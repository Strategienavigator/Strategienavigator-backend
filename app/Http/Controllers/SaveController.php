<?php

namespace App\Http\Controllers;

use App\Http\Resources\SaveResource;
use App\Http\Resources\SimpleSaveResource;
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
        $this->authorize("viewAny", Save::class);

        return SimpleSaveResource::collection(Save::with("contributors")->simplePaginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {

        $this->authorize("create", Save::class);

        $validate = $request->validate([
            "name" => "required|string",
            "description"=>"string",
            "data" => "nullable|json",
            "tool_id" => "required|exists:tools,id"
        ]);

        $s = new Save($validate);
        $s->tool_id = $validate["tool_id"];
        $s->owner_id = $request->user()->id;
        $s->save();
        return response()->created('saves', $s);
    }

    /**
     * Display the specified resource.
     *
     * @param Save $save
     * @return SaveResource
     */
    public function show(Save $save): SaveResource
    {
        $this->authorize("view", $save);
        $save->last_opened = Carbon::now();
        $save->save();
        return new SaveResource($save);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Save $save
     * @return Response|JsonResponse
     */
    public function update(Request $request, Save $save): Response
    {
        $this->authorize("update", $save);
        $user = $request->user();

        if ($request->has("lock")) {

            $validated = $request->validate([
                "lock" => "required|boolean",
                "data" => "prohibited",
                "name" => "prohibited",
                "description"=>"prohibited"
            ]);

            if (is_null($save->locked_by_id) || $save->owner_id === $user->id) {
                if ($validated["lock"]) {
                    $save->locked_by_id = $user->id;
                    $save->last_locked = Carbon::now();
                } else {
                    $save->locked_by_id = null;
                }

                $save->save();
                return response()->noContent(Response::HTTP_OK);
            } else {
                return response(["message" => "The save needs to get locked in advance"], Response::HTTP_FAILED_DEPENDENCY);
            }
        } else {
            $validated = $request->validate([
                "data" => "nullable|json",
                "name" => "string",
                "description" => "string",
                "lock" => "prohibited"
            ]);

            if ($save->locked_by_id === $user->id) {
                $save->fill($validated);
                $save->save();
                return response()->noContent(Response::HTTP_OK);
            } else {
                return response()->noContent(Response::HTTP_LOCKED);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Save $save
     * @return Response
     */
    public
    function destroy(Save $save): Response
    {
        $this->authorize("delete", $save);
        $save->delete();
        return response()->noContent(Response::HTTP_OK);
    }
}
