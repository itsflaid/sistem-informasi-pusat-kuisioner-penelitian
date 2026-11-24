<x-guest-layout>
    <div class="mb-4">
        <h1 class="h2 mb-2">Masuk</h1>
        <p class="text-muted mb-0">Lanjutkan ke akunmu.</p>
    </div>
    @if (session('status'))
        <x-toast :message="session('status')" />
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <x-field for="email" label="Email" :error="$errors->first('email')" class="mb-3">
            <input id="email" class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
        </x-field>
        <x-field for="password" label="Kata sandi" :error="$errors->first('password')" class="mb-3">
            <input id="password" class="form-control" type="password" name="password" required autocomplete="current-password">
        </x-field>
        <div class="d-flex justify-content-between align-items-center gap-3 mb-4">
            <div class="form-check">
                <input id="remember_me" class="form-check-input" type="checkbox" name="remember">
                <label class="form-check-label" for="remember_me">Ingat saya</label>
            </div>
            @if (Route::has('password.request'))
                <a class="text-leaf-deep small" href="{{ route('password.request') }}">Lupa kata sandi?</a>
            @endif
        </div>
        <x-button type="submit" class="w-100">Masuk</x-button>
    </form>
    <p class="text-center text-muted small mt-4 mb-0">Belum punya akun? <a class="text-leaf-deep" href="{{ route('register') }}">Daftar</a></p>
</x-guest-layout>
