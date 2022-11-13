<?php

namespace App\Http\Controllers;

use App\Helpers\BukuHelper;
use App\Models\Buku;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

class BukuController extends Controller
{
    public function addView(){
        Log::info('Auto incement for IDBuku Success');
        return view('buku.add-buku');
    }
    public function store(Request $request){
        $request->validate([
            'NamaBuku' => 'required|string|min:1',
            'GenreBuku' => 'required|string|min:1',
            'Bahasa' => 'required|string|min:1',
            'JumlahHalaman' => 'required|integer|between:0,9999|',
            'StatusBuku' => 'required|string|',
            'Penerbit' => 'required|string|min:1',
            'Penulis' => 'required|string|min:1',
            'LetakRak' => 'required|string|max:2|min:2',
        ]);
        $new_id = BukuHelper::generateBookID();
        try{
            $buku = new Buku();
            $buku->IDBuku = $new_id;
            $buku->NamaBuku = $request->NamaBuku;
            $buku->Deskripsi = $request->Deskripsi;
            $buku->GenreBuku = $request->GenreBuku;
            $buku->Bahasa = $request->Bahasa;
            $buku->JumlahHalaman = $request->JumlahHalaman;
            $buku->StatusBuku = $request->StatusBuku;
            $buku->Penerbit = $request->Penerbit;
            $buku->Penulis = $request->Penulis;
            $buku->LetakRak = $request->LetakRak;
            $buku->TglMasukBuku = date("d-m-Y");
            $buku->save();
            Log::info('Data Buku Created : '.$buku->IDBuku);
            return redirect()
                ->route('all_buku')
                ->with('success_message','Berhasil Menyimpan Data Baru');
        }catch(QueryException $err){
            Log::error('Error in BukuController at store. Error : '.$err->getMessage());
            error_log($err->getMessage());
            return redirect()
                ->route('view_add_buku')
                ->with('Error','Gagal Menyimpan Data Baru');
        }

    }
    public function showAll(){
        Log::info('Showed all Data Buku');
        return view('buku.all-buku', [
            'datas' =>Buku::orderBy('IDBuku')->get()
        ]);
    }
    public function showPart(Request $request){
        if ($request->ajax()) {
            $buku = Buku::orderBy('IDBuku')->get();
            Log::info('Showed part Data Buku');
            return DataTables::of($buku)
                ->addColumn('action', function ($row) {
                    $html = '<a href='.route('view_edit_buku', $row->IDBuku).' class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                    <i class="fa fa-lg fa-fw fa-pen"></i>
                    </a>';
                    $html.= '<a href='.route('delete_buku', $row->IDBuku).' class="btn btn-xs btn-default text-danger mx-1 shadow" title="Edit" onclick="notificationBeforeDelete(event, this)">
                    <i class="fa fa-lg fa-fw fa-trash"></i>
                    </a>';
                    return $html;
                })
                ->toJson();
            }
        return view('buku.all-buku');
    }
    public function editView(Buku $buku){
        return view('buku.edit-buku', ['buku' => $buku]);
    }
    public function update(Buku $buku, Request $request){
           // $request->validate([
        //     'NamaBuku' => 'string|min:1',
        //     'Deskripsi' => 'string|min:1',
        //     'GenreBuku' => 'string',
        //     'Bahasa' => 'string',
        //     'JumlahHalaman' => 'integer|between:0,9999|',
        //     'StatusBuku' => 'string',
        //     'Penerbit' => 'string',
        //     'Penulis' => 'string',
        //     'LetakRak' => 'string|max:2|min:2',
        // ]);
        try{
            if($request->NamaBuku)
                $buku->NamaBuku = $request->NamaBuku;
            if($request->Deskripsi)
                $buku->Deskripsi = $request->Deskripsi;
            if($request->GenreBuku)
                $buku->GenreBuku = $request->GenreBuku;
            if($request->Bahasa)
                $buku->Bahasa = $request->Bahasa;
            if( $request->JumlahHalaman)
                $buku->JumlahHalaman = $request->JumlahHalaman;
            if($request->StatusBuku)
                $buku->StatusBuku = $request->StatusBuku;
            if($request->Penerbit)
                $buku->Penerbit = $request->Penerbit;
            if($request->Penulis)
                $buku->Penulis = $request->Penulis;
            if($request->LetakRak)
                $buku->LetakRak = $request->LetakRak;
            $buku->save();
            Log::info('Updated Data Buku : '.$buku->IDBuku);
            return redirect()
                ->route('all_buku')
                ->with('Success','Berhasil Mengubah Data Buku');
        }catch(QueryException $err){
            Log::error('Error in BukuController at update : '.$err->getMessage());
            error_log($err->getMessage());
            return redirect()
                ->route('view_edit_buku', $buku)
                ->with('Error','Gagal Mengedit Data Buku');
        }
    }

    public function delete(Buku $buku){
        $buku->delete();
        return redirect('/buku/all');
    }
    public function exportPDF(){
        try{
            $datas = Buku::take(100)->get();
            $file_name = 'DataBuku.pdf';
            $mpdf = new \Mpdf\Mpdf([
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 15,
                'margin_bottom' => 20,
                'margin_header' => 10,
                'margin_footer' => 10
            ]);
            $html = \view('buku.pdf', ['datas' => $datas]);
            $style2 = file_get_contents(public_path('css\buku_pdf.css'));
            $mpdf->WriteHTML($style2, \Mpdf\HTMLParserMode::HEADER_CSS);
            $html = $html->render();
            $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
            $mpdf->Output($file_name, 'I');
        }catch(Exception $e){
            Log::error('Error in BukuController at exportPDF : '.$e->getMessage());
            return redirect()
                ->route('all_buku')
                ->with('Error','Gagal Export PDF');
        }
        
    }
}
