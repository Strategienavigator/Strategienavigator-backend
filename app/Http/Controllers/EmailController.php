<?php

namespace App\Http\Controllers;

use App\Models\EmailVerification;
use App\OpenApi\Parameters\LimitableParameters;
use App\OpenApi\Responses\NotFoundResponse;
use App\OpenApi\Responses\OkResponse;
use App\OpenApi\Responses\UnauthenticatedResponse;
use App\OpenApi\Responses\UnauthorizedResponse;
use App\OpenApi\Responses\UserListResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use Vyuldashev\LaravelOpenApi\Attributes\Operation;
use Vyuldashev\LaravelOpenApi\Attributes\Parameters;
use Vyuldashev\LaravelOpenApi\Attributes\PathItem;

/**
 * Controller welche funktionen für die Routen der E-Mail Verifikation implementiert.
 */
#[PathItem]
class EmailController extends Controller
{

    /**
     * Übernimmt die E-Mail aus der EmailVerification-Tabelle in die User-Tabelle
     * @param string $token token des E-Mail verifikation Prozesses
     * @return Response Code 200 bei erfolgreicher Übernahme
     */
    #[Operation(tags: ['email'])]
    #[\Vyuldashev\LaravelOpenApi\Attributes\Response(OkResponse::class, statusCode: 200)]
    #[\Vyuldashev\LaravelOpenApi\Attributes\Response(NotFoundResponse::class, statusCode: 404)]
    function verify(string $token): Response
    {

        $email_verification = EmailVerification::whereToken($token)->firstOrFail();
        $user = $email_verification->user;
        $user->email_verified_at = Carbon::now();
        $user->email = $email_verification->email;
        $user->save();


        return response()->noContent(ResponseAlias::HTTP_OK);
    }
}
