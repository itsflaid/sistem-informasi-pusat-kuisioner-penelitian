<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Akses Ditolak</title>
</head>
<body class="bg-light text-dark">
    <main class="container d-flex align-items-center min-vh-100 py-5">
        <section class="row justify-content-center w-100">
            <div class="col-12 col-md-10 col-lg-7 col-xl-6">
                <div class="card border-0 shadow-sm bg-white text-center">
                    <div class="card-body p-4 p-md-5">
                        <p class="display-1 fw-bold text-success mb-2">403</p>
                        <h1 class="h2 fw-bold mb-3">Akses ditolak</h1>
                        <p class="text-secondary mb-4">Anda tidak memiliki izin untuk membuka halaman ini. Silakan kembali ke beranda atau hubungi administrator jika Anda merasa seharusnya memiliki akses.</p>
                        <a class="btn btn-primary" href="{{ route('home') }}">Kembali ke beranda</a>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
