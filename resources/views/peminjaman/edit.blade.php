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
                            <input class="form-control @error('IDBuku') is-invalid @enderror" list="datalistBuku" name="IDBuku" id="exampleDataList" placeholder="Cari ID Buku" value="{{$data->IDBuku}}">
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
                            <input class="form-control @error('NIK') is-invalid @enderror" list="datalistMember" name="NIK" id="exampleDataList" placeholder="Cari NIK" value="{{$data->NIK}}">
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
                                {{-- <option @if (old('StatusPeminjaman') == 'sudah kembali' || $data->StatusPeminjaman == 'sudah kembali' )
                                    selected
                                @endif value='sudah kembali'>Sudah Kembali</option>
                                <option @if (old('StatusPeminjaman') == 'belum kembali' || $data->StatusPeminjaman == 'belum kembali')
                                    selected
                                @endif value='belum kembali'>Belum Kembali</option>
                                <option @if (old('StatusPeminjaman') == 'batal' || $data->StatusPeminjaman == 'batal')
                                    selected
                                @endif value='batal'>Batal</option> --}}
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleTglPeminjaman">Tanggal Peminjaman</label>
                            <input type="date" class="form-control @error('TglPeminjaman') is-invalid @enderror" id="exampleTglPeminjaman" name="TglPeminjaman" value="{{Carbon\Carbon::parse($data->TglPeminjaman)->format('Y-m-d')}}" disabled>
                        </div>
                        <div class="form-group">
                            <label for="exampleTglPengembalian">Tanggal Pengembalian</label>
                            <input type="date" class="form-control @error('TglPengembalian') is-invalid @enderror" id="exampleTglPengembalian" name="TglPengembalian" value="{{ $data->TglPengembalian??old('TglPengembalian')}}" min="{{Carbon\Carbon::parse($data->TglPeminjaman)->format('Y-m-d')}}" max="{{Carbon\Carbon::parse($data->TglPeminjaman)->addWeek()->format('Y-m-d')}}">
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
@stop
