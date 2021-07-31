<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SimpleSaveResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "locked_by" => $this->locked_by_id,
            "name" => $this->name,
            "last_locked" => $this->last_locked,
            "owner_id" => $this->owner_id,
            "tool_id" => $this->tool_id,
            "contributors" => $this->contributors->map(function ($c) {
                return $c->id;
            })->toArray()
        ];
    }
}
