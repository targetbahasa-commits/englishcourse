<?php

namespace App\Application\PlacementTest;

use App\Models\PlacementListeningQuestion;
use App\Models\PlacementReadingQuestion;
use App\Models\PlacementTestResult;

class SubmitPlacementSectionAnswers
{
    public function submitReading(PlacementTestResult $result, array $answers): void
    {
        $this->submitMcq($result, 'reading', $answers, PlacementReadingQuestion::class);
    }

    public function submitListening(PlacementTestResult $result, array $answers): void
    {
        $this->submitMcq($result, 'listening', $answers, PlacementListeningQuestion::class);
    }

    public function submitWriting(PlacementTestResult $result, int $promptId, string $essay): void
    {
        $data = $result->answers_data ?? [];
        $data['writing'] = ['prompt_id' => $promptId, 'essay' => $essay];
        $result->update(['answers_data' => $data]);
    }

    public function submitSpeaking(PlacementTestResult $result, int $promptId, string $audioPath): void
    {
        $data = $result->answers_data ?? [];
        $data['speaking'] = ['prompt_id' => $promptId, 'audio_path' => $audioPath];
        $result->update(['answers_data' => $data]);
    }

    /**
     * @param class-string<PlacementReadingQuestion|PlacementListeningQuestion> $questionModel
     */
    private function submitMcq(PlacementTestResult $result, string $skill, array $answers, string $questionModel): void
    {
        $questionIds = array_map('intval', array_keys($answers));
        $questions = $questionModel::whereIn('id', $questionIds)->get()->keyBy('id');

        $correct = 0;
        foreach ($answers as $questionId => $selected) {
            $question = $questions->get((int) $questionId);
            if ($question && strtoupper((string) $selected) === strtoupper((string) $question->correct_answer)) {
                $correct++;
            }
        }

        $total = count($answers);
        $percent = $total > 0 ? round(($correct / $total) * 100, 2) : 0;

        $data = $result->answers_data ?? [];
        $data[$skill] = [
            'answers' => $answers,
            'correct' => $correct,
            'total' => $total,
        ];

        $result->update([
            'answers_data' => $data,
            $skill . '_score' => $percent,
        ]);
    }
}
