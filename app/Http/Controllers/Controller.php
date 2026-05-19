<?php

namespace App\Http\Controllers;

use App\API\V1\DTO\Request\PaginationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class Controller
{

    protected function success($data = null, int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'errors' => null
        ], $code, [], JSON_UNESCAPED_UNICODE);
    }

    protected function error($errors, int $code = 400): JsonResponse
    {
        return response()->json([
            'success' => false,
            'data' => null,
            'errors' => $errors
        ], $code, [], JSON_UNESCAPED_UNICODE);
    }

    protected function user()
    {
        return auth()->user();
    }

    protected function requireApiUser()
    {
        $user = auth()->user();

        if (!$user || !$user->isApiUser()) {
            abort(403);
        }

        return $user;
    }

    protected function pagination(Request $request, int $size = 10)
    {
        return new PaginationRequest([
            'page' => $request->query('page', 1),
            'perPage' => $size,
            'sort' => $request->query('sort', '-id'),
        ]);
    }

}
