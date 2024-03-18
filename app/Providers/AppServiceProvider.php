<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Colaborador;
use App\Observers\ColaboradorObserver;

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
        Colaborador::observe(ColaboradorObserver::class);
    }
}
