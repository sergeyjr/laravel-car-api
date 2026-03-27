<?php

namespace Modules\API\V1\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class ApiUser extends Authenticatable
{

    protected $table = 'api_user';

    protected $fillable = [
        'login',
        'password',
        'auth_token',
    ];

    protected $hidden = [
        'password',
    ];

    public function validatePassword(string $password): bool
    {
        return Hash::check($password, $this->password);
    }

}
