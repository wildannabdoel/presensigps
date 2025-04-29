<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\pengajuan_izin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;


class PresensiController extends Controller
{
    public function create()
    {
        $hariini = date('Y-m-d');
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('presensis')->where('nik',     $nik)->where('tanggal_presensi', $hariini)->count();
        $lok_kantor = DB::table('konfigurasi_lokasis')->where('id', 1)->first();
        return view('presensi.create', compact('cek', 'lok_kantor'));
    }

    public function store(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tanggal_presensi = date('Y-m-d');
        $jam = date('H:i:s');
        $lok_kantor = DB::table('konfigurasi_lokasis')->where('id', 1)->first();
        $lok = explode(",", $lok_kantor->lokasi_kantor);
        $latitudekantor = $lok[0];
        $longitudekantor = $lok[1];
        $lokasi = $request->lokasi;
        $lokasiuser = explode(",", $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];

        $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
        $radius = round($jarak["meters"]);
        $cek = DB::table('presensis')->where('nik', $nik)->where('tanggal_presensi', $tanggal_presensi)->count();
        if ($cek > 0) {
            $ket = "out";
        } else {
            $ket = "in";
        }

        $image = $request->image;
        $folderPath = "public/upload/absensi";
        $formatName = $nik . "_" . $tanggal_presensi . "-" . $ket;
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . ".png";
        $file = $folderPath . $fileName;
        $data = [
            'nik' => $nik,
            'tanggal_presensi' => $tanggal_presensi,
            'jam_in' => $jam,
            'foto_in' => $fileName,
            'lokasi_in' => $lokasi
        ];
        if ($radius > $lok_kantor->radius) {
            return response()->json([
                'status' => 'error',
                'message' => 'Jarak Terlalu Jauh'
            ]);
        } else {
            if ($cek > 0) {
                $data_pulang = [
                    'jam_out' => $jam,
                    'foto_out' => $fileName,
                    'lokasi_out' => $lokasi
                ];
                $update = DB::table('presensis')
                    ->where('nik', $nik)
                    ->where('tanggal_presensi', $tanggal_presensi)
                    ->update($data_pulang);
                if ($update) {
                    Storage::put($file, $image_base64);
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Absen Pulang Berhasil',
                        'type' => 'out'
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Absen Pulang Gagal'
                    ]);
                }
            } else {
                $simpan = DB::table('presensis')->insert($data);
                if ($simpan) {
                    Storage::put($file, $image_base64);
                    return response()->json([
                        'status' => 'success',
                        'message' => 'Absen Masuk Berhasil',
                        'type' => 'in'
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Absen Masuk Gagal'
                    ]);
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
        $meters = $kilometers * 300;
        return compact('meters');
    }
    public function editprofile()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawans')->where('nik', $nik)->first();

        return view('presensi.editprofile', compact('karyawan'));
    }

    public function updateprofile(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make($request->password);
        $karyawan = DB::table('karyawans')->where('nik', $nik)->first();
        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $karyawan->foto;
        }
        if (empty($request->password)) {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'foto' => $foto
            ];
        } else {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'password' => $password,
                'foto' => $foto
            ];
        }
        $update = DB::table('karyawans')->where('nik', $nik)->update($data);
        if ($update) {
            if ($request->hasFile('foto')) {
                $folderPath = "public/uploads/karyawan/";
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return redirect()->back()->with(['success' => 'Profil berhasil diperbarui.']);
        } else {
            return redirect()->back()->with(['error' => 'Profil gagal diperbarui.']);
        }
    }
    public function histori()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('presensi.histori', compact('namabulan'));
    }

    public function gethistori(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = Auth::guard('karyawan')->user()->nik;

        $histori  = DB::table('presensis')
            ->whereRaw('MONTH(tanggal_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tanggal_presensi)="' . $tahun . '"')
            ->where('nik', $nik)
            ->orderBy('tanggal_presensi')
            ->get();

        return view('presensi.gethistori', compact('histori'));
    }

    public function izin()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $dataizin = DB::table('pengajuan_izins')->where('nik', $nik)->get();
        return view('presensi.izin', compact('dataizin'));
    }

    public function buatizin()
    {

        return view('presensi.buatizin');
    }
    public function storeizin(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tgl_izin = $request->tgl_izin;
        $status = $request->status;
        $keterangan = $request->keterangan;
        $data = [
            'nik' => $nik,
            'tgl_izin' => $tgl_izin,
            'status' => $status,
            'keterangan' => $keterangan
        ];
        $simpan = DB::table('pengajuan_izins')->insert($data);
        if ($simpan) {
            return redirect('/presensi/izin')->with(['success' => 'Pengajuan berhasil dibuat.']);
        } else {
            return redirect('/presensi/izin')->with(['error' => 'Pengajuan gagal dibuat.']);
        }
    }
    public function monitoring()
    {
        return view('presensi.monitoring');
    }

    public function getpresensi(Request $request)
    {
        $tanggal = $request->tanggal;
        $presensi = DB::table('presensis')
            ->select('presensis.*', 'nama_lengkap', 'nama_dpt')
            ->join('karyawans', 'presensis.nik', '=', 'karyawans.nik')
            ->join('departemens', 'karyawans.kode_dpt', '=', 'departemens.kode_dpt')
            ->where('tanggal_presensi', $tanggal)
            ->get();

        return view('presensi.getpresensi', compact('presensi'));
    }
    public function tampilkanpeta(Request $request)
    {
        $id = $request->id;
        $presensi = DB::table('presensis')->where('id', $id)
            ->join('karyawans', 'presensis.nik', '=', 'karyawans.nik')
            ->first();
        return view('presensi.showlokasi', compact('presensi'));
    }
    public function laporan()
    {
        $namabulan = [
            "",
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember"
        ];
        $karyawan = DB::table('karyawans')->orderBy('nama_lengkap')->get();
        return view('presensi.laporan', compact('namabulan', 'karyawan'));
    }
    public function cetaklaporan(Request $request)
    {
        $nik = $request->nik;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $namabulan = [
            "",
            "Januari",
            "Februari",
            "Maret",
            "April",
            "Mei",
            "Juni",
            "Juli",
            "Agustus",
            "September",
            "Oktober",
            "November",
            "Desember"
        ];
        $karyawan = DB::table('karyawans')->where('nik', $nik)
            ->join('departemens', 'departemens.kode_dpt', '=', 'karyawans.kode_dpt')
            ->first();

        $presensi = DB::table('presensis')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tanggal_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tanggal_presensi)="' . $tahun . '"')
            ->orderBy('tanggal_presensi')
            ->get();
        $karyawan = Karyawan::find($nik);
        if (!$karyawan) {
            return redirect()->back()->with('warning', 'Data karyawan tidak ditemukan');
        }


        return view('presensi.cetaklaporan', compact('bulan', 'tahun', 'namabulan', 'karyawan', 'presensi'));
    }
    public function izinsakit(Request $request)
    {
        $query = pengajuan_izin::query();
        $query->select('id', 'tgl_izin', 'pengajuan_izins.nik', 'nama_lengkap', 'jabatan', 'status', 'status_approved', 'keterangan');
        $query->join('karyawans', 'pengajuan_izins.nik', '=', 'karyawans.nik');
        if (!empty($request->dari) && !empty($request->sampai)) {
            $query->whereBetween('tgl_izin', [$request->dari, $request->sampai]);
        }
        if (!empty($request->nik)) {
            $query->where('pengajuan_izins.nik', $request->nik);
        }
        if (!empty($request->nama_lengkap)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        }
        if ($request->status_approved === '0' || $request->status_approved === '1' || $request->status_approved === '2') {
            $query->where('status_approved', $request->status_approved);
        }
        $query->orderBy('tgl_izin', 'desc');
        $izinsakit = $query->get();
        return view('presensi.izinsakit', compact('izinsakit'));
    }
    public function approveizinsakit(Request $request)
    {
        $status_approved = $request->status_approved;
        $izin_sakit_form = $request->izin_sakit_form;
        $update = DB::table('pengajuan_izins')->where('id', $izin_sakit_form)->update([
            'status_approved' => $status_approved
        ]);
        if ($update) {
            return Redirect::back()->with(['success' => 'Pengajuan Berhasil Di Konfirmasi']);
        } else {
            return Redirect::back()->with(['warning' => 'Pengajuan Gagal Di Konfirmasi']);
        }
    }
    public function batalkanizinsakit($id)
    {
        $update = DB::table('pengajuan_izins')->where('id', $id)->update([
            'status_approved' => 0
        ]);
        if ($update) {
            return Redirect::back()->with(['success' => 'Pengajuan Berhasil Di Update']);
        } else {
            return Redirect::back()->with(['warning' => 'Pengajuan Gagal Di Update']);
        }
    }

    public function cekpengajuanizin(Request $request)
    {
        $tgl_izin = $request->tgl_izin;
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('pengajuan_izins')->where('nik', $nik)->where('tgl_izin', $tgl_izin)->count();
        return $cek;
    }
}
