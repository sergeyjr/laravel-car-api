<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\API\V1\Repositories\ApiUserRepository;
use Modules\API\V1\Repositories\CarOptionRepository;
use Modules\API\V1\Repositories\CarRepository;
use Modules\API\V1\Repositories\Interfaces\ApiUserRepositoryInterface;
use Modules\API\V1\Repositories\Interfaces\CarOptionRepositoryInterface;
use Modules\API\V1\Repositories\Interfaces\CarRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ApiUserRepositoryInterface::class, ApiUserRepository::class);
        $this->app->bind(CarRepositoryInterface::class, CarRepository::class);
        $this->app->bind(CarOptionRepositoryInterface::class, CarOptionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

}
