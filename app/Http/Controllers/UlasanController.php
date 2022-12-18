<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

class UlasanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $ulasan = Ulasan::all();
            return DataTables::of($ulasan)
                ->toJson();
        }
        return view('ulasan.index');

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
        $request->validate([
            'masukan' => 'required|string|min:4'
        ]);
        try{
            Ulasan::create($request->masukan);
            return redirect()->route('all_ulasan')
                            ->with('success','Ulasan Created Successfully!');
        } catch(QueryException $err){
            error_log($err->getMessage());
            Log::error('Error at UlasanController :'.$err);
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
            ->with('success','Ulasan Deleted Successfully!');;
    }
}