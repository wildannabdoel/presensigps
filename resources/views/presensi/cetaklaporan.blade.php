<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Laporan Absensi</title>

    <!-- Normalize CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css">

    <!-- Load paper.css untuk format cetak -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.4.1/paper.css">

    <style>
        @page {
            size: A4;
        }

        body {
            font-family: Arial, sans-serif;
        }

        /* Judul */
        .judul {
            text-align: center;
            margin-bottom: 15px;
        }

        #title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .header-address {
            font-size: 13px;
        }

        /* Garis Pembatas */
        .header-separator {
            border-bottom: 3px solid black;
            margin-bottom: 20px;
        }

        /* Data Karyawan */
        .tabledatakaryawan {
            width: 100%;
            margin-top: 10px;
            display: flex;
            align-items: center;
        }

        .tabledatakaryawan td {
            padding: 5px;
            vertical-align: middle;
        }

        .foto-karyawan {
            width: 120px;
            height: 150px;
            object-fit: cover;
            border: 2px solid black;
            margin-right: 15px;
        }

        /* Tabel Absensi */
        .tabelabsensi {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .tabelabsensi th,
        .tabelabsensi td {
            border: 2px solid black;
            padding: 5px;
            text-align: center;
            font-size: 12px;
        }

        .tabelabsensi th {
            background-color: #00ced1;
            color: black;
        }

        .foto-absensi {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border: 1px solid black;
        }

        /* Tanda Tangan */
        .ttd {
            width: 100%;
            text-align: center;
            margin-top: 50px;
        }

        .ttd p {
            font-size: 15px;
            margin-bottom: 50px;
        }

        .ttd u {
            font-weight: bold;
            font-size: 16px;
        }

        .ttd i {
            font-size: 14px;
        }
        .pemda{
            font-family: 'Times New Roman', Times, serif;
            font-size: 28px;
        }
    </style>
</head>

<body class="A4">
    <section class="sheet padding-10mm">

        <!-- Header -->
        <div class="judul">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 100px; text-align: center;">
                        <img src="{{ asset('assets/img/pemda3.png') }}" width="auto" height="110" alt="Logo">
                    </td>
                    <td style="text-align: center;">
                        <span id="title">
                            <div class="pemda">DINAS PEMUDA DAN OLAHRAGA<br></div>
                            Laporan Absensi Karyawan <br>
                            Periode Bulan {{ $namabulan[$bulan] }} Tahun {{ $tahun }}
                        </span>
                        <br>
                        <span class="header-address">
                            Jl. Raya Soreang-Cipatik, Pamekaran, Kec. Kutawaringin, Kabupaten Bandung
                        </span>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Garis Pembatas -->
        <div class="header-separator"></div>

        <!-- Data Karyawan -->
        <table class="tabledatakaryawan">
            <tr>
                <td rowspan="6">
                    @php
                        $path = Storage::url('uploads/karyawan/' . $karyawan->foto);
                    @endphp
                    <img src="{{ url($path) }}" alt="Foto Karyawan" class="foto-karyawan">
                </td>
                <td><strong>NIK</strong></td>
                <td>:</td>
                <td>{{ $karyawan->nik }}</td>
            </tr>
            <tr>
                <td><strong>Nama Lengkap</strong></td>
                <td>:</td>
                <td>{{ $karyawan->nama_lengkap }}</td>
            </tr>
            <tr>
                <td><strong>Jabatan</strong></td>
                <td>:</td>
                <td>{{ $karyawan->jabatan }}</td>
            </tr>
            <tr>
                <td><strong>Bidang</strong></td>
                <td>:</td>
                <td>{{ $karyawan->nama_dpt }}</td>
            </tr>
            <tr>
                <td><strong>No. HP</strong></td>
                <td>:</td>
                <td>{{ $karyawan->no_hp }}</td>
            </tr>
        </table>

        <!-- Tabel Absensi -->
        <table class="tabelabsensi">
            <tr>
                <th>NO</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Foto Masuk</th>
                <th>Jam Keluar</th>
                <th>Foto Keluar</th>
                <th>Keterangan</th>
            </tr>
            @foreach ($presensi as $d)
                @php
                    $path_in = Storage::url('upload/absensi' . $d->foto_in);
                    $path_out = Storage::url('upload/absensi' . $d->foto_out);
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ date('d-m-Y', strtotime($d->tanggal_presensi)) }}</td>
                    <td>{{ $d->jam_in }}</td>
                    <td><img src="{{ url($path_in) }}" alt="Foto Masuk" class="foto-absensi"></td>
                    <td>{{ $d->jam_out ?? 'Belum Absen' }}</td>
                    <td><img src="{{ url($path_out) }}" alt="Foto Keluar" class="foto-absensi"></td>
                    <td>{{ $d->jam_in > '07:30' ? 'Terlambat' : 'Tepat Waktu' }}</td>
                </tr>
            @endforeach
        </table>

        <!-- Tanda Tangan -->
        <div class="ttd">
            <p><strong>Kepala Dinas Pemuda dan Olahraga</strong></p>
            <br><br>
            <u>Dr.Ir.Erwin Rinaldi</u><br>
            <i>NIP : 12938918329831</i>
        </div>

    </section>
</body>

</html>
