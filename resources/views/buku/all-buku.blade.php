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
                    <div class="row mb-3">
                        <a href="{{ route('view_add_buku') }}" class="btn btn-success mr-3" role="button"><i class="fa fa-plus mr-2"></i>Tambah Buku</a>
                        <button type="button" class="btn btn-primary" role="button" data-toggle="modal" data-target="#modal_filter_pdf"><i class="fa fa-file-pdf mr-2"></i>Export to pdf</button>
                    </div>
                    <table id="table-data" class="table display table-hover table-striped display">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th data-priority="1">ID</th>
                                <th data-priority="2">Nama Buku</th>
                                <th data-priority="3">Deskripsi</th>
                                <th data-priority="4">Genre Buku</th>
                                <th data-priority="5">Bahasa</th>
                                <th data-priority="6">Jumlah Halaman</th>
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
    <div class="modal fade" id="modal_filter_pdf" tabindex="-1" role="dialog" aria-labelledby="modal_export" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="modal_export">Filter Export</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            @php
                $StatusBuku = ['Tersedia', 'Rusak', 'Hilang'];
                $GenreBuku = ['Horror', 'Aksi', 'Fiksi', 'Drama', 'Romansa', 'Komedi', 'Sport', 'Teknologi', 'Sejarah', 'Politik'];
            @endphp
            <form action="{{ route('export_buku') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="NamaBuku">Inisial Nama Buku</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama buku">
                    </div>
                    <div class="form-group">
                        <label for="Bahasa">Bahasa</label>
                        <input type="text" class="form-control" id="Bahasa" name="bahasa" placeholder="Masukkan bahasa buku">
                    </div>
                    <div class="form-group">
                        <label for="GenreBuku">Genre Buku</label>
                        <select class="form-control" id="genre" name="genre">
                            <option value="">-- Pilih Genre --</option>
                            @foreach ($GenreBuku as $genre)
                                <option value={{ $genre }}>{{ $genre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="GenreBuku">Status Buku</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">-- Pilih Status --</option>
                            @foreach ($StatusBuku as $status)
                                <option value={{ $status }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="Penulis">Penulis</label>
                        <input type="text" class="form-control" id="Penulis" name="penulis" placeholder="Masukkan nama penulis">
                    </div>
                    <div class="form-group">
                        <label for="Penerbit">Penerbit</label>
                        <input type="text" class="form-control" id="Penerbit" name="penerbit" placeholder="Masukkan nama penerbit">
                    </div>
                    <div class="form-group">
                        <label for="LetakRak">Letak Rak</label>
                        <input type="text" class="form-control" id="LetakRak" name="letakrak" placeholder="Masukkan letak rak (Contoh : 'A1')">
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
                ajax: '{{ route("all_buku") }}',
                serverSide: true,
                processing: true,
                aaSorting:[[0,"asc"]],
                columns: [
                    {data: 'no', name: 'no', render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }},
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
        });
        
            
    </script>
@endpush