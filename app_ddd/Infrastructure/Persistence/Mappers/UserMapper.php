<?php

namespace App\Infrastructure\Persistence\Mappers;

use App\Domain\User\User as DomainUser;
use App\Models\User as EloquentUser;

class UserMapper
{

    public function toDomain(EloquentUser $model): DomainUser
    {
        return new DomainUser(
            id: $model->id,
            name: $model->name,
            email: $model->email,
            role: $model->role,
        );
    }

}
