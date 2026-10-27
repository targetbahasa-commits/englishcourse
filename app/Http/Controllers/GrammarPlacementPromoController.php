<?php

namespace App\Http\Controllers;

use App\Application\GrammarPlacement\ScoreGrammarPlacementAttempt;
use App\Models\GrammarPlacementPackage;
use App\Models\GrammarPlacementResult;
use Illuminate\Http\Request;

/**
 * Public, unauthenticated Grammar Placement Test flow - the link an admin
 * copies from the packages admin page and sends to a prospective student.
 * Mirrors the other promo/test/* controllers: no login required, protected
 * by Turnstile instead.
 */
class GrammarPlacementPromoController extends Controller
{
    public function show(GrammarPlacementPackage $package)
    {
        if (!$package->is_active) {
            return view('promo.expired');
        }

        $questions = $package->activeQuestions()->get();

        return view('promo.grammar-placement-show', compact('package', 'questions'));
    }

    public function submit(Request $request, GrammarPlacementPackage $package, ScoreGrammarPlacementAttempt $scorer)
    {
        if (!$package->is_active) {
            return view('promo.expired');
        }

        $data = $request->validate([
            'student_name' => 'required|string|max:255',
            'student_phone' => 'nullable|string|max:20',
            'answers' => 'required|array|min:1',
            'cf-turnstile-response' => ['required', new \App\Rules\Turnstile()],
        ]);

        $result = $scorer->execute($data['answers'], [
            'grammar_placement_package_id' => $package->id,
            'student_name' => $data['student_name'],
            'student_phone' => $data['student_phone'] ?? null,
        ]);

        return redirect()->route('promo.test.grammar-placement.result', [$package, $result]);
    }

    public function result(GrammarPlacementPackage $package, GrammarPlacementResult $result)
    {
        if ($result->grammar_placement_package_id !== $package->id) {
            abort(404);
        }

        $result->load('recommendedProgram');

        return view('promo.grammar-placement-result', compact('package', 'result'));
    }
}
