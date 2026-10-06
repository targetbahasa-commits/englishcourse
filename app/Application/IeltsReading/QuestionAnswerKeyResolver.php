<?php

namespace App\Application\IeltsReading;

class QuestionAnswerKeyResolver
{
    public const SHAPE_SUB_QUESTIONS = 'sub_questions';
    public const SHAPE_BLANKS = 'blanks';
    public const SHAPE_PLACEHOLDERS = 'placeholders';
    public const SHAPE_SCALAR = 'scalar';

    /**
     * Types that always render via the placeholders/blanks text-marker mechanism in
     * material.blade.php, regardless of whether a (redundant/unused) sub_questions
     * array is also present in the data blob. Public so other consumers (e.g. content
     * validation) can check "does this type structurally require blanks/placeholders"
     * without re-declaring the list.
     */
    public const BLANKS_FORMAT_TYPES = ['summary_completion', 'sentence_completion', 'table_completion'];

    /**
     * Determine which answer-identifier shape a question actually renders with.
     * This mirrors material.blade.php's @if/@elseif type-dispatch order exactly -
     * it must never diverge from it, since both rendering and scoring depend on
     * agreeing on the same shape for the same question.
     */
    public function classify(array $question): string
    {
        if (!empty($question['blanks'])) {
            return self::SHAPE_BLANKS;
        }

        if (!empty($question['placeholders'])) {
            return self::SHAPE_PLACEHOLDERS;
        }

        if (isset($question['sub_questions']) && is_array($question['sub_questions']) && count($question['sub_questions']) > 0) {
            return self::SHAPE_SUB_QUESTIONS;
        }

        return self::SHAPE_SCALAR;
    }

    /**
     * Resolve a question into a flat [identifier => ['correct' => mixed, 'explanation' => ?string]]
     * map, using whichever identifiers already exist in $question (no rewriting).
     */
    public function resolve(array $question): array
    {
        $correctAnswers = $question['correct_answer'] ?? ($question['data']['correct_answer'] ?? []);
        $explanation = $question['explanation'] ?? null;
        $keys = [];

        switch ($this->classify($question)) {
            case self::SHAPE_SUB_QUESTIONS:
                $isMultiSelect = in_array($question['type'] ?? '', ['multiple_choice_multiple', 'checkbox'], true);
                $allCorrectLetters = [];
                if ($isMultiSelect) {
                    foreach ($question['sub_questions'] as $sub) {
                        $c = $sub['correct_answer'] ?? (is_array($correctAnswers) ? ($correctAnswers[$sub['id'] ?? ''] ?? null) : null);
                        if ($c) {
                            foreach (explode('/', (string)$c) as $letter) {
                                $trimmed = trim($letter);
                                if ($trimmed !== '' && !in_array($trimmed, $allCorrectLetters, true)) {
                                    $allCorrectLetters[] = $trimmed;
                                }
                            }
                        }
                    }
                }

                foreach ($question['sub_questions'] as $sub) {
                    $id = $sub['id'] ?? null;
                    $rawCorrect = $sub['correct_answer'] ?? (is_array($correctAnswers) ? ($correctAnswers[$id] ?? null) : null);
                    $keys[$id] = [
                        'correct' => ($isMultiSelect && count($allCorrectLetters) > 0) ? implode('/', $allCorrectLetters) : $rawCorrect,
                        'explanation' => $explanation,
                    ];
                }
                break;

            case self::SHAPE_BLANKS:
                foreach ($question['blanks'] as $blank) {
                    $id = $blank['id'] ?? null;
                    $keys[$id] = [
                        'correct' => is_array($correctAnswers) ? ($correctAnswers[$id] ?? null) : null,
                        'explanation' => $explanation,
                    ];
                }
                break;

            case self::SHAPE_PLACEHOLDERS:
                foreach ($question['placeholders'] as $id => $qNum) {
                    $keys[$id] = [
                        'correct' => is_array($correctAnswers) ? ($correctAnswers[$id] ?? null) : null,
                        'explanation' => $explanation,
                    ];
                }
                break;

            default:
                $id = $question['id'] ?? ($question['question_number'] ?? null);
                $keys[$id] = [
                    'correct' => $correctAnswers,
                    'explanation' => $explanation,
                ];
        }

        return $keys;
    }
}
