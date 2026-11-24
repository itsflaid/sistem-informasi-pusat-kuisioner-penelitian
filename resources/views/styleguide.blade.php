<x-layouts.public title="Styleguide">
    <div class="container py-5">
        <x-page-header title="Styleguide" description="Token dan komponen dasar Pusat Kuesioner." />

        <section class="mb-5">
            <h2 class="h3 mb-3">Warna</h2>
            <div class="row g-3">
                @foreach (['paper' => 'Putih', 'mist' => 'Mist', 'forest' => 'Forest', 'leaf' => 'Leaf', 'leaf-deep' => 'Leaf deep', 'sprout' => 'Sprout', 'cream' => 'Cream', 'ice' => 'Ice'] as $color => $label)
                    <div class="col-6 col-md-3"><div class="border rounded-4 p-3 {{ in_array($color, ['mist', 'forest', 'sprout', 'cream', 'ice']) ? 'bg-'.$color : '' }} {{ $color === 'forest' ? 'text-white' : '' }}"><div class="fw-semibold">{{ $label }}</div><small>{{ $color }}</small></div></div>
                @endforeach
            </div>
        </section>

        <section class="mb-5">
            <h2 class="h3 mb-3">Tipografi dan tombol</h2>
            <h1>Judul tampilan</h1><h2>Judul bagian</h2><p class="text-muted">Teks isi untuk menjelaskan informasi kepada pengguna dengan jelas.</p>
            <div class="d-flex flex-wrap gap-2"><x-button>Aksi utama</x-button><x-button variant="outline-primary">Aksi kedua</x-button><x-chip-icon icon="clipboard2-check" /></div>
        </section>

        <section class="mb-5"><h2 class="h3 mb-3">Input dan status</h2><div class="row g-3"><div class="col-md-6"><x-field label="Judul kuesioner" for="title"><input id="title" class="form-control" placeholder="Masukkan judul"></x-field></div><div class="col-md-6 d-flex gap-2 align-items-end"><x-badge-status status="draft" /><x-badge-status status="pending" /><x-badge-status status="active" /></div></div></section>

        <section class="mb-5"><h2 class="h3 mb-3">Kartu dan keadaan kosong</h2><div class="row g-4"><div class="col-md-6"><x-questionnaire-card title="Pengaruh penggunaan teknologi dalam pembelajaran" category="Pendidikan" :responses="12" :target="30" deadline="12 hari lagi" /></div><div class="col-md-6"><x-empty-state title="Belum ada kuesioner." message="Buat yang pertama." /></div></div></section>
        <x-toast message="Kuesioner berhasil disimpan." />
    </div>
</x-layouts.public>
