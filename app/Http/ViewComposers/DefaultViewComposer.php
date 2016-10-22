<?php

namespace App\Http\ViewComposers\Frontend;

use Illuminate\View\View;


class DefaultComposer
{
    protected $user;

    public function __construct()
    {

        $this->user = \Auth::user();
    }


    public function compose(View $view)
    {
        $view->with(['user' => $this->user]);
    }
}