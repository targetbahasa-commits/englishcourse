<?php

namespace App\Application\GrammarWriting;

use App\Application\GrammarWriting\Concerns\ScoresWordMatchAnswers;

class EvaluateGrammarWritingMeeting17Submission
{
    use ScoresWordMatchAnswers;

    public function handle(array $questions, string $correctParagraph, array $userAnswers, string $userParagraphAnswer): array
    {
        $results = [];
        $totalScore = 0;
        $maxScore = (count($questions) * 10) + 20;

        foreach ($questions as $index => $question) {
            $userTranslation = trim((string) ($userAnswers[$index] ?? ''));
            $result = $this->scoreWordMatchAnswer($userTranslation, (string) $question['en'], 10);

            $results[$index] = $result + ['correct_answer' => $question['en']];
            $totalScore += $result['score'];
        }

        $paragraphResult = $this->scoreWordMatchAnswer($userParagraphAnswer, $correctParagraph, 20);
        $totalScore += $paragraphResult['score'];

        return [
            'meeting17_submitted' => true,
            'meeting17_results' => $results,
            'meeting17_paragraph_result' => [
                'score' => $paragraphResult['score'],
                'max_score' => 20,
                'formatted_answer' => $paragraphResult['formatted_answer'],
            ],
            'meeting17_final_score' => $maxScore > 0 ? round(($totalScore / $maxScore) * 100) : 0,
            'meeting17_user_answers' => $userAnswers,
            'meeting17_user_paragraph_answer' => $userParagraphAnswer,
        ];
    }
}