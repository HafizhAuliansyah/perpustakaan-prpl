<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Ulasan;
use App\Models\Peminjaman;
use App\Models\RekapPeminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Yajra\DataTables\DataTables;

class PerpustakaanController extends Controller
{
    public function cariBuku(){
        $title = "Cari Buku";
        return view('perpustakaan_cari', ['title' => $title]);
    }

    public function showAll(Request $request){
        if ($request->ajax()) {
            $buku = Buku::orderBy('IDBuku')->get();
            return DataTables::of($buku)
                ->toJson();
            }
    }

    public function ulasan(){
        $title = "Ulasan";
        return view('perpustakaan_ulasan', ['title' => $title]);
    }

    public function saveUlasan(Request $request){
        try{
            Ulasan::create($request->all());
            Log::info('Store ulasan success');
            return redirect()
                ->route('pengunjung.ulasan')
                ->with('Success','Ulasan Created Successfully!');
        } catch(QueryException $err){
            error_log($err->getMessage());
            Log::error('Error at PerpustakaanController@Ulasan :'.$err);
            return redirect()
                ->route('pengunjung.ulasan')
                ->with('Error','Gagal Menyimpan Data Baru');
        }
    }
}
