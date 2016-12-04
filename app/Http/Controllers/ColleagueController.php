<?php

namespace App\Http\Controllers;

use App\User;

class ColleagueController extends Controller
{

    public function index()
    {
        $colleagues = request()->user()->colleagues()->sortable([ 'file_count' => 'desc' ])->paginate();

        return view('pages.colleagues')->with('colleagues', $colleagues);
    }


    public function detail($id, User $user)
    {
        if (request()->user()->id === (int) $id) {
            return redirect()->route('users.detail');
        }

        $colleague = $user->filesPreview(5)->findOrFail($id);

        $this->authorize('colleague', $colleague);

        return view('pages.colleagues-detail')->with('colleague', $colleague);
    }
}
