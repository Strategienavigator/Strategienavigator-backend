<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
        ResponseFactory::macro('created', function (string $route_name, Model $model):Response {
            return \Illuminate\Support\Facades\Response::noContent(
                Response::HTTP_CREATED,
                ['Location' => route($route_name . '.show', $model->id,false)]);
        });

    }
}
