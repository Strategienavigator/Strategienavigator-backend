<?php

namespace App\Http\Controllers;

use App\Http\Resources\ToolResource;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class ToolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $this->authorize("viewAny",Tool::class);

        return ToolResource::collection(Tool::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->authorize("create",Tool::class);

        $tool = new Tool($request->input());
        $tool->save();

        return response()->noContent(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param Tool $tool
     * @return ToolResource
     */
    public function show(Tool $tool)
    {
        $this->authorize("view",$tool);

        return new ToolResource($tool);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Tool $tool
     * @return Response
     */
    public function update(Request $request, Tool $tool)
    {
        $this->authorize("update",$tool);

        return response()->noContent(Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Tool $tool
     * @return Response
     */
    public function destroy(Tool $tool)
    {
        $this->authorize("destroy",$tool);

        return response()->noContent(Response::HTTP_OK);
    }
}
