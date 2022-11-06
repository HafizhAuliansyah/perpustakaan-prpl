@extends('adminlte::page')

@section('title', 'Index Peminjaman')

@section('content_header')
    <h1 class="m-0 text-dark">Index Peminjaman</h1>
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
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <a href="{{route('peminjaman.create')}}" class="btn btn-primary mb-2">
                        Tambah
                    </a>

                    <table class="table table-hover table-bordered table-stripped" id="table-data">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Peminjaman</th>
                            <th>ID Buku</th>
                            <th>NIK</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Status Peminjaman</th>
                            <th>Tanggal Pengembalian</th>
                        </tr>
                        </thead>
                        {{-- <tbody>
                        </tbody> --}}
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@push('js')
    <script>
       $(document).ready(function() {
            $('#table-data').DataTable({
                ajax: '',
                serverSide: true,
                processing: true,
                aaSorting:[[0,"asc"]],
                columns: [
                    {data: 'no', name: 'no', render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }},
                    {data: 'IDPeminjaman', name: 'IDPeminjaman'},
                    {data: 'IDBuku', name: 'IDBuku'},
                    {data: 'NIK', name: 'NIK'},
                    {data: 'TglPeminjaman', name: 'TglPeminjaman'},
                    {data: 'StatusPeminjaman', name: 'StatusPeminjaman'},
                    {data: 'TglPengembalian', name: 'TglPengembalian'},
                ],
                lengthMenu: [10, 25, 50, 75, 100],
            });
        });

    </script>
@endpush
