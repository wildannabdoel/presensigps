@extends('layouts.presensi')
@section('header')
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Lokasi</div>
        <div class="right"></div>
    </div>
@endsection
@section('content')
    <div class="col">
        <div class="row" style="margin-top: 70px">
            <h3>Titik Kordinat Anda</h3>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <input type="text" id="lokasi" autocomplete="off">
        </div>
    </div>
    <style>
        #map {
            height: 450px;
        }
    </style>
    <div id="map">

    </div>
@endsection
@push('myscript')
    <script>
        var lokasi = document.getElementById('lokasi');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
        }

        function successCallback(position) {
            lokasi.value = position.coords.latitude + "," + position.coords.longitude;
            var map = L.map('map').setView([position.coords.latitude, position.coords.longitude], 13);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);
            var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
        }

        function errorCallback() {

        }
    </script>
@endpush
