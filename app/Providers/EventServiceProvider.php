<?php

namespace App\Providers;

use App\Observers\SubjectObserver;
use App\Subject;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        //'App\Events\SomeEvent' => [
        //    'App\Listeners\EventListener',
        //],
    ];


    /**
     * Register any events for your application.
     */
    public function boot()
    {
        parent::boot();
        Subject::observe(SubjectObserver::class);
    }
}
