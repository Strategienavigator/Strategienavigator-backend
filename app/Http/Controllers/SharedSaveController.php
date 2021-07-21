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
        $this->authorize("viewAny",SharedSave::class);

        return SharedSaveResource::collection(SharedSave::simplePaginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request,Save $save, User $user)
    {
        $validated = $request->validate([
            "permission" => ["required","integer","min:0","max:2"]
        ]);
        $this->authorize("create",[SharedSave::class,$save]);
        $shared_save = new SharedSave($validated);
        $shared_save->user_id = $user->id;
        $shared_save->accepted = false;
        $save->invitations()->save($shared_save);
        return response()->created("contribution",$shared_save);
    }

    public function storeReverse(Request $request,User $user, Save $save){
        return $this->store($request,$save,$user);
    }

    /**
     * Display the specified resource.
     *
     * @param SharedSave $sharedSave
     * @return SharedSaveResource
     */
    public function show(SharedSave $sharedSave)
    {
        $this->authorize("view",$sharedSave);

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
        $this->authorize("update",$sharedSave);
        $validated = $request->validate([
            "permission" => ["integer","min:0","min:2"]
        ]);
        $sharedSave->fill($validated);
        $sharedSave->save();
        return \response()->noContent(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param SharedSave $sharedSave
     * @return Response
     */
    public function destroy(SharedSave $sharedSave)
    {
        $this->authorize("delete",$sharedSave);
        $sharedSave->delete();
        return \response()->noContent(Response::HTTP_OK);
    }
}
