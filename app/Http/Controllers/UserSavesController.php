<?php

namespace App\Http\Controllers;

use App\Http\Resources\SimpleSaveResource;
use App\Models\Save;
use App\Models\SharedSave;
use App\Models\User;
use App\Policies\SavePolicy;
use App\Policies\SharedSavePolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

/**
 * Controller, eine Route zum Anzeigen aller Speicherstände eins zugehörigen Users
 * @package App\Http\Controllers
 */
class UserSavesController extends Controller
{
    /**
     * Gibt alle Speicherstände (geteilte und die, die im Besitzt sind) aus
     * @param Request $request Die aktuelle Request instanz
     * @param User $user Der User, welcher in der Route definiert wurde
     * @return AnonymousResourceCollection Alle Speicherständer, nach der Filterung
     * @throws AuthorizationException Wenn der User keine Berechitung hat sich die Speicherstände des Users anzuschauen
     * @see Save
     * @see SharedSavePolicy
     * @see
     */
    public function index(Request $request, User $user)
    {
        $this->authorize("viewOfUser", [SharedSave::class, $user]);
        $validated = $request->validate([
            "tool_id" => ["integer", "exists:tools,id"],
            "name" => ["string"],
            "description" => ["string"],
            "search_both" => ["boolean"]
        ]);

        if (!key_exists("search_both", $validated)) {
            $validated["search_both"] = false;
        }

        $savesQuerry = $user->saves();
        $contributorSavesQuery = $user->accessibleShares(false);

        $where = function ($query) use ($validated) {
            if (key_exists("tool_id", $validated)) {
                $query->where("tool_id", $validated["tool_id"]);
            }

            if (key_exists("name", $validated)) {
                $query->where("name", "Like", "%" . $validated["name"] . "%");
            }
            if (key_exists("description", $validated)) {
                if($validated["search_both"]){
                    $query->where("description", "Like", "%" . $validated["description"] . "%");
                }else{
                    $query->orWhere("description", "Like", "%" . $validated["description"] . "%");
                }
            }
        };

        $savesQuerry->where($where);
        $contributorSavesQuery->where($where);


        $saves = $savesQuerry->union($contributorSavesQuery->getBaseQuery())->paginate();
        return SimpleSaveResource::collection($saves);
    }
}
