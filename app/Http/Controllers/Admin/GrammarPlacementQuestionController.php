<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GrammarPlacementPackage;
use App\Models\GrammarPlacementQuestion;
use Illuminate\Http\Request;

class GrammarPlacementQuestionController extends Controller
{
    private const CEFR_LEVELS = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'];

    public function index(GrammarPlacementPackage $package)
    {
        $questions = $package->questions()->ordered()->get();

        return view('admin.grammar-placement.questions', compact('package', 'questions'));
    }

    public function store(Request $request, GrammarPlacementPackage $package)
    {
        $data = $request->validate([
            'question_text' => 'required|string',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'option_d' => 'required|string|max:255',
            'correct_option' => 'required|in:a,b,c,d',
            'cefr_level' => 'nullable|in:' . implode(',', self::CEFR_LEVELS),
            'order' => 'nullable|integer|min:0',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);

        $package->questions()->create($data);

        return back()->with('success', 'Soal grammar berhasil ditambahkan.');
    }

    public function update(Request $request, GrammarPlacementPackage $package, GrammarPlacementQuestion $question)
    {
        $data = $request->validate([
            'question_text' => 'required|string',
            'option_a' => 'required|string|max:255',
            'option_b' => 'required|string|max:255',
            'option_c' => 'required|string|max:255',
            'option_d' => 'required|string|max:255',
            'correct_option' => 'required|in:a,b,c,d',
            'cefr_level' => 'nullable|in:' . implode(',', self::CEFR_LEVELS),
            'order' => 'nullable|integer|min:0',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);

        $question->update($data);

        return back()->with('success', 'Soal grammar berhasil diperbarui.');
    }

    public function destroy(GrammarPlacementPackage $package, GrammarPlacementQuestion $question)
    {
        $question->delete();

        return back()->with('success', 'Soal grammar berhasil dihapus.');
    }
}
