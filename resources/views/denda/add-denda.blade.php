@extends('adminlte::page')

@section('title', 'Tambah Denda')

@section('content_header')
    <h1 class="m-0 text-dark">Tambah Data Denda</h1>
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
                @php
                    $keterangan = [ 'Merusak Buku', 'Menghilangkan Buku', 'Tenggat Pengembalian'];
                @endphp

                <div class="card-body">
                    <form action={{ route('add_denda') }} method="post">
                        @csrf
                        <input type="hidden" name="IDDenda" value="{{ $new_id }}">
                        <input type="hidden" name="Status" value="Belum Lunas">
                        <div class="form-group">
                            <label for="Peminjaman" id="peminjamanLabel">Peminjaman</label>
                            <input type="text" class="form-control @error('IDPeminjaman') is-invalid @enderror" datalist="dataListPeminjaman" class="form-control" id="IDPeminjaman" name="IDPeminjaman" placeholder="Masukkan IDPeminjaman">
                            @error('IDPeminjaman') <span class="text-danger">{{$message}}</span> @enderror
                            <datalist id="dataListPeminjaman">
                                @foreach ($peminjamans as $peminjaman)
                                    <option value={{$peminjaman->IDPeminjaman}}>
                                @endforeach
                            </datalist>
                        </div>
                        <div class="form-group">
                            <label for="Keterangan">Keterangan</label>
                            <select class="form-control" id="Keterangan" name="Keterangan" onchange="hideNominal()">
                                @foreach ($keterangan as $keteranganDenda)
                                    <option value="{{ $keteranganDenda }}">{{ $keteranganDenda }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Nominal" id="nominalLabel">Nominal</label>
                            <input type="text" class="form-control" id="Nominal" name="Nominal" placeholder="Masukkan Nominal Denda" onkeypress="return hanyaAngka(event)">
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
    function hideNominal(){
        let keterangan = document.getElementById("Keterangan");
        let nominal = document.getElementById("Nominal");
        let nominalLabel = document.getElementById("nominalLabel");
        if(keterangan.value === 'Tenggat Pengembalian'){
            nominal.style.visibility = 'hidden';
            nominalLabel.style.visibility = 'hidden';
        } else{
            nominal.style.visibility = 'visible';
            nominalLabel.style.visibility = 'visible';
        }
    }
</script>
@endpush
