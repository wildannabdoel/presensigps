<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $admins = User::all(); // Menggunakan model User
        return view('user.index', compact('admins'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        try {
            $simpan = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            if ($simpan) {
                return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
            }
        } catch (\Exception $d) {
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan ' . $d->getMessage()]);
        }
    }
    public function edit(Request $request)
    {
        $id = $request->id;
        $admin = DB::table('users')->where('id', $id)->first();
        return view('user.edit', compact('admin'));
    }
    public function update($id, Request $request)
    {
        try {
            // Pastikan ID valid
            $admin = DB::table('users')->where('id', $id)->first();
            if (!$admin) {
                return Redirect::back()->with(['warning' => 'User tidak ditemukan']);
            }

            // Ambil inputan
            $name = $request->name;
            $email = $request->email;
            $password = $request->password ? Hash::make($request->password) : $admin->password; // Jika tidak diubah, gunakan password lama

            // Buat data update
            $data = [
                'name' => $name,
                'email' => $email,
                'password' => $password
            ];

            // Jalankan update
            $update = DB::table('users')->where('id', $id)->update($data);

            // Cek hasil update
            if ($update) {
                return Redirect::back()->with(['success' => 'Data Berhasil Diubah']);
            }
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
    public function delete($id)
    {
        $delete = DB::table('users')->where('id', $id)->delete();
        if ($delete) {
            return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Di Hapus']);
        }
    }
}
