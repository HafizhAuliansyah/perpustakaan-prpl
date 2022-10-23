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
                            'TglMasukBuku'
                        ];
                        $config = [
                            'data' => $datas,
                            'order' => [[1, 'asc']],
                            'columns' => [null, null, null, ['orderable' => false]],
                        ]
                    @endphp
                    <x-adminlte-datatable id="table2" :heads="$heads" head-theme="dark"
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
                    </tr>
                    @endforeach
                    </x-adminlte-datatable>
                </div>
            </div>
        </div>
    </div>
@stop