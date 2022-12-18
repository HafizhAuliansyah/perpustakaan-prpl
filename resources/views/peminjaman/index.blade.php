@extends('adminlte::page')

@section('title', 'Data Peminjaman')

@section('content_header')
    <h1 class="m-0 text-dark">Data Peminjaman</h1>
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
                        <div class="px-2">
                            <a href="{{route('peminjaman.create')}}" class="btn btn-primary" role="button">
                                <i class="fa fa-plus pr-2" aria-hidden="true"></i>
                                Tambah
                            </a>
                        </div>
                        <div class="px-2">
                            <button type="button" class="btn btn-warning" role="button" data-toggle="modal" data-target="#modal_waning_mail">
                                <i class="fa fa-bell pr-2"></i>
                                Kirim mail peringatan
                            </button>
                        </div>
                        <div class="px-2">
                            <a href="{{route('rekap_peminjaman.store')}}" class="btn btn-success px-6" role="button">
                                <i class="fa fa-book pr-2" aria-hidden="true"></i>
                                Rekap Bulanan
                            </a>
                        </div>
                        <div class="px-2">
                            <button type="button" class="btn btn-primary mr-3" role="button" data-toggle="modal" data-target="#modal_filter_pdf">
                                <i class="fa fa-file-pdf mr-2"></i>
                                Export to pdf
                            </button>
                        </div>
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
    <div class="modal fade" id="modal_filter_pdf" tabindex="-1" role="dialog" aria-labelledby="modal_export" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modal_export">Filter Export</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="{{ route('export_peminjaman') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="GenreBuku">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="" selected disabled>-- Pilih Filter Status --</option>
                            <option value="belum kembali">belum kembali</option>
                            <option value="sudah kembali">sudah kembali</option>
                            <option value="batal">batal</option>
                        </select>
                    </div>
                    <label class="col-form-label col-form-label-lg">Tanggal Peminjaman</label>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="fromTglPeminjaman" class="col-form-label col-form-label-sm">From</label>
                            <input type="date" class="form-control" id="fromTglPeminjaman" name="PeminjamanFrom">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="untilTglPeminjaman" class="col-form-label col-form-label-sm">Until</label>
                            <input type="date" class="form-control" id="untilTglPeminjaman" name="PeminjamanUntil">
                        </div>
                    </div>
                    <label class="col-form-label col-form-label-lg">Tanggal Pengembalian</label>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="fromTglPengembalian" class="col-form-label col-form-label-sm">From</label>
                            <input type="date" class="form-control" id="fromTglPengembalian" name="PengembalianFrom">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="untilTglPengembalian" class="col-form-label col-form-label-sm">Until</label>
                            <input type="date" class="form-control" id="untilTglPengembalian" name="PengembalianUntil">
                        </div>
                    </div>
                    <label class="col-form-label col-form-label-lg">Tanggal Selesai</label>
                    <div class="form-row" id="filterTglSelesai">
                        <div class="form-group col-md-6">
                            <label for="fromTglSelesai" class="col-form-label col-form-label-sm">From</label>
                            <input type="date" class="form-control" id="fromTglSelesai" name="SelesaiFrom" disabled>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="untilTglSelesai" class="col-form-label col-form-label-sm">Until</label>
                            <input type="date" class="form-control" id="untilTglSelesai" name="SelesaiUntil" disabled>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">

                    <button type="submit" class="btn btn-primary">Export</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                </div>
            </form>
          </div>
        </div>
    </div>
@stop

@push('js')
    <script>
       $(document).ready(function() {
            var formSelesai = $("#fromTglSelesai");
            var untilSelesai = $("#untilTglSelesai");
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
            $("#status").on('change', function(){

                var status = $("#status").val();
                if(status !== "sudah kembali"){
                    formSelesai.prop('disabled', true);
                    untilSelesai.prop('disabled', true);

                }else{
                    formSelesai.prop('disabled', false);
                    untilSelesai.prop('disabled', false);
                }
            });
        });

    </script>
@endpush
