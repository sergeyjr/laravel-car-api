<?php

namespace Modules\API\V1\Repositories\Interfaces;

use Modules\API\V1\Models\ApiUser;

interface ApiUserRepositoryInterface
{

    public function findByLogin(string $login): ?ApiUser;

    public function save(array $data): ApiUser;

    public function saveToken(ApiUser $user, string $token): ApiUser;

    public function findByToken(string $token): ?ApiUser;

}
