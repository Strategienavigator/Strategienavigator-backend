<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

/**
 * Klasse, welche eine Save instanz in ein Array umwandelt
 */
class SaveResource extends JsonResource
{
    /**
     * Felder der Save instanz
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            $this->merge(new SimpleSaveResource($this->resource)),
            "data" => $this->data,
            "contributors" => SimplestUserResource::collection($this->contributors),
            "invited" => SimplestUserResource::collection($this->invited),
        ];
    }
}
