<?php

namespace App\Application\ToeflMockup\ViewData;

class MockupQuestionViewData
{
    public function __construct(
        public readonly int $id,
        public readonly int $question_number,
        public readonly ?string $question_text,
        public readonly ?string $option_a,
        public readonly ?string $option_b,
        public readonly ?string $option_c,
        public readonly ?string $option_d,
        public readonly ?string $correct_answer,
        public readonly ?string $part,
        public readonly ?string $audio_file,
        public readonly ?string $transcript_en,
        public readonly ?string $transcript_id,
    ) {
    }

    public static function fromModel(object $question): self
    {
        return new self(
            id: (int) $question->id,
            question_number: (int) $question->question_number,
            question_text: $question->question_text,
            option_a: $question->option_a,
            option_b: $question->option_b,
            option_c: $question->option_c,
            option_d: $question->option_d,
            correct_answer: $question->correct_answer,
            part: $question->part,
            audio_file: $question->audio_file,
            transcript_en: $question->transcript_en,
            transcript_id: $question->transcript_id,
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'question_number' => $this->question_number,
            'question_text' => $this->question_text,
            'option_a' => $this->option_a,
            'option_b' => $this->option_b,
            'option_c' => $this->option_c,
            'option_d' => $this->option_d,
            'correct_answer' => $this->correct_answer,
            'part' => $this->part,
            'audio_file' => $this->audio_file,
            'transcript_en' => $this->transcript_en,
            'transcript_id' => $this->transcript_id,
        ];
    }
}