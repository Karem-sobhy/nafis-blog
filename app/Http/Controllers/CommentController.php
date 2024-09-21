<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $comments = Auth::user()
            ->comments()
            ->onlyParents()
            ->when($request->filled('search'), fn ($q) => $q->where('content', 'LIKE', "%{$request->input('search')}%"))
            ->orderBy('updated_at', in_array($request->input('sort'), ['asc', 'desc']) ? $request->input('sort') : 'desc')
            ->with([
                'children',
                'post' => fn ($q) => $q
                    ->with(['user:id,name', 'latestComment.user', 'media'])
                    ->withExists(['likes' => fn ($q) => $q->where('user_id', Auth::id())])
                    ->withCount(['comments', 'likes']),
            ])
            ->paginate();

        return CommentResource::collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request, Post $post)
    {
        $comment = $post->comments()->create([
            'user_id' => Auth::id(),
            'content' => $request->input('content'),
            'parent_id' => $request->input('parent_id'),
        ]);

        return CommentResource::make($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, Post $post, Comment $comment)
    {
        $comment->update([
            'content' => $request->input('content'),
        ]);

        return CommentResource::make($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post, Comment $comment)
    {
        Gate::authorize('delete', $comment);

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
