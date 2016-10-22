<?php

namespace App\Providers;

use App\Http\ViewComposers\DefaultViewComposer;
use Illuminate\Support\ServiceProvider;
use View;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composers([
            DefaultViewComposer::class => 'pages.*',
        ]);
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
