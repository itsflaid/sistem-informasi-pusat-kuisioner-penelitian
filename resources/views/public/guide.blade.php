<x-layouts.public>
    <main>
        <section class="bg-mist py-5">
            <div class="container py-lg-4">
                <div class="row justify-content-center text-center">
                    <div class="col-lg-8">
                        <span class="badge bg-white text-leaf-deep border mb-3">Untuk mahasiswa UINSI Samarinda</span>
                        <h1 class="display-5 fw-bold text-leaf-deep mb-3">Panduan penggunaan</h1>
                        <p class="lead text-secondary mb-0">Mulai penelitian Anda dengan langkah sederhana, dari pendaftaran hingga berbagi tautan kuesioner.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-5">
            <div class="container">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-3">
                        <article class="h-100 border rounded-3 p-4 bg-white shadow-sm">
                            <span class="chip-icon d-inline-flex align-items-center justify-content-center rounded-circle bg-mist text-leaf-deep fw-bold mb-3">1</span>
                            <h2 class="h5 text-leaf-deep">Daftar dan verifikasi email</h2>
                            <p class="text-secondary mb-0">Buat akun menggunakan email aktif Anda, lalu selesaikan verifikasi email untuk mulai menggunakan platform.</p>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <article class="h-100 border rounded-3 p-4 bg-white shadow-sm">
                            <span class="chip-icon d-inline-flex align-items-center justify-content-center rounded-circle bg-mist text-leaf-deep fw-bold mb-3">2</span>
                            <h2 class="h5 text-leaf-deep">Tambahkan tautan kuesioner</h2>
                            <p class="text-secondary mb-0">Isi judul, deskripsi, kategori, dan tempel tautan kuesioner eksternal seperti Google Forms atau Microsoft Forms.</p>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <article class="h-100 border rounded-3 p-4 bg-white shadow-sm">
                            <span class="chip-icon d-inline-flex align-items-center justify-content-center rounded-circle bg-mist text-leaf-deep fw-bold mb-3">3</span>
                            <h2 class="h5 text-leaf-deep">Ajukan untuk diverifikasi</h2>
                            <p class="text-secondary mb-0">Kirim kuesioner Anda untuk ditinjau admin sebelum dapat ditayangkan kepada responden.</p>
                        </article>
                    </div>
                    <div class="col-md-6 col-lg-3">
                        <article class="h-100 border rounded-3 p-4 bg-white shadow-sm">
                            <span class="chip-icon d-inline-flex align-items-center justify-content-center rounded-circle bg-mist text-leaf-deep fw-bold mb-3">4</span>
                            <h2 class="h5 text-leaf-deep">Bagikan tautan ke responden</h2>
                            <p class="text-secondary mb-0">Setelah disetujui, kuesioner tampil di Jelajah dan responden diarahkan ke tautan eksternal yang Anda simpan.</p>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-mist py-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-9">
                        <h2 class="h3 text-leaf-deep text-center mb-4">Pertanyaan yang sering diajukan</h2>
                        <div class="accordion shadow-sm" id="guideFaq">
                            <div class="accordion-item">
                                <h3 class="accordion-header" id="faqRegistrant">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqRegistrantAnswer" aria-expanded="true" aria-controls="faqRegistrantAnswer">Siapa yang boleh mendaftar?</button>
                                </h3>
                                <div id="faqRegistrantAnswer" class="accordion-collapse collapse show" aria-labelledby="faqRegistrant" data-bs-parent="#guideFaq">
                                    <div class="accordion-body">Platform ini hanya dapat digunakan oleh mahasiswa UIN Sultan Aji Muhammad Idris Samarinda.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="accordion-header" id="faqAnonymous">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqAnonymousAnswer" aria-expanded="false" aria-controls="faqAnonymousAnswer">Apakah jawaban responden disimpan di sini?</button>
                                </h3>
                                <div id="faqAnonymousAnswer" class="accordion-collapse collapse" aria-labelledby="faqAnonymous" data-bs-parent="#guideFaq">
                                    <div class="accordion-body">Tidak. Platform ini hanya menyimpan metadata dan tautan kuesioner. Jawaban responden tersimpan di platform kuesioner eksternal yang Anda gunakan.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="accordion-header" id="faqVerification">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqVerificationAnswer" aria-expanded="false" aria-controls="faqVerificationAnswer">Berapa lama proses verifikasi?</button>
                                </h3>
                                <div id="faqVerificationAnswer" class="accordion-collapse collapse" aria-labelledby="faqVerification" data-bs-parent="#guideFaq">
                                    <div class="accordion-body">Kuesioner akan ditinjau oleh admin sebelum tayang. Waktu verifikasi dapat menyesuaikan antrean dan kelengkapan pengajuan.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="accordion-header" id="faqQuestionTypes">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqQuestionTypesAnswer" aria-expanded="false" aria-controls="faqQuestionTypesAnswer">Platform kuesioner apa yang didukung?</button>
                                </h3>
                                <div id="faqQuestionTypesAnswer" class="accordion-collapse collapse" aria-labelledby="faqQuestionTypes" data-bs-parent="#guideFaq">
                                    <div class="accordion-body">Tautan HTTPS dari platform kuesioner mana pun, misalnya Google Forms, Microsoft Forms, atau platform kuesioner lainnya.</div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h3 class="accordion-header" id="faqExport">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqExportAnswer" aria-expanded="false" aria-controls="faqExportAnswer">Bagaimana mendapatkan hasil kuesioner?</button>
                                </h3>
                                <div id="faqExportAnswer" class="accordion-collapse collapse" aria-labelledby="faqExport" data-bs-parent="#guideFaq">
                                    <div class="accordion-body">Jawaban tidak disimpan di platform ini. Unduh hasil kuesioner langsung dari platform eksternal yang Anda gunakan.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="bg-forest py-5">
            <div class="container text-center text-white">
                <h2 class="h3 fw-bold mb-3">Siap membagikan kuesionermu?</h2>
                <p class="mb-4">Daftar untuk mulai menambahkan dan mengajukan tautan kuesioner penelitian Anda.</p>
                <a class="btn btn-light px-4" href="{{ route('register') }}">Daftar sekarang</a>
            </div>
        </section>
    </main>
</x-layouts.public>
