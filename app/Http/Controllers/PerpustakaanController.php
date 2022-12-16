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

    public function createRekapPeminjaman(){

        $checkRekapPeminjaman = RekapPeminjaman::select('TglDibentuk')->where('TglDibentuk', 'LIKE', '%'.date('Y-m').'%')->get();

        if($checkRekapPeminjaman->isNotEmpty()){
            return redirect()
                ->route('peminjaman.index')
                ->with('Error','Rekap Peminjaman Sudah Dibuat');
        }else{
            $array['TglDibentuk'] = date('Y-m-d');
            try {
                $array['JumlahDataPeminjaman'] = Peminjaman::count();
            } catch (QueryException $err) {
                error_log($err->getMessage());
                Log::error('Error at PerpustakaanController@RekapPeminjaman :'.$err);
                return redirect()
                    ->route('peminjaman.index')
                     ->with('Error','Gagal Menemukan Data Peminjaman');
            }
            $jmlpeminjam = Peminjaman::select('NIK')->groupBy('NIK')->orderByRaw('COUNT(*) DESC')->get();
            $array['JumlahPeminjam'] = $jmlpeminjam->count();
            $idbukufav = Peminjaman::select('IDBuku')->groupBy('IDBuku')->orderByRaw('COUNT(*) DESC')->limit(1)->first();
            $array['IDBukuFavorite'] = $idbukufav->IDBuku;
            $idtopmember = Peminjaman::select('NIK')->groupBy('NIK')->orderByRaw('COUNT(*) DESC')->limit(1)->first();
            $array['NikTopMember'] = $idtopmember->NIK;
            $arr = Peminjaman::select('TglPeminjaman', 'TglPengembalian')->get();
            $bagi = Peminjaman::count();

            $sa = 0;
            foreach($arr as $ar){
                $hari = Carbon::parse($ar->TglPeminjaman)->diffInDays(Carbon::parse($ar->TglPengembalian));
                $sa = $sa + $hari;
            }

            $array['MeanRentangPinjam'] = doubleval($sa/$bagi);

            $rekapPeminjaman =  RekapPeminjaman::create($array);

            return redirect()
            ->route('peminjaman.index')
            ->with('Success','Rekap Peminjaman Created Successfully!');
        }
    }
}
