<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\SearchController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::controller(ProfileController::class)->middleware('auth')->group(function () {
    Route::get('/profile', 'edit')->name('profile.edit');
    Route::patch('/profile', 'update')->name('profile.update');
    Route::delete('/profile', 'destroy')->name('profile.destroy');
});


Route::controller(HomeController::class)->middleware('auth')->group(function () {
    Route::get('/', 'homeindex')->name('homeindex');
});

Route::controller(SearchController::class)->middleware(['auth'])->group(function(){
    Route::get('/search', 'searchindex')->name('searchindex');
});

Route::controller(PostController::class)->middleware(['auth'])->group(function(){
    Route::get('/post', 'postindex')->name('postindex');
    Route::get('/post/add_post', 'add_post')->name('add_post');
});

Route::controller(CalendarController::class)->middleware(['auth'])->group(function(){
    Route::get('/calendar', 'test')->name('show');
    //Route::get('/calendar', 'show')->name('show');// カレンダー表示
    Route::post('/calendar/add_schedule', 'add_schedule')->name('add_schedule'); // 予定の新規追加
    Route::post('/calendar/get_schedule', 'get_schedule')->name("get_schedule"); // DBに登録した予定を取得
    
});

require __DIR__.'/auth.php';
