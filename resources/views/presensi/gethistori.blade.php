@if ($histori->isEmpty())
    <div class="alert alert-danger">
        <p style="font-size: 1rem">Tidak ada data</p>
    </div>
@endif

@foreach ( $histori as $d )
   <ul class="listview image-listview">
    <li>
        <div class="item">
            @php
                $path = Storage::url('upload/absensi' . $d->foto_in);
            @endphp
            <img src="{{ url($path) }}" alt="image" class="image">
            <div class="in">    
                <div>
                    <b>{{ date("d-m-Y", strtotime($d->tanggal_presensi)) }}</b><br>
                </div>
                <span class="badge {{ $d->jam_in < "07:30" ? "bg-success": "bg-danger" }}">
                    {{ $d->jam_in }}
                </span>
                <span class="badge bg-primary">{{ $d->jam_out }}</span>
            </div>
        </div>  
    </li>
   </ul>

@endforeach