<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Auth\RegisteredUserController;

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

Route::controller(RegisteredUserController::class)->middleware('auth')->group(function () {
    Route::get('/city/{pref_code}', 'city');
});

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
    Route::get('/post', 'postindex')->name('postindex'); // 投稿の表示
    Route::get('/post/create', 'create')->name('create_post'); // 新規投稿
    Route::post('/post/create', 'store')->name('store_post');
    Route::get('/post/{post}', 'detail')->name('detail'); // 投稿の表示
    Route::delete('/post/{post}/delete', 'delete')->name('delete_post'); // 投稿の削除
    
    Route::get('/post/{post}/edit', 'edit')->name('edit_post'); // 投稿の編集
    Route::put('/post/{post}', 'update')->name('update_post');
    
    Route::get('/action', 'add_action')->name('add_action'); // 作業の追加
    Route::post('/action', 'store_action')->name('store_action');
    
    Route::get('/plant', 'add_plant')->name('add_plant'); // 植物の追加
    Route::post('/plant', 'store_plant')->name('store_plant');
    
    Route::get('/plant/{plant_code}', 'add_plant_variety')->name('add_plant_variety'); // 品種の追加
    Route::post('/plant', 'store_plant_variety')->name('store_plant_variety');
});

Route::controller(CalendarController::class)->middleware(['auth'])->group(function(){
    Route::get('/calendar', 'show')->name('show');// カレンダー表示
    Route::post('/calendar/add_schedule', 'add_schedule')->name('add_schedule'); // 予定の新規追加
    Route::post('/calendar/get_schedule', 'get_schedule')->name("get_schedule"); // DBに登録した予定を取得
    Route::put('/calendar/update', 'update')->name("update"); // 予定の更新
    Route::delete('/calendar/delete', 'delete')->name("delete"); // 予定の削除
});

require __DIR__.'/auth.php';
