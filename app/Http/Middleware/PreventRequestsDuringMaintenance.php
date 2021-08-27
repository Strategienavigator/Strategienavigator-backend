<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

/**
 * Klasse zum Steuern des Wartungsmodus
 * @package App\Http\Middleware
 */
class PreventRequestsDuringMaintenance extends Middleware
{
    /**
     * Routen, welche während Wartungsarbeiten erreichbar sein sollen
     *
     * @var array
     */
    protected $except = [
        //
    ];
}
