<?php

namespace App\Http\Controllers;

use App\JenisPKM;
use App\KriteriaPenilaian;
use App\Notifications\EmailNotification;
use App\PKM;
use App\ProfilDosen;
use App\ProfilMhs;
use App\User;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'admin']);
    }
    //Profile
    public function Profile()
    {
        $gender = $this->gender();
        $title = 'My Profile';
        return view('Admin/Profile', ['title' => $title, 'gender' => $gender]);
    }
    public function GetProfile()
    {
        $id = Auth::id();
        $Profile = ProfilDosen::where('user_id', $id)->first();
        return response()->json(["profile" => $Profile]);
    }
    public function UpdateProfile(Request $request)
    {
        $umur = Carbon::parse($request->tgl_lahir)->age;

        $id = Auth::id();

        $cek_profil = ProfilDosen::where("user_id", $id)->count();

        if ($cek_profil < 1) {

            $validator = Validator::make($request->all(), [
                'nidn' => ['required', 'string', 'max:255', 'unique:profil_dosen'],
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
                $result = ProfilDosen::create([
                    'user_id' => $id,
                    'nidn' => $request->nidn,
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
            }
        } else {
            $result = ProfilDosen::where('user_id', $id)
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
        }
        if ($result) {
            return response()->json(["IsValid" => true, "IsSuccess" => true]);
        } else {
            return response()->json(["IsValid" => true, "IsSuccess" => false]);
        }
    }

    //Jenis PKM
    public function JenisPKM()
    {
        $title = 'Jenis PKM';
        $gender = $this->gender();
        return view('Admin/JenisPKM', ['title' => $title, 'gender' => $gender]);
    }

    public function GetJenisPKM()
    {
        $result = JenisPKM::all();
        return response()->json(["jenispkm" => $result]);
    }

    public function AddJenisPKM(Request $request)
    {
        $request->merge([
            'jumlah_pendaftar' => 0
        ]);
        $result = JenisPKM::create($request->all());
        if ($result) {
            return response()->json(["IsSuccess" => true]);
        } else {
            return response()->json(["IsSuccess" => false]);
        }
    }

    public function UpdateJenisPKM(Request $request, JenisPKM $jenisPKM)
    {
        $result = JenisPKM::where('id', $jenisPKM->id)
            ->update([
                'nama_pkm' => $request->nama_pkm,
                'kuota' => $request->kuota,
                'penjelasan_umum' => $request->penjelasan_umum
            ]);
        if ($result) {
            return response()->json(["IsSuccess" => true]);
        } else {
            return response()->json(["IsSuccess" => false]);
        }
    }

    public function DeleteJenisPKM(JenisPKM $jenisPKM)
    {
        $result = JenisPKM::destroy($jenisPKM->id);
        if ($result) {
            return response()->json(["IsSuccess" => true]);
        } else {
            return response()->json(["IsSuccess" => false]);
        }
    }

    //Kriteria Penilaian

    public function KriteriaPenilaian()
    {
        $title = 'Kriteria Penilaian';
        $jenisPKM = JenisPKM::all();
        $gender = $this->gender();
        return view('Admin/KriteriaPenilaian', ['title' => $title, 'jenisPKM' => $jenisPKM, 'gender' => $gender]);
    }

    public function GetKriteriaPenilaian($jenis_pkm_id)
    {
        $result = KriteriaPenilaian::where(['jenis_pkm_id' => $jenis_pkm_id])->with("jenis_pkm:id,nama_pkm")->get();
        return response()->json(["kriteria" => $result]);
    }

    public function AddKriteriaPenilaian(Request $request)
    {
        $result = KriteriaPenilaian::create($request->all());
        if ($result) {
            return response()->json(["IsSuccess" => true]);
        } else {
            return response()->json(["IsSuccess" => false]);
        }
    }

    public function UpdateKriteriaPenilaian(Request $request, KriteriaPenilaian $kriteriaPenilaian)
    {
        $result = KriteriaPenilaian::where('id', $kriteriaPenilaian->id)
            ->update([
                'jenis_pkm_id' => $request->jenis_pkm_id,
                'kriteria' => $request->kriteria,
                'bobot' => $request->bobot
            ]);
        if ($result) {
            return response()->json(["IsSuccess" => true]);
        } else {
            return response()->json(["IsSuccess" => false]);
        }
    }

    public function DeleteKriteriaPenilaian(KriteriaPenilaian $kriteriaPenilaian)
    {
        $result = KriteriaPenilaian::destroy($kriteriaPenilaian->id);
        if ($result) {
            return response()->json(["IsSuccess" => true]);
        } else {
            return response()->json(["IsSuccess" => false]);
        }
    }


    //Add User
    public function User()
    {
        $title = 'Tambah User';
        $gender = $this->gender();
        return view('Admin/AddUser', ['title' => $title, 'gender' => $gender]);
    }

    public function GetUser()
    {
        $result = User::where("role", "=", "Pembimbing")->orWhere("role", "=", "Wadir")->with("profil_dosen")->get();
        return response()->json(["user" => $result]);
    }

    public function AddUser(Request $request)
    {
        $umur = Carbon::parse($request->tgl_lahir)->age;

        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', 'unique:anggota'],
            'nidn' => ['required', 'string', 'max:255', 'unique:profil_dosen'],
            'password' => ['required', 'string', 'min:8'],
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
            $current_time = Carbon::now()->toDateTimeString();
            $user_create = User::create([
                'name' => $request->nama_lengkap,
                'email' => $request->email,
                'role' => $request->jabatan,
                'password' => Hash::make($request->password),
                'email_verified_at' => $current_time
            ]);
            $profil_create = ProfilDosen::create([
                'user_id' => $user_create->id,
                'nidn' => $request->nidn,
                'nama_lengkap' => $request->nama_lengkap,
                'tempat_lahir' => $request->tempat_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'agama' => $request->agama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'umur' => $umur,
                'jabatan' => $request->jabatan,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'jumlah_pendaftar' => $request->jabatan == "Pembimbing" ? 0 : null,
                'kuota' =>  $request->jabatan == "Pembimbing" ? $request->kuota : null
            ]);
            if ($user_create && $profil_create) {
                $this->SendEmailNotification($user_create, 'Add User', $request->password);
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

    public function DeleteUser(User $user)
    {
        $cek_profil = ProfilDosen::where('user_id', $user->id)->count();
        if($cek_profil > 0){
            $profilDelete = ProfilDosen::where('user_id', $user->id)->delete();
        }
        $result = User::destroy($user->id);
        if ($result && $profilDelete) {
            return response()->json(["IsSuccess" => true]);
        } else {
            return response()->json(["IsSuccess" => false]);
        }
    }


    //Seleksi Tahap 1
    public function Seleksi1()
    {
        $title = 'Seleksi Tahap 1';
        $pembimbing = User::where('role', 'Pembimbing')->get();
        $gender = $this->gender();
        return view('Admin/Seleksi1', ['title' => $title, 'pembimbing' => $pembimbing, 'gender' => $gender]);
    }
    public function GetSeleksi1()
    {
        $result = PKM::select("id", "user_id", "jenis_pkm_id", "dosen_pem_id", "judul_pkm", "jumlah_anggota", "status")
            ->where("status", "Penilaian Tahap 1")
            ->orWhere("status", "Eliminasi Tahap 1")
            ->orWhere("status", "Bimbingan")
            ->with("pembimbing:id,name", "jenis_pkm:id,nama_pkm", "penilaian_tahap_1")
            ->withCount("bimbingan")->get();
        return response()->json(["pkm" => $result]);
    }
    public function EditStatusSeleksi1(Request $request)
    {
        $result = PKM::where('id', $request->pkm_id)
            ->update([
                'status' => $request->status
            ]);
        
        if ($result) {
            $pkm = PKM::where('id', $request->pkm_id)->first();
            $user = User::where('id',$pkm->user_id)->first();
            $this->SendEmailNotification($user, $request->status, null);
            return response()->json(["IsSuccess" => true]);
        } else {
            return response()->json(["IsSuccess" => false]);
        }
    }

    //Seleksi Tahap 2
    public function Seleksi2()
    {
        $title = 'Seleksi Tahap 2';
        $pembimbing = User::where('role', 'Pembimbing')->get();
        $gender = $this->gender();
        return view('Admin/Seleksi2', ['title' => $title, 'pembimbing' => $pembimbing, 'gender' => $gender]);
    }
    public function GetSeleksi2()
    {
        $result = PKM::select("id", "user_id", "jenis_pkm_id", "dosen_pem_id", "judul_pkm", "jumlah_anggota", "status")
            ->where("status", "Penilaian Tahap 2")
            ->orWhere("status", "Eliminasi Tahap 2")
            ->orWhere("status", "Lolos Tahap Pendanaan")
            ->with("pembimbing:id,name", "jenis_pkm:id,nama_pkm", "penilaian_tahap_2")->get();
        return response()->json(["pkm" => $result]);
    }
    public function EditStatusSeleksi2(Request $request)
    {
        $result = PKM::where('id', $request->pkm_id)
            ->update([
                'status' => $request->status
            ]);
            
        if ($result) {
            $pkm = PKM::where('id', $request->pkm_id)->first();
            $user = User::where('id',$pkm->user_id)->first();
            $this->SendEmailNotification($user, $request->status, null);
            return response()->json(["IsSuccess" => true]);
        } else {
            return response()->json(["IsSuccess" => false]);
        }
    }

    private function SendEmailNotification($user, $action, $pw = null)
    {
        if($action == "Bimbingan"){
            $body = "Selamat, proposal PKM yang telah anda ajukan lolos ke tahap Bimbingan. Segera upload file Bimbingan Anda";
            $actionText = "Mulai Bimbingan";
            $actionURL = url('/mahasiswa/bimbingan');
        } else if ($action == "Eliminasi Tahap 1"){
            $body = "Maaf, proposal PKM yang anda ajukan tidak lolos karena jumlah nilai belum memenuhi syarat lolos. Silahkan bisa mencoba pada lain kesempatan. Jangan patah semangat dan tetap gali kemampuan menulis anda";
            $actionText = "Lihat Status PKM";
            $actionURL = url('/mahasiswa/pkm');
        } else if ($action == "Penilaian Tahap 1"){
            $body = "Maaf telah terjadi kesalahan, status PKM anda kami kembalikan ke Penilaian Tahap 1";
            $actionText = "Lihat Status PKM";
            $actionURL = url('/mahasiswa/pkm');
        }else if ($action == "Lolos Tahap Pendanaan"){
            $body = "Selamat, anda telah menyelesaikan bimbingan dengan baik dan proposal PKM anda lolos ketahap pendanaan";
            $actionText = "Lihat Status PKM";
            $actionURL = url('/mahasiswa/pkm');
        } else if ($action == "Eliminasi Tahap 2"){
            $body = "Maaf, proposal PKM anda tidak lolos ketahap pendanaan karena jumlah nilai tidak memenuhi syarat lolos pendanaan. Jangan patah semangat dan tetap kembangkan bakat menulis anda";
            $actionText = "Lihat Status PKM";
            $actionURL = url('/mahasiswa/pkm');
        } else if ($action == "Penilaian Tahap 2"){
            $body = "Maaf telah terjadi kesalahan, status PKM anda kami kembalikan ke Penilaian Tahap 2";
            $actionText = "Lihat Status PKM";
            $actionURL = url('/mahasiswa/pkm');
        }else if ($action == "Add User"){
            $body = "Selamat, akun anda berhasil dibuat sebagai " . $user->role . " di aplikasi PKM | 
                     username : " . $user->email . " | 
                     password : " . $pw;
            $actionText = "Login ke aplikasi PKM";
            $actionURL = url('/login');
        }

        $details = [

            'greeting' => 'Hallo',

            'body' => $body,

            'thanks' => 'Terimakasih telah menggunakan Aplikasi PKM',

            'actionText' => $actionText,

            'actionURL' => $actionURL

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
