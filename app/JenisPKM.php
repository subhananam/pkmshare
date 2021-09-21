<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JenisPKM extends Model
{
    //use SoftDeletes;
    protected $table = 'jenis_pkm';
    protected $fillable = ['nama_pkm','jumlah_pendaftar','kuota','penjelasan_umum'];

}
