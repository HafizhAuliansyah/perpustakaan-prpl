<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeminjamansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->string('IDPeminjaman')->primary();
            $table->string('IDBuku', 12);
            $table->string('NIK', 16);
            $table->date('TglPeminjaman');
            $table->enum('StatusPeminjaman', ['sudah kembali', 'belum kembali', 'batal']);
            $table->date('TglPengembalian');
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
        Schema::dropIfExists('peminjaman');
    }
}
