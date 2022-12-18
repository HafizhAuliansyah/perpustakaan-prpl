<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Denda;
use App\Models\RekapDenda;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Yajra\DataTables\DataTables;

class RekapDendaController extends Controller
{
    public function index(){
        try {
            return view('rekap_denda.index', [
                'datas' =>RekapDenda::orderBy('IDRekapDenda')->get()
            ]);
        } catch (QueryException $err) {
            error_log($err->getMessage());
            Log::error('Error at RekapDendaController@index :');
            return redirect()
                ->route('rekap_denda.index')
                ->with('Error','Gagal Menemukan Data Denda');
        }
    }

    public function showPart(Request $request){
        try {
            if ($request->ajax()) {
                $rekapPeminjaman = RekapDenda::all();
                return DataTables::of($rekapPeminjaman)
                    ->toJson();
            }
            return view('rekap_denda.index');
        } catch (QueryException $er) {
            error_log($err->getMessage());
            Log::error('Error at RekapDendaController@showPart :');
            return redirect()
                ->route('rekap_denda.index')
                ->with('Error','Gagal Menemukan Data Denda');
        }
    }

    public function store(){
        $checkRekapDenda = RekapDenda::select('TglDibentuk')->where('TglDibentuk', 'LIKE', '%'.date('Y-m').'%')->get();

        if($checkRekapDenda->isNotEmpty()){
            return redirect()
            ->route('rekap_denda.index')
            ->with('Error','Rekap Denda Sudah Dibuat');
        }else{
            $array['TglDibentuk'] = date('Y-m-d');
            try {
                $array['JumlahDataDenda'] = Denda::where('created_at', 'LIKE', '%'.date('Y-m').'%')->count();
            } catch (QueryException $err) {
                error_log($err->getMessage());
                Log::error('Error at RekapDendaController@store :'.$err);
                return redirect()
                    ->route('rekap_denda.index')
                    ->with('Error','Gagal Menemukan Data Denda');
            }
            $totalNominal = Denda::where('created_at', 'LIKE', '%'.date('Y-m').'%')->get();
            $array['JumlahNominal'] = $totalNominal->sum('Nominal');
            $array['NominalTerbesar'] = $totalNominal->max('Nominal');
            $array['NominalTerkecil'] = $totalNominal->min('Nominal');

            $rekapDenda = RekapDenda::create($array);

            return redirect()
                ->route('rekap_denda.index')
                ->with('Success','Rekap Denda Created Successfully!');
        }
    }
}
