<?php

namespace App\Http\Controllers;

use App\Models\Save;
use App\Models\SaveResource;
use Illuminate\Http\Request;
use Response;

class SaveResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize("viewAny", Save::class);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\SaveResource $saveResource
     * @return \Illuminate\Http\Response
     */
    public function show(SaveResource $saveResource)
    {
        $this->authorize("view", $saveResource->safe);
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
