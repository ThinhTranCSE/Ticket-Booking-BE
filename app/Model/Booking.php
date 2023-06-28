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
            ->join('shows', 'show_id', '=', 'shows.id')
            ->join('movies', 'shows.movie_id', '=', 'movies.id')
            ->join('theaters', 'shows.theater_id', '=', 'theaters.id')
            ->select(
                'bookings.id', 
                'booking_date', 
                'show_id', 
                'user_id', 
                'movie_id', 
                'theater_id', 
                'show_time', 
                'movies.name as movie_name', 
                'theaters.name as theater_name', 
                'poster'
            )
            ->orderBy('booking_date', 'asc')
            ->get();
        return $bookings;

    }

    static function createBooking($booking_data){
        $booking = new Booking;
        $booking->show_id = $booking_data['show_id'];
        $booking->user_id = $booking_data['user_id'];
        
        $booking->save();
        $booking = $booking->fresh();
        return $booking;
    }

    static function deleteBookingById(int $id){
        $booking = Booking::query()->findOrFail($id);
        $booking->delete();
        return $booking;
    }
}
