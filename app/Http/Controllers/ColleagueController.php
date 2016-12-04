<?php

namespace App\Http\Controllers;

class ColleagueController extends Controller
{

    public function index()
    {
        $colleagues = request()->user()->colleagues()->sortable([ 'file_count' ])->paginate();

        return view('pages.colleagues')->with('colleagues', $colleagues);
    }
}
