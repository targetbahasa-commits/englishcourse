<?php

namespace App\Console\Commands;

use App\Application\IeltsReading\QuestionAnswerKeyResolver;
use App\Models\IeltsReadingQuestion;
use Illuminate\Console\Command;

class AuditIeltsReadingData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ielts:reading-data-audit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Report IELTS Reading question rows where the stored type does not match the actual data shape (read-only, does not modify anything)';

    public function handle(QuestionAnswerKeyResolver $resolver): int
    {
        $rows = [];

        IeltsReadingQuestion::with('passage')->chunk(200, function ($questions) use (&$rows, $resolver) {
            foreach ($questions as $question) {
                $problem = $this->diagnose($question, $resolver);
                if ($problem !== null) {
                    $rows[] = [
                        $question->id,
                        $question->passage?->material_id ?? '—',
                        $question->passage?->title ?? '(orphaned)',
                        $question->type,
                        $problem,
                    ];
                }
            }
        });

        if (empty($rows)) {
            $this->info('No mismatched rows found.');

            return self::SUCCESS;
        }

        $this->table(['id', 'material_id', 'passage', 'type', 'problem'], $rows);
        $this->newLine();
        $this->warn(count($rows) . ' row(s) flagged. This is a read-only report - fix content via the existing admin editor.');

        return self::SUCCESS;
    }

    private function diagnose(IeltsReadingQuestion $question, QuestionAnswerKeyResolver $resolver): ?string
    {
        $data = is_array($question->data) ? $question->data : (json_decode($question->data ?? '', true) ?? []);
        $merged = array_merge(['type' => $question->type], $data);

        $requiresBlanksFormat = in_array($question->type, QuestionAnswerKeyResolver::BLANKS_FORMAT_TYPES, true);

        if ($requiresBlanksFormat) {
            if (empty($merged['placeholders']) && empty($merged['blanks'])) {
                return "type requires placeholders/blanks but neither is present in data (found: " . implode(',', array_keys($data)) . ')';
            }

            $text = ($merged['summary_text'] ?? '') . ' ' . ($merged['text'] ?? '');
            if (!empty($merged['rows'])) {
                foreach ($merged['rows'] as $row) {
                    $text .= ' ' . implode(' ', $row);
                }
            }

            if (!$this->hasAnyMarker($merged, $text) && !$this->coveredBySubQuestionFallback($merged)) {
                return 'has placeholders/blanks declared, but no [bracket] or "number+dots" marker found in the text/rows - nothing for a student to fill in';
            }

            return null;
        }

        $shape = $resolver->classify($merged);
        if ($shape === QuestionAnswerKeyResolver::SHAPE_SUB_QUESTIONS) {
            return null;
        }

        $correctAnswer = $question->correct_answer;
        $isEmpty = $correctAnswer === null || $correctAnswer === '' || $correctAnswer === [];
        if ($isEmpty) {
            return 'scalar/no-sub-question type with no correct_answer at all (content gap)';
        }

        return null;
    }

    private function hasAnyMarker(array $merged, string $text): bool
    {
        $qNums = [];
        foreach ($merged['placeholders'] ?? [] as $key => $qNum) {
            $qNums[] = $key;
            $qNums[] = $qNum;
        }
        foreach ($merged['blanks'] ?? [] as $blank) {
            $qNums[] = $blank['id'] ?? null;
            $qNums[] = $blank['blank_number'] ?? null;
        }

        foreach (array_unique(array_filter($qNums, fn ($v) => $v !== null)) as $marker) {
            if (str_contains($text, '[' . $marker . ']')) {
                return true;
            }
            if (preg_match('/' . preg_quote((string) $marker, '/') . '[\s.\x{2026}_]{2,}/u', $text)) {
                return true;
            }
        }

        return false;
    }

    /**
     * summary-sentence-completion.blade.php falls back to rendering each
     * sub_question as a standalone labelled list item (with its own input)
     * when no inline marker exists for it in the text - as long as that
     * sub_question has both a real label and a real answer. Mirrors the
     * `$unresolvedListItems` logic in that partial exactly.
     */
    private function coveredBySubQuestionFallback(array $merged): bool
    {
        if (empty($merged['placeholders']) || empty($merged['sub_questions'])) {
            return false;
        }

        $subQuestions = [];
        foreach ($merged['sub_questions'] as $sq) {
            if (!empty($sq['id']) && !empty($sq['label']) && isset($sq['correct_answer']) && $sq['correct_answer'] !== '') {
                $subQuestions[$sq['id']] = true;
            }
        }

        foreach (array_keys($merged['placeholders']) as $key) {
            if (!isset($subQuestions[$key])) {
                return false;
            }
        }

        return true;
    }
}
