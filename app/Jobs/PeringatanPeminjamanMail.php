<?php

namespace App\Jobs;

use App\Models\Buku;
use App\Models\Member;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class PeringatanPeminjamanMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Request $request)
    {
        $peminjam = Peminjaman::select('NIK')
                    ->where('StatusPeminjaman','belum kembali')
                    ->get();
        foreach ($peminjam as $p) {
            $datas = Buku::select("*")
            ->join('peminjaman as p', 'p.IDBuku','=','buku.IDBuku')
            ->where('p.NIK',$p->NIK)
            ->orderBy('p.TglPengembalian', 'asc')
            ->get();

            $count_datas = $datas->count();
            $file_name = 'List Buku Dipinjam.pdf';
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
            
            $member_data = Member::select('*')->where('NIK', $p->NIK)->first();
            $html = \view('peminjaman.pdf_warning', ['datas' => $datas, 'jumlah'=> $count_datas, 'member' =>$member_data]);
            $style2 = file_get_contents(public_path('css\buku_pdf.css'));
            $mpdf->WriteHTML($style2, \Mpdf\HTMLParserMode::HEADER_CSS);
            $html = $html->render();
            $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);
            $content = $mpdf->Output($file_name, 'S');

            $mail_data['email'] = $member_data->Email;
            $mail_data['title'] = "Peringatan Peminjaman Buku";
            $mail_data['name'] = $member_data->Nama;
            $mail_data['body'] = $member_data->Nama.", berikut ini list buku yang belum kamu kembalikan ";
            Mail::send('emails.warning_mail', $mail_data, function($message) use($mail_data, $content) {
                $message->to($mail_data["email"], $mail_data["email"])
                        ->subject($mail_data["title"])
                        ->attachData($content, "List Buku Dipinjam.pdf");
            });
        }
        
    }
}
