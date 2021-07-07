<?php

namespace App\Http\Controllers;

use App\Http\Resources\SaveResource;
use App\Models\Save;
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
        $s = new Save($request->toArray());
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
