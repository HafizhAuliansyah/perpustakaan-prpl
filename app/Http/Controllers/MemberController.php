<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class MemberController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = Member::all();
        return view('member.index', [
            'members' => $members
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('member.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'NIK' => 'required',
        //     'Nama' => 'required',
        //     'NomorTelepon' => 'required',
        //     'Email' => 'required'
        // ]);

        try{
            Member::create($request->all());

            return redirect()->route('member.index')->with('success', 'Member created successfully');
        }catch(QueryException $err){
            error_log($err->getMessage());
            return redirect()
                ->route('member.create')
                ->with('Error','Gagal Menyimpan Data Baru');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        return view('member.show', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $member = Member::where('NIK', $id)->get();
        return view('member.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Member  $member
     * @return \Illuminate\Http\Response
     */
    // public function update(Member $member, Request $request)
    // {
    public function update(Request $request, $id)
    {
        // $request->validate([
        //     'NIK' => 'required',
        //     'Nama' => 'required',
        //     'NomorTelepon' => 'required',
        //     'Email' => 'required'
        // ]);
        $member = Member::find($id);
         $member->Nama = $request->Nama;
         $member->StatusMember = $request->StatusMember;
         $member->NomorTelepon = $request->NomorTelepon;
         $member->Email = $request->Email;
        $member->save();
        return redirect()->route('member.index')
            ->with('success_message', 'Berhasil mengubah member');
        // try{
        //     if($request->Nama)
        //         $member->Nama = $request->Nama;
        //     if($request->StatusMember)
        //         $member->StatusMember = $request->StatusMember;
        //     if($request->NomorTelepon)
        //         $member->NomorTelepon = $request->NomorTelepon;
        //     if($request->Email)
        //         $member->Email = $request->Email;

        //     $member->save();
        //     return redirect()
        //         ->route('member.index')
        //         ->with('Success','Berhasil Mengubah Data Buku');
        // }catch(QueryException $err){
        //     error_log($err->getMessage());
        //     return redirect()
        //         ->route('member.edit', $member->NIK)
        //         ->with('Error','Gagal Mengedit Data Buku');
        // }
        // return redirect()->route('member.index')->with('success', 'Member updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Member $member
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $result = Member::find($member)->delete();
        $result = Member::where('NIK', $id)->delete();
        // $member = DB::table('members')->where(['NIK', $id])->get();
        return redirect()->route('member.index')->with('success', 'Member deleted successfully');

        // $member = DB::table('members')->where(['NIK', $id])->get();

        // if ($member) $member->delete();
        // return redirect()->route('member.index')
        //     ->with('success', 'Member deleted successfully');
    }
}
