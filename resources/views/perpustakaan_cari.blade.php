@extends('layouts.perpustakaan')
@section('body')
<div class="container-cari">
    <table id="table-data" class="table display table-hover table-striped display w-100">
        <thead>
            <tr>
                <th>NO</th>
                <th data-priority="2">Nama Buku</th>
                <th data-priority="4">Genre Buku</th>
                <th data-priority="5">Bahasa</th>
                <th>Status Buku</th>
                <th>Penerbit</th>
                <th>Penulis</th>
                <th>Letak Rak</th>
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

@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('#table-data').DataTable({
                ajax: '{{ route("pengunjung.all_buku") }}',
                serverSide: true,
                processing: true,
                aaSorting:[[0,"asc"]],
                columns: [
                    {data: 'no', name: 'no', render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }},
                    {data: 'NamaBuku', name: 'NamaBuku'},
                    {data: 'GenreBuku', name: 'GenreBuku'},
                    {data: 'Bahasa', name: 'Bahasa'},
                    {data: 'StatusBuku', name: 'StatusBuku'},
                    {data: 'Penerbit', name: 'Penerbit'},
                    {data: 'Penulis', name: 'Penulis'},
                    {data: 'LetakRak', name: 'LetakRak'},
                ],
                lengthMenu: [10, 25, 50, 75, 100],
            });
        });
    </script>
@endpush