<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Post::with(['user:id,name'])->latest('id')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        do {
            $slug = Str::slug($request->title).'-'.Str::lower(Str::random(5));
        } while (Post::where('slug', $slug)->exists());

        return Auth::user()
            ->posts()
            ->create(array_merge($request->validated(), ['slug' => $slug]));
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return $post->load(['user:id,name','comments:id,post_id,user_id,content','comments.user:id,name']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        $post->update($request->validated());
        return $post;
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
