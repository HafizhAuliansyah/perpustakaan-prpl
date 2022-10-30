@extends('adminlte::page')

@section('title', 'Tambah User')

@section('content_header')
    <h1 class="m-0 text-dark">Tambah User</h1>
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
    <form action="{{route('member.store')}}" method="post">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <div class="form-group">
                            <label for="exampleInputNIK">NIK</label>
                            <input type="text" class="form-control @error('NIK') is-invalid @enderror" id="exampleInputNIK" placeholder="NIK" name="NIK" value="{{old('NIK')}}">
                            @error('NIK') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputNama">Nama</label>
                            <input type="text" class="form-control @error('Nama') is-invalid @enderror" id="exampleInputNama" placeholder="Nama lengkap" name="Nama" value="{{old('Nama')}}">
                            @error('Nama') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail">Status Member</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="active" name="StatusMember" id="flexRadioDefault1" checked>
                                <label class="form-check-label" for="flexRadioDefault1">
                                  Aktif
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="non-active" name="StatusMember" id="flexRadioDefault2">
                                <label class="form-check-label" for="flexRadioDefault2">
                                  Non Aktif
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="blacklisted" name="StatusMember" id="flexRadioDefault2">
                                <label class="form-check-label" for="flexRadioDefault2">
                                  Black List
                                </label>
                            </div>
                            {{-- <input type="text" class="form-control @error('StatusMember') is-invalid @enderror" id="exampleInputStatusMember" placeholder="Masukkan Status Member" name="StatusMember" value="{{old('StatusMember')}}">
                            @error('StatusMember') <span class="text-danger">{{$message}}</span> @enderror --}}
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail">Nomor Telepon</label>
                            <input type="text" class="form-control @error('NomorTelepon') is-invalid @enderror" id="exampleInputNomorTelepon" placeholder="Masukkan Nomor Telepon" name="NomorTelepon" value="{{old('NomorTelepon')}}">
                            @error('NomorTelepon') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail">Email address</label>
                            <input type="text" class="form-control @error('Email') is-invalid @enderror" id="exampleInputEmail" placeholder="Masukkan Email" name="Email" value="{{old('Email')}}">
                            @error('Email') <span class="text-danger">{{$message}}</span> @enderror
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{route('member.index')}}" class="btn btn-default">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </div>
@stop
