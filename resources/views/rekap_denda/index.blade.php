@extends('adminlte::page')

@section('title', 'Data Rekap Denda')

@section('content_header')
    <h1 class="m-0 text-dark">Data Rekap Denda</h1>
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
                            <a href="{{route('rekap_denda.store')}}" class="btn btn-success px-6" role="button">
                                <i class="fa fa-book pr-2" aria-hidden="true"></i>
                                Data Rekap Denda
                            </a>
                        </div>
                    </div>
                    <table class="table table-hover table-bordered table-stripped" id="table-data">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Rekap Denda</th>
                            <th>Tanggal Dibentuk</th>
                            <th>Jumlah Data Denda</th>
                            <th>Jumlah Total Nominal</th>
                            <th>Nominal Terbesar</th>
                            <th>Nominal Terkecil</th>
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
                ajax: '{{ route("rekap_denda.part") }}',
                serverSide: true,
                processing: true,
                aaSorting:[[0,"asc"]],
                columns: [
                    {data: 'no', name: 'no', render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }},
                    {data: 'IDRekapDenda', name: 'IDRekapDenda'},
                    {data: 'TglDibentuk', name: 'TglDibentuk'},
                    {data: 'JumlahDataDenda', name: 'JumlahDataDenda'},
                    {data: 'JumlahNominal', name: 'JumlahNominal'},
                    {data: 'NominalTerbesar', name: 'NominalTerbesar'},
                    {data: 'NominalTerkecil', name: 'NominalTerkecil'},
                ],
                lengthMenu: [10, 25, 50, 75, 100],
            });
        });

    </script>
@endpush
