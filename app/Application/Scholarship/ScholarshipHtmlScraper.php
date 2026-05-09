<?php

namespace App\Application\Scholarship;

use Carbon\Carbon;
use Illuminate\Support\Str;

class ScholarshipHtmlScraper
{
    public function extractSourceUrlsFromInput(?string $bulkInput, ?string $singleInput): array
    {
        $raw = [];

        if ($singleInput && trim($singleInput) !== '') {
            $raw[] = trim($singleInput);
        }

        if ($bulkInput && trim($bulkInput) !== '') {
            $chunks = preg_split('/[\r\n,;\t ]+/', $bulkInput);
            foreach ($chunks as $chunk) {
                $v = trim((string) $chunk);
                if ($v !== '') {
                    $raw[] = $v;
                }
            }
        }

        $raw = array_values(array_unique($raw));

        return array_values(array_filter($raw, function ($url) {
            return (bool) filter_var($url, FILTER_VALIDATE_URL);
        }));
    }

    public function detectParserNameFromUrl(string $url): string
    {
        $host = strtolower((string) (parse_url($url, PHP_URL_HOST) ?? ''));

        if (str_contains($host, 'daad.de')) {
            return 'site_daad';
        }

        if (str_contains($host, 'chevening.org')) {
            return 'site_chevening';
        }

        if (str_contains($host, 'australiaawardsindonesia.org')) {
            return 'site_australia_awards';
        }

        if (str_contains($host, 'luarkampus.id')) {
            return 'site_luarkampus';
        }

        return 'html_generic';
    }

    public function parseScholarshipFromHtml(string $html, string $url): array
    {
        $xpath = $this->makeXPath($html);

        $title = $this->extractFirst($xpath, [
            "//meta[@property='og:title']/@content",
            "//meta[@name='twitter:title']/@content",
            "//h1[1]/text()",
            "//title/text()",
        ]);

        $description = $this->extractFirst($xpath, [
            "//meta[@name='description']/@content",
            "//meta[@property='og:description']/@content",
            "//article//p[1]/text()",
            "//main//p[1]/text()",
            "//p[1]/text()",
        ]);

        $bodyText = Str::of(strip_tags($html))->replaceMatches('/\s+/', ' ')->lower()->toString();

        $country = $this->inferCountry($bodyText);
        $location = $country ?: 'Global';
        $level = $this->inferLevelOfStudy($bodyText);
        $deadline = $this->extractDeadline($bodyText);
        $minIelts = $this->extractFirstNumber($bodyText, '/ielts[^0-9]{0,20}([4-9](?:\.[05])?)/i');
        $minToefl = $this->extractFirstNumber($bodyText, '/toefl(?:\s*(?:itp|ibt))?[^0-9]{0,20}(\d{2,3})/i');

        $provider = parse_url($url, PHP_URL_HOST) ?: 'Unknown Provider';
        $provider = preg_replace('/^www\./', '', $provider);

        $requirements = $this->extractSectionByKeywords($html, ['requirement', 'eligibility', 'criteria', 'syarat']);
        $benefits = $this->extractSectionByKeywords($html, ['benefit', 'funding', 'coverage', 'award', 'beasiswa']);

        $title = $title ?: Str::title(str_replace(['-', '_'], ' ', $provider . ' scholarship'));
        $description = $description ?: 'Imported by scraper. Mohon review deskripsi dari sumber resmi.';
        $requirements = $requirements ?: 'Lihat website resmi untuk detail persyaratan.';
        $benefits = $benefits ?: 'Lihat website resmi untuk detail benefit.';

        $base = [
            'title' => Str::limit(trim($title), 255, ''),
            'provider' => Str::limit(trim((string) $provider), 255, ''),
            'location' => Str::limit(trim((string) $location), 255, ''),
            'level_of_study' => Str::limit(trim((string) $level), 255, ''),
            'description' => trim($description),
            'requirements' => trim($requirements),
            'benefits' => trim($benefits),
            'deadline' => $deadline->toDateString(),
            'opening_date' => null,
            'requires_certification' => !is_null($minIelts) || !is_null($minToefl),
            'country' => $country,
            'min_ielts' => $minIelts,
            'min_toefl' => $minToefl ? (int) round($minToefl) : null,
            'is_active' => true,
            'apply_link' => $url,
        ];

        $host = strtolower((string) (parse_url($url, PHP_URL_HOST) ?? ''));
        $siteSpecific = $this->parseSiteSpecific($xpath, $html, $host);

        foreach ($siteSpecific as $k => $v) {
            if ($v !== null && $v !== '') {
                $base[$k] = $v;
            }
        }

        return $base;
    }

    private function parseSiteSpecific(\DOMXPath $xpath, string $html, string $host): array
    {
        if (str_contains($host, 'daad.de')) {
            return $this->parseDaadSpecific($xpath, $html);
        }
        if (str_contains($host, 'chevening.org')) {
            return $this->parseCheveningSpecific($xpath, $html);
        }
        if (str_contains($host, 'australiaawardsindonesia.org')) {
            return $this->parseAustraliaAwardsSpecific($xpath, $html);
        }

        return [];
    }

    private function parseDaadSpecific(\DOMXPath $xpath, string $html): array
    {
        $title = $this->extractFirst($xpath, [
            "//h1[contains(@class,'title')]/text()",
            "//h1[1]/text()",
            "//title/text()",
        ]);

        $requirements = $this->extractSectionByKeywords($html, ['application requirements', 'requirements', 'eligibility']);
        $benefits = $this->extractSectionByKeywords($html, ['funding', 'benefits', 'scholarship value']);

        return [
            'title' => $title,
            'provider' => 'DAAD',
            'country' => 'Germany',
            'location' => 'Germany',
            'requirements' => $requirements,
            'benefits' => $benefits,
        ];
    }

    private function parseCheveningSpecific(\DOMXPath $xpath, string $html): array
    {
        $title = $this->extractFirst($xpath, [
            "//h1[1]/text()",
            "//meta[@property='og:title']/@content",
            "//title/text()",
        ]);
        $description = $this->extractFirst($xpath, [
            "//meta[@name='description']/@content",
            "//article//p[1]/text()",
        ]);
        $requirements = $this->extractSectionByKeywords($html, ['eligible', 'eligibility', 'requirements']);
        $benefits = $this->extractSectionByKeywords($html, ['fully funded', 'benefits', 'what is included']);

        return [
            'title' => $title,
            'provider' => 'Chevening',
            'country' => 'United Kingdom',
            'location' => 'United Kingdom',
            'description' => $description,
            'requirements' => $requirements,
            'benefits' => $benefits,
        ];
    }

    private function parseAustraliaAwardsSpecific(\DOMXPath $xpath, string $html): array
    {
        $title = $this->extractFirst($xpath, [
            "//h1[1]/text()",
            "//meta[@property='og:title']/@content",
            "//title/text()",
        ]);
        $requirements = $this->extractSectionByKeywords($html, ['eligibility', 'persyaratan', 'requirements']);
        $benefits = $this->extractSectionByKeywords($html, ['benefits', 'what you will receive', 'pendanaan']);

        return [
            'title' => $title,
            'provider' => 'Australia Awards Indonesia',
            'country' => 'Australia',
            'location' => 'Australia',
            'requirements' => $requirements,
            'benefits' => $benefits,
        ];
    }

    private function makeXPath(string $html): \DOMXPath
    {
        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML('<?xml encoding="utf-8" ?>' . $html, LIBXML_NOERROR | LIBXML_NOWARNING);
        libxml_clear_errors();

        return new \DOMXPath($dom);
    }

    private function extractFirst(\DOMXPath $xpath, array $queries): ?string
    {
        foreach ($queries as $query) {
            $nodes = $xpath->query($query);
            if ($nodes && $nodes->length > 0) {
                $value = trim($nodes->item(0)->nodeValue ?? '');
                if ($value !== '') {
                    return preg_replace('/\s+/', ' ', $value);
                }
            }
        }

        return null;
    }

    private function inferCountry(string $text): ?string
    {
        $map = [
            'australia' => 'Australia',
            'united kingdom' => 'United Kingdom',
            'uk ' => 'United Kingdom',
            'england' => 'United Kingdom',
            'united states' => 'United States',
            'usa' => 'United States',
            'canada' => 'Canada',
            'japan' => 'Japan',
            'korea' => 'South Korea',
            'germany' => 'Germany',
            'france' => 'France',
            'netherlands' => 'Netherlands',
            'singapore' => 'Singapore',
            'new zealand' => 'New Zealand',
        ];

        foreach ($map as $needle => $country) {
            if (str_contains($text, $needle)) {
                return $country;
            }
        }

        return null;
    }

    private function inferLevelOfStudy(string $text): string
    {
        $levels = [];
        if (str_contains($text, 'bachelor') || str_contains($text, 'undergraduate') || str_contains($text, 's1')) {
            $levels[] = 'Bachelor';
        }
        if (str_contains($text, 'master') || str_contains($text, 'postgraduate') || str_contains($text, 's2')) {
            $levels[] = 'Master';
        }
        if (str_contains($text, 'phd') || str_contains($text, 'doctoral') || str_contains($text, 's3')) {
            $levels[] = 'PhD';
        }

        if (count($levels) === 0) {
            return 'Bachelor / Master / PhD';
        }

        return implode(' / ', $levels);
    }

    private function extractDeadline(string $text): Carbon
    {
        $patterns = [
            '/(?:deadline|closing date|application closes|batas akhir|ditutup)\D{0,20}([a-z]{3,9}\s+\d{1,2},?\s+\d{4})/i',
            '/(?:deadline|closing date|application closes|batas akhir|ditutup)\D{0,20}(\d{1,2}[\/\-]\d{1,2}[\/\-]\d{2,4})/i',
            '/(?:deadline|closing date|application closes|batas akhir|ditutup)\D{0,20}(\d{4}[\/\-]\d{1,2}[\/\-]\d{1,2})/i',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $text, $matches)) {
                try {
                    return Carbon::parse(trim($matches[1]));
                } catch (\Throwable $e) {
                    // Continue to next pattern.
                }
            }
        }

        return now()->addDays(90);
    }

    private function extractFirstNumber(string $text, string $pattern): ?float
    {
        if (preg_match($pattern, $text, $matches)) {
            return is_numeric($matches[1]) ? (float) $matches[1] : null;
        }

        return null;
    }

    private function extractSectionByKeywords(string $html, array $keywords): ?string
    {
        $plain = preg_replace('/\s+/', ' ', strip_tags($html));

        foreach ($keywords as $keyword) {
            $pattern = '/(?:' . preg_quote($keyword, '/') . ')[^\.\n]{0,220}(?:\.|\n)/i';
            if (preg_match($pattern, $plain, $matches)) {
                $text = trim($matches[0]);
                if ($text !== '') {
                    return $text;
                }
            }
        }

        return null;
    }
}
