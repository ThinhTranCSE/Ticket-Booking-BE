<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShowCollection;
use App\Model\Show;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ShowController extends Controller
{
    //
    static function getAllShows(){
        $shows = Show::getAllShows();
        return ShowCollection::collection($shows);
    }

    static function getShowById($id){
        $show = Show::getShowById($id);
        return new ShowCollection($show);
    }

    static function getAllShowsWithFullDetails(){
        $shows_with_details = Show::getAllShowsWithFullDetails();
        $shows_with_details->map(function($show){
            $show->movie_poster = asset($show->movie_poster);
        });
        return response()->json($shows_with_details);
    }
    static function createShow(Request $req){
        try{
            $req->validate([
                'show_time' => [
                    'required',
                    'date_format:Y-m-d H:i:s'
                ],
                'movie_id' => [
                    'required',
                    'exists:movies,id'
                ],
                'theater_id' => [
                    'required',
                    'exists:theaters,id'
                ]
            ]);
        }
        catch(ValidationException $err){
            return new JsonResponse([
                'message' => 'Validation failed',
                'errors' => $err->validator->errors()
            ], $err->status);
        }

        $show_data = $req->all();
        $show_data['show_time'] = Carbon::createFromFormat('Y-m-d H:i:s', $show_data['show_time']);

        $show = Show::createShow($show_data);
        return new ShowCollection($show);
    }

    static function updateShow(Request $req, $id){
        try{
            $req->validate([
                'show_time' => [
                    'date_format:Y-m-d H:i:s'
                ],
                'movie_id' => [
                    'exists:movies,id'
                ],
                'theater_id' => [
                    'exists:theaters,id'
                ]
            ]);
        }
        catch(ValidationException $err){
            return new JsonResponse([
                'message' => 'Validation failed',
                'errors' => $err->validator->errors()
            ], $err->status);
        }

        $show_data = $req->all();
        if($show_data['show_time']) $show_data['show_time'] = Carbon::createFromFormat('Y-m-d H:i:s', $show_data['show_time']);

        $show = Show::updateShow($show_data, $id);
        return new ShowCollection($show);
    }

    static function deleteShowById($id){
        $show = Show::deleteShowById($id);
        return new ShowCollection($show);
    }
}
