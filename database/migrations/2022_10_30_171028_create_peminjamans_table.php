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
            $table->string('IDBuku', 14);
            $table->foreign('IDBuku')
                ->references('IDBuku')
                ->on('buku');
            $table->string('NIK', 16);
            $table->foreign('NIK')
                ->references('NIK')
                ->on('member');
            $table->bigInteger('IDPengurus');
            $table->foreign('IDPengurus')
                ->references('id')
                ->on('pengurus');
            $table->date('TglPeminjaman');
            $table->enum('StatusPeminjaman', ['sudah kembali', 'belum kembali', 'batal']);
            $table->date('TglPengembalian');
            $table->date('TglSelesai')->nullable()->default(null);
            $table->timestamps();
        });

        // Schema::alter('peminjaman', function(Blueprint $table) {
        //     $table->foreign('IDPengurus')->references('IDPengurus')->on('pengurus');
        // });
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
