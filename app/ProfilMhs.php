<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfilMhs extends Model
{
    //use SoftDeletes;
    protected $table = 'profil_mhs';
    protected $fillable = [
        'user_id', 'nim','nama_lengkap','tempat_lahir','tgl_lahir','agama',
        'jenis_kelamin','umur','program_studi','alamat', 'no_hp'
    ];
}
