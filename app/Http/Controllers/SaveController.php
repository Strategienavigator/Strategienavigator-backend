<?php

namespace App\Http\Controllers;

use App\Http\Resources\SaveResource;
use App\Models\Save;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class SaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $this->authorize("viewAny",Save::class);

        return SaveResource::collection(Save::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {

        $this->authorize("create",Save::class);

        $validate = $request->validate([
            "data"=>"nullable|json",
            "tool_id"=>"required|exists:tools,id"
        ]);


        $s = new Save($validate);
        $s->tool_id = $validate["tool_id"];
        $s->owner_id = $request->user()->id;
        $s->save();
        return response()->created('saves',$s);
    }

    /**
     * Display the specified resource.
     *
     * @param Save $save
     * @return SaveResource
     */
    public function show(Save $save): SaveResource
    {
        $save->last_opened = Carbon::now();
        $save->save();
        return new SaveResource($save);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Save $save
     * @return Response
     */
    public function update(Request $request, Save $save): Response
    {
        $save->fill($request->toArray());
        $save->save();
        return response()->noContent(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Save $save
     * @return Response
     */
    public function destroy(Save $save): Response
    {
        $save->delete();
        return response()->noContent(Response::HTTP_OK);
    }
}
