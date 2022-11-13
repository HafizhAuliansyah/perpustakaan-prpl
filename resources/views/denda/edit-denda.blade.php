@extends('adminlte::page')

@section('title', 'Edit Denda')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Data Denda</h1>
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
                    @php
                        $status = ['Lunas', 'Belum Lunas'];
                        $keterangan = ['Merusak Buku', 'Menghilangkan Buku', 'Merusak Fasilitas', 'Membawa Makanan/Minuman', 'Buang Sampah Sembarang'];
                    @endphp
                    <form action={{ route('edit_denda', $denda->IDDenda) }} method="post">
                        @method('patch')
                        @csrf
                        <div class="form-group">
                            <label for="NIK">NIK</label>
                            <input type="text" class="form-control" id="NIK" name="NIK" placeholder="Masukkan NIK" value="{{ $denda->NIK }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="Keterangan">Keterangan</label>
                            <select class="form-control" id="Keterangan" name="Keterangan" >
                                @foreach ($keterangan as $keteranganDenda)
                                    <option value="{{ $keteranganDenda }}" "{{ $keteranganDenda==$denda->Keterangan? "selected" : '' }}">{{ $keteranganDenda }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Nominal">Nominal</label>
                            <input type="text" class="form-control" id="Nominal" name="Nominal" placeholder="Masukkan Jumlah Nominal" onkeypress="return hanyaAngka(event)" value={{ $denda->Nominal }}>
                        </div>
                        <div class="form-group">
                            <label for="Status">Status Denda</label>
                            <select class="form-control" id="Status" name="Status">
                                @foreach ($status as $statusDenda)
                                    <option value="{{ $statusDenda }}" "{{ $statusDenda==$denda->Status? "selected" : '' }}">{{ "$statusDenda" }}</option>
                                @endforeach
                            </select>
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