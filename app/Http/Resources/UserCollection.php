<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Psy\Util\Json;

class UserCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            'id' => $this->id,
            'username' => $this->username,
            'role' => $this->role
        ];
    }
}
