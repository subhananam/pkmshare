@extends('layouts/material-table')

@section('title', $title)

@section('icon', 'person_add')

@section('table_name', 'Tabel Anggota')

@section('toolbar')
<p>
    Note:
</p>
<ul>
    <li>
        Button tambah anggota untuk mendaftarkan anggota
    </li>
    <li>
        Icon pensil untuk melakukan edit data
    </li>
    <li>
        Icon tong sampah untuk hapus data
    </li>
    <li>
        Search untuk melakukan pencarian data
    </li>
</ul>
<br>
@if($status_pkm == "Pengajuan" || $status_pkm == "Belum mendaftar PKM")
<button id="TambahAnggota" class="btn btn-primary mb-3">Tambah Anggota</button>
@endif
<button id="RefreshAnggota" class="btn btn-primary mb-3">Refresh Tabel Anggota</button>
@endsection

@section('table')
<table id="anggota" class="table table-striped table-no-bordered table-hover">
    <thead class="card-header-primary">
    </thead>
    <tbody></tbody>
</table>
@endsection

@section('modal')
<div class="modal fade" id="anggota-modal">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border:none !important">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Tambah Anggota</h5>
            </div>
            <form id="form_anggota" method="POST" enctype="multipart/form-data">
                <div class="modal-body" id="anggota-modal-body">
                    @csrf

                    <div class="form-group">
                        <input id="anggota-id" type="hidden">
                        <label for="nama_lengkap">Nama Lengkap</label>
                        <input id="nama_lengkap" name="nama_lengkap" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="nim">NIM</label>
                        <input id="nim" name="nim" type="text" class="form-control">
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
                                <label for="program_studi">Program Studi</label>
                                <select id="program_studi" class="form-control">
                                    <option value="D3 Teknik Informatika">D3 Teknik Informatika</option>
                                    <option value="D3 Teknik Elektronika">D3 Teknik Elektronika</option>
                                    <option value="D3 Teknik Mesin">D3 Teknik Mesin</option>
                                    <option value="D2 Teknik Mesin Perikanan">D2 Teknik Mesin Perikanan</option>
                                    <option value="D2 Teknik Mesin Pertanian">D2 Teknik Mesin Pertanian</option>
                                    <option value="D4 Teknik Lingkungan">D4 Teknik Lingkungan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <select id="jenis_kelamin" class="form-control">
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="agama">Agama</label>
                                <select id="agama" class="form-control">
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
    $(document).ready(function() {
        // $('#Tanggal_Lahir').datetimepicker({
        //     //format: 'L',
        //     icons: {
        //         time: "fa fa-clock-o",
        //         date: "fa fa-calendar",
        //         up: "fa fa-arrow-up",
        //         down: "fa fa-arrow-down"
        //     }
        // });
        //$('.datepicker').datepicker();
        //membuat tabel Anggota
        var table = $("#anggota").DataTable({
            ajax: {
                url: "/mahasiswa/anggota/all",
                dataSrc: "anggota"
            },
            columns: [{
                    title: "Action",
                    data: "id",
                    width: "130px",
                    ordering: false,
                    searchable: false,
                    orderable: false,
                    render: function(data) {
                        return "<button id='anggota-edit' class='btn btn-sm btn-primary' style='float:left;' data-toggle='tooltip' data-placement='top' title='Edit Data'><i class='material-icons' style='color: white;'>edit</i></button>" +
                            "<button id='anggota-hapus' class='btn btn-sm btn-danger' style='float:right;' data-toggle='tooltip' data-placement='top' title='Hapus Data'><i class='material-icons' style='color: white;'>delete</i></button>";
                    }
                },
                {
                    title: "Nama",
                    data: "nama_lengkap"
                },
                {
                    title: "NIM",
                    data: "nim"
                },
                {
                    title: "Email",
                    data: "email"
                },
                {
                    title: "NO HP",
                    data: "no_hp"
                },
                {
                    title: "Program Studi",
                    data: "program_studi"
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

        $("#TambahAnggota").click(function() {
            var modal = $("#anggota-modal");
            modal.find('.modal-title').text('Tambah Anggota');
            $("#anggota-id").val("");
            $("#nama_lengkap").val("");
            $("#nim").val("");
            $("#email").val("");
            $("#no_hp").val("");
            $("#tempat_lahir").val("");
            $("#tgl_lahir").val("");
            $("#program_studi").val("");
            $("#jenis_kelamin").val("");
            $("#agama").val("");
            $("#alamat").val("");
            //$("#Umur").val("");
            $('#anggota-modal').modal('show');
        });
        $("#RefreshAnggota").click(function() {
            table.ajax.reload();
        });

        $("#anggota").on("click", "#anggota-edit", function() {
            var data = table.row($(this).parents('tr')).data();

            var modal = $("#anggota-modal");
            modal.find('.modal-title').text('Edit Anggota');
            $("#anggota-id").val(data.id);
            $("#nama_lengkap").val(data.nama_lengkap);
            $("#nim").val(data.nim);
            $("#email").val(data.email);
            $("#no_hp").val(data.no_hp);
            $("#tempat_lahir").val(data.tempat_lahir);
            $("#tgl_lahir").val(data.tgl_lahir);
            $("#program_studi").val(data.program_studi);
            $("#jenis_kelamin").val(data.jenis_kelamin);
            $("#agama").val(data.agama);
            $("#alamat").val(data.alamat);
            //$("#Umur").val(data.no_hp);
            $('#anggota-modal').modal('show');

            //table.ajax.reload();
        });
        $("#anggota").on("click", "#anggota-hapus", function() {
            var button = $(this);
            var data = table.row($(this).parents('tr')).data();
            var method = {
                _token: $("input[name=_token]").val(),
                _method: "delete"
            };
            swal({
                title: "Are you sure?",
                text: "Apakah anda yakin ingin menghapus Anggota " + data.nama_lengkap,
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, delete it!',
                buttonsStyling: false
            }).then((willDelete) => {
                if (willDelete) {
                    $.post("/mahasiswa/anggota/" + data.id, method, function(d) {
                        if (d.IsSuccess) {
                            table.row(button.parents("tr")).remove().draw();
                            swal("Success", "Anggota " + data.nama_lengkap + " has been deleted", "success");
                            $('#anggota-modal').modal('hide');
                        } else {
                            swal("Error", "Error when delete Anggota " + data.nama_lengkap, "error");
                        }
                    }).fail(function() {
                        swal("Error", "Error when delete Anggota " + data.nama_lengkap, "error");
                    });
                }
            });
        });
        $("#form_anggota").submit(function(e) {
            e.preventDefault();
            var anggota_id = $("#anggota-id").val();
            var nama_lengkap = $("#nama_lengkap").val();
            var jenis_kelamin = $("#jenis_kelamin").val();
            var program_studi = $("#program_studi").val();
            var agama = $("#agama").val();

            var nim = $("#nim").val();
            var no_hp = $("#no_hp").val();
            var tempat_lahir = $("#tempat_lahir").val();
            var tgl_lahir = $("#tgl_lahir").val();
            var alamat = $("#alamat").val();
            if(nama_lengkap == "" || nim == "" || no_hp == "" || tempat_lahir == "" || tgl_lahir == "" || alamat == ""){
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
            formData.append("jenis_kelamin", jenis_kelamin);
            formData.append("program_studi", program_studi);
            formData.append("agama", agama);

            if (anggota_id == "" || anggota_id == null) {
                $.ajax({
                    type: 'POST',
                    url: '/mahasiswa/anggota',
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: formData,
                    success: function(d) {
                        if (d.IsValid == false) {
                            showErrorValidator(d);
                        } else if (d.IsSuccess) {
                            swal("Success", "Anggota " + nama_lengkap + " has been saved", "success");
                            $('#anggota-modal').modal('hide');
                            table.ajax.reload();
                        } else if (d.IsValid == true && d.IsSuccess == false) {
                            swal("Error", "Error when save Anggota " + nama_lengkap, "error");
                        }
                    },
                    fail: function() {
                        swal("Error", "Error when save Anggota " + nama_lengkap, "error");
                    }
                });
            } else {
                formData.append("_method", "patch");
                $.ajax({
                    type: 'POST',
                    url: '/mahasiswa/anggota/' + anggota_id,
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: formData,
                    success: function(d) {
                        if (d.IsValid == false) {
                            showErrorValidator(d);
                        } else if (d.IsSuccess) {
                            swal("Success", "Anggota " + nama_lengkap + " has been updated", "success");
                            $('#anggota-modal').modal('hide');
                            table.ajax.reload();
                        } else if (d.IsValid == true && d.IsSuccess == false) {
                            swal("Error", "Error when update Anggota " + nama_lengkap, "error");
                        }
                    },
                    fail: function() {
                        swal("Error", "Error when update Anggota " + nama_lengkap, "error");
                    }
                });
            }
        });

        function showErrorValidator(d) {
            var errors = [];
            if (d.error_msg.email != undefined || d.error_msg.email != null) {
                errors.push({
                    messages: d.error_msg.email
                })
            }
            if (d.error_msg.nim != undefined || d.error_msg.nim != null) {
                errors.push({
                    messages: d.error_msg.nim
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