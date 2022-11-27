<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <section class="header">
        <div class="title-header">Perpustakaan</div>
        <div class="subtitle-header">Data Member</div>
        <hr class="line-header">
    </section>
    <section class="content">
        <div class="body-header">
            <div class="subtitle-body">Jumlah Data : {{ $jumlah }}</div>
        </div>
        <table class="table_pdf" cellspacing="0">
            <thead>
                <tr>
                    <th>NIK</th>
                    <th>Nama</th>
                    <th>Status</th>
                    <th>Nomor Telepon</th>
                    <th>Email</th>
                    <th>Tgl Daftar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $data)
                    <tr>
                        <td>{{ $data->NIK }}</td>
                        <td>{{ $data->Nama }}</td>
                        <td>{{ $data->StatusMember }}</td>
                        <td>{{ $data->NomorTelepon }}</td>
                        <td>{{ $data->Email }}</td>
                        <td>{{ $data->tgl_daftar }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</body>
</html>