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
Route::get('/poll/{id}', [App\Http\Controllers\PollController::class, 'show'])->name('single-poll');

Route::post('/poll', [App\Http\Controllers\PollController::class, 'submitPoll'])->name('submit-poll');


Route::get('/poll-results/{id}', [App\Http\Controllers\PollController::class, 'showResults'])->name('poll-results');


// Admin routes

Route::get('/login', [App\Http\Controllers\AdminController::class, 'index'])->name('login');
