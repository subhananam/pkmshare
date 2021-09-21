<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PenilaianTahap2 extends Model
{
    //use SoftDeletes;
    protected $table = 'penilaian_tahap_2';
    protected $fillable = [
        'pkm_id','kriteria_id','skor','nilai'
    ];
}
