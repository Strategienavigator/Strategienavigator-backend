<?php

namespace App\Providers;

use App\Http\Controllers\AuthTokenController;
use App\Policies\AuthTokenPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;
use Laravel\Passport\RouteRegistrar;
use Laravel\Passport\Token;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Nicht implizierte Policy Zuweisungen
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Token::class => AuthTokenPolicy::class
    ];

    /**
     * Registriert die nötigen passport routen.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        if (!$this->app->routesAreCached()) {
            Passport::routes(function (RouteRegistrar $router) {
                // manuelle registrierung, da die restlichen nicht benötigt werden
                Route::post('/token', [
                    'uses' => 'AccessTokenController@issueToken',
                    'as' => 'passport.token',
                    'middleware' => 'throttle',
                ]);

                Route::delete('/token/{token_id}', [AuthTokenController::class, 'delete'])
                    ->middleware('auth:api')
                    ->name('passport.token.delete');
            });
        }

        //
    }
}
