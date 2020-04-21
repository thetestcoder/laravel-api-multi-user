<?php

namespace App\Providers;

use App\Helpers\Macros\UserDetails;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class UserFacadeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        App::bind('user', function () {
            return new UserDetails;
        });
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
}
