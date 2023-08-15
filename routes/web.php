<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
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
Route::get('/test/personality', [App\Http\Controllers\PersonalityTestController::class, 'index'])->name('personality-test');




Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/dashboard',[AdminController::class, 'addAccount'])->name('admin.add-acount');
    Route::get('/admin-list',[AdminController::class, 'seeAdminList'])->name('admin.list');
    Route::get('/new-poll',[AdminController::class, 'newPoll'])->name('admin.new-poll');
    Route::post('/new-poll',[AdminController::class,'createPoll'])->name('create-poll');
    Route::get('/polls-list',[AdminController::class, 'seePollsList'])->name('polls-list');


});

require __DIR__.'/auth.php';
