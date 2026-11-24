# PRD: Pusat Kuesioner Penelitian Mahasiswa (Prototipe Web, Lingkup UIN Sultan Aji Muhammad Idris Samarinda)

Dokumen ini adalah sumber kebenaran untuk membangun prototipe web UAS Manajemen Proyek Sistem Informasi, Kelompok 6. Dokumen ini turunan dari proposal "Sistem Informasi Pusat Kuesioner Penelitian Mahasiswa Berbasis Web" (klien: UIN Sultan Aji Muhammad Idris Samarinda), dengan penyesuaian cakupan yang tercatat di bagian 2.

Nama merek belum final. Pakai `config('app.name')` dengan nilai awal "Pusat Kuesioner" dan jangan menulis nama merek langsung di view.

---

## 0. Aturan kerja untuk agen coding

1. Baca seluruh dokumen sebelum menulis kode. Kerjakan berurutan per fase (bagian 10). Jangan lompat fase.
2. Setelah tiap fase selesai: jalankan checklist "Selesai bila" fase itu, commit dengan pesan `feat(fase-N): ...`, lalu berhenti dan laporkan apa yang selesai, apa yang tidak, dan apa yang perlu keputusan manusia.
3. Jangan menambah fitur di luar bagian 2. Khusus: **tidak ada peran atau fitur dosen pembimbing**.
4. Semua teks yang tampil ke pengguna berbahasa Indonesia. Nama variabel, tabel, kolom, class, dan komentar kode berbahasa Inggris.
5. Jangan pernah memakai tampilan bawaan Bootstrap apa adanya. Tema di bagian 7 wajib diterapkan lewat override variabel Sass dan komponen Blade.
6. Dilarang: gambar stok orang, `lorem ipsum` yang tersisa, emoji sebagai ikon, gradien dekoratif, glassmorphism, bayangan tebal, angka palsu di landing page (semua angka statistik diambil dari database).
7. Tidak ada `{!! !!}` di Blade kecuali ada alasan tertulis di komentar. Semua query lewat Eloquent atau query builder berparameter.
8. Bila ada hal ambigu, pilih asumsi paling sederhana yang konsisten dengan dokumen ini, tulis di `docs/ASUMSI.md`, dan lanjut. Jangan berhenti bertanya untuk hal kecil.

---

## 1. Ringkasan produk

**Masalah.** Mahasiswa menyebar kuesioner sendiri-sendiri lewat Google Form, media sosial, dan kertas. Responden sulit didapat, data tersebar, tidak ada verifikasi kelayakan, rekap manual, dan data responden tidak dikelola seragam.

**Solusi.** Satu web terpusat tempat mahasiswa UIN Sultan Aji Muhammad Idris Samarinda bisa membuat kuesioner, mengajukannya untuk diverifikasi admin, membagikannya di etalase, mengisi kuesioner mahasiswa lain, dan melihat rekapnya.

**Tujuan terukur (dari proposal, untuk bahan laporan dan demo)**
- Halaman utama termuat < 3 detik pada jaringan normal.
- Rekap otomatis: dari kuesioner terkumpul ke tabel dan grafik tanpa kerja manual.
- Skor SUS ≥ 68 pada uji ke minimal 5 pengguna (disiapkan di fase 9).

**Pengguna utama:** mahasiswa UIN Sultan Aji Muhammad Idris Samarinda (peneliti sekaligus responden) dan admin pengelola.

---

## 2. Cakupan

**Lingkup institusi:** platform hanya untuk mahasiswa UIN Sultan Aji Muhammad Idris Samarinda. Tidak ada multi-kampus, direktori perguruan tinggi, filter kampus, pengelolaan kampus, atau pendaftaran kampus baru.

### Termasuk
| Modul | Isi |
|---|---|
| M1 Autentikasi dan pengguna | Daftar dengan email aktif, prodi, NIM; verifikasi email; login; profil; peran mahasiswa dan admin |
| M2 Pembuatan kuesioner | Judul, deskripsi, kategori, target responden, batas waktu, estimasi durasi; 3 tipe pertanyaan; tautan dan kode bagikan |
| M3 Pengisian kuesioner | Etalase aktif, pencarian dan filter, pengisian, riwayat |
| M4 Rekap dan dasbor | Progres responden, tabel dan grafik per pertanyaan, ekspor CSV dan Excel |
| M5 Verifikasi dan pemantauan (versi admin saja) | Antrian verifikasi, tolak dengan alasan, kelola pengguna dan kategori, rekap aktivitas per periode dan per kategori |

### Dikeluarkan dari prototipe (ditulis sebagai "pengembangan lanjutan" di laporan)
- Peran dosen pembimbing, komentar dosen, pemantauan bimbingan. Proposal masih menyebutnya; dijelaskan sebagai ditunda.
- Autentikasi dua faktor (OTP email) untuk admin dan CAPTCHA. Diganti honeypot dan pembatasan percobaan login.
- SSO akun kampus, integrasi SIAKAD, aplikasi mobile native, analisis statistik lanjutan (validitas, reliabilitas, uji hipotesis).
- Sistem poin atau kredit "saling mengisi" (lihat pertanyaan terbuka di bagian 12).
- Dark mode, multi-bahasa, notifikasi email selain verifikasi dan reset kata sandi.

---

## 3. Peran dan hak akses

| Kemampuan | Tamu | Mahasiswa (email terverifikasi) | Admin |
|---|---|---|---|
| Lihat landing, etalase, detail kuesioner | ya | ya | ya |
| Isi kuesioner | tidak (diarahkan login) | ya, kecuali milik sendiri | ya (tidak disarankan, tidak dilarang) |
| Buat dan kelola kuesioner milik sendiri | tidak | ya | tidak perlu |
| Lihat rekap kuesioner | tidak | hanya milik sendiri | semua (ringkas) |
| Verifikasi atau tolak kuesioner | tidak | tidak | ya |
| Kelola pengguna dan kategori | tidak | tidak | ya |

Otorisasi lewat Laravel Policy (`QuestionnairePolicy`) dan middleware peran. Jangan cek peran di dalam view saja.

---

## 4. Alur pengguna utama

**A. Peneliti membuat dan menayangkan kuesioner**
Login → Kuesioner Saya → Buat kuesioner → isi info dasar → tambah pertanyaan → pratinjau → Ajukan untuk diverifikasi (status `pending`) → admin menyetujui (status `active`) atau menolak dengan alasan (status `rejected`, bisa diedit lalu diajukan ulang) → salin tautan atau kode untuk dibagikan.

**B. Responden mengisi**
Landing atau Jelajah → filter/cari → buka detail → Isi kuesioner → (login bila belum) → jawab → kirim → halaman terima kasih → tercatat di Riwayat.

**C. Peneliti memantau dan mengunduh**
Kuesioner Saya → Rekap → lihat progres dan grafik → Ekspor CSV atau Excel.

**D. Admin memverifikasi**
Admin → Verifikasi → buka kuesioner → periksa judul, pertanyaan, kelayakan → Setujui atau Tolak (alasan wajib).

---

## 5. Aturan bisnis

| ID | Aturan |
|---|---|
| BR-01 | Satu pengguna hanya boleh punya satu respons per kuesioner. Dijaga dengan unique constraint di database, bukan hanya validasi form. |
| BR-02 | Peneliti tidak boleh mengisi kuesioner miliknya sendiri. |
| BR-03 | Pembuatan dan pengisian kuesioner memerlukan email terverifikasi. |
| BR-04 | Status: `draft` → `pending` → `active` / `rejected`; `rejected` → `draft` (saat diedit); `active` → `closed`. |
| BR-05 | Pertanyaan hanya bisa diubah saat status `draft` atau `rejected`. Setelah diajukan, struktur terkunci agar data jawaban tetap konsisten. |
| BR-06 | Minimal 1 pertanyaan, maksimal 50. Pilihan ganda: 2 sampai 10 opsi. Skala Likert: 5 poin dengan label kutub yang bisa diubah. |
| BR-07 | Batas waktu wajib diisi dan harus di masa depan saat diajukan. |
| BR-08 | Status efektif "terbuka" dihitung saat dibaca: `status = active` dan `deadline_at > now()`. Jangan bergantung pada scheduler, karena di XAMPP/Laragon biasanya tidak berjalan. |
| BR-09 | Kuesioner yang target responden-nya tercapai tetap tampil dengan penanda "Target tercapai"; tidak otomatis ditutup. Peneliti boleh menutup manual. |
| BR-10 | Peneliti tidak pernah melihat identitas responden. Rekap dan ekspor memakai penomoran "Responden 1, 2, ..." tanpa nama, email, NIM, atau prodi. |
| BR-11 | Admin tidak menghapus kuesioner yang sudah punya respons. Admin dapat menutup paksa dengan alasan tercatat. |
| BR-12 | Pertanyaan wajib (`is_required`) divalidasi di server. Jawaban pilihan ganda harus berasal dari opsi milik pertanyaan itu. Jawaban Likert harus dalam rentang skala. |

---

## 6. Peta halaman dan rute

Gunakan route name dalam bahasa Inggris, path dalam bahasa Indonesia.

### Publik
| Path | Route name | Keterangan |
|---|---|---|
| `/` | `home` | Landing page (bagian 8) |
| `/jelajah` | `explore` | Etalase. Query: `q`, `kategori`, `prodi`, `urut` (`terbaru`, `deadline`, `populer`). Paginasi 12 |
| `/k/{slug}` | `questionnaires.show` | Detail kuesioner publik |
| `/panduan` | `guide` | FAQ dan cara pakai |
| `/privasi` | `privacy` | Kebijakan privasi (dasar: UU 27/2022 PDP) |

### Autentikasi (bawaan Breeze, tampilan diganti ke tema sendiri)
`/login`, `/register`, `/forgot-password`, `/reset-password`, `/verify-email`. Form daftar menambah: prodi dan NIM.

### Mahasiswa (middleware `auth`, `verified`)
| Path | Route name | Keterangan |
|---|---|---|
| `/dasbor` | `dashboard` | Ringkasan: kuesioner saya, total respons masuk, rekomendasi kuesioner untuk diisi |
| `/kuesioner-saya` | `mine.index` | Daftar dengan filter status |
| `/kuesioner/buat` | `mine.create` | Langkah 1: info dasar |
| `/kuesioner/{id}/edit` | `mine.edit` | Info dasar dan builder pertanyaan |
| `/kuesioner/{id}/pratinjau` | `mine.preview` | Tampilan seperti responden, tidak menyimpan jawaban |
| `POST /kuesioner/{id}/ajukan` | `mine.submit` | `draft/rejected` → `pending` |
| `POST /kuesioner/{id}/tutup` | `mine.close` | `active` → `closed` |
| `/kuesioner/{id}/rekap` | `mine.report` | Rekap dan grafik |
| `/kuesioner/{id}/ekspor/{format}` | `mine.export` | `csv` atau `xlsx` |
| `/k/{slug}/isi` | `fill.show` / `fill.store` | Form pengisian |
| `/k/{slug}/terima-kasih` | `fill.thanks` | Setelah kirim |
| `/riwayat` | `history` | Kuesioner yang pernah diisi |
| `/profil` | `profile.edit` | Data akun |

### Admin (prefix `/admin`, middleware `auth`, `verified`, `role:admin`)
| Path | Keterangan |
|---|---|
| `/admin` | Dasbor: antrian menunggu, total kuesioner, pengguna, respons |
| `/admin/verifikasi` dan `/admin/verifikasi/{id}` | Antrian, detail, tombol Setujui dan Tolak (alasan wajib) |
| `/admin/pengguna` | Daftar, cari, ubah peran, nonaktifkan |
| `/admin/kategori` | CRUD kategori |
| `/admin/rekap` | Filter periode; agregat per kategori; ekspor CSV |

---

## 7. Arahan desain UI

### 7.1 Analisis referensi
Referensi adalah landing page platform survei (Bohemian Research). Hal yang membuatnya terasa dirancang, bukan dihasilkan otomatis, dan yang kita ambil:

1. **Satu perangkat visual yang konsisten.** Kata kunci di headline ("survey", "respondents") diganti atau ditemani chip ikon berbentuk squircle yang sama dengan logo dan ikon di kartu. Ikon bukan hiasan; ia menunjuk objek yang dibicarakan.
2. **Tipografi yang memikul kepribadian.** Satu keluarga grotesk geometris, headline sangat tebal dengan jarak rapat, isi teks reguler abu-abu. Hierarki jelas dalam tiga lompatan ukuran.
3. **Palet sangat terkendali.** Putih, abu sangat muda, hitam. Warna hanya muncul kecil (logo, chip ikon, tint kartu). Tidak ada gradien latar.
4. **Bento dengan bobot berbeda.** Satu kartu gelap besar sebagai titik fokus, dua kartu abu muda lebih kecil di sebelahnya. Radius dan ukuran bervariasi sesuai hierarki, bukan deretan kartu seragam.
5. **Mockup antarmuka sungguhan, bukan ikon generik.** Kartu "untuk siapa" berisi potongan UI mini (daftar, bar progres, grafik) yang menjelaskan fungsi produk.
6. **Bukti sosial yang konkret.** Angka spesifik dari data nyata, bukan klaim kabur.
7. **Tombol pil, dua tingkat.** Satu pil gelap sebagai aksi utama, satu pil bergaris sebagai aksi kedua.
8. **Ruang kosong lega, tiap section punya satu titik fokus.**

Kelemahan referensi yang **jangan ditiru**: teks sekunder abu terang yang kontrasnya tipis, dan nomor langkah di "How it works" yang semuanya "1" (itu cacat mockup). Nomor langkah kita harus berurutan dan benar.

Adaptasi jujur: referensi memakai logo klien besar dan angka jutaan. Kita tidak punya itu. Kita **tidak boleh memalsukannya**. Pengganti: logo UIN Sultan Aji Muhammad Idris Samarinda (dengan label "Dikembangkan untuk") dan statistik asli dari database.

### 7.2 Rencana desain (token)

**Warna** (nama dipakai sebagai nama variabel)
| Nama | Hex | Pakai untuk |
|---|---|---|
| `paper` | `#FFFFFF` | Latar utama |
| `mist` | `#F3F6F4` | Permukaan kartu terang, latar section selang-seling |
| `forest` | `#0F2A1E` | Teks utama, tombol utama, kartu gelap. Sengaja hijau-hutan gelap, bukan hitam netral |
| `leaf` | `#17A05F` | Isi aksen (chip ikon, bar progres, grafik). Bukan untuk teks kecil |
| `leaf-deep` | `#0B6B3C` | Teks aksen, tautan, hover tombol, tombol dengan teks putih |
| `sprout` | `#DFF3E7` | Tint hijau (latar chip, badge, kartu peran) |
| `cream` | `#FBF0DC` | Tint kartu peran ke-2 saja |
| `ice` | `#E3EEF6` | Tint kartu peran ke-3 saja |
| `line` | `#E3E8E4` | Garis 1px |
| `ink-2` | `#3F4F46` | Teks isi |
| `ink-3` | `#5F6F66` | Teks muted (kontras ≥ 4,5:1 di atas putih) |

Aturan: hijau adalah satu-satunya aksen. `cream` dan `ice` hanya boleh menjadi latar kartu, tidak untuk teks, tombol, atau ikon. Teks kecil di atas `leaf` dilarang; pakai `leaf-deep`.

**Tipografi** (self-host lewat npm, jangan CDN, karena demo mungkin offline)
- Display dan judul: **Bricolage Grotesque** (`@fontsource-variable/bricolage-grotesque`), bobot 700 sampai 800, letter-spacing -0,03em, line-height 1,05 untuk display.
- Isi dan UI: **Hanken Grotesk** (`@fontsource-variable/hanken-grotesk`), bobot 400, 500, 600.
- Skala: display `clamp(2.5rem, 1.2rem + 5vw, 4.5rem)`; h2 `clamp(1.75rem, 1.2rem + 2vw, 2.5rem)`; h3 `1.25rem`; isi `1rem/1.6`; kecil `0.875rem`. Lebar baris isi maksimal 65ch.
- Dilarang: kapital semua untuk label, eyebrow kecil di atas tiap judul, satu kata di headline diberi warna lain, tanda panah `→` di akhir tombol, pemisah titik-tengah antar metadata.

**Bentuk**
- Tombol: pil penuh (`border-radius: 999px`), tinggi 44px, padding horizontal 24px.
- Input: radius 12px, border 1px `line`, fokus: ring 2px `leaf` dan border `leaf-deep`.
- Radius kartu sesuai hierarki: kartu fokus gelap 28px, kartu bento 20px, kartu daftar kuesioner 16px, chip 10px. Jangan satu radius untuk semuanya.
- Tanpa bayangan; pemisah dengan border 1px `line` atau perbedaan latar `paper`/`mist`. Satu-satunya bayangan boleh pada dropdown dan modal.
- Spasi: kelipatan 4px; jarak antar section 96px desktop, 64px mobile.

**Ikon.** Satu set saja: Bootstrap Icons (`bootstrap-icons` via npm, SVG inline). Chip ikon "squircle": kotak 40–56px, radius 30%, latar `sprout`, ikon `leaf-deep`. Di headline hero chip berukuran setinggi huruf kapital.

**Gerak.** Tidak ada animasi masuk per section, tidak ada efek hover di semua kartu. Hanya: (1) satu urutan saat halaman dimuat di hero, di mana dua chip ikon "mendarat" bergantian dalam < 600ms; (2) respons terhadap aksi pengguna (buka, tutup, simpan). Hormati `prefers-reduced-motion`: chip langsung tampil.

**Override Bootstrap** (`resources/sass/_variables.scss`, dimuat sebelum Bootstrap):
```scss
$font-family-sans-serif: 'Hanken Grotesk Variable', system-ui, sans-serif;
$headings-font-family: 'Bricolage Grotesque Variable', 'Hanken Grotesk Variable', sans-serif;
$headings-font-weight: 800;
$body-color: #3F4F46;
$headings-color: #0F2A1E;
$primary: #0F2A1E;
$success: #0B6B3C;
$link-color: #0B6B3C;
$link-hover-color: #0F2A1E;
$border-color: #E3E8E4;
$border-radius: .75rem;
$border-radius-lg: 1.25rem;
$btn-border-radius: 999px;
$btn-padding-x: 1.5rem;
$input-border-radius: .75rem;
$input-focus-border-color: #0B6B3C;
$input-btn-focus-color: rgba(23, 160, 95, .35);
$progress-bar-bg: #17A05F;
$progress-border-radius: 999px;
```
Selain itu buat kelas utilitas `.bg-mist`, `.bg-sprout`, `.bg-cream`, `.bg-ice`, `.bg-forest`, `.text-leaf-deep`, dan komponen `.chip-icon`.

### 7.3 Pedoman copy
- Bahasa Indonesia sehari-hari yang rapi, huruf kapital hanya di awal kalimat (sentence case).
- Tombol menyebut apa yang terjadi: "Ajukan untuk diverifikasi", "Simpan perubahan", "Kirim jawaban". Nama aksi konsisten di seluruh alur: tombol "Ajukan" menghasilkan toast "Kuesioner diajukan".
- Pesan galat menyebut apa yang salah dan cara memperbaikinya, tanpa permintaan maaf dan tanpa kata "oops". Contoh: "Batas waktu harus setelah hari ini."
- Keadaan kosong adalah ajakan bertindak: "Belum ada kuesioner. Buat yang pertama." dengan tombol, tanpa ilustrasi.
- Tanpa kata kosong ("revolusioner", "seamless", "solusi terdepan").

### 7.4 Spesifikasi landing page (`/`)
Navigasi: logo kiri; tautan tengah (Jelajah, Cara kerja, Panduan); kanan pil gelap "Daftar" dan pil bergaris "Masuk". Bila sudah login: "Dasbor".

**1. Hero (rata tengah)**
Headline dua baris, dengan chip ikon sebaris di dalam teks:
> Punya [ikon kuesioner] kuesioner?
> Kami bantu carikan [ikon orang] responden.

Subteks (maks 2 baris): "Unggah kuesioner penelitianmu, bagikan ke mahasiswa UIN Sultan Aji Muhammad Idris Samarinda, dan pantau hasilnya di satu tempat."
Tombol: "Mulai sekarang" (pil gelap) ke `/register`; "Jelajah kuesioner" (pil bergaris) ke `/jelajah`.
Baris kecil di bawahnya: "Dikembangkan untuk UIN Sultan Aji Muhammad Idris Samarinda" dengan logo UINSI kecil. Satu-satunya gerak: chip ikon mendarat saat dimuat.

**2. Bento statistik (angka asli dari database)**
Grid 12 kolom: kartu gelap kiri (span 5, dua baris), dua kartu abu di kanan (span 7).
- Kartu gelap `forest`: "{N} kuesioner aktif" + deskripsi singkat. Visual: diagram orbit, pusat wordmark web, titik-titik abstrak mewakili kuesioner yang berjalan, mengitari dua lingkaran tipis. Dibuat dengan SVG dan CSS, bukan gambar.
- Kartu `mist` 1: "{N} mahasiswa terdaftar" + deskripsi. Visual: grid titik abstrak dengan 2–3 busur dan beberapa titik hijau (dekoratif, tidak mengklaim peta akurat).
- Kartu `mist` 2: "{N} kategori penelitian" + deretan chip kategori nyata dan chip "+{sisa}" bergaya lencana seperti referensi.
Jika data masih kosong, tampilkan angka 0 apa adanya, jangan dipalsukan. Seeder demo mengisi data agar tidak kosong.

**3. "Dibuat untuk peneliti seperti kamu"** (judul rata tengah, subteks satu kalimat)
Tiga kartu tint berbeda, masing-masing berisi mockup UI mini dibangun HTML/CSS:
- Mahasiswa peneliti (`sprout`): bar progres responden dan tombol salin tautan. "Buat kuesioner, ajukan, dan pantau jumlah responden."
- Responden (`cream`): tumpukan 3 kartu kuesioner kecil dengan chip kategori. "Pilih kuesioner yang sesuai, isi, dan lihat riwayatmu."
- Admin (`ice`): antrian verifikasi dengan tombol setuju/tolak. "Periksa kuesioner sebelum tayang dan rekap aktivitas penelitian."

**4. "Cara kerja"** (ini memang urutan, jadi nomor dipakai)
Kontainer `mist` radius 28px. Empat langkah dihubungkan garis tipis: 1 Buat kuesioner ("±10 menit"), 2 Diverifikasi admin ("sebelum tayang"), 3 Bagikan dan diisi ("tautan dan kode"), 4 Lihat rekap ("langsung, tanpa hitung manual"). Nomor 1 sampai 4, berurutan.

**5. Kuesioner aktif terbaru**
Judul "Sedang mencari responden". Grid 3 kolom berisi 6 kartu kuesioner (komponen sama dengan etalase). Tombol "Lihat semua" ke `/jelajah`.

**6. FAQ ringkas** (accordion Bootstrap, 5 pertanyaan): siapa boleh daftar, apakah identitas responden terlihat peneliti, berapa lama verifikasi, apa saja tipe pertanyaan, bagaimana data diunduh.

**7. Blok ajakan penutup** (`forest`, radius 28px, rata tengah)
"Siap mengumpulkan responden?" + satu kalimat: "Daftar dengan email aktif dan buat kuesioner pertamamu hari ini." + pil putih "Daftar sekarang".

**Footer:** logo, tautan (Jelajah, Panduan, Privasi), baris "Prototipe proyek Manajemen Proyek Sistem Informasi, Kelompok 6".

### 7.5 Komponen yang dipakai ulang (Blade components)
`x-button`, `x-chip-icon`, `x-badge-status`, `x-questionnaire-card`, `x-stat-card`, `x-empty-state`, `x-field` (label + input + galat), `x-progress`, `x-toast`, `x-page-header`. Kartu kuesioner memuat: judul (maks 2 baris), chip kategori, bar progres `responden/target` (bila ada target), sisa waktu, tombol "Lihat" atau "Isi".

### 7.6 Layout aplikasi (setelah login)
Sidebar kiri (offcanvas di mobile) untuk Dasbor, Kuesioner saya, Jelajah, Riwayat, Profil; admin memakai sidebar tambahan Verifikasi, Pengguna, Kategori, Rekap. Konten rata kiri, lebar maksimal 1120px. Halaman builder: dua kolom, daftar pertanyaan di kiri dan panel pengaturan pertanyaan terpilih di kanan; di mobile menjadi satu kolom. Urutan pertanyaan lewat tombol naik/turun (drag-and-drop opsional jika waktu cukup).

### 7.7 Kualitas minimum
Responsif sampai 360px; fokus keyboard terlihat; kontras teks ≥ 4,5:1; semua input berlabel; area sentuh ≥ 44px; `alt` pada logo; `prefers-reduced-motion` dihormati; skor Lighthouse performa landing ≥ 85 pada lokal.

---

## 8. Model data

Engine InnoDB, charset `utf8mb4`. Timezone aplikasi `Asia/Makassar` (WITA), locale `id`.

Lingkup satu kampus: tidak ada tabel `institutions` maupun kolom asal kampus di `users`. `study_program` diisi dari daftar prodi resmi UINSI (Lampiran A) dan disimpan sebagai string berformat `{Jenjang} {Nama Prodi}`, misalnya `S1 Sistem Informasi (SI)`.

**users**: `id`, `name`, `email` unique, `email_verified_at`, `password`, `role` enum(`student`,`admin`) default `student`, `study_program` string, `nim` string null, `is_active` bool default true, `remember_token`, timestamps.

**categories**: `id`, `name`, `slug` unique, `is_active` bool, timestamps.

**questionnaires**: `id`, `user_id` FK, `category_id` FK, `title`, `slug` unique, `share_code` unique (8 karakter), `description` text, `estimated_minutes` unsigned tinyint null, `target_respondents` unsigned int null, `deadline_at` datetime, `status` enum(`draft`,`pending`,`active`,`rejected`,`closed`), `rejection_reason` text null, `closed_reason` text null, `reviewed_by` FK users null, `reviewed_at` null, `published_at` null, `closed_at` null, timestamps, soft deletes. Indeks gabungan (`status`, `deadline_at`), indeks `category_id`, `user_id`.

**questions**: `id`, `questionnaire_id` FK cascade, `type` enum(`multiple_choice`,`likert`,`short_text`), `text`, `help_text` null, `is_required` bool default true, `sort_order` unsigned smallint, `settings` json null (Likert: `{"points":5,"min_label":"Sangat tidak setuju","max_label":"Sangat setuju"}`), timestamps. Indeks (`questionnaire_id`, `sort_order`).

**question_options**: `id`, `question_id` FK cascade, `label`, `sort_order`, timestamps.

**responses**: `id`, `questionnaire_id` FK, `user_id` FK, `submitted_at`, timestamps. **Unique (`questionnaire_id`, `user_id`)** (BR-01).

**answers**: `id`, `response_id` FK cascade, `question_id` FK, `option_id` FK null, `value_number` unsigned tinyint null, `value_text` text null, timestamps. Unique (`response_id`, `question_id`).

Relasi Eloquent lengkap, `casts` untuk `status` (PHP enum `QuestionnaireStatus`) dan `settings`, serta accessor `is_open` (BR-08) dan `effective_status`. Hitung jumlah respons dengan `withCount('responses')`.

Validasi: gunakan Form Request per aksi. Terapkan `$fillable` pada semua model.

---

## 9. Spesifikasi teknis

| Komponen | Pilihan |
|---|---|
| Lingkungan | Laragon atau XAMPP di Windows; MySQL lokal; PHP, Composer, dan Node.js terpasang |
| Back-end | Laravel versi stabil terbaru (sesuaikan dengan versi PHP di Laragon; cek persyaratannya sebelum `composer create-project`) |
| Front-end | Blade + Bootstrap 5 (Sass) + sedikit JavaScript; build dengan Vite |
| Auth | Laravel Breeze (Blade). Setelah terpasang, **hapus Tailwind dan ganti semua view auth ke Bootstrap dan token tema**. Alternatif bila ini merepotkan: `laravel/ui` dengan preset Bootstrap |
| Grafik | Chart.js (npm, di-bundle Vite) |
| Ekspor | CSV dengan streaming bawaan PHP; Excel dengan `maatwebsite/excel` (butuh ekstensi PHP `zip`, `gd`, `mbstring`, `intl` aktif) |
| Pengujian | PHPUnit feature test, `Apache Bench` atau `k6` untuk uji beban ringan |
| Email lokal | Mailer `log` atau Mailtrap untuk verifikasi dan reset kata sandi |
| Bahasa | `APP_LOCALE=id`, `APP_TIMEZONE=Asia/Makassar`; terjemahan validasi lewat `lang:publish` dan berkas `lang/id` |

Struktur yang diharapkan: `app/Enums`, `app/Http/Controllers/{Public,Student,Admin}`, `app/Http/Requests`, `app/Policies`, `app/Services` (`QuestionnaireReportService`, `ExportService`), `resources/views/{layouts,components,public,student,admin}`, `database/{migrations,factories,seeders}`, `tests/Feature`, `docs/`.

Keamanan yang wajib: hash kata sandi bawaan Laravel, CSRF bawaan, throttle login dan pengiriman jawaban (`throttle:` middleware), honeypot di form daftar, Policy di setiap aksi kuesioner, tidak ada `{!! !!}`, `APP_DEBUG=false` pada saat demo.

---

## 10. Tahapan pengerjaan

Estimasi kasar untuk satu orang dengan bantuan agen; sesuaikan dengan tenggat UAS.

### Fase 0: Persiapan lingkungan (±0,5 hari)
- Buat proyek Laravel, database MySQL, `.env` (locale, timezone, mailer log), `git init`, `.gitignore`.
- Pasang Breeze (Blade), Bootstrap, Sass, `bootstrap-icons`, fontsource Bricolage Grotesque dan Hanken Grotesk, Chart.js.
- **Selesai bila:** `php artisan serve` dan `npm run dev` jalan; halaman login bawaan tampil; `migrate` sukses.

### Fase 1: Fondasi desain (±1 hari)
- Terapkan token bagian 7.2 (variabel Sass, utilitas warna, font, `.chip-icon`).
- Buat layout `public`, `app` (sidebar), `auth`; navbar, footer; komponen Blade bagian 7.5.
- Buat halaman `/_styleguide` (hanya saat `APP_ENV=local`) yang menampilkan warna, tipografi, tombol, input, badge status, kartu kuesioner, keadaan kosong, toast.
- **Selesai bila:** styleguide tampil sesuai token; tidak ada elemen Bootstrap bawaan yang terlihat generik; Tailwind sudah dihapus.

### Fase 2: Database dan model (±1 hari)
- Migrasi semua tabel bagian 8, model, relasi, enum, factory.
- Seeder: admin awal, 8–12 kategori, 20 mahasiswa dengan prodi beragam, 12–15 kuesioner dummy dengan beragam status, pertanyaan, dan 5–40 respons acak yang valid.
- **Selesai bila:** `php artisan migrate:fresh --seed` berjalan bersih; unique constraint BR-01 terbukti menolak duplikasi lewat tinker atau tes.

### Fase 3: Autentikasi dan profil (±1 hari)
- Form daftar: nama, email, prodi, NIM, kata sandi; honeypot; verifikasi email wajib (BR-03).
- Middleware `role`, redirect setelah login sesuai peran, halaman profil.
- **Selesai bila:** daftar, verifikasi (via log mailer), masuk, keluar, lupa kata sandi bekerja; mahasiswa tidak bisa membuka `/admin`.

### Fase 4: Pembuatan kuesioner (±2 hari)
- `mine.index`, `create`, `edit` (info dasar), builder pertanyaan 3 tipe, hapus dan urut pertanyaan, pratinjau, aksi ajukan dan tutup, pembuatan `slug` dan `share_code`.
- Terapkan BR-05, BR-06, BR-07 dan `QuestionnairePolicy`.
- **Selesai bila:** alur A bagian 4 sampai status `pending` jalan; pertanyaan terkunci setelah diajukan; pengguna lain tidak bisa membuka kuesioner orang lain (403).

### Fase 5: Jelajah dan pengisian (±1,5 hari)
- `/jelajah` dengan pencarian dan filter kategori, prodi, urutan; paginasi; `/k/{slug}` detail; form isi dengan validasi server (BR-12); BR-01, BR-02, BR-08; halaman terima kasih; riwayat.
- **Selesai bila:** alur B jalan penuh; mengisi dua kali ditolak dengan pesan jelas; kuesioner lewat deadline tidak bisa diisi.

### Fase 6: Rekap dan ekspor (±1,5 hari)
- `QuestionnaireReportService`: hitung per pertanyaan (pilihan ganda: jumlah dan persen; Likert: distribusi dan rata-rata; isian singkat: daftar berpaginasi). Header rekap: total respons, progres terhadap target, grafik respons per hari.
- Ekspor CSV dan XLSX anonim (BR-10): kolom `Responden`, `Waktu kirim`, lalu satu kolom per pertanyaan.
- **Selesai bila:** angka rekap cocok dengan data seeder (dicek lewat tes); berkas ekspor terbuka di Excel dan tidak memuat nama atau email.

### Fase 7: Panel admin (±1,5 hari)
- Dasbor admin; antrian verifikasi dengan setujui dan tolak (alasan wajib, BR-04); kelola pengguna dan kategori; rekap aktivitas per periode dan per kategori dengan ekspor CSV; tutup paksa (BR-11).
- **Selesai bila:** alur D jalan; kuesioner yang disetujui langsung muncul di `/jelajah`; ditolak muncul alasan di sisi peneliti.

### Fase 8: Landing page dan poles (±1,5 hari)
- Bangun landing sesuai bagian 7.4; halaman panduan dan privasi; keadaan kosong dan pesan galat sesuai 7.3; toast; halaman 403, 404, 419, 500 bertema.
- QA responsif (360, 768, 1280px), kontras, fokus keyboard, `prefers-reduced-motion`, Lighthouse.
- **Selesai bila:** semua poin 7.7 terpenuhi; angka di landing diambil dari database; tidak ada teks placeholder.

### Fase 9: Pengujian dan persiapan demo (±1 hari)
- Feature test PHPUnit untuk: BR-01, BR-02, BR-03, BR-05, BR-08, otorisasi tiap peran, rekap, ekspor anonim.
- Uji beban ringan landing dan `/jelajah` (Apache Bench atau k6) dan catat hasilnya untuk laporan.
- Skrip UAT dan kuesioner SUS untuk 5 pengguna; skrip demo 5 menit (alur A, B, D, C berurutan); `README.md` berisi cara instal di Laragon/XAMPP; tangkapan layar tiap halaman untuk laporan.
- **Selesai bila:** semua tes hijau; `migrate:fresh --seed` menghasilkan data demo siap pakai; README diuji di komputer lain.

---

## 11. Kriteria penerimaan global
- Alur A, B, C, D bagian 4 dapat didemokan tanpa galat.
- Tidak ada fitur dosen di UI, rute, maupun database.
- Tidak ada fitur multi-kampus: tidak ada tabel, kolom, filter, rute, atau unggah logo perguruan tinggi.
- Semua aturan BR-01 sampai BR-12 ditegakkan di sisi server.
- Tampilan konsisten dengan bagian 7 dan tidak terlihat sebagai Bootstrap bawaan.
- Aplikasi berjalan dari nol di Laragon/XAMPP hanya dengan langkah di README.

---

## 12. Pertanyaan terbuka dan asumsi sementara
| # | Pertanyaan | Asumsi yang dipakai sampai ada jawaban |
|---|---|---|
| 1 | Nama merek final dan logonya | "Pusat Kuesioner", logo teks (wordmark) sederhana |
| 2 | Perlu sistem "saling mengisi" (poin/kredit)? | Tidak; dicatat sebagai pengembangan lanjutan |
| 3 | Tamu boleh mengisi tanpa akun? | Tidak; wajib login (mencegah duplikasi, sesuai proposal) |
| 4 | Apakah mahasiswa dari perguruan tinggi lain boleh mendaftar? | Tidak. Platform hanya untuk mahasiswa UIN Sultan Aji Muhammad Idris Samarinda; tidak ada pendaftaran kampus baru |
| 5 | Tenggat UAS dan pembagian tugas tim | Satu pengerjaan berurutan sesuai fase; estimasi hari di bagian 10 |

---

## 13. Aset yang perlu disediakan
| Aset | Format | Dipakai di | Catatan |
|---|---|---|---|
| Logo UIN Sultan Aji Muhammad Idris Samarinda | SVG atau PNG transparan | Landing (baris "Dikembangkan untuk"), footer | Wajib |
| Logo Program Studi Sistem Informasi atau FUAD | SVG atau PNG transparan | Footer, halaman panduan | Opsional |
| Logo atau nama merek web | SVG | Navbar, favicon | Bila belum ada, dibuatkan wordmark sederhana |
| Daftar kategori penelitian | Teks | Seeder | Bila belum ada, dipakai 10 kategori umum |
| Daftar program studi UIN Sultan Aji Muhammad Idris Samarinda | Teks | Pilihan prodi di form daftar, filter `/jelajah`, seeder | Sudah diterima; lihat Lampiran A |
| Teks kebijakan privasi dan panduan | Teks | `/privasi`, `/panduan` | Bila belum ada, dibuat draf |

Tanpa foto orang dan tanpa ilustrasi eksternal; seluruh visual dibangun dari HTML, CSS, dan SVG.

---

## Lampiran A: Daftar Program Studi UIN Sultan Aji Muhammad Idris Samarinda

Sumber: data tim. Dipakai untuk pilihan prodi di form daftar, filter `/jelajah`, dan seeder. Nilai yang disimpan di `users.study_program` berformat `{Jenjang} {Nama Prodi}`, misalnya `S1 Sistem Informasi (SI)`. Dengan format ini setiap prodi unik meskipun namanya sama di jenjang berbeda.

| Fakultas | Jenjang | Program Studi |
|---|---|---|
| FTIK | S1 | Pendidikan Agama Islam (PAI) |
| FTIK | S1 | Manajemen Pendidikan Islam (MPI) |
| FTIK | S1 | Pendidikan Bahasa Arab (PBA) |
| FTIK | S1 | Tadris Bahasa Inggris (TBI) |
| FTIK | S1 | Pendidikan Guru Madrasah Ibtidaiyah (PGMI) |
| FTIK | S1 | Pendidikan Islam Anak Usia Dini (PIAUD) |
| FTIK | S1 | Tadris Biologi |
| FTIK | S1 | Tadris Matematika |
| FASYA | S1 | Hukum Keluarga (Ahwal Al-Syakhshiyyah) |
| FASYA | S1 | Hukum Ekonomi Syariah (Muamalah) |
| FASYA | S1 | Hukum Tata Negara (Siyasah) |
| FEBI | S1 | Ekonomi Syariah |
| FEBI | S1 | Perbankan Syariah |
| FEBI | S1 | Manajemen Bisnis Syariah |
| FUAD | S1 | Komunikasi dan Penyiaran Islam (KPI) |
| FUAD | S1 | Bimbingan dan Konseling Islam (BKI) |
| FUAD | S1 | Manajemen Dakwah (MD) |
| FUAD | S1 | Ilmu Al-Qur'an dan Tafsir (IAT) |
| FUAD | S1 | Sistem Informasi (SI) |
| Pascasarjana | S2 | Pendidikan Agama Islam (PAI) |
| Pascasarjana | S2 | Manajemen Pendidikan Islam (MPI) |
| Pascasarjana | S2 | Hukum Keluarga (Ahwal Al-Syakhshiyyah) |
| Pascasarjana | S2 | Ekonomi Syariah |
| Pascasarjana | S2 | Komunikasi dan Penyiaran Islam (KPI) |
| Pascasarjana | S2 | Pendidikan Bahasa Arab (PBA) |
| Pascasarjana | S3 | Pendidikan Agama Islam (PAI) |

Catatan: "Pascasarjana" bukan fakultas, tetapi dipakai sebagai pengelompokan agar pilihan S2 dan S3 terpisah dari S1. Total 26 pilihan prodi.