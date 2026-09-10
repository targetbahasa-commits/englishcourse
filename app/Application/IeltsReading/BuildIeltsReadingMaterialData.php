<?php

namespace App\Application\IeltsReading;

use App\Domain\IeltsReading\Repositories\IeltsReadingRepository;
use Illuminate\Http\RedirectResponse;

class BuildIeltsReadingMaterialData
{
    public function __construct(
        private readonly IeltsReadingRepository $repository,
    ) {}
    private const MATERIALS = [
        1 => 'Practice Test 1',
        2 => 'Practice Test 2',
        3 => 'Practice Test 3',
        4 => 'Practice Test 4',
        5 => 'Practice Test 5',
        6 => 'Practice Test 6',
        7 => 'Practice Test 7',
        8 => 'Practice Test 8',
        9 => 'Practice Test 9',
        10 => 'Practice Test 10',
        11 => 'Practice Test 11',
        12 => 'Practice Test 12',
        13 => 'Practice Test 13',
        14 => 'Practice Test 14',
        15 => 'Practice Test 15',
        16 => 'Practice Test 16',
        17 => 'Practice Test 17',
        18 => 'Practice Test 18',
        19 => 'Practice Test 19',
        20 => 'Practice Test 20',
        21 => 'Practice Test 21',
        22 => 'Practice Test 22',
        23 => 'Practice Test 23',
        24 => 'Practice Test 24',
        25 => 'Practice Test 25',
        26 => 'Practice Test 26',
        27 => 'Practice Test 27',
        28 => 'Practice Test 28',
        29 => 'Practice Test 29',
        30 => 'Practice Test 30',
        31 => 'Practice Test 31',
        32 => 'Practice Test 32',
        33 => 'Practice Test 33',
        34 => 'Practice Test 34',
        35 => 'Practice Test 35',
        36 => 'Practice Test 36',
        37 => 'Practice Test 37',
        38 => 'Practice Test 38',
        39 => 'Practice Test 39',
        40 => 'Practice Test 40',
        41 => 'Practice Test 41',
        42 => 'Practice Test 42',
        43 => 'Practice Test 43',
        44 => 'Practice Test 44',
        45 => 'Practice Test 45',
        46 => 'Practice Test 46',
        47 => 'Practice Test 47',
        48 => 'Practice Test 48',
        49 => 'Practice Test 49',
        50 => 'Practice Test 50',
        101 => 'Practice Test 1 (General Training)',
        102 => 'Practice Test 2 (General Training)',
        103 => 'Practice Test 3 (General Training)',
        104 => 'Practice Test 4 (General Training)',
        105 => 'Practice Test 5 (General Training)',
        106 => 'Practice Test 6 (General Training)',
        107 => 'Practice Test 7 (General Training)',
        108 => 'Practice Test 8 (General Training)',
        109 => 'Practice Test 9 (General Training)',
        110 => 'Practice Test 10 (General Training)',
        111 => 'Practice Test 11 (General Training)',
        112 => 'Practice Test 12 (General Training)',
        113 => 'Practice Test 13 (General Training)',
        114 => 'Practice Test 14 (General Training)',
        115 => 'Practice Test 15 (General Training)',
        116 => 'Practice Test 16 (General Training)',
        117 => 'Practice Test 17 (General Training)',
        118 => 'Practice Test 18 (General Training)',
        119 => 'Practice Test 19 (General Training)',
        120 => 'Practice Test 20 (General Training)',
        121 => 'Practice Test 21 (General Training)',
        122 => 'Practice Test 22 (General Training)',
        123 => 'Practice Test 23 (General Training)',
        124 => 'Practice Test 24 (General Training)',
        125 => 'Practice Test 25 (General Training)',
        126 => 'Practice Test 26 (General Training)',
        127 => 'Practice Test 27 (General Training)',
        128 => 'Practice Test 28 (General Training)',
        129 => 'Practice Test 29 (General Training)',
        130 => 'Practice Test 30 (General Training)',
    ];

    public function material(int $id, mixed $user): array|RedirectResponse|null
    {
        $title = self::MATERIALS[$id] ?? ($id <= 200 ? "Practice Test {$id}" : null);
        if (!$title) {
            abort(404);
        }

        $canBypassLock = $user?->isAdmin() || $user?->isTeacher();
        $meeting = $id < 100 ? $this->repository->findMeetingByProgramAndNumber(8, $id) : null;

        if ($meeting && $meeting->is_locked && !$canBypassLock) {
            return redirect()
                ->route('assignments.ielts-academic.reading.index')
                ->with('error', 'This practice test is currently locked.');
        }

        $dbPassages = collect($this->repository->getPassagesByMaterialWithQuestions($id));

        if ($dbPassages->isEmpty()) {
            if (!$canBypassLock) {
                return null;
            }

            // Admin/teacher viewing a brand-new, still-empty material: render the
            // page with an empty state (instead of falling through to legacy/404)
            // so they have somewhere to add the first passage from.
            return [
                'title' => $title,
                'id' => $id,
                'content' => [],
            ];
        }

        return [
            'title' => $title,
            'id' => $id,
            'content' => $dbPassages->map(function ($passage) {
                return [
                    'id' => $passage->id,
                    'passage_title' => $passage->title,
                    'passage_text' => $passage->content,
                    'questions' => $passage->questions->map(function ($question) {
                        $dataArray = is_array($question->data) ? $question->data : (json_decode($question->data ?? '', true) ?? []);
                        $questionData = [
                            'id' => $question->question_number,
                            'db_id' => $question->id,
                            'type' => $question->type,
                            'text' => $question->question_text,
                            'options' => $this->normalizeOptions($question->options),
                            'correct_answer' => $question->correct_answer,
                            'explanation' => $question->explanation,
                            'data' => $dataArray,
                        ];

                        if (!empty($dataArray)) {
                            $questionData = array_merge($questionData, $dataArray);
                        }

                        return $questionData;
                    })->toArray(),
                ];
            })->toArray(),
        ];
    }

    private function normalizeOptions(mixed $options): mixed
    {
        if (is_string($options)) {
            $options = json_decode($options, true);
        }

        if (!is_array($options) || empty($options)) {
            return [];
        }

        if (array_keys($options) === range(0, count($options) - 1)) {
            return array_combine($options, $options);
        }

        return $options;
    }
}