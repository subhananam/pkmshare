@extends('layouts/material-panel')

@section('title', $title)

@section('icon', 'assignment')

@section('panel_name', 'Pendaftaran PKM')

@section('panel')
<div class="card-content ">
    <p>
        Note:
    </p>
    <ul>
        <li>
            Button Daftar PKM untuk mendaftarkan PKM anda
        </li>
        <li>
            Button edit PKM untuk merubah data PKM
        </li>
        <li>
            Jika status PKM anda bimbingan, silahkan klik sidebar Bimbingan untuk melakukan Bimbingan
        </li>
    </ul>
    <br>
    <button id="DaftarPKM" class="btn btn-primary mb-3">Daftar PKM</button>
    <button id="EditPKM" class="btn btn-primary mb-3">Edit PKM</button>
    <button id="ReloadPKM" class="btn btn-primary mb-3">Reload PKM</button>

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
            <div id="text_latar_belakang"></div>
        </div>
        <div class="tab-pane" id="pill3">
            <div id="text_tujuan"></div>
        </div>
        <div class="tab-pane" id="pill4">
            <div id="text_manfaat"></div>
        </div>
    </div>

    <div id="notfound">
        <center><i>Tidak Ada PKM yg Terdaftar</i><br>
        </center>
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
                <h5 class="modal-title" id="exampleModalLabel">Daftar PKM</h5>
            </div>
            <br>
            <div class="row">
                <div class="col-md-10 col-md-offset-1">
                    <div class="card-content ">
                        <form id="form_pkm" method="POST" enctype="multipart/form-data">
                            <ul class="nav nav-pills nav-pills-rose">
                                <li class="active">
                                    <a href="#modalpill1" data-toggle="tab">General</a>
                                </li>
                                <li>
                                    <a href="#modalpill2" data-toggle="tab">Latar Belakang</a>
                                </li>
                                <li>
                                    <a href="#modalpill3" data-toggle="tab">Tujuan</a>
                                </li>
                                <li>
                                    <a href="#modalpill4" data-toggle="tab">Manfaat</a>
                                </li>
                            </ul>
                            <br>
                            <div class="tab-content">
                                <div class="tab-pane active" id="modalpill1">

                                    <div class="modal-body" id="pkm-modal-body">
                                        @csrf
                                        <input id="pkm-id" name="id" type="hidden">
                                        <div class="form-group">
                                            <label for="judul_pkm">Judul PKM</label>
                                            <input id="judul_pkm" name="judul_pkm" type="text" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="jenis_pkm_id">Jenis PKM</label>
                                            <select id="jenis_pkm_id" class="form-control">
                                                @foreach($jenisPKM as $pkm)
                                                <option value="{{ $pkm->id }}" @if($pkm->jumlah_pendaftar >= $pkm->kuota) {{'disabled'}} @endif >
                                                    {{ $pkm->nama_pkm . ' ( ' . $pkm->jumlah_pendaftar .'/'. $pkm->kuota . ' )' }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="dosen_pem_id">Dosen Pembimbing</label>
                                            <select id="dosen_pem_id" class="form-control">
                                                @foreach($pembimbing as $p)
                                                <option value="{{ $p->user_id }}" @if($p->jumlah_pendaftar >= $p->kuota) {{'disabled'}} @endif >
                                                    {{ $p->nama_lengkap . ' ( ' . $p->jumlah_pendaftar .'/'. $p->kuota . ' )'}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane" id="modalpill2">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="latar_belakang">Latar Belakang</label>
                                                <textarea id="latar_belakang" name="latar_belakang"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="modalpill3">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="tujuan">Tujuan</label>
                                                <textarea id="tujuan" name="tujuan"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="modalpill4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="manfaat">Manfaat</label>
                                                <textarea id="manfaat" name="manfaat"></textarea>
                                            </div>
                                        </div>
                                    </div>
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

        </div>
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        $("#DaftarPKM").click(function() {
            var modal = $("#pkm-modal");
            modal.find('.modal-title').text('Daftar PKM');
            $("#pkm-id").val("");
            $("#judul_pkm").val("");
            editor_lb.setData("");
            editor_tujuan.setData("");
            editor_manfaat.setData("");
            $('#pkm-modal').modal('show');
        });
        $("#RefreshPKM").click(function() {
            table.ajax.reload();
        });
        ReloadPKM();

        $('#ReloadPKM').on('click', function() {
            ReloadPKM();
            $.notify({
                icon: "notifications",
                message: "PKM sudah di reload"

            }, {
                type: 'success',
                timer: 3000,
                placement: {
                    from: 'top',
                    align: 'right'
                }
            });
        });

        $('#EditPKM').on('click', function() {
            var modal = $("#pkm-modal");
            modal.find('.modal-title').text('Edit PKM');
            var id = $('#text_id').text(),
                judul_pkm = $('#text_judul_pkm').text(),
                jenis_pkm_id = $('#text_jenis_pkm_id').text(),
                dosen_pem_id = $('#text_dosbim_id').text(),
                latar_belakang = $('#text_latar_belakang').html(),
                tujuan = $('#text_tujuan').html(),
                manfaat = $('#text_manfaat').html();
            $("#pkm-id").val(id);
            $("#judul_pkm").val(judul_pkm);
            $("#jenis_pkm_id").val(jenis_pkm_id).change();
            $("#dosen_pem_id").val(dosen_pem_id).change();
            editor_lb.setData(latar_belakang);
            editor_tujuan.setData(tujuan);
            editor_manfaat.setData(manfaat);
            $('#pkm-modal').modal('show');
        });

        function ReloadPKM() {
            $.ajax({
                type: "GET",
                url: "/mahasiswa/pkm/all",
                success: function(data) {
                    //console.log(data.pkm);
                    if (data.pkm.length > 0) {
                        text_id
                        $('#text_id').text(data.pkm[0].id);
                        $('#text_judul_pkm').text(data.pkm[0].judul_pkm);
                        $('#text_jenis_pkm_id').text(data.pkm[0].jenis_pkm.id);
                        $('#text_jenis_pkm').text(data.pkm[0].jenis_pkm.nama_pkm);
                        $('#text_dosbim').text(data.pkm[0].pembimbing.name);
                        $('#text_dosbim_id').text(data.pkm[0].pembimbing.id);
                        $('#text_jumlah_anggota').text(data.pkm[0].jumlah_anggota);
                        $('#text_status').text(data.pkm[0].status);
                        $('#text_latar_belakang').html(data.pkm[0].latar_belakang);
                        $('#text_tujuan').html(data.pkm[0].tujuan);
                        $('#text_manfaat').html(data.pkm[0].manfaat);
                        $('#notfound').hide();
                        $('#DaftarPKM').hide();
                        $('#EditPKM').show();
                    } else {
                        $('#text_id').text('');
                        $('#text_judul_pkm').text('');
                        $('#text_jenis_pkm_id').text('');
                        $('#text_jenis_pkm').text('');
                        $('#text_dosbim').text('');
                        $('#text_jumlah_anggota').text('');
                        $('#text_status').text('');
                        $('#text_latar_belakang').text('');
                        $('#text_tujuan').text('');
                        $('#text_manfaat').text('');
                        $('#notfound').show();
                        $('#DaftarPKM').show();
                        $('#EditPKM').hide();
                    }
                }
            })
        }



        $("#form_pkm").submit(function(e) {
            e.preventDefault();
            var pkm_id = $("#pkm-id").val();
            var judul_pkm = $("#judul_pkm").val();

            var latar_belakang = editor_lb.getData();
            var tujuan = editor_tujuan.getData();
            var manfaat = editor_manfaat.getData();

            if(judul_pkm == "" || latar_belakang == "" || tujuan == "" || manfaat == ""){
                swal("Error", "Data belum terisi semua", "error");
                return;
            }



            var formData = new FormData(this);
            formData.append("user_id", "");
            formData.append("jenis_pkm_id", $("#jenis_pkm_id").val());
            formData.append("dosen_pem_id", $("#dosen_pem_id").val());
            formData.append("latar_belakang", editor_lb.getData());
            formData.append("tujuan", editor_tujuan.getData());
            formData.append("manfaat", editor_manfaat.getData());
            formData.append("jumlah_anggota", "");
            formData.append("status", "");

            if (pkm_id == "" || pkm_id == null) {
                $.ajax({
                    type: 'POST',
                    url: '/mahasiswa/pkm',
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: formData,
                    success: function(d) {
                        if(d.IsValid == false){
                            showErrorValidator(d);
                        }
                        else if (d.IsSuccess) {
                            swal("Success", "PKM " + judul_pkm + " has been saved", "success");
                            $('#pkm-modal').modal('hide');

                            ReloadPKM();
                        } else {
                            swal("Error", "Error when save PKM " + judul_pkm, "error");
                        }
                    },
                    fail: function() {
                        swal("Error", "Error when save PKM " + judul_pkm, "error");
                    }
                });
            } else {
                formData.append("_method", "patch");
                $.ajax({
                    type: 'POST',
                    url: '/mahasiswa/pkm/' + pkm_id,
                    dataType: 'json',
                    contentType: false,
                    cache: false,
                    processData: false,
                    data: formData,
                    success: function(d) {
                        if(d.IsValid == false){
                            showErrorValidator(d);
                        }
                        else if (d.IsSuccess) {
                            swal("Success", "PKM " + judul_pkm + " has been updated", "success");
                            $('#pkm-modal').modal('hide');

                            ReloadPKM();
                        } else {
                            swal("Error", "Error when update PKM " + judul_pkm, "error");
                        }
                    },
                    fail: function() {
                        swal("Error", "Error when update PKM " + judul_pkm, "error");
                    }
                });
            }
        });
        function showErrorValidator(d) {
            var errors = [];
            if (d.error_msg.judul_pkm != undefined || d.error_msg.judul_pkm != null) {
                errors.push({
                    messages: d.error_msg.judul_pkm
                })
            }
            var error_tampil = "";
            for (var i = 0; i < errors.length; i++) {
                error_tampil += "<li>" + errors[i].messages + "</li>";
            }
            swal("Error", "<ul>" + error_tampil + "</ul>", "error");
        }
        var ckeditor_config = {
            toolbar: [{
                    name: 'document',
                    items: ['Print']
                },
                {
                    name: 'clipboard',
                    items: ['Undo', 'Redo']
                },
                {
                    name: 'styles',
                    items: ['Format', 'Font', 'FontSize']
                },
                {
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'CopyFormatting']
                },
                {
                    name: 'colors',
                    items: ['TextColor', 'BGColor']
                },
                {
                    name: 'align',
                    items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
                },
                {
                    name: 'links',
                    items: ['Link', 'Unlink']
                },
                {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']
                },
                {
                    name: 'insert',
                    items: ['Image', 'Table']
                },
                {
                    name: 'tools',
                    items: ['Maximize']
                },
                {
                    name: 'editing',
                    items: ['Scayt']
                }
            ],
            customConfig: '',
            disallowedContent: 'img{width,height,float}',
            extraAllowedContent: 'img[width,height,align]',
            extraPlugins: 'uploadimage',
            height: 800,
            bodyClass: 'document-editor',
            format_tags: 'p;h1;h2;h3;pre',
            removeDialogTabs: 'image:advanced;link:advanced',
            stylesSet: [
                /* Inline Styles */
                {
                    name: 'Marker',
                    element: 'span',
                    attributes: {
                        'class': 'marker'
                    }
                },
                {
                    name: 'Cited Work',
                    element: 'cite'
                },
                {
                    name: 'Inline Quotation',
                    element: 'q'
                },

                /* Object Styles */
                {
                    name: 'Special Container',
                    element: 'div',
                    styles: {
                        padding: '5px 10px',
                        background: '#eee',
                        border: '1px solid #ccc'
                    }
                },
                {
                    name: 'Compact table',
                    element: 'table',
                    attributes: {
                        cellpadding: '5',
                        cellspacing: '0',
                        border: '1',
                        bordercolor: '#ccc'
                    },
                    styles: {
                        'border-collapse': 'collapse'
                    }
                },
                {
                    name: 'Borderless Table',
                    element: 'table',
                    styles: {
                        'border-style': 'hidden',
                        'background-color': '#E6E6FA'
                    }
                },
                {
                    name: 'Square Bulleted List',
                    element: 'ul',
                    styles: {
                        'list-style-type': 'square'
                    }
                }
            ]
        };
        var editor_lb = CKEDITOR.replace('latar_belakang', ckeditor_config);
        var editor_tujuan = CKEDITOR.replace('tujuan', ckeditor_config);
        var editor_manfaat = CKEDITOR.replace('manfaat', ckeditor_config);


    });
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
@endsection