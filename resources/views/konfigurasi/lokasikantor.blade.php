@extends('layouts.admin.tabler')
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">E-ABSENSI</div>
          <h2 class="page-title">Atur Lokasi Kantor</h2>
        </div>
        <!-- Page title actions -->

      </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
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
                        <form action="{{ url('konfigurasi/updatelokasikantor') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                      <!-- Download SVG icon from http://tabler.io/icons/icon/user -->
                                      <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"
                                      fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"
                                      stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-map-2">
                                      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                      <path d="M12 18.5l-3 -1.5l-6 3v-13l6 -3l6 3l6 -3v7.5" />
                                      <path d="M9 4v13" /><path d="M15 7v5.5" />
                                      <path d="M21.121 20.121a3 3 0 1 0 -4.242 0c.418 .419 1.125 1.045 2.121 1.879c1.051 -.89 1.759 -1.516 2.121 -1.879z" />
                                      <path d="M19 18v.01" /></svg>
                                    </span>
                                    <input type="text" value="{{ $lok_kantor->lokasi_kantor }}" id="lokasi_kantor" class="form-control" name="lokasi_kantor" placeholder="Latitude,Longitude">
                                  </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="input-icon mb-3">
                                    <span class="input-icon-addon">
                                      <!-- Download SVG icon from http://tabler.io/icons/icon/user -->
                                      <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"
                                      fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"
                                      stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-radar">
                                      <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                      <path d="M21 12h-8a1 1 0 1 0 -1 1v8a9 9 0 0 0 9 -9" />
                                      <path d="M16 9a5 5 0 1 0 -7 7" />
                                      <path d="M20.486 9a9 9 0 1 0 -11.482 11.495" /></svg>
                                    </span>
                                    <input type="text" value="{{ $lok_kantor->radius }}" id="radius" class="form-control" name="radius" placeholder="Jarak Maksimal">

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-primary w-100">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"
                                    fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"
                                    stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-refresh">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4" />
                                    <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4" /></svg>
                                    Konfigurasi</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

