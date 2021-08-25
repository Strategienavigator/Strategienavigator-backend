<?php

namespace App\Http\Controllers;

use App\Models\EmailVerification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class EmailController extends Controller
{
    //

    /**
     * @param Request $request
     * @return Response
     */
    function verify(Request $request): Response
    {

        $email_verification = EmailVerification::where('token', '=', $request->token)->firstOrFail();
        $user = $email_verification->user;
        $user->email_verified_at = Carbon::now();
        $user->email = $email_verification->email;
        $user->save();


        return response()->noContent(ResponseAlias::HTTP_OK);
    }
}
