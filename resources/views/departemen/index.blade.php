@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">E-ABSENSI</div>
          <h2 class="page-title">Data Divisi</h2>
        </div>
        <!-- Page title actions -->

      </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                               @if (Session::get('success'))
                                   <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                   </div>
                               @endif

                               @if (Session::get('error'))
                                   <div class="alert alert-warning">
                                    {{ Session::get('error') }}
                                   </div>
                               @endif

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <a href="#" class="btn btn-primary" id="btnTambahDepartemen">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"
                                    viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"
                                    stroke-linecap="round"  stroke-linejoin="round"
                                    class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" /></svg>
                                    Tambah Data
                                </a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <form action="{{ url('departemen') }}" method="GET">
                                    <div class="row mt-2">
                                        <div class="col-10">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="nama_dept" id="nama_dept"
                                                placeholder="Nama Divisi" value="{{ Request('nama_karyawan') }}">
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">
                                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"
                                                    stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                        <path d="M21 21l-6 -6" /></svg>
                                                        Cari
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                       <div class="row mt-4">
                        <div class="col-12">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Kode Divisi</th>
                                        <th>Nama Divisi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($departemen as $d)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $d->kode_dept }}</td>
                                            <td>{{ $d->nama_dept }}</td>
                                            <td>
                                                <a href="#" class="edit btn btn-info btn-sm" kode_dept="{{ $d->kode_dept }}">
                                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"
                                                    stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                    <path d="M16 5l3 3" /></svg>
                                                </a>
                                                <form action="{{ url('departemen/' . $d->kode_dept . '/delete') }}" method="POST">
                                                    @csrf

                                                    <a class="btn btn-danger btn-sm delete-confirm">
                                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"
                                                        fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"
                                                        stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                                        <path d="M4 7l16 0" /><path d="M10 11l0 6" />
                                                        <path d="M14 11l0 6" />
                                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                                    </a>

                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                        </div>
                       </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-inputdepartemen" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Data Divisi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ url('departemen/store') }}" method="POST" id="frmDepartemen">
                @csrf
                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                              <!-- Download SVG icon from http://tabler.io/icons/icon/user -->
                              <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-id">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" />
                                <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M15 8l2 0" />
                                <path d="M15 12l2 0" /><path d="M7 16l10 0" /></svg>
                            </span>
                            <input type="text" value="" id="nrp" class="form-control" name="kode_dept" placeholder="Kode Divisi">
                          </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="input-icon mb-3">
                            <span class="input-icon-addon">
                              <!-- Download SVG icon from http://tabler.io/icons/icon/user -->
                              <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /></svg>
                            </span>
                            <input type="text" value="" id="nama_dept" class="form-control" name="nama_dept" placeholder="Nama Divisi">
                          </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <div class="form-group">
                            <button class="btn btn-primary w-100">
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-send">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M10 14l11 -11" />
                                    <path d="M21 3l-6.5 18a.55 .55 0 0 1 -1 0l-3.5 -7l-7 -3.5a.55 .55 0 0 1 0 -1l18 -6.5" /></svg>
                                Simpan Data
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
      </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal modal-blur fade" id="modal-editdepartemen" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit Data Departemen</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="loadeditform">

        </div>
      </div>
    </div>
</div>
@endsection

@push('myscript')
    <script>
        $(function() {
            $("#btnTambahDepartemen").click(function() {
                $("#modal-inputdepartemen").modal("show");
            });

            $(".edit").click(function() {
                var kode_dept = $(this).attr('kode_dept');
                $.ajax({
                    type: 'POST',
                    url: "{{ url('departemen/edit') }}",
                    cache: false,
                    data: {
                        _token: "{{ csrf_token() }}",
                        kode_dept: kode_dept
                    },
                    success: function(respond){
                        $("#loadeditform").html(respond);
                    }
                });
                $("#modal-editdepartemen").modal("show");
            });

            $(".delete-confirm").click(function(e){
                var form = $(this).closest('form');
                e.preventDefault();
                Swal.fire({
                    title: "Yakin Menghapus Data?",
                    text: "Aksi ini akan menghapus data secara permanen",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Hapus Data!"
                    }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                        Swal.fire({
                        title: "Berhasil!",
                        text: "Data Berhasil Dihapus",
                        icon: "success"
                        });
                    }
                });
            });

            $("#frmKaryawan").submit(function() {
                var nrp = $("#nrp").val();
                var nama_lengkap = $("#nama_lengkap").val();
                var jabatan = $("#jabatan").val();
                var no_hp = $("#no_hp").val();
                var foto = $("#foto").val();
                var kode_dept = $("frmKaryawan").find("#kode_dept").val();

                if(nrp == "") {
                    Swal.fire({
                        title: 'Data Kosong',
                        text: 'NRP Harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                        }).then((result) => {
                            $("#nrp").focus();
                        });

                    return false;
                }else if(nama_lengkap == ""){
                    Swal.fire({
                        title: 'Data Kosong',
                        text: 'Nama Lengkap Harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                        }).then((result) => {
                            $("#nama_lengkap").focus();
                        });

                    return false;
                }else if(jabatan == ""){
                    Swal.fire({
                        title: 'Data Kosong',
                        text: 'Jabatan Harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                        }).then((result) => {
                            $("#jabatan").focus();
                        });

                    return false;
                }else if(no_hp == ""){
                    Swal.fire({
                        title: 'Data Kosong',
                        text: 'No. HP Harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                        }).then((result) => {
                            $("#no_hp").focus();
                        });

                    return false;
                }else if(kode_dept == ""){
                    Swal.fire({
                        title: 'Data Kosong',
                        text: 'Divisi Harus Diisi',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                        }).then((result) => {
                            $("#kode_dept").focus();
                        });

                    return false;
                }
            });
        });
    </script>
@endpush
