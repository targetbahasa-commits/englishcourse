<?php

use App\Models\GrammarQuestion;
use Illuminate\Support\Facades\DB;

require __DIR__.'/vendor/autoload.php';

$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$paragraph = [
    'id' => 'Pendidikan digital semakin berkembang karena teknologi internet sudah menjangkau banyak daerah. Sekolah mulai menggunakan platform daring dan guru mendapatkan pelatihan khusus untuk mengajar secara interaktif. Tidak semua siswa memiliki perangkat memadai, maupun koneksi internet yang stabil di rumah mereka. Banyak universitas menawarkan kursus online, tetapi masih ada hambatan dalam penerapan di daerah terpencil. Mahasiswa bisa mengikuti kelas tatap muka atau memilih pembelajaran jarak jauh sesuai kebutuhan. Sistem ini memberi fleksibilitas besar, namun tantangan kesenjangan akses masih perlu diatasi. Transformasi pendidikan berbasis digital terus berjalan, sehingga kesempatan belajar menjadi lebih terbuka untuk semua kalangan.',
    'en' => 'Digital education is increasingly developing because internet technology has reached many areas. Schools are starting to use online platforms and teachers are getting special training to teach interactively. Not all students have adequate devices, nor do they have stable internet connections at their homes. Many universities offer online courses, but there are still obstacles in implementation in remote areas. Students can attend face-to-face classes or choose distance learning according to their needs. This system provides great flexibility, yet the challenge of access gaps still needs to be addressed. The digital-based education transformation continues, so learning opportunities become more open to all groups.',
    'vocab' => [
        'Digital education' => 'Pendidikan digital',
        'Increasingly' => 'Semakin',
        'Online platform' => 'Platform daring',
        'Interactively' => 'Secara interaktif',
        'Adequate' => 'Memadai',
        'Stable' => 'Stabil',
        'Obstacle' => 'Hambatan',
        'Remote areas' => 'Daerah terpencil',
        'Face-to-face' => 'Tatap muka',
        'Distance learning' => 'Pembelajaran jarak jauh',
        'Flexibility' => 'Fleksibilitas',
        'Access gap' => 'Kesenjangan akses',
        'Transformation' => 'Transformasi'
    ]
];

// Check if data already exists to avoid duplicates
// Using question_number 0 or similar to denote paragraph, or section 'paragraph'
// Existing questions are 1-15. Let's use question_number 100 for paragraph or rely on 'section'.
// Better to use 'section' = 'paragraph'.

$existingParagraph = GrammarQuestion::where('meeting_number', 11)
                                    ->where('section', 'paragraph')
                                    ->first();

if ($existingParagraph) {
    echo "Meeting 11 paragraph already exists. Skipping migration.\n";
} else {
    GrammarQuestion::create([
        'meeting_number' => 11,
        'question_number' => 100, // Arbitrary high number to keep it separate? Or just ignore number.
        'question_text' => $paragraph['id'],
        'correct_answer' => $paragraph['en'],
        'vocab' => $paragraph['vocab'],
        'section' => 'paragraph', // Mark as paragraph
        'structure' => null,
        'example_en' => null,
    ]);
    echo "Migrated Meeting 11 paragraph.\n";
}
