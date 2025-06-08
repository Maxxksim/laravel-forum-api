<?php

namespace App\Http\Controllers;


use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class LikeController extends Controller
{
    public function toLike(Post $post): JsonResponse
    {

        if ($post->isLiked()) {
            return response()->json(['message' => 'Already liked'], Response::HTTP_FORBIDDEN);
        }

        Like::create([
            'user_id' => auth()->id(),
            'post_id' => $post->id,
        ]);

        $post->increment('likes');

        return response()->json(['message' => 'Liked'], Response::HTTP_CREATED);
    }

    public function toUnlike(Post $post): JsonResponse
    {
        if ($post->isLiked()) {

            $post->likes()->where('user_id', auth()->id())->delete();

            $post->decrement('likes');

            return response()->json(['message' => 'Unliked'], Response::HTTP_OK);

        }

        return response()->json(['message' => 'Not liked'], Response::HTTP_NOT_FOUND);
    }
}
