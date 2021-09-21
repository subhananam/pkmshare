@extends('layouts/material-table')

@section('title', $title)

@section('icon', 'assignment')

@section('table_name', 'Tabel Jenis PKM')

@section('toolbar')
<p>
    Note:
</p>
<ul>
    <li>
        Button tambah jenis pkm untuk menambahkan jenis-jenis pkm
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
<button id="TambahJenisPKM" class="btn btn-primary mb-3">Tambah Jenis PKM</button>
<button id="RefreshJenisPKM" class="btn btn-primary mb-3">Refresh Tabel Jenis PKM</button>
@endsection

@section('table')
<table id="JenisPKM" class="table table-striped table-no-bordered table-hover">
    <thead class="card-header-primary">
    </thead>
    <tbody></tbody>
</table>
@endsection

@section('modal')
<div class="modal fade bd-example-modal-lg" id="Jenis-PKM-modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header" style="border:none !important">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="material-icons">clear</i>
                </button>
                <h5 class="modal-title" id="exampleModalLabel">Tambah Jenis PKM</h5>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body" id="JenisPKM-modal-body">
                    @csrf
                    <input id="jenis_pkm_id" name="id" type="hidden">
                    <div class="form-group">
                        <label for="nama_pkm">Nama PKM</label>
                        <input id="nama_pkm" name="nama_pkm" type="text" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="kuota">Kuota</label>
                        <input id="kuota" name="kuota" type="number" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="penjelasan_umum">Penjelasan Umum</label>
                        <textarea id="penjelasan_umum">

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
        var table = $("#JenisPKM").DataTable({
            ajax: {
                url: "/admin/jenispkm/all",
                dataSrc: "jenispkm"
            },
            columns: [{
                    title: "Action",
                    data: "id",
                    width: "120px",
                    ordering: false,
                    searchable: false,
                    orderable: false,
                    render: function(data) {
                        return "<button id='pkm-edit' class='btn btn-sm btn-primary' style='float:left;' data-toggle='tooltip' data-placement='top' title='Edit Data'><i class='material-icons' style='color: white;'>edit</i></button>" +
                            "<button id='pkm-hapus' class='btn btn-sm btn-danger' style='float:right;' data-toggle='tooltip' data-placement='top' title='Hapus Data'><i class='material-icons' style='color: white;'>delete</i></button>";
                    }
                },
                {
                    title: "Nama PKM",
                    data: "nama_pkm",
                    width: "120px"
                },
                {
                    title: "Kuota",
                    data: "kuota",
                    width: "100px"
                },
                {
                    title: "Penjelasan Umum",
                    data: "penjelasan_umum"
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

        $("#TambahJenisPKM").click(function() {
            var modal = $("#Jenis-PKM-modal");
            modal.find('.modal-title').text('Tambah Jenis PKM');
            $("#jenis_pkm_id").val("");
            $("#nama_pkm").val("");
            $("#kuota").val("");
            editor.setData("");
            $('#Jenis-PKM-modal').modal('show');
        });
        $("#RefreshJenisPKM").click(function() {
            table.ajax.reload();
        });

        $("#JenisPKM").on("click", "#pkm-edit", function() {
            var data = table.row($(this).parents('tr')).data();

            var modal = $("#Jenis-PKM-modal");
            modal.find('.modal-title').text('Edit Jenis PKM');

            $("#jenis_pkm_id").val(data.id);
            $("#nama_pkm").val(data.nama_pkm);
            $("#kuota").val(data.kuota);
            editor.setData(data.penjelasan_umum);
            $('#Jenis-PKM-modal').modal('show');
        });
        $("#JenisPKM").on("click", "#pkm-hapus", function() {
            var button = $(this);
            var data = table.row($(this).parents('tr')).data();
            var method = {
                _token: $("input[name=_token]").val(),
                _method: "delete"
            };
            swal({
                title: "Are you sure?",
                text: "Apakah anda yakin ingin menghapus Jenis PKM " + data.nama_pkm,
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                confirmButtonText: 'Yes, delete it!',
                buttonsStyling: false
            }).then((willDelete) => {
                if (willDelete) {
                    $.post("/admin/jenispkm/" + data.id, method, function(d) {
                        if (d.IsSuccess) {
                            table.row(button.parents("tr")).remove().draw();
                            swal("Success", "Jenis PKM " + data.nama_pkm + " has been deleted", "success");
                            $('#Jenis-PKM-modal').modal('hide');
                        } else {
                            swal("Error", "Error when delete Jenis PKM " + data.nama_pkm, "error");
                        }
                    }).fail(function() {
                        swal("Error", "Error when delete Jenis PKM " + data.nama_pkm, "error");
                    });
                }
            });
        });
        $("#btnSave").on("click", function() {
            var jenis_pkm_id = $("#jenis_pkm_id").val();
            var data = {
                _token: $("input[name=_token]").val(),
                _method: "",
                nama_pkm: $("#nama_pkm").val(),
                kuota: $("#kuota").val(),
                penjelasan_umum: editor.getData()
            };
            var alldata = table.rows().data(),
                isKuotaValid = true,
                isNamaValid = true;


            for (var i = 0; i < alldata.length; i++) {
                if (alldata[i].nama_pkm == $("#nama_pkm").val() && alldata[i].id != $("#jenis_pkm_id").val()) {
                    isNamaValid = false;
                }
            }
            if ($("#kuota").val() == null || $("#kuota").val() == "") {
                isKuotaValid = false;
            }


            //Validasi panjang field
            // data.nama_pkm adalah variabel yg menyimpan nama pkm,,
            // lalu ditambahkan .length untuk mencari panjang karakter
            // 30 adalah panjang maksimal sesuai di tabel
            // masing2 kolom dibuatkan 1 (yg perlu2 saja)
            if(data.nama_pkm.length > 30){ 
                swal("Error", "Nama PKM Tidak boleh lebih dari 30 karakter", "error");
                return;
            }


            if (isNamaValid == false) {
                swal("Error", "Nama PKM Sudah Digunakan", "error");
            } else if (isKuotaValid == false) {
                swal("Error", "Kuota tidak boleh kosong", "error");
            } else {
                if (jenis_pkm_id == "" || jenis_pkm_id == null) {
                    $.post("/admin/jenispkm", data, function(d) {
                        if (d.IsSuccess) {
                            swal("Success", "Jenis PKM " + data.nama_pkm + " has been saved", "success");
                            $('#Jenis-PKM-modal').modal('hide');
                            table.ajax.reload();
                        } else {
                            swal("Error", "Error when save Jenis PKM " + data.nama_pkm, "error");
                        }
                    }).fail(function() {
                        swal("Error", "Error when save Jenis PKM " + data.nama_pkm, "error");
                    });
                } else {
                    data._method = "patch";
                    $.post("/admin/jenispkm/" + jenis_pkm_id, data, function(d) {
                        if (d.IsSuccess) {
                            swal("Success", "Jenis PKM " + data.nama_pkm + " has been updated", "success");
                            $('#Jenis-PKM-modal').modal('hide');
                            table.ajax.reload();
                        } else {
                            swal("Error", "Error when update Jenis PKM " + data.nama_pkm, "error");
                        }
                    }).fail(function() {
                        swal("Error", "Error when update Jenis PKM " + data.nama_pkm, "error");
                    });
                }
            }


        });
        $('.datepicker').datetimepicker();
        var editor = CKEDITOR.replace('penjelasan_umum', {
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