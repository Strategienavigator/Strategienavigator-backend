<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

/**
 * Middleware um das last_activity Feld des authentifizierten Users auf die aktuelle Uhrzeit zu setzten
 *
 * @see User::$last_activity
 */
class UserLastActivityLog
{
    /**
     * Setzt last_activity des authentifizierten Nutzers auf die aktuelle Uhrzeit
     *
     * @param Request $request Aktuelle Request instanz
     * @param Closure $next Callback um den Request weiterzuverarbeiten
     * @return mixed return value des übergebenen $next callbacks
     */
    public function handle(Request $request, Closure $next)
    {
        $u = $request->user();
        $u->last_activity = Carbon::now();
        $u->save();
        return $next($request);
    }
}
