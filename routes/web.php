<?php

use App\Http\Controllers\BukuController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MemberController;

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

Route::middleware('auth')->group(function(){
    Route::controller(BukuController::class)->group(function(){
        Route::get('/buku/all', 'show')->name('all_buku');
        Route::get('/buku/all/part', 'showPart');
        Route::get('/buku/add', 'addView')->name('view_add_buku');
        Route::post('/buku/add', 'store')->name('add_buku');
        Route::get('/buku/update/{buku}', 'editView')->name('view_edit_buku');
        Route::patch('/buku/update/{buku}', 'update')->name('edit_buku');
        Route::delete('/buku/delete/{buku}', 'delete');
    });
});

// Route::middleware('auth')->group(function () {
//     Route::controller(MemberController::class)->group(function(){
//         Route::get('member/index', 'index')->name('index_member');
//     });
// });

Route::resource('member', MemberController::class)
    ->middleware('auth');
