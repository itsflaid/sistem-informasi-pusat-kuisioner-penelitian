<x-layouts.app>
    <x-slot name="header"><x-page-header title="Kuesioner saya" description="Kelola draf, pengajuan, dan kuesioner yang telah tayang."><x-slot name="actions"><a class="btn btn-primary" href="{{ route('questionnaires.create') }}">Buat kuesioner</a></x-slot></x-page-header></x-slot>
    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if ($questionnaires->isEmpty())
        <x-empty-state title="Belum ada kuesioner" message="Buat kuesioner pertama Anda untuk memulai penelitian."><a class="btn btn-primary" href="{{ route('questionnaires.create') }}">Buat kuesioner</a></x-empty-state>
    @else
        <div class="row g-4">@foreach ($questionnaires as $questionnaire)<div class="col-md-6 col-xl-4"><article class="card h-100 shadow-sm"><div class="card-body d-flex flex-column"><div class="d-flex justify-content-between gap-2 mb-3"><span class="badge bg-mist text-leaf-deep">{{ $questionnaire->category->name }}</span><x-badge-status :status="$questionnaire->status->value" /></div><h2 class="h5">{{ $questionnaire->title }}</h2><p class="small text-muted mb-3">{{ $questionnaire->questions_count }} pertanyaan · Batas waktu {{ $questionnaire->deadline_at->translatedFormat('d M Y') }}</p><a class="btn btn-outline-primary mt-auto" href="{{ route('questionnaires.show', $questionnaire) }}">Lihat detail</a></div></article></div>@endforeach</div>
        <div class="mt-4">{{ $questionnaires->links() }}</div>
    @endif
</x-layouts.app>
