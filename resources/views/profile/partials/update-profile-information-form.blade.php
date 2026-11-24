@section('styles')
    @php
        $studyPrograms = $studyPrograms ?? DatabaseSeeder::STUDY_PROGRAMS;
    @endphp

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-4">
        @csrf
        @method('patch')

        <div class="row g-3">
            <div class="col-md-6">
                <x-field for="name" label="Nama lengkap" :error="$errors->first('name')" class="mb-3">
                    <input id="name" class="form-control" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                </x-field>
            </div>

            <div class="col-md-6">
                <x-field for="email" label="Email kampus" :error="$errors->first('email')" class="mb-3">
                    <input id="email" class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                </x-field>
            </div>

            <div class="col-md-6">
                <x-field for="study_program" label="Prodi" :error="$errors->first('study_program')" class="mb-3">
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
                <x-field for="nim" label="NIM" :error="$errors->first('nim')" class="mb-3">
                    <input id="nim" class="form-control" type="text" name="nim" value="{{ old('nim', $user->nim) }}" required autocomplete="off" pattern="[0-9]*">
                </x-field>
            </div>
        </div>

        <x-button type="submit">Simpan perubahan</x-button>
    </form>