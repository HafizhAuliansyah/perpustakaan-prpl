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
                    <div class="row mb-3">
                        <a href="{{route('peminjaman.create')}}" class="btn btn-primary mr-3" role="button">
                            Tambah
                        </a>
                        <button type="button" class="btn btn-warning" role="button" data-toggle="modal" data-target="#modal_waning_mail"><i class="fa fa-bell mr-2"></i>Kirim mail peringatan</button>
                    </div>
                    <table class="table table-hover table-bordered table-stripped" id="table-data">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Peminjaman</th>
                            <th>ID Buku</th>
                            <th>NIK</th>
                            <th>Status Peminjaman</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Tanggal Pengembalian</th>
                            <th>Tanggal Selesai Pengembalian</th>
                            <th>Opsi</th>
                        </tr>
                        </thead>
                        {{-- <tbody>
                        </tbody> --}}
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_waning_mail" tabindex="-1" role="dialog" aria-labelledby="modal_export" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modal_export">Mail Peringatan Peminjaman</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                Kirim email peringatan peminjaman ke {{ $count_send_warning }} user ?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                <a href="{{route('peminjaman.warningmail')}}" class="btn btn-primary">Kirim</a>
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
                    {data: 'StatusPeminjaman', name: 'StatusPeminjaman'},
                    {data: 'TglPeminjaman', name: 'TglPeminjaman'},
                    {data: 'TglPengembalian', name: 'TglPengembalian'},
                    {data: 'TglSelesai', name: 'TglSelesai', defaultContent: '-'},
                    {data: 'action', name: 'action'},
                ],
                lengthMenu: [10, 25, 50, 75, 100],
            });
        });

    </script>
@endpush
