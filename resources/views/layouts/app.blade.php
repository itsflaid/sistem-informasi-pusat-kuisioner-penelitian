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
        <div class="d-lg-flex min-vh-100">
            @include('layouts.navigation')
            <main class="flex-grow-1">
                @isset($header)
                    <header class="bg-white border-bottom">
                        <div class="container-fluid py-4 px-4 px-lg-5">{{ $header }}</div>
                    </header>
                @endisset
                <div class="container-fluid py-4 px-4 px-lg-5">{{ $slot }}</div>
            </main>
        </div>
    </body>
</html>
