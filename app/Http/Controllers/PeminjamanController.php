<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Member;
use App\Models\Buku;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $peminjaman = Peminjaman::all();
            return DataTables::of($peminjaman)->toJson();
        }
        return view('peminjaman.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bukus = Buku::all();
        $members = Member::all();
        return view('peminjaman.create', compact('bukus', 'members'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $peminjaman = new Peminjaman();
        try{
            $PeminjamanList = Peminjaman::where('IDPeminjaman', 'LIKE', date('dmY'))->get();
            $PeminjamanCount = $PeminjamanList->count() + 1;
            if($PeminjamanCount < 10){
                $peminjaman->IDPeminjaman = 'D'.date('dmY').'0'.$PeminjamanCount;
            }
            else{
                $peminjaman->IDPeminjaman = 'D'.date('dmY').$PeminjamanCount;
            }
        }catch(QueryException $err){
            $peminjaman->IDPeminjaman = 'D'.date('dmY').'01';
        }
        $peminjaman->IDBuku = $request->IDBuku;
        $peminjaman->NIK = $request->NIK;
        $peminjaman->TglPeminjaman = date('Y-m-d');
        $peminjaman->StatusPeminjaman = 'belum kembali';
        $peminjaman->TglPengembalian = $request->TglPengembalian;
        $peminjaman->save();
        return redirect()->route('peminjaman.index')
           ->with('success_message', 'Berhasil melakukan peminjaman');
        // try{

        // }catch(QueryException $err){
        //     error_log($err->getMessage());
        //     return redirect()
        //         ->route('peminjaman.create')
        //         ->with($err->getMessage());
        //         // ->with('Error','Gagal membuat peminjaman buku');
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
