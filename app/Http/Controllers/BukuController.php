<?php

namespace App\Http\Controllers;

use App\Helpers\BukuHelper;
use App\Jobs\DownloadAllQR;
use App\Models\Buku;
use ErrorException;
use Exception;
use Facade\FlareClient\Http\Response as HttpResponse;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Response;

class BukuController extends Controller
{
    public function addView(){
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

        $cover_name = 'default.jpg';
        $cover_buku = null;
        if($request->file('Cover')){
            try{   
                $cover_buku= $request->file('Cover');
                $cover_name = $new_id.'.'.$cover_buku->getClientOriginalExtension();
                $cover_buku->move(public_path('/images/buku/cover'), $cover_name);
    
            }catch(ErrorException $err){
                Log::error('Error in BukuController at store. Error : '.$err->getMessage());
                error_log($err->getMessage());
                return redirect()
                    ->route('view_add_buku')
                    ->with('Error','Gagal Menyimpan Data Baru');
            }
        }
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
            $buku->Cover = $cover_name;
            $qrPath = public_path('images/buku/qr_code/'.$new_id.'.svg');
            QrCode::format('svg')->backgroundColor(255,255,255)->size(200)->generate($new_id, $qrPath);
            $buku->QRCode = $new_id.'.svg';
            $buku->save();
            return redirect()
                ->route('detail_buku', $new_id)
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
        return view('buku.all-buku', [
            'datas' =>Buku::orderBy('IDBuku')->get()
        ]);
    }
    public function showPart(Request $request){
        if ($request->ajax()) {
            $buku = Buku::orderBy('IDBuku')->get();
            return DataTables::of($buku)
                ->addColumn('action', function ($row) {
                    $html = '<a href='.route('detail_buku', $row->IDBuku).' class="btn btn-xs btn-default text-primary mx-1 shadow" title="Detail"><i class="fa fa-lg fa-fw fa-eye"></i></a>';
                    $html.= '<a href='.route('view_edit_buku', $row->IDBuku).' class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                    <i class="fa fa-lg fa-fw fa-pen"></i>
                    </a>';
                    $html.= '<a href='.route('delete_buku', $row->IDBuku).' class="btn btn-xs btn-default text-danger mx-1 shadow" title="Edit" onclick="notificationBeforeDelete(event, this)">
                    <i class="fa fa-lg fa-fw fa-trash"></i>
                    </a>';
                    return $html;
                })
                ->toJson();
            }
        $jumlah_buku = Buku::count();
        return view('buku.all-buku', ['jumlah_buku' => $jumlah_buku]);
    }
    public function getAjaxBuku(Buku $buku)
    {
        return response()->json($buku);
    }
    public function editView(Buku $buku){
        return view('buku.edit-buku', ['buku' => $buku]);
    }
    public function update(Buku $buku, Request $request){
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
            if($request->file('Cover')){
                $cover_name = $buku->Cover;
                $cover_buku = null;
                try{   
                    unlink(public_path('images/buku/cover/'.$buku->Cover));
                    $cover_buku= $request->file('Cover');
                    $cover_name = $buku->IDBuku.'.'.$cover_buku->getClientOriginalExtension();
                    $cover_buku->move(public_path('/images/buku/cover'), $cover_name);
        
                }catch(ErrorException $err){
                    Log::error('Error in BukuController at store. Error : '.$err->getMessage());
                    error_log($err->getMessage());
                    return redirect()
                        ->route('view_edit_buku')
                        ->with('Error','Gagal Menyimpan Data Baru');
                }
                $buku->Cover = $cover_name;
            }
            $buku->save();
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
        if($buku->Cover != 'default.jpg')
            unlink(public_path('images/buku/cover/'.$buku->Cover));
            
        unlink(public_path('images/buku/qr_code/'.$buku->QRCode));
        $buku->delete();
        return redirect('/buku/all');
    }
    public function exportPDF(Request $request){
        try{
            $datas = Buku::select("*");
            if($request->nama){
                $datas->where('NamaBuku','LIKE','%'.$request->nama.'%');
            }
            if(!empty($request->bahasa)){
                $datas->where('Bahasa',$request->bahasa);
            }
            if(!empty($request->genre)){
                $datas->where('GenreBuku',$request->genre);
            }
            if(!empty($request->status)){
                $datas->where('StatusBuku',$request->status);
            }
            if(!empty($request->penulis)){
                $datas->where('Penulis',$request->penulis);
            }
            if(!empty($request->penerbit)){
                $datas->where('Penerbit',$request->penerbit);
            }
            if(!empty($request->letakrak)){
                $datas->where('LetakRak',$request->letakrak);
            }
            if(!empty($request->EnterFrom) && !empty($request->EnterUntil)){
                $from = date($request->EnterFrom);
                $to = date($request->EnterUntil);
                $datas->whereBetween('TglMasukBuku', [$from, $to]);
            }
            $datas = $datas->get();
            $count_datas = $datas->count();
            $file_name = 'DataBuku.pdf';
            ini_set("pcre.backtrack_limit", "5000000");
            $mpdf = new \Mpdf\Mpdf([
                'margin_left' => 10,
                'margin_right' => 10,
                'margin_top' => 15,
                'margin_bottom' => 20,
                'margin_header' => 10,
                'margin_footer' => 10,
                'format' => 'A4-P',
                'orientation' => 'P'
            ]);
            $html = \view('buku.pdf', ['datas' => $datas, 'jumlah'=> $count_datas]);
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
    public function detail(Buku $buku){
        return view('buku.detail',['buku' => $buku]);
    }
    public function exportQRPDF(Buku $buku)
    {
        try{
            $data = $buku;
            $file_name = 'QR-'.$buku->IDBuku.".pdf";
            $mpdf = new \Mpdf\Mpdf([
                'margin_left' => 3,
                'margin_right' => 3,
                'margin_top' => 3,
                'margin_bottom' => 3,
                'format' => [50, 60],
                'orientation' => 'P'
            ]);
            $html = \view('buku.qr_pdf', ['data' => $data]);
            $style2 = file_get_contents(public_path('css\buku_pdf.css'));
            $mpdf->WriteHTML($style2, \Mpdf\HTMLParserMode::HEADER_CSS);
            $html = $html->render();
            $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
            $mpdf->debug = true;
            $mpdf->Output($file_name, 'I');
        }catch(Exception $e){
            Log::error('Error in BukuController at exportQRPDF : '.$e->getMessage());
            return redirect()
                ->route('detail_buku', $buku->IDBuku)
                ->with('Error','Gagal Export PDF');
        }
    }
    public function donwloadQR(Buku $buku)
    {
        $path = public_path("/images/buku/qr_code/".$buku->QRCode);
        return response()->download($path, "QR-".$buku->IDBuku.".svg");
    }
    public function exportAllQR()
    {
       $job = new DownloadAllQR();
       $this->dispatch($job);
       return redirect()->route("all_buku")->with('success_message', 'Proses download sedang berjalan');
    }
}
