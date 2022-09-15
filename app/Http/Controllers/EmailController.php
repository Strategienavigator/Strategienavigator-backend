<?php

namespace App\Http\Controllers;

use App\Models\EmailVerification;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * Controller welche funktionen für die Routen der E-Mail Verifikation implementiert.
 */
class EmailController extends Controller
{

    /**
     * Übernimmt die E-Mail aus der EmailVerification-Tabelle in die User-Tabelle
     * @param string $token token des E-Mail verifikation Prozesses
     * @return JsonResponse Code 200 bei erfolgreicher Übernahme
     */
    function verify(string $token): JsonResponse
    {
        $email_verification = EmailVerification::whereToken($token)->firstOrFail();
        $user = $email_verification->user;
        $user->email_verified_at = Carbon::now();
        $user->email = $email_verification->email;
        $user->save();

        return response()->json([
            "email" => $email_verification->email
        ], Response::HTTP_OK);
    }
}
