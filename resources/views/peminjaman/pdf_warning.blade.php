
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
        <div class="subtitle-header">Peringatan Pengembalian Buku</div>
        <hr class="line-header">
    </section>
    <section class="content">
        <div class="body-header">
            <div class="subtitle-body">Jumlah Buku : {{ $jumlah }}</div>
        </div>
        @foreach ($datas as $data)
            @php
                $sisaHari = strtotime($data->TglPeminjaman) - strtotime(date('Y-m-d'));
                $sisaHari = round($sisaHari / (60*60*24));

                $colorHeader = "#264653";
                if($data->StatusPeminjaman == "belum kembali"){
                    if($sisaHari == 0 || $sisaHari == 1){
                        $colorHeader = "#dc3545";
                    }elseif($sisaHari > 1 && $sisaHari < 6){
                        $colorHeader = "#ffc107";
                    }elseif ($sisaHari < 0) {
                        $colorHeader = "#a52532";
                    }
                }
                
            @endphp 
            <div class="book-card" >
                <div class="book-data id-buku" style="background-color: {{ $colorHeader }}">#{{ $data->IDBuku }}</div>
                
                <table class="table-data">
                    <tr>
                        <td class="data-title">Judul</td>
                        <td class="data-content">{{ $data->NamaBuku }}</td>
                    </tr>
                    <tr>
                        <td class="data-title">Genre</td>
                        <td class="data-content">{{ $data->GenreBuku }}</td>
                    </tr>
                    <tr>
                        <td class="data-title">Bahasa</td>
                        <td class="data-content">{{ $data->Bahasa }}</td>
                    </tr>
                    <tr>
                        <td class="data-title">Jumlah Halaman</td>
                        <td class="data-content">{{ $data->JumlahHalaman }}</td>
                    </tr>
                    <tr>
                        <td class="data-title">Penerbit : </td>
                        <td class="data-content">{{ $data->Penerbit }}</td>
                    </tr>
                    <tr>
                        <td class="data-title">Penulis</td>
                        <td class="data-content">{{ $data->Penulis }}</td>
                    </tr>
                    <tr>
                        <td class="data-title">Tanggal Dipinjam</td>
                        <td class="data-content">{{ $data->TglPeminjaman }}</td>
                    </tr>
                    <tr>
                        <td class="data-title">Status Peminjaman</td>
                        <td class="data-content" style="color: {{ $colorHeader }}">{{ $data->StatusPeminjaman }}</td>
                    </tr>
                    @if ($data->StatusPeminjaman == "belum kembali")
                        <tr>
                            <td class="data-title">{{ $sisaHari < 0 ? "Lama Keterlambatan" : "Sisa Hari" }} hari</td>
                            <td class="data-content">{{ $sisaHari < 0 ? abs($sisaHari) : $sisaHari}}</td>
                        </tr>
                    @endif
                </table>
            </div>
        @endforeach
    </section>
</body>
</html>