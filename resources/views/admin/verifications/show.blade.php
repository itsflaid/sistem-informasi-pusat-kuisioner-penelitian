<x-app-layout>
    <x-slot name="header">
        <x-page-header :title="$questionnaire->title" :description="$questionnaire->description">
            <x-slot name="actions"><x-badge-status :status="$questionnaire->status->value" /></x-slot>
        </x-page-header>
    </x-slot>

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <dl class="row mb-4">
                <dt class="col-sm-3">Penyusun</dt>
                <dd class="col-sm-9">{{ $questionnaire->user->name }} — {{ $questionnaire->user->study_program }}</dd>
                <dt class="col-sm-3">Kategori</dt>
                <dd class="col-sm-9">{{ $questionnaire->category->name }}</dd>
                <dt class="col-sm-3">Batas waktu</dt>
                <dd class="col-sm-9">{{ $questionnaire->deadline_at->translatedFormat('d F Y') }}</dd>
                <dt class="col-sm-3">Estimasi waktu</dt>
                <dd class="col-sm-9">{{ $questionnaire->estimated_minutes ? $questionnaire->estimated_minutes.' menit' : 'Tidak ditentukan' }}</dd>
                <dt class="col-sm-3">Target responden</dt>
                <dd class="col-sm-9">{{ $questionnaire->target_respondents ?? 'Tidak ditentukan' }}</dd>
                <dt class="col-sm-3">Tautan kuesioner</dt>
                <dd class="col-sm-9"><a href="{{ $questionnaire->external_url }}" target="_blank" rel="noopener noreferrer">{{ $questionnaire->external_url }}</a></dd>
            </dl>

            <form class="d-inline" method="POST" action="{{ route('admin.verifications.approve', $questionnaire) }}">
                @csrf
                <x-button type="submit">Setujui</x-button>
            </form>

            <form class="mt-3" method="POST" action="{{ route('admin.verifications.reject', $questionnaire) }}">
                @csrf
                <x-field for="rejection_reason" label="Alasan penolakan" :error="$errors->first('rejection_reason')">
                    <textarea class="form-control" id="rejection_reason" name="rejection_reason" required>{{ old('rejection_reason') }}</textarea>
                </x-field>
                <x-button variant="outline-danger" type="submit" class="mt-2">Tolak</x-button>
            </form>
        </div>
    </div>
</x-app-layout>
