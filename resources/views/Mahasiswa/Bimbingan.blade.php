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
        Button upload bimbingan untuk mengupload bimbingan pkm
    </li>
    <li>
        Icon awan untuk mendownload file bimbingan yang sudah direvisi
    </li>
    <li>
        Icon mata untuk melihat komentar dari pembimbing
    </li>
    <li>
        Icon tong sampah untuk hapus data
    </li>
</ul>
<br>

@if($status == "Bimbingan")
<button id="UploadBimbingan" class="btn btn-primary mb-3">Upload Bimbingan</button>
@endif
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
<div class="modal fade" id="bimbingan-modal">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border:none !important">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Upload Bimbingan</h5>
            </div>
            <form method="POST" id="form_upload_bimbingan" enctype="multipart/form-data">
                <div class="modal-body" id="bimbingan-modal-body">
                    @csrf
                    <input id="bimbingan-id" name="id" type="hidden">
                    <div class="form-group form-file-upload form-file-simple">
                        <input type="text" name="file_name" class="form-control inputFileVisible" multiple="false" placeholder="Upload dokumen Bimbingan (doc/docx/pdf)">
                        <input type="file" name="upload_bimbingan" class="inputFileHidden">
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
                        <input type="hidden" id="revisi-id">
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
                url: "/mahasiswa/bimbingan/all",
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

                        var edit_button = "<button id='bimbingan-edit' class='btn btn-sm btn-primary' style='float:left;' data-toggle='tooltip' data-placement='top' title='Edit Data'><i class='material-icons' style='color: white;'>edit</i></button>";
                        var delete_button = "<button id='bimbingan-hapus' class='btn btn-sm btn-danger' style='float:left;' data-toggle='tooltip' data-placement='top' title='Hapus Data'><i class='material-icons' style='color: white;'>delete</i></button>";
                        var comment_button = "<button id='bimbingan-comment' class='btn btn-sm btn-success' style='float:left;' data-toggle='tooltip' data-placement='top' title='Lihat Komentar'><i class='material-icons' style='color: white;'>visibility</i></button>";

                        if (row.revisi == null) {
                            return edit_button + delete_button;
                        } else {
                            var download_button = "<a href='/mahasiswa/revisi/download/" + row.revisi.id + "' target='_blank' class='btn btn-sm btn-success' style='float:left;' data-toggle='tooltip' data-placement='top' title='Download File Bimbingan'><i class='material-icons' style='color: white;'>cloud_download</i></a>";
                            return download_button + comment_button;
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

        $("#UploadBimbingan").click(function() {
            var modal = $("#bimbingan-modal");
            $("#bimbingan-id").val("");
            modal.modal('show');
        });
        $("#RefreshBimbingan").click(function() {
            table.ajax.reload();
        });

        $("#bimbingan").on("click", "#bimbingan-edit", function() {
            var data = table.row($(this).parents('tr')).data();

            var modal = $("#bimbingan-modal");
            $("#bimbingan-id").val(data.id);
            modal.modal('show');
        });
        $("#bimbingan").on("click", "#bimbingan-comment", function() {
            var data = table.row($(this).parents('tr')).data();
            $("#text_komentar").text(data.revisi.komentar);
            $("#revisi-id").val(data.revisi.id);
            getAllComments(data.revisi.id);
            $('#komentar-modal').modal('show');
        });
        $("#bimbingan").on("click", "#bimbingan-hapus", function() {
            var button = $(this);
            var data = table.row($(this).parents('tr')).data();
            var method = {
                _token: $("input[name=_token]").val(),
                _method: "delete"
            };
            swal({
                title: "Are you sure?",
                text: "Apakah anda yakin ingin menghapus File " + data.nama_file,
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, delete it!',
                buttonsStyling: false
            }).then((willDelete) => {
                if (willDelete) {
                    $.post("/mahasiswa/bimbingan/" + data.id, method, function(d) {
                        if (d.IsSuccess) {
                            table.row(button.parents("tr")).remove().draw();
                            swal("Success", "File " + data.nama_file + " berhasil dihapus", "success");
                        } else {
                            swal("Error", "Error ketika menghapus File " + data.nama_file, "error");
                        }
                    }).fail(function() {
                        swal("Error", "Error ketika menghapus File " + data.nama_file, "error");
                    });
                }
            });
        });
        $("#form_upload_bimbingan").submit(function(e) {
            e.preventDefault();
            var bimbingan_id = $("#bimbingan-id").val();

            var formData = new FormData(this);
            var filename = $(".inputFileVisible").val();
            var extention = filename.substr(filename.length - 4);
            if (extention == ".doc" || extention == "docx" || extention == ".pdf") {
                if (bimbingan_id == "" || bimbingan_id == null) {
                    $.blockUI({ message: '<h3>Mohon Tunggu..</h3>', baseZ: 100000 });
                    $.ajax({
                        type: 'POST',
                        url: '/mahasiswa/bimbingan',
                        dataType: 'json',
                        contentType: false,
                        cache: false,
                        processData: false,
                        data: formData,
                        success: function(d) {
                            if (d.IsSuccess) {
                                swal("Success", "Dokumen berhasil di Upload", "success");
                                $('#bimbingan-modal').modal('hide');
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
                        url: '/mahasiswa/bimbingan/' + bimbingan_id,
                        dataType: 'json',
                        contentType: false,
                        cache: false,
                        processData: false,
                        data: formData,
                        success: function(d) {
                            if (d.IsSuccess) {
                                swal("Success", "Dokumen berhasil di Upload", "success");
                                $('#bimbingan-modal').modal('hide');
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
                    url: '/mahasiswa/komentar',
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
                url: '/mahasiswa/komentar/all/' + revisi_id,
                success: function(d) {
                    var user_id = parseInt("{{ Auth::id() }}");
                    if (d.komentar != null || d.komentar != "") {
                        for (var i = 0; i < d.komentar.length; i++) {
                            if (d.komentar[i].user_id == user_id) {
                                new_comment += '<button type="button" class="btn btn-primary my_comment_text"><b>' + d.komentar[i].user.name + "</b><br>" +
                                    d.komentar[i].komentar + ' &nbsp;&nbsp;&nbsp;<span class="badge badge-default">' + d.komentar[i].created_at + '</span>' +
                                    '</button>' +
                                    '<br><br><br><br>';
                            } else {
                                new_comment += '<button type="button" class="btn btn-default other_comment_text"><b>' + d.komentar[i].user.name + "</b><br>" +
                                    d.komentar[i].komentar + ' &nbsp;&nbsp;&nbsp;<span class="badge badge-default">' + d.komentar[i].created_at + '</span>' +
                                    '</button>' +
                                    '<br><br><br><br>';
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