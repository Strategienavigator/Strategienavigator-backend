<?php

namespace App\Http\Controllers;

use App\Http\Resources\SimpleSaveResource;
use App\Models\User;

class UserSavesController extends Controller
{
    public function index(User $user)
    {

        $saves = $user->saves()->simplePaginate();
        foreach ($saves->items() as $s) {
            $this->authorize("view", $s);
        }
        return SimpleSaveResource::collection($saves);
    }
}
