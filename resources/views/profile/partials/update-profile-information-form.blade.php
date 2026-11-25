@php
    $studyPrograms ??= \Database\Seeders\DatabaseSeeder::STUDY_PROGRAMS;
@endphp

<form method="post" action="{{ route('profile.update') }}">
    @csrf
    @method('patch')

    <div class="row g-3">
        <div class="col-md-6">
            <x-field for="name" label="Nama lengkap" :error="$errors->first('name')">
                <input id="name" class="form-control" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
            </x-field>
        </div>

        <div class="col-md-6">
            <x-field for="email" label="Email" :error="$errors->first('email')">
                <input id="email" class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
            </x-field>
        </div>

        <div class="col-md-6">
            <x-field for="study_program" label="Prodi" :error="$errors->first('study_program')">
                <select id="study_program" class="form-select" name="study_program" required>
                    @foreach ($studyPrograms as $program)
                        <option value="{{ $program }}" {{ old('study_program', $user->study_program) == $program ? 'selected' : '' }}>
                            {{ $program }}
                        </option>
                    @endforeach
                </select>
            </x-field>
        </div>

        <div class="col-md-6">
            <x-field for="nim" label="NIM" :error="$errors->first('nim')">
                <input id="nim" class="form-control" type="text" name="nim" value="{{ old('nim', $user->nim) }}" required autocomplete="off" pattern="[0-9]*">
            </x-field>
        </div>
    </div>

    <x-button type="submit" class="mt-3">Simpan perubahan</x-button>
</form>
