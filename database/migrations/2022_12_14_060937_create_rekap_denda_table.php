<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRekapDendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekap_denda', function (Blueprint $table) {
            $table->id("IDRekapDenda");
            $table->date("TglDibentuk");
            $table->integer("JumlahDataDenda");
            $table->integer("JumlahNominal");
            $table->integer("NominalTerbesar");
            $table->integer("NominalTerkecil");
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
        Schema::dropIfExists('rekap_denda');
    }
}
