<?php

namespace Modules\API\V1\Mappers;

use Modules\API\V1\Models\ApiUser;

class UserMapper
{
    public function toModel(array $data, ?ApiUser $user = null): ApiUser
    {
        $user = $user ?? new ApiUser();

        $user->login = $data['login'] ?? $user->login;
        $user->password = $data['password'] ?? $user->password;
        $user->auth_token = $data['auth_token'] ?? $user->auth_token;

        return $user;
    }

    public function toArray(ApiUser $user): array
    {
        return [
            'id' => $user->id,
            'login' => $user->login,
            'auth_token' => $user->auth_token,
        ];
    }
}
