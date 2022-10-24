<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function addView(){
        $last_data = Buku::orderByDesc('created_at', 'desc')->first();
        $last_count = $last_data ? (int)substr($last_data->IDBuku, 9) : 0;
        $last_count += 1;
        $new_id = "B".date("dmY")."000";
        $counterlen = strlen((string)$last_count);
        $new_id = substr_replace($new_id, (string)$last_count, $counterlen * -1);
        return view('buku.add-buku', ['new_id' => $new_id]);
    }
    public function store(Request $request){
        // $request->validate([
        //     'IDBuku' => 'required|string|max:12',
        //     'NamaBuku' => 'required|string|min:1',
        //     'Deskripsi' => 'required|string|min:1',
        //     'GenreBuku' => 'required|string',
        //     'Bahasa' => 'required|string',
        //     'JumlahHalaman' => 'required|integer|between:0,9999|',
        //     'StatusBuku' => 'required|string|',
        //     'Penerbit' => 'required|string',
        //     'Penulis' => 'required|string',
        //     'LetakRak' => 'required|string|max:2|min:2',
        // ]);
        try{
            $buku = new Buku();
            $buku->IDBuku = $request->IDBuku;
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
            return redirect()
                ->route('view_add_buku')
                ->with('Success','Berhasil Menyimpan Data Baru');
        }catch(QueryException $err){
            error_log($err->getMessage());
            return redirect()
                ->route('view_add_buku')
                ->with('Error','Gagal Menyimpan Data Baru');
        }

    }
    public function show(){
        return view('buku.all-buku', [
            'datas' =>Buku::orderBy('IDBuku')->get()
        ]);
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
            return redirect()
                ->route('all_buku')
                ->with('Success','Berhasil Mengubah Data Buku');
        }catch(QueryException $err){
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
}
