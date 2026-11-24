<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }}</title>
        @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    </head>
    <body class="bg-mist">
        <main class="container py-5">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-5">
                    <a class="d-flex align-items-center justify-content-center gap-2 mb-4 fw-bold fs-4 text-decoration-none text-forest" href="{{ route('home') }}">
                        <span class="chip-icon"><i class="bi bi-ui-checks-grid"></i></span>
                        {{ config('app.name') }}
                    </a>
                    <div class="card border-0 rounded-4">
                        <div class="card-body p-4 p-md-5">{{ $slot }}</div>
                    </div>
                </div>
            </div>
        </main>
    </body>
</html>
