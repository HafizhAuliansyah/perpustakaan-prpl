@extends('adminlte::page')

@section('title', 'Data Denda')

@section('content_header')
    <h1 class="m-0 text-dark">Data Denda</h1>
@stop
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
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
                    @php
                         $btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                        <i class="fa fa-lg fa-fw fa-pen"></i>
                        </button>';
                        $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Edit">
                        <i class="fa fa-lg fa-fw fa-trash"></i>
                        </button>';
                    @endphp
                    <table id="table-data" class="table display table-hover table-striped display">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th data-priority="1">ID</th>
                                <th data-priority="2">IDPeminjaman</th>
                                <th data-priority="3">NIK</th>
                                <th data-priority="4">Keterangan</th>
                                <th data-priority="5">Nominal</th>
                                <th data-priority="6">Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        {{-- <tbody>
                            @foreach ($datas as $data)
                                <tr>
                                    <td>{{ $data->IDDenda }}</td>
                                    <td>{{ $data->IDPeminjaman }}</td>
                                    <td>{{ $data->NIK }}</td>
                                    <td>{{ $data->Keterangan }}</td>
                                    <td>{{ $data->Nominal }}</td>
                                    <td>{{ $data->Status }}</td>
                                    <td>
                                        <a href="{{ route('view_edit_denda', $data->IDDenda) }}">{!! $btnEdit !!}</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody> --}}
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
@push('js')
    <form action="" id="delete-form" method="post">
        @method('delete')
        @csrf
    </form>
    <script>

        function notificationBeforeDelete(event, el) {
            event.preventDefault();
            if (confirm('Apakah anda yakin akan menghapus data ? ')) {
                $("#delete-form").attr('action', $(el).attr('href'));
                $("#delete-form").submit();
            }
        }
        $(document).ready(function() {
            $('#table-data').DataTable({
                ajax: '{{ route("all_denda") }}',
                serverSide: true,
                processing: true,
                aaSorting:[[0,"asc"]],
                columns: [
                    {data: 'no', name: 'no', render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }},
                    {data: 'IDDenda', name: 'IDDenda'},
                    {data: 'IDPeminjaman', name: 'IDPeminjaman'},
                    {data: 'NIK', name: 'NIK'},
                    {data: 'Keterangan', name: 'Keterangan'},
                    {data: 'Nominal', name: 'Nominal'},
                    {data: 'Status', name: 'Status'},
                    {data: 'action', name: 'action'},
                ],
                lengthMenu: [10, 25, 50, 75, 100],
            });
        });
        
            
    </script>
@endpush