<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapPeminjamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekap_peminjaman', function (Blueprint $table) {
            $table->string("IDRekapPeminjaman")->primary();
            $table->date("TglDibentuk");
            $table->integer("JumlahDataPeminjaman");
            $table->integer("JumlahPeminjaman");
            $table->string("IDBukuFavorite");
            $table->string("NikTopMember");
            $table->float("MeanRentangPinjam");
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
        Schema::dropIfExists('rekap_peminjaman');
    }
}
