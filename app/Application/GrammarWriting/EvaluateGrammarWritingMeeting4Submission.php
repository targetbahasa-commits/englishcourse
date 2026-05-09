<?php

namespace App\Application\GrammarWriting;

use App\Application\GrammarWriting\Concerns\ScoresWordMatchAnswers;

class EvaluateGrammarWritingMeeting4Submission
{
    use ScoresWordMatchAnswers;

    public function handle(array $questions, string $paragraphAnswer, array $userAnswers, string $correctParagraph): array
    {
        $results = [];
        $totalScore = 0;
        $maxScore = (count($questions) * 10) + 20;

        foreach ($questions as $index => $question) {
            $userTranslation = trim((string) ($userAnswers[$index]['trans'] ?? ''));
            $translationResult = $this->scoreWordMatchAnswer($userTranslation, (string) $question['en'], 10);

            $results[$index] = [
                'user_trans' => $userTranslation,
                'trans_score' => $translationResult['score'],
                'formatted_answer' => $translationResult['formatted_answer'],
            ];

            $totalScore += $translationResult['score'];
        }

        $paragraphResult = $this->evaluateParagraph($paragraphAnswer, $correctParagraph);
        $totalScore += $paragraphResult['score'];

        return [
            'meeting4_submitted' => true,
            'meeting4_results' => $results,
            'meeting4_paragraph_result' => $paragraphResult,
            'meeting4_final_score' => $maxScore > 0 ? round(($totalScore / $maxScore) * 100) : 0,
            'meeting4_user_answers' => $userAnswers,
            'meeting4_user_paragraph_answer' => $paragraphAnswer,
        ];
    }

    private function evaluateParagraph(string $paragraphAnswer, string $correctParagraph): array
    {
        $paragraphResult = $this->scoreWordMatchAnswer($paragraphAnswer, $correctParagraph, 20);

        return [
            'score' => $paragraphResult['score'],
            'max_score' => 20,
            'formatted_answer' => $paragraphResult['formatted_answer'],
        ];
    }
}