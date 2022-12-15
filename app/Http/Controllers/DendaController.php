<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Denda;
use App\Models\Peminjaman;
use App\Models\Buku;
use App\Helpers\DendaHelper;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;


class DendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showAll()
    {
        return view('denda.all-denda', [
            'datas' =>Denda::orderBy('IDDenda')->get()
        ]);
    }

    public function showPart(Request $request){
        if ($request->ajax()){
            $denda = Denda::all();
            return DataTables::of($denda)
                ->addColumn('action', function ($row) {
                    $html = '<a href='.route('view_edit_denda', $row->IDDenda).' class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                    <i class="fa fa-lg fa-fw fa-pen"></i>
                    </a>';
                    return $html;
                })
                ->toJson();
            }
        return view('denda.all-denda');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function addView($IDPeminjaman)
    {
        $new_id = DendaHelper::generateDendaID();
        $peminjamans = Peminjaman::where('StatusPeminjaman', 'belum kembali')->get();
        return view('denda.add-denda', ['new_id' => $new_id, 'IDPeminjaman' => $IDPeminjaman]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $denda = new Denda();
            $denda->IDDenda = $request->IDDenda;
            $peminjaman = Peminjaman::find($request->IDPeminjaman);
            $buku = Buku::find($peminjaman->IDBuku);
            if($request->Keterangan == "telat pengembalian"){
                if($peminjaman){
                    $now = Carbon::now();
                    $pengembalian = Carbon::parse($peminjaman->TglPengembalian);
                    $diff = $now->floatDiffInDays($pengembalian, false);
                    if($diff > 0){
                        Log::error('Error in DendaController at store: Data Peminjaman Tidak Ada');
                        return redirect()
                            ->route('view_add_denda', $request->IDPeminjaman)
                            ->with('Error', 'Belum Lewat Tenggat Pengembalian!');
                    }
                    $denda->Nominal = abs(ceil($diff*2000));
                    $denda->IDPeminjaman = $request->IDPeminjaman;
                } else{
                    Log::error('Error in DendaController at store: Data Peminjaman Tidak Ada');
                    return redirect()
                        ->route('view_add_denda',$request->IDPeminjaman)
                        ->with('Error', 'Data Peminjaman Tidak Ada!');
                }
            }else if ($request->Keterangan == "menghilangkan buku") {
                $buku->StatusBuku = 'Hilang';
                $denda->Nominal = $request->Nominal;
                $buku->save();
            } else if ($request->Keterangan == "merusak buku"){
                $buku->StatusBuku = 'Rusak';
                $denda->Nominal = $request->Nominal;
                $buku->save();
            }
            $denda->IDPeminjaman = $request->IDPeminjaman;
            $denda->Keterangan = $request->Keterangan;
            $denda->Status = $request->Status;
            $denda->save();
            return redirect()
                ->route('all_denda')
                ->with('Success','Berhasil Menyimpan Data Baru');
        }catch(QueryException $err){
            Log::error('Error in DendaController at store: '.$err->getMessage());
            return redirect()
                ->route('view_add_denda', $request->IDPeminjaman)
                ->with('Error', 'Gagal Menyimpan Data Baru');
        }
    }

    public function editView(Denda $denda){
        return view('denda.edit-denda', ['denda' => $denda]);
    }

    public function update(Denda $denda, Request $request){
        try{
            if($request->Keterangan)
                $denda->Keterangan = $request->Keterangan;
            if($request->Status)
                $denda->Status = $request->Status;
            if($request->Nominal)
                $denda->Nominal = $request->Nominal;
            $denda->save();
            return redirect()
                ->route('all_denda')
                ->with('Success','Berhasil Mengubah Data denda');
        }catch(QueryException $err){
            Log::error('Error in DendaController at update : '.$err->getMessage());
            error_log($err->getMessage());
            return redirect()
                ->route('view_edit_denda', $denda)
                ->with('Error','Gagal Mengedit Data Denda');
        }
    }
}
