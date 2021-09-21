@extends('layouts/material-table')

@section('title', $title)

@section('icon', 'assignment')

@section('table_name', 'Tabel PKM Terdaftar')

@section('table')
<div class="card-content ">
    <div class="tab-content">
        <p>
            Note:
        </p>
        <ul>
            <li>
                Jika nilai PKM > 400 maka PKM lolos
            </li>
            <li>
                Silahkan klik pada kolom action loloskan, jika < 400 tolak </li> </ul> <button id="RefreshPKM" class="btn btn-primary mb-3">Refresh Tabel PKM</button>
                    <table id="pkm" class="table table-striped table-no-bordered table-hover">
                        <thead class="card-header-primary">
                        </thead>
                        <tbody></tbody>
                    </table>
    </div>
</div>
@endsection
@section('modal')
@csrf
@endsection

@section('script')
<script type="text/javascript">
    $(document).ajaxStop($.unblockUI);
    $(document).ready(function() {
        var table = $("#pkm").DataTable({
            ajax: {
                url: "/admin/seleksi2/all",
                dataSrc: "pkm"
            },
            columns: [{
                    title: "Action",
                    data: "id",
                    width: "120px",
                    ordering: false,
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row) {
                        var btn_approve = "<button id='approve' class='btn btn-sm btn-primary' style='float:left;' data-toggle='tooltip' data-placement='top' title='Loloskan PKM'><i class='material-icons' style='color: white;'>check_circle</i></button>";
                        var btn_reject = "<button id='reject' class='btn btn-sm btn-danger' style='float:left;' data-toggle='tooltip' data-placement='top' title='Eliminasi PKM'><i class='material-icons' style='color: white;'>cancel</i></button>";
                        var btn_undo = "<button id='undo' class='btn btn-sm btn-success' style='float:left;' data-toggle='tooltip' data-placement='top' title='Batalkan'><i class='material-icons' style='color: white;'>undo</i></button>";
                        if (row.status == "Penilaian Tahap 2") {
                            if (row.penilaian_tahap_2 != null) {
                                var total_nilai = 0;
                                for (var i = 0; i < row.penilaian_tahap_2.length; i++) {
                                    total_nilai += row.penilaian_tahap_2[i].nilai;
                                }
                                if(total_nilai >= 400){
                                    return btn_approve;
                                } else {
                                    return btn_reject;
                                }
                            } else {
                                return " ";
                            }
                            
                        } else if (row.status == "Eliminasi Tahap 2" || row.status == "Lolos Tahap Pendanaan") {
                            return btn_undo
                        }
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
                    title: "Dosen Pembimbing",
                    data: "pembimbing.name"
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
                        if (row.penilaian_tahap_2 != null) {
                            var total_nilai = 0;
                            for (var i = 0; i < row.penilaian_tahap_2.length; i++) {
                                total_nilai += row.penilaian_tahap_2[i].nilai;
                            }
                            return total_nilai;
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
        $("#RefreshPKM").click(function() {
            table.ajax.reload();
        });
        $("#pkm").on("click", "#approve", function() {
            var data = table.row($(this).parents('tr')).data();
            console.log(data);
            var pkm = {
                _token: $("input[name=_token]").val(),
                pkm_id: data.id,
                status: "Lolos Tahap Pendanaan"
            };
            swal({
                title: "Are you sure?",
                text: "Apakah anda yakin ingin meloloskan " + data.judul_pkm + " untuk selanjutnya akan Di Danai?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Ya',
                buttonsStyling: false
            }).then((willDelete) => {
                if (willDelete) {
                    $.blockUI({
                        message: '<h3>Mohon Tunggu..</h3>',
                        baseZ: 100000
                    });
                    $.post("/admin/seleksi2/status", pkm, function(d) {
                        if (d.IsSuccess) {
                            table.ajax.reload();
                            swal("Success", "PKM " + data.judul_pkm + " berhasil diloloskan", "success");
                        } else {
                            swal("Error", "PKM " + data.judul_pkm + " gagal diloloskan", "error");
                        }
                    }).fail(function() {
                        swal("Error", "PKM " + data.judul_pkm + " gagal diloloskan", "error");
                    });
                }
            });
        });
        $("#pkm").on("click", "#reject", function() {
            var data = table.row($(this).parents('tr')).data();
            var pkm = {
                _token: $("input[name=_token]").val(),
                pkm_id: data.id,
                status: "Eliminasi Tahap 2"
            };
            swal({
                title: "Are you sure?",
                text: "Apakah anda yakin ingin mengeliminasi " + data.judul_pkm + "?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Ya',
                buttonsStyling: false
            }).then((willDelete) => {
                if (willDelete) {
                    $.blockUI({
                        message: '<h3>Mohon Tunggu..</h3>',
                        baseZ: 100000
                    });
                    $.post("/admin/seleksi2/status", pkm, function(d) {
                        if (d.IsSuccess) {
                            table.ajax.reload();
                            swal("Success", "PKM " + data.judul_pkm + " berhasil dieliminasi", "success");
                        } else {
                            swal("Error", "PKM " + data.judul_pkm + " gagal dieliminasi", "error");
                        }
                    }).fail(function() {
                        swal("Error", "PKM " + data.judul_pkm + " gagal dieliminasi", "error");
                    });
                }
            });
        });
        $("#pkm").on("click", "#undo", function() {
            var data = table.row($(this).parents('tr')).data();
            var pkm = {
                _token: $("input[name=_token]").val(),
                pkm_id: data.id,
                status: "Penilaian Tahap 2"
            };
            swal({
                title: "Are you sure?",
                text: "Apakah anda yakin ingin membatalkan " + data.judul_pkm + "?",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Ya',
                buttonsStyling: false
            }).then((willDelete) => {
                if (willDelete) {
                    $.blockUI({
                        message: '<h3>Mohon Tunggu..</h3>',
                        baseZ: 100000
                    });
                    $.post("/admin/seleksi2/status", pkm, function(d) {
                        if (d.IsSuccess) {
                            table.ajax.reload();
                            swal("Success", "PKM " + data.judul_pkm + " berhasil dibatalkan", "success");
                        } else {
                            swal("Error", "PKM " + data.judul_pkm + " gagal dibatalkan", "error");
                        }
                    }).fail(function() {
                        swal("Error", "PKM " + data.judul_pkm + " gagal dibatalkan", "error");
                    });
                }
            });
        });
    });
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
@endsection