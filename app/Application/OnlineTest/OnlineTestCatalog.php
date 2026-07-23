<?php

namespace App\Application\OnlineTest;

use App\Models\Setting;

class OnlineTestCatalog
{
    /**
     * @var array<string, array<string, mixed>>
     */
    private const TEST_DEFAULTS = [
        'ielts_academic' => [
            'label' => 'IELTS Academic',
            'description' => 'Prepare for IELTS Academic with focused practice across all exam sections.',
            'color' => 'blue',
            'duration_minutes' => 165,
            'sections' => [
                ['key' => 'listening', 'title' => 'Listening', 'minutes' => 30, 'question_count' => 40],
                ['key' => 'reading', 'title' => 'Reading', 'minutes' => 60, 'question_count' => 40],
                ['key' => 'writing', 'title' => 'Writing', 'minutes' => 60, 'question_count' => 2],
                ['key' => 'speaking', 'title' => 'Speaking', 'minutes' => 15, 'question_count' => 3],
            ],
        ],
        'ielts_general' => [
            'label' => 'IELTS General',
            'description' => 'Build confidence for IELTS General with practical learning materials and drills.',
            'color' => 'green',
            'duration_minutes' => 165,
            'sections' => [
                ['key' => 'listening', 'title' => 'Listening', 'minutes' => 30, 'question_count' => 40],
                ['key' => 'reading', 'title' => 'Reading', 'minutes' => 60, 'question_count' => 40],
                ['key' => 'writing', 'title' => 'Writing', 'minutes' => 60, 'question_count' => 2],
                ['key' => 'speaking', 'title' => 'Speaking', 'minutes' => 15, 'question_count' => 3],
            ],
        ],
        'toefl_itp' => [
            'label' => 'TOEFL ITP',
            'description' => 'Practice TOEFL ITP listening, structure, and reading in one place.',
            'color' => 'purple',
            'duration_minutes' => 115,
            'sections' => [
                ['key' => 'listening', 'title' => 'Listening Comprehension', 'minutes' => 35, 'question_count' => 50],
                ['key' => 'structure', 'title' => 'Structure and Written Expression', 'minutes' => 25, 'question_count' => 40],
                ['key' => 'reading', 'title' => 'Reading Comprehension', 'minutes' => 55, 'question_count' => 50],
            ],
        ],
        'pte_academic' => [
            'label' => 'PTE Academic',
            'description' => 'Get ready for PTE Academic with integrated speaking, listening, reading, and writing.',
            'color' => 'orange',
            'duration_minutes' => 120,
            'sections' => [
                ['key' => 'speaking_writing', 'title' => 'Speaking & Writing', 'minutes' => 54, 'question_count' => 28],
                ['key' => 'reading', 'title' => 'Reading', 'minutes' => 30, 'question_count' => 20],
                ['key' => 'listening', 'title' => 'Listening', 'minutes' => 36, 'question_count' => 20],
            ],
        ],
    ];

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getEnabledTests(): array
    {
        $settings = $this->loadSettings();
        $tests = [];

        foreach (self::TEST_DEFAULTS as $slug => $default) {
            if (!$this->isEnabled($slug, $settings)) {
                continue;
            }

            $tests[] = $this->buildTestPayload($slug, $default, $settings);
        }

        return $tests;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getEnabledTestBySlug(string $slug): ?array
    {
        $test = $this->getTestBySlug($slug);

        if ($test === null || !$test['enabled']) {
            return null;
        }

        return $test;
    }

    /**
     * @return array<string, mixed>|null
     */
    public function getTestBySlug(string $slug): ?array
    {
        if (!array_key_exists($slug, self::TEST_DEFAULTS)) {
            return null;
        }

        $settings = $this->loadSettings();

        return $this->buildTestPayload($slug, self::TEST_DEFAULTS[$slug], $settings);
    }

    /**
     * @return array<string, string>
     */
    private function loadSettings(): array
    {
        return Setting::query()
            ->where('key', 'like', 'online_test_%')
            ->pluck('value', 'key')
            ->toArray();
    }

    /**
     * @param array<string, mixed> $default
     * @param array<string, string> $settings
     * @return array<string, mixed>
     */
    private function buildTestPayload(string $slug, array $default, array $settings): array
    {
        $descriptionKey = "online_test_{$slug}_description";

        return [
            'slug' => $slug,
            'label' => (string) $default['label'],
            'description' => $settings[$descriptionKey] ?? (string) $default['description'],
            'color' => (string) $default['color'],
            'duration_minutes' => (int) $default['duration_minutes'],
            'sections' => $default['sections'],
            'enabled' => $this->isEnabled($slug, $settings),
        ];
    }

    /**
     * @param array<string, string> $settings
     */
    private function isEnabled(string $slug, array $settings): bool
    {
        $enabledKey = "online_test_{$slug}_enabled";

        return ($settings[$enabledKey] ?? '1') === '1';
    }
}
