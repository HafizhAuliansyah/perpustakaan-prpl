<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
            Log::info('Showed part Data Buku');
            return DataTables::of($buku)
                ->toJson();
            }
    }
    public function ulasan(){

    }
}
