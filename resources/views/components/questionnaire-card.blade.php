@props(['title', 'category' => 'Kategori', 'deadline' => 'Belum ditentukan', 'action' => 'Lihat', 'href' => null])

<article {{ $attributes->merge(['class' => 'questionnaire-card card']) }}>
    <div class="card-body d-flex flex-column p-4">
        <span class="badge bg-sprout text-leaf-deep align-self-start mb-3">{{ $category }}</span>
        <h2 class="h5 mb-3">{{ $title }}</h2>
        <div class="d-flex justify-content-between align-items-center gap-2 small text-muted mt-auto">
            <span><i class="bi bi-clock me-1"></i>{{ $deadline }}</span>
            @if ($href)
                <a class="btn btn-outline-primary btn-sm" href="{{ $href }}">{{ $action }}</a>
            @endif
        </div>
    </div>
</article>
