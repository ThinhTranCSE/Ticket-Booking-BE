<?php

namespace App\Policies;

use App\Booking;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Http\Request;

class BookingPolicy
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

    public function viewAllOf(User $user, int $user_model_id){
        return $user->id == $user_model_id;
    }
    public function view(User $user, int $booking_id)
    {
        $booking = \App\Model\Booking::query()->findOrFail($booking_id);
        return $user->id == $booking->getAttributeValue('user_id');
    }

    public function delete(User $user)
    {
        return false;
    }

}
