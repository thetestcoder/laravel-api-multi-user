<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class GlobalHelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->loadHelpers();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function loadHelpers()
    {
        foreach (\glob(__DIR__ . './../Helpers/Global-Helper/*.php') as $filename) {
            require_once $filename;
        }
    }
}
