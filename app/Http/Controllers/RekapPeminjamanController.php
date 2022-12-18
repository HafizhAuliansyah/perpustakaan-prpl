<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\RekapPeminjaman;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Yajra\DataTables\DataTables;

class RekapPeminjamanController extends Controller
{
    public function index(){
        try {
            return view('rekap_peminjaman.index', [
                'datas' =>RekapPeminjaman::orderBy('IDRekapPeminjaman')->get()
            ]);
        } catch (QueryException $err) {
            error_log($err->getMessage());
            Log::error('Error at RekapPeminjamanController@index :');
            return redirect()
                ->route('rekap_peminjaman.index')
                ->with('Error','Gagal Menemukan Data Peminjaman ');
        }
    }

    public function showPart(Request $request){
        try {
            if ($request->ajax()) {
                $rekapPeminjaman = RekapPeminjaman::all();
                return DataTables::of($rekapPeminjaman)
                    ->toJson();
            }
            return view('rekap_peminjaman.index');
        } catch (QueryException $er) {
            error_log($err->getMessage());
            Log::error('Error at RekapPeminjamanController@showPart :');
            return redirect()
                ->route('rekap_peminjaman.index')
                ->with('Error','Gagal Menemukan Data Peminjaman ');
        }
    }

    public function store(){
        $checkRekapPeminjaman = RekapPeminjaman::select('TglDibentuk')->where('TglDibentuk', 'LIKE', '%'.date('Y-m').'%')->get();

        if($checkRekapPeminjaman->isNotEmpty()){
            return redirect()
                ->route('rekap_peminjaman.index')
                ->with('Error','Rekap Peminjaman Sudah Dibuat');
        }else{
            $array['TglDibentuk'] = date('Y-m-d');
            try {
                $array['JumlahDataPeminjaman'] = Peminjaman::where('TglPeminjaman', 'LIKE', '%'.date('Y-m').'%')->count();
            } catch (QueryException $err) {
                error_log($err->getMessage());
                Log::error('Error at RekapPeminjamanController@store :'.$err);
                return redirect()
                    ->route('rekap_peminjaman.index')
                    ->with('Error','Gagal Menemukan Data Peminjaman');
            }
            $jmlpeminjam = Peminjaman::select('NIK')->where('TglPeminjaman', 'LIKE', '%'.date('Y-m').'%')->groupBy('NIK')->orderByRaw('COUNT(*) DESC')->get();
            $array['JumlahPeminjam'] = $jmlpeminjam->count();
            $idbukufav = Peminjaman::select('IDBuku')->where('TglPeminjaman', 'LIKE', '%'.date('Y-m').'%')->groupBy('IDBuku')->orderByRaw('COUNT(*) DESC')->limit(1)->first();
            $array['IDBukuFavorite'] = $idbukufav->IDBuku;
            $idtopmember = Peminjaman::select('NIK')->where('TglPeminjaman', 'LIKE', '%'.date('Y-m').'%')->groupBy('NIK')->orderByRaw('COUNT(*) DESC')->limit(1)->first();
            $array['NikTopMember'] = $idtopmember->NIK;
            $arr = Peminjaman::select('TglPeminjaman', 'TglPengembalian')->where('TglPeminjaman', 'LIKE', '%'.date('Y-m').'%')->get();
            $bagi = Peminjaman::where('TglPeminjaman', 'LIKE', '%'.date('Y-m').'%')->count();

            $sa = 0;
            foreach($arr as $ar){
                $hari = Carbon::parse($ar->TglPeminjaman)->diffInDays(Carbon::parse($ar->TglPengembalian));
                $sa = $sa + $hari;
            }

            $array['MeanRentangPinjam'] = doubleval($sa/$bagi);

            $rekapPeminjaman =  RekapPeminjaman::create($array);

            return redirect()
            ->route('rekap_peminjaman.index')
            ->with('Success','Rekap Peminjaman Created Successfully!');
        }
    }
}
