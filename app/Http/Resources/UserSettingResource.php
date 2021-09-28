<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserSettingResource extends JsonResource
{


    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [

            $this->mergeWhen($this->resource->pivot , function(){
                return[
                    "user_id" => $this->pivot->user_id,
                    "setting_id" => $this->pivot->setting_id,
                    "value" => $this->pivot->value
                ];
            }),
        ];
    }
}
