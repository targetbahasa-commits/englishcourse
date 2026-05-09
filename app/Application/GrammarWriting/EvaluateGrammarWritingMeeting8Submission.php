<?php

namespace App\Application\GrammarWriting;

use App\Application\GrammarWriting\Concerns\ScoresWordMatchAnswers;

class EvaluateGrammarWritingMeeting8Submission
{
    use ScoresWordMatchAnswers;

    public function handle(array $questions, array $paragraph, array $userAnswers, string $userParagraphAnswer): array
    {
        $results = [];
        $questionTotalScore = 0;
        $totalItems = count($questions);

        foreach ($questions as $index => $question) {
            $userTranslation = trim((string) ($userAnswers[$index] ?? ''));
            $result = $this->scoreWordMatchAnswer($userTranslation, (string) $question['en'], 10);

            $results[$index] = $result + ['correct_answer' => $question['en']];
            $questionTotalScore += ($result['score'] * 10);
        }

        $averageQuestionScore = $totalItems > 0 ? ($questionTotalScore / $totalItems) : 0;
        $paragraphResult = $this->scoreWordMatchAnswer($userParagraphAnswer, (string) ($paragraph['en'] ?? ''), 100);
        $finalScore = round(($averageQuestionScore * 0.8) + ($paragraphResult['score'] * 0.2));

        return [
            'meeting8_submitted' => true,
            'meeting8_results' => $results,
            'meeting8_paragraph_result' => [
                'score' => $paragraphResult['score'],
                'max_score' => 100,
                'formatted_answer' => $paragraphResult['formatted_answer'],
            ],
            'meeting8_final_score' => $finalScore,
            'meeting8_user_answers' => $userAnswers,
            'meeting8_user_paragraph_answer' => $userParagraphAnswer,
        ];
    }
}