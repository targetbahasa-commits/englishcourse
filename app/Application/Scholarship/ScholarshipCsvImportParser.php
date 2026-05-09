<?php

namespace App\Application\Scholarship;

use Carbon\Carbon;
use Illuminate\Support\Str;

class ScholarshipCsvImportParser
{
    public function findHeaderIndex(array $headers, array $needles): ?int
    {
        foreach ($headers as $index => $header) {
            foreach ($needles as $needle) {
                if ($header !== '' && str_contains($header, $needle)) {
                    return $index;
                }
            }
        }

        return null;
    }

    public function parseRowWithHeaderMap(array $row, array $map): array
    {
        $get = function (?int $idx) use ($row): string {
            return ($idx !== null && isset($row[$idx])) ? trim((string) $row[$idx]) : '';
        };

        $applyLink = $get($map['apply_link']);
        if ($applyLink === '') {
            $applyLink = $this->extractFirstUrl($row);
        }

        $title = $get($map['title']);
        if ($title === '') {
            $title = $this->extractLikelyTitle($row);
        }

        $provider = $get($map['provider']);
        if ($provider === '' && $applyLink !== '') {
            $provider = preg_replace('/^www\./', '', (string) parse_url($applyLink, PHP_URL_HOST));
        }

        $location = $get($map['location']) ?: 'Indonesia';
        $level = $get($map['level']) ?: $this->extractLevelFromRow($row);
        if ($level === '') {
            $level = 'SMA / Diploma / S1';
        }

        $openingDate = $this->parseDateValue($get($map['opening_date']));
        $deadline = $this->parseDateValue($get($map['deadline'])) ?: now()->addDays(90);

        $country = $location;
        $description = $get($map['description']) ?: 'Imported via CSV scraper. Mohon review deskripsi.';

        $ageInfo = $get($map['age']);
        $requirements = $get($map['requirements']);
        if ($requirements === '') {
            $requirements = 'Lihat website resmi untuk detail persyaratan.';
            if ($ageInfo !== '') {
                $requirements .= ' Usia: ' . $ageInfo . '.';
            }
        }

        $benefits = $get($map['benefits']) ?: 'Lihat website resmi untuk detail benefit.';

        $minIeltsRaw = $get($map['min_ielts']);
        $minToeflRaw = $get($map['min_toefl']);

        $minIelts = is_numeric($minIeltsRaw) ? (float) $minIeltsRaw : null;
        $minToefl = is_numeric($minToeflRaw) ? (int) $minToeflRaw : null;

        return [
            'title' => Str::limit($title !== '' ? $title : 'Imported Scholarship', 255, ''),
            'provider' => Str::limit($provider !== '' ? $provider : 'Unknown Provider', 255, ''),
            'location' => Str::limit($location, 255, ''),
            'level_of_study' => Str::limit($level, 255, ''),
            'opening_date' => $openingDate?->toDateString(),
            'deadline' => $deadline->toDateString(),
            'apply_link' => $applyLink,
            'country' => Str::limit($country, 255, ''),
            'description' => $description,
            'requirements' => $requirements,
            'benefits' => $benefits,
            'min_ielts' => $minIelts,
            'min_toefl' => $minToefl,
        ];
    }

    public function parseNoisyScraperRow(array $row): array
    {
        $cells = array_map(fn ($v) => trim((string) $v), $row);
        $cells = array_values(array_filter($cells, fn ($v) => $v !== ''));

        $applyLink = $this->extractFirstUrl($cells);

        if ($applyLink && str_contains(strtolower($applyLink), 'luarkampus.id')) {
            return $this->parseLuarkampusRow($cells, $applyLink);
        }

        $provider = $applyLink ? preg_replace('/^www\./', '', (string) parse_url($applyLink, PHP_URL_HOST)) : 'Unknown Provider';

        $allDates = [];
        foreach ($cells as $cell) {
            $d = $this->parseDateValue($cell);
            if ($d) {
                $allDates[] = $d;
            }
        }

        $openingDate = $allDates[0] ?? null;
        $deadline = $allDates[1] ?? $allDates[0] ?? now()->addDays(90);

        $title = $this->extractLikelyTitle($cells);
        $level = $this->extractLevelFromRow($cells);
        if ($level === '') {
            $level = 'SMA / Diploma / S1';
        }

        $ageInfo = collect($cells)->first(function ($cell) {
            return (bool) preg_match('/^\d+\+$/', $cell);
        });

        return [
            'title' => Str::limit($title !== '' ? $title : 'Imported Scholarship', 255, ''),
            'provider' => Str::limit($provider !== '' ? $provider : 'Unknown Provider', 255, ''),
            'location' => 'Indonesia',
            'level_of_study' => Str::limit($level, 255, ''),
            'opening_date' => $openingDate?->toDateString(),
            'deadline' => $deadline->toDateString(),
            'apply_link' => $applyLink ?: '',
            'country' => 'Indonesia',
            'description' => 'Imported from scraper table. Mohon review detail beasiswa.',
            'requirements' => $ageInfo ? ('Periksa syarat resmi. Indikasi usia: ' . $ageInfo . '.') : 'Periksa syarat resmi di halaman sumber.',
            'benefits' => 'Lihat halaman sumber untuk detail benefit.',
            'min_ielts' => null,
            'min_toefl' => null,
        ];
    }

    private function parseLuarkampusRow(array $cells, string $applyLink): array
    {
        $nonUrlCells = array_values(array_filter($cells, function ($cell) {
            return !filter_var($cell, FILTER_VALIDATE_URL);
        }));

        $allDates = [];
        foreach ($nonUrlCells as $cell) {
            $d = $this->parseDateValue($cell);
            if ($d) {
                $allDates[] = $d;
            }
        }

        $openingDate = $allDates[0] ?? null;
        $deadline = $allDates[1] ?? $allDates[0] ?? now()->addDays(90);

        $levelTokens = [];
        foreach ($nonUrlCells as $cell) {
            $upper = strtoupper($cell);
            if (preg_match('/^(SMA|SMK|SMP|D1|D2|D3|D4|S1|S2|S3)$/', $upper)) {
                $levelTokens[] = $upper;
            }
        }
        $levelTokens = array_values(array_unique($levelTokens));
        $levelOfStudy = count($levelTokens) > 0 ? implode(' / ', $levelTokens) : 'SMA / Diploma / S1';

        $ageInfo = collect($nonUrlCells)->first(function ($cell) {
            return (bool) preg_match('/^\d+\+$/', trim($cell));
        });

        $title = '';
        foreach (array_reverse($nonUrlCells) as $cell) {
            $candidate = trim($cell);
            if ($candidate === '') {
                continue;
            }
            if ($this->parseDateValue($candidate)) {
                continue;
            }
            if (preg_match('/^(SMA|SMK|SMP|D1|D2|D3|D4|S1|S2|S3)$/i', $candidate)) {
                continue;
            }
            if (preg_match('/^\d+\+$/', $candidate)) {
                continue;
            }
            if (mb_strlen($candidate) >= 6) {
                $title = $candidate;
                break;
            }
        }

        if ($title === '') {
            $title = 'Imported Event dari Luarkampus';
        }

        $requirements = 'Periksa syarat resmi di halaman sumber.';
        if ($ageInfo) {
            $requirements .= ' Indikasi usia minimum: ' . $ageInfo . '.';
        }
        if (count($levelTokens) > 0) {
            $requirements .= ' Jenjang target: ' . implode(' / ', $levelTokens) . '.';
        }

        return [
            'title' => Str::limit($title, 255, ''),
            'provider' => 'luarkampus.id',
            'location' => 'Indonesia',
            'level_of_study' => Str::limit($levelOfStudy, 255, ''),
            'opening_date' => $openingDate?->toDateString(),
            'deadline' => $deadline->toDateString(),
            'apply_link' => $applyLink,
            'country' => 'Indonesia',
            'description' => 'Imported from luarkampus.id via CSV scraper. Mohon review apakah ini beasiswa/event yang sesuai sebelum publish.',
            'requirements' => $requirements,
            'benefits' => 'Lihat halaman sumber untuk detail benefit atau hadiah.',
            'min_ielts' => null,
            'min_toefl' => null,
        ];
    }

    public function extractFirstUrl(array $cells): ?string
    {
        foreach ($cells as $cell) {
            if (filter_var($cell, FILTER_VALIDATE_URL)) {
                return $cell;
            }
        }

        return null;
    }

    private function extractLikelyTitle(array $cells): string
    {
        foreach (array_reverse($cells) as $cell) {
            if (filter_var($cell, FILTER_VALIDATE_URL)) {
                continue;
            }
            if (mb_strlen($cell) >= 10 && !preg_match('/^\d+[\/-]\d+[\/-]\d+$/', $cell)) {
                return $cell;
            }
        }

        return '';
    }

    private function extractLevelFromRow(array $cells): string
    {
        $tokens = [];
        foreach ($cells as $cell) {
            if (preg_match('/^(SMA|SMK|SMP|D1|D2|D3|D4|S1|S2|S3)$/i', strtoupper($cell))) {
                $tokens[] = strtoupper($cell);
            }
        }

        $tokens = array_values(array_unique($tokens));
        return implode(' / ', $tokens);
    }

    public function parseDateValue(?string $value): ?Carbon
    {
        if (!$value) {
            return null;
        }

        $raw = trim($value);
        $formats = ['d M Y', 'd F Y', 'Y-m-d', 'd/m/Y', 'd-m-Y', 'm/d/Y'];

        foreach ($formats as $format) {
            try {
                return Carbon::createFromFormat($format, $raw);
            } catch (\Throwable $e) {
                // try next format
            }
        }

        try {
            return Carbon::parse($raw);
        } catch (\Throwable $e) {
            return null;
        }
    }
}
