<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\BaseApiController;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends BaseApiController
{

    private AuthService $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    public function login(Request $request)
    {
        $data = $request->all();

        if (empty($data['login']) || empty($data['password'])) {
            return $this->error('login and password required', 400);
        }

        $token = $this->service->login(
            $data['login'],
            $data['password']
        );

        return $this->success([
            'token' => $token
        ]);
    }

}
