<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pengajuanizin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class PresensiController extends Controller
{
    public function create()
    {
        $hariini = date("Y-m-d");
        $nrp = Auth::guard('karyawan')->user()->nrp;
        $cek = DB::table('presensi')->where('tgl_presensi', $hariini)->where('nrp', $nrp)->count();
        $lok_kantor = DB::table('konfigurasi_lokasi')->where('id', 1)->first();
        return view('presensi.create', compact('cek', 'lok_kantor'));
    }

    public function store(Request $request)
    {
        $nrp = Auth::guard('karyawan')->user()->nrp;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        $lok_kantor = DB::table('konfigurasi_lokasi')->where('id', 1)->first();
        $lok = explode(',', $lok_kantor->lokasi_kantor);
        $latitudekantor = $lok[0];
        $longitudekantor = $lok[1];
        $lokasi = $request->lokasi;
        $lokasiuser = explode(",", $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];

        $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
        $radius = round($jarak["meters"]);

        $cek = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nrp', $nrp)->count();

        if($cek > 0){
            $ket = "out";
        }else{
            $ket = "in";
        }

        $image = $request->image;
        $folderPath = "public/uploads/absensi/";
        $formatName = $nrp."-".$tgl_presensi."-".$ket;
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName.".png";
        $file = $folderPath.$fileName;


        $cek = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nrp', $nrp)->count();
        if($radius > $lok_kantor->radius){
            echo "error|Anda Berada Di Luar Jarak Maksimal, Anda Berjarak ".$radius." Dari Kantor|radius";
        }else{
            if($cek > 0){
                $data_pulang = [
                    'jam_out' => $jam,
                    'foto_out' => $fileName,
                    'lokasi_out' => $lokasi
                ];
                $update = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nrp', $nrp)->update($data_pulang);
                if($update){
                    echo "success|Sampai Jumpa Esok Hari|out";
                    Storage::put($file, $image_base64);
                }else{
                    echo "error|Absen Anda Gagal|out";
                }
            }else{
                $data = [
                    'nrp' => $nrp,
                    'tgl_presensi' => $tgl_presensi,
                    'jam_in' => $jam,
                    'foto_in' => $fileName,
                    'lokasi_in' => $lokasi
                ];
                $simpan = DB::table('presensi')->insert($data);
                if($simpan){
                    echo "success|Selamat Bekerja|in";
                    Storage::put($file, $image_base64);
                }else{
                    echo "error|Absen Anda Gagal|in";
                }
            }
        }
    }

     //Menghitung Jarak
     function distance($lat1, $lon1, $lat2, $lon2)
     {
         $theta = $lon1 - $lon2;
         $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
         $miles = acos($miles);
         $miles = rad2deg($miles);
         $miles = $miles * 60 * 1.1515;
         $feet = $miles * 5280;
         $yards = $feet / 3;
         $kilometers = $miles * 1.609344;
         $meters = $kilometers * 1000;
         return compact('meters');
     }

     public function editprofile()
     {
        $nrp = Auth::guard('karyawan')->user()->nrp;
        $karyawan = DB::table('karyawan')->where('nrp', $nrp)->first();
        return view('presensi.editprofile',compact('karyawan'));
     }

     public function updateprofile(Request $request)
     {
        $nrp = Auth::guard('karyawan')->user()->nrp;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make($request->password);
        $karyawan = DB::table('karyawan')->where('nrp', $nrp)->first();

        if($request->hasFile('foto')){
            $foto = $nrp.".".$request->file('foto')->getClientOriginalExtension();
        }else{
            $foto = $karyawan->foto;
        }

        if(empty($password)){
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'foto' => $foto
            ];
        }else{
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'password' => $password,
                'foto' => $foto
            ];
        }

        $update = DB::table('karyawan')->where('nrp', $nrp)->update($data);
        if($update){
            if($request->hasFile('foto')){
                $folderPath = "public/uploads/karyawan/";
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update']);
        }else{
            return Redirect::back()->with(['error' => 'Data Gagal Di Update']);
        }
     }

     public function histori()
     {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
        "Agustus", "September", "Oktober", "November", "Desember"];
        return view('presensi.histori', compact('namabulan'));
     }

     public function gethistori(Request $request)
     {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nrp = Auth::guard('karyawan')->user()->nrp;

        $histori = DB::table('presensi')
        ->whereRaw('MONTH(tgl_presensi)="'. $bulan . '"')
        ->whereRaw('YEAR(tgl_presensi)="'. $tahun . '"')
        ->where('nrp', $nrp)
        ->orderBy('tgl_presensi')
        ->get();

        return view('presensi.gethistori', compact('histori'));

     }

     public function izin()
     {
        $nrp = Auth::guard('karyawan')->user()->nrp;
        $dataizin = DB::table('pengajuan_izin')->where('nrp', $nrp)->get();
        return view('presensi.izin', compact('dataizin'));
     }

     public function buatizin()
     {
        return view('presensi.buatizin');
     }

     public function storeizin(Request $request)
     {
        $nrp = Auth::guard('karyawan')->user()->nrp;
        $tgl_izin = $request->tgl_izin;
        $status = $request->status;
        $keterangan = $request->keterangan;

        $data = [
            'nrp' => $nrp,
            'tgl_izin' => $tgl_izin,
            'status' => $status,
            'keterangan' => $keterangan
        ];

        $simpan = DB::table('pengajuan_izin')->insert($data);

        if($simpan){
            return redirect('/presensi/izin')->with(['success' => 'Berhasil Diajukan, Silahkan Tunggu Persetujuan']);
        }else{
            return redirect('/presensi/izin')->with(['error' => 'Gagal Diajukan, Silahkan Ulangi atau Hubungi Admin']);
        }
     }

     public function monitoring()
     {
        return view('presensi.monitoring');
     }

     public function getpresensi(Request $request)
     {
        $tanggal = $request->tanggal;
        $presensi = DB::table('presensi')
        ->select('presensi.*', 'nama_lengkap', 'jabatan','nama_dept')
        ->join('karyawan', 'presensi.nrp', '=', 'karyawan.nrp')
        ->join('departemen', 'karyawan.kode_dept', '=', 'departemen.kode_dept')
        ->where('tgl_presensi', $tanggal)
        ->get();

        return view('presensi.getpresensi', compact('presensi'));
     }

     public function tampilkanpeta(Request $request)
     {
        $id = $request->id;
        $presensi = DB::table('presensi')->where('id', $id)
        ->join('karyawan', 'presensi.nrp', '=', 'karyawan.nrp')
        ->first();
        return view('presensi.showmap', compact('presensi'));
     }

     public function laporan()
     {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
        "Agustus", "September", "Oktober", "November", "Desember"];
        $karyawan = DB::table('karyawan')->orderBy('nama_lengkap')->get();
        return view('presensi.laporan', compact('namabulan', 'karyawan'));
     }

     public function cetaklaporan(Request $request)
     {
        $nrp = $request->nrp;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
        "Agustus", "September", "Oktober", "November", "Desember"];

        $karyawan = DB::table('karyawan')->where('nrp', $nrp)
        ->join('departemen', 'karyawan.kode_dept', '=', 'departemen.kode_dept')
        ->first();

        $presensi = DB::table('presensi')
        ->where('nrp', $nrp)
        ->whereRaw('MONTH(tgl_presensi)="'. $bulan .'"')
        ->whereRaw('YEAR(tgl_presensi)="'. $tahun .'"')
        ->orderBy('tgl_presensi')
        ->get();

        if(isset($_POST['exportexcel'])) {
            $time = date("d-m-Y H:i:s");
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Laporan Absensi $time.xls");
            return view('presensi.cetaklaporanexcel', compact('bulan', 'tahun', 'namabulan', 'karyawan', 'presensi'));
        }

        return view('presensi.cetaklaporan', compact('bulan', 'tahun', 'namabulan', 'karyawan', 'presensi'));
    }

    public function rekap()
     {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
        "Agustus", "September", "Oktober", "November", "Desember"];
        return view('presensi.rekap', compact('namabulan'));
     }

    public function cetakrekap(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli",
        "Agustus", "September", "Oktober", "November", "Desember"];

        $rekap = DB::table('presensi')
        ->selectRaw('presensi.nrp, nama_lengkap,
        MAX(IF(DAY(tgl_presensi) = 1, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_1,
        MAX(IF(DAY(tgl_presensi) = 2, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_2,
        MAX(IF(DAY(tgl_presensi) = 3, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_3,
        MAX(IF(DAY(tgl_presensi) = 4, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_4,
        MAX(IF(DAY(tgl_presensi) = 5, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_5,
        MAX(IF(DAY(tgl_presensi) = 6, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_6,
        MAX(IF(DAY(tgl_presensi) = 7, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_7,
        MAX(IF(DAY(tgl_presensi) = 8, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_8,
        MAX(IF(DAY(tgl_presensi) = 9, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_9,
        MAX(IF(DAY(tgl_presensi) = 10, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_10,
        MAX(IF(DAY(tgl_presensi) = 11, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_11,
        MAX(IF(DAY(tgl_presensi) = 12, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_12,
        MAX(IF(DAY(tgl_presensi) = 13, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_13,
        MAX(IF(DAY(tgl_presensi) = 14, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_14,
        MAX(IF(DAY(tgl_presensi) = 15, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_15,
        MAX(IF(DAY(tgl_presensi) = 16, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_16,
        MAX(IF(DAY(tgl_presensi) = 17, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_17,
        MAX(IF(DAY(tgl_presensi) = 18, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_18,
        MAX(IF(DAY(tgl_presensi) = 19, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_19,
        MAX(IF(DAY(tgl_presensi) = 20, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_20,
        MAX(IF(DAY(tgl_presensi) = 21, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_21,
        MAX(IF(DAY(tgl_presensi) = 22, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_22,
        MAX(IF(DAY(tgl_presensi) = 23, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_23,
        MAX(IF(DAY(tgl_presensi) = 24, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_24,
        MAX(IF(DAY(tgl_presensi) = 25, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_25,
        MAX(IF(DAY(tgl_presensi) = 26, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_26,
        MAX(IF(DAY(tgl_presensi) = 27, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_27,
        MAX(IF(DAY(tgl_presensi) = 28, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_28,
        MAX(IF(DAY(tgl_presensi) = 29, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_29,
        MAX(IF(DAY(tgl_presensi) = 30, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_30,
        MAX(IF(DAY(tgl_presensi) = 31, CONCAT(jam_in, "-", IFNULL(jam_out, "00:00:00")), "")) as tgl_31
       ')
        ->join('karyawan', 'presensi.nrp', '=', 'karyawan.nrp')
        ->whereRaw('MONTH(tgl_presensi)="'. $bulan .'"')
        ->whereRaw('YEAR(tgl_presensi)="'. $tahun .'"')
        ->groupByRaw('presensi.nrp,nama_lengkap')
        ->get();

        if(isset($_POST['exportexcel'])) {
            $time = date("d-m-Y H:i:s");
            header("Content-type: application/vnd-ms-excel");
            header("Content-Disposition: attachment; filename=Rekap Absensi $time.xls");
        }

        return view('presensi.cetakrekap', compact('bulan', 'tahun', 'rekap', 'namabulan'));
    }

    public function izinsakit(Request $request)
    {
        $query = Pengajuanizin::query();
        $query->select('id', 'tgl_izin', 'pengajuan_izin.nrp', 'nama_lengkap', 'jabatan', 'status', 'status_approved', 'keterangan');
        $query->join('karyawan', 'pengajuan_izin.nrp', '=', 'karyawan.nrp');

        if(!empty($request->dari) && !empty($request->sampai)){
            $query->whereBetween('tgl_izin', [$request->dari, $request->sampai]);
        }

        if(!empty($request->nrp)){
            $query->where('pengajuan_izin.nrp', $request->nrp);
        }

        if(!empty($request->nama_lengkap)){
            $query->where('nama_lengkap','like','%'. $request->nama_lengkap .'%');
        }

        if($request->status_approved === "0" || $request->status_approved === "1" || $request->status_approved === "2"){
            $query->where('status_approved', $request->status_approved);
        }

        $query->orderBy('tgl_izin', 'desc');
        $izinsakit = $query->paginate(2);
        $izinsakit->appends($request->all());
        return view('presensi.izinsakit', compact('izinsakit'));
    }

    public function approveizinsakit(Request $request)
    {
        $status_approved = $request->status_approved;
        $id_izinsakit_form = $request->id_izinsakit_form;
        $update = DB::table('pengajuan_izin')->where('id', $id_izinsakit_form)->update([
            'status_approved' => $status_approved
        ]);

        if($update){
            return Redirect::back()->with(['success' => 'Persetujuan Berhasil, Terima Kasih']);
        }else{
            return Redirect::back()->with(['warning' => 'Persetujuan Gagal, Silahkan Coba Lagi']);
        }
    }

    public function batalkanizinsakit($id)
    {
        $update = DB::table('pengajuan_izin')->where('id', $id)->update([
            'status_approved' => 0
        ]);

        if($update){
            return Redirect::back()->with(['success' => 'Pembatalan Berhasil, Terima Kasih']);
        }else{
            return Redirect::back()->with(['warning' => 'Pembatalan Gagal, Silahkan Coba Lagi']);
        }
    }

    public function cekpengajuanizin(Request $request)
    {
        $tgl_izin = $request->tgl_izin;
        $nrp = Auth::guard('karyawan')->user()->nrp;

        $cek = DB::table('pengajuan_izin')->where('nrp', $nrp)->where('tgl_izin', $tgl_izin)->count();
        return $cek;
    }
}

