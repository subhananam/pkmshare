@extends('layouts/material-table')

@section('title', $title)

@section('icon', 'view_list')

@section('table_name', 'Tabel Kriteria Penilaian')

@section('toolbar')
<p>
    Note:
</p>
<ul>
    <li>
        Button tambah kriteria penilaian untuk menambah kriteria penilaian tiap-tiap pkm
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
    <li>
        Jenis pkm untuk melakukan pencarian pkm sesuai pilihan
    </li>
</ul>
<br>
<button id="TambahKriteriaPenilaian" class="btn btn-primary mb-3">Tambah Kriteria Penilaian</button>
<button id="RefreshKriteriaPenilaian" class="btn btn-primary mb-3">Refresh Tabel Kriteria Penilaian</button>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="JenisPKM">Jenis PKM</label>
            <select id="JenisPKM" class="form-control col-3">
                @foreach($jenisPKM as $pkm)
                <option value="{{ $pkm->id }}">{{ $pkm->nama_pkm }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

@endsection

@section('table')
<table id="KriteriaPenilaian" class="table table-striped table-no-bordered table-hover">
    <thead class="card-header-primary">
    </thead>
    <tbody></tbody>
</table>
@endsection

@section('modal')
<div class="modal fade bd-example-modal-lg" id="Kriteria-Penilaian-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border:none !important">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Tambah Kriteria Penilaian</h5>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body" id="JenisPKM-modal-body">
                    @csrf
                    <input id="kriteria_id" name="id" type="hidden">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jenis_pkm_id">Jenis PKM</label>
                                <select id="jenis_pkm_id" class="form-control">
                                    @foreach($jenisPKM as $pkm)
                                    <option value="{{ $pkm->id }}">{{ $pkm->nama_pkm }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bobot">Bobot</label>
                                <input id="bobot" name="bobot" type="number" class="form-control">
                            </div>
                        </div>
                    </div>



                    <div class="form-group">
                        <label for="kriteria">Kriteria Penilaian</label>
                        <textarea id="kriteria">

                        </textarea>
                    </div>
                    <!-- <div class="input-group">
                        <span class="input-group-btn">
                            <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                                <i class="fa fa-picture-o"></i> Choose
                            </a>
                        </span>
                        <input id="thumbnail" class="form-control" type="text" name="filepath">
                    </div>
                    <img id="holder" style="margin-top:15px;max-height:100px;"> -->
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

        //membuat tabel mahasiswa
        var table = $("#KriteriaPenilaian").DataTable({
            ajax: {
                url: "/admin/kriteria/" + $('#JenisPKM').children("option:selected").val(),
                dataSrc: "kriteria"
            },
            columns: [{
                    title: "Action",
                    data: "id",
                    width: "120px",
                    ordering: false,
                    searchable: false,
                    orderable: false,
                    render: function(data) {
                        return "<button id='kriteria-edit' class='btn btn-sm btn-primary' style='float:left;' data-toggle='tooltip' data-placement='top' title='Edit Data'><i class='material-icons' style='color: white;'>edit</i></button>" +
                            "<button id='kriteria-hapus' class='btn btn-sm btn-danger' style='float:right;' data-toggle='tooltip' data-placement='top' title='Hapus Data'><i class='material-icons' style='color: white;'>delete</i></button>";
                    }
                },
                {
                    title: "Nama PKM",
                    data: "jenis_pkm.nama_pkm",
                    width: "120px"
                },
                {
                    title: "Kriteria Penilaian",
                    data: "kriteria"
                },
                {
                    title: "Bobot",
                    data: "bobot",
                    width: "100px"
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

        $("#TambahKriteriaPenilaian").click(function() {
            var modal = $("#Kriteria-Penilaian-modal"),
                pkm_id = $("#JenisPKM").val();
            modal.find('.modal-title').text('Tambah Kriteria Penilaian');
            $("#kriteria_id").val("");
            $("#jenis_pkm_id").val(pkm_id).change();
            $("#bobot").val("");
            editor.setData("");
            $('#Kriteria-Penilaian-modal').modal('show');
        });
        $("#RefreshKriteriaPenilaian").click(function() {
            var jenis_pkm_id = $('#JenisPKM').children("option:selected").val();
            table.ajax.url("/admin/kriteria/" + jenis_pkm_id).load();
        });
        $("#JenisPKM").on("change", function() {
            var jenis_pkm_id = $('#JenisPKM').children("option:selected").val();
            table.ajax.url("/admin/kriteria/" + jenis_pkm_id).load();
        });
        $("#KriteriaPenilaian").on("click", "#kriteria-edit", function() {
            var data = table.row($(this).parents('tr')).data();

            var modal = $("#Kriteria-Penilaian-modal");
            modal.find('.modal-title').text('Edit Kriteria Penilaian');

            $("#kriteria_id").val(data.id);
            $("#jenis_pkm_id").val(data.jenis_pkm.id).change();
            $("#bobot").val(data.bobot);
            editor.setData(data.kriteria);
            $('#Kriteria-Penilaian-modal').modal('show');
        });
        $("#KriteriaPenilaian").on("click", "#kriteria-hapus", function() {
            var button = $(this);
            var data = table.row($(this).parents('tr')).data();
            var method = {
                _token: $("input[name=_token]").val(),
                _method: "delete"
            };
            swal({
                title: "Are you sure?",
                text: "Apakah anda yakin ingin menghapus Kriteria Penilaian " + data.jenis_pkm.nama_pkm,
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, delete it!',
                buttonsStyling: false
            }).then((willDelete) => {
                if (willDelete) {
                    $.post("/admin/kriteria/" + data.id, method, function(d) {
                        if (d.IsSuccess) {
                            table.row(button.parents("tr")).remove().draw();
                            swal("Success", "Kriteria Penilaian " + data.jenis_pkm.nama_pkm + " has been deleted", "success");
                            $('#Kriteria-Penilaian-modal').modal('hide');
                        } else {
                            swal("Error", "Error when delete Kriteria Penilaian " + data.jenis_pkm.nama_pkm, "error");
                        }
                    }).fail(function() {
                        swal("Error", "Error when delete Kriteria Penilaian " + data.jenis_pkm.nama_pkm, "error");
                    });
                }
            });
        });
        $("#btnSave").on("click", function() {
            var kriteria_id = $("#kriteria_id").val();
            var nama_pkm = $("#jenis_pkm_id").children("option:selected").text();
            var data = {
                _token: $("input[name=_token]").val(),
                _method: "",
                jenis_pkm_id: $("#jenis_pkm_id").val(),
                bobot: $("#bobot").val(),
                kriteria: editor.getData()
            };
            var alldata = table.rows().data(),
                isBobotValid = true;

            if ($("#bobot").val() == null || $("#bobot").val() == "") {
                isBobotValid = false;
            }

            if (isBobotValid == false) {
                swal("Error", "Bobot tidak boleh kosong", "error");
            } else {
                if (kriteria_id == "" || kriteria_id == null) {
                    $.post("/admin/kriteria", data, function(d) {
                        if (d.IsSuccess) {
                            swal("Success", "Kriteria Penilaian " + nama_pkm + " has been saved", "success");
                            $('#Kriteria-Penilaian-modal').modal('hide');
                            var jenis_pkm_id = $('#JenisPKM').children("option:selected").val();
                            table.ajax.url("/admin/kriteria/" + jenis_pkm_id).load();
                        } else {
                            swal("Error", "Error when save Kriteria Penilaian " + nama_pkm, "error");
                        }
                    }).fail(function() {
                        swal("Error", "Error when save Kriteria Penilaian " + nama_pkm, "error");
                    });
                } else {
                    data._method = "patch";
                    $.post("/admin/kriteria/" + kriteria_id, data, function(d) {
                        if (d.IsSuccess) {
                            swal("Success", "Kriteria Penilaian " + nama_pkm + " has been updated", "success");
                            $('#Kriteria-Penilaian-modal').modal('hide');
                            var jenis_pkm_id = $('#JenisPKM').children("option:selected").val();
                            table.ajax.url("/admin/kriteria/" + jenis_pkm_id).load();
                        } else {
                            swal("Error", "Error when update Kriteria Penilaian " + nama_pkm, "error");
                        }
                    }).fail(function() {
                        swal("Error", "Error when update Kriteria Penilaian " + nama_pkm, "error");
                    });
                }
            }


        });
        $('.datepicker').datetimepicker();
        var editor = CKEDITOR.replace('kriteria', {
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

            // Since we define all configuration options here, let's instruct CKEditor to not load config.js which it does by default.
            // One HTTP request less will result in a faster startup time.
            // For more information check https://ckeditor.com/docs/ckeditor4/latest/api/CKEDITOR_config.html#cfg-customConfig
            customConfig: '',

            // Sometimes applications that convert HTML to PDF prefer setting image width through attributes instead of CSS styles.
            // For more information check:
            //  - About Advanced Content Filter: https://ckeditor.com/docs/ckeditor4/latest/guide/dev_advanced_content_filter.html
            //  - About Disallowed Content: https://ckeditor.com/docs/ckeditor4/latest/guide/dev_disallowed_content.html
            //  - About Allowed Content: https://ckeditor.com/docs/ckeditor4/latest/guide/dev_allowed_content_rules.html
            disallowedContent: 'img{width,height,float}',
            extraAllowedContent: 'img[width,height,align]',

            // Enabling extra plugins, available in the full-all preset: https://ckeditor.com/cke4/presets-all
            //extraPlugins: 'tableresize,uploadimage,uploadfile',
            extraPlugins: 'uploadimage',

            /*********************** File management support ***********************/
            // In order to turn on support for file uploads, CKEditor has to be configured to use some server side
            // solution with file upload/management capabilities, like for example CKFinder.
            // For more information see https://ckeditor.com/docs/ckeditor4/latest/guide/dev_ckfinder_integration.html

            // Uncomment and correct these lines after you setup your local CKFinder instance.
            // filebrowserBrowseUrl: 'http://example.com/ckfinder/ckfinder.html',
            // filebrowserUploadUrl: 'http://example.com/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
            /*********************** File management support ***********************/

            // Make the editing area bigger than default.
            height: 800,

            // An array of stylesheets to style the WYSIWYG area.
            // Note: it is recommended to keep your own styles in a separate file in order to make future updates painless.
            //contentsCss: ['{{ asset("/vendor/ckeditor/contents.css") }}', '{{ asset("/vendor/ckeditor/document-editor.css") }}'],

            // This is optional, but will let us define multiple different styles for multiple editors using the same CSS file.
            bodyClass: 'document-editor',

            // Reduce the list of block elements listed in the Format dropdown to the most commonly used.
            format_tags: 'p;h1;h2;h3;pre',

            // Simplify the Image and Link dialog windows. The "Advanced" tab is not needed in most cases.
            removeDialogTabs: 'image:advanced;link:advanced',

            // Define the list of styles which should be available in the Styles dropdown list.
            // If the "class" attribute is used to style an element, make sure to define the style for the class in "mystyles.css"
            // (and on your website so that it rendered in the same way).
            // Note: by default CKEditor looks for styles.js file. Defining stylesSet inline (as below) stops CKEditor from loading
            // that file, which means one HTTP request less (and a faster startup).
            // For more information see https://ckeditor.com/docs/ckeditor4/latest/features/styles.html
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
        });
        //$('#lfm').filemanager('image');
    });
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
@endsection