@extends('layouts.presensi')
@section('header')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
<style>
    .datepicker-modal{
        max-height: 430px !important;
    }
</style>
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="/dashboard" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Form Izin</div>
    <div class="right"></div>
</div>

@endsection
@section('content')
<div class="row" style="margin-top: 70px">
    <div class="col">
        <form action="/presensi/storeizin" method="POST" id="frmizin">
            @csrf
                <div class="col">
                    <div class="form-group">
                        <input type="text" id="tgl_izin" name="tgl_izin" class="form-control datepicker" placeholder="Tanggal">
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <select name="status" id="status" class="form-control">
                            <option value="">Izin / Sakit</option>
                            <option value="i">Izin</option>
                            <option value="s">Sakit</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control" placeholder="Keterangan"></textarea>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary btn-block">Kirim</button>
                    </div>
                </div>
        </form>
    </div>
</div>
@endsection

@push('myscript')
    <script>
        var currYear = (new Date()).getFullYear();

        $(document).ready(function() {
        $(".datepicker").datepicker({
            format: "yyyy-mm-dd"    
         });

         $("#tgl_izin").change(function(e){
            var tgl_izin = $(this).val();
            $.ajax ({       
                type : 'POST',
                url : '/presensi/cekpengajuanizin',
                data : {
                    _token : "{{ csrf_token() }}",
                    tgl_izin : tgl_izin
                },
                cache : false,
                success : function(respond){
                  if(respond==1) {
                    Swal.fire({
                        title: 'Gagal',
                        text: 'Anda Sudah Melakukan Pengajuan Izin / Sakit Pada Tanggal Tersebut',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                        }).then((result)=>{
                            $("#tgl_izin").val("");
                        });
                  }
                }
            });
         });
         $('#frmizin').submit(function(){
            event.preventDefault(); // Mencegah form dikirim secara otomatis
            var tgl_izin = $('#tgl_izin').val();
            var status = $('#status').val();
            var keterangan = $('#keterangan').val();
            if (tgl_izin == ""){
                Swal.fire({
                        title: 'Oops',
                        text: 'Tanggal Tidak Boleh Kosong',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                        });
                return false;
            }else if (status == ""){
                Swal.fire({
                        title: 'Oops',
                        text: 'Status Tidak Boleh Kosong',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                        });
                return false;
            }else if (keterangan == ""){
                Swal.fire({
                        title: 'Oops',
                        text: 'Tanggal Tidak Boleh Kosong',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                        });
                return false;
            }
            this.submit();
         });
        });
    </script>
@endpush