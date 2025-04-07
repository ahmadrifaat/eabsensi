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

@foreach ($presensi as $d)

@php
    $foto_in = Storage::url('uploads/absensi/'. $d->foto_in);
    $foto_out = Storage::url('uploads/absensi/'. $d->foto_out);
@endphp

    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $d->nrp }}</td>
        <td>{{ $d->nama_lengkap }}</td>
        <td>{{ $d->jabatan }}</td>
        <td>{{ $d->nama_dept }}</td>
        <td>
            @if ($d->jam_in > '07:00')
            <span class="badge bg-danger">{{ $d->jam_in }}</span>
            @else
            <span class="badge bg-success">{{ $d->jam_in }}</span>
            @endif

            @if ($d->jam_in > '07:00')
                @php
                    $jamterlambat = selisih('07:00:00', $d->jam_in)
                @endphp
                <span class="badge bg-danger">Terlambat {{ $jamterlambat }}</span>
            @else
                <span class="badge bg-success">Tepat Waktu</span>
            @endif

        </td>
        <td>
            <img src="{{ url($foto_in) }}" class="avatar" alt="">
        </td>
        <td>{!! $d->jam_out != null ? $d->jam_out : '<span class="badge bg-danger">Belum Absen</span>'  !!}</td>
        <td>
            @if ($d->jam_out != null)
            <img src="{{ url($foto_out) }}" class="avatar" alt="">
            @else
            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"
            fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"
            stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-photo-scan">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M15 8h.01" /><path d="M6 13l2.644 -2.644a1.21 1.21 0 0 1 1.712 0l3.644 3.644" />
            <path d="M13 13l1.644 -1.644a1.21 1.21 0 0 1 1.712 0l1.644 1.644" />
            <path d="M4 8v-2a2 2 0 0 1 2 -2h2" /><path d="M4 16v2a2 2 0 0 0 2 2h2" />
            <path d="M16 4h2a2 2 0 0 1 2 2v2" />
            <path d="M16 20h2a2 2 0 0 0 2 -2v-2" /></svg>
            @endif

        </td>
        {{-- <td>
            @if ($d->jam_in > '07:00')
                @php
                    $jamterlambat = selisih('07:00:00', $d->jam_in)
                @endphp
                <span class="badge bg-danger">Terlambat {{ $jamterlambat }}</span>
            @else
                <span class="badge bg-success">Tepat Waktu</span>
            @endif
        </td> --}}
        <td>
            <a href="#" class="btn btn-primary tampilkanpeta" id="{{ $d->id }}">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"
                stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-user-pin">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                <path d="M6 21v-2a4 4 0 0 1 4 -4h2.5" />
                <path d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z" />
                <path d="M19 18v.01" /></svg>
            </a>
        </td>
    </tr>
@endforeach

<script>
    $(function() {
        $(".tampilkanpeta").click(function(e){
            var id = $(this).attr("id");
            $.ajax({
                type: 'POST',
                url: '/tampilkanpeta',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id
                },
                cache: false,
                success: function(respond){
                    $("#loadmap").html(respond);
                }
            })
            $("#modal-tampilkanpeta").modal("show");
        });
    });
</script>
