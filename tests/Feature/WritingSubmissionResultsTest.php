<?php

namespace Tests\Feature;

use App\Models\ClassPeriod;
use App\Models\Enrollment;
use App\Models\IeltsWritingMeeting;
use App\Models\IeltsWritingPracticeSubmission;
use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WritingSubmissionResultsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(\App\Http\Middleware\RedirectApexToWww::class);
    }

    private function enrollStudent(User $student): void
    {
        $program = Program::firstOrCreate(
            ['slug' => 'ielts-academic-writing'],
            ['name' => 'IELTS Academic Writing']
        );
        $classPeriod = ClassPeriod::create(['name' => 'Test Period']);

        Enrollment::create([
            'user_id' => $student->id,
            'program_id' => $program->id,
            'class_period_id' => $classPeriod->id,
            'status' => 'active',
        ]);
    }

    public function test_student_can_view_own_submission_result_page(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $this->enrollStudent($student);

        $submission = IeltsWritingPracticeSubmission::create([
            'user_id' => $student->id,
            'meeting_id' => null,
            'task_type' => 1,
            'essay' => 'This is a sample test essay for Task 1 writing practice.',
            'scores' => [
                'overall_band_score' => 7.0,
                'overall_comment' => 'Great work!',
            ],
            'evaluation_status' => 'success',
            'attempts' => 1,
        ]);

        $response = $this->actingAs($student)->get(route('assignments.ielts-academic.writing.submission.show', $submission));

        $response->assertOk();
        $response->assertSee('Hasil Pengerjaan Writing');
        $response->assertSee('This is a sample test essay');
    }

    public function test_student_cannot_view_other_student_submission_result(): void
    {
        $studentA = User::factory()->create(['role' => 'student']);
        $studentB = User::factory()->create(['role' => 'student']);
        $this->enrollStudent($studentB);

        $submission = IeltsWritingPracticeSubmission::create([
            'user_id' => $studentA->id,
            'meeting_id' => null,
            'task_type' => 1,
            'essay' => 'Essay by Student A',
            'scores' => ['overall_band_score' => 6.5],
            'evaluation_status' => 'success',
            'attempts' => 1,
        ]);

        $response = $this->actingAs($studentB)->get(route('assignments.ielts-academic.writing.submission.show', $submission));

        $response->assertForbidden();
    }

    public function test_teacher_and_admin_can_view_student_submission_and_submit_review(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $teacher = User::factory()->create(['role' => 'teacher']);

        $submission = IeltsWritingPracticeSubmission::create([
            'user_id' => $student->id,
            'meeting_id' => null,
            'task_type' => 2,
            'essay' => 'This is a task 2 essay.',
            'scores' => ['overall_band_score' => 7.0],
            'evaluation_status' => 'success',
            'attempts' => 1,
        ]);

        // Teacher views inspection page
        $response = $this->actingAs($teacher)->get(route('admin.writing-practice-submissions.show', $submission));
        $response->assertOk();
        $response->assertSee('Pemeriksaan Submission Writing Student');

        // Teacher submits review notes & manual scores
        $reviewResponse = $this->actingAs($teacher)->post(route('admin.writing-practice-submissions.review', $submission), [
            'task_achievement_score' => 7.5,
            'coherence_cohesion_score' => 7.5,
            'lexical_resource_score' => 7.5,
            'grammatical_range_score' => 7.5,
            'teacher_feedback' => 'Penulisan sangat baik, struktur paragraf rapi.',
        ]);

        $reviewResponse->assertRedirect();
        $submission->refresh();

        $this->assertEquals(7.5, $submission->teacher_score);
        $this->assertEquals('Penulisan sangat baik, struktur paragraf rapi.', $submission->teacher_feedback);
        $this->assertEquals($teacher->id, $submission->reviewed_by);
        $this->assertNotNull($submission->reviewed_at);
    }

    public function test_teacher_can_toggle_ai_evaluation_setting_and_disable_ai(): void
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $student = User::factory()->create(['role' => 'student']);
        $this->enrollStudent($student);

        // 1. Teacher toggles AI OFF
        $toggleRes = $this->actingAs($teacher)->postJson(route('admin.writing-practice-submissions.toggle-ai'), [
            'enabled' => false,
        ]);

        $toggleRes->assertOk();
        $toggleRes->assertJson([
            'status' => 'success',
            'ai_enabled' => false,
        ]);

        $this->assertDatabaseHas('settings', [
            'key' => 'ielts_writing_ai_evaluation_enabled',
            'value' => '0',
        ]);

        // 2. Student submits essay when AI is OFF -> should skip AI call and redirect to review page
        $evalRes = $this->actingAs($student)->postJson(route('assignments.ielts.writing.evaluate'), [
            'essay' => 'This is a student essay submitted while AI evaluation is disabled by teacher.',
            'task_type' => '2',
        ]);

        $evalRes->assertOk();
        $evalRes->assertJson([
            'status' => 'pending_teacher',
            'ai_enabled' => false,
        ]);

        $this->assertDatabaseHas('ielts_writing_practice_submissions', [
            'user_id' => $student->id,
            'evaluation_status' => 'pending_teacher',
        ]);
    }
}
