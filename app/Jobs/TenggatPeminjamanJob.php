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
            $peminjamTenggat = DB::table('peminjaman')->select()->where('TglPengembalian', );
        }catch(QueryExceptyion $err){
            
        }
        try{
            $new_id = BukuHelper::generateBookID();
            $denda = new Denda();
            $denda->IDDenda = $new_id;
            $denda->

        }catch(QueryExceptyion $err){

        }
    }
}
