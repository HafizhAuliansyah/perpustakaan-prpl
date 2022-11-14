<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PerpustakaanController extends Controller
{
    public function cariBuku(){
        $title = "Cari Buku";
        return view('perpustakaan_cari', ['title' => $title]);
    }
    public function ulasan(){

    }
}
