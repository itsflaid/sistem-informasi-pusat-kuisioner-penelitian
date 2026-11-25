<form method="post" action="{{ route('profile.destroy') }}">
    @csrf
    @method('delete')

    <p class="text-muted small mb-3">Setelah akun dihapus, seluruh data kuesioner dan keanggotaanmu akan hilang secara permanen.</p>

    <x-field for="delete_password" label="Kata sandi" :error="$errors->userDeletion->first('password')">
        <input id="delete_password" name="password" type="password" class="form-control" placeholder="Masukkan kata sandi" autocomplete="current-password">
    </x-field>

    <x-button type="submit" variant="outline-danger" class="mt-3">Hapus akun</x-button>
</form>
