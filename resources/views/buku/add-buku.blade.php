@extends('adminlte::page')

@section('title', 'Tambah Buku')

@section('content_header')
    <h1 class="m-0 text-dark">Tambah Data Buku</h1>
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
                <div class="card-body">
                    @php
                        $GenreBuku = ['Horror', 'Aksi', 'Fiksi', 'Drama', 'Romansa', 'Komedi', 'Sport', 'Teknologi', 'Sejarah', 'Politik'];
                        $Bahasa = ['Indonesia', 'Inggris', 'Jepang', 'China', 'Arab', 'Prancis'];
                        $StatusBuku = ['Dipinjam', 'Rusak', 'Hilang', 'Tersedia'];
                    @endphp
                    <form action={{ route('add_buku') }} method="post">
                        @csrf
                        <input type="hidden" name="IDBuku" value="{{ $new_id }}">
                        <div class="form-group">
                            <label for="NamaBuku">Nama Buku</label>
                            <input type="text" class="form-control" id="NamaBuku" name="NamaBuku" placeholder="Masukkan nama buku">
                        </div>
                        <div class="form-group">
                            <label for="Deksripsi">Deskripsi</label>
                            <textarea class="form-control" id="Deksripsi" rows="3" name="Deskripsi"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="GenreBuku">Genre Buku</label>
                            <select class="form-control" id="GenreBuku" name="GenreBuku">
                                @foreach ($GenreBuku as $genre)
                                    <option value={{ $genre }}>{{ $genre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Bahasa">Bahasa</label>
                            <select class="form-control" id="Bahasa" name="Bahasa">
                                @foreach ($Bahasa as $bhs)
                                    <option value={{ $bhs }}>{{ $bhs }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="JumlahHalaman">Jumlah Halaman</label>
                            <input type="text" class="form-control" id="JumlahHalaman" name="JumlahHalaman" placeholder="Masukkan jumlah halaman" onkeypress="return hanyaAngka(event)">
                        </div>
                        <div class="form-group">
                            <label for="GenreBuku">Status Buku</label>
                            <select class="form-control" id="StatusBuku" name="StatusBuku">
                                @foreach ($StatusBuku as $status)
                                    <option value={{ $status }}>{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Penulis">Penulis</label>
                            <input type="text" class="form-control" id="Penulis" name="Penulis" placeholder="Masukkan nama penulis">
                        </div>
                        <div class="form-group">
                            <label for="Penerbit">Penerbit</label>
                            <input type="text" class="form-control" id="Penerbit" name="Penerbit" placeholder="Masukkan nama penerbit">
                        </div>
                        <div class="form-group">
                            <label for="LetakRak">Letak Rak</label>
                            <input type="text" class="form-control" id="LetakRak" name="LetakRak" placeholder="Masukkan letak rak (Contoh : 'A1')">
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mb-2"><i class="fa fa-save mr-2"></i>Save</button>
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