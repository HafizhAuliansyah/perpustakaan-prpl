@extends('adminlte::page')

@section('title', 'Tambah Peminjaman')

@section('content_header')
    <h1 class="m-0 text-dark">Peminjaman Buku</h1>
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
    <form action="{{route('peminjaman.store')}}" method="post" autocomplete="off">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="exampleInput">ID Buku</label>
                            <div id="reader" width="600px"></div>
                            <input class="form-control @error('IDBuku') is-invalid @enderror" list="datalistBuku" name="IDBuku" id="inputIDBuku" placeholder="Cari ID Buku">
                            @error('IDBuku') <span class="text-danger">{{$message}}</span> @enderror
                            <datalist id="datalistBuku">
                                @foreach ($bukus as $buku)
                                    <option value={{$buku->IDBuku}}>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="form-group">
                            <label for="exampleInput">NIK</label>
                            <input class="form-control @error('NIK') is-invalid @enderror" list="datalistMember" name="NIK" id="exampleDataList" placeholder="Cari NIK">
                            @error('NIK') <span class="text-danger">{{$message}}</span> @enderror
                            <datalist id="datalistMember">
                                @foreach ($members as $member)
                                    <option value={{$member->NIK}}>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="form-group">
                            <label for="exampleTglPeminjaman">Tanggal Peminjaman</label>
                            <input type="date" class="form-control @error('TglPeminjaman') is-invalid @enderror" id="exampleTglPeminjaman" name="TglPeminjaman" value="{{Carbon\Carbon::now()->format('Y-m-d')}}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleHariPinjam">Hari Peminjaman</label>
                            {{-- <input type="date" class="form-control @error('TglPengembalian') is-invalid @enderror" id="exampleTglPengembalian" name="TglPengembalian" value="{{old('TglPengembalian')}}" min="{{Carbon\Carbon::now()->format('Y-m-d')}}" max="{{Carbon\Carbon::now()->addWeek()->format('Y-m-d')}}"> --}}
                            <select class="form-control" id="exampleHariPinjam" name="HariPinjam" onchange="updateTglPengembalian(event)">
                                @for ($i = 1; $i < 8; $i++)
                                    <option value={{$i}}>{{$i." Hari"}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleTglPengembalian">Tanggal Pengembalian</label>
                            <input type="date" class="form-control @error('TglPengembalian') is-invalid @enderror" id="exampleTglPengembalian" name="TglPengembalian" value="{{Carbon\Carbon::now()->addDays(1)->format('Y-m-d')}}" disabled>
                        </div>
                        {{-- <div class="form-group">
                            <label for="exampleTglPengembalian">Tanggal Pengembalian</label> --}}
                            {{-- <input type="date" class="form-control @error('TglPengembalian') is-invalid @enderror" id="exampleTglPengembalian" name="TglPengembalian" value="{{old('TglPengembalian')}}" min="{{Carbon\Carbon::now()->format('Y-m-d')}}" max="{{Carbon\Carbon::now()->addWeek()->format('Y-m-d')}}"> --}}
                            {{-- <input type="date" class="form-control @error('TglPengembalian') is-invalid @enderror" id="exampleTglPengembalian" name="TglPengembalian" value="{{Carbon\Carbon::now()->addDays(1)->format('Y-m-d')}}" disabled>
                        </div> --}}
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{route('peminjaman.index')}}" class="btn btn-default">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Scripts --}}
        <script type = "text/JavaScript" src="https://momentjs.com/downloads/moment.js"></script>
        <script type = "text/JavaScript" src="https://momentjs.com/downloads/moment-with-locales.js"></script>
        <script type = "text/JavaScript">
            function updateTglPengembalian(event) {
                let day = document.getElementById("exampleHariPinjam").value;
                let borrowingDay = moment().add(day, 'days').format('yyyy-MM-DD');
                document.getElementById("exampleTglPengembalian").value = borrowingDay;
            }
        </script>
        <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
        <script>
            function onScanSuccess(decodedText, decodedResult) {
            // handle the scanned code as you like, for example:
            // console.log(`Code matched = ${decodedText}`, decodedResult);
                $('#inputIDBuku').val(decodedText);
        }

            function onScanFailure(error) {
            // handle scan failure, usually better to ignore and keep scanning.
            // for example:
            console.warn(`Code scan error = ${error}`);
            }

            let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            { fps: 10, qrbox: {width: 250, height: 250} },
            /* verbose= */ false);
            html5QrcodeScanner.render(onScanSuccess, onScanFailure);    
        </script>
@stop
