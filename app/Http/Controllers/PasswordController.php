<?php

namespace App\Http\Controllers;

use App\Models\PasswordReset;
use App\Models\User;
use App\Services\TokenService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PasswordController extends Controller
{
    //
    function forgotPassword(Request $request) {
        $tokenService = new TokenService();

        $validate = $request->validate([
            "username" => "required|exists:users,username"
        ]);

        $password_reset = new PasswordReset();
        $password_reset->user_id = User::where('username', '=', $validate["username"])->firstOrFail()->id;

        // TODO Ablaufzeit festlegen
        $password_reset->expiry_date = "2022-07-16";

        $password_reset->token = $tokenService->createToken();
        $password_reset->password_changed = false;

        $password_reset->save();

        // TODO Email versenden implementieren


        return response()->noContent(Response::HTTP_OK);
    }

    function updatePassword(Request $request) {

        $validate = $request->validate([
            "password" => "required|string"
        ]);

        $password_reset = PasswordReset::where('token', '=', $request->token)->firstOrFail();

        if (date('Y-m-d') < $password_reset->expiry_date && $password_reset->password_changed == false) {

            $user = User::findOrFail($password_reset->user_id);

            // TODO Wie wird das Passwort übermittelt?
            $user->password = $validate["password"];
            $password_reset->password_changed = true;
            $password_reset->save();
            $user->save();
            return response()->noContent(Response::HTTP_OK);
        } else {
            return response()->noContent(Response::HTTP_FORBIDDEN);
        }

    }

}
