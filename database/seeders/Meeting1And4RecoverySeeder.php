<?php

namespace Database\Seeders;

use App\Http\Controllers\AssignmentController;
use App\Models\GrammarQuestion;
use App\Models\GrammarVocabulary;
use Illuminate\Database\Seeder;

class Meeting1And4RecoverySeeder extends Seeder
{
    public function run(): void
    {
        $controller = app(AssignmentController::class);

        $this->seedMeeting1($controller);
        $this->seedMeeting4($controller);
    }

    private function seedMeeting1(AssignmentController $controller): void
    {
        $questionsCount = GrammarQuestion::where('meeting_number', 1)
            ->where(function ($q) {
                $q->whereNull('section')
                    ->orWhere('section', '!=', 'paragraph');
            })
            ->count();

        if ($questionsCount === 0) {
            $questions = $this->getPrivateProperty($controller, 'meeting1FallbackQuestions');
            foreach ($questions as $number => $q) {
                GrammarQuestion::create([
                    'meeting_number' => 1,
                    'section' => 'sentences',
                    'question_number' => (int) $number,
                    'question_text' => $q['id'],
                    'correct_answer' => $q['en'],
                    'example_id' => $q['example']['id'] ?? null,
                    'example_en' => $q['example']['en'] ?? null,
                    'vocab' => $q['vocab'] ?? [],
                ]);
            }
        }

        $paragraphCount = GrammarQuestion::where('meeting_number', 1)
            ->where('section', 'paragraph')
            ->count();

        if ($paragraphCount === 0) {
            $paragraph = $this->getPrivateProperty($controller, 'meeting1Paragraph');
            GrammarQuestion::create([
                'meeting_number' => 1,
                'section' => 'paragraph',
                'question_number' => 999,
                'question_text' => $paragraph['id'],
                'correct_answer' => $paragraph['en'],
                'vocab' => [],
            ]);
        }

        if (GrammarVocabulary::where('meeting_number', 1)->count() === 0) {
            $vocab = $this->getPrivateProperty($controller, 'meeting1FallbackVocab');
            foreach ($vocab as $word => $meta) {
                GrammarVocabulary::create([
                    'meeting_number' => 1,
                    'section' => 'global',
                    'word' => (string) $word,
                    'translation' => (string) ($meta['id'] ?? ''),
                    'pos' => (string) ($meta['pos'] ?? 'general'),
                ]);
            }
        }

        $this->command?->line('Meeting 1 recovery seeding complete.');
    }

    private function seedMeeting4(AssignmentController $controller): void
    {
        $questionsCount = GrammarQuestion::where('meeting_number', 4)
            ->where(function ($q) {
                $q->whereNull('section')
                    ->orWhere('section', '!=', 'paragraph');
            })
            ->count();

        if ($questionsCount === 0) {
            $questions = $this->getPrivateProperty($controller, 'meeting4Questions');
            foreach ($questions as $number => $q) {
                GrammarQuestion::create([
                    'meeting_number' => 4,
                    'section' => 'sentences',
                    'question_number' => (int) $number,
                    'question_text' => $q['id'],
                    'correct_answer' => $q['en'],
                    'vocab' => $q['vocab'] ?? [],
                ]);
            }
        }

        $paragraphCount = GrammarQuestion::where('meeting_number', 4)
            ->where('section', 'paragraph')
            ->count();

        if ($paragraphCount === 0) {
            $paragraph = $this->getPrivateProperty($controller, 'meeting4Paragraph');
            GrammarQuestion::create([
                'meeting_number' => 4,
                'section' => 'paragraph',
                'question_number' => 999,
                'question_text' => $paragraph['id'],
                'correct_answer' => $paragraph['en'],
                'vocab' => $paragraph['vocab'] ?? [],
            ]);
        }

        $this->command?->line('Meeting 4 recovery seeding complete.');
    }

    private function getPrivateProperty(object $object, string $propertyName)
    {
        $reflection = new \ReflectionClass($object);
        $property = $reflection->getProperty($propertyName);
        $property->setAccessible(true);

        return $property->getValue($object);
    }
}
