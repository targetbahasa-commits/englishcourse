<?php

namespace Tests\Feature;

use App\Models\GrammarPlacementPackage;
use App\Models\GrammarPlacementResult;
use App\Models\SelfStudyDraft;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SelfStudyDraftPersistenceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The player() route is gated behind a self-study grammar placement
     * result (see SelfStudyGrammarPlacementModeTest) - seed one so tests
     * that need to actually load the player page can pass the gate.
     */
    private function passSelfStudyPlacementGate(User $user): void
    {
        $package = GrammarPlacementPackage::create(['title' => 'Gate Package', 'is_active' => true]);
        Setting::create(['key' => 'self_study_grammar_placement_package_id', 'value' => (string) $package->id, 'type' => 'string']);
        GrammarPlacementResult::create([
            'grammar_placement_package_id' => $package->id,
            'student_name' => $user->name,
            'user_id' => $user->id,
            'answers_data' => [],
            'correct_count' => 10,
            'total_count' => 20,
            'percentage' => 50.0,
            'cefr_level' => 'B1',
        ]);
    }

    public function test_saving_a_draft_persists_it_to_the_database()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->postJson(route('self-study-classes.draft'), [
            'course' => 'grammar-for-writing',
            'module' => 'm1',
            'topic' => 't1',
            'answers' => ['q1' => 'The cat sits on the mat.'],
            'submitted' => ['q1' => true],
        ]);

        $response->assertStatus(200);
        $response->assertJson(['success' => true]);

        $this->assertDatabaseHas('self_study_drafts', [
            'user_id' => $admin->id,
            'course' => 'grammar-for-writing',
            'module' => 'm1',
            'topic' => 't1',
        ]);

        $draft = SelfStudyDraft::where('user_id', $admin->id)->first();
        $this->assertSame('The cat sits on the mat.', $draft->answers['q1']);
        $this->assertTrue($draft->submitted['q1']);
    }

    public function test_reopening_the_player_loads_the_saved_draft_from_the_database_not_a_blank_default()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->passSelfStudyPlacementGate($admin);

        SelfStudyDraft::create([
            'user_id' => $admin->id,
            'course' => 'grammar-for-writing',
            'module' => 'm1',
            'topic' => 't1',
            'answers' => ['q1' => 'Previously saved answer'],
            'submitted' => ['q1' => true],
        ]);

        $response = $this->actingAs($admin)->get(route('self-study-classes.player', [
            'course' => 'grammar-for-writing',
            'module' => 'm1',
            'topic' => 't1',
        ]));

        $response->assertStatus(200);
        $response->assertSee('Previously saved answer');
    }

    public function test_draft_endpoint_requires_auth()
    {
        $response = $this->postJson(route('self-study-classes.draft'), [
            'course' => 'grammar-for-writing',
            'module' => 'm1',
            'topic' => 't1',
            'answers' => ['q1' => 'x'],
        ]);

        $response->assertStatus(401);
    }
}
