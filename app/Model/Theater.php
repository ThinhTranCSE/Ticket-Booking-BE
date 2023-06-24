<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Theater extends Model
{
    static function getAllTheaters(){
        $theaters = Theater::all();
        return $theaters;
    }

    static function getTheaterById(int $id){
        $theater = Theater::query()->findOrFail($id);
        return $theater;
    }
    static function createTheater($theater_data){
        $theater = new Theater;
        $theater->name = $theater_data['name'];
        $theater->location = $theater_data['location'];
        
        $theater->save();
        return $theater;
    }

    static function updateTheater($theater_data, int $id){
        $theater = Theater::query()->findOrFail($id);
        
        if($theater_data['name']) $theater->name = $theater_data['name'];
        if($theater_data['location']) $theater->location = $theater_data['location'];

        $theater->save();

        return $theater;
    }

    static function deleteTheaterById(int $id){
        $theater = Theater::query()->findOrFail($id)->delete();
        return $theater;
    }


}
