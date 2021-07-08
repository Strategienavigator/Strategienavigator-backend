<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;
use Laravel\Passport\RouteRegistrar;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        if(! $this->app->routesAreCached()){
            Passport::routes(function(RouteRegistrar $router){
                // manuelle registrierung, da die restlichen nicht benötigt werden
                Route::post('/token', [
                    'uses' => 'AccessTokenController@issueToken',
                    'as' => 'passport.token',
                    'middleware' => 'throttle',
                ]);
            });
        }

        //
    }
}
