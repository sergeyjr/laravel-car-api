<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    public function findByLogin(string $login): ?User
    {
        return User::where('login', $login)->first();
    }

    public function save(array $data): User
    {
        if (isset($data['id'])) {
            $user = User::find($data['id']);

            if (!$user) {
                throw new \RuntimeException('User not found');
            }
        } else {
            $user = new User();
        }

        $user->login = $data['login'];
        $user->password = $data['password'] ?? $user->password;

        if (isset($data['auth_token'])) {
            $user->auth_token = $data['auth_token'];
        }

        if (!$user->save()) {
            throw new \RuntimeException('Failed to save user');
        }

        return $user;
    }

    public function saveToken(User $user, string $token): User
    {
        $user->auth_token = $token;

        if (!$user->save()) {
            throw new \RuntimeException('Failed to save token');
        }

        return $user;
    }
}
