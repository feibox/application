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

    public function destroy(User $user, File $file)
    {
        return $file->uploaded_by === $user->id;
    }

    public function delete(User $user, File $file)
    {
        return $this->destroy($user, $file);
    }
}
