<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBukusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buku', function (Blueprint $table) {

            $table->string('IDBuku', 12)->primary();
            $table->string('NamaBuku');
            $table->text('Deskripsi');
            $table->enum('GenreBuku', ['Horror', 'Aksi', 'Fiksi', 'Drama', 'Romansa', 'Komedi', 'Sport', 'Teknologi', 'Sejarah', 'Politik']);
            $table->enum('Bahasa',['Indonesia', 'Inggris', 'Jepang', 'China', 'Arab', 'Prancis']);
            $table->integer('JumlahHalaman', false, true);
            $table->enum('StatusBuku', ['Dipinjam', 'Rusak', 'Hilang', 'Tersedia']);
            $table->string('Penerbit');
            $table->string('Penulis');
            $table->string('LetakRak', 2);
            $table->date('TglMasukBuku');
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
        Schema::dropIfExists('buku');
    }
}
