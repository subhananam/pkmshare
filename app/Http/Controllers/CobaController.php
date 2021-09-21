<?php

namespace App\Http\Controllers;

use App\Komentar;
use Illuminate\Http\Request;

class CobaController extends Controller
{
    public function coba_insert(){
        $hasil = Komentar::create([
            'revisi_id' => 1,
            'user_id' => 2,
            'komentar' => 'Coba insert komentar'
        ]);
        if($hasil){
            echo "Berhasil simpan data";
        } else {
            echo "Gagal simpan data";
        }
    }
    public function coba_update($id){
        $hasil = Komentar::where('id', $id)->update([
            'revisi_id' => 1,
            'user_id' => 2,
            'komentar' => 'Coba Update komentar'
        ]);
        if($hasil){
            echo "Berhasil Update data";
        } else {
            echo "Gagal Update data";
        }
    }

    public function coba_hapus($id){
        $hasil = Komentar::destroy($id);
        if($hasil){
            echo "Berhasil Hapus data";
        } else {
            echo "Gagal Hapus data";
        }
    }

    public function lihat_semua(){
        $hasil = Komentar::with('user')->get();
        return response()->json($hasil);
    }
}
