<?php

namespace App\Http\Controllers;


use App\Models\Post;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;


class PostController extends Controller
{


    public function index(Request $request): Response
    {

        $validated = $request->validate([
            'user_id' => ['integer', 'exists:users,id']
        ]);

        if (isset($validated['user_id'])) {

            return response(User::find($validated['user_id'])->posts()->paginate(10)->toResourceCollection(), Response::HTTP_OK);
        }

        return response(Post::paginate(10)->toResourceCollection(), Response::HTTP_OK);

    }


    public function store(StorePostRequest $request)
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

        return response(['message' => 'Post was created successfully.'], Response::HTTP_CREATED);

    }

    public function show(Post $post)
    {
        return response($post->toResource(), Response::HTTP_OK);
    }

    public function update(UpdatePostRequest $request, Post $post)
    {

        if (auth()->user()->cannot('update', $post)) {
            return response(['message' => 'You can update only your own post.'], Response::HTTP_FORBIDDEN);
        }

        $post->update($request->validated());

        return response(['message' => 'Post was updated successfully.'], Response::HTTP_OK);
    }

    public function destroy(Post $post)
    {

        if (auth()->user()->cannot('delete', $post)) {
            return response(['message' => 'You can delete only your own post.'], Response::HTTP_FORBIDDEN);
        }

        $post->delete();

        return response('Post was deleted successfully.', Response::HTTP_OK);
    }
}
