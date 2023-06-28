<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
class Movie extends Model
{
    static function getAllMovie(){
        $movies = Movie::all();
        return $movies;
    }

    static function getMovieById(int $id){
        $movie = Movie::findOrFail($id);
        return $movie;
    }
    static function createMovie($movie_data){
        $movie = new Movie;
        $movie->name = $movie_data['name'];
        $movie->description = $movie_data['description'];
        $movie->duration = $movie_data['duration'];
        $movie->poster = $movie_data['poster'];

        $movie->save();

        return $movie;
    }

    static function updateMovie($movie_data, int $id){
        $movie = Movie::findOrFail($id);
        if($movie_data['name']) $movie->name = $movie_data['name'];
        if($movie_data['description']) $movie->description = $movie_data['description'] ;
        if($movie_data['duration'])  $movie->duration = $movie_data['duration'];
        if($movie_data['poster']) $movie->poster = $movie_data['poster'];

        $movie->save();
        return $movie;
    }

    static function deleteMovieById(int $id){
        $movie = Movie::findOrFail($id);
        $movie->delete();
        return $movie;
    }
}
