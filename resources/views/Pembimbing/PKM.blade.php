@extends('layouts/material-panel')

@section('title', $title)

@section('icon', 'assignment')

@section('panel_name', 'Daftar PKM')

@section('table')
<div class="card-content ">
    <div class="tab-content">
        <p>
            Note:
        </p>
        <ul>
            <li>
                Masukkan nilai dari 1-100
            </li>
        </ul>
        <br>
        <button id="RefreshPKM" class="btn btn-primary mb-3">Refresh Tabel PKM</button>
        <table id="pkm" class="table table-striped table-no-bordered table-hover">
            <thead class="card-header-primary">
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection

@section('modal')
<div class="modal fade" id="pkm-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border:none !important">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Penilaian Tahap 1</h5>
            </div>
            <br>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="card-content ">
                        <ul class="nav nav-pills nav-pills-rose">
                            <li class="active">
                                <a href="#pill1" data-toggle="tab">General</a>
                            </li>
                            <li>
                                <a href="#pill2" data-toggle="tab">Latar Belakang</a>
                            </li>
                            <li>
                                <a href="#pill3" data-toggle="tab">Tujuan</a>
                            </li>
                            <li>
                                <a href="#pill4" data-toggle="tab">Manfaat</a>
                            </li>
                        </ul>
                        <br>
                        <div class="tab-content">
                            <div class="tab-pane active" id="pill1">
                                <table border="0" align="center" width="100%" class="table table-hover">
                                    <tr>
                                        <td width="200px">Judul PKM</td>
                                        <td>
                                            <p id="text_id" class="hide"></p>
                                            <p id="text_judul_pkm"></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="200px">Jenis PKM</td>
                                        <td>
                                            <p id="text_jenis_pkm_id" class="hide"></p>
                                            <p id="text_jenis_pkm"></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="200px">Dosen Pembimbing</td>
                                        <td>
                                            <p id="text_dosbim_id" class="hide"></p>
                                            <p id="text_dosbim"></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="200px">Jumlah Anggota</td>
                                        <td>
                                            <p id="text_jumlah_anggota"></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="200px">Status</td>
                                        <td>
                                            <p id="text_status"></p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="tab-pane" id="pill2">
                                <p id="text_latar_belakang"></p>
                            </div>
                            <div class="tab-pane" id="pill3">
                                <p id="text_tujuan"></p>
                            </div>
                            <div class="tab-pane" id="pill4">
                                <p id="text_manfaat"></p>
                            </div>
                        </div>

                        <div id="notfound">
                            <center><i>Tidak Ada PKM yg Terdaftar</i><br>
                            </center>
                        </div>
                    </div>
                </div>
            </div>

            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body" id="pkm-modal-body">
                    @csrf
                    <input id="pkm-id" name="id" type="hidden">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nilai_judul">Nilai Judul PKM</label>
                                <input id="nilai_id" name="nilai_id" type="hidden">
                                <input id="nilai_judul" name="nilai_judul" type="number" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nilai_lb">Nilai Latar Belakang</label>
                                <input id="nilai_lb" name="nilai_lb" type="number" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nilai_tujuan">Nilai Tujuan</label>
                                <input id="nilai_tujuan" name="nilai_tujuan" type="number" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="nilai_manfaat">Nilai Manfaat</label>
                                <input id="nilai_manfaat" name="nilai_manfaat" type="number" class="form-control">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer" style="border:none !important">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnSave">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        var table = $("#pkm").DataTable({
            ajax: {
                url: "/pembimbing/pkm/all",
                dataSrc: "pkm"
            },
            columns: [{
                    title: "Action",
                    data: "id",
                    width: "130px",
                    ordering: false,
                    searchable: false,
                    orderable: false,
                    render: function(data) {
                        return "<button id='add-nilai' class='btn btn-sm btn-primary' style='float:left;' data-toggle='tooltip' data-placement='top' title='Tambah Nilai Tahap 1'><i class='material-icons' style='color: white;'>edit</i></button>";
                    }
                },
                {
                    title: "Judul PKM",
                    data: "judul_pkm"
                },
                {
                    title: "Jenis PKM",
                    data: "jenis_pkm.nama_pkm"
                },
                {
                    title: "Jumlah Anggota",
                    data: "jumlah_anggota"
                },
                {
                    title: "Status",
                    data: "status"
                },
                {
                    title: "Total Nilai",
                    render: function(data, type, row) {
                        if (row.penilaian_tahap_1 != null) {
                            var nilai_judul = row.penilaian_tahap_1.nilai_judul,
                                nilai_lb = row.penilaian_tahap_1.nilai_lb,
                                nilai_tujuan = row.penilaian_tahap_1.nilai_tujuan,
                                nilai_manfaat = row.penilaian_tahap_1.nilai_manfaat;

                            return nilai_judul + nilai_lb + nilai_tujuan + nilai_manfaat;
                        } else {
                            return "<i>Belum Dinilai</i>";
                        }

                    }
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

        $("#pkm").on("click", "#add-nilai", function() {
            var data = table.row($(this).parents('tr')).data();
            $('#text_id').text(data.id);
            $('#text_judul_pkm').text(data.judul_pkm);
            $('#text_jenis_pkm_id').text(data.jenis_pkm.id);
            $('#text_jenis_pkm').text(data.jenis_pkm.nama_pkm);
            $('#text_dosbim').text(data.pembimbing.name);
            $('#text_dosbim_id').text(data.pembimbing.id);
            $('#text_jumlah_anggota').text(data.jumlah_anggota);
            $('#text_status').text(data.status);
            $('#text_latar_belakang').html(data.latar_belakang);
            $('#text_tujuan').html(data.tujuan);
            $('#text_manfaat').html(data.manfaat);
            $('#notfound').hide();
            if (data.penilaian_tahap_1 != null) {
                $('#nilai_id').val(data.penilaian_tahap_1.id);
                $('#nilai_judul').val(data.penilaian_tahap_1.nilai_judul);
                $('#nilai_lb').val(data.penilaian_tahap_1.nilai_lb);
                $('#nilai_tujuan').val(data.penilaian_tahap_1.nilai_tujuan);
                $('#nilai_manfaat').val(data.penilaian_tahap_1.nilai_manfaat);
            }
            $('#pkm-modal').modal('show');
        });
        $("#RefreshPKM").click(function() {
            table.ajax.reload();
        });
        $("#btnSave").on("click", function() {
            var pkm_id = $("#pkm-id").val();
            var data = {
                _token: $("input[name=_token]").val(),
                id: $("#nilai_id").val(),
                pkm_id: $("#text_id").text(),
                nilai_judul: $("#nilai_judul").val(),
                nilai_lb: $("#nilai_lb").val(),
                nilai_tujuan: $("#nilai_tujuan").val(),
                nilai_manfaat: $("#nilai_manfaat").val(),
            };

            var isValid = true;

            if (data.nilai_judul == "" || data.nilai_lb == "" || data.nilai_tujuan == "" || data.nilai_manfaat == "") {
                isValid = false;
            }
            if (data.nilai_judul < 1 || data.nilai_lb < 1 || data.nilai_tujuan < 1 || data.nilai_manfaat < 1) {
                isValid = false;
            }
            if (data.nilai_judul > 100 || data.nilai_lb > 100 || data.nilai_tujuan > 100 || data.nilai_manfaat > 100) {
                isValid = false;
            }
            if (isValid == false) {
                swal("Error", "Nilai tidak boleh kosong, rentang nilai 1 - 100", "error");
            } else {
                var judul_pkm = $('#text_judul_pkm').text();
                if (data.id == null || data.id == '') {
                    $.post("/pembimbing/pkm/nilai1/add", data, function(d) {
                        if (d.IsSuccess) {
                            swal("Success", "PKM " + judul_pkm + " has been added a score", "success");
                            $('#pkm-modal').modal('hide');
                            table.ajax.reload();
                        } else {
                            swal("Error", "Error when save score PKM " + judul_pkm, "error");
                        }
                    }).fail(function() {
                        swal("Error", "Error when save score PKM " + judul_pkm, "error");
                    });
                } else {
                    $.post("/pembimbing/pkm/nilai1/edit", data, function(d) {
                        if (d.IsSuccess) {
                            swal("Success", "PKM " + judul_pkm + " has been updated a score", "success");
                            $('#pkm-modal').modal('hide');
                            table.ajax.reload();
                        } else {
                            swal("Error", "Error when update score PKM " + judul_pkm, "error");
                        }
                    }).fail(function() {
                        swal("Error", "Error when update score PKM " + judul_pkm, "error");
                    });
                }
            }

        });
    });
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
@endsection