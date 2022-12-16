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
        <div class="subtitle-header">Data Peminjaman</div>
        <hr class="line-header">
    </section>
    <section class="content">
        <div class="body-header">
            <div class="subtitle-body">Jumlah Data : {{ $jumlah }}</div>
        </div>
        <table class="table_pdf" cellspacing="0">
            <thead>
                <tr>
                    <th>ID Peminjaman</th>
                    <th>ID Buku</th>
                    <th>NIK</th>
                    <th>Status Peminjaman</th>
                    <th>Tanggal Peminjaman</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Tanggal Selesai</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($datas as $data)
                @php
                    $status = $data->StatusPeminjaman;
                    $colorText = "";
                    if($status == "belum kembali"){
                        $colorText = "#dc3545";
                    }elseif($status == "sudah kembali"){
                        $colorText = "#264653";
                    }else{
                        $colotText = "#000000";
                    }
                @endphp
                    <tr>
                        <td>{{ $data->IDPeminjaman }}</td>
                        <td>{{ $data->IDBuku }}</td>
                        <td>{{ $data->NIK }}</td>
                        <td style="color: {{ $colorText }}">{{ $data->StatusPeminjaman }}</td>
                        <td>{{ $data->TglPeminjaman }}</td>
                        <td>{{ $data->TglPengembalian }}</td>
                        <td>{{ $data->TglSelesai }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</body>
</html>