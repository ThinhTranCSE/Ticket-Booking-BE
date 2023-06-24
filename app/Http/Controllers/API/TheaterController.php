<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TheaterCollection;
use App\Model\Theater;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;

class TheaterController extends Controller
{
    //
    static function getAllTheaters(){
        $theaters = Theater::getAllTheaters();
        return TheaterCollection::collection($theaters);
    }

    static function getTheaterById($id){
        $theater = Theater::getTheaterById($id);
        return new TheaterCollection($theater);
    }

    static function createTheater(Request $req){
        try{
            $req->validate([
                'name' => [
                    'required',
                    'max:255'
                ],
                'location' => [
                    'required',
                    'max:255'
                ]
            ]);
        }
        catch(ValidationException $err){
            return new JsonResponse([
                'message' => 'Validation failed',
                'errors' => $err->validator->errors()
            ], $err->status);
        }

        $theater_data = $req->all();
        $theater = Theater::createTheater($theater_data);
        return new TheaterCollection($theater);
    }

    static function updateTheater(Request $req, $id){
        try{
            $req->validate([
                'name' => [
                    'max:255'
                ],
                'location' => [
                    'max:255'
                ]
            ]);
        }
        catch(ValidationException $err){
            return new JsonResponse([
                'message' => 'Validation failed',
                'errors' => $err->validator->errors()
            ], $err->status);
        }

        $theater_data = $req->all();
        $theater = Theater::updateTheater($theater_data, $id);
        return new TheaterCollection($theater);
    }
    static function deleteTheaterById($id){
        $theater = Theater::deleteTheaterById($id);
        return new TheaterCollection($theater);
    }
}
