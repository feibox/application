<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class ValidatorServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        Validator::extend('stuba_email', 'App\Validators\StubaEmailValidator@validate');
    }


    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
