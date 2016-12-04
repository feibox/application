<?php

namespace App\Policies;

use App\Subject;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SubjectPolicy
{

    use HandlesAuthorization;


    public function before(User $user)
    {
        return ($user->is_admin) ? true : null;
    }


    public function upload(User $user, Subject $subject)
    {
        return $this->browse($user, $subject);
    }


    public function browse(User $user, Subject $subject)
    {
        if ($subject->is_enabled === true && ! is_null($subject->study_year)) {
            return $user->rank >= $subject->study_year;
        }
    }


    public function createFolder(User $user, Subject $subject)
    {
        return $this->browse($user, $subject);
    }
}
