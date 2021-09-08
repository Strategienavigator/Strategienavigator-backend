<?php

namespace App\Http\Resources;

use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Klasse, welche eine PasswordReset instanz in ein Array umwandelt
 */
class PasswordResetResource extends JsonResource
{
    /**
     * Felder der PasswordReset instanz ohne das Token und password_changed(_at) Feld
     *
     * @param Request $request
     * @return array
     *
     * @see PasswordReset
     */
    public function toArray($request)
    {
        return [
            "user_id" => $this->user_id,
            "expiry_date" => $this->expiry_date,
        ];
    }
}
