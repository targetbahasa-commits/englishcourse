<?php

namespace App\Domain\ToeflMockup;

use App\Models\Setting;

class ToeflScoreConverter
{
    /**
     * @return array<string, array<int, int>>
     */
    public static function defaultTables(): array
    {
        return [
            'listening' => [
                50 => 68, 49 => 67, 48 => 66, 47 => 65, 46 => 63, 45 => 62, 44 => 61, 43 => 60, 42 => 59, 41 => 58, 40 => 57,
                39 => 57, 38 => 56, 37 => 55, 36 => 54, 35 => 54, 34 => 53, 33 => 52, 32 => 52, 31 => 51, 30 => 51, 29 => 50,
                28 => 49, 27 => 49, 26 => 48, 25 => 48, 24 => 47, 23 => 47, 22 => 46, 21 => 45, 20 => 45, 19 => 44, 18 => 43,
                17 => 42, 16 => 41, 15 => 41, 14 => 39, 13 => 38, 12 => 37, 11 => 35, 10 => 33, 9 => 32, 8 => 32, 7 => 31,
                6 => 30, 5 => 29, 4 => 28, 3 => 27, 2 => 26, 1 => 25, 0 => 24,
            ],
            'structure' => [
                40 => 68, 39 => 67, 38 => 65, 37 => 63, 36 => 61, 35 => 60, 34 => 58, 33 => 57, 32 => 56, 31 => 55, 30 => 54,
                29 => 53, 28 => 52, 27 => 51, 26 => 50, 25 => 49, 24 => 48, 23 => 47, 22 => 46, 21 => 45, 20 => 44, 19 => 43,
                18 => 43, 17 => 42, 16 => 40, 15 => 40, 14 => 38, 13 => 37, 12 => 36, 11 => 35, 10 => 33, 9 => 31, 8 => 29,
                7 => 27, 6 => 26, 5 => 25, 4 => 23, 3 => 22, 2 => 21, 1 => 20, 0 => 20,
            ],
            'reading' => [
                50 => 67, 49 => 66, 48 => 65, 47 => 63, 46 => 61, 45 => 60, 44 => 59, 43 => 58, 42 => 57, 41 => 56, 40 => 55,
                39 => 54, 38 => 54, 37 => 53, 36 => 52, 35 => 52, 34 => 51, 33 => 50, 32 => 49, 31 => 48, 30 => 48, 29 => 47,
                28 => 46, 27 => 46, 26 => 45, 25 => 44, 24 => 43, 23 => 43, 22 => 42, 21 => 41, 20 => 40, 19 => 39, 18 => 38,
                17 => 37, 16 => 36, 15 => 35, 14 => 34, 13 => 32, 12 => 31, 11 => 30, 10 => 29, 9 => 28, 8 => 28, 7 => 27,
                6 => 26, 5 => 25, 4 => 24, 3 => 23, 2 => 23, 1 => 22, 0 => 21,
            ],
        ];
    }

    public function convert(string $section, int $rawScore): int
    {
        $tables = $this->resolveTables();
        $table = $tables[$section] ?? [];

        if ($table === []) {
            return 31;
        }

        return (int) ($table[$rawScore] ?? $table[0] ?? 31);
    }

    /**
     * @return array<string, array<int, int>>
     */
    private function resolveTables(): array
    {
        $defaults = self::defaultTables();
        $stored = Setting::query()->where('key', 'online_test_toefl_itp_score_tables')->value('value');

        if (!is_string($stored) || trim($stored) === '') {
            return $defaults;
        }

        $decoded = json_decode($stored, true);
        if (!is_array($decoded)) {
            return $defaults;
        }

        $tables = [];

        foreach ($defaults as $section => $defaultTable) {
            $inputTable = $decoded[$section] ?? [];

            if (!is_array($inputTable)) {
                $tables[$section] = $defaultTable;
                continue;
            }

            $normalizedTable = [];

            foreach ($inputTable as $raw => $scaled) {
                if (!is_numeric($raw) || !is_numeric($scaled)) {
                    continue;
                }

                $scaledScore = (int) $scaled;

                // Support x10 stored format (e.g. 680) while keeping runtime scale at 68.
                if ($scaledScore >= 100) {
                    $scaledScore = (int) round($scaledScore / 10);
                }

                $normalizedTable[(int) $raw] = $scaledScore;
            }

            krsort($normalizedTable);
            $tables[$section] = $normalizedTable !== [] ? $normalizedTable : $defaultTable;
        }

        return $tables;
    }
}