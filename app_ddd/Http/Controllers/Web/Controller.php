<?php

namespace App\Http\Controllers\Web;

use App\Domain\Shared\Pagination;
use App\Infrastructure\Persistence\Mappers\UserMapper;
use Illuminate\Http\Request;

abstract class Controller
{

    protected function success($data = null, int $code = 200)
    {
        return response()->json([
            'success' => true,
            'data' => $data,
            'errors' => null
        ], $code, [], JSON_UNESCAPED_UNICODE);
    }

    protected function error($errors, int $code = 400)
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

        $domainUser = app(UserMapper::class)->toDomain($user);

        if (!$domainUser->isApiUser()) {
            abort(403);
        }

        return $user;
    }

    protected function pagination(Request $request, int $size = 10): Pagination
    {
        return new Pagination(
            page: (int) $request->query('page', 1),
            perPage: $size,
            sort: $request->query('sort', '-id'),
        );
    }

    protected function logException(\Throwable $e)
    {
        \Log::error($e->getMessage(), [
            'trace' => $e->getTraceAsString()
        ]);
    }

}
