<x-layouts.public>
    <main>
        <section class="bg-mist py-5">
            <div class="container py-lg-4">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-8">
                        <span class="badge bg-white text-leaf-deep border mb-3">Draf untuk prototipe</span>
                        <h1 class="display-5 fw-bold text-leaf-deep mb-3">Kebijakan privasi</h1>
                        <p class="lead text-secondary mb-0">Penjelasan sederhana tentang cara {{ config('app.name') }} menggunakan dan menjaga data pada platform ini.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <article class="col-lg-9">
                        <div class="bg-white border rounded-3 shadow-sm p-4 p-md-5">
                            <section class="mb-5">
                                <h2 class="h4 text-leaf-deep">Data yang dikumpulkan</h2>
                                <p class="text-secondary mb-0">Kami dapat mengumpulkan data akun seperti nama, email, NIM, dan program studi untuk mendukung penggunaan platform oleh mahasiswa UIN Sultan Aji Muhammad Idris Samarinda. Kami juga menyimpan metadata kuesioner dan tautan eksternal yang ditambahkan melalui platform.</p>
                            </section>

                            <section class="mb-5">
                                <h2 class="h4 text-leaf-deep">Tujuan penggunaan</h2>
                                <p class="text-secondary mb-0">Data digunakan untuk mengelola akun, membantu verifikasi tautan kuesioner, serta menjaga operasional prototipe ini. Data tidak digunakan untuk tujuan yang tidak terkait dengan layanan tanpa dasar yang jelas.</p>
                            </section>

                            <section class="mb-5">
                                <h2 class="h4 text-leaf-deep">Data jawaban kuesioner</h2>
                                <p class="text-secondary mb-0">Jawaban responden tidak disimpan di platform ini. Saat responden membuka tautan, mereka diarahkan ke platform kuesioner eksternal yang memiliki kebijakan privasi dan pengelolaan data sendiri.</p>
                            </section>

                            <section class="mb-5">
                                <h2 class="h4 text-leaf-deep">Akses admin</h2>
                                <p class="text-secondary mb-0">Admin pengelola sistem dapat mengakses data yang diperlukan untuk memverifikasi kuesioner, menangani masalah penggunaan, dan menjaga layanan tetap berjalan. Akses tersebut dilakukan sesuai kebutuhan pengelolaan sistem.</p>
                            </section>

                            <section class="mb-5">
                                <h2 class="h4 text-leaf-deep">Penyimpanan dan keamanan</h2>
                                <p class="text-secondary mb-0">Data disimpan untuk mendukung layanan prototipe ini. Kami berupaya menerapkan langkah yang wajar untuk mengurangi risiko akses tanpa izin, namun tidak dapat menjanjikan keamanan yang sepenuhnya bebas risiko.</p>
                            </section>

                            <section class="mb-5">
                                <h2 class="h4 text-leaf-deep">Hak pengguna</h2>
                                <p class="text-secondary mb-0">Anda dapat menghubungi pengelola sistem untuk menanyakan data akun, memperbarui informasi yang tidak tepat, atau menyampaikan pertanyaan terkait penggunaan data. Kebijakan ini disusun dengan memperhatikan prinsip perlindungan data pribadi, termasuk UU No. 27 Tahun 2022 tentang Perlindungan Data Pribadi.</p>
                            </section>

                            <section class="mb-0">
                                <h2 class="h4 text-leaf-deep">Perubahan kebijakan</h2>
                                <p class="text-secondary mb-3">Kebijakan ini dapat diperbarui seiring pengembangan platform. Perubahan penting akan ditampilkan pada halaman ini agar pengguna dapat meninjaunya kembali.</p>
                                <p class="mb-0">Hubungi admin {{ config('app.name') }} melalui pengelola sistem.</p>
                            </section>
                        </div>
                    </article>
                </div>
            </div>
        </section>
    </main>
</x-layouts.public>
