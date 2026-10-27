<?php

namespace App\Http\Controllers;

use App\Application\GrammarPlacement\ScoreGrammarPlacementAttempt;
use App\Models\GrammarPlacementPackage;
use App\Models\GrammarPlacementQuestion;
use App\Models\GrammarPlacementResult;
use App\Models\PlacementTestPackage;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

/**
 * Authenticated placement test gating the self-study Grammar for Writing
 * course into two content tracks (see ResolveSelfStudyGrammarMode). Mirrors
 * GrammarPlacementPromoController's show/submit/result shape, but for a
 * logged-in student instead of a public/Turnstile-protected lead.
 */
class SelfStudyPlacementController extends Controller
{
    public function show(Request $request)
    {
        $isAdmin = auth()->check() && (
            (method_exists(auth()->user(), 'isAdmin') && auth()->user()->isAdmin()) ||
            in_array(strtolower(auth()->user()->role ?? ''), ['admin', 'superadmin'])
        );

        $gatePackageId = Setting::where('key', 'self_study_grammar_placement_package_id')->value('value');
        $testType = $request->query('test_type', 'grammar'); // 'grammar' or '4skill'
        $selectedModule = $request->query('module', 'all');

        $fourSkillPackage = null;
        $fourSkillQuestions = [];

        if ($isAdmin && $testType === '4skill') {
            $fourSkillPackage = PlacementTestPackage::with([
                'readingPassages.questions',
                'listeningBanks.questions',
                'writingPrompts',
                'speakingPrompts'
            ])->effectivelyActive()->first() ?? PlacementTestPackage::with([
                'readingPassages.questions',
                'listeningBanks.questions',
                'writingPrompts',
                'speakingPrompts'
            ])->first();
            $package = null;
            $questions = collect();
            $moduleCounts = [
                'reading' => $fourSkillPackage ? $fourSkillPackage->readingPassages->sum(fn($p) => $p->questions->count()) : 0,
                'listening' => $fourSkillPackage ? $fourSkillPackage->listeningBanks->sum(fn($b) => $b->questions->count()) : 0,
                'writing' => $fourSkillPackage ? $fourSkillPackage->writingPrompts->count() : 0,
                'speaking' => $fourSkillPackage ? $fourSkillPackage->speakingPrompts->count() : 0,
            ];
        } else {
            // Grammar placement test
            $testType = 'grammar';
            $requestedPackageId = $request->query('package_id');

            if ($isAdmin && $requestedPackageId) {
                $package = GrammarPlacementPackage::find($requestedPackageId);
            } else {
                $package = $this->resolveGatePackage();
            }

            if (!$package) {
                // Fallback to first active package if gate package is not set or not found
                $package = GrammarPlacementPackage::where('is_active', true)->first() ?? GrammarPlacementPackage::first();
            }

            if (!$package) {
                abort(404, 'Paket tes penempatan tidak ditemukan.');
            }

            // Get module counts (by cefr_level)
            $moduleCounts = $package->questions()->active()
                ->selectRaw('cefr_level, count(*) as count')
                ->groupBy('cefr_level')
                ->pluck('count', 'cefr_level')
                ->toArray();

            // Filter questions
            $questionsQuery = $package->questions()->active()->ordered();
            if ($selectedModule && $selectedModule !== 'all') {
                $questionsQuery->where('cefr_level', $selectedModule);
            }
            $questions = $questionsQuery->get();
        }

        $allGrammarPackages = $isAdmin
            ? GrammarPlacementPackage::withCount(['questions' => fn($q) => $q->active()])->orderBy('id')->get()
            : collect();

        $allFourSkillPackages = $isAdmin
            ? PlacementTestPackage::all()
            : collect();

        $students = $isAdmin
            ? User::where('role', '!=', 'admin')->orderBy('name')->get(['id', 'name', 'email', 'self_study_grammar_mode_override'])
            : collect();

        $courseModules = [
            ['key' => 'm1', 'code' => 'Modul 1', 'title' => 'Introductory Grammar Foundations (80 Soal)', 'route' => route('self-study-classes.player', ['course' => 'grammar-for-writing', 'module' => 'm1'])],
            ['key' => 'm2', 'code' => 'Modul 2', 'title' => 'Phrasal & Structural Expansion (80 Soal)', 'route' => route('self-study-classes.player', ['course' => 'grammar-for-writing', 'module' => 'm2'])],
            ['key' => 'm3', 'code' => 'Modul 3', 'title' => 'Clause Coordination & Subordination', 'route' => route('self-study-classes.player', ['course' => 'grammar-for-writing', 'module' => 'm3'])],
            ['key' => 'm4', 'code' => 'Modul 4', 'title' => 'Stylistic Polish & Syntactic Mastery', 'route' => route('self-study-classes.player', ['course' => 'grammar-for-writing', 'module' => 'm4'])],
        ];

        return view('self-study-class.placement-show', compact(
            'package',
            'questions',
            'isAdmin',
            'students',
            'testType',
            'selectedModule',
            'moduleCounts',
            'allGrammarPackages',
            'allFourSkillPackages',
            'fourSkillPackage',
            'gatePackageId',
            'courseModules'
        ));
    }

    public function submit(Request $request, ScoreGrammarPlacementAttempt $scorer): RedirectResponse
    {
        $packageId = $request->input('package_id');
        $isAdmin = auth()->check() && (
            (method_exists(auth()->user(), 'isAdmin') && auth()->user()->isAdmin()) ||
            in_array(strtolower(auth()->user()->role ?? ''), ['admin', 'superadmin'])
        );

        if ($isAdmin && $packageId) {
            $package = GrammarPlacementPackage::find($packageId);
        } else {
            $package = $this->resolveGatePackage();
        }

        if (!$package || !$package->is_active) {
            abort(404);
        }

        $data = $request->validate([
            'answers' => 'required|array|min:1',
        ]);

        $user = $request->user();

        $result = $scorer->execute($data['answers'], [
            'grammar_placement_package_id' => $package->id,
            'student_name' => $user->name,
            'user_id' => $user->id,
        ]);

        return redirect()->route('self-study-classes.placement.result', $result);
    }

    public function result(GrammarPlacementResult $result)
    {
        if ($result->user_id !== auth()->id()) {
            abort(403);
        }

        return view('self-study-class.placement-result', compact('result'));
    }

    private function resolveGatePackage(): ?GrammarPlacementPackage
    {
        $packageId = Setting::where('key', 'self_study_grammar_placement_package_id')->value('value');

        if (!$packageId) {
            return null;
        }

        return GrammarPlacementPackage::find($packageId);
    }
}
