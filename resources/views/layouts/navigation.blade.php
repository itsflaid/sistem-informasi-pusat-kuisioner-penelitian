<aside class="bg-white border-end d-flex flex-column flex-shrink-0 p-3" style="width: 17rem;">
    <a class="d-flex align-items-center gap-2 mb-4 fw-bold fs-5 text-decoration-none text-forest" href="{{ route('dashboard') }}">
        <span class="chip-icon"><i class="bi bi-ui-checks-grid"></i></span>
        {{ config('app.name') }}
    </a>

    <nav class="nav nav-pills flex-column gap-1 mb-auto">
        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : 'text-body' }}" href="{{ route('dashboard') }}">
            <i class="bi bi-grid me-2"></i>Dasbor
        </a>
        <a class="nav-link text-body" href="#"><i class="bi bi-clipboard2-data me-2"></i>Kuesioner saya</a>
        <a class="nav-link text-body" href="#"><i class="bi bi-compass me-2"></i>Jelajah</a>
        <a class="nav-link text-body" href="#"><i class="bi bi-clock-history me-2"></i>Riwayat</a>
        <a class="nav-link text-body" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Profil</a>
    </nav>

    <div class="border-top pt-3">
        <div class="small fw-semibold text-forest">{{ Auth::user()->name }}</div>
        <div class="small text-muted text-truncate mb-2">{{ Auth::user()->email }}</div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="btn btn-outline-primary btn-sm w-100" type="submit">Keluar</button>
        </form>
    </div>
</aside>
