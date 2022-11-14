<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class PerpustakaanController extends Controller
{
    public function cariBuku(){
        $title = "Cari Buku";
        return view('perpustakaan_cari', ['title' => $title]);
    }
    public function showAll(Request $request){
        if ($request->ajax()) {
            $buku = Buku::orderBy('IDBuku')->get();
            Log::info('Showed part Data Buku');
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
            return redirect()->route('pengunjung.ulasan')
                            ->with('success','Ulasan Created Successfully!');
        } catch(QueryException $err){
            error_log($err->getMessage());
            Log::error('Error at UlasanController :'.$err);
            return redirect()
                ->route('pengunjung.ulasan')
                ->with('Error','Gagal Menyimpan Data Baru');
        }
    }
}
