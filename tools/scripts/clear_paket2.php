<?php

/**
 * Script untuk mengosongkan data Paket 2 TOEFL ITP Full Mock Test
 * 
 * Usage: php clear_paket2.php [--dry-run]
 * 
 * --dry-run : Tampilkan data yang akan dihapus tanpa menghapusnya
 */

require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use App\Models\ToeflMockupQuestion;
use App\Models\ToeflReadingPassage;

$dryRun = in_array('--dry-run', $argv);

echo "=== Clear Paket 2 Data ===\n\n";

// Count data in Paket 2
$mockupQuestionsCount = ToeflMockupQuestion::where('package_number', 2)->count();
$readingPassagesCount = ToeflReadingPassage::where('package_number', 2)->count();

echo "Data Paket 2 yang ditemukan:\n";
echo "- ToeflMockupQuestion: {$mockupQuestionsCount} records\n";
echo "- ToeflReadingPassage: {$readingPassagesCount} records\n\n";

if ($mockupQuestionsCount === 0 && $readingPassagesCount === 0) {
    echo "Paket 2 sudah kosong. Tidak ada data untuk dihapus.\n";
    exit(0);
}

if ($dryRun) {
    echo "[DRY RUN] Data yang akan dihapus:\n\n";
    
    // Show Listening questions
    $listeningCount = ToeflMockupQuestion::where('package_number', 2)
        ->where('section', 'listening')
        ->count();
    echo "Listening questions: {$listeningCount}\n";
    
    // Show Structure questions
    $structureCount = ToeflMockupQuestion::where('package_number', 2)
        ->where('section', 'structure')
        ->count();
    echo "Structure questions: {$structureCount}\n";
    
    // Show Reading questions
    $readingCount = ToeflMockupQuestion::where('package_number', 2)
        ->where('section', 'reading')
        ->count();
    echo "Reading questions: {$readingCount}\n";
    
    // Show Reading passages
    $passages = ToeflReadingPassage::where('package_number', 2)->get();
    echo "Reading passages: {$passages->count()}\n";
    foreach ($passages as $passage) {
        echo "  - Passage {$passage->passage_number}: " . $passage->questions()->count() . " questions\n";
    }
    
    echo "\n[DRY RUN] Gunakan tanpa --dry-run untuk menghapus data.\n";
    exit(0);
}

// Confirm deletion
echo "PERINGATAN: Data Paket 2 akan dihapus permanen!\n";
echo "Ketik 'YES' untuk melanjutkan: ";
$handle = fopen("php://stdin", "r");
$line = fgets($handle);
if (trim($line) !== 'YES') {
    echo "Dibatalkan.\n";
    exit(1);
}

// Begin transaction
DB::beginTransaction();

try {
    // Delete ToeflMockupQuestion for Paket 2
    $deletedMockup = ToeflMockupQuestion::where('package_number', 2)->delete();
    echo "✓ Deleted {$deletedMockup} ToeflMockupQuestion records\n";
    
    // Delete ToeflReadingPassage for Paket 2 (questions will cascade delete)
    $deletedPassages = ToeflReadingPassage::where('package_number', 2)->delete();
    echo "✓ Deleted {$deletedPassages} ToeflReadingPassage records\n";
    
    DB::commit();
    
    echo "\n=== Paket 2 berhasil dikosongkan! ===\n";
    echo "Paket 2 sekarang tersedia dengan data kosong.\n";
    echo "Anda bisa mulai menambahkan soal baru ke Paket 2.\n";
    
} catch (Exception $e) {
    DB::rollBack();
    echo "\n✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}
