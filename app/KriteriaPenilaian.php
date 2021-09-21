<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KriteriaPenilaian extends Model
{
    //use SoftDeletes;
    protected $table = 'kriteria_penilaian';
    protected $fillable = ['jenis_pkm_id','kriteria','bobot'];

    public function jenis_pkm()
    {
        return $this->hasOne(JenisPKM::class, 'id', 'jenis_pkm_id');
    }
}
