<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\MovieCollection;
use App\Model\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;

class MovieController extends Controller
{
    const DESTINATION_POSTERS_PATH = 'public/posters';
    static function getAllMovies(){
        $movies = Movie::getAllMovie();
        return MovieCollection::collection($movies);
    }
    
    static function getMovieById($id){
        $movie = Movie::getMovieById($id);
        return new MovieCollection($movie);
    }
    static function createMovie(Request $req){
        try{
            $req->validate([
                'name' => [
                    'required',
                    'max:255'
                ],
                'description' => [
                    'required'
                ],
                'duration' => [
                    'required',
                    'integer',
                    'min:0'
                ],
                'poster' => [
                    'image'
                ]
            ]);
        }
        catch(ValidationException $err){
            return new JsonResponse([
                'message' => 'Validation failed',
                'error' => $err->validator->errors()
            ], $err->status);
        }

        $movie_data = $req->all();
        $movie_data['poster'] = '';

        $movie = Movie::createMovie($movie_data);

        if($req->hasFile('poster')){
            $path = MovieController::storePoster($req->file('poster'), $movie->id);
            $movie->poster = str_replace('public', 'storage', $path);
            $movie->save();
        }
        return new MovieCollection($movie);
    }   

    static function updateMovie(Request $req, $id){
        try{
            $req->validate([
                'name' => [
                    'max:255'
                ],
                'description' => [
                ],
                'duration' => [
                    'min:0'
                ],
                'poster' => [
                    'image'
                ]
            ]);
        }
        catch(ValidationException $err){
            return new JsonResponse([
                'message' => 'Validation failed',
                'error' => $err->validator->errors()
            ], $err->status);
        }
        $movie_data = $req->all();
        $movie_data['poster'] = '';
        $movie = Movie::updateMovie($movie_data, $id);

        if($req->hasFile('poster')){
            MovieController::deletePoster($movie->poster);
            $path = MovieController::storePoster($req->file('poster'), $movie->id);
            $movie->poster = str_replace('public', 'storage', $path);
            $movie->save();
        }

        return new MovieCollection($movie);
    }

    static function deleteMovieById($id){
        $movie = Movie::deleteMovieById($id);
        MovieController::deletePoster($movie->poster);
        return new MovieCollection($movie);
    }
    private static function deletePoster($stored_path){
        $on_disk_path = str_replace( 'storage', 'public', $stored_path);
        Storage::delete($on_disk_path);

    }
    private static function storePoster(UploadedFile $poster, $id){
        $destination_path = MovieController::DESTINATION_POSTERS_PATH;
        $file_name = $id . '.' . $poster->getClientOriginalExtension();
        $path = $poster->storeAs($destination_path, $file_name);
        return $path;
    }
}
