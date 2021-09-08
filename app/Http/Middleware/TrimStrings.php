<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

/**
 * Konfiguration für die "TrimStrings" funktion
 */
class TrimStrings extends Middleware
{
    /**
     * Attribute, bei denen vorangestellte und nachgestellte Leerzeichen nicht entfernt werden
     *
     * @var array
     */
    protected $except = [
        'current_password',
        'password',
        'password_confirmation',
    ];
}
