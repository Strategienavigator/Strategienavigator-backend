<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

/**
 * Identifiziert den aktuellen User und überprüft ob der Access-Token Valide ist
 * @package App\Http\Middleware
 */
class Authenticate extends Middleware
{
    /**
     * Führt die Weiterleitung durch, wenn kein User angemeldet ist
     *
     * @param Request $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return config("frontend.url");
        }
    }
}
