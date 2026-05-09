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
    ];

    public function material(int $id, mixed $user): array|RedirectResponse|null
    {
        if (!array_key_exists($id, self::MATERIALS)) {
            abort(404);
        }

        $canBypassLock = $user?->isAdmin() || $user?->isTeacher();
        $meeting = $this->repository->findMeetingByProgramAndNumber(8, $id);

        if ($meeting && $meeting->is_locked && !$canBypassLock) {
            return redirect()
                ->route('assignments.ielts-academic.reading.index')
                ->with('error', 'This practice test is currently locked.');
        }

        $dbPassages = collect($this->repository->getPassagesByMaterialWithQuestions($id));

        if ($dbPassages->isEmpty()) {
            return null;
        }

        return [
            'title' => self::MATERIALS[$id],
            'id' => $id,
            'content' => $dbPassages->map(function ($passage) {
                return [
                    'id' => $passage->id,
                    'passage_title' => $passage->title,
                    'passage_text' => $passage->content,
                    'questions' => $passage->questions->map(function ($question) {
                        $questionData = [
                            'id' => $question->question_number,
                            'db_id' => $question->id,
                            'type' => $question->type,
                            'text' => $question->question_text,
                            'options' => $this->normalizeOptions($question->options),
                            'correct_answer' => $question->correct_answer,
                            'explanation' => $question->explanation,
                            'data' => $question->data,
                        ];

                        if ($question->data) {
                            $questionData = array_merge($questionData, $question->data);
                        }

                        return $questionData;
                    })->toArray(),
                ];
            })->toArray(),
        ];
    }

    private function normalizeOptions(mixed $options): mixed
    {
        if (!is_array($options) || empty($options)) {
            return $options;
        }

        if (array_keys($options) === range(0, count($options) - 1)) {
            return array_combine($options, $options);
        }

        return $options;
    }
}