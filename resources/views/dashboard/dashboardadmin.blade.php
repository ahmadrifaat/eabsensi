@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">E-ABSENSI</div>
          <h2 class="page-title">Beranda</h2>
        </div>
        <!-- Page title actions -->

      </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row">

            <div class="col-md-6 col-xl-3">
                <div class="card card-sm">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="bg-primary text-white avatar">
                          <!-- Download SVG icon from http://tabler.io/icons/icon/currency-dollar -->
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-users"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" /><path d="M16 3.13a4 4 0 0 1 0 7.75" /><path d="M21 21v-2a4 4 0 0 0 -3 -3.85" /></svg>
                        </span>
                      </div>
                      <div class="col">
                        <div class="font-weight-medium">132</div>
                        <div class="text-secondary">Jumlah Pegawai</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-xl-3">
                <div class="card card-sm">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="bg-success text-white avatar">
                          <!-- Download SVG icon from http://tabler.io/icons/icon/currency-dollar -->
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-fingerprint"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18.9 7a8 8 0 0 1 1.1 5v1a6 6 0 0 0 .8 3" /><path d="M8 11a4 4 0 0 1 8 0v1a10 10 0 0 0 2 6" /><path d="M12 11v2a14 14 0 0 0 2.5 8" /><path d="M8 15a18 18 0 0 0 1.8 6" /><path d="M4.9 19a22 22 0 0 1 -.9 -7v-1a8 8 0 0 1 12 -6.95" /></svg>
                        </span>
                      </div>
                      <div class="col">
                        <div class="font-weight-medium">{{ $rekappresensi->jmlhadir }}</div>
                        <div class="text-secondary">Total Hadir</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-xl-3">
                <div class="card card-sm">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="bg-info text-white avatar">
                          <!-- Download SVG icon from http://tabler.io/icons/icon/currency-dollar -->
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /></svg>
                        </span>
                      </div>
                      <div class="col">
                        <div class="font-weight-medium">{{ $rekapizin->jmlizin != null ? $rekapizin->jmlizin : 0 }}</div>
                        <div class="text-secondary">Total Izin</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-xl-3">
                <div class="card card-sm">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="bg-warning text-white avatar">
                          <!-- Download SVG icon from http://tabler.io/icons/icon/currency-dollar -->
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-report-medical"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M10 14l4 0" /><path d="M12 12l0 4" />
                        </svg>
                        </span>
                      </div>
                      <div class="col">
                        <div class="font-weight-medium">{{ $rekapizin->jmlsakit != null ? $rekapizin->jmlsakit : 0}}</div>
                        <div class="text-secondary">Total Sakit</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-xl-3" style="margin-top: 10px">
                <div class="card card-sm">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="bg-danger text-white avatar">
                          <!-- Download SVG icon from http://tabler.io/icons/icon/currency-dollar -->
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="currentColor"  class="icon icon-tabler icons-tabler-filled icon-tabler-alarm-minus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16 6.072a8 8 0 1 1 -11.995 7.213l-.005 -.285l.005 -.285a8 8 0 0 1 11.995 -6.643zm-2 5.928h-4l-.117 .007a1 1 0 0 0 .117 1.993h4l.117 -.007a1 1 0 0 0 -.117 -1.993z" /><path d="M6.412 3.191a1 1 0 0 1 1.273 1.539l-.097 .08l-2.75 2a1 1 0 0 1 -1.273 -1.54l.097 -.08l2.75 -2z" /><path d="M16.191 3.412a1 1 0 0 1 1.291 -.288l.106 .067l2.75 2a1 1 0 0 1 -1.07 1.685l-.106 -.067l-2.75 -2a1 1 0 0 1 -.22 -1.397z" /></svg>
                        </span>
                      </div>
                      <div class="col">
                        <div class="font-weight-medium">{{ $rekappresensi->jmlterlambat != null ? $rekappresensi->jmlterlambat : 0}}</div>
                        <div class="text-secondary">Total Terlambat</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6 col-xl-3" style="margin-top: 10px">
                <div class="card card-sm">
                  <div class="card-body">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        <span class="bg-dark text-white avatar">
                          <!-- Download SVG icon from http://tabler.io/icons/icon/currency-dollar -->
                          <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-military-award"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 13m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M8.5 10.5l-1 -2.5h-5.5l2.48 5.788a2 2 0 0 0 1.84 1.212h2.18" /><path d="M15.5 10.5l1 -2.5h5.5l-2.48 5.788a2 2 0 0 1 -1.84 1.212h-2.18" /></svg>
                        </span>
                      </div>
                      <div class="col">
                        <div class="font-weight-medium">{{ $rekapizin->jmltugas != null ? $rekapizin->jmltugas : 0}}</div>
                        <div class="text-secondary">Tugas Diluar</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

        </div>
    </div>
</div>






@endsection
