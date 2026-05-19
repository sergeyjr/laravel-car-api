<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\User\User as DomainUser;
use App\Http\Controllers\Web\Controller;
use App\Infrastructure\Persistence\Mappers\UserMapper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiAuthController extends Controller
{

    public function login(Request $request, UserMapper $mapper)
    {

        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        /** @var \App\Models\User $user */
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return $this->error('Неверные учетные данные', 401);
        }

        /** @var DomainUser $domainUser */
        $domainUser = $mapper->toDomain($user);

        if (!$domainUser->isAdmin() && !$domainUser->isApiUser()) {
            return $this->error('Запрещено: нет доступа к API', 403);
        }

        $user->tokens()->where('name', 'api_token')->delete();

        $token = $user->createToken('api_token')->plainTextToken;

        return $this->success([
            'token' => $token,
            'message' => 'Успешный вход.',
        ]);

    }

}
