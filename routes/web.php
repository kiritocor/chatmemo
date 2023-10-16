<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatmemoController; 
use App\Http\Controllers\RecordController; 
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TalkController;
use App\Http\Controllers\EditController;
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
    return view('auth.login');
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
    
    Route::get('/record/think/{think}', [RecordController::class ,'thinkEdit']);
    Route::get('/record/memo/{memo}', [RecordController::class ,'memoEdit']);
    Route::get('/record/plan/{plan}', [RecordController::class ,'planEdit']);
    Route::get('/record/todo/{todo}', [RecordController::class ,'todoEdit']);
    Route::get('/chatmemo', [ChatmemoController::class, 'top']);
    Route::post('/save-memo-message', [TalkController::class, 'saveMemoMessage']);
Route::post('/save-plan-message', [TalkController::class, 'saveplanMessage']);
Route::post('/save-todo-message', [TalkController::class, 'savetodoMessage']);
Route::post('/save-think-message', [TalkController::class, 'saveThinkMessage']);
Route::put('/record/memo/{memo}/update', [EditController::class, 'updateMessage']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});


require __DIR__.'/auth.php';
