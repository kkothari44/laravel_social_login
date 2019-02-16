<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\App;
use App\Providers\Contracts\LoginFacebookContract;

class LoginFacebookProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        
        
         App::bind(LoginFacebookContract::class, function() {
            return new Containers\LoginFacebookContainer();
        });
    }
}
