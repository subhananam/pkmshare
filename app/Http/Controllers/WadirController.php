<?php

namespace App\Http\Controllers;

use App\PKM;
use App\ProfilDosen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WadirController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'wadir']);
    }
    //Profile
    public function Profile()
    {
        $gender = $this->gender();
        $title = 'My Profile';
        return view('Wadir/Profile', ['title' => $title, 'gender' => $gender]);
    }
    public function GetProfile()
    {
        $id = Auth::id();
        $Profile = ProfilDosen::where('user_id', $id)->first();
        return response()->json(["profile" => $Profile]);
    }
    public function UpdateProfile(Request $request, ProfilDosen $profilDosen)
    {
        $umur = Carbon::parse($request->tgl_lahir)->age;

        $result = ProfilDosen::where('id', $profilDosen->id)
            ->update([
                'nama_lengkap' => $request->nama_lengkap,
                'tempat_lahir' => $request->tempat_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'agama' => $request->agama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'umur' => $umur,
                'jabatan' => $request->jabatan,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp
            ]);
        if ($result) {
            return response()->json(["IsSuccess" => true]);
        } else {
            return response()->json(["IsSuccess" => false]);
        }
    }
    //PKM
    public function PKM()
    {
        $title = 'Daftar PKM';
        //$pembimbing = User::where('role', 'Pembimbing')->get();
        $gender = $this->gender();
        return view('Wadir/PKM', ['title' => $title, 'gender' => $gender]);
    }
    public function GetPKM()
    {
        $result = PKM::select("id", "user_id", "jenis_pkm_id", "dosen_pem_id", "judul_pkm", "jumlah_anggota", "status")
            ->with("profil_mhs:id,user_id,nama_lengkap,program_studi","pembimbing:id,name", "jenis_pkm:id,nama_pkm", "penilaian_tahap_2")->get();
        return response()->json(["pkm" => $result]);
    }

    private function gender()
    {
        $id = Auth::id();
        $profil = ProfilDosen::where('user_id', $id)->first();
        if ($profil) {
            $gender = $profil->jenis_kelamin;
        } else {
            $gender = 'Laki-laki';
        }
        return $gender;
    }
}
