<?php

use App\Http\Controllers\BukuController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Auth::routes();

Route::resource('users', UserController::class)
    ->middleware('auth');

Route::get('/home', function() {
    return view('home');
})->name('home')->middleware('auth');

Route::controller(BukuController::class)->group(function(){
    Route::get('/buku/all', 'show');
    Route::get('/buku/all/part', 'showPart');
    Route::get('/buku/add', 'addView');
    Route::post('/buku/add', 'store');
    Route::get('/buku/update', 'editView');
    Route::patch('/buku/update/{buku}', 'update');
    Route::delete('/buku/delete/{buku}', 'delete');
});
