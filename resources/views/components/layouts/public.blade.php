<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ isset($title) ? $title.' · ' : '' }}{{ config('app.name') }}</title>
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body>
        <header class="border-bottom bg-white">
            <nav class="container py-3 d-flex align-items-center justify-content-between gap-3">
                <a class="fw-bold fs-5 text-decoration-none text-forest" href="{{ route('home') }}">{{ config('app.name') }}</a>
                <div class="d-none d-md-flex align-items-center gap-4">
                    <a class="text-decoration-none text-body" href="{{ route('home') }}">Beranda</a>
                    <a class="text-decoration-none text-body" href="{{ route('explore') }}">Jelajah</a>
                    <a class="text-decoration-none text-body" href="{{ route('home') }}#cara-kerja">Cara kerja</a>
                    <a class="text-decoration-none text-body" href="{{ route('guide') }}">Panduan</a>
                </div>
                <div class="d-flex gap-2">
                    @auth
                        <a class="btn btn-primary" href="{{ route('dashboard') }}">Dashboard</a>
                    @else
                        <a class="btn btn-outline-primary" href="{{ route('login') }}">Masuk</a>
                        <a class="btn btn-primary" href="{{ route('register') }}">Daftar</a>
                    @endauth
                </div>
            </nav>
        </header>

        <main>{{ $slot }}</main>

        <footer class="border-top mt-5">
            <div class="container py-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 small text-muted">
                <div class="d-flex align-items-center gap-2">
                    <img src="{{ asset('assets/uinsi.png') }}" alt="Logo UIN Sultan Aji Muhammad Idris Samarinda" width="32" height="32">
                    <span>{{ config('app.name') }}</span>
                </div>
                <div class="d-flex gap-3">
                    <a class="text-leaf-deep" href="{{ route('explore') }}">Jelajah</a>
                    <a class="text-leaf-deep" href="{{ route('guide') }}">Panduan</a>
                    <a class="text-leaf-deep" href="{{ route('privacy') }}">Privasi</a>
                </div>
                <span>Prototipe proyek Manajemen Proyek Sistem Informasi, Kelompok 6</span>
            </div>
        </footer>
    </body>
</html>
