<?php

namespace App\Http\Controllers;

use App\Http\Resources\SaveResourceDescriptorResource;
use App\Models\Save;
use App\Models\SaveResource;
use App\Services\SaveResourceService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Validation\Rules\File;
use Response;

class SaveResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Save $save)
    {
        abort(404);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return AnonymousResourceCollection
     */
    public function store(SaveResourceService $saveResourceService, Save $save, Request $request)
    {
        $this->authorize("update", $save);
        $request->validate([
            "resources.*" => [
                File::types(SaveController::ALLOWED_MIMETYPES)
                    ->max(SaveController::FILE_MAX_KILOBYTES)
            ]
        ]);
        return SaveResourceDescriptorResource::collection($saveResourceService->saveResources($save, $request->allFiles()));

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\SaveResource $resource
     * @return \Illuminate\Http\Response
     */
    public function show(SaveResource $resource)
    {
        $this->authorize("view", $resource->safe);
        $content = $resource->contents;

        return Response::make($content)
            ->header("Content-Type", $resource->file_type);
    }

    /**
     * Display the specified resource by file name and save.
     */

    public function showByName(Save $save, string $fileName)
    {
        $this->authorize("view", $save);

        /** @var SaveResource $saveResource */
        $saveResource = $save->saveResources()->where("file_name", "=", $fileName)->firstOrFail();

        $content = $saveResource->contents;
        return Response::make($content)
            ->header("Content-Type", $saveResource->file_type);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\SaveResource $saveResource
     * @return \Illuminate\Http\Response
     */
    public function destroy(SaveResource $saveResource)
    {
        abort(404);
    }
}
