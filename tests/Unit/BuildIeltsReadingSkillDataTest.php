<?php

namespace Tests\Unit;

use App\Application\IeltsReading\BuildIeltsReadingSkillData;
use App\Models\IeltsReadingPassage;
use App\Models\IeltsReadingQuestion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BuildIeltsReadingSkillDataTest extends TestCase
{
    use RefreshDatabase;

    private function passage(int $materialId = 1): IeltsReadingPassage
    {
        return IeltsReadingPassage::create([
            'material_id' => $materialId,
            'title' => "Passage $materialId",
            'content' => '<p>Text.</p>',
            'order' => 1,
        ]);
    }

    public function test_ids_stay_unique_across_passages_that_reused_the_same_sub_question_id(): void
    {
        // Two different source passages both authored their sub-questions starting
        // from "1" - a real, observed pattern in the corpus. Without prefixing by the
        // DB row id, combining them into one skill-filtered page would collide.
        $passageA = $this->passage(1);
        $passageB = $this->passage(2);

        IeltsReadingQuestion::create([
            'passage_id' => $passageA->id,
            'question_number' => 1,
            'question_text' => 'T/F/NG',
            'type' => 'true_false_not_given',
            'options' => ['TRUE' => 'TRUE', 'FALSE' => 'FALSE', 'NOT GIVEN' => 'NOT GIVEN'],
            'data' => ['sub_questions' => [['id' => '1', 'label' => 'Statement 1', 'correct_answer' => 'TRUE']]],
            'order' => 1,
        ]);

        IeltsReadingQuestion::create([
            'passage_id' => $passageB->id,
            'question_number' => 1,
            'question_text' => 'T/F/NG',
            'type' => 'true_false_not_given',
            'options' => ['TRUE' => 'TRUE', 'FALSE' => 'FALSE', 'NOT GIVEN' => 'NOT GIVEN'],
            'data' => ['sub_questions' => [['id' => '1', 'label' => 'Statement 1 (other passage)', 'correct_answer' => 'FALSE']]],
            'order' => 1,
        ]);

        $result = app(BuildIeltsReadingSkillData::class)->handle('true-false-not-given');

        $ids = [];
        foreach ($result['content'] as $passage) {
            foreach ($passage['questions'] as $question) {
                foreach ($question['sub_questions'] as $sub) {
                    $ids[] = $sub['id'];
                }
            }
        }

        $this->assertCount(2, $ids);
        $this->assertCount(2, array_unique($ids), 'Sub-question ids from different source passages collided.');
    }

    public function test_correct_answer_map_keys_match_rewritten_sub_question_ids(): void
    {
        $passage = $this->passage(1);

        IeltsReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 1,
            'question_text' => 'T/F/NG',
            'type' => 'true_false_not_given',
            'options' => ['TRUE' => 'TRUE', 'FALSE' => 'FALSE', 'NOT GIVEN' => 'NOT GIVEN'],
            'data' => ['sub_questions' => [['id' => '1', 'label' => 'Statement 1', 'correct_answer' => 'TRUE']]],
            'order' => 1,
        ]);

        $result = app(BuildIeltsReadingSkillData::class)->handle('true-false-not-given');
        $question = $result['content'][0]['questions'][0];
        $subId = $question['sub_questions'][0]['id'];

        $this->assertArrayHasKey($subId, $question['correct_answer']);
        $this->assertSame('TRUE', $question['correct_answer'][$subId]);
    }

    public function test_summary_completion_text_markers_are_rewritten_to_match_new_placeholder_keys(): void
    {
        $passage = $this->passage(1);

        IeltsReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 5,
            'question_text' => 'Summary',
            'type' => 'summary_completion',
            'correct_answer' => ['5' => 'apple'],
            'data' => [
                'summary_text' => 'The fruit was a [5].',
                'placeholders' => ['5' => 5],
            ],
            'order' => 1,
        ]);

        $result = app(BuildIeltsReadingSkillData::class)->handle('summary-completion');
        $question = $result['content'][0]['questions'][0];
        $newKey = array_key_first($question['placeholders']);

        $this->assertStringContainsString('[' . $newKey . ']', $question['summary_text']);
        $this->assertStringNotContainsString('[5]', $question['summary_text']);
        $this->assertSame('apple', $question['correct_answer'][$newKey]);
    }

    public function test_summary_completion_ellipsis_style_marker_is_recognized_without_rewriting_text(): void
    {
        // No [bracket] in the text at all - the view finds this via its own
        // "number + dots" regex fallback instead, so the text must be left as-is
        // and the question must NOT be defensively excluded.
        $passage = $this->passage(1);

        IeltsReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 7,
            'question_text' => 'Summary',
            'type' => 'summary_completion',
            'correct_answer' => ['7' => 'cherry'],
            'data' => [
                'summary_text' => 'The fruit was a 7…………… on the table.',
                'placeholders' => ['7' => 7],
            ],
            'order' => 1,
        ]);

        $result = app(BuildIeltsReadingSkillData::class)->handle('summary-completion');

        $this->assertCount(1, $result['content']);
        $this->assertCount(1, $result['content'][0]['questions']);
    }

    public function test_content_with_no_renderable_marker_at_all_is_excluded(): void
    {
        // type=summary_completion but the referenced text has neither a [bracket]
        // marker nor a "number+dots" pattern - a genuine pre-existing content gap
        // that cannot be rendered as an answerable input at all.
        $passage = $this->passage(1);

        IeltsReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 28,
            'question_text' => 'Summary',
            'type' => 'summary_completion',
            'correct_answer' => ['q28' => 'hammer'],
            'data' => [
                'summary_text' => 'Complete the summary below with no visible blanks at all.',
                'placeholders' => ['q28' => 28],
            ],
            'order' => 1,
        ]);

        $result = app(BuildIeltsReadingSkillData::class)->handle('summary-completion');

        $this->assertSame([], $result['content'], 'Unrenderable content should be excluded, not shown broken.');
    }

    public function test_table_completion_with_no_columns_or_rows_is_excluded(): void
    {
        // A real pattern found in production: type=table_completion but the data
        // only has sub_questions/box_title, no columns/rows/placeholders at all.
        $passage = $this->passage(1);

        IeltsReadingQuestion::create([
            'passage_id' => $passage->id,
            'question_number' => 28,
            'question_text' => 'Table',
            'type' => 'table_completion',
            'correct_answer' => ['q28' => 'red'],
            'data' => [
                'box_title' => 'Some title',
                'sub_questions' => [['id' => 'q28', 'label' => 'unused', 'correct_answer' => 'red']],
            ],
            'order' => 1,
        ]);

        $result = app(BuildIeltsReadingSkillData::class)->handle('table-completion');

        $this->assertSame([], $result['content']);
    }

    public function test_unknown_skill_slug_returns_null(): void
    {
        $result = app(BuildIeltsReadingSkillData::class)->handle('not-a-real-skill');

        $this->assertNull($result);
    }

    public function test_general_training_materials_are_excluded_from_academic_skill_views(): void
    {
        $academicPassage = $this->passage(1);
        $generalPassage = $this->passage(101);

        foreach ([$academicPassage, $generalPassage] as $passage) {
            IeltsReadingQuestion::create([
                'passage_id' => $passage->id,
                'question_number' => 1,
                'question_text' => 'MCQ',
                'type' => 'multiple_choice',
                'options' => ['A' => 'A', 'B' => 'B'],
                'correct_answer' => 'A',
                'order' => 1,
            ]);
        }

        $result = app(BuildIeltsReadingSkillData::class)->handle('multiple-choice');

        $this->assertCount(1, $result['content']);
        $this->assertSame($academicPassage->id, $result['content'][0]['id']);
    }
}
