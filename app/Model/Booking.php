<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    //
    protected $date = [
        'booking_date'
    ];

    static function getAllBookings(){
        $bookings = Booking::all();
        return $bookings;
    }
    static function getBookingById(int $id){
        $booking = Booking::query()->findOrFail($id);
        return $booking;
    }

    static function getAllBookingsOfUser(int $user_id){
        $bookings = Booking::query()
            ->where('user_id', '=', $user_id)
            ->orderBy('booking_time', 'asc')
            ->get();
        return $bookings;

    }

    static function createBooking($booking_data){
        $booking = new Booking;
        $booking->show_id = $booking_data['show_id'];
        $booking->user_id = $booking_data['user_id'];
        
        $booking->save();
        return $booking;
    }

    static function deleteBookingById(int $id){
        $booking = Booking::query()->findOrFail($id)->delete();
        return $booking;
    }
}
