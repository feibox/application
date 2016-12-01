<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Subject;
use Illuminate\Http\Request;
use Krucas\Notification\Facades\Notification;

class SubjectsController extends Controller
{

    /**
     * @var Subject
     */
    private $subject;


    public function __construct(Subject $subject)
    {
        $this->subject = $subject;
    }


    public function index()
    {
        $this->authorize($this->subject);
        $subjects = $this->subject->with('translations')->sortable('code')->paginate(10);

        return view('pages.subjects')->with([ 'subjects' => $subjects ]);
    }


    public function enable($id)
    {
        $subject = $this->subject->findOrFail($id);

        if ($subject->is_valid && ! is_null($subject->study_year)) {
            $subject->is_enabled = true;
            $subject->save();
            Notification::success('Subject '.$subject->code.' was enabled.');
        } else {
            Notification::error('Subject without study year or not valid can not be set as "enabled".');
        }

        return redirect()->back();
    }


    public function disable($id)
    {
        $subject = $this->subject->findOrFail($id);

        if ($subject->is_enabled) {
            $subject->is_enabled = false;
            $subject->save();
            Notification::success('Subject '.$subject->code.' was disabled.');
        } else {
            Notification::warning('Subject can not be disabled more than once :)');
        }

        return redirect()->back();
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }
}
