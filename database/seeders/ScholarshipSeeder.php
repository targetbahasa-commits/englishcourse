<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Scholarship;

class ScholarshipSeeder extends Seeder
{
    public function run(): void
    {
        Scholarship::create([
            'title' => 'LPDP - Beasiswa Reguler 2026',
            'provider' => 'Kementerian Keuangan RI',
            'location' => 'Indonesia / Global',
            'description' => 'Beasiswa penuh untuk program Magister dan Doktoral di dalam dan luar negeri.',
            'requirements' => "1. WNI 2. Telah menyelesaikan studi D4/S1 3. Tidak sedang menempuh studi degree/non-degree 4. Usia maksimal 35 tahun (S2) dan 40 tahun (S3)",
            'benefits' => "Biaya Pendidikan (Tuition Fee) Biaya Hidup (Living Allowance) Biaya Tiket Pesawat (PP) Asuransi Kesehatan Biaya Kedatangan",
            'min_ielts' => 6.5,
            'min_toefl' => 550,
            'min_gpa' => 3.00,
            'max_age' => 35,
            'country' => 'Global',
            'level_of_study' => 'Master / PhD',
            'funding_type' => 'Fully Funded',
            'has_work_contract' => true,
            'apply_link' => 'https://lpdp.kemenkeu.go.id/',
            'opening_date' => now()->copy()->subDays(5),
            'deadline' => now()->copy()->addDays(28),
        ]);
        
        Scholarship::create([
            'title' => 'AAS - Australia Awards Scholarships 2026',
            'provider' => 'Department of Foreign Affairs and Trade (DFAT)',
            'location' => 'Australia',
            'description' => 'Beasiswa internasional bergengsi yang didanai oleh Pemerintah Australia.',
            'requirements' => "1. Warga negara Indonesia 2. Melamar untuk program studi di Australia 3. Memenuhi persyaratan bahasa Inggris",
            'benefits' => "Full tuition fees Return air travel Establishment allowance Contribution to Living Expenses (CLE) OSHC (Health Cover)",
            'min_ielts' => 6.0,
            'min_toefl' => 525,
            'min_gpa' => 2.90,
            'max_age' => 42,
            'country' => 'Australia',
            'level_of_study' => 'Master / PhD',
            'funding_type' => 'Fully Funded',
            'has_work_contract' => false,
            'apply_link' => 'https://www.australiaawardsindonesia.org/',
            'opening_date' => now()->copy()->addDays(5),
            'deadline' => now()->copy()->addDays(45),
        ]);
    }
}
