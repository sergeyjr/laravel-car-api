<?php

namespace App\Providers;

use App\API\V1\Repositories\CarOptionRepository;
use App\API\V1\Repositories\CarRepository;
use App\API\V1\Repositories\Interfaces\CarOptionRepositoryInterface;
use App\API\V1\Repositories\Interfaces\CarRepositoryInterface;
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
        $this->app->bind(CarRepositoryInterface::class, CarRepository::class);
        $this->app->bind(CarOptionRepositoryInterface::class, CarOptionRepository::class);
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
