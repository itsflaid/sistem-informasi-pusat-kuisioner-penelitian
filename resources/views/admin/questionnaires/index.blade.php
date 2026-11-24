<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Manajemen kuesioner" description="Pantau seluruh kuesioner yang terdaftar di platform." />
    </x-slot>

    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form class="row g-2 align-items-end mb-4" method="GET" action="{{ route('admin.questionnaires.index') }}">
                <div class="col-md-5">
                    <x-field for="q" label="Cari kuesioner">
                        <input class="form-control" id="q" name="q" type="search" value="{{ $search }}" placeholder="Judul, nama penyusun, atau email">
                    </x-field>
                </div>
                <div class="col-md-3">
                    <x-field for="status" label="Status">
                        <select class="form-select" id="status" name="status">
                            <option value="">Semua status</option>
                            @foreach (['draft' => 'Draf', 'pending' => 'Menunggu verifikasi', 'active' => 'Aktif', 'rejected' => 'Ditolak', 'closed' => 'Ditutup'] as $value => $label)
                                <option value="{{ $value }}" @selected($statusFilter === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </x-field>
                </div>
                <div class="col-md-auto">
                    <x-button type="submit">Terapkan</x-button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Kuesioner</th>
                            <th scope="col">Penyusun</th>
                            <th scope="col">Status</th>
                            <th scope="col">Batas waktu</th>
                            <th scope="col" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($questionnaires as $questionnaire)
                            <tr>
                                <td>
                                    <strong class="d-block">{{ $questionnaire->title }}</strong>
                                    <small class="text-muted">{{ $questionnaire->category->name }}</small>
                                </td>
                                <td>
                                    <span class="d-block">{{ $questionnaire->user->name }}</span>
                                    <small class="text-muted">{{ $questionnaire->user->study_program ?? $questionnaire->user->email }}</small>
                                </td>
                                <td><x-badge-status :status="$questionnaire->status->value" /></td>
                                <td>{{ $questionnaire->deadline_at->translatedFormat('d M Y') }}</td>
                                <td class="text-end">
                                    <a class="btn btn-outline-primary btn-sm" href="{{ route('admin.questionnaires.show', $questionnaire) }}">Lihat detail</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5"><x-empty-state title="Kuesioner tidak ditemukan" message="Coba ubah kata kunci atau filter status." /></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">{{ $questionnaires->links() }}</div>
</x-app-layout>
