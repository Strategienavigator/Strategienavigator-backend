<?php

namespace App\Providers;

use App\Console\Commands\PurgeAnonymousUsersCommand;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

/**
 * @ignore
 */
class AppServiceProvider extends ServiceProvider
{

    public $singletons = [

    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ResponseFactory::macro('created', function (string $route_name, Model $model): Response {
            return \Illuminate\Support\Facades\Response::noContent(
                Response::HTTP_CREATED,
                ['Location' => route($route_name . '.show', $model->id, false)]);
        });



    }
}
