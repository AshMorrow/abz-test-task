<?php

namespace App\Providers;

use App\Employees;
use App\Observers\EmployeeObserver;
use App\Observers\PositionObserver;
use App\Position;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Employees::observe(EmployeeObserver::class);
        Position::observe(PositionObserver::class);
    }
}
