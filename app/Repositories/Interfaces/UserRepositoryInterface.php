<?php

namespace App\Repositories\Interfaces;

use App\Models\ApiUser;

interface UserRepositoryInterface
{

    public function findByLogin(string $login): ?ApiUser;

    public function save(array $data): ApiUser;

    public function saveToken(ApiUser $user, string $token): ApiUser;

    public function findByToken(string $token): ?ApiUser;

}
