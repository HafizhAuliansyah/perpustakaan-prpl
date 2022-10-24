<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UlasanController;

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
    return redirect('home');
});

Route::controller(UlasanController::class)->group(function(){
    Route::get('/ulasan/all', 'index')->name('all_ulasan');
    Route::get('/ulasan/add', 'addView')->name('view_add_ulasan');
    Route::post('/ulasan/add','store')->name('add_ulasan');
    Route::delete('/ulasan/delete/{ulasan}','destroy');
});

Auth::routes();

Route::resource('users', UserController::class)
    ->middleware('auth');

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');
