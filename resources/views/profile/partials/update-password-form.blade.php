<form method="post" action="{{ route('password.update') }}">
    @csrf
    @method('put')

    <div class="row g-3">
        <div class="col-12">
            <x-field for="update_password_current_password" label="Kata sandi saat ini" :error="$errors->updatePassword->first('current_password')">
                <input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password">
            </x-field>
        </div>

        <div class="col-md-6">
            <x-field for="update_password_password" label="Kata sandi baru" :error="$errors->updatePassword->first('password')">
                <input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password">
            </x-field>
        </div>

        <div class="col-md-6">
            <x-field for="update_password_password_confirmation" label="Konfirmasi kata sandi" :error="$errors->updatePassword->first('password_confirmation')">
                <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password">
            </x-field>
        </div>
    </div>

    <div class="d-flex flex-wrap align-items-center gap-3 mt-3">
        <x-button type="submit">Simpan kata sandi</x-button>
        @if (session('status') === 'password-updated')
            <span class="small text-success">Kata sandi berhasil diperbarui.</span>
        @endif
    </div>
</form>
