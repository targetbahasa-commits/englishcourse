<?php

namespace App\Application\GrammarWriting;

use App\Application\GrammarWriting\Concerns\ScoresWordMatchAnswers;
use Illuminate\Support\Collection;

class EvaluateGrammarWritingMeeting12Submission
{
    use ScoresWordMatchAnswers;

    public function handle(Collection $questions, string $correctParagraph, array $userAnswers, string $userParagraphAnswer): array
    {
        $results = [];
        $totalScore = 0;
        $maxScore = ($questions->count() * 10) + 20;

        foreach ($questions->values() as $index => $question) {
            $userTranslation = trim((string) ($userAnswers[$index] ?? ''));
            $result = $this->scoreWordMatchAnswer($userTranslation, (string) $question['en'], 10);

            $results[$index] = $result + ['correct_answer' => $question['en']];
            $totalScore += $result['score'];
        }

        $paragraphResult = $this->scoreWordMatchAnswer($userParagraphAnswer, $correctParagraph, 20);
        $totalScore += $paragraphResult['score'];

        return [
            'meeting12_submitted' => true,
            'meeting12_results' => $results,
            'meeting12_paragraph_result' => [
                'score' => $paragraphResult['score'],
                'max_score' => 20,
                'formatted_answer' => $paragraphResult['formatted_answer'],
            ],
            'meeting12_final_score' => $maxScore > 0 ? round(($totalScore / $maxScore) * 100) : 0,
            'meeting12_user_answers' => $userAnswers,
            'meeting12_user_paragraph_answer' => $userParagraphAnswer,
        ];
    }
}