<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Profil" description="Kelola data akun dan keanggotaanmu di {{ config('app.name') }}." />
    </x-slot>

    @if (session('status') === 'profile-updated')
        <div class="alert alert-success" role="alert">Profil berhasil diperbarui.</div>
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <h2 class="h5 mb-3">Informasi profil</h2>
                    @include('profile.partials.update-profile-information-form', [
                        'user' => $user,
                        'studyPrograms' => $studyPrograms,
                    ])
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <h2 class="h5 mb-3">Ringkasan akun</h2>
                    <div class="d-flex align-items-center mb-3">
                        <div class="chip-icon">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <div class="ms-3">
                            <div class="fw-semibold text-forest">{{ $user->name }}</div>
                            <div class="small text-muted text-truncate">{{ $user->email }}</div>
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

        <div class="col-lg-8">
            <div class="card shadow-sm h-100">
                <div class="card-body p-4">
                    <h2 class="h5 mb-3">Ubah kata sandi</h2>
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm bg-cream h-100">
                <div class="card-body p-4">
                    <h2 class="h5 mb-3">Hapus akun</h2>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
