<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function findByLogin(string $login): ?User;

    public function save(array $data): User;

    public function saveToken(User $user, string $token): User;
}
