@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle text-center">
                        Halaman
                    </div>
                    <h2 class="page-title" style="justify-content: center">
                        Pengajuan Izin / Sakit
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    @if (Session::get('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    @if (Session::get('warning'))
                        <div class="alert alert-warning">
                            {{ Session::get('warning') }}
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <form action="/presensi/izinsakit" method="GET" autocomplete="off">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="input-icon mb-3">
                                                    <span class="input-icon-addon">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="currentColor"
                                                            class="icon icon-tabler icons-tabler-filled icon-tabler-calendar-month">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path
                                                                d="M8 12a1 1 0 0 1 1 1v4a1 1 0 0 1 -2 0v-4a1 1 0 0 1 1 -1" />
                                                            <path
                                                                d="M12 12a1 1 0 0 1 1 1v4a1 1 0 0 1 -2 0v-4a1 1 0 0 1 1 -1" />
                                                            <path
                                                                d="M16 12a1 1 0 0 1 1 1v4a1 1 0 0 1 -2 0v-4a1 1 0 0 1 1 -1" />
                                                            <path
                                                                d="M16 2a1 1 0 0 1 .993 .883l.007 .117v1h1a3 3 0 0 1 2.995 2.824l.005 .176v12a3 3 0 0 1 -2.824 2.995l-.176 .005h-12a3 3 0 0 1 -2.995 -2.824l-.005 -.176v-12a3 3 0 0 1 2.824 -2.995l.176 -.005h1v-1a1 1 0 0 1 1.993 -.117l.007 .117v1h6v-1a1 1 0 0 1 1 -1m3 7h-14v9.625c0 .705 .386 1.286 .883 1.366l.117 .009h12c.513 0 .936 -.53 .993 -1.215l.007 -.16z" />
                                                        </svg>
                                                    </span>
                                                    <input type="text" id="dari" value="{{ Request('dari') }}" name="dari"
                                                        class="form-control" placeholder="Dari Tanggal">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="input-icon mb-3">
                                                    <span class="input-icon-addon">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="currentColor"
                                                            class="icon icon-tabler icons-tabler-filled icon-tabler-calendar-month">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path
                                                                d="M8 12a1 1 0 0 1 1 1v4a1 1 0 0 1 -2 0v-4a1 1 0 0 1 1 -1" />
                                                            <path
                                                                d="M12 12a1 1 0 0 1 1 1v4a1 1 0 0 1 -2 0v-4a1 1 0 0 1 1 -1" />
                                                            <path
                                                                d="M16 12a1 1 0 0 1 1 1v4a1 1 0 0 1 -2 0v-4a1 1 0 0 1 1 -1" />
                                                            <path
                                                                d="M16 2a1 1 0 0 1 .993 .883l.007 .117v1h1a3 3 0 0 1 2.995 2.824l.005 .176v12a3 3 0 0 1 -2.824 2.995l-.176 .005h-12a3 3 0 0 1 -2.995 -2.824l-.005 -.176v-12a3 3 0 0 1 2.824 -2.995l.176 -.005h1v-1a1 1 0 0 1 1.993 -.117l.007 .117v1h6v-1a1 1 0 0 1 1 -1m3 7h-14v9.625c0 .705 .386 1.286 .883 1.366l.117 .009h12c.513 0 .936 -.53 .993 -1.215l.007 -.16z" />
                                                        </svg>
                                                    </span>
                                                    <input type="text" id="sampai" value="{{ Request('sampai') }}" name="sampai"
                                                        class="form-control" placeholder="Sampai Tanggal">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="input-icon mb-3">
                                                    <span class="input-icon-addon">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-barcode">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M4 7v-1a2 2 0 0 1 2 -2h2" />
                                                            <path d="M4 17v1a2 2 0 0 0 2 2h2" />
                                                            <path d="M16 4h2a2 2 0 0 1 2 2v1" />
                                                            <path d="M16 20h2a2 2 0 0 0 2 -2v-1" />
                                                            <path d="M5 11h1v2h-1z" />
                                                            <path d="M10 11l0 2" />
                                                            <path d="M14 11h1v2h-1z" />
                                                            <path d="M19 11l0 2" />
                                                        </svg>
                                                    </span>
                                                    <input type="text" id="nik" value="{{ Request('nik') }}" name="nik"
                                                        class="form-control" placeholder="NIK">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="input-icon mb-3">
                                                    <span class="input-icon-addon">
                                                        <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                                                            <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                                        </svg>
                                                    </span>
                                                    <input type="text" id="nama_lengkap" value="{{ Request('nama_lengkap') }}"
                                                        name="nama_lengkap" class="form-control"
                                                        placeholder="Nama Karyawan">
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <select name="status_approved" id="status_approved"
                                                        class="form-select">
                                                        <option value="">Pilih Status</option>
                                                        <option value="0" {{ Request('status_approved')==='0' ?  'selected' : '' }} >Menunggu</option>
                                                        <option value="1" {{ Request('status_approved')=='1' ?  'selected' : '' }} >Disetujui</option>
                                                        <option value="2" {{ Request('status_approved')=='2' ?  'selected' : '' }} >Ditolak</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <button class="btn btn-primary">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-search">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" />
                                                            <path d="M21 21l-6 -6" />
                                                        </svg>
                                                        Cari
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <td>N0</td>
                                        <td>NIK</td>
                                        <td>Nama Karyawan</td>
                                        <td>Jabatan</td>
                                        <td>Status</td>
                                        <td>Keterangan</td>
                                        <td>Tanggal</td>
                                        <td>Status</td>
                                        <td>Aksi</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($izinsakit as $d)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $d->nik }}</td>
                                            <td>{{ $d->nama_lengkap }}</td>
                                            <td>{{ $d->jabatan }}</td>
                                            <td>{{ $d->status == 'i' ? 'Izin' : 'Sakit' }}</td>
                                            <td>{{ $d->keterangan }}</td>
                                            <td>{{ date('d-m-Y', strtotime($d->tgl_izin)) }}</td>
                                            <td>
                                                @if ($d->status_approved == 1)
                                                    <span class="badge bg-success">Disetehui</span>
                                                @elseif($d->status_approved == 2)
                                                    <span class="badge bg-danger">Ditolak</span>
                                                @else
                                                    <span class="badge bg-info">Menunggu</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($d->status_approved == 0)
                                                    <a href="#" class="btn btn-primary btn-sm" id="approve"
                                                        id_izinsakit="{{ $d->id }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path
                                                                d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                                            <path
                                                                d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                                            <path d="M16 5l3 3" />
                                                        </svg>
                                                        Aksi
                                                    </a>
                                                @else
                                                    <a href="/presensi/{{ $d->id }}/batalkanizinsakit"
                                                        class="btn btn-warning btn-sm">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                            height="24" viewBox="0 0 24 24" fill="none"
                                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            class="icon icon-tabler icons-tabler-outline icon-tabler-xbox-x">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path
                                                                d="M12 21a9 9 0 0 0 9 -9a9 9 0 0 0 -9 -9a9 9 0 0 0 -9 9a9 9 0 0 0 9 9z" />
                                                            <path d="M9 8l6 8" />
                                                            <path d="M15 8l-6 8" />
                                                        </svg>
                                                        Batalkan
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal modal-blur fade" id="modal-izinsakit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Persetejuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/presensi/approveizinsakit" method="POST">
                        @csrf
                        <input type="hidden" id="izin_sakit_form" name="izin_sakit_form">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <select name="status_approved" id="status_approved" class="form-select">
                                        <option value="1">Disetujui</option>
                                        <option value="2">Ditolak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <dilv class="form-group">
                                    <button class="btn btn-primary w-100" type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-square-rounded-check">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M9 12l2 2l4 -4" />
                                            <path d="M12 3c7.2 0 9 1.8 9 9s-1.8 9 -9 9s-9 -1.8 -9 -9s1.8 -9 9 -9z" />
                                        </svg>
                                        Submit
                                    </button>
                                </dilv>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('myscript')
    <script>
        $(function() {
            $("#approve").click(function(e) {
                e.preventDefault();
                var id_izinsakit = $(this).attr("id_izinsakit");
                $("#izin_sakit_form").val(id_izinsakit);
                $("#modal-izinsakit").modal("show");
            });
            $("#dari, #sampai").datepicker({
                autoclose: true,
                todayHighlight: true,
                format: 'yyyy-mm-dd'
            });
        });
    </script>
@endpush
