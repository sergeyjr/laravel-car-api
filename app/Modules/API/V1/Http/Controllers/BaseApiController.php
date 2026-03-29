<?php

namespace Modules\API\V1\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\API\V1\Helpers\ApiResponse;

abstract class BaseApiController extends Controller
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
