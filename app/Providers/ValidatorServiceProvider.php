<?php

namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('stuba_email', 'App\Validators\StubaEmailValidator@validate');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
