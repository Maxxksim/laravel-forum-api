<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends Controller
{

    public function register(RegisterRequest $request): JsonResponse
    {
        return response()->json(['token' => User::create($request->validated())->createToken('auth_token')->plainTextToken], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        if (!auth()->attempt($request->validated())) {
            return response()->json(['error' => 'Wrong login credentials.'], Response::HTTP_UNAUTHORIZED);
        }

        return response()->json(['token' => auth()->user()->createToken('auth_token')->plainTextToken], Response::HTTP_OK);
    }

}
