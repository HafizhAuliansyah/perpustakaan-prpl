@extends('adminlte::page')

@section('title', 'Index Member')

@section('content_header')
    <h1 class="m-0 text-dark">Index Member</h1>
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
                        <a href="{{route('member.create')}}" class="btn btn-success mr-3">
                            <i class="fa fa-plus mr-2"></i>Tambah Member
                        </a>
                        <button type="button" class="btn btn-primary" role="button" data-toggle="modal" data-target="#modal_filter_pdf"><i class="fa fa-file-pdf mr-2"></i>Export to pdf</button>
                    </div>

                    <table class="table table-hover table-bordered table-stripped" id="table-data">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Status Member</th>
                            <th>Nomor Telepon</th>
                            <th>Email</th>
                            <th>Opsi</th>
                        </tr>
                        </thead>
                        <tbody>
                        {{-- @foreach($members as $member)
                            <tr>
                                <td>{{$member->NIK}}</td>
                                <td>{{$member->Nama}}</td>
                                <td>{{$member->StatusMember}}</td>
                                <td>{{$member->NomorTelepon}}</td>
                                <td>{{$member->Email}}</td>
                                <td>
                                    <a href="{{route('member.edit', $member->NIK)}}" class="btn btn-primary btn-xs">
                                        Edit
                                    </a>
                                    <a href="{{route('member.destroy', $member->NIK)}}" onclick="notificationBeforeDelete(event, this)" class="btn btn-danger btn-xs">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        @endforeach --}}
                        </tbody>
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
            <form action="{{ route('export_member') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="">-- Pilih Filter Status --</option>
                            <option value="active">Active</option>
                            <option value="non-active">Non Active</option>
                        </select>
                    </div>
                    <label class="col-form-label col-form-label-lg">Tanggal Daftar</label>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="fromTgl" class="col-form-label col-form-label-sm">From</label>
                            <input type="date" class="form-control" id="fromTgl" name="DaftarFrom">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="untilTgl" class="col-form-label col-form-label-sm">Until</label>
                            <input type="date" class="form-control" id="untilTgl" name="DaftarUntil">
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
                        }},
                    {data: 'NIK', name: 'NIK'},
                    {data: 'Nama', name: 'Nama'},
                    {data: 'StatusMember', name: 'StatusMember'},
                    {data: 'NomorTelepon', name: 'NomorTelepon'},
                    {data: 'Email', name: 'Email'},
                    {data: 'action', name: 'action'},
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
