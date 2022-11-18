<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Denda;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;
use App\Helpers\DendaHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;
use Carbon\Carbon;

class TenggatPeminjamanJob implements ShouldQueue
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
        $waktuSekarang = CarbonImmutable::now(new DateTimeZone('Asia/Jakarta'));
        try{
            $peminjamTenggat = DB::table('peminjaman')->select()->where('TglPengembalian', $waktuSekarang->toDateString());
        }catch(QueryExceptyion $err){
            Log::error('Error in TenggatPeminjamJobs at get peminjam : '.$err->getMessage());
        }
        try{
            if($peminjamTenggat){
                foreach($peminjamTenggat as $peminjam){
                    $new_id = DendaHelper::generateBookID();
                    $denda = new Denda();
                    $denda->IDDenda = $new_id;
                    $denda->IDPeminjam = $peminjam->IDPeminjam;
                    $denda->NIK = $peminjam->NIK;
                    $denda->Keterangan = 'Tenggat Pengembalian';
                    $denda->Status = 'Belum Lunas';
                    $denda->Nominal = 10000;
                    $denda->save();
                    Log::info('Created Denda with TenggatPeminjamanJobs :'.$denda->IDDenda);
                }
            }
            Log::info('TenggatPeminjamanJobs work');
        }catch(QueryException $err){
            Log::error('Error in TenggatPeminjamanJobs :'.$err->getMessage());
        }
    }
}
