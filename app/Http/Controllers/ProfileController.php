<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{

    /**
     * Update profile (name, email, avatar)
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name'   => ['required', 'string', 'max:255'],
            'email'  => ['required', 'email', 'max:255'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        // update basic fields
        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // avatar upload
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save();

        return back()->with('success', 'Профиль обновлён');
    }

    /**
     * Change password
     */
    public function password(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = Auth::user();

        // check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Текущий пароль неверный');
        }

        // update password
        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Пароль успешно изменён');
    }

    /**
     * Delete account
     */
    public function destroy(Request $request)
    {
        $user = Auth::user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Аккаунт удалён');
    }

}
