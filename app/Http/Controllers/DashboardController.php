<?php

namespace App\Http\Controllers;

use App\File;
use App\Subject;

class DashboardController extends Controller
{

    public function index(Subject $subject, File $file)
    {
        $user = request()->user();
        $counts = $recents = [];

        $recents['colleagues'] = $user->colleagues()->limit(5)->orderBy('updated_at')->get();
        $counts['colleagues'] = $user->colleagues()->count();

        $recents['courses'] = $subject->forUser($user)->with('translations')->limit(5)->orderBy('updated_at')->get();
        $counts['courses'] = $subject->forUser($user)->count();

        $recents['files'] = $file->with([
            'folder.subject' => function ($query) use ($user) {
                $query->whereIsEnabled(true)->whereNotNull('study_year')->where('study_year', '<=', $user->rank);
            }
        ])->orderBy('updated_at')->get()->filter(function ($value, $key) {
            return ! is_null($value['relations']['folder']['relations']['subject']);
        });

        $counts['files'] = $recents['files']->count();

        return view('pages.dashboard')->with([ 'recents' => $recents, 'counts' => $counts ]);
    }
}
