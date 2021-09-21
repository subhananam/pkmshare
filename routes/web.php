<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Auth;

Auth::routes(['verify' => true]);

Route::get('/', 'HomeController@index')->name('home');
Route::get('/home/jenispkm/all', 'HomeController@GetJenisPKM');
Route::get('/download/template/{jenis_pkm}', 'HomeController@DownloadTemplate');
/*
======================================Admin Route======================================
*/
//Profile
Route::get('/admin/profile', 'AdminController@Profile')->name('admin.profile');
Route::get('/admin/profile/get', 'AdminController@GetProfile');
Route::post('/admin/profile', 'AdminController@UpdateProfile');
//Jenis PKM
Route::get('/admin', 'AdminController@JenisPKM');
Route::get('/admin/jenispkm', 'AdminController@JenisPKM')->name('jenispkm');
Route::get('/admin/jenispkm/all', 'AdminController@GetJenisPKM');
Route::post('/admin/jenispkm', 'AdminController@AddJenisPKM');
Route::patch('/admin/jenispkm/{jenisPKM}', 'AdminController@UpdateJenisPKM');
Route::delete('/admin/jenispkm/{jenisPKM}', 'AdminController@DeleteJenisPKM');
//Kriteria Penilaian
Route::get('/admin/kriteria', 'AdminController@KriteriaPenilaian')->name('kriteria');
Route::get('/admin/kriteria/{jenis_pkm_id}', 'AdminController@GetKriteriaPenilaian');
Route::post('/admin/kriteria', 'AdminController@AddKriteriaPenilaian');
Route::patch('/admin/kriteria/{kriteriaPenilaian}', 'AdminController@UpdateKriteriaPenilaian');
Route::delete('/admin/kriteria/{kriteriaPenilaian}', 'AdminController@DeleteKriteriaPenilaian');
//Add User
Route::get('/admin/user', 'AdminController@User')->name('admin.user');
Route::get('/admin/user/all', 'AdminController@GetUser');
Route::post('/admin/user', 'AdminController@AddUser');
Route::post('/admin/user/mail/{user}', 'AdminController@SendEmailUser');
Route::delete('/admin/user/{user}', 'AdminController@DeleteUser');

//Seleksi Tahap 1
Route::get('/admin/seleksi1', 'AdminController@Seleksi1')->name('admin.seleksi1');
Route::get('/admin/seleksi1/all', 'AdminController@GetSeleksi1');
Route::post('/admin/seleksi1/status', 'AdminController@EditStatusSeleksi1');

//Seleksi Tahap 2
Route::get('/admin/seleksi2', 'AdminController@Seleksi2')->name('admin.seleksi2');
Route::get('/admin/seleksi2/all', 'AdminController@GetSeleksi2');
Route::post('/admin/seleksi2/status', 'AdminController@EditStatusSeleksi2');




/*
======================================Pembimbing Route======================================
*/
//Profile
Route::get('/pembimbing/profile', 'PembimbingController@Profile')->name('pembimbing.profile');
Route::get('/pembimbing/profile/get', 'PembimbingController@GetProfile');
Route::patch('/pembimbing/profile/{profilDosen}', 'PembimbingController@UpdateProfile');
//Lihat PKM
Route::get('/pembimbing', 'PembimbingController@PKM');
Route::get('/pembimbing/pkm', 'PembimbingController@PKM')->name('pembimbing.pkm');
Route::get('/pembimbing/pkm/all', 'PembimbingController@GetPKM');
Route::post('/pembimbing/pkm/nilai1/add', 'PembimbingController@AddNilaiTahapPertama');
Route::post('/pembimbing/pkm/nilai1/edit', 'PembimbingController@EditNilaiTahapPertama');

//Bimbingan
Route::get('/pembimbing/bimbingan', 'PembimbingController@Bimbingan')->name('pembimbing.bimbingan');
Route::get('/pembimbing/bimbingan/all', 'PembimbingController@GetBimbingan');
Route::get('/pembimbing/bimbingan/download/{bimbingan}', 'PembimbingController@DownloadBimbingan');
Route::post('/pembimbing/revisi', 'PembimbingController@AddRevisi');
Route::patch('/pembimbing/revisi/{revisi}', 'PembimbingController@UpdateRevisi');
Route::delete('/pembimbing/revisi/{revisi}', 'PembimbingController@DeleteRevisi');

//Komentar
Route::get('/pembimbing/komentar/all/{revisi}', 'PembimbingController@GetAllKomentar');
Route::post('/pembimbing/komentar', 'PembimbingController@AddKomentar');
//Penilaian Tahap 2
Route::get('/pembimbing/pkm/nilai2/{pkm}', 'PembimbingController@NilaiTahapKedua');
Route::get('/pembimbing/pkm/nilai2/get/{pkm}', 'PembimbingController@GetNilaiTahapKedua');
Route::post('/pembimbing/pkm/nilai2/add', 'PembimbingController@AddNilaiTahapKedua');

/*
======================================Mahasiswa Route======================================
*/
//Profile
Route::get('/mahasiswa/profile', 'MahasiswaController@Profile')->name('mahasiswa.profile');
Route::get('/mahasiswa/profile/get', 'MahasiswaController@GetProfile');
Route::post('/mahasiswa/profile', 'MahasiswaController@AddProfile');
Route::patch('/mahasiswa/profile/{profilMhs}', 'MahasiswaController@UpdateProfile');
//Anggota
Route::get('/mahasiswa', 'MahasiswaController@Anggota');
Route::get('/mahasiswa/anggota', 'MahasiswaController@Anggota')->name('anggota');
Route::get('/mahasiswa/anggota/all', 'MahasiswaController@GetAnggota');
Route::post('/mahasiswa/anggota', 'MahasiswaController@AddAnggota');
Route::patch('/mahasiswa/anggota/{anggota}', 'MahasiswaController@UpdateAnggota');
Route::delete('/mahasiswa/anggota/{anggota}', 'MahasiswaController@DeleteAnggota');
//PKM
Route::get('/mahasiswa/pkm', 'MahasiswaController@PKM')->name('pkm');
Route::get('/mahasiswa/pkm/all', 'MahasiswaController@GetPKM');
Route::post('/mahasiswa/pkm', 'MahasiswaController@AddPKM');
Route::patch('/mahasiswa/pkm/{pkm}', 'MahasiswaController@UpdatePKM');
Route::delete('/mahasiswa/pkm/{pkm}', 'MahasiswaController@DeletePKM');
//Bimbingan
Route::get('/mahasiswa/bimbingan', 'MahasiswaController@Bimbingan')->name('mahasiswa.bimbingan');
Route::get('/mahasiswa/bimbingan/all', 'MahasiswaController@GetBimbingan');
Route::get('/mahasiswa/revisi/download/{revisi}', 'MahasiswaController@DownloadRevisi');
Route::post('/mahasiswa/bimbingan', 'MahasiswaController@AddBimbingan');
Route::patch('/mahasiswa/bimbingan/{bimbingan}', 'MahasiswaController@UpdateBimbingan');
Route::delete('/mahasiswa/bimbingan/{bimbingan}', 'MahasiswaController@DeleteBimbingan');
//Komentar
Route::get('/mahasiswa/komentar/all/{revisi}', 'MahasiswaController@GetAllKomentar');
Route::post('/mahasiswa/komentar', 'MahasiswaController@AddKomentar');


/*
======================================Wadir Route======================================
*/
//Profile
Route::get('/wadir/profile', 'WadirController@Profile')->name('wadir.profile');
Route::get('/wadir/profile/get', 'WadirController@GetProfile');
Route::patch('/wadir/profile/{profilDosen}', 'WadirController@UpdateProfile');
//PKM
Route::get('/wadir', 'WadirController@PKM')->name('wadir');
Route::get('/wadir/pkm/all', 'WadirController@GetPKM');


Route::get('/lihat_semua', 'CobaController@lihat_semua');
Route::get('/coba_komen', 'CobaController@coba_insert');
Route::get('/coba_update/{id}', 'CobaController@coba_update');
Route::get('/coba_hapus/{id}', 'CobaController@coba_hapus');
