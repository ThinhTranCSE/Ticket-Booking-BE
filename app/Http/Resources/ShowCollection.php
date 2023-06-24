<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class ShowCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'show_time' =>  Carbon::createFromFormat('Y-m-d H:i:s', $this->show_time)->format('Y-m-d H:i:s'),
            'movie_id' => $this->movie_id,
            'theater_id' => $this->theater_id
        ];
    }
}
