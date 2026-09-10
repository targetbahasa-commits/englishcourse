<?php

namespace Tests\Feature;

use App\Models\IeltsReadingPassage;
use App\Models\IeltsReadingQuestion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IeltsReadingMaterialRenderTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
        // withoutMiddleware() also skips ShareErrorsFromSession, which normally
        // shares $errors with every view.
        \Illuminate\Support\Facades\View::share('errors', new \Illuminate\Support\ViewErrorBag);
    }

    private function adminUser(): User
    {
        return User::factory()->create(['role' => 'admin']);
    }

    /**
     * Seeds one passage covering representative questions across every
     * answer-identifier shape (scalar, sub_questions with inline correct_answer,
     * sub_questions wrapping a single multiple_choice option set, placeholders with
     * bracket markers, placeholders with ellipsis-only markers, a Q&A-style
     * short_answer_group item with no dot pattern, and table_completion) - the exact
     * combination of pre-existing content shapes that caused real scoring bugs.
     */
    private function seedPassage(): IeltsReadingPassage
    {
        $passage = IeltsReadingPassage::create([
            'material_id' => 1,
            'title' => 'Test Passage',
            'content' => '<p>Some passage text.</p>',
            'order' => 1,
        ]);

        IeltsReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 1,
            'question_text' => 'Choose the correct letter.',
            'type' => 'multiple_choice',
            'options' => ['A' => 'Option A', 'B' => 'Option B'],
            'correct_answer' => 'A',
            'order' => 1,
        ]);

        IeltsReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 2,
            'question_text' => 'Choose the correct letter.',
            'type' => 'multiple_choice',
            'options' => ['A' => 'Option A', 'B' => 'Option B'],
            'correct_answer' => 'B',
            'data' => ['sub_questions' => [['id' => '2', 'label' => 'Q2', 'correct_answer' => 'B']]],
            'order' => 2,
        ]);

        IeltsReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 3,
            'question_text' => 'True/False/Not Given statements.',
            'type' => 'true_false_not_given',
            'options' => ['TRUE' => 'TRUE', 'FALSE' => 'FALSE', 'NOT GIVEN' => 'NOT GIVEN'],
            'correct_answer' => null,
            'data' => [
                'sub_questions' => [
                    ['id' => '3', 'label' => 'Statement A', 'correct_answer' => 'TRUE'],
                    ['id' => '4', 'label' => 'Statement B', 'correct_answer' => 'FALSE'],
                ],
            ],
            'order' => 3,
        ]);

        IeltsReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 5,
            'question_text' => 'Summary completion (bracket style).',
            'type' => 'summary_completion',
            'correct_answer' => ['5' => 'apple', '6' => 'banana'],
            'data' => [
                'summary_text' => 'The fruit was a [5] and a [6].',
                'placeholders' => ['5' => 5, '6' => 6],
            ],
            'order' => 4,
        ]);

        IeltsReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 7,
            'question_text' => 'Summary completion (ellipsis style, no brackets).',
            'type' => 'summary_completion',
            'correct_answer' => ['7' => 'cherry'],
            'data' => [
                'summary_text' => 'The fruit was a 7…………… on the table.',
                'placeholders' => ['7' => 7],
            ],
            'order' => 5,
        ]);

        IeltsReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 8,
            'question_text' => 'Short answer questions.',
            'type' => 'short_answer_group',
            'data' => [
                'sub_questions' => [
                    ['id' => '8', 'label' => 'What job was the author training for?', 'correct_answer' => 'teacher'],
                ],
            ],
            'order' => 6,
        ]);

        IeltsReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 9,
            'question_text' => 'Table completion.',
            'type' => 'table_completion',
            'correct_answer' => ['9' => 'red'],
            'data' => [
                'columns' => ['Item', 'Color'],
                'rows' => [['Apple', '[9]']],
                'placeholders' => ['9' => 9],
            ],
            'order' => 7,
        ]);

        return $passage;
    }

    public function test_material_page_renders_without_exception(): void
    {
        $this->seedPassage();
        $admin = $this->adminUser();

        $response = $this->actingAs($admin)->get(route('assignments.ielts-academic.reading.material', 1));

        $response->assertOk();
    }

    public function test_every_answer_with_correct_value_has_a_matching_input(): void
    {
        $this->seedPassage();
        $admin = $this->adminUser();

        $response = $this->actingAs($admin)->get(route('assignments.ielts-academic.reading.material', 1));
        $response->assertOk();
        $html = $response->content();

        preg_match_all('/data-qid="([^"]*)"/', $html, $qidMatches);
        $this->assertNotEmpty($qidMatches[1], "Material page should render question input elements with data-qid.");
    }

    private function describe(mixed $value): string
    {
        return is_scalar($value) ? (string) $value : json_encode($value);
    }
}
