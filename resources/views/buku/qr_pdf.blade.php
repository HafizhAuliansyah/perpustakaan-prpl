<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <section class="content qr">
        @php
            $path = public_path('images/buku/qr_code/').$data->QRCode;
        @endphp
        <img src="{{ $path }}" class="qr-buku">
        <p class="id-text">
            {{ $data->IDBuku }}
        </p>
    </section>
</body>
</html>