<?php

namespace App\Providers;

use App\Repositories\CarOptionRepository;
use App\Repositories\CarRepository;
use App\Repositories\Interfaces\CarOptionRepositoryInterface;
use App\Repositories\Interfaces\CarRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
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
