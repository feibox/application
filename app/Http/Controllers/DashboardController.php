<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class DashboardController extends Controller
{
    public function index()
    {
        $user = \Auth::user();
        return view('pages.dashboard');
    }
}
