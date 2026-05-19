<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function me(Request $request): JsonResponse
    {

        $user = $request->user();

        return response()->json(
            ['user' => $user]
        );

    }

    public function register(Request $request): JsonResponse
    {

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        // $token = $user->createToken('web_session_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            // 'token' => $token,
            'message' => 'Регистрация успешно завершена! Теперь вы можете войти.',
            // 'redirect' => '/dashboard',
        ]);

    }

    public function login(Request $request): JsonResponse
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(
                ['message' => 'Имя пользователя и пароль не совпадают.'],
                422
            );
        }

        $user = auth()->user();

        $request->session()->regenerate();

        $user->tokens()->where('name', 'web_session_token')->delete();

        $token = $user->createToken('web_session_token')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
            'message' => 'Успешный вход.',
        ]);

    }

    public function logout(Request $request): JsonResponse
    {

        $user = auth()->user();

        $user?->tokens()->where('name', 'web_session_token')->delete();

        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Выход из системы.']);

    }

}
