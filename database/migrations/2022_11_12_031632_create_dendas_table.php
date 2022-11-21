<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('denda', function (Blueprint $table) {
            $table->string('IDDenda')->primary();
            $table->string('IDPeminjaman')->default(null)->nullable();
            $table->foreign('IDPeminjaman')
                  ->references('IDPeminjaman')
                  ->on('peminjaman')
                  ->restrictOnDelete();
            $table->string('Keterangan');
            $table->string('Status');
            $table->integer('Nominal');
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
        Schema::dropIfExists('denda');
    }
}
