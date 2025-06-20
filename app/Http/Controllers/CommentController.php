<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'post_id' => ['required', 'integer', 'exists:posts,id'],
        ]);

        return response()->json(Post::find($validated['post_id'])->comments()->get()->toResourceCollection()->sortBy('created_at'), Response::HTTP_OK);
    }

    public function store(StoreCommentRequest $request): JsonResponse
    {
        Comment::create([
            'comment' => $request->validated()['comment'],
            'post_id' => $request->validated()['post_id'],
            'user_id' => auth()->id(),
            'author_first_name' => auth()->user()->first_name,
            'author_last_name' => auth()->user()->last_name,
        ]);

        return response()->json(['message' => 'Comment was created successfully.'], Response::HTTP_CREATED);
    }

    public function update(UpdateCommentRequest $request, Comment $comment): JsonResponse
    {
        if (auth()->user()->cannot('update', $comment)) {
            return response()->json(['message' => 'You can update only your own comment.'], Response::HTTP_FORBIDDEN);
        }

        $comment->update($request->validated());

        return response()->json(['message' => 'Comment was updated successfully.'], Response::HTTP_OK);
    }

    public function destroy(Comment $comment): JsonResponse
    {
        if (auth()->user()->cannot('delete', $comment)) {
            return response()->json(['message' => 'You can delete only your own comment.'], Response::HTTP_FORBIDDEN);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment was deleted successfully.'], Response::HTTP_OK);
    }
}
