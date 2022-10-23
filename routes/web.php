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
    Route::get('/all-buku', 'show');
    Route::get('/add-buku', 'addView');
    Route::post('/add-buku', 'store');
    Route::get('/edit-buku', 'editView');
    Route::patch('/edit-buku', 'update');
    Route::delete('/add-buku', 'delete');
});
