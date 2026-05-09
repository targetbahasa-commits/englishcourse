<?php

namespace Tests\Feature;

use App\Application\IeltsShared\DetermineCambridgeAccess;
use App\Application\IeltsShared\ManageCambridgeMockupMaterial;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class IeltsCambridgeMockupControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }

    private function adminUser(): User
    {
        return User::factory()->create(['role' => 'admin']);
    }

    private function teacherUser(): User
    {
        return User::factory()->create(['role' => 'teacher']);
    }

    private function studentUser(): User
    {
        return User::factory()->create(['role' => 'student']);
    }

    // -------------------------------------------------------------------------
    // uploadAudio
    // -------------------------------------------------------------------------

    public function test_upload_audio_aborts_for_student(): void
    {
        $this->actingAs($this->studentUser());

        $service = $this->createMock(ManageCambridgeMockupMaterial::class);
        $service->expects($this->never())->method('uploadAudio');
        $this->app->instance(ManageCambridgeMockupMaterial::class, $service);
        $this->app->instance(DetermineCambridgeAccess::class, $this->createMock(DetermineCambridgeAccess::class));

        $response = $this->post(
            route('assignments.ielts-academic.mockup.cambridge.upload-audio', ['edition' => 16, 'id' => 1]),
            ['audio_file' => UploadedFile::fake()->create('test.mp3', 100, 'audio/mpeg')]
        );

        $response->assertForbidden();
    }

    public function test_upload_audio_succeeds_for_admin(): void
    {
        $this->actingAs($this->adminUser());

        $service = $this->createMock(ManageCambridgeMockupMaterial::class);
        $service->expects($this->once())->method('uploadAudio')
            ->with(16, 1, $this->isInstanceOf(UploadedFile::class));
        $this->app->instance(ManageCambridgeMockupMaterial::class, $service);
        $this->app->instance(DetermineCambridgeAccess::class, $this->createMock(DetermineCambridgeAccess::class));

        $response = $this->post(
            route('assignments.ielts-academic.mockup.cambridge.upload-audio', ['edition' => 16, 'id' => 1]),
            ['audio_file' => UploadedFile::fake()->create('audio.mp3', 200, 'audio/mpeg')]
        );

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Audio uploaded successfully.');
    }

    public function test_upload_audio_succeeds_for_teacher(): void
    {
        $this->actingAs($this->teacherUser());

        $service = $this->createMock(ManageCambridgeMockupMaterial::class);
        $service->expects($this->once())->method('uploadAudio');
        $this->app->instance(ManageCambridgeMockupMaterial::class, $service);
        $this->app->instance(DetermineCambridgeAccess::class, $this->createMock(DetermineCambridgeAccess::class));

        $response = $this->post(
            route('assignments.ielts-academic.mockup.cambridge.upload-audio', ['edition' => 16, 'id' => 1]),
            ['audio_file' => UploadedFile::fake()->create('audio.mp3', 100, 'audio/mpeg')]
        );

        $response->assertRedirect();
    }

    public function test_upload_audio_returns_error_when_no_file_given(): void
    {
        $this->actingAs($this->adminUser());

        $service = $this->createMock(ManageCambridgeMockupMaterial::class);
        $service->expects($this->never())->method('uploadAudio');
        $this->app->instance(ManageCambridgeMockupMaterial::class, $service);
        $this->app->instance(DetermineCambridgeAccess::class, $this->createMock(DetermineCambridgeAccess::class));

        // audio_file validation is 'required' so this should fail validation
        $response = $this->post(
            route('assignments.ielts-academic.mockup.cambridge.upload-audio', ['edition' => 16, 'id' => 1]),
            []
        );

        $response->assertSessionHasErrors('audio_file');
    }

    // -------------------------------------------------------------------------
    // uploadSrt
    // -------------------------------------------------------------------------

    public function test_upload_srt_aborts_for_student(): void
    {
        $this->actingAs($this->studentUser());

        $service = $this->createMock(ManageCambridgeMockupMaterial::class);
        $service->expects($this->never())->method('uploadSrt');
        $this->app->instance(ManageCambridgeMockupMaterial::class, $service);
        $this->app->instance(DetermineCambridgeAccess::class, $this->createMock(DetermineCambridgeAccess::class));

        $response = $this->post(
            route('assignments.ielts-academic.mockup.cambridge.upload-srt', ['edition' => 16, 'id' => 1]),
            ['srt_content' => '1\n00:00:01,000 --> 00:00:02,000\nHello', 'language' => 'en']
        );

        $response->assertForbidden();
    }

    public function test_upload_srt_via_content_delegates_to_service(): void
    {
        $this->actingAs($this->adminUser());

        $service = $this->createMock(ManageCambridgeMockupMaterial::class);
        $service->expects($this->once())->method('uploadSrt')
            ->with(16, 2, $this->isType('string'), 'id');
        $this->app->instance(ManageCambridgeMockupMaterial::class, $service);
        $this->app->instance(DetermineCambridgeAccess::class, $this->createMock(DetermineCambridgeAccess::class));

        $response = $this->post(
            route('assignments.ielts-academic.mockup.cambridge.upload-srt', ['edition' => 16, 'id' => 2]),
            ['srt_content' => "1\r\n00:00:01,000 --> 00:00:02,000\r\nHalo", 'language' => 'id']
        );

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Transcript uploaded/updated successfully.');
    }

    public function test_upload_srt_fails_validation_without_srt_content_or_file(): void
    {
        $this->actingAs($this->adminUser());

        $this->app->instance(ManageCambridgeMockupMaterial::class, $this->createMock(ManageCambridgeMockupMaterial::class));
        $this->app->instance(DetermineCambridgeAccess::class, $this->createMock(DetermineCambridgeAccess::class));

        $response = $this->post(
            route('assignments.ielts-academic.mockup.cambridge.upload-srt', ['edition' => 16, 'id' => 1]),
            ['language' => 'en']
        );

        $response->assertSessionHasErrors();
    }

    // -------------------------------------------------------------------------
    // uploadAnswerKey
    // -------------------------------------------------------------------------

    public function test_upload_answer_key_aborts_for_student(): void
    {
        $this->actingAs($this->studentUser());

        $service = $this->createMock(ManageCambridgeMockupMaterial::class);
        $service->expects($this->never())->method('updateAnswerKey');
        $this->app->instance(ManageCambridgeMockupMaterial::class, $service);
        $this->app->instance(DetermineCambridgeAccess::class, $this->createMock(DetermineCambridgeAccess::class));

        $response = $this->post(
            route('assignments.ielts-academic.mockup.cambridge.upload-answer-key', ['edition' => 16, 'id' => 1]),
            ['answer_key' => '1.B 2.C']
        );

        $response->assertForbidden();
    }

    public function test_upload_answer_key_delegates_to_service(): void
    {
        $this->actingAs($this->adminUser());

        $service = $this->createMock(ManageCambridgeMockupMaterial::class);
        $service->expects($this->once())->method('updateAnswerKey')
            ->with(17, 3, '1.A 2.B 3.C');
        $this->app->instance(ManageCambridgeMockupMaterial::class, $service);
        $this->app->instance(DetermineCambridgeAccess::class, $this->createMock(DetermineCambridgeAccess::class));

        $response = $this->post(
            route('assignments.ielts-academic.mockup.cambridge.upload-answer-key', ['edition' => 17, 'id' => 3]),
            ['answer_key' => '1.A 2.B 3.C']
        );

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Answer Key uploaded/updated successfully.');
    }

    public function test_upload_answer_key_fails_validation_when_empty(): void
    {
        $this->actingAs($this->adminUser());

        $this->app->instance(ManageCambridgeMockupMaterial::class, $this->createMock(ManageCambridgeMockupMaterial::class));
        $this->app->instance(DetermineCambridgeAccess::class, $this->createMock(DetermineCambridgeAccess::class));

        $response = $this->post(
            route('assignments.ielts-academic.mockup.cambridge.upload-answer-key', ['edition' => 16, 'id' => 1]),
            []
        );

        $response->assertSessionHasErrors('answer_key');
    }

    public function test_upload_answer_key_succeeds_for_teacher(): void
    {
        $this->actingAs($this->teacherUser());

        $service = $this->createMock(ManageCambridgeMockupMaterial::class);
        $service->expects($this->once())->method('updateAnswerKey');
        $this->app->instance(ManageCambridgeMockupMaterial::class, $service);
        $this->app->instance(DetermineCambridgeAccess::class, $this->createMock(DetermineCambridgeAccess::class));

        $response = $this->post(
            route('assignments.ielts-academic.mockup.cambridge.upload-answer-key', ['edition' => 16, 'id' => 1]),
            ['answer_key' => '1.D']
        );

        $response->assertRedirect();
    }
}
