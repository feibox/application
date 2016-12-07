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

        $recents['colleagues'] = $user->colleagues()->limit(5)->orderBy('updated_at', 'desc')->get();
        $counts['colleagues'] = $user->colleagues()->count();

        $recents['courses'] = $subject->forUser($user)->with('translations')->limit(5)->orderBy('updated_at')->get();
        $counts['courses'] = $subject->forUser($user)->count();

        $recents['files'] = $file->with([
            'user'           => function ($query) {
                $query->select([ 'id', 'user_name' ]);
            },
            'folder.subject' => function ($query) use ($user) {
                $query->whereIsEnabled(true)->whereNotNull('study_year')->where('study_year', '<=', $user->rank);
            }
        ])->orderBy('updated_at', 'desc')->get()->filter(function ($value) {
            return ! is_null($value['relations']['folder']['relations']['subject']);
        });

        $counts['files'] = $recents['files']->count();

        $popular_files = $file->with([
            'user' => function ($query) {
                $query->select([ 'id', 'user_name' ]);
            },
            'folder.subject' => function ($query) use ($user)
    {
        $query->whereIsEnabled(true)->whereNotNull('study_year')->where('study_year', '<=', $user->rank);
    }
        ])->orderBy('downloaded', 'desc')->orderBy('updated_at')->limit(5)->get()->filter(function ($value) {
        return ! is_null($value['relations']['folder']['relations']['subject']);
    });

        $user_files = $file->with([
            'user' => function ($query) {
                $query->select([ 'id', 'user_name' ]);
            }
        ])->whereUploadedBy($user->id)->orderBy('downloaded', 'desc')->orderBy('updated_at', 'desc')->limit(5)->get();

        return view('pages.dashboard')->with([
            'recents'       => $recents,
            'counts'        => $counts,
            'popular_files' => $popular_files,
            'user_files'    => $user_files
        ]);
    }
}
