<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarsController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| PAGES (обычные страницы)
|--------------------------------------------------------------------------
*/

Route::get('/', [SiteController::class, 'home'])->name('home');
Route::get('/about', [SiteController::class, 'about'])->name('about');
Route::get('/contact', [SiteController::class, 'contact'])->name('contact');
Route::post('/contact', [SiteController::class, 'sendContact'])->name('contact.send');

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard.index');
})->middleware('auth:web')->name('dashboard');

/*
|--------------------------------------------------------------------------
| CARS (module)
|--------------------------------------------------------------------------
*/

Route::get('/cars', [CarsController::class, 'index']);

Route::get('/cars/create', function () {
    return view('cars.create');
})->middleware('auth:web');

Route::get('/cars/show/{id}', [CarsController::class, 'show'])
    ->whereNumber('id');

/*
|--------------------------------------------------------------------------
| FILES (storage access)
|--------------------------------------------------------------------------
*/

Route::get('/files/{path}', function ($path) {
    $path = ltrim($path, '/');

    if (!Storage::disk('public')->exists($path)) {
        abort(404);
    }

    return Storage::disk('public')->response($path);
})->where('path', '.*');
