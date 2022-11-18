<?php

use App\Http\Controllers\BukuController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UlasanController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\DendaController;
use App\Http\Controllers\PerpustakaanController;

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
Route::get('/perpustakaan/cari-buku', [PerpustakaanController::class, 'cariBuku'])->name('pengunjung.cari');
Route::get('/perpustakaan/all-buku', [PerpustakaanController::class, 'showAll'])->name('pengunjung.all_buku');
Route::get('/perpustakaan/ulasan', [PerpustakaanController::class, 'ulasan'])->name('pengunjung.ulasan');
Route::post('/perpustakaan/ulasan', [PerpustakaanController::class, 'saveUlasan'])->name('pengunjung.save.ulasan');

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

Route::middleware('auth')->group(function(){
    Route::controller(BukuController::class)->group(function(){
        Route::prefix('buku')->group(function(){
            Route::get('/all', 'showPart')->name('all_buku');
            Route::get('/all/part', 'showPart')->name('part-buku');
            Route::get('/add', 'addView')->name('view_add_buku');
            Route::post('/store', 'store')->name('store_buku');
            Route::get('/update/{buku}', 'editView')->name('view_edit_buku');
            Route::patch('/update/{buku}', 'update')->name('edit_buku');
            Route::delete('/delete/{buku}', 'delete')->name('delete_buku');
            // PDF Export
            Route::get('/buku/pdf', 'exportPDF')->name('export_buku');
        });
    });
});

Route::controller(DendaController::class)->group(function(){
    Route::get('/denda/all', 'showPart')->name('all_denda');
    Route::get('/denda/all/part', 'showPart')->name('part-denda');
    Route::get('/denda/add', 'addView')->name('view_add_denda');
    Route::post('/denda/add', 'store')->name('add_denda');
    Route::get('/denda/update/{denda}', 'editView')->name('view_edit_denda');
    Route::patch('/denda/update/{denda}', 'update')->name('edit_denda');
});
// Route::middleware('auth')->group(function () {
//     Route::controller(MemberController::class)->group(function(){
//         Route::get('member/index', 'index')->name('index_member');
//     });
// });

Route::resource('member', MemberController::class)->middleware('auth');

Route::resource('peminjaman', PeminjamanController::class)->middleware('auth');

