<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatmemoController; 
use App\Http\Controllers\RecordController; 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TalkController;
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

Route::get('/qpage', function () {
    return view('/login');
});

Route::get('/qpage', function () {
    return view('chatmemo.qpage');
});

Route::get('/talk/memo', function () {
    return view('chatmemo.talk_memo');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/record', [RecordController::class, 'showData'])->name('chatmemo.record');
    
    Route::get('/chatmemo', [ChatmemoController::class, 'top']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

Route::post('/save-message', [TalkController::class, 'saveMessage'])->name('save-message');

require __DIR__.'/auth.php';
