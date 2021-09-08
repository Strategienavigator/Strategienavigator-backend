<?php

namespace App\Http\Controllers;

use App\Http\Resources\SimpleSaveResource;
use App\Models\SharedSave;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Controller, eine Route zum Anzeigen aller Speicherstände eins zugehörigen Users
 * @package App\Http\Controllers
 */
class UserSavesController extends Controller
{
    public function index(Request $request, User $user)
    {
        $this->authorize("viewOfUser", [SharedSave::class, $user]);
        $validated = $request->validate([
            "tool_id" => ["integer", "exists:tools,id"],
            "name" => ["string"],
            "description" => ["string"]
        ]);

        $savesQuerry = $user->saves();
        $contributorSavesQuery = $user->accessibleShares(false);

        if (key_exists("tool_id", $validated)) {
            $savesQuerry->where("tool_id", $validated["tool_id"]);
            $contributorSavesQuery->where("tool_id", $validated["tool_id"]);
        }


        if (key_exists("name", $validated)) {
            $savesQuerry->where("name","Like", "%" .  $validated["name"] . "%");
            $contributorSavesQuery->where("name","Like", "%" .  $validated["name"] . "%");
        }

        if (key_exists("description", $validated)) {
            $savesQuerry->where("description","Like", "%" .  $validated["description"] . "%");
            $contributorSavesQuery->where("description","Like", "%" .  $validated["description"] . "%");
        }

        $saves = $savesQuerry->union($contributorSavesQuery->getBaseQuery())->paginate();
        return SimpleSaveResource::collection($saves);
    }
}
