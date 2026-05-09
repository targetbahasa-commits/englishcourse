<?php

namespace App\Application\GrammarWriting;

use App\Application\GrammarWriting\Concerns\ScoresWordMatchAnswers;

class EvaluateGrammarWritingMeeting9Submission
{
    use ScoresWordMatchAnswers;

    public function handle(string $userParagraphAnswer, string $correctText): array
    {
        $paragraphResult = $this->scoreWordMatchAnswer($userParagraphAnswer, $correctText, 100);

        return [
            'meeting9_submitted' => true,
            'meeting9_results' => [],
            'meeting9_paragraph_result' => [
                'score' => $paragraphResult['score'],
                'max_score' => 100,
                'formatted_answer' => $paragraphResult['formatted_answer'],
            ],
            'meeting9_final_score' => $paragraphResult['score'],
            'meeting9_user_answers' => [],
            'meeting9_user_paragraph_answer' => $userParagraphAnswer,
        ];
    }
}