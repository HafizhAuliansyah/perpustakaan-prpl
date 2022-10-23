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
                        $heads = [
                            'ID',
                            'NamaBuku',
                            'Deskripsi',
                            'GenreBuku',
                            'Bahasa',
                            'JumlahHalaman',
                            'StatusBuku',
                            'Penerbit',
                            'Penulis',
                            'LetakRak',
                            'TglMasukBuku',
                            'Actions'
                        ];
                        $config = [
                            'data' => $datas,
                            'order' => [[1, 'asc']],
                            'columns' => [null, null, null, ['orderable' => false]],
                            'responsive' => true,
                            'columns'=> [
                                [ 'responsivePriority' => 1 ],
                                ['responsivePriority' => 2],
                                ['responsivePriority'=> 3],
                                ['responsivePriority'=> 4],
                                ['responsivePriority'=> 5],
                                ['responsivePriority'=> 6],
                            ]
                        ];
                        $btnEdit = '<button class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit">
                        <i class="fa fa-lg fa-fw fa-pen"></i>
                        </button>';
                        $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Edit">
                        <i class="fa fa-lg fa-fw fa-trash"></i>
                        </button>';
                        
                    @endphp
                    <x-adminlte-datatable id="table-data" :heads="$heads" head-theme="dark" :config="$config"
                    striped hoverable bordered compressed beautify responsive>
                    @foreach($config['data'] as $data)
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
                    </x-adminlte-datatable>
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

    </script>
@endpush