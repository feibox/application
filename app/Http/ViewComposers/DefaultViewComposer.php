<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class DefaultViewComposer
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
