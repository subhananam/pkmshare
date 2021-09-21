<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Komentar extends Model
{
    //use SoftDeletes;
    protected $table = "komentar";
    protected $fillable = ['revisi_id','user_id','komentar'];
    //

    protected $casts = [
        'updated_at' => 'datetime:d M Y - H:i',
        'created_at' => 'datetime:d M Y - H:i',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
