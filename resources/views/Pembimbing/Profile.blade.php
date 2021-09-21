@extends('layouts/material-profile')

@section('title', $title)

@section('form')
<form action="POST" id="form_profile">
    <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <label class="control-label">Email</label>
                @csrf
                <input id="profile-id" type="hidden">
                <input id="email" type="text" class="form-control" value="{{  Auth::user()->email }}" disabled>
            </div>
        </div>
        <div class="col-md-7">
            <div class="form-group">
                <label class="control-label">NIDN</label>
                <input id="nidn" name="nidn" type="text" class="form-control" readonly>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label">Nama Lengkap</label>
                <input id="nama_lengkap" name="nama_lengkap" type="text" class="form-control">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">No HP</label>
                <input id="no_hp" name="no_hp" type="text" class="form-control">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">Tempat Lahir</label>
                <input id="tempat_lahir" name="tempat_lahir" type="text" class="form-control">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label">Tanggal Lahir</label>
                <input id="tgl_lahir" name="tgl_lahir" type="text" class="form-control datepicker">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Jenis Kelamin</label>
                <select id="jenis_kelamin" name="jenis_kelamin" class="form-control">
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Jabatan</label>
                <select id="jabatan" name="jabatan" class="form-control">
                    <option value="Pembimbing">Pembimbing</option>
                    <option value="Wadir">Wakil Direktur</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Agama</label>
                <select id="agama" name="agama" class="form-control">
                    <option value="Islam">Islam</option>
                    <option value="Kristen">Kristen</option>
                    <option value="Katholik">Katholik</option>
                    <option value="Hindu">Hindu</option>
                    <option value="Budha">Budha</option>
                    <option value="Kong Hu Chu">Kong Hu Chu</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <div class="form-group">
                    <label class="control-label">Alamat</label>
                    <textarea id="alamat" name="alamat" class="form-control" rows="5"></textarea>
                </div>
            </div>
        </div>
    </div>
    <button type="submit" id="btnSave" class="btn btn-rose pull-right">Update Profile</button>
</form>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        GetProfile();

        function GetProfile() {
            $.ajax({
                type: "GET",
                url: "/pembimbing/profile/get",
                success: function(data) {
                    if (data.profile != null) {
                        $("#profile-id").val(data.profile.id);
                        $("#nidn").val(data.profile.nidn);
                        $("#nama_lengkap").val(data.profile.nama_lengkap);
                        $("#no_hp").val(data.profile.no_hp);
                        $("#tempat_lahir").val(data.profile.tempat_lahir);
                        $("#tgl_lahir").val(data.profile.tgl_lahir);
                        $("#jenis_kelamin").val(data.profile.jenis_kelamin);
                        $("#jabatan").val(data.profile.jabatan);
                        $("#agama").val(data.profile.agama);
                        $("#alamat").val(data.profile.alamat);
                    }
                }
            });
        }

        $("#form_profile").submit(function(e) {
            e.preventDefault();
            var profile_id = $("#profile-id").val();
            var nama_lengkap = $("#nama_lengkap").val();

            var email = $("#email").val();
            var nidn = $("#nidn").val();
            var no_hp = $("#no_hp").val();
            var tempat_lahir = $("#tempat_lahir").val();
            var tgl_lahir = $("#tgl_lahir").val();
            var alamat = $("#alamat").val();

            if(email == "" || nidn == "" || nama_lengkap == "" || no_hp == "" || tempat_lahir == "" || tgl_lahir == "" || alamat == ""){
                swal("Error", "Data belum terisi semua", "error");
                return;
            }

            var today = new Date();
            var birthDate = new Date(tgl_lahir);
            var age = today.getFullYear() - birthDate.getFullYear();
            if(age < 17){
                swal("Error", "Umur minimal 17 tahun", "error");
                return;
            }

            var formData = new FormData(this);
            formData.append("_method", "patch");

            $.ajax({
                type: 'POST',
                url: '/pembimbing/profile/' + profile_id,
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                data: formData,
                success: function(d) {
                    if (d.IsSuccess) {
                        swal("Success", "Profile " + nama_lengkap + " has been updated", "success");
                    } else {
                        swal("Error", "Error when update Profile " + nama_lengkap, "error");
                    }
                },
                fail: function() {
                    swal("Error", "Error when update Profile " + nama_lengkap, "error");
                }
            });
        });
    });
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
@endsection