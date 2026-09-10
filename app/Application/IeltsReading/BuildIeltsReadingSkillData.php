<?php

namespace App\Application\IeltsReading;

use App\Domain\IeltsReading\Repositories\IeltsReadingRepository;

class BuildIeltsReadingSkillData
{
    public function __construct(
        private readonly IeltsReadingRepository $repository,
        private readonly QuestionAnswerKeyResolver $answerKeyResolver,
    ) {}

    private const SKILL_TYPES = [
        'matching-headings' => ['matching_headings'],
        'multiple-choice' => ['multiple_choice', 'multiple_choice_multiple', 'checkbox'],
        'short-answer' => ['short_answer', 'short_answer_group'],
        'name-matching' => ['matching_features'],
        'true-false-not-given' => ['true_false_not_given', 'true_false'],
        'yes-no-not-given' => ['yes_no_not_given'],
        'summary-completion' => ['summary_completion'],
        'matching-sentence-endings' => ['matching_sentence_endings'],
        'sentence-completion' => ['sentence_completion'],
        'matching-paragraph-info' => ['matching_paragraph_information'],
        'table-completion' => ['table_completion'],
        'diagram-labelling' => ['diagram_labelling'],
    ];

    private const SKILL_TITLES = [
        'matching-headings' => 'Matching Headings',
        'multiple-choice' => 'Multiple Choice',
        'short-answer' => 'Short Answer',
        'name-matching' => 'Name Matching',
        'true-false-not-given' => 'True / False / Not Given',
        'yes-no-not-given' => 'Yes / No / Not Given',
        'summary-completion' => 'Summary Completion',
        'matching-sentence-endings' => 'Matching Sentence Endings',
        'sentence-completion' => 'Sentence Completion',
        'matching-paragraph-info' => 'Matching Paragraph Info',
        'table-completion' => 'Table Completion',
        'diagram-labelling' => 'Diagram Labelling',
    ];

    public function handle(string $skill): ?array
    {
        if (!array_key_exists($skill, self::SKILL_TYPES)) {
            return null;
        }

        $questions = collect($this->repository->getQuestionsByType(self::SKILL_TYPES[$skill]))
            ->filter(fn ($question) => $question->passage !== null);

        $content = $questions->groupBy('passage_id')->map(function ($questionsInPassage) {
            $passage = $questionsInPassage->first()->passage;
            $builtQuestions = $questionsInPassage->map(fn ($question) => $this->buildQuestion($question))
                ->filter()
                ->values()->toArray();

            if (empty($builtQuestions)) {
                return null;
            }

            return [
                'id' => $passage->id,
                'passage_title' => $passage->title,
                'passage_text' => $passage->content,
                'questions' => $builtQuestions,
            ];
        })->filter()->values()->toArray();

        return [
            'title' => self::SKILL_TITLES[$skill],
            'id' => 0,
            'content' => $content,
            'isSkillView' => true,
        ];
    }

    private function buildQuestion($question): ?array
    {
        $dataArray = is_array($question->data) ? $question->data : (json_decode($question->data ?? '', true) ?? []);
        $prefix = 'sk' . $question->id . '_';

        $questionData = [
            'id' => $prefix . $question->question_number,
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

        $originalCorrectAnswer = is_array($question->correct_answer) ? $question->correct_answer : [];

        // Delegate shape classification to the same resolver material.blade.php uses for
        // scoring, so rendering and scoring can never drift out of sync again.
        $shape = $this->answerKeyResolver->classify($questionData);
        // Whether this question's TYPE structurally requires the blanks/placeholders
        // format - independent of $shape, which reflects what data actually exists.
        // Used below to detect mislabeled content (type says blanks-format, but
        // neither field is actually populated).
        $requiresBlanksFormatType = in_array($question->type, QuestionAnswerKeyResolver::BLANKS_FORMAT_TYPES, true);

        if ($shape === QuestionAnswerKeyResolver::SHAPE_SUB_QUESTIONS) {
            $newCorrectMap = [];
            $newSubQuestions = [];

            foreach ($questionData['sub_questions'] as $sub) {
                $oldId = $sub['id'] ?? null;
                $newId = $prefix . $oldId;
                $sub['id'] = $newId;
                $newSubQuestions[] = $sub;
                $newCorrectMap[$newId] = $sub['correct_answer'] ?? ($originalCorrectAnswer[$oldId] ?? null);
            }

            $questionData['sub_questions'] = $newSubQuestions;
            $questionData['correct_answer'] = $newCorrectMap;
        } elseif (in_array($shape, [QuestionAnswerKeyResolver::SHAPE_BLANKS, QuestionAnswerKeyResolver::SHAPE_PLACEHOLDERS], true)) {
            $keyMap = [];
            $qNumsSeen = [];
            $newCorrectMap = [];

            if (!empty($questionData['placeholders'])) {
                $newPlaceholders = [];
                foreach ($questionData['placeholders'] as $oldKey => $qNum) {
                    $newKey = $prefix . $oldKey;
                    $keyMap[$oldKey] = $newKey;
                    $keyMap[$qNum] = $newKey;
                    $qNumsSeen[] = $qNum;
                    $newPlaceholders[$newKey] = $qNum;
                    $newCorrectMap[$newKey] = $originalCorrectAnswer[$oldKey] ?? null;
                }
                $questionData['placeholders'] = $newPlaceholders;
            }

            if (!empty($questionData['blanks'])) {
                $newBlanks = [];
                foreach ($questionData['blanks'] as $blank) {
                    $oldId = $blank['id'] ?? null;
                    $qNum = $blank['blank_number'] ?? null;
                    $newId = $prefix . $oldId;
                    $keyMap[$oldId] = $newId;
                    if ($qNum !== null) {
                        $keyMap[$qNum] = $newId;
                        $qNumsSeen[] = $qNum;
                    }
                    $blank['id'] = $newId;
                    $newBlanks[] = $blank;
                    $newCorrectMap[$newId] = $originalCorrectAnswer[$oldId] ?? null;
                }
                $questionData['blanks'] = $newBlanks;
            }

            $markersFound = 0;
            $textToScan = ($questionData['summary_text'] ?? '') . ' ' . ($questionData['text'] ?? '');
            if (!empty($questionData['rows'])) {
                foreach ($questionData['rows'] as $row) {
                    $textToScan .= ' ' . implode(' ', $row);
                }
            }

            foreach (['summary_text', 'text'] as $textField) {
                if (!empty($questionData[$textField])) {
                    $questionData[$textField] = $this->rewriteMarkers($questionData[$textField], $keyMap, $markersFound);
                }
            }

            if (!empty($questionData['rows'])) {
                $questionData['rows'] = array_map(
                    fn ($row) => array_map(fn ($cell) => $this->rewriteMarkers($cell, $keyMap, $markersFound), $row),
                    $questionData['rows']
                );
            }

            // The view also supports a fallback where the text has no [bracket] marker
            // at all, but instead has the raw question number directly followed by a
            // run of dots/ellipsis (e.g. "17……………") - mirror that same detection here
            // so this defensive check doesn't wrongly treat renderable content as unusable.
            if ($markersFound === 0) {
                foreach (array_unique($qNumsSeen) as $qNum) {
                    if (preg_match('/' . preg_quote((string) $qNum, '/') . '[\s.\x{2026}_]{2,}/u', $textToScan)) {
                        $markersFound++;
                    }
                }
            }

            $questionData['correct_answer'] = $newCorrectMap;

            // Some rows declare placeholders/blanks but the referenced text has no
            // marker at all to attach an input to (content-authoring gap - the answer
            // is nowhere for a student to actually type into). Treat these the same as
            // the "no placeholders/blanks at all" case below.
            if ($markersFound === 0) {
                return null;
            }
        }

        // Defensive guard: some rows in the corpus are mislabeled (type doesn't match
        // the actual data shape, e.g. table_completion with no columns/rows/placeholders
        // at all - a pre-existing content-authoring gap). Rendering these would show a
        // question with no way to answer it at all, so skip them here rather than
        // present broken/unanswerable content.
        if ($requiresBlanksFormatType && empty($questionData['placeholders']) && empty($questionData['blanks'])) {
            return null;
        }

        return $questionData;
    }

    private function rewriteMarkers(string $text, array $keyMap, int &$markersFound = 0): string
    {
        foreach ($keyMap as $oldKey => $newKey) {
            $needle = '[' . $oldKey . ']';
            $count = substr_count($text, $needle);
            if ($count > 0) {
                $markersFound += $count;
                $text = str_replace($needle, '[' . $newKey . ']', $text);
            }
        }

        return $text;
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
