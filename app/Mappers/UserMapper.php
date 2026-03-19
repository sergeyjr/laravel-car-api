<?php

namespace App\Mappers;

use App\Models\User;

class UserMapper
{
    public function toModel(array $data, ?User $user = null): User
    {
        $user = $user ?? new User();

        $user->login = $data['login'] ?? $user->login;
        $user->password = $data['password'] ?? $user->password;
        $user->auth_token = $data['auth_token'] ?? $user->auth_token;

        return $user;
    }

    public function toArray(User $user): array
    {
        return [
            'id' => $user->id,
            'login' => $user->login,
            'auth_token' => $user->auth_token,
        ];
    }
}
