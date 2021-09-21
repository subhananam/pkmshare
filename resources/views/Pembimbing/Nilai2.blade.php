@extends('layouts/material-panel')

@section('title', $title)

@section('icon', 'assignment')

@section('panel_name', 'Penilaian Tahap 2')

@section('panel')
<div class="card-content ">
    <table border="0" align="center" width="100%" class="table table-hover">
        <tr>
            <td width="200px">Judul PKM</td>
            <td>
                <p id="text_id" class="hide">{{ $pkm->id }}</p>
                <p id="text_judul_pkm">{{ $pkm->judul_pkm }}</p>
            </td>
        </tr>
        <tr>
            <td width="200px">Jenis PKM</td>
            <td>
                <p id="text_jenis_pkm_id" class="hide">{{ $pkm->jenis_pkm_id }}</p>
                <p id="text_jenis_pkm">{{ $pkm->jenis_pkm->nama_pkm }}</p>
            </td>
        </tr>
        <tr>
            <td width="200px">Dosen Pembimbing</td>
            <td>
                <p id="text_dosbim_id" class="hide"></p>
                <p id="text_dosbim">{{ $pkm->pembimbing->name }}</p>
            </td>
        </tr>
        <tr>
            <td width="200px" style="vertical-align: top;">Anggota</td>
            <td>
                @foreach($pkm->anggota as $anggota)
                <p id="text_nama_anggota">{{ $loop->iteration . '. ' .$anggota->nama_lengkap . ' (' . $anggota->nim .')' }}</p><br>
                @endforeach
            </td>
        </tr>
        <tr>
            <td width="200px">Status</td>
            <td>
                <p id="text_status">{{ $pkm->status }}</p>
            </td>
        </tr>
    </table>
    <br>

</div>
<br>
<p>
    Note:
</p>
<ul>
    <li>
        Masukan nilai skor di kolom skor dengan rentang 1,2,3,5,6,7 isikan ditiap kriteria penilaian
    </li>
    <li>
        Skor: 1, 2, 3, 5, 6, 7 (1 = Buruk; 2 =Sangatkurang; 3 =Kurang; 5 = Cukup; 6= Baik; 7= Sangatbaik);
    </li>
    <li>
        Nilai = Bobot x Skor
    </li>
    <li>
        Button Simpan Nilai untuk menyimpan nilai
    </li>
    <li>
        Button Refresh Nilai untuk merefresh tabel nilai
    </li>
</ul>
<br>
<button type="button" class="btn btn-primary" id="RefreshNilai">Refresh Nilai</button>
<button type="button" class="btn btn-primary" id="btnSaveNilai">Simpan Nilai</button>
<a href="/pembimbing/bimbingan" class="btn btn-secondary">Back</a>

<table id="PenilaianTahap2" class="table table-striped table-no-bordered table-hover">
    <thead class="card-header-primary">
    </thead>
    <tbody></tbody>
</table>



@endsection

@section('modal')
@csrf
@endsection

@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        var table = $("#PenilaianTahap2").DataTable({
            ajax: {
                url: "/pembimbing/pkm/nilai2/get/" + $('#text_id').text(),
                dataType: "json",
                dataSrc: "penilaian",
            },
            columns: [
                {
                    title: "Kriteria Penilaian",
                    ordering: false,
                    orderable: false,
                    data: "kriteria"
                },
                {
                    title: "Bobot",
                    data: "bobot",
                    ordering: false,
                    orderable: false,
                    width: "100px",
                },
                {
                    title: "Skor",
                    ordering: false,
                    orderable: false,
                    width: "100px",
                    render: function(data, type, row) {
                        if (row.skor != undefined) {
                            return "<input type='number' name='skor' data-nilai-id='" + row.nilai_id + "' id='skor_" + row.id + "' value='" + row.skor + "' />";
                        } else {
                            return "<input type='number' name='skor' data-nilai-id='0' id='skor_" + row.id + "' />";
                        }
                    }
                },
                {
                    title: "Nilai",
                    ordering: false,
                    orderable: false,
                    width: "100px",
                    render: function(data, type, row) {
                        if (row.nilai != undefined) {
                            return row.nilai;
                        } else {
                            return " ";
                        }
                    }
                }
            ],
            processing: true,
            searchHighlight: true,
            drawCallback: function(settings) {
                $('[data-toggle="tooltip"]').tooltip();
            }
        });

        $("#RefreshNilai").click(function() {
            table.ajax.reload();
        });
        $("#btnSaveNilai").click(function() {
            var data = table.rows().data();
            var nilai = "";
            var judul_pkm = $("#text_judul_pkm").text();

            var cek_skor = true;
            for (var i = 0; i < data.length; i++) {
                var skor = $("#skor_" + data[i].id).val();
                if (skor == "" || skor == null) {
                    cek_skor = false;
                }
                if (skor < 1 || skor > 7) {
                    cek_skor = false;
                }
            }
            if (cek_skor == false) {
                swal("Error", "Skor harus terisi semua, dan rentang nilai 1 - 7", "error");
            } else {
                for (var i = 0; i < data.length; i++) {
                    var nilai_id = $("#skor_" + data[i].id).data('nilai-id');
                    var skor = $("#skor_" + data[i].id).val();
                    if (i == 0) {
                        nilai += nilai_id + "," + data[i].id + "," + data[i].bobot + "," + skor
                    } else {
                        nilai += ";" + nilai_id + "," + data[i].id + "," + data[i].bobot + "," + skor
                    }
                }
                dataToSave = {
                    _token: $("input[name=_token]").val(),
                    pkm_id: $('#text_id').text(),
                    nilai: nilai
                };
                $.ajax({
                    type: 'POST',
                    url: '/pembimbing/pkm/nilai2/add',
                    dataType: 'json',
                    data: dataToSave,
                    success: function(d) {
                        if (d.IsSuccess) {
                            swal("Success", "Nilai untuk PKM " + judul_pkm + " berhasil disimpan", "success");
                            table.ajax.reload();
                        } else {
                            swal("Error", "Error ketika menyimpan Nilai untuk PKM " + judul_pkm, "error");
                        }
                    },
                    fail: function() {
                        swal("Error", "Error ketika menyimpan Nilai untuk PKM " + judul_pkm, "error");
                    }
                });
            }
        });
    });
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
@endsection