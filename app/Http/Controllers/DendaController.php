<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Denda;
use App\Models\Peminjaman;
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
    public function addView()
    {
        $new_id = DendaHelper::generateDendaID();
        return view('denda.add-denda', ['new_id' => $new_id]);
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
            $denda->NIK = $request->NIK;
            if($request->Keterangan === "Tenggat Peminjaman"){
                $peminjaman = Peminjaman::find($request->IDPeminjaman);
                if($peminjaman){
                    $now = Carbon::now();
                    $pengembalian = Carbon::parse($peminjaman->TglPengembalian);
                    $diff = $pengembalian->floatDiffInWeeks($now);
                    $denda->Nominal = $diff*10000;
                    $denda->IDPeminjaman = $request->IDPeminjaman;
                } else{
                    return redirect()
                        ->route('view_add_denda')
                        ->with('Error', 'Data Peminjaman Tidak Ada!');
                }
            }else {
                $denda->IDPeminjaman = null;
                $denda->Nominal = $request->Nominal;
            }
            $denda->Keterangan = $request->Keterangan;
            $denda->Status = $request->Status;
            $denda->save();
            Log::info('Data Denda Created : '.$denda->IDDenda);
            return redirect()
                ->route('view_add_denda')
                ->with('Success','Berhasil Menyimpan Data Baru');
        }catch(QueryException $err){
            Log::error('Error in DendaController at store: '.$err->getMessage());
            return redirect()
                ->route('view_add_denda')
                ->with('Error', 'Gagal Menyimpan Data Baru');
        }
    }

    public function editView(Denda $denda){
        return view('denda.edit-denda', ['denda' => $denda]);
    }

    public function update(Denda $denda, Request $request){
        try{
            if($request->NIK)
                $denda->NIK = $request->NIK;
            if($request->Keterangan)
                $denda->Keterangan = $request->Keterangan;
            if($request->Status)
                $denda->Status = $request->Status;
            if($request->Nominal)
                $denda->Nominal = $request->Nominal;
            $denda->save();
            Log::info('Updated Data Denda : '.$denda->IDDenda);
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
