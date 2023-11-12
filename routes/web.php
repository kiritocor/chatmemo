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

Route::get('/talk/plan', function () {
    return view('chatmemo.talk_plan');
});

Route::get('/talk/todo', function () {
    return view('chatmemo.talk_todo');
});

Route::get('/talk/think', function () {
    return view('chatmemo.talk_think');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/filter-by-importance', [RecordController::class ,'filterByImportance']);
Route::post('/filter-by-category', [RecordController::class ,'filterByCategory']);

Route::middleware('auth')->group(function () {
    Route::get('/record', [RecordController::class, 'showData'])->name('chatmemo.record');
    
    Route::get('/record/think/{think}', [RecordController::class ,'thinkEdit']);
    Route::get('/record/memo/{memo}', [RecordController::class ,'memoEdit']);
    Route::get('/record/plan/{plan}', [RecordController::class ,'planEdit']);
    Route::get('/record/todo/{todo}', [RecordController::class ,'todoEdit']);
    Route::post('/record/tag/save', [RecordController::class ,'savetag']);
    Route::post('/attach-tag-to-post', [RecordController::class ,'attachTagToPost']);
    Route::delete('/delete-tagpost/{id}', [RecordController::class, 'deleteTagPost']);
    Route::get('/search', [RecordController::class ,'search']);
    Route::get('/chatmemo', [ChatmemoController::class, 'top']);
    Route::post('/fetchDateData', [ChatmemoController::class, 'fetchDateData']);
    Route::post('/updateSorve', [ChatmemoController::class, 'updateSorve']);
    Route::post('/updateunSorve', [ChatmemoController::class, 'updateunSorve']);
    Route::post('/filter-by-unsorve', [ChatmemoController::class ,'filterByunSorve']);
    Route::post('/filter-by-sorve', [ChatmemoController::class ,'filterBySorve']);
Route::post('/save-memo-message', [TalkController::class, 'saveMemoMessage']);
Route::post('/save-plan-message', [TalkController::class, 'savePlanMessage']);
Route::post('/save-todo-message', [TalkController::class, 'saveTodoMessage']);
Route::post('/save-think-message', [TalkController::class, 'saveThinkMessage']);
Route::put('/record/memo/{memo}/update', [EditController::class, 'updateMemoMessage']);
Route::put('/record/think/{think}/update', [EditController::class, 'updateThinkMessage']);
Route::put('/record/plan/{plan}/update', [EditController::class, 'updatePlanMessage']);
Route::put('/record/todo/{todo}/update', [EditController::class, 'updateTodoMessage']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});


require __DIR__.'/auth.php';
