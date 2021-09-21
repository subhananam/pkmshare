<?php

namespace App\Http\Controllers;

use App\Bimbingan;
use App\JenisPKM;
use App\Komentar;
use App\KriteriaPenilaian;
use App\Notifications\EmailNotification;
use App\PenilaianTahap1;
use App\PenilaianTahap2;
use App\PKM;
use App\ProfilDosen;
use App\Revisi;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PembimbingController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'pembimbing']);
    }
    //Profile
    public function Profile()
    {
        $gender = $this->gender();
        $title = 'My Profile';
        return view('Pembimbing/Profile', ['title' => $title, 'gender' => $gender]);
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
        $title = 'Penilaian Tahap 1';
        $jenisPKM = JenisPKM::all();
        $pembimbing = ProfilDosen::all();
        $gender = $this->gender();
        return view('Pembimbing/PKM', ['title' => $title, 'jenisPKM' => $jenisPKM, 'pembimbing' => $pembimbing, 'gender' => $gender]);
    }
    public function GetPKM()
    {
        $id = Auth::id();
        $result = PKM::where(['dosen_pem_id' => $id, 'status' => 'Pengajuan'])->orWhere(['status' => 'Penilaian Tahap 1'])->with("pembimbing:id,name", "jenis_pkm:id,nama_pkm", "penilaian_tahap_1")->get();
        return response()->json(["pkm" => $result]);
    }

    //Penilaian Tahap 1
    public function AddNilaiTahapPertama(Request $request)
    {
        $data = $request->all();
        $result = PenilaianTahap1::create($request->all());
        $update = PKM::where('id', $request->pkm_id)
            ->update([
                'status' => 'Penilaian Tahap 1'
            ]);
        if ($result && $update) {
            return response()->json(["IsSuccess" => true]);
        } else {
            return response()->json(["IsSuccess" => false]);
        }
    }
    public function EditNilaiTahapPertama(Request $request)
    {
        $result = PenilaianTahap1::where('id', $request->id)
            ->update([
                'nilai_judul' => $request->nilai_judul,
                'nilai_lb' => $request->nilai_lb,
                'nilai_tujuan' => $request->nilai_tujuan,
                'nilai_manfaat' => $request->nilai_manfaat,
            ]);
        if ($result) {
            return response()->json(["IsSuccess" => true]);
        } else {
            return response()->json(["IsSuccess" => false]);
        }
    }

    //Bimbingan
    public function Bimbingan()
    {
        $title = 'Bimbingan';
        $gender = $this->gender();
        return view('Pembimbing/Bimbingan', ['title' => $title, 'gender' =>  $gender]);
    }
    public function GetBimbingan()
    {
        $id = Auth::id();
        $pkm = PKM::where('dosen_pem_id', $id)->get();
        foreach ($pkm as $p) {
            $pkm_id[] = $p->id;
        }

        $Bimbingan = Bimbingan::whereIn('pkm_id', $pkm_id)->with("pkm:id,judul_pkm", "revisi")->get();
        return response()->json(["bimbingan" => $Bimbingan]);
    }
    public function DownloadBimbingan(Bimbingan $bimbingan)
    {
        $bimbingan = Bimbingan::where('id', $bimbingan->id)->first();
        try{
            return Storage::download($bimbingan->lokasi_file, $bimbingan->nama_file);
        }
        catch(\Exception $e ){
            return $e->getMessage();
        }
    }


    public function AddRevisi(Request $request)
    {
        $id = Auth::id();

        $file = $request->file("upload_revisi");
        $fileName = $file->getClientOriginalName();
        $extention = $file->getClientOriginalExtension();
        $newName = time() . "." . $extention;
        $fileLocation = Storage::putFileAs("public/dokumen/revisi", $file, $newName);

        $result = Revisi::create([
            "bimbingan_id" => $request->bimbingan_id,
            "nama_file" => $fileName,
            "lokasi_file" => $fileLocation,
            "komentar" => $request->komentar
        ]);

        $bimbingan = Bimbingan::where('id', $request->bimbingan_id)->first();
        $user = User::where('id', $bimbingan->user_id)->first();

        if ($result) {
            $this->SendEmailNotification($user);
            return response()->json(["IsSuccess" => true]);
        } else {
            return response()->json(["IsSuccess" => false]);
        }
    }
    public function UpdateRevisi(Request $request, Revisi $revisi)
    {
        $id = Auth::id();

        $revisi = Revisi::where("id", $revisi->id)->first();

        
        if ($request->file_name == $revisi->nama_file) {
            $result = Revisi::where('id', $revisi->id)
                ->update([
                    "komentar" => $request->komentar
                ]);
        } else {
            $file = $request->file("upload_revisi");
            $fileName = $file->getClientOriginalName();
            $extention = $file->getClientOriginalExtension();
            $newName = time() . "." . $extention;
            $fileLocation = Storage::putFileAs("public/dokumen/revisi", $file, $newName);

            $result = Revisi::where('id', $revisi->id)
                ->update([
                    "nama_file" => $fileName,
                    "lokasi_file" => $fileLocation,
                    "komentar" => $request->komentar
                ]);
        }
        $bimbingan = Bimbingan::where('id', $request->bimbingan_id)->first();
        $user = User::where('id', $bimbingan->user_id)->first();
        if ($result) {
            $this->SendEmailNotification($user);
            return response()->json(["IsSuccess" => true]);
        } else {
            return response()->json(["IsSuccess" => false]);
        }
    }
    public function DeleteRevisi(Revisi $revisi)
    {
        $result = Revisi::destroy($revisi->id);
        if ($result) {
            return response()->json(["IsSuccess" => true]);
        } else {
            return response()->json(["IsSuccess" => false]);
        }
    }

    //Komentar
    public function GetAllKomentar(Revisi $revisi)
    {
        $comment = Komentar::where("revisi_id", $revisi->id)->with("user:id,name")->get();
        return response()->json(["komentar" => $comment]);
    }
    public function AddKomentar(Request $request)
    {
        $id = Auth::id();
        $request->merge([
            'user_id' => $id
        ]);
        $result = Komentar::create($request->all());
        if ($result) {
            return response()->json(["IsSuccess" => true]);
        } else {
            return response()->json(["IsSuccess" => false]);
        }
    }

    //Penilaian Tahap 2
    public function NilaiTahapKedua(PKM $pkm)
    {
        $title = 'Penilaian Tahap 2';
        $gender = $this->gender();
        $pkm = PKM::where('id', $pkm->id)->with('anggota','jenis_pkm:id,nama_pkm','pembimbing:id,name')->first();
        return view('Pembimbing/Nilai2', ['title' => $title, 'gender' => $gender, 'pkm' =>  $pkm]);
        //return $pkm;
    }
    public function GetNilaiTahapKedua(PKM $pkm)
    {
        $cek_penilaian = DB::table('kriteria_penilaian')
            ->leftJoin('penilaian_tahap_2', 'kriteria_penilaian.id', '=', 'penilaian_tahap_2.kriteria_id')
            ->where("kriteria_penilaian.jenis_pkm_id",'=', $pkm->jenis_pkm_id)
            ->where('penilaian_tahap_2.pkm_id', '=', $pkm->id)
            ->count();

        $penilaian = DB::table('kriteria_penilaian')
            ->leftJoin('penilaian_tahap_2', 'kriteria_penilaian.id', '=', 'penilaian_tahap_2.kriteria_id')
            ->select('penilaian_tahap_2.*', 'kriteria_penilaian.*', 'penilaian_tahap_2.id as nilai_id')
            ->where("kriteria_penilaian.jenis_pkm_id",'=', $pkm->jenis_pkm_id)
            ->where('penilaian_tahap_2.pkm_id', '=', $pkm->id)
            ->orderBy('kriteria_penilaian.id', 'asc')
            ->get();
        $kriteria_penilaian = KriteriaPenilaian::where('jenis_pkm_id', $pkm->jenis_pkm_id)->orderBy('id', 'asc')->get();

        if($cek_penilaian > 0){
            return response()->json(["penilaian" => $penilaian]);
        } else {
            return response()->json(["penilaian" => $kriteria_penilaian]);
        }
        
    }
    public function AddNilaiTahapKedua(Request $request)
    {
        $result = true;
        $data_nilai = explode(";", $request->nilai);
        foreach($data_nilai as $dn){
            $data = explode(",", $dn);
            $nilai_id = $data[0];
            $kriteria_id = $data[1];
            $bobot = $data[2];
            $skor = $data[3];
            $nilai = $bobot * $skor;

            if($nilai_id == 0){
                $insert = PenilaianTahap2::create([
                    "pkm_id" => $request->pkm_id,
                    "kriteria_id" => $kriteria_id,
                    "skor" => $skor,
                    "nilai" => $nilai
                ]);
                if(!$insert){
                    $result = false;
                }
            } else {
                $update = PenilaianTahap2::where("id", $nilai_id)
                ->update([
                    "skor" => $skor,
                    "nilai" => $nilai
                ]);
                if(!$update){
                    $result = false;
                }
            }
        }
        $update = PKM::where('id', $request->pkm_id)
            ->update([
                'status' => 'Penilaian Tahap 2'
            ]);
        if ($result && $update) {
            return response()->json(["IsSuccess" => true]);
        } else {
            return response()->json(["IsSuccess" => false]);
        }
    }

    private function SendEmailNotification($user){

        $details = [

            'greeting' => 'Hallo',

            'body' => 'Silahkan buka aplikasi PKM dan cek pada bagian bimbingan, 
                        dosen pembimbing anda sudah mengirimkan revisi proposal. 
                        Segera lakukan revisi agar proposal anda cepat acc dan selesai tepat waktu.',

            'thanks' => 'Terimakasih telah menggunakan Aplikasi PKM',

            'actionText' => 'Lihat Revisi',

            'actionURL' => url('/mahasiswa/bimbingan')

        ];
        $user->notify(new EmailNotification($details));
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
