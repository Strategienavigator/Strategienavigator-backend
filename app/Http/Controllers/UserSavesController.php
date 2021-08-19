<?php

namespace App\Http\Controllers;

use App\Http\Resources\SimpleSaveResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserSavesController extends Controller
{
    public function index(Request $request , User $user)
    {
        $validated = $request->validate([
            "tool_id" => ["integer","exists:tools,id"]
        ]);
        $savesQuerry = $user->saves()->with(["contributors"]);
        if(key_exists("tool_id",$validated)){
            $savesQuerry->where("tool_id",$validated["tool_id"]);
        }
        $saves = $savesQuerry->simplePaginate();
        foreach ($saves->items() as $s) {
            $this->authorize("view", $s);
        }
        return SimpleSaveResource::collection($saves);
    }
}
