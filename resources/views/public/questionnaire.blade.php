<x-layouts.public>
    <main class="container py-5">
        <div class="row justify-content-center">
            <article class="col-lg-8">
                <a class="small" href="{{ route('explore') }}">Kembali ke jelajah</a>
                <div class="card mt-3">
                    <div class="card-body p-4 p-md-5">
                        <span class="badge bg-sprout text-leaf-deep mb-3">{{ $questionnaire->category->name }}</span>
                        <h1 class="h2">{{ $questionnaire->title }}</h1>
                        <p class="text-muted">{{ $questionnaire->description }}</p>
                        <dl class="row mb-4">
                            <dt class="col-sm-4">Penyusun</dt>
                            <dd class="col-sm-8">Mahasiswa {{ $questionnaire->user->study_program }}</dd>
                            <dt class="col-sm-4">Estimasi waktu</dt>
                            <dd class="col-sm-8">{{ $questionnaire->estimated_minutes ? $questionnaire->estimated_minutes.' menit' : 'Tidak ditentukan' }}</dd>
                            <dt class="col-sm-4">Target responden</dt>
                            <dd class="col-sm-8">{{ $questionnaire->target_respondents ?? 'Tidak ditentukan' }}</dd>
                            <dt class="col-sm-4">Batas waktu</dt>
                            <dd class="col-sm-8">{{ $questionnaire->deadline_at->translatedFormat('d F Y') }}</dd>
                        </dl>
                        @auth
                            <a class="btn btn-primary" href="{{ route('fill.show', ['questionnaire' => $questionnaire->slug]) }}">Isi kuesioner</a>
                            <p class="small text-muted mt-3 mb-0">Kamu akan diarahkan ke platform kuesioner eksternal.</p>
                        @else
                            <a class="btn btn-primary" href="{{ route('login') }}">Masuk untuk mengisi</a>
                        @endauth
                    </div>
                </div>
            </article>
        </div>
    </main>
</x-layouts.public>
