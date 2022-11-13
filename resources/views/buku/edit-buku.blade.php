@extends('adminlte::page')

@section('title', 'Edit Buku')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Data Buku</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
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
                <div class="card-body">
                    <div class="row mb-3">
                        <a href="{{ route('all_buku') }}" class="btn btn-danger mr-3" role="button"><i class="fa fa-arrow-left mr-2"></i>Kembali</a>
                    </div>
                    @php
                        $GenreBuku = ['Horror', 'Aksi', 'Fiksi', 'Drama', 'Romansa', 'Komedi', 'Sport', 'Teknologi', 'Sejarah', 'Politik'];
                        $StatusBuku = ['Tersedia', 'Dipinjam', 'Rusak', 'Hilang'];
                    @endphp
                    <form action={{ route('edit_buku', $buku->IDBuku) }} method="post">
                        @method('patch')
                        @csrf
                        <div class="form-group">
                            <label for="NamaBuku">Nama Buku</label>
                            <input type="text" class="form-control" id="NamaBuku" name="NamaBuku" placeholder="Masukkan nama buku" value="{{ $buku->NamaBuku }}">
                        </div>
                        <div class="form-group">
                            <label for="Deksripsi">Deskripsi</label>
                            <textarea class="form-control" id="Deksripsi" rows="3" name="Deskripsi">{{ $buku->Deskripsi }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="GenreBuku">Genre Buku</label>
                            <select class="form-control" id="GenreBuku" name="GenreBuku">
                                <option value="">-- Pilih Genre --</option>
                                @foreach ($GenreBuku as $genre)
                                    <option value={{ $genre }} {{ $genre==$buku->GenreBuku? "selected" : '' }}>{{ $genre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Bahasa">Bahasa</label>
                            <input type="text" class="form-control" id="Bahasa" name="Bahasa" placeholder="Masukkan bahasa buku" value="{{ $buku->Bahasa }}">
                        </div>
                        <div class="form-group">
                            <label for="JumlahHalaman">Jumlah Halaman</label>
                            <input type="text" class="form-control" id="JumlahHalaman" name="JumlahHalaman" placeholder="Masukkan jumlah halaman" onkeypress="return hanyaAngka(event)" value={{ $buku->JumlahHalaman }}>
                        </div>
                        <div class="form-group">
                            <label for="GenreBuku">Status Buku</label>
                            <select class="form-control" id="StatusBuku" name="StatusBuku">
                                @foreach ($StatusBuku as $status)
                                    <option value={{ $status }} {{ $status==$buku->StatusBuku? "selected" : '' }}>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Penulis">Penulis</label>
                            <input type="text" class="form-control" id="Penulis" name="Penulis" placeholder="Masukkan nama penulis" value="{{ $buku->Penulis }}">
                        </div>
                        <div class="form-group">
                            <label for="Penerbit">Penerbit</label>
                            <input type="text" class="form-control" id="Penerbit" name="Penerbit" placeholder="Masukkan nama penerbit" value="{{ $buku->Penerbit }}">
                        </div>
                        <div class="form-group">
                            <label for="LetakRak">Letak Rak</label>
                            <input type="text" class="form-control" id="LetakRak" name="LetakRak" placeholder="Masukkan letak rak (Contoh : 'A1')" value="{{ $buku->LetakRak }}">
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mb-2"><i class="fa fa-pen mr-2"></i>Edit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@push('js')
<script>
    function hanyaAngka(evt) {
       var charCode = evt.which ? evt.which : event.keyCode;
       if (charCode > 31 && (charCode < 48 || charCode > 57)) return false;
       return true;
    }
</script>
@endpush