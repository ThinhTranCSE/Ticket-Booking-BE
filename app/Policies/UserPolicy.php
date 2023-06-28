<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability){
        if($user->role == 'admin'){
            return true;
        }
    }
    public function viewAny(User $user)
    {
        return false;
    }

    public function view(User $user, int $user_model_id)
    {
        return $user->id == $user_model_id;
    }

    public function create(User $user)
    {
        return false;
    }

    public function update(User $user, int $user_model_id)
    {
        return $user->id == $user_model_id;
    }

    public function delete(User $user)
    {
        return false;
    }
}
