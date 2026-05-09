<?php

namespace Tests\Feature;

use App\Application\IeltsSpeaking\ManageIeltsSpeakingTopics;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IeltsSpeakingAdminControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware();
    }

    // -------------------------------------------------------------------------
    // toggleLock
    // -------------------------------------------------------------------------

    public function test_toggle_lock_aborts_for_non_admin(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $this->actingAs($student);

        $service = $this->createMock(ManageIeltsSpeakingTopics::class);
        $service->expects($this->never())->method('toggleLock');
        $this->app->instance(ManageIeltsSpeakingTopics::class, $service);

        $response = $this->post(route('admin.ielts.speaking.topics.toggle-lock', ['id' => 1]));

        $response->assertForbidden();
    }

    public function test_toggle_lock_succeeds_for_admin_and_returns_locked_state(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $service = $this->createMock(ManageIeltsSpeakingTopics::class);
        $service->expects($this->once())->method('toggleLock')->with(5)->willReturn(true);
        $this->app->instance(ManageIeltsSpeakingTopics::class, $service);

        $response = $this->post(route('admin.ielts.speaking.topics.toggle-lock', ['id' => 5]));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Speaking topic is now LOCKED.');
        $response->assertSessionHas('success_state', 'locked');
    }

    public function test_toggle_lock_succeeds_for_admin_and_returns_open_state(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $service = $this->createMock(ManageIeltsSpeakingTopics::class);
        $service->expects($this->once())->method('toggleLock')->with(3)->willReturn(false);
        $this->app->instance(ManageIeltsSpeakingTopics::class, $service);

        $response = $this->post(route('admin.ielts.speaking.topics.toggle-lock', ['id' => 3]));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Speaking topic is now OPEN.');
        $response->assertSessionHas('success_state', 'open');
    }

    // -------------------------------------------------------------------------
    // storeTopic
    // -------------------------------------------------------------------------

    public function test_store_topic_aborts_for_non_admin(): void
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $this->actingAs($teacher);

        $service = $this->createMock(ManageIeltsSpeakingTopics::class);
        $service->expects($this->never())->method('create');
        $this->app->instance(ManageIeltsSpeakingTopics::class, $service);

        $response = $this->post(route('admin.ielts.speaking.topics.store'), [
            'title' => 'New Topic',
            'slug' => 'new-topic',
            'icon' => 'star',
        ]);

        $response->assertForbidden();
    }

    public function test_store_topic_delegates_to_service_and_redirects(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $captured = null;
        $service = $this->createMock(ManageIeltsSpeakingTopics::class);
        $service->expects($this->once())
            ->method('create')
            ->willReturnCallback(function (array $attrs) use (&$captured) {
                $captured = $attrs;
            });
        $this->app->instance(ManageIeltsSpeakingTopics::class, $service);

        $response = $this->post(route('admin.ielts.speaking.topics.store'), [
            'title' => 'Jobs',
            'slug' => 'jobs',
            'icon' => 'briefcase',
            'color' => 'blue',
            'order' => 2,
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Speaking topic created successfully.');
        $this->assertEquals('Jobs', $captured['title']);
        $this->assertEquals('jobs', $captured['slug']);
        $this->assertEquals('blue', $captured['color']);
        $this->assertEquals(2, $captured['order']);
    }

    public function test_store_topic_fails_validation_when_title_missing(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $this->app->instance(ManageIeltsSpeakingTopics::class, $this->createMock(ManageIeltsSpeakingTopics::class));

        $response = $this->post(route('admin.ielts.speaking.topics.store'), [
            'slug' => 'no-title',
            'icon' => 'star',
        ]);

        $response->assertSessionHasErrors('title');
    }

    // -------------------------------------------------------------------------
    // updateTopic
    // -------------------------------------------------------------------------

    public function test_update_topic_aborts_for_non_admin(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $this->actingAs($student);

        $service = $this->createMock(ManageIeltsSpeakingTopics::class);
        $service->expects($this->never())->method('update');
        $this->app->instance(ManageIeltsSpeakingTopics::class, $service);

        $response = $this->put(route('admin.ielts.speaking.topics.update', ['id' => 7]), [
            'title' => 'Updated',
            'slug' => 'updated',
            'icon' => 'star',
        ]);

        $response->assertForbidden();
    }

    public function test_update_topic_delegates_to_service_and_redirects(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $service = $this->createMock(ManageIeltsSpeakingTopics::class);
        $service->expects($this->once())->method('update')->with(7, $this->arrayHasKey('title'));
        $this->app->instance(ManageIeltsSpeakingTopics::class, $service);

        $response = $this->put(route('admin.ielts.speaking.topics.update', ['id' => 7]), [
            'title' => 'Travel',
            'slug' => 'travel',
            'icon' => 'plane',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Speaking topic updated successfully.');
    }

    // -------------------------------------------------------------------------
    // destroyTopic
    // -------------------------------------------------------------------------

    public function test_destroy_topic_aborts_for_non_admin(): void
    {
        $student = User::factory()->create(['role' => 'student']);
        $this->actingAs($student);

        $service = $this->createMock(ManageIeltsSpeakingTopics::class);
        $service->expects($this->never())->method('destroy');
        $this->app->instance(ManageIeltsSpeakingTopics::class, $service);

        $response = $this->delete(route('admin.ielts.speaking.topics.delete', ['id' => 9]));

        $response->assertForbidden();
    }

    public function test_destroy_topic_delegates_to_service_and_redirects(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->actingAs($admin);

        $service = $this->createMock(ManageIeltsSpeakingTopics::class);
        $service->expects($this->once())->method('destroy')->with(9);
        $this->app->instance(ManageIeltsSpeakingTopics::class, $service);

        $response = $this->delete(route('admin.ielts.speaking.topics.delete', ['id' => 9]));

        $response->assertRedirect();
        $response->assertSessionHas('success', 'Speaking topic deleted successfully.');
    }
}
