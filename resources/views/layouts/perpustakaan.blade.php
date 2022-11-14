<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'Perpustaaan' }}</title>
    {{-- Base Stylesheets --}}
    @if(!config('adminlte.enabled_laravel_mix'))
        <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

        {{-- Configured Stylesheets --}}
        @include('adminlte::plugins', ['type' => 'css'])

        <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    @else
        <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_mix_css_path', 'css/app.css')) }}">
    @endif
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    {{-- Custom Stylesheets (post AdminLTE) --}}
    @stack('css')
    @yield('css')
</head>
<body>
    <div class="container-fluid container-perpus">
        <div class="background"></div>
        <div class="overlay"></div>
        <div class="card content-switch">
            <div class="card-header p-0">
                <div class="row w-100 m-0">
                    <a href="{{ route('pengunjung.cari') }}" class="col-md-6 header-switch {{ $title=='Cari Buku'? 'active' : ' ' }}">
                        Cari Buku
                    </a>
                    <a href="#" class="col-md-6 header-switch">
                        Ulasan
                    </a>
                </div>
            </div>
            <div class="card-body">
                {{-- Body Content --}}
                @yield('body')

            </div>

        </div>
    </div>

    {{-- Base Scripts --}}
    @if(!config('adminlte.enabled_laravel_mix'))
        <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

        {{-- Configured Scripts --}}
        @include('adminlte::plugins', ['type' => 'js'])

        <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @else
        <script src="{{ mix(config('adminlte.laravel_mix_js_path', 'js/app.js')) }}"></script>
    @endif
    {{-- Custom Scripts --}}
    @stack('js')
    @yield('js')
</body>
</html>