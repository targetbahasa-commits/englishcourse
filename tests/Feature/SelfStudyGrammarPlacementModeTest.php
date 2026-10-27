<?php

namespace Tests\Feature;

use App\Models\GrammarPlacementPackage;
use App\Models\GrammarPlacementQuestion;
use App\Models\GrammarPlacementResult;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SelfStudyGrammarPlacementModeTest extends TestCase
{
    use RefreshDatabase;

    private function seedGatePackage(): GrammarPlacementPackage
    {
        $package = GrammarPlacementPackage::create([
            'title' => 'Test Gate Package',
            'is_active' => true,
        ]);

        GrammarPlacementQuestion::create([
            'grammar_placement_package_id' => $package->id,
            'question_text' => 'He ___ to school every day.',
            'option_a' => 'walk', 'option_b' => 'walks', 'option_c' => 'walking', 'option_d' => 'walked',
            'correct_option' => 'b', 'cefr_level' => 'A1', 'order' => 1, 'is_active' => true,
        ]);

        Setting::create([
            'key' => 'self_study_grammar_placement_package_id',
            'value' => (string) $package->id,
            'type' => 'string',
        ]);

        return $package;
    }

    public function test_player_redirects_to_placement_when_no_result_exists()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->seedGatePackage();

        $response = $this->actingAs($admin)->get(route('self-study-classes.player', ['course' => 'grammar-for-writing']));

        $response->assertRedirect(route('self-study-classes.placement.show'));
    }

    public function test_low_score_serves_mode_a_everyday_content()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $package = $this->seedGatePackage();

        GrammarPlacementResult::create([
            'grammar_placement_package_id' => $package->id,
            'student_name' => $admin->name,
            'user_id' => $admin->id,
            'answers_data' => [],
            'correct_count' => 2,
            'total_count' => 20,
            'percentage' => 10.0,
            'cefr_level' => 'A1',
        ]);

        $response = $this->actingAs($admin)->get(route('self-study-classes.player', ['course' => 'grammar-for-writing', 'module' => 'm1', 'topic' => 't2']));

        $response->assertStatus(200);
        // Mode A topic 1.2's first exercise is the everyday "neighbors watch the birds" sentence,
        // not the Advanced track's "Researchers observe seawater temperature fluctuations".
        $response->assertSee('The neighbors watch the birds in the park every week', false);
        $response->assertDontSee('Researchers observe seawater temperature fluctuations', false);
    }

    public function test_high_score_serves_mode_b_advanced_content()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $package = $this->seedGatePackage();

        GrammarPlacementResult::create([
            'grammar_placement_package_id' => $package->id,
            'student_name' => $admin->name,
            'user_id' => $admin->id,
            'answers_data' => [],
            'correct_count' => 19,
            'total_count' => 20,
            'percentage' => 95.0,
            'cefr_level' => 'C2',
        ]);

        $response = $this->actingAs($admin)->get(route('self-study-classes.player', ['course' => 'grammar-for-writing', 'module' => 'm1', 'topic' => 't2']));

        $response->assertStatus(200);
        // Mode B topic 1.2's first exercise uses the restored academic register.
        $response->assertSee('Researchers observe seawater temperature fluctuations', false);
        $response->assertDontSee('The neighbors watch the birds in the park every week', false);
    }

    public function test_module_2_is_unaffected_by_mode()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $package = $this->seedGatePackage();

        GrammarPlacementResult::create([
            'grammar_placement_package_id' => $package->id,
            'student_name' => $admin->name,
            'user_id' => $admin->id,
            'answers_data' => [],
            'correct_count' => 2,
            'total_count' => 20,
            'percentage' => 10.0,
            'cefr_level' => 'A1',
        ]);

        $responseA = $this->actingAs($admin)->get(route('self-study-classes.player', ['course' => 'grammar-for-writing', 'module' => 'm2', 'topic' => 't1']));
        $responseA->assertStatus(200);

        GrammarPlacementResult::create([
            'grammar_placement_package_id' => $package->id,
            'student_name' => $admin->name,
            'user_id' => $admin->id,
            'answers_data' => [],
            'correct_count' => 19,
            'total_count' => 20,
            'percentage' => 95.0,
            'cefr_level' => 'C2',
        ]);

        $responseB = $this->actingAs($admin)->get(route('self-study-classes.player', ['course' => 'grammar-for-writing', 'module' => 'm2', 'topic' => 't1']));
        $responseB->assertStatus(200);

        // Module 2 content is identical for both modes.
        $this->assertSame($responseA->getContent(), $responseB->getContent());
    }
}
