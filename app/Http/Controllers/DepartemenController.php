<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

use function Laravel\Prompts\select;

class DepartemenController extends Controller
{
    public function index(Request $request)
    {
        $nama_dpt = $request->nama_dpt;
        $query = Departemen::query();
        $query->select('*');
        if (!empty($nama_dpt)) {
            $query->where('nama_dpt', 'like', '%' . $nama_dpt . '%');
        }
        $departemen = $query->get();

        //$departemen = DB::table('departemens')->orderBy('kode_dpt')->get();
        return view('/departemen.index', compact('departemen'));
    }

    public function store(Request $request)
    {
        $kode_dpt = $request->kode_dpt;
        $nama_dpt = $request->nama_dpt;
        $data = [
            'kode_dpt' => $kode_dpt,
            'nama_dpt' => $nama_dpt
        ];
        $simpan = DB::table('departemens')->insert($data);
        if ($simpan) {
            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
        } else {
            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
        }
    }
    public function edit(Request $request)
    {
        $kode_dpt = $request->kode_dpt;
        $departemen = DB::table('departemens')->where('kode_dpt', $kode_dpt)->first();
        return view('departemen.edit', compact('departemen'));
    }
    public function update(Request $request, $kode_dpt)
{
    // Validasi input
    $request->validate([
        'kode_dpt' => 'required|string|max:6|unique:departemens,kode_dpt', // Pastikan kode unik
        'nama_dpt' => 'required|string|max:100',
    ]);

    try {
        DB::beginTransaction(); // Mulai transaksi agar data tetap konsisten

        // Cek apakah kode_dpt berubah
        if ($kode_dpt !== $request->kode_dpt) {
            // Insert data baru dengan kode_dpt baru
            DB::table('departemens')->insert([
                'kode_dpt' => $request->kode_dpt,
                'nama_dpt' => $request->nama_dpt,
            ]);

            // Hapus data lama dengan kode_dpt lama
            DB::table('departemens')->where('kode_dpt', $kode_dpt)->delete();
        } else {
            // Jika kode_dpt sama, cukup update nama_dpt saja
            DB::table('departemens')->where('kode_dpt', $kode_dpt)->update([
                'nama_dpt' => $request->nama_dpt,
            ]);
        }

        DB::commit(); // Simpan perubahan

        return Redirect::back()->with(['success' => 'Data Berhasil Diubah']);
    } catch (\Exception $e) {
        DB::rollBack(); // Batalkan perubahan jika ada error
        return Redirect::back()->with(['warning' => 'Data Gagal Diubah. Error']);
    }
}

    public function delete($kode_dpt)
    {
        $delete = DB::table('departemens')->where('kode_dpt', $kode_dpt)->delete();
        if ($delete) {
            return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus']);
        } else {
            return Redirect::back()->with(['success' => 'Data Gagal Di Hapus']);
        }
    }
}
