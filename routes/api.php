<?php

use App\Http\Controllers\InvitationLinkController;
use App\Http\Controllers\SaveController;
use App\Http\Controllers\SharedSaveController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\UserController;
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

//User
Route::apiResource('users', UserController::class)->only('store');
Route::post('users/anonymous', [UserController::class,"storeAnonymous"]);

Route::group(["middleware" => ["auth:api","activityLog"]], function () {
    Route::apiResources([
        "tools" => ToolController::class,
        "saves" => SaveController::class,
        "invitation-link" => InvitationLinkController::class,
    ]);


    // contributors
    Route::apiResource("contribution", SharedSaveController::class, [
        "except" => ["store"]
    ])->parameter("contribution", "sharedSave");
    Route::put("/contribution/{sharedSave}/accept", [SharedSaveController::class, "accept"]);
    Route::put("/contribution/{sharedSave}/decline", [SharedSaveController::class, "decline"]);

    Route::get("/saves/{save}/contributors", [SharedSaveController::class, "indexSave"])->name("contributions.index.save");
    Route::post("/saves/{save}/contributors/{user}", [SharedSaveController::class, "store"])->name("contribution.store.save");
    Route::post("/users/{user}/contributions/{save}", [SharedSaveController::class, "storeReverse"])->name("contribution.store.user");


    // Users
    Route::get('users/{user}/saves', 'App\Http\Controllers\UserSavesController@index');
    Route::get("checkUsername", 'App\Http\Controllers\UserController@checkUsername');

    Route::apiResource('users', UserController::class)->except('store');

    // InvitationLink
    Route::get('invitation-link/save/{save}', 'App\Http\Controllers\InvitationLinkController@saveIndex');
    Route::get('invitation-link/{token}/accept', 'App\Http\Controllers\InvitationLinkController@acceptInvite');

    // PasswordReset
    Route::get('password-reset/{token}', 'App\Http\Controllers\PasswordController@show');
    Route::post('password-reset', 'App\Http\Controllers\PasswordController@forgotPassword');
    Route::put('password-reset/{token}', 'App\Http\Controllers\PasswordController@updatePassword');


});


//Email
Route::put('email/verify/{token}', 'App\Http\Controllers\EmailController@verify');


// DEBUG
Route::get('password-template', function () {
    return view('password-reset', ['token' => 'TEST_TOKEN']);
});
Route::get('email-template', function () {
    return view('email-verification', ['token' => 'TEST_TOKEN']);
});
Route::get('invitation-template', function () {
    return view('save-invitation', ['invite_user' => 'Tester', 'token' => 'TEST_TOKEN']);
});
