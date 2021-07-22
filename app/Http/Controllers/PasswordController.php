<?php

namespace App\Http\Controllers;

use App\Http\Resources\PasswordResetResource;
use App\Models\PasswordReset;
use App\Models\User;
use App\Services\TokenService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PasswordController extends Controller
{
    //

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return PasswordResetResource
     */
    function show(Request $request) {
        $password_reset = PasswordReset::where('token', '=', $request->token)->firstOrFail();
        // TODO PasswordPolicy implementieren
        // $this->authorize('view', $password_reset);

        return new PasswordResetResource($password_reset);
    }


    function forgotPassword(Request $request) {
        $tokenService = new TokenService();

        $validate = $request->validate([
            "username" => "required|exists:users,username"
        ]);

        $password_reset = new PasswordReset();
        $password_reset->user_id = User::where('username', '=', $validate["username"])->firstOrFail()->id;

        $password_reset->expiry_date = Carbon::now()->addHour();

        $password_reset->token = $tokenService->createToken();
        $password_reset->password_changed = false;
        $password_reset->created_at = Carbon::now();

        $password_reset->save();

        // TODO Email versenden implementieren


        return response()->noContent(Response::HTTP_OK);
    }

    function updatePassword(Request $request) {

        $validate = $request->validate([
            "password" => "required|string"
        ]);

        $password_reset = PasswordReset::where('token', '=', $request->token)->firstOrFail();

        if (Carbon::now() < $password_reset->expiry_date && $password_reset->password_changed === false) {

            $user = User::findOrFail($password_reset->user_id);

            $user->password = $validate["password"];
            $password_reset->password_changed = true;
            $password_reset->password_changed_at = Carbon::now();
            $password_reset->save();
            $user->save();
            return response()->noContent(Response::HTTP_OK);
        } else {
            return response()->noContent(Response::HTTP_FORBIDDEN);
        }

    }

}
