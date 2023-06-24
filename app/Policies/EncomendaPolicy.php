<?php

namespace App\Policies;

use App\Models\User;

class EncomendaPolicy
{
    /**
     * Create a new policy instance.
     */
    public function viewAny(User $user): bool
    {
       if (($user->user_type == 'A') || ($user->user_type == 'E'))
       {
        return true;
       }
       return false;
    }

    public function view(User $user): bool
    {
        return true;
    }

    public function update(User $user): bool
    {
        if (($user->user_type == 'E') || ($user->user_type == 'A'))
        {
            return true;
        }
        return false;
    }
}
