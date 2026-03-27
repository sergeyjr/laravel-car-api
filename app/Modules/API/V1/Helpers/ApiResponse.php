<?php

namespace Modules\API\V1\Helpers;

class ApiResponse
{

    public static function success($data = null, int $code = 200)
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'errors' => null
        ], $code);
    }

    public static function error($errors, int $code = 400)
    {
        return response()->json([
            'success' => false,
            'data' => null,
            'errors' => $errors
        ], $code);
    }

}
