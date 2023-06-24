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
}
