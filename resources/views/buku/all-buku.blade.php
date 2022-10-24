@extends('adminlte::page')

@section('title', 'Data Buku')

@section('content_header')
    <h1 class="m-0 text-dark">Data Buku</h1>
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
                    <table id="table-data" class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama Buku</th>
                                <th>Deskripsi</th>
                                <th>Genre Buku</th>
                                <th>Bahasa</th>
                                <th>Jumlah Halaman</th>
                                <th>Status Buku</th>
                                <th>Penerbit</th>
                                <th>Penulis</th>
                                <th>Letak Rak</th>
                                <th>Tanggal Masuk</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        {{-- <tbody>
                            @foreach ($datas as $data)
                                <tr>
                                    <td>{{ $data->IDBuku }}</td>
                                    <td>{{ $data->NamaBuku }}</td>
                                    <td>{{ $data->Deskripsi }}</td>
                                    <td>{{ $data->GenreBuku }}</td>
                                    <td>{{ $data->Bahasa }}</td>
                                    <td>{{ $data->JumlahHalaman }}</td>
                                    <td>{{ $data->StatusBuku }}</td>
                                    <td>{{ $data->Penerbit }}</td>
                                    <td>{{ $data->Penulis }}</td>
                                    <td>{{ $data->LetakRak }}</td>
                                    <td>{{ $data->TglMasukBuku }}</td>
                                    <td>
                                        <a href="{{ route('view_edit_buku', $data->IDBuku) }}">{!! $btnEdit !!}</a>
                                        <a href="/buku/delete/{{ $data->IDBuku }}" onclick="notificationBeforeDelete(event, this)">{!! $btnDelete !!}</a>
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
        $('#table-data').DataTable({
            responsive: true,
            ajax: {
                url: '{{ route("part-buku") }}',
            },
            serverSide: true,
            processing: true,
            aaSorting:[[0,"asc"]],
            columns: [
                {data: 'IDBuku', name: 'IDBuku'},
                {data: 'NamaBuku', name: 'NamaBuku'},
                {data: 'Deskripsi', name: 'Deskripsi'},
                {data: 'GenreBuku', name: 'GenreBuku'},
                {data: 'Bahasa', name: 'Bahasa'},
                {data: 'JumlahHalaman', name: 'JumlahHalaman'},
                {data: 'StatusBuku', name: 'StatusBuku'},
                {data: 'Penerbit', name: 'Penerbit'},
                {data: 'Penulis', name: 'Penulis'},
                {data: 'LetakRak', name: 'LetakRak'},
                {data: 'TglMasukBuku', name: 'TglMasukBuku'},
                {data: 'action', name: 'action'},
            ],
            lengthMenu: [10, 25, 50, 75, 100],
        });
            
    </script>
@endpush