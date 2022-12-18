@extends('adminlte::page')

@section('title', 'Edit Peminjaman')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Peminjaman</h1>
@stop

@section('content')
    @if (session('Success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('Success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @elseif(session('Error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('Error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
    </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    @foreach ($peminjaman as $data)
    <form action="{{route('peminjaman.update', $data->IDPeminjaman)}}" method="post" autocomplete="off">
        @method('PUT')
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="exampleInput">ID Buku</label>
                            <input class="form-control @error('IDBuku') is-invalid @enderror" list="datalistBuku" name="IDBuku" id="exampleDataList" placeholder="Cari ID Buku" value="{{$data->IDBuku}}" readonly>
                            @error('IDBuku') <span class="text-danger">{{$message}}</span> @enderror
                            <datalist id="datalistBuku">
                                @foreach ($bukus as $buku)
                                    <option value={{$buku->IDBuku}}>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="form-group">
                            <input type="hidden" name="oldIDBuku" value="{{$data->IDBuku}}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInput">NIK</label>
                            <input class="form-control @error('NIK') is-invalid @enderror" list="datalistMember" name="NIK" id="exampleDataList" placeholder="Cari NIK" value="{{$data->NIK}}" readonly>
                            @error('NIK') <span class="text-danger">{{$message}}</span> @enderror
                            <datalist id="datalistMember">
                                @foreach ($members as $member)
                                    <option value={{$member->NIK}}>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="form-group">
                            <label for="StatusPeminjamanInput">Status Peminjaman</label>
                            <select class="form-control" id="StatusPeminjamanInput" name="StatusPeminjaman">
                                <option {{old('StatusPeminjaman') == 'sudah kembali' || $data->StatusPeminjaman == 'sudah kembali' ? 'selected' : ''}} value='sudah kembali'>Sudah Kembali</option>
                                <option {{old('StatusPeminjaman') == 'belum kembali' || $data->StatusPeminjaman == 'belum kembali' ? 'selected' : ''}} value='belum kembali'>Belum Kembali</option>
                                <option {{old('StatusPeminjaman') == 'batal' || $data->StatusPeminjaman == 'batal' ? 'selected' : ''}} value='batal'>Batal</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleTglPeminjaman">Tanggal Peminjaman</label>
                            <input type="date" class="form-control @error('TglPeminjaman') is-invalid @enderror" id="exampleTglPeminjaman" name="TglPeminjaman" value="{{$data->TglPeminjaman}}" disabled>
                            @php
                                $tglPinjam = $data->TglPeminjaman;
                            @endphp
                        </div>
                        <div class="form-group">
                            <label for="exampleHariPinjam">Hari Peminjaman</label>
                            {{-- <input type="date" class="form-control @error('TglPengembalian') is-invalid @enderror" id="exampleTglPengembalian" name="TglPengembalian" value="{{old('TglPengembalian')}}" min="{{Carbon\Carbon::now()->format('Y-m-d')}}" max="{{Carbon\Carbon::now()->addWeek()->format('Y-m-d')}}"> --}}
                            <select class="form-control" id="exampleHariPinjam" name="hariPinjam" onchange="updateTglPengembalian(event)" {{ $data->StatusPeminjaman=="sudah kembali" ? "disabled" : "" }}>
                                @php
                                    $interval = strtotime($data->TglPengembalian) - strtotime($data->TglPeminjaman);
                                    $interval = round($interval / (60*60*24));
                                @endphp
                                
                                @for ($i = 1; $i < 8; $i++)
                                    <option value={{$i}} {{ $interval==$i?'selected':'' }}>{{$i." Hari"}}</option>
                                @endfor
                            </select>

                        </div>
                        <div class="form-group">
                            <label for="exampleTglPengembalian">Tanggal Pengembalian</label>
                            <input type="date" class="form-control @error('TglPengembalian') is-invalid @enderror" id="exampleTglPengembalian" name="TglPengembalian" value="{{$data->TglPengembalian}}" disabled>
                            
                        </div>

                        <div class="form-group">
                            <label for="TglSelesaiInput">Tanggal Selesai Peminjaman</label>
                            <input type="date" class="form-control @error('TglSelesai') is-invalid @enderror" id="TglSelesaiInput" name="TglSelesai" value="{{ $data->TglSelesai==null ? "" : $data->TglSelesai }}">
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{route('peminjaman.index')}}" class="btn btn-default">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endforeach

    {{-- Scripts --}}
    <script type = "text/JavaScript" src="https://momentjs.com/downloads/moment.js"></script>
    <script type = "text/JavaScript" src="https://momentjs.com/downloads/moment-with-locales.js"></script>
    <script type = "text/JavaScript">
        function updateTglPengembalian(event) {
            let borrowingDay = @json($tglPinjam);
            let day = document.getElementById("exampleHariPinjam").value;
            let borrowingLimitDay = moment(borrowingDay).add(day, 'days').format('yyyy-MM-DD');
            document.getElementById("exampleTglPengembalian").value = borrowingLimitDay;
        }
       
    </script>
@stop
@push('js')
    <script>
        $(document).ready(function(){
        var tglSelesaiInput = $("#TglSelesaiInput");
        $("#StatusPeminjamanInput").on("change", function(){
            var status = $("#StatusPeminjamanInput").val();
            if(status === "sudah kembali"){
                tglSelesaiInput.prop("disabled", false);

            }else{
                tglSelesaiInput.prop("disabled", true);
            }
        });
    });
    </script>
@endpush
