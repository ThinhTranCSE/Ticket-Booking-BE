<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingCollection;
use App\Model\Booking;
use App\Model\Movie;
use App\Model\Show;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
 
class DashboardController extends Controller
{
    static function getLineChartData($from, $to){
        $date_to = $to != null ? date_create($to) : date_create('now');
        $date_from = $from != null ? date_create($from) : date_create('now');
        $from == null  ? date_sub($date_from, date_interval_create_from_date_string("30 days")) : null;
        date_time_set($date_to, 23, 59);
        date_time_set($date_from, 0, 0);

        //line_chart_data -> { booking_count, date }
        $line_chart_data = Booking ::query()
            ->where('booking_date', '>=', $date_from, 'and')
            ->where('booking_date', '<=', $date_to)
            ->selectRaw('date(booking_date) as date, count(id) as booking_count')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();
        return response()->json(['data' => $line_chart_data]);
    }

    static function getPieChartData($from, $to){
        $date_to = $to != null ? date_create($to) : date_create('now');
        $date_from = $from != null ? date_create($from) : date_create('now');
        $from == null  ? date_sub($date_from, date_interval_create_from_date_string("30 days")) : null;
        date_time_set($date_to, 23, 59);
        date_time_set($date_from, 0, 0);

        $pie_chart_data = Booking::query()
            ->where('booking_date', '>=', $date_from, 'and')
            ->where('booking_date', '<=', $date_to)
            ->leftJoin('shows', 'show_id', '=', 'shows.id')
            ->join('movies', 'shows.movie_id', '=', 'movies.id')
            ->selectRaw('movies.name as movie_name, count(bookings.id) as booking_count')
            ->groupBy('movie_name')
            ->get();
        return response()->json(['data' => $pie_chart_data]);
    }

    static function getBarChartData($from, $to){
        $date_to = $to != null ? date_create($to) : date_create('now');
        $date_from = $from != null ? date_create($from) : date_create('now');
        $from == null  ? date_sub($date_from, date_interval_create_from_date_string("30 days")) : null;
        date_time_set($date_to, 23, 59);
        date_time_set($date_from, 0, 0);

        $bar_chart_data = Booking::query()
            ->where('booking_date', '>=', $date_from, 'and')
            ->where('booking_date', '<=', $date_to)
            ->leftJoin('shows', 'show_id', '=', 'shows.id')
            ->join('theaters', 'shows.theater_id', '=', 'theaters.id')
            ->selectRaw('theaters.name as theater_name, count(bookings.id) as booking_count')
            ->groupBy('theater_name')
            ->get();
        return response()->json(['data' => $bar_chart_data]);
    }
}
