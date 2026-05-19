<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class FileController
{

    public function show($path)
    {
        if (!str_starts_with($path, 'uploads/')) {
            abort(403);
        }

        if (!Storage::disk('public')->exists($path)) {
            abort(404);
        }

        return Storage::disk('public')->response($path);
    }

}
