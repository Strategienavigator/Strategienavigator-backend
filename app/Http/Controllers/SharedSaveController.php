<?php

namespace App\Http\Controllers;

use App\Http\Resources\SharedSaveResource;
use App\Models\Save;
use App\Models\SharedSave;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class SharedSaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $this->authorize("viewAny", SharedSave::class);

        return SharedSaveResource::collection(SharedSave::simplePaginate());
    }


    public function indexSave(Save $save)
    {
        $this->authorize("viewOfSave", [SharedSave::class, $save]);
        return SharedSaveResource::collection($save->sharedSaves()->simplePaginate());
    }


    public function indexUser(User $user, User $model)
    {
        $this->authorize("viewOfUser", [SharedSave::class, $model]);
        return SharedSaveResource::collection($user->sharedSaves()->simplePaginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request, Save $save, User $user)
    {
        $validated = $request->validate([
            "permission" => ["required", "integer", "min:0", "max:2"]
        ]);
        $this->authorize("create", [SharedSave::class, $save]);
        $shared_save = new SharedSave($validated);
        $shared_save->user_id = $user->id;
        $shared_save->accepted = false;
        $save->invitations()->save($shared_save);
        return response()->created("contribution", $shared_save);
    }

    /**
     * Display the specified resource.
     *
     * @param SharedSave $sharedSave
     * @return SharedSaveResource
     */
    public function show(SharedSave $sharedSave)
    {
        $this->authorize("view", $sharedSave);

        return new SharedSaveResource($sharedSave);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param SharedSave $sharedSave
     * @return Response
     */
    public function update(Request $request, SharedSave $sharedSave)
    {
        $this->authorize("update", $sharedSave);
        $validated = $request->validate([
            "permission" => ["integer", "min:0", "min:2"],
            "revoked" => ["boolean"],
        ]);
        $sharedSave->fill($validated);
        $sharedSave->save();
        return \response()->noContent(Response::HTTP_OK);
    }


    public function accept(Request $request, SharedSave $sharedSave)
    {
        $this->authorize("acceptDecline", $sharedSave);
        if (!$sharedSave->revoked) {
            $sharedSave->declined = false;
            $sharedSave->accepted = true;
            $sharedSave->save();
            return \response()->noContent(Response::HTTP_OK);
        } else {
            return \response(null, Response::HTTP_CONFLICT);
        }
    }

    public function decline(Request $request, SharedSave $sharedSave)
    {
        $this->authorize("acceptDecline", $sharedSave);
        $sharedSave->accepted = false;
        $sharedSave->declined = true;
        $sharedSave->save();
        return \response(null, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SharedSave $sharedSave
     * @return Response
     */
    public function destroy(SharedSave $sharedSave)
    {
        $this->authorize("delete", $sharedSave);
        $sharedSave->delete();
        return \response(null, Response::HTTP_OK);
    }
}
