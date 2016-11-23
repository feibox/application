<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Http\Requests\StoreFolderRequest;
use App\Subject;
use Krucas\Notification\Facades\Notification;

class FolderController extends Controller
{
    private $subject;
    private $folder;

    public function __construct(Subject $subject, Folder $folder)
    {
        $this->subject = $subject;
        $this->folder = $folder;
    }

    public function index($subject_id, $folder = null)
    {
        if (is_null($folder)) {
            $folder_prefix = '';
            $subject = $this->subject->with('parentFolders')->find($subject_id);
            $current_folder = null;
            $folders = $subject->parentFolders;
        } else {
            $folder_prefix = $folder . '-';
            $folder = $this->getDeepestFolder($folder);
            $subject = $this->subject->find($subject_id);
            $current_folder = $this->folder->subject($subject_id)->name($folder)->with('parentFolder',
                'childFolders')->first();

            if (is_null($current_folder)) {
                abort(404);
            }

            $folders = $current_folder->childFolders;
        }

        return view('pages.folders')->with([
            'current_folder' => $current_folder,
            'folders' => $folders,
            'subject' => $subject,
            'folder_prefix' => $folder_prefix
        ]);
    }

    private function getDeepestFolder($folder)
    {
        if (str_contains($folder, '-')) {
            $folders = explode('-', $folder);
            $folder = end($folders);
        }
        return $folder;
    }

    public function create($subject_id, $folder = null)
    {
        $subject = $this->subject->findOrFail($subject_id);
        if (is_null($folder)) {
            $current_folder = null;
        } else {
            $folder = $this->getDeepestFolder($folder);
            $current_folder = $this->folder->subject($subject_id)->name($folder)->first();

        }

        return view('pages.folder-create')->with(['subject' => $subject, 'current_folder' => $current_folder]);
    }

    public function store(StoreFolderRequest $request, $subject_id)
    {
        $parent_id = $request->get('parent_id', 0);
        $this->folder->create([
            'name' => $request->get('name'),
            'subject_id' => $subject_id,
            'parent_id' => $parent_id
        ]);


        Notification::success('Folder created');
        return redirect()->route('subject.folder', ['subject_id' => $subject_id]);
    }
}
