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

    /**
     * Zeigt Metadaten des angeforderten Password resets an
     *
     * @param string $token Der Token von der PasswordReset Resource
     * @return PasswordResetResource Resource mit der angeforderten PasswordReset instanz
     */
    function show(string $token): PasswordResetResource
    {
        $password_reset = PasswordReset::whereToken($token)->firstOrFail();

        return new PasswordResetResource($password_reset);
    }


    /**
     * Erstellt eine PasswordReset instanz und schickt eine E-Mail an den Nutzer
     * @param Request $request die aktuelle Request instanz
     * @param TokenService $tokenService Dependency Injection
     * @return Response Code 201 wenn resource erstellt wurde
     * @see PasswordReset
     */
    function forgotPassword(Request $request, TokenService $tokenService): Response
    {

        $validate = $request->validate([
            "email" => ["required","exists:users,email"]
        ]);

        $password_reset = new PasswordReset();
        $u = User::whereEmail($validate["email"])->firstOrFail();
        $password_reset->user_id = $u->id;

        $password_reset->expiry_date = Carbon::now()->addHour();

        $password_reset->token = $tokenService->createToken(true);
        $password_reset->password_changed = false;
        $password_reset->created_at = Carbon::now();


        $password_reset->save();

        Mail::to($u->email)->send(new PasswordResetEmail($password_reset->token,$u->username));


        return response()->noContent(Response::HTTP_CREATED);
    }

    /**
     * Aktualisiert das Password des Users, welcher mit der PasswordReset Resource verknüpft ist
     * @param String $token Der token der PasswordReset Resource
     * @param Request $request Die aktuelle Request instanz
     * @return Response Code 200, wenn das Password erfolgreich geändert wurde, Code 403, wenn der PasswordReset Link angelaufen ist oder bereits benutzt wurde
     */
    function updatePassword(String $token, Request $request): Response
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
