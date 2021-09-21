<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenilaianTahap2Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaian_tahap_2', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('pkm_id');
            $table->bigInteger('kriteria_id');
            $table->integer('skor');
            $table->integer('nilai');
            $table->softDeletes();
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
        Schema::dropIfExists('penilaian_tahap_2');
    }
}
