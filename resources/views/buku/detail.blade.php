@extends('adminlte::page')

@section('title', 'Detail Buku')

@section('content_header')
    <h1 class="m-0 text-dark">Detail Buku</h1>
@stop
@push('css')
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
@endpush

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @if (empty($buku))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Buku Tidak Ditemukan !!
                    </div>
                    @else
                    <div class="row mb-3">
                        <a href="{{ route('all_buku') }}" class="btn btn-danger mr-3" role="button"><i class="fa fa-arrow-left mr-2"></i>Kembali</a>
                    </div>
                        <div class="row">
                            <div class="col-md-6">
                                <h5 class="font-weight-bold">ID Buku</h5>
                            </div>
                            <div class="col-md-6">
                                <p>{{ $buku->IDBuku }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="font-weight-bold">Nama Buku</h5>
                            </div>
                            <div class="col-md-6">
                                <p>{{ $buku->NamaBuku }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="font-weight-bold">Deskripsi</h5>
                            </div>
                            <div class="col-md-6">
                                <p>{{ $buku->Deskripsi }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="font-weight-bold">Genre</h5>
                            </div>
                            <div class="col-md-6">
                                <p>{{ $buku->GenreBuku }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="font-weight-bold">Bahasa</h5>
                            </div>
                            <div class="col-md-6">
                                <p>{{ $buku->Bahasa }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="font-weight-bold">Jumlah Halaman</h5>
                            </div>
                            <div class="col-md-6">
                                <p>{{ $buku->JumlahHalaman }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="font-weight-bold">Status</h5>
                            </div>
                            <div class="col-md-6">
                                <p>{{ $buku->StatusBuku }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="font-weight-bold">Penerbit</h5>
                            </div>
                            <div class="col-md-6">
                                <p>{{ $buku->Penerbit }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="font-weight-bold">Penulis</h5>
                            </div>
                            <div class="col-md-6">
                                <p>{{ $buku->Penulis }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="font-weight-bold">Letak Rak</h5>
                            </div>
                            <div class="col-md-6">
                                <p>{{ $buku->LetakRak }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="font-weight-bold">Cover</h5>
                            </div>
                            <div class="col-md-6">
                                <img src="{{url('/images/buku/cover/'.$buku->Cover )}}" class="cover_buku">
                            </div>
                            <div class="col-md-6">
                                <h5 class="font-weight-bold">QR Code</h5>
                            </div>
                            <div class="col-md-6">
                                <img src="{{url('/images/buku/qr_code/'. $buku->QRCode )}}" class="qr_buku">
                            </div>
                        </div>
                    @endif
                
                    
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