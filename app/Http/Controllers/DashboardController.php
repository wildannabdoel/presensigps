<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {
        $hariini = date('Y-m-d');
        $bulanini = date('m') * 1;
        $tahunini = date('Y');
        $nik = Auth::guard('karyawan')->user()->nik;
        $presensihariini = DB::table('presensis')
            ->where('nik', $nik)->where('tanggal_presensi', $hariini)->first();
        $historibulanini = DB::table('presensis')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tanggal_presensi)="' . $bulanini . '"')
            ->whereRaw('YEAR(tanggal_presensi)="' . $tahunini . '"')
            ->orderBy('tanggal_presensi')
            ->get();

        $rekappresensi = DB::table('presensis')
            ->selectRaw('COUNT(nik) as jmlhadir ,SUM(IF(jam_in > "07:30", 1,0)) as jmlterlambat')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tanggal_presensi)="' . $bulanini . '"')
            ->whereRaw('YEAR(tanggal_presensi)="' . $tahunini . '"')
            ->first();

        $leaderboard = DB::table('presensis')
            ->join('karyawans', 'presensis.nik', '=', 'karyawans.nik')
            ->where('tanggal_presensi', $hariini)
            ->orderBy('jam_in')
            ->get();
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        $rekapizin = DB::table('pengajuan_izins')
            ->selectRaw('SUM(IF(status = "i",1,0)) as jmlizin,SUM(IF(status = "s",1,0)) as jmlsakit')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_izin)="' . $bulanini . '"')
            ->whereRaw('YEAR(tgl_izin)="' . $tahunini . '"')
            ->where('status_approved', 1)
            ->first();
        return view('dashboard.dashboard', compact(
            'presensihariini',
            'historibulanini',
            'namabulan',
            'bulanini',
            'tahunini',
            'rekappresensi',
            'leaderboard',
            'rekapizin'
        ));
    }
    public function lokasipegawai(Request $request)
    {
        $id = $request->id;
        $presensi = DB::table('presensis')->where('id', $id)
            ->join('karyawans', 'presensis.nik', '=', 'karyawans.nik')
            ->first();
        return view('lokasi.pegawai', compact('presensi'));
    }

    public function dashboardadmin()
    {
        $hariini = date('Y-m-d');
        $rekappresensi = DB::table('presensis')
            ->selectRaw('COUNT(nik) as jmlhadir ,SUM(IF(jam_in > "07:30", 1,0)) as jmlterlambat')
            ->where('tanggal_presensi', $hariini)
            ->first();

        $rekapizin = DB::table('pengajuan_izins')
            ->selectRaw('SUM(IF(status = "i",1,0)) as jmlizin,SUM(IF(status = "s",1,0)) as jmlsakit')
            ->where('tgl_izin', $hariini)
            ->where('status_approved', 1)
            ->first();

        $hariini = date('Y-m-d');
        $nik = Auth::guard('user')->user()->nik;
        $presensihariini = DB::table('presensis')
            ->where('nik', $nik)->where('tanggal_presensi', $hariini)->first();

        $leaderboard = DB::table('presensis')
            ->join('karyawans', 'presensis.nik', '=', 'karyawans.nik')
            ->where('tanggal_presensi', $hariini)
            ->orderBy('jam_in', 'asc')
            ->orderBy('jam_out', 'asc')
            ->get();
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        return view('dashboard.dashboardadmin', compact('rekappresensi', 'rekapizin', 'leaderboard','presensihariini'));
    }
}
