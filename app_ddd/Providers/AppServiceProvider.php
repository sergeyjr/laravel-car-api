<?php

namespace App\Providers;

use App\Domain\Car\Repositories\CarOptionRepositoryInterface;
use App\Domain\Car\Repositories\CarRepositoryInterface;
use App\Infrastructure\Persistence\Repositories\EloquentCarOptionRepository;
use App\Infrastructure\Persistence\Repositories\EloquentCarRepository;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CarRepositoryInterface::class, EloquentCarRepository::class);
        $this->app->bind(CarOptionRepositoryInterface::class, EloquentCarOptionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        RateLimiter::for('contact_form', function (Request $request) {
            return Limit::perMinutes(10, 1)->by($request->ip());
        });
    }

}
