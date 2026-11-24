<x-guest-layout>
    <div class="mb-4">
        <h1 class="h2 mb-2">Buat akun</h1>
        <p class="text-muted mb-0">Mulai buat dan isi kuesioner penelitian.</p>
    </div>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <x-field for="name" label="Nama lengkap" :error="$errors->first('name')" class="mb-3">
            <input id="name" class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
        </x-field>
        <x-field for="email" label="Email aktif" :error="$errors->first('email')" class="mb-3">
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autocomplete="username">
        </x-field>
        <x-field for="password" label="Kata sandi" :error="$errors->first('password')" class="mb-3">
            <input id="password" class="form-control" type="password" name="password" required autocomplete="new-password">
        </x-field>
        <x-field for="password_confirmation" label="Konfirmasi kata sandi" class="mb-4">
            <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password">
        </x-field>
        <x-button type="submit" class="w-100">Daftar</x-button>
    </form>
    <p class="text-center text-muted small mt-4 mb-0">Sudah punya akun? <a class="text-leaf-deep" href="{{ route('login') }}">Masuk</a></p>
</x-guest-layout>
