<?php

namespace Database\Seeders;

use App\Enums\QuestionnaireStatus;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public const STUDY_PROGRAMS = [
        'S1 Manajemen Pendidikan Islam (MPI)',
        'S1 Pendidikan Agama Islam (PAI)',
        'S1 Pendidikan Bahasa Arab (PBA)',
        'S1 Pendidikan Islam Anak Usia Dini (PIAUD)',
        'S1 Tadris Bahasa Inggris (TBI)',
        'S1 Tadris Matematika (TMT)',
        'S1 Hukum Ekonomi Syariah (HES)',
        'S1 Hukum Keluarga (HK)',
        'S1 Hukum Tata Negara (HTN)',
        'S1 Ekonomi Syariah (ES)',
        'S1 Perbankan Syariah (PS)',
        'S1 Manajemen Bisnis Syariah (MBS)',
        'S1 Komunikasi dan Penyiaran Islam (KPI)',
        'S1 Bimbingan dan Konseling Islam (BKI)',
        'S1 Manajemen Dakwah (MD)',
        'S1 Ilmu Al-Qur\'an dan Tafsir (IAT)',
        'S1 Sistem Informasi (SI)',
        'S2 Manajemen Pendidikan Islam (MPI)',
        'S2 Pendidikan Agama Islam (PAI)',
        'S2 Hukum Keluarga (HK)',
        'S2 Ekonomi Syariah (ES)',
        'S2 Komunikasi dan Penyiaran Islam (KPI)',
        'S2 Pendidikan Bahasa Arab (PBA)',
        'S2 Ilmu Al-Qur\'an dan Tafsir (IAT)',
        'S3 Manajemen Pendidikan Islam (MPI)',
        'S3 Pendidikan Agama Islam (PAI)',
    ];

    public function run(): void
    {
        $admin = User::factory()->admin()->create([
            'name' => 'Admin Kampus UINSI',
            'email' => 'admin@uinsi.ac.id',
            'study_program' => 'S1 Sistem Informasi (SI)',
            'nim' => '2111100000',
        ]);

        $students = collect();
        foreach (array_slice(self::STUDY_PROGRAMS, 0, 20) as $index => $program) {
            $students->push(User::factory()->create([
                'name' => "Mahasiswa {$index}",
                'email' => "mahasiswa{$index}@uinsi.ac.id",
                'study_program' => $program,
                'nim' => sprintf('2111100%03d', $index + 1),
            ]));
        }

        $categories = collect([
            'Teknologi Informasi',
            'Pendidikan & Pembelajaran',
            'Ekonomi & Bisnis Syariah',
            'Sosial & Agama',
            'Hukum & Tata Negara',
            'Psikologi & Konseling',
            'Komunikasi & Media',
            'Manajemen & Kepemimpinan',
        ])->map(fn (string $name) => Category::create([
            'name' => $name,
            'slug' => Str::slug($name),
            'is_active' => true,
        ]));

        $titles = [
            'Pengaruh Penggunaan AI terhadap Efektivitas Belajar Mahasiswa UINSI',
            'Evaluasi Kepuasan Layanan Sistem Informasi Akademik Kampus',
            'Analis Hubungan E-Commerce Syariah terhadap Perilaku Belanja',
            'Peran Konseling Agama dalam Mengurangi Stres Akademik Mahasiswa',
            'Kesiapan Mahasiswa Hukum dalam Menghadapi Digitalisasi Peradilan',
            'Efektivitas Pembelajaran Bahasa Arab Berbasis Aplikasi Mobile',
            'Tingkat Literasi Keuangan Syariah pada Mahasiswa FEBI UINSI',
            'Pengaruh Media Sosial terhadap Pola Komunikasi Keluarga',
            'Evaluasi Fasilitas Perpustakaan Digital UIN Samarinda',
            'Minat Mahasiswa terhadap Kewirausahaan Digital Syariah',
            'Dampak Program Magang terhadap Kesiapan Kerja Mahasiswa SI',
            'Studi Preferensi Penggunaan Metode Pembelajaran Hybrid',
        ];

        foreach ($titles as $i => $title) {
            $student = $students->random();
            $category = $categories->random();

            $status = match (true) {
                $i < 6 => QuestionnaireStatus::Active,
                $i < 8 => QuestionnaireStatus::Pending,
                $i < 10 => QuestionnaireStatus::Draft,
                $i === 10 => QuestionnaireStatus::Closed,
                default => QuestionnaireStatus::Rejected,
            };

            $student->questionnaires()->create([
                'category_id' => $category->id,
                'title' => $title,
                'slug' => Str::slug($title).'-'.Str::random(4),
                'share_code' => Str::upper(Str::random(8)),
                'description' => "Kuesioner penelitian untuk mendukung skripsi/tugas akhir mengenai {$title}.",
                'external_url' => 'https://forms.gle/'.$i.'uinsiKuesioner',
                'estimated_minutes' => 5,
                'target_respondents' => 30,
                'deadline_at' => $status === QuestionnaireStatus::Closed ? now()->subDay() : now()->addDays(14),
                'status' => $status,
                'rejection_reason' => $status === QuestionnaireStatus::Rejected ? 'Tautan kuesioner tidak valid atau tidak dapat dibuka.' : null,
                'closed_reason' => $status === QuestionnaireStatus::Closed ? 'Batas waktu telah berakhir.' : null,
                'reviewed_by' => in_array($status, [QuestionnaireStatus::Active, QuestionnaireStatus::Rejected, QuestionnaireStatus::Closed], true) ? $admin->id : null,
                'reviewed_at' => in_array($status, [QuestionnaireStatus::Active, QuestionnaireStatus::Rejected, QuestionnaireStatus::Closed], true) ? now()->subDays(2) : null,
                'published_at' => in_array($status, [QuestionnaireStatus::Active, QuestionnaireStatus::Closed], true) ? now()->subDays(2) : null,
                'closed_at' => $status === QuestionnaireStatus::Closed ? now()->subDay() : null,
            ]);
        }
    }
}
