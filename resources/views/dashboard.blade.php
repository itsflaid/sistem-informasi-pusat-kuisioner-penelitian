<x-app-layout>
    <x-slot name="header"><x-page-header title="Dasbor" description="Ringkasan aktivitas kuesionermu." /></x-slot>

    <div class="row g-4">
        <div class="col-md-4"><x-stat-card label="Kuesioner saya" value="0" icon="clipboard2-data" /></div>
        <div class="col-md-4"><x-stat-card label="Respons masuk" value="0" icon="people" /></div>
        <div class="col-md-4"><x-stat-card label="Kuesioner diisi" value="0" icon="check2-circle" /></div>
        <div class="col-12"><x-empty-state title="Belum ada kuesioner." message="Buat yang pertama untuk mulai mengumpulkan respons."><x-button>Buat kuesioner</x-button></x-empty-state></div>
    </div>
</x-app-layout>
