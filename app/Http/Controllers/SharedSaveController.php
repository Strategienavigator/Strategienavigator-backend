<?php

namespace App\Http\Controllers;

use App\Models\Save;
use App\Models\SharedSave;
use App\Models\User;
use Illuminate\Http\Request;

class SharedSaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Save $save, User $user)
    {
        $validated = $request->validate([
            "permission" => ["required","integer","min:0","max:2"]
        ]);
        $this->authorize("create",[SharedSave::class,$save]);
        $shared_save = new SharedSave($validated);
        $shared_save->user_id = $user->id;
        $save->invitations()->save($shared_save);
        return response()->created("contribution",$shared_save);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SharedSave  $sharedSave
     * @return \Illuminate\Http\Response
     */
    public function show(SharedSave $sharedSave)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SharedSave  $sharedSave
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SharedSave $sharedSave)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SharedSave  $sharedSave
     * @return \Illuminate\Http\Response
     */
    public function destroy(SharedSave $sharedSave)
    {
        //
    }
}
