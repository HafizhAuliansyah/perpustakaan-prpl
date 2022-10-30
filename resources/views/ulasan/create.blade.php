@extends('adminlte::page')
  
@section('title', 'Tambah Ulasan')

@section('content_header')
    <h1 class="m-0 text-dark">Tambah Ulasan</h1>
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
                    <form action={{ route('add_ulasan') }} method="post">
                        @csrf
                        <div class="form-group">
                            <label for="NIK">NIK</label>
                            <input type="text" class="form-control" id="NIK" name="NIK" placeholder="Masukkan NIK">
                        </div>
                        <div class="form-group">
                            <label for="Masukan">Masukan</label>
                            <textarea class="form-control" id="Masukan" rows="3" name="masukan"></textarea>
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