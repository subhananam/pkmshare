<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProfilDosen extends Model
{
    //use SoftDeletes;
    protected $table = 'profil_dosen';
    protected $fillable = [
        'user_id', 'nidn','nama_lengkap','tempat_lahir','tgl_lahir','agama','jenis_kelamin',
        'umur','jabatan','alamat','no_hp','jumlah_pendaftar','kuota'
    ];
}
