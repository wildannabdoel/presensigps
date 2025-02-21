@extends('layouts.admin.tabler')
@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle text-center">
                        Konfigurasi
                    </div>
                    <h2 class="page-title" style="justify-content: center">
                        Lokasi Kantor
                    </h2>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-6">
                    <di class="card">
                        <div class="card-body">
                            <form action="/konfigurasi/updatelokasi" method="POST">
                                @csrf
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
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="currentColor"
                                                    class="icon icon-tabler icons-tabler-filled icon-tabler-current-location">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path
                                                        d="M12 1a1 1 0 0 1 1 1v1.055a9.004 9.004 0 0 1 7.946 7.945h1.054a1 1 0 0 1 0 2h-1.055a9.004 9.004 0 0 1 -7.944 7.945l-.001 1.055a1 1 0 0 1 -2 0v-1.055a9.004 9.004 0 0 1 -7.945 -7.944l-1.055 -.001a1 1 0 0 1 0 -2h1.055a9.004 9.004 0 0 1 7.945 -7.945v-1.055a1 1 0 0 1 1 -1m0 4a7 7 0 1 0 0 14a7 7 0 0 0 0 -14m0 3a4 4 0 1 1 -4 4l.005 -.2a4 4 0 0 1 3.995 -3.8" />
                                                </svg>
                                            </span>
                                            <input type="text" id="lokasi_kantor" value="{{ $lok_kantor->lokasi_kantor }}" name="lokasi_kantor"
                                                class="form-control" placeholder="Kordinat Kantor">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="input-icon mb-3">
                                            <span class="input-icon-addon">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/user -->
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="icon icon-tabler icons-tabler-outline icon-tabler-radar-2">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                    <path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
                                                    <path d="M15.51 15.56a5 5 0 1 0 -3.51 1.44" />
                                                    <path d="M18.832 17.86a9 9 0 1 0 -6.832 3.14" />
                                                    <path d="M12 12v9" />
                                                </svg>
                                            </span>
                                            <input type="text" id="radius" value="{{ $lok_kantor->radius }}" name="radius"
                                                class="form-control" placeholder="Radius">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12"></div>
                                    <button class="btn btn-primary w-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-edit-circle">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M12 15l8.385 -8.415a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3z" />
                                            <path d="M16 5l3 3" />
                                            <path d="M9 7.07a7 7 0 0 0 1 13.93a7 7 0 0 0 6.929 -6" />
                                        </svg>
                                        Ubah Lokasi
                                    </button>
                                </div>
                            </form>
                        </div>
                    </di>
                </div>
            </div>
        </div>
    </div>
@endsection
