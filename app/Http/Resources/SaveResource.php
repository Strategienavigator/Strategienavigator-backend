<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaveResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "data" => $this->data,
            "name" => $this->name,
            "description" => $this->description,
            "locked_by" => $this->locked_by_id,
            "last_locked" => $this->last_locked,
            "owner_id" => $this->owner_id,
            "tool_id" => $this->tool_id,
            "contributors" => $this->contributors->map(function ($c) {
                return $c->id;
            })->toArray(),
            "invited" => $this->invited->map(function ($c) {
                return $c->id;
            })->toArray(),
        ];
    }
}
