<?php

namespace App\Policies;

use App\File;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FilePolicy
{

    use HandlesAuthorization;


    public function before(User $user)
    {
        return ($user->is_admin) ? true : false;
    }


    public function upload(User $user)
    {
        $folder = resolve(\App\Folder::class)->with('subject')->findOrFail(request()->get('folder_id'));
        return $user->can('upload', $folder->subject);
    }


    public function delete(User $user, File $file)
    {
        return $this->destroy($user, $file);
    }


    public function destroy(User $user, File $file)
    {
        return $file->uploaded_by === $user->id;
    }
}
