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
                    <table class="table table-hover table-bordered table-stripped" id="example2">
                        <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Ulasan</th>
                        </tr>
                        </thead>
                        <tbody>
                    @php
                        $btnDelete = '<button class="btn btn-xs btn-default text-danger mx-1 shadow" title="Edit">
                        <i class="fa fa-lg fa-fw fa-trash"></i>
                        </button>';
                        
                    @endphp
                        @foreach($datas as $key => $index)
                            <tr>
                                <td>{{$index->NIK}}</td>
                                <td>{{$index->masukan}}</td>
                                <td>
                                    <a href="/ulasan/delete/{{ $index->id }}" onclick="notificationBeforeDelete(event, this)">{!! $btnDelete !!}</a>
                                </td>
                        @endforeach
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
        $('#example2').DataTable({
            "responsive": true,
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
