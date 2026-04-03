<?php

namespace Modules\API\V1\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ApiAuthController extends BaseApiController
{

    public function login(Request $request)
    {

        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        /** @var \App\Models\User $user */
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return $this->error('Invalid credentials', 401);
        }

        if ($user->isUser()) {
            return $this->error('Forbidden: no API access', 403);
        }

//        $token = $user->tokens()->first();
//        if (!$token) {
//            $token = $user->createToken('api')->plainTextToken;
//        }

        $apiToken = $user->createToken('api');

        return $this->success([
            'api_token' => $apiToken->plainTextToken
        ]);

    }

}
