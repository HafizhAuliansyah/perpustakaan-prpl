<?php

namespace App\Http\Controllers;

use App\Jobs\PeringatanPeminjamanMail;
use App\Models\Peminjaman;
use App\Models\Member;
use App\Models\Buku;
use App\Models\Denda;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

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
            return DataTables::of($peminjaman)
            ->addColumn('action', function ($row) {
                $html = '<div class="row"><a href='.route('peminjaman.edit',$row->IDPeminjaman).' class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                <i class="fa fa-lg fa-fw fa-pen"></i>
                </a>
                <a href='.route('view_add_denda',$row->IDPeminjaman).' class="btn btn-xs btn-default text-danger mx-1 shadow" title="Denda">
                <i class="fas fa-lg fa-fw fa-file-invoice-dollar"></i>
                </a></div>';
                // $html.= '<a href='.route('peminjaman.destroy', $row->IDPeminjaman).' class="btn btn-xs btn-default text-success mx-1 shadow" title="Edit" onclick="notificationBeforeDelete(event, this)">
                // <i class="fa fa-lg fa-fw fa-check"></i>
                // </a>';
                return $html;
            })
            ->toJson();
        }
        $count_send_warning = Peminjaman::where('StatusPeminjaman','belum kembali')->count();
        return view('peminjaman.index',["count_send_warning" => $count_send_warning]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bukus = Buku::where('StatusBuku', 'Tersedia')->get();
        $members = Member::where('StatusMember', 'active')->get();
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
        // dd($request->all());
        $request->validate([
            'NIK' => 'required|string|max:16|min:16',
            'hariPinjam' => 'required|integer|between:0,8',
        ]);
        try{
            $peminjaman = new Peminjaman();
            try{
                $PeminjamanList = Peminjaman::where('IDPeminjaman', 'LIKE', '%'.date('dmY').'%')->get();
                $PeminjamanCount = $PeminjamanList->count() + 1;
                if($PeminjamanCount < 10){
                    $peminjaman->IDPeminjaman = 'D'.date('dmY').'0'.$PeminjamanCount;
                }
                else{
                    $peminjaman->IDPeminjaman = 'D'.date('dmY').$PeminjamanCount;
                }
            }catch(QueryException $err){
                $peminjaman->IDPeminjaman = 'D'.date('dmY').'01';
                Log::error('Error in PeminjamanController at store , Error : '.$err->getMessage());
            }
            try{
                $dataBuku = Buku::find($request->IDBuku);
                if($dataBuku->StatusBuku == 'Tersedia'){
                    $peminjaman->IDBuku = $request->IDBuku;
                }
                else{
                    return redirect()
                    ->route('peminjaman.create')
                    ->with('Error','Gagal buku telah dipinjam');
                }
            }
            catch(QueryException $err){
                error_log($err->getMessage());
                Log::error('Error in PeminjamanController at store, Error : '.$err->getMessage());
                return redirect()
                    ->route('peminjaman.create')
                    ->with('Error','Kesalahan dalam pencarian data buku');
            }
            $peminjam = Member::find($request->NIK);
            if($peminjam){
                try{
                    $peminjaman->NIK = $request->NIK;
                    $peminjaman->IDPengurus = Auth::user()->id;
                    $peminjaman->TglPeminjaman = date('Y-m-d');
                    $peminjaman->StatusPeminjaman = 'belum kembali';
                    $tglKembali = Carbon::now()->addDays((int)$request->hariPinjam)->format('Y-m-d');
                    $peminjaman->TglPengembalian = $tglKembali;
                    $peminjaman->TglSelesai = NULL;
                    $peminjaman->save();
                }catch(QueryException $err){
                    error_log($err->getMessage());
                    Log::error('Error in PeminjamanController at store when save peminjaman, Error : '.$err->getMessage());
                    return redirect()
                        ->route('peminjaman.create')
                        ->with('Error','Gagal Menyimpan Peminjaman');
                }

            } else{
                return redirect()
                    ->route('peminjaman.create')
                    ->with('Error', 'Peminjam Belum Menjadi Member!');
            }

            try {
                Buku::where('IDBuku', $request->IDBuku)->update(array('StatusBuku' => 'Dipinjam'));
            } catch (QueryException $err) {
                error_log($err->getMessage());
                Log::error('Error in PeminjamanController at store, Error : '.$err->getMessage());
                return redirect()
                    ->route('peminjaman.create')
                    ->with('Error','Gagal mengupdate data buku');
            }
            return redirect()->route('peminjaman.index')
               ->with('success_message', 'Berhasil melakukan peminjaman');
        }catch(QueryException $err){
            Log::error('Error in PeminjamanController at store, Error :'.$err->getMessage());
            error_log($err->getMessage());
            return redirect()
                ->route('peminjaman.create')
                ->with('Error','Gagal menginput peminjaman buku');
        }
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
        $idBuku = Peminjaman::select('IDBuku')->where('IDPeminjaman', $id)->get();
        try {
            Buku::where('IDBuku', $idBuku)->update(array('StatusBuku' => 'Tersedia'));
        } catch (QueryException $err) {
            error_log($err->getMessage());
            return redirect()
                ->route('peminjaman.index')
                ->with('Error','Gagal buku belum dipinjam');
        }
        $peminjaman = Peminjaman::where('IDPeminjaman', $id)->get();
        $bukus = Buku::where('StatusBuku', 'Tersedia')->get();
        $members = Member::where('StatusMember', 'active')->get();
        return view('peminjaman.edit', compact('bukus', 'members', 'peminjaman'));
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
        if($request->StatusPeminjaman == 'sudah kembali'){
            $request->validate([
                'NIK' => 'required|string|max:16|min:16',
                'hariPinjam' => 'required|integer|between:0,8',
                'TglSelesai' => 'required|date'
            ]);
        } else {
            $request->validate([
                'NIK' => 'required|string|max:16|min:16',
                'hariPinjam' => 'required|integer|between:0,8',
                'TglSelesai' => 'nullable|date'
            ]);
            $request->TglSelesai = null;
        }
        try{
            $peminjaman = Peminjaman::find($id);
            try{
                if($request->IDBuku != $request->oldIDBuku){
                    $peminjaman->IDBuku = $request->IDBuku;
                    try {
                        Buku::where('IDBuku', $request->oldIDBuku)->update(array('StatusBuku' => 'Tersedia'));
                    } catch (QueryException $err) {
                        error_log($err->getMessage());
                        Log::error('Error in PeminjamanController at update'.$err->getMessage());
                        return redirect()
                            ->route('peminjaman.edit')
                            ->with('Error','Data Buku Error');
                    }
                }else{
                    $peminjaman->IDBuku = $request->IDBuku;
                }
            }catch(QueryException $err){
                Log::error('Error in PeminjamanController at update'.$err->getMessage());
                error_log($err->getMessage());
                return redirect()
                    ->route('peminjaman.edit')
                    ->with('Error','Data Buku Error');
            }
            $peminjaman->NIK = $request->NIK;
            $peminjaman->StatusPeminjaman = $request->StatusPeminjaman;
            $tglKembali =Carbon::now()->addDays((int)$request->hariPinjam)->format('Y-m-d');
            $peminjaman->TglPengembalian = $tglKembali;
            $peminjaman->TglSelesai = $request->TglSelesai;
            $peminjaman->save();
            if($request->StatusPeminjaman == 'belum kembali'){
                try {
                    Buku::where('IDBuku', $request->IDBuku)->update(array('StatusBuku' => 'Dipinjam'));
                } catch (QueryException $err) {
                    error_log($err->getMessage());
                    Log::error('Error in PeminjamanController at update'.$err->getMessage());
                    return redirect()
                        ->route('peminjaman.edit')
                        ->with('Error','Gagal buku telah dipinjam');
                }
            }else if($request->StatusPeminjaman == 'sudah kembali'){
                try {
                    Buku::where('IDBuku', $request->IDBuku)->update(array('StatusBuku' => 'Tersedia'));
                } catch (QueryException $err) {
                    error_log($err->getMessage());
                    Log::error('Error in PeminjamanController at update'.$err->getMessage());
                    return redirect()
                        ->route('peminjaman.edit')
                        ->with('Error','Gagal buku telah dipinjam');
                }
            }else{
                try {
                    Buku::where('IDBuku', $request->IDBuku)->update(array('StatusBuku' => 'Tersedia'));
                } catch (QueryException $err) {
                    error_log($err->getMessage());
                    Log::error('Error in PeminjamanController at update'.$err->getMessage());
                    return redirect()
                        ->route('peminjaman.edit')
                        ->with('Error','Gagal buku telah dipinjam');
                }
            }
            return redirect()->route('peminjaman.index')
               ->with('success_message', 'Berhasil mengubah data peminjaman');
        }catch(QueryException $err){
            error_log($err->getMessage());
            Log::error('Error in PeminjamanController at update'.$err->getMessage());
            return redirect()
                ->route('peminjaman.edit', $peminjaman->IDPeminjaman)
                ->with('Error','Gagal Mengedit Data Peminjaman'.$err->getMessage());
        }
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
    public function warningmail()
    {
        $job = new PeringatanPeminjamanMail();
        $this->dispatch($job);
        return redirect()->route('peminjaman.index')
               ->with('success_message', 'Berhasil mengirim email peringatan');
    }

}
