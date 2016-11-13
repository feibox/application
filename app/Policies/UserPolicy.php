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
            if (!$user->is_admin) {
                return false;
            }
            return null;
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

    public function detail(User $current_user, User $user)
    {
        return $current_user->id === $user->id;
    }
}
