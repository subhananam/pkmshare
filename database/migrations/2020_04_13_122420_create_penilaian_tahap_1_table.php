<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePenilaianTahap1Table extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('penilaian_tahap_1', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('pkm_id');
            $table->integer('nilai_judul');
            $table->integer('nilai_lb');
            $table->integer('nilai_tujuan');
            $table->integer('nilai_manfaat');
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
        Schema::dropIfExists('penilaian_tahap_1');
    }
}
