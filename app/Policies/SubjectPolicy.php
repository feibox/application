<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubjectPolicy
{
    use HandlesAuthorization;

    public function before(User $user)
    {
        return ($user->is_admin) ? true : false;
    }
}
