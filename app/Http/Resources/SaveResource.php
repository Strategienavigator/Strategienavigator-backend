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
        $simpleResource = new SimpleSaveResource($this->resource);
        return array_merge_recursive($simpleResource->toArray($request), [
            "data" => $this->data,
            "contributors" => $this->contributors->map(function ($c) {
                return new SimpletsUserResource($c);
            })->toArray(),
            "invited" => $this->invited->map(function ($c) {
                return new SimpletsUserResource($c);
            })->toArray(),
        ]);
    }
}
