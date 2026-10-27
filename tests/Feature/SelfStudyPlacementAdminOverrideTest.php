<?php

namespace Tests\Feature;

use App\Models\GrammarPlacementPackage;
use App\Models\GrammarPlacementResult;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SelfStudyPlacementAdminOverrideTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_the_index_page()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.self-study-placement.index'));

        $response->assertStatus(200);
        $response->assertSee('Self-Study Grammar Placement');
    }

    public function test_admin_sees_the_inline_control_panel_on_the_placement_test_page()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $package = GrammarPlacementPackage::create(['title' => 'Gate', 'is_active' => true]);
        Setting::create(['key' => 'self_study_grammar_placement_package_id', 'value' => (string) $package->id, 'type' => 'string']);

        $response = $this->actingAs($admin)->get(route('self-study-classes.placement.show'));

        $response->assertStatus(200);
        $response->assertSee('Kendali Admin');
        $response->assertSee(route('admin.self-study-placement.override'), false);
    }

    public function test_non_admin_does_not_see_the_inline_control_panel()
    {
        $student = User::factory()->create(['role' => 'admin']); // only role:admin can reach the route at all currently
        $package = GrammarPlacementPackage::create(['title' => 'Gate', 'is_active' => true]);
        Setting::create(['key' => 'self_study_grammar_placement_package_id', 'value' => (string) $package->id, 'type' => 'string']);

        // Simulate a non-privileged viewer by overriding the role check surface: since
        // only role:admin can reach this route today, assert the panel is gated on the
        // controller's own isAdmin check rather than always rendering.
        $student->role = 'student';
        $student->save();

        $this->actingAs($student);
        $this->withoutMiddleware(\App\Http\Middleware\RoleMiddleware::class);
        $response = $this->get(route('self-study-classes.placement.show'));

        $response->assertStatus(200);
        $response->assertDontSee('Kendali Admin');
    }

    public function test_admin_can_set_a_mode_override_for_a_student()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $student = User::factory()->create(['role' => 'student']);

        $response = $this->actingAs($admin)->post(route('admin.self-study-placement.override'), [
            'user_id' => $student->id,
            'mode' => 'B',
        ]);

        $response->assertRedirect();
        $this->assertSame('B', $student->fresh()->self_study_grammar_mode_override);
    }

    public function test_override_bypasses_the_placement_test_gate_and_forces_the_mode()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $student = User::factory()->create(['role' => 'admin', 'self_study_grammar_mode_override' => 'B']);

        // No GrammarPlacementResult exists for this student at all - normally this
        // would redirect to the placement test, but the override should skip that.
        $response = $this->actingAs($student)->get(route('self-study-classes.player', [
            'course' => 'grammar-for-writing', 'module' => 'm1', 'topic' => 't2',
        ]));

        $response->assertStatus(200);
        $response->assertSee('Researchers observe seawater temperature fluctuations', false);
    }

    public function test_clearing_the_override_falls_back_to_the_placement_test_gate()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $package = GrammarPlacementPackage::create(['title' => 'Gate', 'is_active' => true]);
        Setting::create(['key' => 'self_study_grammar_placement_package_id', 'value' => (string) $package->id, 'type' => 'string']);

        $student = User::factory()->create(['role' => 'admin', 'self_study_grammar_mode_override' => 'A']);

        // Clear the override via the admin endpoint.
        $this->actingAs($admin)->post(route('admin.self-study-placement.override'), [
            'user_id' => $student->id,
            'mode' => '',
        ]);

        $this->assertNull($student->fresh()->self_study_grammar_mode_override);

        // Now that the override is gone and no result exists, the gate should redirect.
        $response = $this->actingAs($student->fresh())->get(route('self-study-classes.player', [
            'course' => 'grammar-for-writing',
        ]));

        $response->assertRedirect(route('self-study-classes.placement.show'));
    }
}
