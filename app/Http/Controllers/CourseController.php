<?php

namespace App\Http\Controllers;

use App\Subject;

class CourseController extends Controller
{

    public function index(Subject $subject, $all = false)
    {
        $user = request()->user();
        $all = ( ! $all) ? false : true;
        $courses = $subject->forUser($user, $all)->with('translations')->sortable('code')->paginate(10);

        return view('pages.courses')->with([ 'courses' => $courses ]);
    }
}
