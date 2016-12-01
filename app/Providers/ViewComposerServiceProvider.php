<?php

namespace App\Providers;

use App\Http\ViewComposers\DefaultViewComposer;
use Illuminate\Support\ServiceProvider;
use View;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        View::composers([
            DefaultViewComposer::class => ['pages.*', 'auth.password'],
        ]);
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
