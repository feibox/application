<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{

    use HandlesAuthorization;


    public function before(User $user, $ability)
    {
        if (($ability == 'ban' || $ability == 'removeBan')) {
            if ( ! $user->is_admin) {
                return false;
            }

            return;
        }

        return ($user->is_admin) ? true : null;
    }


    public function ban(User $current_user, User $user)
    {
        return $current_user->id !== $user->id;
    }


    public function removeBan(User $current_user, User $user)
    {
        return $current_user->id !== $user->id;
    }


    public function synchronize(User $current_user, User $user)
    {
        return $current_user->id === $user->id;
    }


    public function colleague(User $current_user, User $user)
    {
        return $current_user->rank === $user->rank && $current_user->study_information === $user->study_information;
    }


    public function detail(User $current_user, User $user)
    {
        return $current_user->id === $user->id;
    }
}
