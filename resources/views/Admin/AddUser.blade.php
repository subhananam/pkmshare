@extends('layouts/material-table')

@section('title', $title)

@section('icon', 'person_add')

@section('table_name', 'Tabel User')

@section('toolbar')
<p>
    Note:
</p>
<ul>
    <li>
        Button tambah user untuk menambahkan user (pembimbing dan wadir 3)
    </li>
    <li>
    Icon mata untuk melihat detail data
    </li>
    <li>
        Icon tong sampah untuk hapus data
    </li>
    <li>
        Search untuk melakukan pencarian data
    </li>
</ul>
<button id="TambahUser" class="btn btn-primary mb-3">Tambah User</button>
<button id="RefreshUser" class="btn btn-primary mb-3">Refresh Tabel User</button>
@endsection

@section('table')
<table id="user" class="table table-striped table-no-bordered table-hover">
    <thead class="card-header-primary">
    </thead>
    <tbody></tbody>
</table>
@endsection

@section('modal')
<div class="modal fade" id="user-modal">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border:none !important">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Tambah User</h5>
            </div>
            <form method="POST" id="form_add_user" enctype="multipart/form-data">
                <div class="modal-body" id="user-modal-body">
                    @csrf
                    <input id="user-id" name="id" type="hidden">
                    <div class="form-group">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input id="nama_lengkap" name="nama_lengkap" type="text" class="form-control">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" name="email" type="email" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input id="password" name="password" type="password" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nidn">NIDN</label>
                                <input id="nidn" name="nidn" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_hp">No HP</label>
                                <input id="no_hp" name="no_hp" type="text" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tempat_lahir">Tempat Lahir</label>
                                <input id="tempat_lahir" name="tempat_lahir" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Lahir</label>
                                <input id="tgl_lahir" name="tgl_lahir" type="text" class="form-control datepicker">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jabatan">Jabatan</label>
                                <select id="jabatan" name="jabatan" class="form-control">
                                    <option value="Pembimbing">Pembimbing</option>
                                    <option value="Wadir">Wakil Direktur</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select id="jenis_kelamin" name="jenis_kelamin" class="form-control">
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="agama">Agama</label>
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
                    <div class="form-group">
                        <label id="LabelKuota" for="kuota" class="hide">Kuota Bimbingan</label>
                        <input id="kuota" name="kuota" type="text" class="form-control hide">
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input id="alamat" name="alamat" type="text" class="form-control">
                    </div>
                </div>
                <div class="modal-footer" style="border:none !important">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="btnSave">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ajaxStop($.unblockUI);
    $(document).ready(function() {
        var table = $("#user").DataTable({
            ajax: {
                url: "/admin/user/all",
                dataSrc: "user"
            },
            columns: [{
                    title: "Action",
                    data: "id",
                    width: "130px",
                    ordering: false,
                    searchable: false,
                    orderable: false,
                    render: function(data) {
                        return "<button id='user-detail' class='btn btn-sm btn-primary' style='float:left;' data-toggle='tooltip' data-placement='top' title='See User Detail'><i class='material-icons' style='color: white;'>visibility</i></button>" +
                            "<button id='user-hapus' class='btn btn-sm btn-danger' style='float:right;' data-toggle='tooltip' data-placement='top' title='Hapus Data'><i class='material-icons' style='color: white;'>delete</i></button>";
                    }
                },
                {
                    title: "Nama",
                    data: "name"
                },
                {
                    title: "NIDN",
                    data: "profil_dosen.nidn"
                },
                {
                    title: "Email",
                    data: "email"
                },
                {
                    title: "NO HP",
                    data: "profil_dosen.no_hp"
                },
                {
                    title: "Jabatan",
                    data: "profil_dosen.jabatan"
                }
            ],
            order: [1, 'asc'],
            processing: true,
            searchHighlight: true,
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        table.on('draw', function() {
            var body = $(table.table().body());
            body.unhighlight();
            body.highlight(table.search());

        });

        $("#TambahUser").click(function() {
            var modal = $("#user-modal");
            modal.find('.modal-title').text('Tambah User');
            $("#user-id").val("");
            $("#nama_lengkap").val("");
            $("#nidn").val("");
            $("#email").val("");
            $("#password").val("");
            $("#no_hp").val("");
            $("#tempat_lahir").val("");
            $("#tgl_lahir").val("");
            $("#jabatan").val("");
            $("#jenis_kelamin").val("");
            $("#agama").val("");
            $("#alamat").val("");
            $('select').attr("disabled", false);
            $('input').attr('readonly', false);
            $("#btnSave").show();
            $('#user-modal').modal('show');
        });
        $("#RefreshUser").click(function() {
            table.ajax.reload();
        });
        $("#jabatan").on("change", function() {
            var jabatan = $("#jabatan").val();
            if (jabatan == "Pembimbing") {
                $("#kuota").removeClass('hide');
                $("#LabelKuota").removeClass('hide');
            } else {
                $("#kuota").addClass('hide');
                $("#LabelKuota").addClass('hide');
            }
        });

        $("#user").on("click", "#user-detail", function() {
            var data = table.row($(this).parents('tr')).data();

            var modal = $("#user-modal");
            modal.find('.modal-title').text('Lihat Detail User');
            $("#user-id").val(data.id);
            $("#nama_lengkap").val(data.profil_dosen.nama_lengkap);
            $("#nidn").val(data.profil_dosen.nidn);
            $("#email").val(data.email);
            $("#no_hp").val(data.profil_dosen.no_hp);
            $("#tempat_lahir").val(data.profil_dosen.tempat_lahir);
            $("#tgl_lahir").val(data.profil_dosen.tgl_lahir);
            $("#jabatan").val(data.profil_dosen.jabatan);
            $("#jenis_kelamin").val(data.profil_dosen.jenis_kelamin);
            $("#agama").val(data.profil_dosen.agama);
            $("#alamat").val(data.profil_dosen.alamat);
            $("#kuota").val(data.profil_dosen.kuota);
            $('select').attr("disabled", true);
            $('input').attr('readonly', true);
            $("#btnSave").hide();
            $('#user-modal').modal('show');
        });
        $("#user").on("click", "#user-hapus", function() {
            var button = $(this);
            var data = table.row($(this).parents('tr')).data();
            var method = {
                _token: $("input[name=_token]").val(),
                _method: "delete"
            };
            swal({
                title: "Are you sure?",
                text: "Apakah anda yakin ingin menghapus User " + data.profil_dosen.nama_lengkap,
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, delete it!',
                buttonsStyling: false
            }).then((willDelete) => {
                if (willDelete) {
                    $.post("/admin/user/" + data.id, method, function(d) {
                        if (d.IsSuccess) {
                            table.row(button.parents("tr")).remove().draw();
                            swal("Success", "User " + data.profil_dosen.nama_lengkap + " has been deleted", "success");
                            $('#user-modal').modal('hide');
                        } else {
                            swal("Error", "Error when delete User " + data.profil_dosen.nama_lengkap, "error");
                        }
                    }).fail(function() {
                        swal("Error", "Error when delete User " + data.profil_dosen.nama_lengkap, "error");
                    });
                }
            });
        });
        $("#form_add_user").submit(function(e) {
            e.preventDefault();
            var user_id = $("#user-id").val();
            var nama_lengkap = $("#nama_lengkap").val();
            var nidn = $("#nidn").val();
            var no_hp = $("#no_hp").val();
            var tempat_lahir = $("#tempat_lahir").val();
            var tgl_lahir = $("#tgl_lahir").val();
            var alamat = $("#alamat").val();

            if(nama_lengkap == "" || nidn == "" || no_hp == "" || tempat_lahir == "" || tgl_lahir == "" || alamat == ""){
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

            //Validasi panjang field
            if(nama_lengkap.length > 191){
                swal("Error", "Nama Lengkap Tidak boleh lebih dari 191 karakter", "error");
                return;
            }

            var formData = new FormData(this);
            formData.append("user_id", "");
            formData.append("jenis_pkm_id", "");
            formData.append("umur", "");
            formData.append("jumlah_pendaftar", "");
            $.blockUI({ message: '<h3>Mohon Tunggu..</h3>', baseZ: 100000 });
            $.ajax({
                type: 'POST',
                url: '/admin/user',
                dataType: 'json',
                contentType: false,
                cache: false,
                processData: false,
                data: formData,
                success: function(d) {
                    if (d.IsValid == false) {
                        showErrorValidator(d);
                    } else if (d.IsSuccess) {
                        swal("Success", "User " + nama_lengkap + " has been saved", "success");
                        $('#user-modal').modal('hide');
                        table.ajax.reload();
                    } else if (d.IsValid == true && d.IsSuccess == false) {
                        swal("Error", "Error when save User " + nama_lengkap, "error");
                    }
                },
                fail: function() {
                    swal("Error", "Error when save User " + nama_lengkap, "error");
                }
            });
        });

        function showErrorValidator(d) {
            var errors = [];
            console.log(d);
            if (d.error_msg.email != undefined || d.error_msg.email != null) {
                errors.push({
                    messages: d.error_msg.email
                })
            }
            if (d.error_msg.password != undefined || d.error_msg.password != null) {
                errors.push({
                    messages: d.error_msg.password
                })
            }
            if (d.error_msg.nidn != undefined || d.error_msg.nidn != null) {
                errors.push({
                    messages: d.error_msg.nidn
                })
            }
            var error_tampil = "";
            for (var i = 0; i < errors.length; i++) {
                error_tampil += "<li>" + errors[i].messages + "</li>";
            }
            swal("Error", "<ul>" + error_tampil + "</ul>", "error");
        }
        
    });
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
@endsection