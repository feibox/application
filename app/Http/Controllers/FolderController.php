<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Subject;

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
}
