<?php

namespace App\Policies;

use App\Folder;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FolderPolicy
{

    use HandlesAuthorization;


    public function destroy(User $user, Folder $folder)
    {
        if ($folder->created_by === system_account()->id) {
            return false;
        } elseif ($user->is_admin) {
            return true;
        } else {
            return $user->id === $folder->created_by;
        }
    }
}
