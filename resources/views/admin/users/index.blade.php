<x-app-layout>
    <x-slot name="header">
        <x-page-header title="Manajemen pengguna" description="Kelola peran dan status akun mahasiswa serta admin." />
    </x-slot>

    @if (session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if (session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif

    <div class="card shadow-sm">
        <div class="card-body p-4">
            <form class="row g-2 align-items-end mb-4" method="GET" action="{{ route('admin.users.index') }}">
                <div class="col-md-5">
                    <x-field for="q" label="Cari pengguna">
                        <input class="form-control" id="q" name="q" type="search" value="{{ $search }}" placeholder="Nama, email, atau NIM">
                    </x-field>
                </div>
                <div class="col-md-3">
                    <x-field for="role" label="Peran">
                        <select class="form-select" id="role" name="role">
                            <option value="">Semua peran</option>
                            <option value="student" @selected($roleFilter === 'student')>Mahasiswa</option>
                            <option value="admin" @selected($roleFilter === 'admin')>Admin</option>
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
                            <th scope="col">Pengguna</th>
                            <th scope="col">Program studi</th>
                            <th scope="col">Peran &amp; status</th>
                            <th scope="col" class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>
                                    <strong class="d-block">{{ $user->name }}</strong>
                                    <small class="text-muted">{{ $user->email }}</small>
                                    @if ($user->nim)<small class="d-block text-muted">NIM {{ $user->nim }}</small>@endif
                                </td>
                                <td>{{ $user->study_program ?? '—' }}</td>
                                <td>
                                    <span class="badge bg-mist text-leaf-deep">{{ $user->role === 'admin' ? 'Admin' : 'Mahasiswa' }}</span>
                                    <span class="badge {{ $user->is_active ? 'bg-success' : 'bg-secondary' }}">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                </td>
                                <td class="text-end">
                                    <form class="d-flex flex-wrap justify-content-end gap-2" method="POST" action="{{ route('admin.users.update', $user) }}">
                                        @csrf
                                        @method('PATCH')
                                        <select class="form-select form-select-sm w-auto" name="role" aria-label="Peran {{ $user->name }}">
                                            <option value="student" @selected($user->role === 'student')>Mahasiswa</option>
                                            <option value="admin" @selected($user->role === 'admin')>Admin</option>
                                        </select>
                                        <select class="form-select form-select-sm w-auto" name="is_active" aria-label="Status {{ $user->name }}">
                                            <option value="1" @selected($user->is_active)>Aktif</option>
                                            <option value="0" @selected(! $user->is_active)>Nonaktif</option>
                                        </select>
                                        <x-button variant="outline-primary" type="submit" class="btn-sm">Simpan</x-button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4"><x-empty-state title="Pengguna tidak ditemukan" message="Coba ubah kata kunci atau filter peran." /></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
</x-app-layout>
