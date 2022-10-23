<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function create(Request $request){

    }
    public function show(){
        return view('buku.all-buku', [
            'datas' =>Buku::all()
        ]);
    }
    public function edit(Buku $buku,Request $request){

    }
    public function delete(Buku $buku){
        
    }
}
