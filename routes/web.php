<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App\Http\Controllers\PollController::class, 'index'])->name('show-poll');

Route::post('/', [App\Http\Controllers\PollController::class, 'submitPoll'])->name('submit-poll');
Route::get('/poll-results', [App\Http\Controllers\PollController::class, 'showResults'])->name('poll-results');

