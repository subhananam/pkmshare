<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bimbingan extends Model
{
    //use SoftDeletes;
    protected $table = "bimbingan";
    protected $fillable = ['user_id','pkm_id','nama_file','lokasi_file'];
    //
    protected $casts = [
        'updated_at' => 'datetime:d M Y - H:i',
        'created_at' => 'datetime:d M Y - H:i',
    ];

    public function pkm()
    {
        return $this->hasOne(PKM::class, 'id', 'pkm_id');
    }
    public function revisi()
    {
        return $this->hasOne(Revisi::class, 'bimbingan_id', 'id');
    }
}
