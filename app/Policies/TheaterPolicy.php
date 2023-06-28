<?php

namespace App\Policies;

use App\Theater;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TheaterPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function before($user, $ability){
        if($user->role == 'admin'){
            return true;
        }
    }
    
    public function create(User $user)
    {
        return false;
    }

    public function update(User $usere)
    {
        return false;
    }

    public function delete(User $user)
    {
        return false;
    }
}
