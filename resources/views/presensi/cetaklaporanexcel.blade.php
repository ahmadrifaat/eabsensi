<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>A4</title>

  <!-- Normalize or reset CSS with your favorite library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

  <!-- Load paper.css for happy printing -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

  <!-- Set page size here: A5, A4 or A3 -->
  <!-- Set also "landscape" if you need -->
  <style>
  @page {
        size: A4
    }
    #title{
        font-family: Arial, Helvetica, sans-serif;
        font-size: 18px;
        font-weight: bold;
    }
    .tabeldatakaryawan{
        margin-top: 40px;
    }

    .tabeldatakaryawan tr td{
        padding: 5px;
    }

    .tabelpresensi{
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    .tabelpresensi tr td{
        border: 1px solid #212020;
        padding: 5px;
        font-size: 12px;
    }

    .tabelpresensi tr th{
        border: 1px solid #212020;
        padding: 8px;
        background-color: #a9aaac;
    }

    .foto{
        height: 50px;
        width: 50px;
    }

    .nofoto{
        height: 20px;
        width: 20px;
    }
  </style>
</head>

<!-- Set "A5", "A4" or "A3" for class name -->
<!-- Set also "landscape" if you need -->
<body class="A4">

    <?php
    function selisih($jam_masuk, $jam_keluar)
        {
            list($h, $m, $s) = explode(":", $jam_masuk);
            $dtAwal = mktime($h, $m, $s, "1", "1", "1");
            list($h, $m, $s) = explode(":", $jam_keluar);
            $dtAkhir = mktime($h, $m, $s, "1", "1", "1");
            $dtSelisih = $dtAkhir - $dtAwal;
            $totalmenit = $dtSelisih / 60;
            $jam = explode(".", $totalmenit / 60);
            $sisamenit = ($totalmenit / 60) - $jam[0];
            $sisamenit2 = $sisamenit * 60;
            $jml_jam = $jam[0];
            return $jml_jam . ":" . round($sisamenit2);
        }
?>

  <!-- Each sheet element should have the class "sheet" -->
  <!-- "padding-**mm" is optional: you can set 10, 15, 20 or 25 -->
  <section class="sheet padding-10mm">
    <table style="width: 100%">
        <tr>
            <td style="width: 32px">
                <img src="{{ asset('assets/img/logopresensi.png') }}" height="65" width="65" alt="">
            </td>
            <td>
                <span id="title">
                    LAPORAN PRESENSI PRAJURIT DAN PEGAWAI<br>
                    PERIODE {{ strtoupper($namabulan[$bulan]) }} {{$tahun}}<br>
                    HUBDAM XIV/HASANUDDIN <br>
                </span>
                <span>Jl. Opu Daeng Risadju No.420 90121 Makassar Sulawesi Selatan</span>
            </td>
        </tr>
    </table>
    <table class="tabeldatakaryawan">
        <tr>
        </tr>
        <tr>
            <td>NRP</td>
            <td>:</td>
            <td>{{ $karyawan->nrp }}</td>
        </tr>
        <tr>
            <td>Nama Lengkap</td>
            <td>:</td>
            <td>{{ $karyawan->nama_lengkap }}</td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>:</td>
            <td>{{ $karyawan->jabatan }}</td>
        </tr>
        <tr>
            <td>Divisi</td>
            <td>:</td>
            <td>{{ $karyawan->nama_dept }}</td>
        </tr>
        <tr>
            <td>No. HP</td>
            <td>:</td>
            <td>{{ $karyawan->no_hp }}</td>
        </tr>
    </table>

    <table class="tabelpresensi">
        <tr>
            <th>No.</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>

            <th>Jam Pulang</th>

            <th>Keterangan</th>
            <th>Total Jam Kerja</th>
        </tr>
        @foreach ($presensi as $d )
        @php
        $jamterlambat = selisih('07:00:00', $d->jam_in)
        @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ date("d-m-Y", strtotime($d->tgl_presensi)) }}</td>
                <td>{{ $d->jam_in }}</td>

                <td>{{ $d->jam_out != null ? $d->jam_out : 'Tidak Absen'}}</td>

                <td>
                    @if ($d->jam_in > '07:00')
                        Terlambat Selama {{ $jamterlambat }}
                    @else
                        Tepat Waktu
                    @endif
                </td>
                <td>
                    @if ($d->jam_out != null)
                        @php
                            $jmljamkerja = selisih($d->jam_in, $d->jam_out)
                        @endphp
                    @else
                    @php
                        $jmljamkerja = "00:00";
                    @endphp
                    @endif
                    {{ $jmljamkerja }}
                </td>
            </tr>
        @endforeach
    </table>

    {{-- <table width="100%">
        <tr>
            <td style="text-align: center; height: 30px">
                <u>Nama Penganggung Jawab</u><br>
                <b>KAHUBDAM XIV/HASANUDDIN</b>
            </td>
        </tr>
    </table> --}}
  </section>

</body>

</html>
