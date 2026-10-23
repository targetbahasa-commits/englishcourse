<?php

namespace Tests\Feature;

use App\Models\ClassPeriod;
use App\Models\ClassMeeting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomClassSpeakingAiInterviewSmokeTest extends TestCase
{
    use RefreshDatabase;

    private function makeClassPeriodWithMeeting1(): ClassPeriod
    {
        $classPeriod = ClassPeriod::create([
            'name' => 'Smoke Test Custom Class',
            'is_custom' => true,
            'status' => 'active',
            'batch_type' => 'private',
            'learning_mode' => 'online',
            'total_meetings' => 8,
        ]);

        ClassMeeting::create([
            'class_period_id' => $classPeriod->id,
            'meeting_number' => 1,
            'topic' => 'Smoke Test Meeting 1',
        ]);

        return $classPeriod;
    }

    public function test_speaking_page_renders_with_ai_interview_tab()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $classPeriod = $this->makeClassPeriodWithMeeting1();

        $response = $this->actingAs($admin)->get(route('assignments.custom-class.meeting.speaking', [$classPeriod->id, 1]));

        $response->assertStatus(200);
        $response->assertSee('AI Interview');
        $response->assertSee('aiQuestions', false);
        $response->assertSee('toggleAiInteraction', false);
    }

    public function test_ai_interview_evaluate_endpoint_requires_auth()
    {
        $classPeriod = $this->makeClassPeriodWithMeeting1();

        $response = $this->post(route('assignments.custom-class.meeting.speaking.ai-interview.evaluate', [$classPeriod->id, 1]), [
            'questions' => ['Hello, how are you?'],
            'answers' => ['I am fine thank you.'],
        ]);

        // Guest hits the route-group 'auth' middleware before the
        // controller's own `if (!$user)` check ever runs, so it's a
        // standard redirect-away, not the controller's JSON 401.
        $response->assertRedirect();
    }

    public function test_ai_interview_evaluate_rejects_unenrolled_student()
    {
        $student = User::factory()->create(['role' => 'student']);
        $classPeriod = $this->makeClassPeriodWithMeeting1();

        $response = $this->actingAs($student)->post(route('assignments.custom-class.meeting.speaking.ai-interview.evaluate', [$classPeriod->id, 1]), [
            'questions' => ['Hello, how are you?'],
            'answers' => ['I am fine thank you.'],
        ]);

        $response->assertStatus(403);
    }
}
