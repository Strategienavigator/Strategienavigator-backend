<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserSavesController extends Controller
{
    public function index(User $user){
        return response()->json($user->saves->map(function($s){
            return $s->id;
        }));
    }
}
