<?php

namespace App\Http\Controllers;

use App\Models\EmailVerification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EmailController extends Controller
{
    //

    function verify(Request $request) {

        $email_verification = EmailVerification::where('token', '=', $request->token)->firstOrFail();
        $user = $email_verification->user;
        $user->email_verified_at = date('Y-m-d');
        $user->email = $email_verification->email;
        $user->save();


        return response()->noContent(Response::HTTP_OK);
    }
}
