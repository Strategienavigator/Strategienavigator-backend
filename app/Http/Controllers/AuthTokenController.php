<?php

namespace App\Http\Controllers;

use App\Policies\AuthTokenPolicy;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;

class AuthTokenController extends Controller
{

    /**
     * Löscht den gegebenen Access token und alle zugehörigen refreshtoken aus der datenbank
     *
     * @param string $token_id id des Token
     * @param TokenRepository $tokenRepository Dependency Injection
     * @param RefreshTokenRepository $refreshTokenRepository Dependency Injection
     * @return Response Code 200 beim erfolgreicher löschen
     * @throws AuthorizationException|ModelNotFoundException Wenn der Token nicht existiert oder der User nicht autorisiert ist.
     * @see AuthTokenPolicy::delete()
     */
    public function delete(string $token_id, TokenRepository $tokenRepository, RefreshTokenRepository $refreshTokenRepository): Response
    {
        $t = $tokenRepository->find($token_id);
        if ($t) {
            $this->authorize("delete", $t);
            $tokenRepository->revokeAccessToken($token_id);
            $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($token_id);

            return response()->noContent(Response::HTTP_OK);
        } else {
            $exception = new ModelNotFoundException();
            $exception->setModel("Token", $token_id);
            throw $exception;
        }

    }
}
