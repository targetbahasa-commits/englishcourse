<?php

namespace App\Application\GrammarWriting;

use App\Application\GrammarWriting\Concerns\ScoresWordMatchAnswers;

class EvaluateGrammarWritingMeeting16Submission
{
    use ScoresWordMatchAnswers;

    public function handle(string $correctParagraph, string $userParagraphAnswer): array
    {
        $paragraphResult = $this->scoreWordMatchAnswer($userParagraphAnswer, $correctParagraph, 100);

        return [
            'meeting16_submitted' => true,
            'meeting16_results' => [],
            'meeting16_paragraph_result' => [
                'score' => $paragraphResult['score'],
                'max_score' => 100,
                'formatted_answer' => $paragraphResult['formatted_answer'],
            ],
            'meeting16_final_score' => $paragraphResult['score'],
            'meeting16_user_answers' => [],
            'meeting16_user_paragraph_answer' => $userParagraphAnswer,
        ];
    }
}