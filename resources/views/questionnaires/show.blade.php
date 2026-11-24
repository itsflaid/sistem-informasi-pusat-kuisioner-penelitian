<x-app-layout>
    <x-slot name="header">
        <x-page-header :title="$questionnaire->title" :description="$questionnaire->description">
            <x-slot name="actions"><x-badge-status :status="$questionnaire->effective_status->value" /></x-slot>
        </x-page-header>
    </x-slot>

    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if (session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
    @if ($questionnaire->rejection_reason && in_array($questionnaire->status->value, ['draft', 'rejected'], true))
        <div class="alert alert-warning"><strong>Catatan verifikasi:</strong> {{ $questionnaire->rejection_reason }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <dl class="row mb-4">
                <dt class="col-sm-3">Kategori</dt>
                <dd class="col-sm-9">{{ $questionnaire->category->name }}</dd>
                <dt class="col-sm-3">Estimasi waktu</dt>
                <dd class="col-sm-9">{{ $questionnaire->estimated_minutes ? $questionnaire->estimated_minutes.' menit' : 'Tidak ditentukan' }}</dd>
                <dt class="col-sm-3">Target responden</dt>
                <dd class="col-sm-9">{{ $questionnaire->target_respondents ?? 'Tidak ditentukan' }}</dd>
                <dt class="col-sm-3">Batas waktu</dt>
                <dd class="col-sm-9">{{ $questionnaire->deadline_at->translatedFormat('d F Y') }}</dd>
                <dt class="col-sm-3">Tautan kuesioner</dt>
                <dd class="col-sm-9"><a href="{{ $questionnaire->external_url }}" target="_blank" rel="noopener noreferrer">Buka tautan eksternal</a></dd>
            </dl>

            @if (in_array($questionnaire->status->value, ['draft', 'rejected'], true))
                <a class="btn btn-outline-primary me-2" href="{{ route('questionnaires.edit', $questionnaire) }}">Edit kuesioner</a>
                <form class="d-inline" method="POST" action="{{ route('questionnaires.submit', $questionnaire) }}">
                    @csrf
                    <x-button type="submit">Ajukan verifikasi</x-button>
                </form>
            @endif
            @if ($questionnaire->status->value === 'pending')
                <p class="alert alert-info mb-0">Menunggu verifikasi admin.</p>
            @endif
            @if ($questionnaire->status->value === 'active')
                <form method="POST" action="{{ route('questionnaires.close', $questionnaire) }}">
                    @csrf
                    <x-button variant="outline-danger" type="submit">Tutup kuesioner</x-button>
                </form>
            @endif
        </div>
    </div>
</x-app-layout>
