<?php

namespace Modules\API\V1\Http\Controllers;

use Illuminate\Http\Request;
use Modules\API\V1\Services\AuthService;

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
