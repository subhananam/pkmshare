<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PKM extends Model
{
    //use SoftDeletes;
    protected $table = 'pkm';
    protected $fillable = [
        'user_id','jenis_pkm_id','dosen_pem_id','judul_pkm',
        'latar_belakang','tujuan','manfaat','jumlah_anggota','status'
    ];

    public function profil_mhs()
    {
        return $this->hasOne(ProfilMhs::class, 'user_id', 'user_id');
    }
    public function anggota()
    {
        return $this->hasMany(Anggota::class, 'pkm_id', 'id');
    }

    public function jenis_pkm()
    {
        return $this->hasOne(JenisPKM::class, 'id', 'jenis_pkm_id');
    }
    public function kriteria_penilaian()
    {
        return $this->hasMany(KriteriaPenilaian::class, 'jenis_pkm_id', 'jenis_pkm_id')->orderBy('id', 'asc');
    }
    public function pembimbing()
    {
        return $this->hasOne(User::class, 'id', 'dosen_pem_id');
    }
    public function penilaian_tahap_1()
    {
        return $this->hasOne(PenilaianTahap1::class, 'pkm_id', 'id');
    }
    public function bimbingan()
    {
        return $this->hasOne(Bimbingan::class, 'pkm_id', 'id');
    }
    public function penilaian_tahap_2()
    {
        return $this->hasMany(PenilaianTahap2::class, 'pkm_id', 'id')->orderBy('kriteria_id', 'asc');
    }
}
