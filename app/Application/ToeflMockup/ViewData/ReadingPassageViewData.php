<?php

namespace App\Application\ToeflMockup\ViewData;

class ReadingPassageViewData
{
    /**
     * @param array<int, array<string, mixed>> $questions
     * @param array<int, string> $lineMarkers
     */
    public function __construct(
        public readonly int $passageNumber,
        public readonly string $sectionTitle,
        public readonly string $content,
        public readonly array $lineMarkers,
        public readonly array $questions,
    ) {
    }

    public static function fromModel(object $passage): self
    {
        $questions = collect($passage->questions)->map(
            fn (object $question) => \App\Application\ToeflMockup\ViewData\MockupQuestionViewData::fromModel($question)->toArray()
        )->values()->all();

        $startQuestion = $questions[0]['question_number'] ?? 1;
        $endQuestion = $questions[count($questions) - 1]['question_number'] ?? 10;

        $formattedContent = collect(explode("\n\n", trim((string) $passage->content)))
            ->map(fn($p) => '<p class="mockup-passage-paragraph">' . trim($p) . '</p>')
            ->implode('');

        return new self(
            passageNumber: (int) $passage->passage_number,
            sectionTitle: "Questions {$startQuestion}-{$endQuestion}",
            content: $formattedContent,
            lineMarkers: ['Line', '(5)', '(10)', '(15)', '(20)', '(25)', '(30)'],
            questions: $questions,
        );
    }

    public function toArray(): array
    {
        return [
            'passage_number' => $this->passageNumber,
            'section_title' => $this->sectionTitle,
            'content' => $this->content,
            'line_markers' => $this->lineMarkers,
            'questions' => $this->questions,
        ];
    }
}