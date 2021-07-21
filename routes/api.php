<?php

use App\Http\Controllers\InvitationLinkController;
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
Route::group(["middleware" => "auth:api"], function () {
    Route::apiResources([
        "tools" => ToolController::class,
        "saves" => SaveController::class,
        "invitation_link" => InvitationLinkController::class,
    ]);


    // contributors
    Route::apiResource("contribution", SharedSaveController::class, [
        "except" => ["store"]
    ])->parameter("contribution","sharedSave");
    Route::post("/saves/{save}/contributors/{user}", [SharedSaveController::class, "store"])->name("contribution.store");
    Route::post("/users/{user}/contributions/{save}", [SharedSaveController::class, "storeReverse"])->name("contribution.store");


    // Users
    Route::get('users/{user}/saves', 'App\Http\Controllers\UserSavesController@index');
    Route::get("checkUsername", 'App\Http\Controllers\UserController@checkUsername');
    Route::apiResource('users', UserController::class);
});


