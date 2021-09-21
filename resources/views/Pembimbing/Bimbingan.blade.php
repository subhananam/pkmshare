@extends('layouts/material-table')

@section('title', $title)

@section('icon', 'description')

@section('table_name', 'Tabel Bimbingan')

@section('toolbar')
<p>
    Note:
</p>
<ul>
    <li>
        Icon awan biru untuk upload file revisi
    </li>
    <li>
        Icon awan hijau untuk download file bimbingan
    </li>
    <li>
        Icon pena untuk mengedit file revisi
    </li>
    <li>
        Icon mata untuk melihat komentar
    </li>
    <li>
        Icon catatan untuk memberi nilai tahap 2
    </li>
    <li>
        Icon tong sampah untuk hapus data
    </li>
</ul>
<br>
<button id="RefreshBimbingan" class="btn btn-primary mb-3">Refresh Tabel Bimbingan</button>
@endsection

@section('table')
<table id="bimbingan" class="table table-striped table-no-bordered table-hover">
    <thead class="card-header-primary">
    </thead>
    <tbody></tbody>
</table>
@endsection

@section('modal')
<div class="modal fade" id="revisi-modal">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border:none !important">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Upload Revisi</h5>
            </div>
            <form method="POST" id="form_upload_revisi" enctype="multipart/form-data">
                <div class="modal-body" id="bimbingan-modal-body">
                    @csrf
                    <input id="revisi-id" type="hidden">
                    <input id="bimbingan-id" name="bimbingan_id" type="hidden">
                    <div class="form-group form-file-upload form-file-simple">
                        <input type="text" name="file_name" class="form-control inputFileVisible" placeholder="Upload Dokumen Revisi (doc/docx/pdf)">
                        <input type="file" name="upload_revisi" class="inputFileHidden">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Komentar</label>
                        <textarea id="komentar" name="komentar" class="form-control" rows="5"></textarea>
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
<style>
    .my_comment_text {
        float: right;
        text-align: left;
        text-transform: none !important;
    }

    .other_comment_text {
        float: left;
        text-align: left;
        text-transform: none !important;
    }
</style>
<div class="modal fade" id="komentar-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border:none !important">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Komentar</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1" style="background-color:lightgrey; border-radius:10px;">
                        <p id="text_komentar"></p>
                    </div>
                    <div class="col-md-10 col-md-offset-1" id="comment_field">

                    </div>
                </div>
            </div>

            <div class="modal-footer" style="border:none !important">

                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="form-group">
                            <input id="comment_text" name="comment_text" type="text" class="form-control" placeholder="Tulis komentar anda disini..">
                        </div>
                        <button type="button" class="btn btn-primary" id="btnRefresh">Refresh</button>
                        <button type="submit" class="btn btn-primary" id="btnSend">Send <i class="material-icons">send</i> </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ajaxStop($.unblockUI); 
    $(document).ready(function() {
        $('.inputFileHidden').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $('.inputFileVisible').val(fileName);
        });
        var table = $("#bimbingan").DataTable({
            ajax: {
                url: "/pembimbing/bimbingan/all",
                dataSrc: "bimbingan"
            },
            columns: [{
                    title: "Action",
                    data: "id",
                    width: "130px",
                    ordering: false,
                    searchable: false,
                    orderable: false,
                    render: function(data, type, row) {
                        var upload_button = "<button id='revisi-upload' class='btn btn-sm btn-primary' style='float:left;' data-toggle='tooltip' data-placement='top' title='Upload Revisi'><i class='material-icons' style='color: white;'>backup</i></button>";
                        var download_button = "<a href='/pembimbing/bimbingan/download/" + row.id + "' target='_blank' class='btn btn-sm btn-success' style='float:left;' data-toggle='tooltip' data-placement='top' title='Download File Bimbingan'><i class='material-icons' style='color: white;'>cloud_download</i></a>";
                        var nilai_button = "<a href='/pembimbing/pkm/nilai2/" + row.pkm.id + "' class='btn btn-sm btn-success' style='float:left;' data-toggle='tooltip' data-placement='top' title='Penilaian Tahap 2'><i class='material-icons' style='color: white;'>assignment</i></a>";
                        var edit_button = "<button id='revisi-edit' class='btn btn-sm btn-primary' style='float:left;' data-toggle='tooltip' data-placement='top' title='Edit Revisi'><i class='material-icons' style='color: white;'>edit</i></button>";
                        var delete_button = "<button id='revisi-hapus' class='btn btn-sm btn-danger' style='float:left;' data-toggle='tooltip' data-placement='top' title='Hapus Revisi'><i class='material-icons' style='color: white;'>delete</i></button>";
                        var comment_button = "<button id='revisi-comment' class='btn btn-sm btn-success' style='float:left;' data-toggle='tooltip' data-placement='top' title='Lihat Komentar'><i class='material-icons' style='color: white;'>visibility</i></button>";

                        if (row.revisi == null) {
                            return upload_button + download_button + nilai_button;
                        } else {
                            return edit_button + comment_button + nilai_button + delete_button;
                        }
                    }
                },
                {
                    title: "Judul PKM",
                    data: "pkm.judul_pkm"
                },
                {
                    title: "File Bimbingan",
                    data: "nama_file",
                    width: "200px"
                },
                {
                    title: "Tanggal Bimbingan",
                    data: "updated_at"
                },
                {
                    title: "File Revisi",
                    width: "200px",
                    render: function(data, type, row) {
                        if (row.revisi == null) {
                            return " ";
                        } else {
                            return row.revisi.nama_file;
                        }
                    }
                },
                {
                    title: "Tanggal Revisi",
                    render: function(data, type, row) {
                        if (row.revisi == null) {
                            return " ";
                        } else {
                            return row.revisi.updated_at;
                        }
                    }
                }
            ],
            order: [3, 'desc'],
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
        $("#RefreshBimbingan").click(function() {
            table.ajax.reload();
        });
        $("#bimbingan").on("click", "#revisi-upload", function() {
            var data = table.row($(this).parents('tr')).data();

            var modal = $("#revisi-modal");
            $("#bimbingan-id").val(data.id);
            $("#revisi-id").val("");
            $(".inputFileVisible").val("");
            $("#komentar").text("");
            modal.modal('show');
        });

        $("#bimbingan").on("click", "#revisi-edit", function() {
            var data = table.row($(this).parents('tr')).data();

            var modal = $("#revisi-modal");
            $("#bimbingan-id").val(data.id);
            $("#revisi-id").val(data.revisi.id);
            $(".inputFileVisible").val(data.revisi.nama_file);
            $("#komentar").text(data.revisi.komentar);
            console.log(data.revisi.komentar);
            modal.modal('show');
        });
        $("#bimbingan").on("click", "#revisi-comment", function() {
            var data = table.row($(this).parents('tr')).data();
            $("#text_komentar").text(data.revisi.komentar);
            $("#revisi-id").val(data.revisi.id);
            getAllComments(data.revisi.id);
            $('#komentar-modal').modal('show');
        });
        $("#bimbingan").on("click", "#revisi-hapus", function() {
            var button = $(this);
            var data = table.row($(this).parents('tr')).data();
            console.log(data);
            var method = {
                _token: $("input[name=_token]").val(),
                _method: "delete"
            };
            swal({
                title: "Are you sure?",
                text: "Apakah anda yakin ingin menghapus Anggota " + data.revisi.nama_file,
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, delete it!',
                buttonsStyling: false
            }).then((willDelete) => {
                if (willDelete) {
                    $.post("/pembimbing/revisi/" + data.revisi.id, method, function(d) {
                        if (d.IsSuccess) {
                            table.ajax.reload();
                            swal("Success", "File Revisi " + data.revisi.nama_file + " Berhasil dihapus", "success");
                        } else {
                            swal("Error", "Error ketika menghapus file revisi " + data.revisi.nama_file, "error");
                        }
                    }).fail(function() {
                        swal("Error", "Error ketika menghapus file revisi " + data.revisi.nama_file, "error");
                    });
                }
            });
        });
        $("#form_upload_revisi").submit(function(e) {
            e.preventDefault();
            var revisi_id = $("#revisi-id").val();

            var formData = new FormData(this);
            var filename = $(".inputFileVisible").val();
            var extention = filename.substr(filename.length - 4);
            if (extention == ".doc" || extention == "docx" || extention == ".pdf") {
                if (revisi_id == "" || revisi_id == null) {
                    $.blockUI({ message: '<h3>Mohon Tunggu..</h3>', baseZ: 100000 });
                    $.ajax({
                        type: 'POST',
                        url: '/pembimbing/revisi',
                        dataType: 'json',
                        contentType: false,
                        cache: false,
                        processData: false,
                        data: formData,
                        success: function(d) {
                            if (d.IsSuccess) {
                                swal("Success", "Dokumen berhasil di Upload", "success");
                                $('#revisi-modal').modal('hide');
                                table.ajax.reload();
                            } else if (d.IsSuccess == false) {
                                swal("Error", "Dokumen gagal di Upload", "error");
                            }
                        },
                        fail: function() {
                            swal("Error", "Dokumen gagal di Upload", "error");
                        }
                    });
                } else {
                    formData.append("_method", "patch");
                    $.blockUI({ message: '<h3>Mohon Tunggu..</h3>', baseZ: 100000 });
                    $.ajax({
                        type: 'POST',
                        url: '/pembimbing/revisi/' + revisi_id,
                        dataType: 'json',
                        contentType: false,
                        cache: false,
                        processData: false,
                        data: formData,
                        success: function(d) {
                            if (d.IsSuccess) {
                                swal("Success", "Dokumen berhasil di Upload", "success");
                                $('#revisi-modal').modal('hide');
                                table.ajax.reload();
                            } else if (d.IsSuccess == false) {
                                swal("Error", "Dokumen gagal di Upload", "error");
                            }
                        },
                        fail: function() {
                            swal("Error", "Dokumen gagal di Upload", "error");
                        }
                    });
                }
            } else {
                swal("Error", "File yg di upload harus berupa .doc / .docx / .pdf", "error");
                return;
            }

        });

        $("#btnSend").on("click", function() {
            var new_comment = $("#comment_text").val();
            if (new_comment == null || new_comment == "") {
                swal("Error", "Kolom komentar tidak boleh kosong", "error");
            } else {
                var data = {
                    _token: $("input[name=_token]").val(),
                    revisi_id: $("#revisi-id").val(),
                    user_id: "",
                    komentar: $("#comment_text").val()
                };
                $.ajax({
                    type: 'POST',
                    url: '/pembimbing/komentar',
                    data: data,
                    success: function(d) {
                        if (d.IsSuccess) {
                            getAllComments(data.revisi_id);
                        } else {
                            swal("Error", "Error ketika menambahkan komentar", "error");
                        }
                    },
                    fail: function() {
                        swal("Error", "Error ketika menambahkan komentar", "error");
                    }
                });
                $("#comment_text").val("");
            }
        });
        $("#btnRefresh").on("click", function() {
            var revisi_id = $("#revisi-id").val();
            getAllComments(revisi_id);
        });

        function getAllComments(revisi_id) {
            var old_comment = $("#comment_field").html();
            var new_comment = "";
            $.ajax({
                type: 'GET',
                url: '/pembimbing/komentar/all/' + revisi_id,
                success: function(d) {
                    var user_id = parseInt("{{ Auth::id() }}");
                    if (d.komentar != null || d.komentar != "") {
                        for (var i = 0; i < d.komentar.length; i++) {
                            if (d.komentar[i].user_id == user_id) {
                                new_comment += '<button type="button" class="btn btn-primary my_comment_text"><b>' + d.komentar[i].user.name + "</b><br>" +
                                    d.komentar[i].komentar + ' &nbsp;&nbsp;&nbsp;<span class="badge badge-default">' + d.komentar[i].created_at + '</span>' +
                                    '</button>' +
                                    '<br><br><br>';
                            } else {
                                new_comment += '<button type="button" class="btn btn-default other_comment_text"><b>' + d.komentar[i].user.name + "</b><br>" +
                                    d.komentar[i].komentar + ' &nbsp;&nbsp;&nbsp;<span class="badge badge-default">' + d.komentar[i].created_at + '</span>' +
                                    '</button>' +
                                    '<br><br><br>';
                            }
                        }
                        $("#comment_field").html(new_comment);
                    }
                },
                fail: function() {
                    swal("Error", "Error ketika mendapatkan Komentar", "error");
                }
            });

        }
    });
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
@endsection