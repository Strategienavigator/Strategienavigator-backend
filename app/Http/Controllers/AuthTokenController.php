<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;

class AuthTokenController extends Controller
{
    /**
     * @param string $token_id
     * @param TokenRepository $tokenRepository
     * @param RefreshTokenRepository $refreshTokenRepository
     * @return Response
     * @throws AuthorizationException
     */
    public function delete(string $token_id, TokenRepository $tokenRepository, RefreshTokenRepository $refreshTokenRepository)
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
