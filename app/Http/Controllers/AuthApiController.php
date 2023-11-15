<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class AuthApiController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'phone' => ['required', 'digits:10', 'numeric', 'unique:' . User::class],
            'email' => ['required', 'email', 'lowercase', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Password::defaults()]
        ]);

        $user = User::create($data);

        return response()->json([
            'statusText' => 'Registered Successfully',
            'data' => [
                'user' => $user,
                'token' => $user->createToken('API TOKEN')->plainTextToken
            ],
        ], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email', 'lowercase'],
            'password' => ['required']
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'statusText' => 'The provided credentials do not match our records.'
            ], 400);
        }

        $user = User::where('email', $request->email)->first();

        return response()->json([
            'statusText' => 'Logged in successfully',
            'data' => $user,
            'token' => $user->createToken('API TOKEN')->plainTextToken
        ]);
    }

    public function logout(): JsonResponse
    {
        if (is_null(Auth::user())) {
            return response()->json([
                'statusText' => 'There\'s no current session'
            ], 400);
        }

        Auth::user()->tokens()->delete();

        return response()->json([
            'statusText' => 'Logged out successfully'
        ]);
    }
}
