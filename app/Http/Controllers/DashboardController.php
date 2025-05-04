<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $hariini = date("Y-m-d");
        $bulanini = date("m") * 1;
        $tahunini = date("Y");
        $nrp = Auth::guard('karyawan')->user()->nrp;
        $presensihariini = DB::table('presensi')->where('nrp', $nrp)->where('tgl_presensi', $hariini)->first();

        $historibulanini = DB::table('presensi')
        ->where('nrp', $nrp)
        ->whereRaw('MONTH(tgl_presensi)="'.$bulanini.'"')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahunini.'"')
        ->orderBy('tgl_presensi')
        ->get();

        $rekappresensi = DB::table('presensi')
        ->selectRaw('COUNT(nrp) as jmlhadir, SUM(IF(jam_in > "07:00",1,0)) as jmlterlambat')
        ->where('nrp', $nrp)
        ->whereRaw('MONTH(tgl_presensi)="'.$bulanini.'"')
        ->whereRaw('YEAR(tgl_presensi)="'.$tahunini.'"')
        ->first();

        $leaderboard = DB::table('presensi')
        ->join('karyawan', 'presensi.nrp', '=', 'karyawan.nrp')
        ->where('tgl_presensi', $hariini)
        ->orderBy('jam_in')
        ->get();

        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
        "Agustus", "September", "Oktober", "November", "Desember"];

        $rekapizin = DB::table('pengajuan_izin')
        ->selectRaw('SUM(IF(status="i",1,0)) as jmlizin, SUM(IF(status="s",1,0)) as jmlsakit')
        ->where('nrp', $nrp)
        ->whereRaw('MONTH(tgl_izin)="'.$bulanini.'"')
        ->whereRaw('YEAR(tgl_izin)="'.$tahunini.'"')
        ->where('status_approved', 1)
        ->first();

        return view('dashboard.dashboard', compact('presensihariini', 'historibulanini', 'namabulan', 'bulanini',
        'tahunini', 'rekappresensi', 'leaderboard', 'rekapizin'));
    }

    public function dashboardadmin()
    {
        $hariini = date("Y-m-d");
        $rekappresensi = DB::table('presensi')
        ->selectRaw('COUNT(nrp) as jmlhadir, SUM(IF(jam_in > "07:00",1,0)) as jmlterlambat')
        ->where('tgl_presensi', $hariini)
        ->first();
        $rekapizin = DB::table('pengajuan_izin')
        ->selectRaw('SUM(IF(status="i",1,0)) as jmlizin, SUM(IF(status="s",1,0)) as jmlsakit, SUM(IF(status="t",1,0)) as jmltugas')
        ->where('tgl_izin', $hariini)
        // ->where('status_approved', 1)
        ->first();

        $jumlahKaryawan = Karyawan::count();

        return view('dashboard.dashboardadmin', compact('rekappresensi', 'rekapizin', 'jumlahKaryawan'));
    }
}
