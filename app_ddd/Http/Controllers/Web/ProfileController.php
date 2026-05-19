<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{

    /**
     * Обновление профиля (имя, email, аватар)
     */
    public function update(Request $request): JsonResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:65536'],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        $user->save();

        return response()->json([
            'message' => 'Профиль успешно обновлён',
        ]);
    }

    /**
     * Смена пароля
     */
    public function password(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ]);

        $user = $request->user();

        if (!Hash::check($validated['current_password'], $user->password)) {
            return response()->json([
                'message' => 'Текущий пароль неверный',
                'errors' => [
                    'current_password' => ['Текущий пароль неверный']
                ],
            ], 422);
        }

        if (Hash::check($validated['password'], $user->password)) {
            return response()->json([
                'message' => 'Новый пароль не может совпадать со старым.',
                'errors' => [
                    'password' => ['Новый пароль не может совпадать со старым.']
                ],
            ], 422);
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        return response()->json([
            'message' => 'Пароль успешно изменён',
        ]);
    }

    /**
     * Удаление аккаунта
     */
    public function destroy(Request $request): JsonResponse
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Требуется авторизация.',
            ], 401);
        }

        $user->tokens()->delete();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Аккаунт успешно удалён.',
            'redirect' => '/',
        ]);
    }

}
