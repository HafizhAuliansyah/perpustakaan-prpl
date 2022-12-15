<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Log;

class MemberController extends Controller{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Log::info('Showing all member');
        if ($request->ajax()) {
            $member = Member::all();
            return DataTables::of($member)
                ->addColumn('action', function ($row) {
                    $html = '<a href='.route('member.edit',$row->NIK).' class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                    <i class="fa fa-lg fa-fw fa-pen"></i>
                    </a>';
                    $html.= '<a href='.route('member.destroy', $row->NIK).' class="btn btn-xs btn-default text-danger mx-1 shadow" title="Edit" onclick="notificationBeforeDelete(event, this)">
                    <i class="fa fa-lg fa-fw fa-trash"></i>
                    </a>';
                    return $html;
                })
                ->toJson();
        }
        return view('member.index');
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
            Log::info('Created new member');

            $details['email'] = $request->Email;
            $details['name'] = $request->Nama;

            dispatch(new \App\Jobs\WelcomeEmailJob($details));

            return redirect()->route('member.index')->with('success', 'Member created successfully');

        }catch(QueryException $err){
            error_log($err->getMessage());
            Log::error('in MemberController on function Store : '. $err->getMessage());
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
            try{
                $member = Member::find($id);
                $member->Nama = $request->Nama;
                $member->StatusMember = $request->StatusMember;
                $member->NomorTelepon = $request->NomorTelepon;
                $member->Email = $request->Email;
                $member->updated_at = date("d-m-Y");
                $member->save();
                Log::info('Updated member : '.$id);
                return redirect()->route('member.index')
                   ->with('success_message', 'Berhasil mengubah member');
            }catch(QueryException $err){
                Log::error('in MemberController on update function : '.$err->getMessage());
                error_log($err->getMessage());
                return redirect()
                    ->route('member.edit', $member->NIK)
                    ->with('Error','Gagal Mengedit Data Buku');
            }
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
        Log::info('Deleted member : '.$id);
        $result = Member::where('NIK', $id)->delete();
        // $member = DB::table('members')->where(['NIK', $id])->get();
        return redirect()->route('member.index')->with('success', 'Member deleted successfully');

        // $member = DB::table('members')->where(['NIK', $id])->get();

        // if ($member) $member->delete();
        // return redirect()->route('member.index')
        //     ->with('success', 'Member deleted successfully');
    }
    public function exportPDF(Request $request){
        $datas = Member::select(
            '*',
            DB::raw("to_char(created_at, 'DD-MM-YYYY') as tgl_daftar"),
            );
        if(!empty($request->status)){
            $datas->where('StatusMember',$request->status);
        }
        if(!empty($request->DaftarFrom) && !empty($request->DaftarUntil)){
            $from = date($request->DaftarFrom);
            $to = date($request->DaftarUntil);
            $datas->whereBetween('created_at', [$from, $to]);
        }
        $datas = $datas->get();
        $count_datas = $datas->count();
        $file_name = 'ListMember.pdf';
        ini_set("pcre.backtrack_limit", "5000000");
        $mpdf = new \Mpdf\Mpdf([
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_top' => 15,
            'margin_bottom' => 20,
            'margin_header' => 10,
            'margin_footer' => 10,
            'format' => 'A4-L',
            'orientation' => 'L'

        ]);
        $html = \view('member.pdf', ['datas' => $datas, 'jumlah'=> $count_datas]);
        $style2 = file_get_contents(public_path('css\member_pdf.css'));
        $mpdf->SetTitle('List Member');
        $mpdf->WriteHTML($style2, \Mpdf\HTMLParserMode::HEADER_CSS);
        $html = $html->render();
        $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
        $mpdf->Output($file_name, 'I');
    }
    public function getAjaxMember(Member $member)
    {
        return response()->json($member);
    }
}
