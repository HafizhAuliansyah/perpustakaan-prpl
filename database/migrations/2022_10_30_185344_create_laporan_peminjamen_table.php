<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaporanPeminjamenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laporan_peminjaman', function (Blueprint $table) {
            $table->string("IDLaporan")->primary();
            $table->date("TglDibentuk");
            $table->integer("JumlahDataPeminjaman");
            $table->integer("JumlahPeminjaman");
            $table->string("IDBukuFavorite");
            $table->string("NikTopMember");
            $table->string("MeanRentangPinjam");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('laporan_peminjaman');
    }
}
