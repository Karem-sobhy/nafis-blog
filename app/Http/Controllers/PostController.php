<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return Post::where('user_id',Auth::id())->get();
        return Auth::user()->posts;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
    //     $user = Auth::user();
    //     $userPosts = $user->posts();
    //     $userPosts->create($request->validated());

       $post = Auth::user()->posts()->create($request->validated());
       $post->load('user:id,name');
       return $post;
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        if($post->user_id != Auth::id()){
            abort(403, 'You are not authorized to view this post');
        }

        return $post->load('user:id,name');
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
        $post->delete();
        return response()->json('Post deleted successfully');
    }
}
