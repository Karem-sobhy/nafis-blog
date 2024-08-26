<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $posts = Post::with(['user:id,name'])
            ->with('media')
            ->withCount('comments')
            ->with(['comments' => fn ($q) => $q->latest('id')->limit(1)])
            ->orderBy('updated_at', in_array($request->input('sort'), ['asc', 'desc']) ? $request->input('sort') : 'desc')
            ->paginate();

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        do {
            $slug = Str::slug($request->title).'-'.Str::lower(Str::random(5));
        } while (Post::where('slug', $slug)->exists());

        $post = Auth::user()
            ->posts()
            ->create(array_merge($request->validated(), ['slug' => $slug]));

        if ($request->hasFile('image')) {
            $post->addMediaFromRequest('image')
                ->sanitizingFileName(fn ($fileName) => Str::uuid7().'.'.Str::afterLast($fileName, '.'))
                ->toMediaCollection('header');
        }

        return PostResource::make($post);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        $post->load(['user:id,name', 'comments', 'comments.user:id,name', 'media']);

        return PostResource::make($post);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update(array_merge($request->validated()));

        $request->whenHas('image', function ($image) use ($post) {
            $image
            ? $post->addMedia($image)
                ->sanitizingFileName(fn ($fileName) => Str::uuid7().'.'.Str::afterLast($fileName, '.'))
                ->toMediaCollection('header')
            : $post->clearMediaCollection('header');
        });

        return PostResource::make($post);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Gate::authorize('delete', $post);

        $post->delete();

        return response()->json('Post deleted successfully');
    }
}
