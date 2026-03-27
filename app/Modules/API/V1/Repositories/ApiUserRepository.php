<?php

namespace Modules\API\V1\Repositories;

use Modules\API\V1\Models\ApiUser;
use Modules\API\V1\Repositories\Interfaces\ApiUserRepositoryInterface;

class ApiUserRepository implements ApiUserRepositoryInterface
{

    public function findByLogin(string $login): ?ApiUser
    {
        return ApiUser::where('login', $login)->first();
    }

    public function save(array $data): ApiUser
    {
        if (isset($data['id'])) {
            $user = ApiUser::find($data['id']);

            if (!$user) {
                throw new \RuntimeException('ApiUser not found');
            }
        } else {
            $user = new ApiUser();
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

    public function saveToken(ApiUser $user, string $token): ApiUser
    {
        $user->auth_token = $token;

        if (!$user->save()) {
            throw new \RuntimeException('Failed to save token');
        }

        return $user;
    }

    public function findByToken(string $token): ?ApiUser
    {
        return ApiUser::where('auth_token', $token)->first();
    }

}
