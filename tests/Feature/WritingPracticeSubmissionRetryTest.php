<?php

namespace Tests\Feature;

use App\Models\ClassPeriod;
use App\Models\Enrollment;
use App\Models\IeltsWritingPracticeSubmission;
use App\Models\Program;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WritingPracticeSubmissionRetryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // This app's global RedirectApexToWww middleware 301s every apex-domain
        // request to https://www.targetbahasa.com/... which is irrelevant to the
        // authorization logic these tests actually check. Route-model-binding
        // (SubstituteBindings) and the pre-existing program-enrollment access gate
        // (HandlesAssignmentAccess, applied to every ielts.writing.* route) are
        // deliberately left running - real students can only ever reach this route
        // in production while properly enrolled, so tests that exercise a student
        // set up real enrollment below instead of bypassing that gate.
        $this->withoutMiddleware(\App\Http\Middleware\RedirectApexToWww::class);
    }

    private function enrollInIeltsAcademicWriting(User $student): void
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

    private function submission(User $owner): IeltsWritingPracticeSubmission
    {
        return IeltsWritingPracticeSubmission::create([
            'user_id' => $owner->id,
            'meeting_id' => null,
            'task_type' => 1,
            'essay' => str_repeat('Test essay content. ', 20),
            'scores' => null,
            'evaluation_status' => 'failed',
            'error_message' => 'AI Response Error',
            'attempts' => 1,
        ]);
    }

    public function test_admin_page_blocks_students_via_http(): void
    {
        $student = User::factory()->create(['role' => 'student']);

        $response = $this->actingAs($student)->get(route('admin.writing-practice-submissions.index'));

        $response->assertForbidden();
    }

    public function test_admin_page_allows_admin_via_http(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.writing-practice-submissions.index'));

        $response->assertOk();
    }

    public function test_admin_page_allows_teacher_via_http(): void
    {
        $teacher = User::factory()->create(['role' => 'teacher']);

        $response = $this->actingAs($teacher)->get(route('admin.writing-practice-submissions.index'));

        $response->assertOk();
    }

    public function test_retry_route_blocks_other_students_via_http(): void
    {
        $owner = User::factory()->create(['role' => 'student']);
        $other = User::factory()->create(['role' => 'student']);
        $this->enrollInIeltsAcademicWriting($other);
        $submission = $this->submission($owner);

        $response = $this->actingAs($other)->post(route('assignments.ielts.writing.submission.retry', $submission));

        $response->assertForbidden();
    }

    public function test_retry_route_allows_owner_via_http(): void
    {
        $owner = User::factory()->create(['role' => 'student']);
        $this->enrollInIeltsAcademicWriting($owner);
        $submission = $this->submission($owner);

        $response = $this->actingAs($owner)->post(route('assignments.ielts.writing.submission.retry', $submission));

        // Not asserting 200 specifically since it depends on live AI providers -
        // the point of this test is that authorization did NOT reject the owner
        // (a 403 here would be the bug; 200 or a 500 from AI failure are both fine).
        $this->assertNotEquals(403, $response->status());
    }

    public function test_retry_route_allows_admin_via_http(): void
    {
        $owner = User::factory()->create(['role' => 'student']);
        $admin = User::factory()->create(['role' => 'admin']);
        $submission = $this->submission($owner);

        $response = $this->actingAs($admin)->post(route('assignments.ielts.writing.submission.retry', $submission));

        $this->assertNotEquals(403, $response->status());
    }

    public function test_retry_route_allows_teacher_via_http(): void
    {
        $owner = User::factory()->create(['role' => 'student']);
        $teacher = User::factory()->create(['role' => 'teacher']);
        $submission = $this->submission($owner);

        $response = $this->actingAs($teacher)->post(route('assignments.ielts.writing.submission.retry', $submission));

        $this->assertNotEquals(403, $response->status());
    }
}
