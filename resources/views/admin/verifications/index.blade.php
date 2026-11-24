<x-app-layout>
    <x-slot name="header"><x-page-header title="Verifikasi kuesioner" description="Tinjau pengajuan sebelum ditayangkan." /></x-slot>

    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    <div class="card shadow-sm">
        <div class="list-group list-group-flush">
            @forelse ($questionnaires as $questionnaire)
                <a class="list-group-item list-group-item-action px-4" href="{{ route('admin.verifications.show', $questionnaire) }}">
                    <strong class="d-block">{{ $questionnaire->title }}</strong>
                    <small class="text-muted">{{ $questionnaire->user->name }} · {{ $questionnaire->category->name }} · batas waktu {{ $questionnaire->deadline_at->translatedFormat('d M Y') }}</small>
                </a>
            @empty
                <x-empty-state title="Antrian kosong" message="Tidak ada kuesioner yang menunggu verifikasi." />
            @endforelse
        </div>
    </div>

    <div class="mt-4">{{ $questionnaires->links() }}</div>
</x-app-layout>
