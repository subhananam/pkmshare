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
                Print untuk mencetak data pkm
            </li>
            <li>
                Pdf untuk mendownload data bentuk pdf
            </li>
            <li>
                Excel untuk mendownload data bentuk excel
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
@csrf
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        var table = $("#pkm").DataTable({
            ajax: {
                url: "/wadir/pkm/all",
                dataSrc: "pkm"
            },
            lengthChange: !1,
            dom: 'Bfrtip',
            buttons: ["print", "pdf", "excel"],
            columns: [
                {
                    title: "Judul PKM",
                    data: "judul_pkm"
                },
                {
                    title: "Jenis PKM",
                    data: "jenis_pkm.nama_pkm"
                },
                {
                    title: "Jurusan",
                    render: function(data, type, row){
                        if(row.profil_mhs != null){
                            return row.profil_mhs.program_studi;
                        } else {
                            return " ";
                        }
                    }
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
    });
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
@endsection