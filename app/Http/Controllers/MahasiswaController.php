<?php

namespace App\Http\Controllers;

use App\Mahasiswa;
use App\Anggota;
use App\Bimbingan;
use App\JenisPKM;
use App\Komentar;
use App\Notifications\EmailNotification;
use App\PKM;
use App\ProfilDosen;
use App\ProfilMhs;
use App\Revisi;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MahasiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'mhs']);
    }

    //Profile
    public function Profile()
    {
        $gender = $this->gender();
        $title = 'My Profile';
        return view('Mahasiswa/Profile', ['title' => $title, 'gender' => $gender]);
    }
    public function GetProfile()
    {
        $id = Auth::id();
        $Profile = ProfilMhs::where('user_id', $id)->first();
        return response()->json(["profile" => $Profile]);
    }
    public function AddProfile(Request $request)
    {
        $umur = Carbon::parse($request->tgl_lahir)->age;

        $id = Auth::id();

        $request->merge([
            'user_id' => $id,
            'umur' => $umur
        ]);
        $result = ProfilMhs::create($request->all());

        if ($result) {
            return response()->json(["IsSuccess" => true, "id" => $result->id]);
        } else {
            return response()->json(["IsSuccess" => false]);
        }
    }
    public function UpdateProfile(Request $request, ProfilMhs $profilMhs)
    {
        $umur = Carbon::parse($request->tgl_lahir)->age;

        $id = Auth::id();

        $result = ProfilMhs::where('id', $profilMhs->id)
            ->update([
                'user_id' => $id,
                'nim' => $request->nim,
                'nama_lengkap' => $request->nama_lengkap,
                'tempat_lahir' => $request->tempat_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'agama' => $request->agama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'umur' => $umur,
                'program_studi' => $request->program_studi,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp
            ]);
        if ($result) {
            return response()->json(["IsSuccess" => true]);
        } else {
            return response()->json(["IsSuccess" => false]);
        }
    }


    //Anggota
    public function Anggota()
    {
        $gender = $this->gender();
        $title = 'Pendaftaran Anggota';
        $id = Auth::id();
        $is_registered = PKM::where('user_id', $id)->count();
        if ($is_registered > 0){
            $status_pkm = PKM::where('user_id', $id)->first()->status;
        } else {
            $status_pkm = "Belum mendaftar PKM";
        }
        
        return view('Mahasiswa/Anggota', ['title' => $title, 'gender' => $gender, 'status_pkm' => $status_pkm]);
    }
    public function GetAnggota()
    {
        $id = Auth::id();
        $Anggota = Anggota::where('user_id', $id)->get();
        return response()->json(["anggota" => $Anggota]);
    }
    public function AddAnggota(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'unique:anggota'],
            'nim' => ['required', 'string', 'max:255', 'unique:profil_mhs', 'unique:anggota'],
        ], [
            'required'  => ':attribute tidak boleh kosong',
            'unique'    => ':attribute sudah terdaftar',
        ]);
        if ($validator->fails()) {
            $message = [
                "IsValid" => false,
                "IsSuccess" => false,
                "error_msg" => $validator->messages()
            ];
            return response()->json($message);
        } else {
            $umur = Carbon::parse($request->tgl_lahir)->age;

            $id = Auth::id();
            $cek_pkm = PKM::where('user_id', $id)->count();

            if ($cek_pkm > 0) {
                $pkm = PKM::where('user_id', $id)->first();
                $pkm_id = $pkm->id;
            } else {
                $pkm_id = NULL;
            }

            $request->merge([
                'user_id' => Auth::id(),
                'pkm_id' => $pkm_id,
                'umur' => $umur
            ]);
            $result = Anggota::create($request->all());

            $jumlah_anggota = Anggota::where('user_id', $id)->count();
            if ($cek_pkm > 0) {
                PKM::where('user_id', $id)
                    ->update([
                        'jumlah_anggota' => $jumlah_anggota
                    ]);
            }

            if ($result) {
                return response()->json(["IsSuccess" => true, "IsValid" => true]);
            } else {
                $message = [
                    "IsValid" => true,
                    "IsSuccess" => false,
                    "error_msg" => "Fail"
                ];
                return response()->json($message);
            }
        }
    }
    public function UpdateAnggota(Request $request, Anggota $anggota)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', Rule::unique('anggota')->ignore($anggota->id, 'id')],
            'nim' => ['required', 'string', 'max:255', 'unique:profil_mhs', Rule::unique('anggota')->ignore($anggota->id, 'id')],
        ], [
            'required'  => ':attribute tidak boleh kosong',
            'unique'    => ':attribute sudah terdaftar',
        ]);
        if ($validator->fails()) {
            $message = [
                "IsValid" => false,
                "IsSuccess" => false,
                "error_msg" => $validator->messages()
            ];
            return response()->json($message);
        } else {
            $umur = Carbon::parse($request->tgl_lahir)->age;

            $id = Auth::id();
            $cek_pkm = PKM::where('user_id', $id)->count();

            if ($cek_pkm > 0) {
                $pkm = PKM::where('user_id', $id)->first();
                $pkm_id = $pkm->id;
            } else {
                $pkm_id = NULL;
            }

            $result = Anggota::where('id', $anggota->id)
                ->update([
                    'user_id' => Auth::id(),
                    'pkm_id' => $pkm_id,
                    'nim' => $request->nim,
                    'nama_lengkap' => $request->nama_lengkap,
                    'tempat_lahir' => $request->tempat_lahir,
                    'tgl_lahir' => $request->tgl_lahir,
                    'agama' => $request->agama,
                    'jenis_kelamin' => $request->jenis_kelamin,
                    'umur' => $umur,
                    'program_studi' => $request->program_studi,
                    'alamat' => $request->alamat,
                    'email' => $request->email,
                    'no_hp' => $request->no_hp
                ]);
            if ($result) {
                return response()->json(["IsSuccess" => true, "IsValid" => true]);
            } else {
                $message = [
                    "IsValid" => true,
                    "IsSuccess" => false,
                    "error_msg" => "Fail"
                ];
                return response()->json($message);
            }
        }
    }
    public function DeleteAnggota(Anggota $anggota)
    {
        $result = Anggota::destroy($anggota->id);
        $id = Auth::id();
        $jumlah_anggota = Anggota::where('user_id', $id)->count();
        $cek_pkm = PKM::where('user_id', $id)->count();
        if ($cek_pkm > 0) {
            PKM::where('user_id', $id)
                ->update([
                    'jumlah_anggota' => $jumlah_anggota
                ]);
        }
        if ($result) {
            return response()->json(["IsSuccess" => true]);
        } else {
            return response()->json(["IsSuccess" => false]);
        }
    }

    //PKM
    public function PKM()
    {
        $title = 'Pendaftaran PKM';
        $jenisPKM = JenisPKM::all();
        $pembimbing_id = User::select("id")->where("role", "Pembimbing")->get();
        $pembimbing = ProfilDosen::whereIn('user_id', $pembimbing_id)->get();
        $gender = $this->gender();
        return view('Mahasiswa/PKM', ['title' => $title, 'jenisPKM' => $jenisPKM, 'pembimbing' => $pembimbing, 'gender' => $gender]);
    }
    public function GetPKM()
    {
        $id = Auth::id();
        $result = PKM::where('user_id', $id)->with("pembimbing:id,name", "jenis_pkm:id,nama_pkm")->get();
        return response()->json(["pkm" => $result]);
    }
    public function AddPKM(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul_pkm' => ['required', 'string', 'max:255', 'unique:pkm'],
        ], [
            'required'  => ':attribute tidak boleh kosong',
            'unique'    => ':attribute sudah terdaftar',
        ]);

        if ($validator->fails()) {
            $message = [
                "IsValid" => false,
                "IsSuccess" => false,
                "error_msg" => $validator->messages()
            ];
            return response()->json($message);
        } else {

            $id = Auth::id();
            $jumlah_anggota = Anggota::where('user_id', $id)->count();

            $new_jenis_pkm_id = $request->jenis_pkm_id;
            $new_dosen_pem_id = $request->dosen_pem_id;

            $request->merge([
                'user_id' => $id,
                'jumlah_anggota' => $jumlah_anggota,
                'status' => 'Pengajuan'
            ]);
            $result = PKM::create($request->all());
            $pkm_id = $result->id;
            $anggota = Anggota::where('user_id', $id)
                ->update([
                    'pkm_id' => $pkm_id
                ]);
            if ($result) {
                $this->UpdateKuota(null, $new_jenis_pkm_id, null, $new_dosen_pem_id);
                return response()->json(["IsSuccess" => true]);
            } else {
                return response()->json(["IsSuccess" => false]);
            }
        }
    }
    public function UpdatePKM(Request $request, PKM $pkm)
    {
        $validator = Validator::make($request->all(), [
            'judul_pkm' => ['required', 'string', 'max:255', Rule::unique('pkm')->ignore($pkm->id, 'id')],
        ], [
            'required'  => ':attribute tidak boleh kosong',
            'unique'    => ':attribute sudah terdaftar',
        ]);

        if ($validator->fails()) {
            $message = [
                "IsValid" => false,
                "IsSuccess" => false,
                "error_msg" => $validator->messages()
            ];
            return response()->json($message);
        } else {

            $id = Auth::id();
            $jumlah_anggota = Anggota::where('user_id', $id)->count();

            $pkm = PKM::where('user_id', $id)->first();
            $old_jenis_pkm_id = $pkm->jenis_pkm_id;
            $new_jenis_pkm_id = $request->jenis_pkm_id;
            $old_dosen_pem_id = $pkm->dosen_pem_id;
            $new_dosen_pem_id = $request->dosen_pem_id;

            $result = PKM::where('id', $pkm->id)
                ->update([
                    'user_id' => $id,
                    'jenis_pkm_id' => $request->jenis_pkm_id,
                    'dosen_pem_id' => $request->dosen_pem_id,
                    'judul_pkm' => $request->judul_pkm,
                    'latar_belakang' => $request->latar_belakang,
                    'tujuan' => $request->tujuan,
                    'manfaat' => $request->manfaat,
                    'jumlah_anggota' => $jumlah_anggota
                ]);
            $anggota = Anggota::where('user_id', $id)
                ->update([
                    'pkm_id' => $pkm->id
                ]);
            if ($result) {
                $this->UpdateKuota($old_jenis_pkm_id, $new_jenis_pkm_id, $old_dosen_pem_id, $new_dosen_pem_id);
                return response()->json(["IsSuccess" => true]);
            } else {
                return response()->json(["IsSuccess" => false]);
            }
        }
    }
    public function DeletePKM(PKM $pkm)
    {
        $result = PKM::destroy($pkm->id);
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
        $id = Auth::id();
        $is_registered = PKM::where('user_id', $id)->count();
        if($is_registered > 0){
            $status = PKM::where("user_id", $id)->first()->status;
        } else {
            $status = "Belum mendaftar PKM";
        }
        
        return view('Mahasiswa/Bimbingan', ['title' => $title, 'gender' =>  $gender, 'status' => $status]);
    }
    public function GetBimbingan()
    {
        $id = Auth::id();
        $Bimbingan = Bimbingan::where('user_id', $id)->with("pkm:id,judul_pkm", "revisi")->get();
        return response()->json(["bimbingan" => $Bimbingan]);
    }
    public function AddBimbingan(Request $request)
    {
        $id = Auth::id();

        $file = $request->file("upload_bimbingan");
        $fileName = $file->getClientOriginalName();
        $extention = $file->getClientOriginalExtension();
        $newName = time() . "." . $extention;
        $fileLocation = Storage::putFileAs("public/dokumen/bimbingan", $file, $newName);

        $pkm = PKM::where('user_id', $id)->first();

        $result = Bimbingan::create([
            "user_id" => $id,
            "pkm_id" => $pkm->id,
            "nama_file" => $fileName,
            "lokasi_file" => $fileLocation
        ]);
        $user = User::where('id', $pkm->dosen_pem_id)->first();
        if ($result) {
            $this->SendEmailNotification($user);
            return response()->json(["IsSuccess" => true]);
        } else {
            return response()->json(["IsSuccess" => false]);
        }
    }
    public function UpdateBimbingan(Request $request, Bimbingan $bimbingan)
    {
        $id = Auth::id();

        $file = $request->file("upload_bimbingan");
        $fileName = $file->getClientOriginalName();
        $extention = $file->getClientOriginalExtension();
        $newName = time() . "." . $extention;
        $fileLocation = Storage::putFileAs("public/dokumen/bimbingan", $file, $newName);

        $pkm = PKM::where('user_id', $id)->first();

        $result = Bimbingan::where('id', $bimbingan->id)
            ->update([
                "user_id" => $id,
                "pkm_id" => $pkm->id,
                "nama_file" => $fileName,
                "lokasi_file" => $fileLocation
            ]);
        $user = User::where('id', $pkm->dosen_pem_id)->first();
        if ($result) {
            $this->SendEmailNotification($user);
            return response()->json(["IsSuccess" => true]);
        } else {
            return response()->json(["IsSuccess" => false]);
        }
    }
    public function DeleteBimbingan(Bimbingan $bimbingan)
    {
        $result = Bimbingan::destroy($bimbingan->id);
        if ($result) {
            return response()->json(["IsSuccess" => true]);
        } else {
            return response()->json(["IsSuccess" => false]);
        }
    }

    public function DownloadRevisi(Revisi $revisi)
    {
        $revisi = Revisi::where('id', $revisi->id)->first();
        try {
            return Storage::download($revisi->lokasi_file, $revisi->nama_file);
        } catch (\Exception $e) {
            return $e->getMessage();
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



    private function UpdateKuota(
        $old_jenis_pkm_id = null,
        $new_jenis_pkm_id,
        $old_dosen_pem_id = null,
        $new_dosen_pem_id
    ) {
        //Update Kuota PKM
        if ($old_jenis_pkm_id != null) {
            $old_kuota_pkm = PKM::where('jenis_pkm_id', $old_jenis_pkm_id)->count();
            JenisPKM::where('id', $old_jenis_pkm_id)
                ->update([
                    'jumlah_pendaftar' => $old_kuota_pkm
                ]);
        }
        $new_kuota_pkm = PKM::where('jenis_pkm_id', $new_jenis_pkm_id)->count();
        JenisPKM::where('id', $new_jenis_pkm_id)
            ->update([
                'jumlah_pendaftar' => $new_kuota_pkm
            ]);

        //Update Kuota Dosen
        if ($old_dosen_pem_id != null) {
            $old_kuota_dosen = PKM::where('dosen_pem_id', $old_dosen_pem_id)->count();
            ProfilDosen::where('user_id', $old_dosen_pem_id)
                ->update([
                    'jumlah_pendaftar' => $old_kuota_dosen
                ]);
        }
        $new_kuota_dosen = PKM::where('dosen_pem_id', $new_dosen_pem_id)->count();
        ProfilDosen::where('user_id', $new_dosen_pem_id)
            ->update([
                'jumlah_pendaftar' => $new_kuota_dosen
            ]);
    }

    private function SendEmailNotification($user)
    {

        $details = [

            'greeting' => 'Hallo',

            'body' => 'Silahkan buka aplikasi PKM anda dan cek dibagian Bimbingan, Mahasiswa bimbingan anda telah mengirimkan file revisi proposal',

            'thanks' => 'Terimakasih telah menggunakan Aplikasi PKM',

            'actionText' => 'Lihat Bimbingan',

            'actionURL' => url('/pembimbing/bimbingan')

        ];
        $user->notify(new EmailNotification($details));
    }

    private function gender()
    {
        $id = Auth::id();
        $profil = ProfilMhs::where('user_id', $id)->first();
        if ($profil) {
            $gender = $profil->jenis_kelamin;
        } else {
            $gender = 'Laki-laki';
        }
        return $gender;
    }
}
