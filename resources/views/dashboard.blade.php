<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Dasbor" description="Ringkasan tautan kuesioner dan aktivitasmu.">
            <x-slot name="actions"><a class="btn btn-primary" href="{{ route('questionnaires.create') }}">Tambah tautan</a></x-slot>
        </x-page-header>
    </x-slot>

    <div class="row g-4">
        <div class="col-md-4"><x-stat-card label="Kuesioner saya" :value="$questionnaireCount" icon="clipboard2-data" /></div>
        <div class="col-md-4"><x-stat-card label="Sedang aktif" :value="$activeQuestionnaireCount" icon="broadcast" /></div>
        <div class="col-md-4"><x-stat-card label="Menunggu verifikasi" :value="$pendingQuestionnaireCount" icon="hourglass-split" /></div>

        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                        <h2 class="h5 mb-0">Kuesioner terbaru</h2>
                        <a class="small" href="{{ route('questionnaires.index') }}">Lihat semua</a>
                    </div>

                    @if ($recentQuestionnaires->isEmpty())
                        <x-empty-state title="Belum ada kuesioner." message="Tambahkan tautan kuesioner pertamamu untuk mulai mencari responden.">
                            <a class="btn btn-primary" href="{{ route('questionnaires.create') }}">Tambah tautan</a>
                        </x-empty-state>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach ($recentQuestionnaires as $questionnaire)
                                <a class="list-group-item list-group-item-action d-flex flex-wrap justify-content-between align-items-center gap-2 px-0" href="{{ route('questionnaires.show', $questionnaire) }}">
                                    <span>
                                        <strong class="d-block">{{ $questionnaire->title }}</strong>
                                        <small class="text-muted">{{ $questionnaire->category->name }} · batas waktu {{ $questionnaire->deadline_at->translatedFormat('d M Y') }}</small>
                                    </span>
                                    <x-badge-status :status="$questionnaire->effective_status->value" />
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <section class="mt-4">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <h2 class="h4 mb-0">Sedang mencari responden</h2>
            <a class="small" href="{{ route('explore') }}">Jelajah semua</a>
        </div>

        @if ($recommendedQuestionnaires->isEmpty())
            <x-empty-state title="Belum ada kuesioner aktif" message="Kuesioner yang sudah disetujui admin akan muncul di sini." />
        @else
            <div class="row g-4">
                @foreach ($recommendedQuestionnaires as $questionnaire)
                    <div class="col-md-6 col-lg-4">
                        <x-questionnaire-card
                            :title="$questionnaire->title"
                            :category="$questionnaire->category->name"
                            :deadline="$questionnaire->deadline_at->translatedFormat('d M Y')"
                            :href="route('public.questionnaires.show', $questionnaire)"
                        />
                    </div>
                @endforeach
            </div>
        @endif
    </section>
</x-app-layout>
