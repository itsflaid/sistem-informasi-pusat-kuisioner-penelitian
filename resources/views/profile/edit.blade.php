<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Profil" description="Kelola data akun dan keanggotaanmu di {{ config('app.name') }}." />
    </x-slot>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h3 class="h6 mb-4">Informasi Profil</h3>
                    @include('profile.partials.update-profile-information-form', [
                        'user' => $user,
                        'studyPrograms' => $studyPrograms,
                    ])
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-4">
                        <div class="rounded-circle bg-mist d-flex align-items-center justify-content-center" style="width: 64px; height: 64px;">
                            <i class="bi bi-person-fill text-leaf-deep fs-3"></i>
                        </div>
                        <div class="ms-3">
                            <div class="fw-semibold text-forest">{{ $user->name }}</div>
                            <div class="small text-muted">{{ $user->email }}</div>
                        </div>
                    </div>
                    <dl class="row small mb-0">
                        <dt class="col-sm-4 text-muted">Peran</dt>
                        <dd class="col-sm-8">{{ ucfirst($user->role) }}</dd>
                        <dt class="col-sm-4 text-muted">Prodi</dt>
                        <dd class="col-sm-8">{{ $user->study_program }}</dd>
                        <dt class="col-sm-4 text-muted">NIM</dt>
                        <dd class="col-sm-8">{{ $user->nim }}</dd>
                        <dt class="col-sm-4 text-muted">Status</dt>
                        <dd class="col-sm-8">
                            <x-badge-status status="{{ $user->is_active ? 'active' : 'closed' }}" />
                        </dd>
                        <dt class="col-sm-4 text-muted">Email</dt>
                        <dd class="col-sm-8">{{ $user->email_verified_at ? 'Terverifikasi' : 'Belum terverifikasi' }}</dd>
                    </dl>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="h6 mb-3">Ubah kata sandi</h3>
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        <div class="col-lg-8 mt-4">
            <div class="card border-0 shadow-sm bg-cream">
                <div class="card-body p-4">
                    <h3 class="h6 mb-3">Hapus akun</h3>
                    <p class="text-muted small mb-3">Menghapus akun akan menghapus semua data kuesioner milikmu secara permanen.</p>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
