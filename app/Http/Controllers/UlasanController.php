<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use Illuminate\Http\Request;

class UlasanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ulasan.index',[
            'datas' => Ulasan::orderBy('id')->get()
        ]);
    }

    public function addView(){
        return view('ulasan.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            Ulasan::create($request->all());
            return redirect()->route('all_ulasan')
                            ->with('success','Ulasan Created Successfully!');
        } catch(QueryException $err){
            error_log($err->getMessage());
            return redirect()
                ->route('all_ulasan')
                ->with('Error','Gagal Menyimpan Data Baru');
        }
           
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ulasan  $ulasan
     * @return \Illuminate\Http\Response
     */
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ulasan  $ulasan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ulasan $ulasan)
    {
        $ulasan->delete();
        
        return redirect()
            ->route('all_ulasan')
            ->with('success','Ulasan Created Successfully!');;
    }
}