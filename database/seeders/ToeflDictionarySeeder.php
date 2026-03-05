<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ToeflDictionarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample words from the passages
        $words = [
            ['mitosis', 'mitosis (pembelahan sel)', 'cell division, biological process'],
            ['meiosis', 'meiosis (pembelahan reduksi)', 'cell division, reduction division'],
            ['cell', 'sel', 'unit, compartment'],
            ['living', 'hidup', 'alive, existing, animate'],
            ['gold', 'emas', 'precious metal, aurum'],
            ['rush', 'terburu-buru / demam (emas)', 'hurry, dash, stampede'],
            ['arch', 'lengkungan', 'curve, bow, vault'],
            ['circumstantial', 'tidak langsung / berdasarkan keadaan', 'contingent, incidental, indirect'],
            ['evidence', 'bukti', 'proof, testimony, confirmation'],
            ['ordinance', 'peraturan / undang-undang', 'law, decree, regulation'],
            ['motel', 'motel (hotel pinggir jalan)', 'motor hotel, inn, lodge'],
            ['oak', 'pohon ek', 'hardwood tree'],
            ['lightning', 'petir', 'thunderbolt, electrical discharge'],
            ['alternative', 'alternatif', 'option, substitute, choice'],
            ['history', 'sejarah', 'past events, chronicle'],
            ['lathe', 'mesin bubut', 'turning machine'],
            ['toy', 'mainan', 'plaything, trinket'],
            ['transportation', 'transportasi', 'conveyance, transport, movement'],
        ];

        foreach ($words as $w) {
            \App\Models\ToeflDictionary::updateOrCreate(
                ['word' => $w[0]],
                [
                    'translation' => $w[1],
                    'synonyms' => $w[2]
                ]
            );
        }
    }
}
