<?php

use App\Http\Controllers\SaveController;
use App\Http\Controllers\SharedSaveController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group(["middleware"=>"auth:api"],function (){
    Route::apiResources([
        "tools"=>ToolController::class,
        "saves"=>SaveController::class,
        "users"=>UserController::class,
    ]);
    Route::get('users/{user}/saves','App\Http\Controllers\UserSavesController@index');
});


