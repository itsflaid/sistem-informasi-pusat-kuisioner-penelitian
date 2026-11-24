<x-layouts.public>
    <section class="container py-5 text-center">
        <div class="mx-auto" style="max-width: 760px;">
            <div class="d-flex justify-content-center gap-2 mb-4">
                <x-chip-icon icon="ui-checks-grid" />
                <x-chip-icon icon="people" />
            </div>
            <h1 class="display-4 fw-bold mb-4">Punya kuesioner?<br>Kami bantu carikan responden.</h1>
            <p class="lead text-muted mx-auto mb-4" style="max-width: 650px;">Unggah tautan kuesioner penelitianmu, bagikan ke mahasiswa UIN Sultan Aji Muhammad Idris Samarinda, dan temukan kuesioner mahasiswa lain di satu tempat.</p>
            <div class="d-flex justify-content-center flex-wrap gap-2">
                <a class="btn btn-primary" href="{{ route('register') }}">Mulai sekarang</a>
                <a class="btn btn-outline-primary" href="{{ route('explore') }}">Jelajah kuesioner</a>
            </div>
            <div class="d-inline-flex align-items-center gap-2 mt-4 small text-muted">
                <img src="{{ asset('assets/uinsi.png') }}" alt="Logo UIN Sultan Aji Muhammad Idris Samarinda" width="36" height="36">
                Dikembangkan untuk UIN Sultan Aji Muhammad Idris Samarinda
            </div>
        </div>
    </section>

    <section class="container pb-5" id="cara-kerja">
        <div class="row g-4">
            <div class="col-lg-5"><div class="bg-forest rounded-4 h-100 p-4 p-lg-5 text-white"><span class="chip-icon mb-5"><i class="bi bi-broadcast"></i></span><div class="display-5 fw-bold">{{ $activeQuestionnaireCount }} kuesioner aktif</div><p class="mb-0 opacity-75">Kuesioner penelitian mahasiswa yang sedang mencari responden.</p></div></div>
            <div class="col-lg-7"><div class="row g-4"><div class="col-md-6"><x-stat-card label="Mahasiswa terdaftar" :value="$studentCount" icon="people" /></div><div class="col-md-6"><x-stat-card label="Kategori penelitian" :value="$activeCategoryCount" icon="tags" /></div><div class="col-12"><div class="bg-mist rounded-4 p-4"><h2 class="h4">Dibuat untuk peneliti seperti kamu</h2><p class="text-muted mb-0">Tambahkan tautan kuesioner, ajukan verifikasi, dan temukan kuesioner mahasiswa lain tanpa perlu mengunggah pertanyaan.</p></div></div></div></div>
        </div>
    </section>
</x-layouts.public>
