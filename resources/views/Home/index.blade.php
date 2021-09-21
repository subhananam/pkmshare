@extends('layouts.material-main')
@section('title', 'Home')
@section('content')
<div class="row">
    <div class="col-md-10 col-md-offset-1">
        <p>
            Haiii,, kata-kata bisa ditambahkan disini kes,, filenya di resource/views/Home/index.blade.php baris ke 7 wkwkwk
        </p>
        <table id="JenisPKM" class="table table-striped table-no-bordered table-hover">
            <thead class="card-header-primary">
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>

@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        var table = $("#JenisPKM").DataTable({
            ajax: {
                url: "/home/jenispkm/all",
                dataSrc: "jenispkm"
            },
            columns: [{
                    title: "Nama PKM",
                    data: "nama_pkm",
                    width: "120px"
                },
                {
                    title: "File Template",
                    width: "120px",
                    render: function(data, type, row) {
                        return "<a href='/download/template/" + row.nama_pkm + "' target='_blank'>" + row.nama_pkm + "</a>"
                    }
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
    });
</script>
@endsection