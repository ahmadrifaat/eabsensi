<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {

        $query = Karyawan::query();
        $query->select('karyawan.*' , 'nama_dept');
        $query->join('departemen', 'karyawan.kode_dept', '=', 'departemen.kode_dept');
        $query->orderBy('nama_dept');
        if(!empty($request->nama_karyawan)){
            $query->where('nama_lengkap', 'like', '%' .$request->nama_karyawan. '%');
        }

        if(!empty($request->kode_dept)){
            $query->where('karyawan.kode_dept', $request->kode_dept);
        }
        $karyawan = $query->paginate(10);

        $departemen = DB::table('departemen')->get();
        return view('karyawan.index', compact('karyawan', 'departemen'));
    }

    public function store(Request $request)
    {
        $nrp = $request->nrp;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_dept = $request->kode_dept;
        $password = Hash::make('12345');

        if($request->hasFile('foto')){
            $foto = $nrp.".".$request->file('foto')->getClientOriginalExtension();
        }else{
            $foto = null;
        }

        try {
            $data = [
                'nrp' => $nrp,
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_hp' => $no_hp,
                'kode_dept' => $kode_dept,
                'foto' => $foto,
                'password' => $password
            ];
            $simpan = DB::table('karyawan')->insert($data);
            if($simpan){
                if($request->hasFile('foto')){
                    $folderPath = "public/uploads/karyawan/";
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
            }
        } catch (\Exception $e) {
            if($e->getCode() == 23000) {
                $message = "Data dengan NRP ". $nrp ." Sudah Ada";
            }
            return Redirect::back()->with(['error' => 'Data Tidak Berhasil Disimpan' . $message]);
        }
    }

    public function edit(Request $request)
    {
        $nrp = $request->nrp;
        $departemen = DB::table('departemen')->get();
        $karyawan = DB::table('karyawan')->where('nrp', $nrp)->first();
        return view('karyawan.edit', compact('departemen', 'karyawan'));
    }

    public function update($nrp, Request $request)
    {
        $nrp = $request->nrp;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_dept = $request->kode_dept;
        $password = Hash::make('12345');

        $old_foto = $request->old_foto;
        if($request->hasFile('foto')){
            $foto = $nrp.".".$request->file('foto')->getClientOriginalExtension();
        }else{
            $foto = $old_foto;
        }

        try {
            $data = [
                //'nrp' => $nrp,
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_hp' => $no_hp,
                'kode_dept' => $kode_dept,
                'foto' => $foto,
                'password' => $password
            ];
            $update = DB::table('karyawan')->where('nrp', $nrp)->update($data);
            if($update){
                if($request->hasFile('foto')){
                    $folderPath = "public/uploads/karyawan/";
                    $folderPathOld = "public/uploads/karyawan/" . $old_foto;
                    Storage::delete($folderPathOld);
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data Berhasil Diperbarui']);
            }
        } catch (\Exception $e) {
            return Redirect::back()->with(['error' => 'Data Gagal Diperbarui']);
        }
    }

    public function delete($nrp)
    {
        $delete = DB::table('karyawan')->where('nrp', $nrp)->delete();
        if($delete){
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        }else{
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
        }
    }
}
