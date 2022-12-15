@extends('adminlte::page')
  
@section('title', 'Data Ulasan')

@section('content_header')
    <h1 class="m-0 text-dark">Data Ulasan</h1>
@stop


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <a href="{{route('view_add_ulasan')}}" class="btn btn-primary mr-3" role="button">
                            Tambah
                        </a>
                    </div>
                    <table class="table table-hover table-bordered table-stripped" id="table-data">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Ulasan</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{-- @foreach($datas as $key => $index)
                            <tr>
                                <td>{{$index->NIK}}</td>
                                <td>{{$index->masukan}}</td>
                        @endforeach --}}
                        </tbody>
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
       $(document).ready(function() {
            $('#table-data').DataTable({
                ajax: '',
                serverSide: true,
                processing: true,
                aaSorting:[[0,"asc"]],
                columns: [
                    {data: 'no', name: 'no', render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                    }, width: '5%'},
                    {data: 'masukan', name: 'masukan'},
                ],
                lengthMenu: [10, 25, 50, 75, 100],
            });
        });

        function notificationBeforeDelete(event, el) {
            event.preventDefault();
            if (confirm('Apakah anda yakin akan menghapus data ? ')) {
                $("#delete-form").attr('action', $(el).attr('href'));
                $("#delete-form").submit();
            }
        }

    </script>
@endpush
