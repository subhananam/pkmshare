<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJumlahPendaftarToJenisPkm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jenis_pkm', function (Blueprint $table) {
            $table->integer('jumlah_pendaftar')->nullable()->after('nama_pkm');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jenis_pkm', function (Blueprint $table) {
            //
        });
    }
}
