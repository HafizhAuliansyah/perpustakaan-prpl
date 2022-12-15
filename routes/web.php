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
Route::controller(PerpustakaanController::class)->group(function(){
    Route::prefix('perpustakaan')->group(function(){
        Route::get('/cari-buku', [PerpustakaanController::class, 'cariBuku'])->name('pengunjung.cari');
        Route::get('/all-buku', [PerpustakaanController::class, 'showAll'])->name('pengunjung.all_buku');
        Route::get('/ulasan', [PerpustakaanController::class, 'ulasan'])->name('pengunjung.ulasan');
        Route::post('/ulasan', [PerpustakaanController::class, 'saveUlasan'])->name('pengunjung.save.ulasan');
    });
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
            Route::get('/detail/{buku}', 'detail')->name('detail_buku');
            Route::patch('/update/{buku}', 'update')->name('edit_buku');
            Route::delete('/delete/{buku}', 'delete')->name('delete_buku');
            // Get data buku as json
            Route::get('/get-ajax-buku/{buku}', 'getAjaxBuku')->name('ajax_buku');
            // PDF Export
            Route::post('/pdf', 'exportPDF')->name('export_buku');
        });
    });
    Route::controller(UlasanController::class)->group(function(){
        Route::get('/ulasan/all', 'index')->name('all_ulasan');
        Route::get('/ulasan/add', 'addView')->name('view_add_ulasan');
        Route::post('/ulasan/add','store')->name('add_ulasan');
        Route::delete('/ulasan/delete/{ulasan}','destroy');
    });
    Route::controller(DendaController::class)->group(function(){
        Route::get('/denda/all', 'showPart')->name('all_denda');
        Route::get('/denda/all/part', 'showPart')->name('part-denda');
        Route::get('/denda/add/{IDPeminjaman}', 'addView')->name('view_add_denda');
        Route::post('/denda/add', 'store')->name('add_denda');
        Route::get('/denda/update/{denda}', 'editView')->name('view_edit_denda');
        Route::patch('/denda/update/{denda}', 'update')->name('edit_denda');
    });
    Route::resource('member', MemberController::class);
    Route::controller(MemberController::class)->group(function(){
        Route::prefix('member')->group(function(){
            Route::get('/','index')->name('member.index');
            Route::get('/create', 'create')->name('member.create');
            Route::post('/store', 'store')->name('member.store');
            Route::get('/edit/{id}','edit')->name('member.edit');
            Route::put('/update/{id}','update')->name('member.update');
            Route::delete('/delete','destroy')->name('member.destroy');
            // Get data member as json
            Route::get('/get-ajax-member/{member}', 'getAjaxMember')->name('ajax_member');
        });
    });
    // PDF Export
    Route::post('member/pdf', [MemberController::class, 'exportPDF'])->name('export_member');
    Route::controller(PeminjamanController::class)->group(function(){
        Route::prefix('peminjaman')->group(function(){
            Route::get('/', 'index')->name('peminjaman.index');
            Route::get('/create', 'create')->name('peminjaman.create');
            Route::post('/store', 'store')->name('peminjaman.store');
            Route::get('/show', 'show')->name('peminjaman.show');
            Route::get('/edit/{id}', 'edit')->name('peminjaman.edit');
            Route::put('/update/{id}', 'update')->name('peminjaman.update');
            Route::delete('/delete', 'delete')->name('peminjaman.delete');
            Route::get('/warningmail', 'warningmail')->name('peminjaman.warningmail');
        });
    });
    // Route::resource('peminjaman', PeminjamanController::class);
});

// Route::middleware('auth')->group(function () {
//     Route::controller(MemberController::class)->group(function(){
//         Route::get('member/index', 'index')->name('index_member');
//     });
// });


Route::get('/send-email-queue', function(){
    $details['email'] = 'williamshakespear000@gmail.com';
    $details['name'] = 'William Shakespear';

    dispatch(new App\Jobs\WelcomeEmailJob($details));
    return response()->json(['message' => 'Mail Send Successfully!!']);
});
