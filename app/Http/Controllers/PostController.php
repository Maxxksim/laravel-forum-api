<?php

namespace App\Http\Controllers;


use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class PostController extends Controller
{


    public function index(Request $request): JsonResponse
    {

        $validated = $request->validate([
            'user_id' => ['integer', 'exists:users,id']
        ]);

        if (isset($validated['user_id'])) {

            return response()->json(User::find($validated['user_id'])->posts()->paginate(10)->toResourceCollection(), Response::HTTP_OK);
        }

        return response()->json(Post::paginate(10)->toResourceCollection(), Response::HTTP_OK);

    }


    public function store(StorePostRequest $request): JsonResponse
    {

        $name_image = Post::generateNameImage($request->file('image')->getClientOriginalExtension());

        Post::create([
            'name_image' => $name_image,
            'title' => $request->validated()['title'],
            'user_id' => auth()->id(),
            'text' => $request->validated()['text'],
            'author_first_name' => auth()->user()->first_name,
            'author_last_name' => auth()->user()->last_name,
        ]);

        $request->file('image')->storePubliclyAs('post_images/', $name_image, 'public');

        return response()->json(['message' => 'Post was created successfully.'], Response::HTTP_CREATED);

    }

    public function show(int $id): JsonResponse
    {
        if ($post = Post::where('id', $id)->first()) {
            return response()->json($post->toResource(), Response::HTTP_OK);
        }

        return response()->json(['message' => 'Post not found'], Response::HTTP_NOT_FOUND);
    }

    public function update(UpdatePostRequest $request, Post $post): Response
    {

        if (auth()->user()->cannot('update', $post)) {
            return response(['message' => 'You can update only your own post.'], Response::HTTP_FORBIDDEN);
        }

        $post->update($request->validated());

        return response()->json(['message' => 'Post was updated successfully.'], Response::HTTP_OK);
    }

    public function destroy(Post $post): JsonResponse
    {

        if (auth()->user()->cannot('delete', $post)) {
            return response()->json(['message' => 'You can delete only your own post.'], Response::HTTP_FORBIDDEN);
        }

        $post->delete();

        return response()->json('Post was deleted successfully.', Response::HTTP_OK);
    }
}
