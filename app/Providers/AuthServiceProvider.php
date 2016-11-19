<?php

namespace App\Providers;

use App\Policies\SubjectPolicy;
use App\Policies\UserPolicy;
use App\Subject;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //'App\Model' => 'App\Policies\ModelPolicy',
        User::class => UserPolicy::class,
        Subject::class => SubjectPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        \Validator::extend('current_password', function ($attribute, $value, $parameters) {
            return \Hash::check($value, \Auth::user()->getAuthPassword());
        }, 'Current password is incorrect.');
    }
}
