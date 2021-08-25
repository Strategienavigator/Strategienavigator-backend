<?php

namespace App\Http\Controllers;

use App\Http\Resources\PasswordResetResource;
use App\Mail\EmailVerificationEmail;
use App\Mail\PasswordResetEmail;
use App\Models\PasswordReset;
use App\Models\User;
use App\Services\TokenService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Mail;

class PasswordController extends Controller
{
    //

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return PasswordResetResource
     */
    function show(Request $request)
    {
        $password_reset = PasswordReset::where('token', '=', $request->token)->firstOrFail();
        // TODO PasswordPolicy implementieren
        // $this->authorize('view', $password_reset);

        return new PasswordResetResource($password_reset);
    }


    function forgotPassword(Request $request, TokenService $tokenService)
    {

        $validate = $request->validate([
            "email" => ["required","exists:users,email"]
        ]);

        $password_reset = new PasswordReset();
        $u = User::whereEmail($validate["email"])->firstOrFail();
        $password_reset->user_id = $u->id;

        $password_reset->expiry_date = Carbon::now()->addHour();

        $password_reset->token = $tokenService->createToken(true);
        Log::debug($password_reset->token);
        $password_reset->password_changed = false;
        $password_reset->created_at = Carbon::now();


        $password_reset->save();

        Mail::to($u->email)->send(new PasswordResetEmail($password_reset->token,$u->username));


        return response()->noContent(Response::HTTP_OK);
    }

    function updatePassword(String $token, Request $request)
    {

        $validate = $request->validate([
            "password" => "required|string"
        ]);

        $password_reset = PasswordReset::whereToken($token)->firstOrFail();

        if (Carbon::now() < $password_reset->expiry_date && $password_reset->password_changed === false) {

            $user = $password_reset->user;

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
