<?php

use App\Http\Controllers\api\VotesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\DashboardController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/events', EventsController::class, ['names' => 'event']);
Route::post('/events/{id}/question', [QuestionsController::class, 'store'])->name('question_store');
Route::get('/events/{event_id}/question/answered/{question_id}', [QuestionsController::class, 'answered'])->name('question_answered');
Route::get('/events/{event_id}/question/not_answered/{question_id}', [QuestionsController::class, 'not_answered'])->name('question_not_answered');
Route::post('/events/{event_id}/update/{question_id}', [QuestionsController::class, 'update'])->name('question_update');
Route::get('/events/{event_id}/edit/{question_id}', [QuestionsController::class, 'edit'])->name('question_edit');
Route::get('/events/{event_id}/delete/{question_id}', [QuestionsController::class, 'delete'])->name('question_delete');

Route::get('/api/vote', [VotesController::class, 'vote']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
