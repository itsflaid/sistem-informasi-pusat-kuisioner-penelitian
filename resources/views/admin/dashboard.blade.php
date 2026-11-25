<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Dashboard admin" description="Ringkasan pengelolaan platform.">
            <x-slot name="actions">
                <a class="btn btn-primary" href="{{ route('admin.verifications.index') }}">Buka antrian verifikasi</a>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div class="row g-4">
        <div class="col-md-6 col-xl-3"><x-stat-card label="Menunggu verifikasi" :value="$pendingCount" icon="hourglass-split" /></div>
        <div class="col-md-6 col-xl-3"><x-stat-card label="Total kuesioner" :value="$questionnaireCount" icon="clipboard2-data" /></div>
        <div class="col-md-6 col-xl-3"><x-stat-card label="Kuesioner aktif" :value="$activeCount" icon="broadcast" /></div>
        <div class="col-md-6 col-xl-3"><x-stat-card label="Pengguna" :value="$userCount" icon="people" /></div>

        <div class="col-lg-8">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                        <h2 class="h5 mb-0">Menunggu verifikasi</h2>
                        <a class="small" href="{{ route('admin.verifications.index') }}">Lihat semua</a>
                    </div>

                    @if ($pendingQuestionnaires->isEmpty())
                        <x-empty-state title="Antrian kosong" message="Tidak ada kuesioner yang menunggu verifikasi." />
                    @else
                        <div class="list-group list-group-flush">
                            @foreach ($pendingQuestionnaires as $questionnaire)
                                <a class="list-group-item list-group-item-action d-flex flex-wrap justify-content-between align-items-center gap-2 px-0" href="{{ route('admin.verifications.show', $questionnaire) }}">
                                    <span>
                                        <strong class="d-block">{{ $questionnaire->title }}</strong>
                                        <small class="text-muted">{{ $questionnaire->user->name }} · {{ $questionnaire->category->name }} · batas waktu {{ $questionnaire->deadline_at->translatedFormat('d M Y') }}</small>
                                    </span>
                                    <x-badge-status :status="$questionnaire->status->value" />
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <h2 class="h5 mb-3">Aksi cepat</h2>
                    <div class="d-grid gap-2">
                        <a class="btn btn-outline-primary" href="{{ route('admin.verifications.index') }}"><i class="bi bi-clipboard-check me-2"></i>Tinjau verifikasi</a>
                        <a class="btn btn-outline-primary" href="{{ route('admin.users.index') }}"><i class="bi bi-people me-2"></i>Kelola pengguna</a>
                        <a class="btn btn-outline-primary" href="{{ route('admin.questionnaires.index') }}"><i class="bi bi-journal-text me-2"></i>Kelola kuesioner</a>
                    </div>
                    <p class="small text-muted mb-0 mt-3">{{ $categoryCount }} kategori aktif dikelola.</p>
                </div>
            </div>
        </div>

        <div class="col-lg-7">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                        <h2 class="h5 mb-0">Kuesioner terbaru</h2>
                        <a class="small" href="{{ route('admin.questionnaires.index') }}">Lihat semua</a>
                    </div>

                    @if ($latestQuestionnaires->isEmpty())
                        <x-empty-state title="Belum ada kuesioner" message="Kuesioner yang ditambahkan mahasiswa akan muncul di sini." />
                    @else
                        <div class="list-group list-group-flush">
                            @foreach ($latestQuestionnaires as $questionnaire)
                                <a class="list-group-item list-group-item-action d-flex flex-wrap justify-content-between align-items-center gap-2 px-0" href="{{ route('admin.questionnaires.show', $questionnaire) }}">
                                    <span>
                                        <strong class="d-block">{{ $questionnaire->title }}</strong>
                                        <small class="text-muted">{{ $questionnaire->user->name }} · {{ $questionnaire->category->name }}</small>
                                    </span>
                                    <x-badge-status :status="$questionnaire->effective_status->value" />
                                </a>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                        <h2 class="h5 mb-0">Pengguna terbaru</h2>
                        <a class="small" href="{{ route('admin.users.index') }}">Lihat semua</a>
                    </div>

                    <div class="list-group list-group-flush">
                        @foreach ($latestUsers as $user)
                            <div class="list-group-item px-0">
                                <strong class="d-block">{{ $user->name }}</strong>
                                <small class="text-muted">{{ $user->email }} · {{ $user->role === 'admin' ? 'Admin' : 'Mahasiswa' }}</small>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
