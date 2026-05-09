<?php

namespace App\Application\GrammarWriting;

use App\Application\GrammarWriting\Concerns\ScoresWordMatchAnswers;

class EvaluateGrammarWritingMeeting20Submission
{
    use ScoresWordMatchAnswers;

    public function handle(string $correctParagraph, string $userParagraphAnswer): array
    {
        $paragraphResult = $this->scoreWordMatchAnswer($userParagraphAnswer, $correctParagraph, 100, '.,!');

        return [
            'meeting20_submitted' => true,
            'meeting20_user_paragraph_answer' => $userParagraphAnswer,
            'meeting20_paragraph_result' => [
                'score' => $paragraphResult['score'],
                'max_score' => 100,
                'formatted_answer' => $paragraphResult['formatted_answer'],
            ],
            'meeting20_final_score' => $paragraphResult['score'],
        ];
    }
}