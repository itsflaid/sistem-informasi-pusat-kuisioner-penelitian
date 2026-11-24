<x-app-layout>
    <x-slot name="header"><x-page-header title="Dasbor admin" description="Ringkasan pengelolaan platform." /></x-slot>

    <div class="row g-3">
        <div class="col-md-3"><x-stat-card label="Menunggu verifikasi" :value="$pendingCount" icon="hourglass-split" /></div>
        <div class="col-md-3"><x-stat-card label="Total kuesioner" :value="$questionnaireCount" icon="clipboard2-data" /></div>
        <div class="col-md-3"><x-stat-card label="Kuesioner aktif" :value="$activeCount" icon="broadcast" /></div>
        <div class="col-md-3"><x-stat-card label="Pengguna" :value="$userCount" icon="people" /></div>
    </div>

    <div class="d-flex flex-wrap gap-2 mt-4">
        <a class="btn btn-primary" href="{{ route('admin.verifications.index') }}">Buka antrian verifikasi</a>
        <span class="align-self-center small text-muted">{{ $categoryCount }} kategori aktif dikelola.</span>
    </div>
</x-app-layout>
