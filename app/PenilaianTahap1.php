<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenilaianTahap1 extends Model
{
    //use SoftDeletes;
    protected $table = 'penilaian_tahap_1';
    protected $fillable = [
        'pkm_id','nilai_judul','nilai_lb','nilai_tujuan','nilai_manfaat'
    ];
}
