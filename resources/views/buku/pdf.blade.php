
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
        <div class="subtitle-header">Data Buku</div>
        <hr class="line-header">
    </section>
    <section class="content">
        @foreach ($datas as $data)
            <div class="book-card">
                <div class="book-data id-buku">#{{ $data->IDBuku }}</div>
                {{-- <div class="book-data">Judul : {{ $data->NamaBuku }}</div>
                <div class="book-data">Deskripsi : {{ $data->Deskripsi }}</div>
                <div class="book-data">Genre : {{ $data->GenreBuku }}</div>
                <div class="book-data">Bahasa : {{ $data->Bahasa }}</div>
                
                <div class="book-data">Jumlah Halaman : {{ $data->JumlahHalaman }}</div>
                
                <div class="book-data">Status : {{ $data->StatusBuku }}</div>
                
                <div class="book-data">Penerbit : {{ $data->Penerbit }}</div>
                
                <div class="book-data">Penulis : {{ $data->Penulis }}</div>
                
                <div class="book-data">Letak Rak : {{ $data->LetakRak }}</div>
                
                <div class="book-data">Tanggal Masuk : {{ $data->TglMasukBuku }}</div> --}}
                <table class="table-data">
                    <tr>
                        <td class="data-title">Judul</td>
                        <td class="data-content">{{ $data->NamaBuku }}</td>
                    </tr>
                    <tr>
                        <td class="data-title">Deskripsi</td>
                        <td class="data-content">{{ $data->Deskripsi }}</td>
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
                        <td class="data-title">Status</td>
                        <td class="data-content">{{ $data->StatusBuku }}</td>
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
                        <td class="data-title">LetakRak </td>
                        <td class="data-content">{{ $data->LetakRak }}</td>
                    </tr>
                    <tr>
                        <td class="data-title">Tanggal Masuk</td>
                        <td class="data-content">{{ $data->TglMasukBuku }}</td>
                    </tr>
                </table>
            </div>
        @endforeach
    </section>
</body>
</html>