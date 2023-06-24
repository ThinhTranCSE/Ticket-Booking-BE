<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class BookingCollection extends JsonResource
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
            'booking_date' => Carbon::createFromFormat('Y-m-d H:i:s', $this->booking_date)->format('Y-m-d H:i:s'),
            'show_id' => $this->show_id,
            'user_id' => $this->user_id
        ];
    }
}
