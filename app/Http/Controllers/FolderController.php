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
            $subject = $this->subject->with('rootFolders.user')->findOrFail($subject_id);
            $current_folder = null;
            $folders = $subject->rootFolders;
        } else {
            $folder_prefix = $folder.'-';
            $folders_array = $this->getFoldersArray($folder);
            $parent_id = $this->getParentFolderId($folders_array, $subject_id);
            $folder = end($folders_array);
            $subject = $this->subject->findOrFail($subject_id);
            $current_folder = $this->folder->whereSubjectId($subject_id)->whereParentId($parent_id)->whereName($folder)->with('parentFolder',
                'childFolders.user', 'files.user')->first();
            if (is_null($current_folder)) {
                abort(404);
            }

            $folders = $current_folder->childFolders;
        }

        return view('pages.folders')->with([
            'current_folder' => $current_folder,
            'folders' => $folders,
            'subject' => $subject,
            'folder_prefix' => $folder_prefix,
        ]);
    }

    private function getFoldersArray($folder)
    {
        if (str_contains($folder, '-')) {
            return explode('-', $folder);
        }

        return [$folder];
    }

    private function getParentFolderId(array $folder_array, $subject_id)
    {
        if (count($folder_array) > 1) {
            array_pop($folder_array);
            $parent_name = end($folder_array);
            $parent_id = $this->getParentFolderId($folder_array, $subject_id);

            return $this->folder->whereSubjectId($subject_id)->whereName($parent_name)->whereParentId($parent_id)->select(['id'])->firstOrFail()->id;
        }

        return null;
    }

    public function create($subject_id, $folder = null)
    {
        $subject = $this->subject->findOrFail($subject_id);
        $current_folder = null;
        if (!is_null($folder)) {
            $folders_array = $this->getFoldersArray($folder);
            $parent_id = $this->getParentFolderId($folders_array);
            $folder = end($folders_array);
            $current_folder = $this->folder->whereSubjectId($subject_id)->whereParentId($parent_id)->whereName($folder)->first();
        }

        return view('pages.folder-create')->with(['subject' => $subject, 'current_folder' => $current_folder]);
    }

    public function store(StoreFolderRequest $request, $subject_id)
    {
        $parent_id = $request->get('parent_id', null);
        $this->folder->create([
            'name' => $request->get('name'),
            'subject_id' => $subject_id,
            'parent_id' => $parent_id,
            'created_by' => $request->user()->id,
        ]);

        Notification::success('Folder created.');

        return redirect()->back();
    }

    //public function destroy($folder_id)
    //{
    //    $folder = $this->folder->findOrFail($folder_id);
    //    $this->authorize($folder);

    //    if ($folder->isEmpty()) {
    //        $folder->delete();
    //        Notification::success('Folder deleted.');
    //    }

    //    return redirect()->back();
    //}
}
