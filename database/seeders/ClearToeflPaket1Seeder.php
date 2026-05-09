<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToeflMockupQuestion;

class ClearToeflPaket1Seeder extends Seeder
{
    /**
     * Menghapus semua soal TOEFL dari database (Paket 1)
     */
    public function run(): void
    {
        // Hapus semua soal Listening (Part A, B, C)
        $deletedListening = ToeflMockupQuestion::where('section', 'listening')
            ->whereIn('part', ['A', 'B', 'C'])
            ->delete();

        // Hapus semua soal Structure
        $deletedStructure = ToeflMockupQuestion::where('section', 'structure')->delete();

        // Hapus semua soal Reading
        $deletedReading = ToeflMockupQuestion::where('section', 'reading')->delete();

        $this->command->info("Berhasil menghapus:");
        $this->command->info("- Listening: {$deletedListening} soal");
        $this->command->info("- Structure: {$deletedStructure} soal");
        $this->command->info("- Reading: {$deletedReading} soal");
        $this->command->info("Total: " . ($deletedListening + $deletedStructure + $deletedReading) . " soal dihapus");
    }
}
