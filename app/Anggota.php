<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Anggota extends Model
{
    //use SoftDeletes;
    protected $table = 'anggota';
    protected $fillable = [
        'user_id','pkm_id','nim','nama_lengkap','tempat_lahir','tgl_lahir','agama',
        'jenis_kelamin','umur','program_studi','alamat','email','no_hp'
    ];
}
