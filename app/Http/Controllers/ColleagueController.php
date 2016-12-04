<?php

namespace App\Http\Controllers;

use App\User;

class ColleagueController extends Controller
{

    public function index()
    {
        $colleagues = request()->user()->colleagues()->sortable([ 'file_count' ])->paginate();

        return view('pages.colleagues')->with('colleagues', $colleagues);
    }

    public function detail(User $user) {
        dd($user);
    }
}
