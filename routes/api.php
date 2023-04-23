<?php

use App\Http\Controllers\Api\Mobile\Auth\AuthController;
use App\Http\Controllers\Api\Mobile\Event\EventController;
use App\Http\Controllers\Api\Mobile\Question\QuestionController;
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

Route::post("/login", [AuthController::class, "login"]);
Route::post("/register", [AuthController::class, "register"]);



Route::middleware('auth:sanctum')->post('/question/create/{id}', [QuestionController::class, "store"]);
Route::middleware('guest')->post('/question/anon_create/{id}', [QuestionController::class, "store"]);

Route::middleware('auth:sanctum')->post('/question/vote/{id}', [QuestionController::class, "vote"]);
Route::middleware('guest')->post('/question/anon_vote/{id}', [QuestionController::class, "vote"]);

Route::post("/question/report/{event_id}/{question_id}", [QuestionController::class, "report"]);

Route::prefix('anon-event')->group(function () {
    Route::post("/list", [EventController::class, "list"]);
    Route::post("/show/{id}", [EventController::class, "show"]);
});


Route::group(["middleware" => ["auth:sanctum"]], function(){

    Route::post("/splash", [AuthController::class, "loginCheck"]);

    Route::prefix('event')->group(function () {
        Route::post("/create", [EventController::class, "store"]);
        Route::post("/update/{id}", [EventController::class, "update"]);
        Route::post("/delete/{id}", [EventController::class, "delete"]);
    });

    Route::prefix('question')->group(function () {
        Route::post("/answered/{event_id}/{question_id}", [QuestionController::class, "answered"]);
    });

    Route::post("/logout", [AuthController::class, "logout"]);
});

Route::group(["middleware" => ["auth:sanctum", "guest"]], function() {

    Route::prefix('event')->group(function () {
        Route::post("/list", [EventController::class, "list"]);
        Route::post("/show/{id}", [EventController::class, "show"]);
    });

});
