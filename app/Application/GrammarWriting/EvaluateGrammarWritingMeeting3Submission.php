<?php

namespace App\Application\GrammarWriting;

use App\Application\GrammarWriting\Concerns\ScoresWordMatchAnswers;

class EvaluateGrammarWritingMeeting3Submission
{
    use ScoresWordMatchAnswers;

    public function handle(mixed $questions, string $paragraphAnswer, array $userAnswers, string $correctParagraph): array
    {
        $results = [];
        $totalScore = 0;
        $answeredCount = 0;
        $questionArray = is_array($questions) ? $questions : (method_exists($questions, 'toArray') ? $questions->toArray() : (array) $questions);

        foreach ($questionArray as $question) {
            // Keyed by the question's own question_number, NOT the loop
            // position - the form posts userAnswers[<question_number>][trans]
            // (see meeting3.blade.php's `name="userAnswers[{{ $data['q_num'] }}]..."`)
            // and question_number is 1-based, so using the 0-based loop
            // index here silently read every answer shifted by one question
            // (and dropped the last question's answer entirely) for as long
            // as this existed - only ever invisible before because the old
            // "must answer all 20" gate meant the misaligned score still
            // landed somewhere.
            $questionNumber = is_array($question) ? (int) ($question['q_num'] ?? $question['question_number'] ?? 0) : (int) ($question->question_number ?? 0);
            $rawAnswer = $userAnswers[$questionNumber] ?? '';
            $userTranslation = is_array($rawAnswer)
                ? trim((string) ($rawAnswer['trans'] ?? ''))
                : trim((string) $rawAnswer);

            // Not attempted - excluded from scoring entirely (never counted
            // toward maxScore below), not marked wrong. "Cek Jawaban" can
            // be used on a partial attempt, so an unanswered question isn't
            // the student's fault the way a wrong answer is.
            if ($userTranslation === '') {
                $results[$questionNumber] = [
                    'user_trans' => '',
                    'trans_score' => null,
                    'formatted_answer' => null,
                    'answered' => false,
                ];
                continue;
            }

            // 'correct_answer' is the real column/property name on both
            // shapes $question can take here - DB-sourced GrammarQuestion
            // models come through as plain arrays via the Collection
            // ->toArray() above (Eloquent models implement Arrayable), and
            // the fallback-question path already normalizes to that same
            // property in loadLegacyQuestionModels()'s mapper. Checking
            // 'en' first (as this used to) never matches anything on
            // either shape, so it silently scored every translation
            // against an empty string - 0/10, every word marked wrong,
            // regardless of what the student typed.
            $correctEn = is_array($question) ? ($question['correct_answer'] ?? '') : ($question->correct_answer ?? '');
            $translationResult = $this->scoreWordMatchAnswer($userTranslation, (string) $correctEn, 10);

            $results[$questionNumber] = [
                'user_trans' => $userTranslation,
                'trans_score' => $translationResult['score'],
                'formatted_answer' => $translationResult['formatted_answer'],
                'answered' => true,
            ];

            $totalScore += $translationResult['score'];
            $answeredCount++;
        }

        $paragraphAnswered = trim($paragraphAnswer) !== '';
        $paragraphResult = $paragraphAnswered
            ? $this->evaluateParagraph($paragraphAnswer, $correctParagraph)
            : ['score' => null, 'max_score' => 20, 'formatted_answer' => null, 'answered' => false];

        if ($paragraphAnswered) {
            $totalScore += $paragraphResult['score'];
        }

        $maxScore = ($answeredCount * 10) + ($paragraphAnswered ? 20 : 0);

        return [
            'meeting3_submitted' => true,
            'meeting3_results' => $results,
            'meeting3_paragraph_result' => $paragraphResult,
            'meeting3_final_score' => $maxScore > 0 ? round(($totalScore / $maxScore) * 100) : 0,
            'meeting3_user_answers' => $userAnswers,
            'meeting3_user_paragraph_answer' => $paragraphAnswer,
        ];
    }

    private function evaluateParagraph(string $paragraphAnswer, string $correctParagraph): array
    {
        $paragraphResult = $this->scoreWordMatchAnswer($paragraphAnswer, $correctParagraph, 20);

        return [
            'score' => $paragraphResult['score'],
            'max_score' => 20,
            'formatted_answer' => $paragraphResult['formatted_answer'],
            'answered' => true,
        ];
    }
}