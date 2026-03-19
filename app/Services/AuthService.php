<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Str;

class AuthService
{
    private UserRepository $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function login(string $login, string $password): string
    {
        $user = $this->users->findByLogin($login);

        if (!$user || !$user->validatePassword($password)) {
            throw new \RuntimeException('Invalid login or password');
        }

        $token = Str::random(64);

        $this->users->saveToken($user, $token);

        return $token;
    }
}
