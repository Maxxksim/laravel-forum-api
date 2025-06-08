<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        if (auth()->user()->cannot('update', $user)) {
            return response()->json(['message' => 'You can update only your own account.'], 403);
        }

        $user->update(
            [...$request->validated(),
                isset($request->validated()['password']) ? ['password' => Hash::make($request->validated()['password'])] : null
            ]);

        return response()->json(['message' => 'User was updated successfully.'], Response::HTTP_OK);

    }

    public function show(int $id): JsonResponse
    {

        if ($user = User::where('id', $id)->first()) {
            return response()->json($user->toResource(), Response::HTTP_OK);
        }
        return response()->json(['message' => 'User not found.'], 404);

    }

    public function destroy(User $user): JsonResponse
    {
        if (auth()->user()->cannot('delete', $user)) {
            return response()->json(['message' => 'You can delete only your own account.'], 403);
        }

        $user->delete();

        return response()->json(['message' => 'User\'s account was deleted successfully.'], Response::HTTP_OK);
    }
}
