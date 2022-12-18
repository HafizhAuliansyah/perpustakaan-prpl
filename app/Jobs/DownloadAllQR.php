<?php

namespace App\Jobs;

use App\Models\Buku;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class DownloadAllQR implements ShouldQueue
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
    public function handle()
    {
        if(file_exists(storage_path('downloaded/qr_buku'))){
            array_map('unlink', glob(storage_path('downloaded/qr_buku/*.*')));
            rmdir(storage_path('downloaded/qr_buku'));
            rmdir(storage_path('downloaded'));
        }
        mkdir(storage_path('downloaded'));
        mkdir(storage_path('downloaded/qr_buku'));
        $all_buku = Buku::get();
        foreach($all_buku as $buku){
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
            $path_save = storage_path('downloaded/qr_buku/'.$file_name);
            $mpdf->Output($path_save, 'F');
        }
    }
}
