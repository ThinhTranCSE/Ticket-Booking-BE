<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingCollection;
use App\Model\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    //
    static function getAllBookings(){
        $bookings = Booking::getAllBookings();
        return BookingCollection::collection($bookings);
    }

    static function getBookingById($id){
        $booking = Booking::getBookingById($id);
        return new BookingCollection($booking);
    }

    static function getAllBookingsOfUser($user_id){
        $bookings = Booking::getAllBookingsOfUser($user_id);
        return response()->json($bookings->map(function($booking){
            $booking->poster = asset($booking->poster);
            return $booking;
        }));
    }

    static function createBooking(Request $req){
        try{
            $req->validate([
                'show_id' => [
                    'required',
                    'exists:shows,id'
                ],
                'user_id' => [
                    'required',
                    'exists:users,id'
                ]
            ]);
        }
        catch(ValidationException $err){
            return new JsonResponse([
                'message' => 'Validation failed',
                'errors' => $err->validator->errors()
            ], $err->status);
        }

        $booking_data = $req->all();
        $booking = Booking::createBooking($booking_data);
        return new BookingCollection($booking);
    }

    static function deleteBookingById($id){
        $booking = Booking::deleteBookingById($id);
        return new BookingCollection($booking);
    }
}
