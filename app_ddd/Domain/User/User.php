<?php

namespace App\Domain\User;

class User
{

    public function __construct(
        public ?int $id,
        public string $name,
        public string $email,
        public string $role,
    ) {}

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isApiUser(): bool
    {
        return $this->role === 'api';
    }

    public function isUser(): bool
    {
        return $this->role === 'user';
    }

}
