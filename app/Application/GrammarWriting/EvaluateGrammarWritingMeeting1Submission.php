<?php

namespace App\Application\GrammarWriting;

use App\Application\GrammarWriting\Concerns\ScoresWordMatchAnswers;
use Illuminate\Support\Collection;

class EvaluateGrammarWritingMeeting1Submission
{
    use ScoresWordMatchAnswers;

    public function handle(Collection $questions, array $input, array $paragraphReference): array
    {
        $score = 0;
        $results = [];

        foreach ($questions as $question) {
            $index = $question->question_number;
            $userAnswer = trim((string) ($input['q' . $index] ?? ''));

            [$questionScore, $formattedAnswer] = $this->evaluateSentenceAnswer($userAnswer, (string) $question->correct_answer);

            $score += $questionScore;

            $results[$index] = [
                'user_answer' => $userAnswer,
                'formatted_answer' => $formattedAnswer,
                'score' => $questionScore,
                'correct_answer' => $question->correct_answer,
            ];
        }

        $paragraphResult = $this->evaluateParagraphAnswer(
            trim((string) ($input['paragraph_ans'] ?? '')),
            (string) $paragraphReference['en'],
        );

        $score += $paragraphResult['score'];

        $maxRawScore = ($questions->count() * 10) + 50;

        return [
            'results' => $results,
            'paragraphResult' => $paragraphResult,
            'finalScore' => $maxRawScore > 0 ? round(($score / $maxRawScore) * 100, 1) : 0,
        ];
    }

    private function evaluateSentenceAnswer(string $userAnswer, string $correctAnswer): array
    {
        $bestScore = -1;
        $bestFormattedAnswer = '';

        foreach (explode('|', $correctAnswer) as $variant) {
            $variant = trim($variant);
            $cleanUser = strtolower(rtrim($userAnswer, '.!'));
            $cleanCorrect = strtolower(rtrim($variant, '.!'));

            $percent = 0;
            similar_text($cleanUser, $cleanCorrect, $percent);
            $questionScore = round($percent / 10, 1);

            if ($questionScore > $bestScore) {
                $bestScore = $questionScore;
                $bestFormattedAnswer = $this->formatWordMatchDiff(
                    explode(' ', $userAnswer),
                    explode(' ', $variant),
                );
            }
        }

        return [max(0, $bestScore), $bestFormattedAnswer];
    }

    private function evaluateParagraphAnswer(string $userParagraph, string $correctParagraph): array
    {
        $cleanUser = strtolower(rtrim($userParagraph, '.!'));
        $cleanCorrect = strtolower(rtrim($correctParagraph, '.!'));

        $percent = 0;
        similar_text($cleanUser, $cleanCorrect, $percent);

        return [
            'user_answer' => $userParagraph,
            'formatted_answer' => $this->formatWordMatchDiff(explode(' ', $userParagraph), explode(' ', $correctParagraph)),
            'score' => round(($percent / 100) * 50, 1),
            'correct_answer' => $correctParagraph,
        ];
    }
}