<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;

use function Laravel\Prompts\select;

class KaryawanController extends Controller
{
    public function index(Request $request)
    {

        $query = Karyawan::query();
        $query->select('karyawans.*', 'nama_dpt');
        $query->join('departemens', 'karyawans.kode_dpt', '=', 'departemens.kode_dpt');
        $query->orderBy('nama_lengkap');
        if (!empty($request->nama_lengkap)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        }
        if (!empty($request->kode_dpt)) {
            $query->where('karyawans.kode_dpt', $request->kode_dpt);
        }
        $karyawan = $query->paginate(5);


        $departemen = DB::table('departemens')->get();
        return view('karyawan.index', compact('karyawan', 'departemen'));
    }

    public function store(Request $request)
    {
        $nik = $request->nik;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_dpt = $request->kode_dpt;
        $password = Hash::make('12345');

        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = null;
        }
        try {
            $data = [
                'nik' => $nik,
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_hp' => $no_hp,
                'kode_dpt' => $kode_dpt,
                'foto' => $foto,
                'password' => $password
            ];
            $simpan = DB::table('karyawans')->insert($data);
            if ($simpan) {
                if ($request->hasFile('foto')) {
                    $folderPath = "public/uploads/karyawan/";
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
            }
        } catch (\Exception $d) {
            return Redirect::back()->with(['error' => 'Data Gagal Disimpan']);
        }
    }
    public function edit(Request $request){
        $nik = $request->nik;
        $departemen = DB::table('departemens')->get();
        $karyawan = DB::table('karyawans')->where('nik',$nik)->first();
        return view ('karyawan.edit',compact('departemen','karyawan'));
    }
    public function update($nik,Request $request){
        $nik = $request->nik;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_dpt = $request->kode_dpt;
        $password = Hash::make('12345');
        $old_foto = $request->old_foto;
        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $old_foto;
        }
        try {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_hp' => $no_hp,
                'kode_dpt' => $kode_dpt,
                'foto' => $foto,
                'password' => $password
            ];
            $update = DB::table('karyawans')->where('nik',$nik)->update($data);
            if ($update) {
                if ($request->hasFile('foto')) {
                    $folderPath = "public/uploads/karyawan/";
                    $folderPathOld = "public/uploads/karyawan/".$old_foto;
                    Storage::delete($folderPathOld);
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data Berhasil Diubah']);
            }
        } catch (\Exception $d) {
            return Redirect::back()->with(['error' => 'Data Gagal Diubah']);
        }
    }
    public function delete($nik){
        $delete = DB::table('karyawans')->where('nik', $nik)->delete();
        if($delete){
            return Redirect::back()->with(['success'=> 'Data Berhasil Di Hapus']);
        }else{
            return Redirect::back()->with(['success'=> 'Data Gagal Di Hapus']);
        }
    }
}
