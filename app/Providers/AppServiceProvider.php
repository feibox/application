<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Blade::directive('increment', function ($variable) {
            return "<?php {$variable} = (isset({$variable}) ? {$variable}+1 : 1); ?>";
        });
    }


    /**
     * Register any application services.
     */
    public function register()
    {
    }
}
