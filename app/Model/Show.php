<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Show extends Model
{
    //
    protected $date = [
        'show_time'
    ];

    static function getAllShows(){
        $shows = Show::all();
        return $shows;
    }

    static function getAllShowsWithFullDetails(){
        $shows = Show::query()
            ->join('movies', 'shows.movie_id', '=', 'movies.id')
            ->join('theaters', 'shows.theater_id', '=', 'theaters.id')
            ->select(
                'shows.id',
                'shows.show_time', 
                'movies.name as movie_name', 
                'movies.description as movie_description', 
                'movies.duration as movie_duration', 
                'movies.poster as movie_poster', 
                'theaters.name as theater_name',
                'theaters.location as theater_location'
            )
            ->get();
        return $shows;
    }

    static function getShowById(int $id){
        $show = Show::query()->findOrFail($id);
        return $show;
    }

    static function createShow($show_data){
        $show = new Show;
        $show->show_time = $show_data['show_time'];
        $show->movie_id = $show_data['movie_id'];
        $show->theater_id = $show_data['theater_id'];

        $show->save();
        return $show;
    }

    static function updateShow($show_data, int $id){
        $show = Show::query()->findOrFail($id);
        if($show_data['show_time']) $show->show_time = $show_data['show_time'];
        if($show_data['movie_id']) $show->movie_id = $show_data['movie_id'];
        if($show_data['theater_id']) $show->theater_id = $show_data['theater_id'];

        $show->save();
        return $show;
    }

    static function deleteShowById(int $id){
        $show = Show::query()->findOrFail($id)->delete();
        return $show;
    }
}
