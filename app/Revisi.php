<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Revisi extends Model
{
    //use SoftDeletes;
    protected $table = "revisi";
    protected $fillable = ['bimbingan_id','nama_file','lokasi_file','komentar'];
    protected $casts = [
        'updated_at' => 'datetime:d M Y - H:i',
        'created_at' => 'datetime:d M Y - H:i',
    ];
    //
}
