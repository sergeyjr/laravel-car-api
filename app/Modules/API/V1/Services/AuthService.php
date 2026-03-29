<?php

namespace Modules\API\V1\Services;

use Illuminate\Support\Str;
use Modules\API\V1\Exceptions\ServiceException;
use Modules\API\V1\Repositories\ApiUserRepository;

class AuthService
{

    private ApiUserRepository $users;

    public function __construct(ApiUserRepository $users)
    {
        $this->users = $users;
    }

    public function login(string $login, string $password): string
    {
        $user = $this->users->findByLogin($login);

        if (!$user || !$user->validatePassword($password)) {
            throw new ServiceException('Invalid login or password');
        }

        $token = Str::random(64);

        $this->users->saveToken($user, $token);

        return $token;
    }

    public function check(string $token): bool
    {
        return $this->users->findByToken($token) !== null;
    }

}
