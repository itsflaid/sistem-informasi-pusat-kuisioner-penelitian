<aside class="app-sidebar bg-white border-end d-flex flex-column flex-shrink-0 p-3">
    <a class="d-flex align-items-center gap-2 mb-4 fw-bold fs-5 text-decoration-none text-forest" href="{{ route(Auth::user()->role === 'admin' ? 'admin.dashboard' : 'dashboard') }}">
        <span class="chip-icon"><i class="bi bi-ui-checks-grid"></i></span>
        {{ config('app.name') }}
    </a>

    <nav class="nav nav-pills flex-column gap-1 mb-auto">
        @unless (Auth::user()->role === 'admin')
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : 'text-body' }}" href="{{ route('dashboard') }}">
                <i class="bi bi-grid me-2"></i>Dashboard
            </a>
            <a class="nav-link {{ request()->routeIs('questionnaires.*') ? 'active' : 'text-body' }}" href="{{ route('questionnaires.index') }}"><i class="bi bi-clipboard2-data me-2"></i>Kuesioner saya</a>
        @endunless
        @if (Auth::user()->role === 'admin')
            <div class="small text-uppercase text-muted mt-3 mb-1">Admin</div>
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-body' }}" href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2 me-2"></i>Dashboard admin</a>
            <a class="nav-link {{ request()->routeIs('admin.verifications.*') ? 'active' : 'text-body' }}" href="{{ route('admin.verifications.index') }}"><i class="bi bi-clipboard-check me-2"></i>Verifikasi</a>
            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : 'text-body' }}" href="{{ route('admin.users.index') }}"><i class="bi bi-people me-2"></i>Manajemen pengguna</a>
            <a class="nav-link {{ request()->routeIs('admin.questionnaires.*') ? 'active' : 'text-body' }}" href="{{ route('admin.questionnaires.index') }}"><i class="bi bi-journal-text me-2"></i>Manajemen kuesioner</a>
        @endif
        <a class="nav-link {{ request()->routeIs('profile.*') ? 'active' : 'text-body' }}" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Profil</a>
    </nav>

    <div class="mb-3">
        <a class="sidebar-public-cta" href="{{ route('explore') }}">
            <span class="sidebar-public-cta__icon"><i class="bi bi-compass"></i></span>
            <span class="sidebar-public-cta__title">Jelajahi kuesioner</span>
        </a>
    </div>

    <div class="border-top pt-3">
        <div class="small fw-semibold text-forest">{{ Auth::user()->name }}</div>
        <div class="small text-muted text-truncate mb-2">{{ Auth::user()->email }}</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-outline-primary btn-sm w-100" type="submit">Keluar</button>
        </form>
    </div>
</aside>
