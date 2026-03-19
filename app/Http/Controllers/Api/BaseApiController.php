<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;

class BaseApiController extends Controller
{
    protected function success($data = null, int $code = 200)
    {
        return ApiResponse::success($data, $code);
    }

    protected function error($errors, int $code = 400)
    {
        return ApiResponse::error($errors, $code);
    }
}
