<?php

namespace App\Http\Controllers;

use App\Http\Resources\InvitationLinkResource;
use App\Models\InvitationLink;
use App\Models\Save;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class InvitationLinkController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        $this->authorize("viewAny", InvitationLink::class);

        return InvitationLinkResource::collection(InvitationLink::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {

        $this->authorize("create", InvitationLink::class);

        $validate = $request->validate([
            "expiry_date" => "required|date",
            "permission" => "required|numeric|min:0|max:2",
            "save_id" => "required|exists:saves,id"
        ]);


        $invitation_link = new InvitationLink($validate);
        $invitation_link->save_id = $validate["save_id"];
        $invitation_link->save();
        return response()->created('invitation_link', $invitation_link);
    }

    /**
     * Display the specified resource.
     *
     * @param InvitationLink $invitation_link
     * @return InvitationLinkResource
     */
    public function show(InvitationLink $invitation_link): InvitationLinkResource
    {
        $this->authorize("view", $invitation_link);

        return new InvitationLinkResource($invitation_link);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param InvitationLink $invitation_link
     * @return Response|JsonResponse
     */
    public function update(Request $request, InvitationLink $invitation_link): Response
    {
        $this->authorize("update", $invitation_link);

        $validate = $request->validate([
            "expiry_date" => "date",
            "permission" => "numeric|min:1|max:2"
        ]);

        $invitation_link->fill($validate);
        $invitation_link->save();

        return response()->noContent(Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param InvitationLink $invitation_link
     * @return Response
     */
    public
    function destroy(InvitationLink $invitation_link): Response
    {
        $this->authorize("delete", $invitation_link);
        $invitation_link->delete();
        return response()->noContent(Response::HTTP_OK);
    }
}