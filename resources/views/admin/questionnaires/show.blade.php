<x-app-layout>
    <x-slot name="header">
        <x-page-header :title="$questionnaire->title" :description="$questionnaire->description">
            <x-slot name="actions"><x-badge-status :status="$questionnaire->status->value" /></x-slot>
        </x-page-header>
    </x-slot>

    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    @if ($questionnaire->rejection_reason)
        <div class="alert alert-warning"><strong>Catatan verifikasi:</strong> {{ $questionnaire->rejection_reason }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <dl class="row mb-4">
                <dt class="col-sm-3">Penyusun</dt>
                <dd class="col-sm-9">{{ $questionnaire->user->name }} — {{ $questionnaire->user->study_program ?? 'Program studi belum diisi' }} ({{ $questionnaire->user->email }})</dd>
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
                @if ($questionnaire->reviewer)
                    <dt class="col-sm-3">Diverifikasi oleh</dt>
                    <dd class="col-sm-9">{{ $questionnaire->reviewer->name }}{{ $questionnaire->reviewed_at ? ' · '.$questionnaire->reviewed_at->translatedFormat('d M Y H:i') : '' }}</dd>
                @endif
                @if ($questionnaire->closed_at)
                    <dt class="col-sm-3">Ditutup pada</dt>
                    <dd class="col-sm-9">{{ $questionnaire->closed_at->translatedFormat('d M Y H:i') }}{{ $questionnaire->closed_reason ? ' · '.$questionnaire->closed_reason : '' }}</dd>
                @endif
            </dl>

            <div class="d-flex flex-wrap gap-2">
                <a class="btn btn-outline-primary" href="{{ route('public.questionnaires.show', $questionnaire) }}">Lihat halaman publik</a>
                @if ($questionnaire->status->value === 'active')
                    <form method="POST" action="{{ route('admin.questionnaires.close', $questionnaire) }}">
                        @csrf
                        <x-button variant="outline-danger" type="submit">Tutup kuesioner</x-button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <div class="mt-3"><a class="text-decoration-none" href="{{ route('admin.questionnaires.index') }}">&larr; Kembali ke daftar kuesioner</a></div>
</x-app-layout>
