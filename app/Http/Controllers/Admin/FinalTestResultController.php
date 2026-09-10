<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FinalTestResult;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class FinalTestResultController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:completed,in_progress,abandoned,not_started'
        ]);

        if (!Schema::hasTable((new FinalTestResult())->getTable())) {
            return response()->json(['error' => 'Table not found'], 404);
        }

        $result = FinalTestResult::findOrFail($id);
        $result->status = $request->status;
        
        if ($request->status === 'completed' && !$result->completed_at) {
            $result->completed_at = now();
        }
        
        $result->save();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'status' => $result->status]);
        }

        return back()->with('success', 'Status updated successfully.');
    }


    public function index(Request $request)
    {
        $page = (int) $request->get('page', 1);
        $perPage = 20;

        if (Schema::hasTable((new FinalTestResult())->getTable())) {
            $query = FinalTestResult::query()->orderByDesc('created_at');

            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('candidate_id', 'like', "%{$search}%");
                });
            }

            if ($request->filled('test_type')) {
                $type = $request->test_type;
                $typeUnderscore = str_replace('-', '_', $type);
                $typeHyphen = str_replace('_', '-', $type);
                $query->where(function ($q) use ($type, $typeUnderscore, $typeHyphen) {
                    $q->where('test_type', $type)
                      ->orWhere('test_type', $typeUnderscore)
                      ->orWhere('test_type', $typeHyphen);
                });
            }

            if ($request->filled('status')) {
                $query->where('status', $request->status);
            }

            $results = $query->paginate($perPage)->withQueryString();
        } else {
            $results = new LengthAwarePaginator([], 0, $perPage, $page, [
                'path' => url()->current(),
                'query' => request()->query(),
            ]);
        }

        // Offer a fuller list of final-test types used across the app
        $testTypes = collect([
            (object)['test_slug' => 'toefl_itp', 'test_label' => 'TOEFL ITP'],
            (object)['test_slug' => 'ielts_academic', 'test_label' => 'IELTS Academic'],
            (object)['test_slug' => 'ielts_general', 'test_label' => 'IELTS General'],
            (object)['test_slug' => 'pte_academic', 'test_label' => 'PTE Academic'],
            (object)['test_slug' => 'introductory_grammar_for_writing', 'test_label' => 'Introductory Grammar for Writing'],
            (object)['test_slug' => 'complexity_grammar_for_writing', 'test_label' => 'Grammar for Writing Complexity'],
            (object)['test_slug' => 'proficiency_grammar_for_writing', 'test_label' => 'Grammar for Writing Proficiency'],
            (object)['test_slug' => 'fast_track_grammar_for_writing', 'test_label' => 'Grammar for Writing Fast Track'],
            (object)['test_slug' => 'introductory_speaking', 'test_label' => 'Introductory Speaking'],
            (object)['test_slug' => 'intermediate_speaking', 'test_label' => 'Intermediate Speaking'],
            (object)['test_slug' => 'advanced_speaking', 'test_label' => 'Advanced Speaking'],
        ]);

        $statuses = collect();
        if (Schema::hasTable((new FinalTestResult())->getTable())) {
            $statuses = FinalTestResult::select('status')->distinct()->pluck('status')->filter()->values();
        }

        $stats = [
            'total' => $results->total(),
            'completed' => Schema::hasTable((new FinalTestResult())->getTable()) ? FinalTestResult::where('status', 'completed')->count() : 0,
            'in_progress' => Schema::hasTable((new FinalTestResult())->getTable()) ? FinalTestResult::where('status', 'in_progress')->count() : 0,
            'takers' => Schema::hasTable((new FinalTestResult())->getTable()) ? FinalTestResult::distinct('email')->count('email') : 0,
        ];

        return view('admin.final-test-results.index', compact('results', 'testTypes', 'statuses', 'stats'));
    }

    public function certificate($id)
    {
        $result = \App\Models\FinalTestResult::findOrFail($id);
        $certificate = \App\Models\FreeTestCertificate::where('test_type', $result->test_type)->whereNull('program_id')->first();

        if (!$certificate) {
            return back()->with('error', 'Sertifikat untuk tipe tes ini belum disiapkan.');
        }

        $date = $result->completed_at ? \Carbon\Carbon::parse($result->completed_at)->format('d F Y') : $result->created_at->format('d F Y');

        $data = [
            'result'      => $result,
            'certificate' => $certificate,
            'testName'    => $result->test_label ?? 'Final Test',
            'user'        => (object) ['name' => $result->name],
            'date'        => $date,
        ];

        return \Barryvdh\DomPDF\Facade\Pdf::loadView('free-tests.certificate-pdf', $data)->stream('Certificate.pdf');
    }

    public function show($id)
    {
        if (!Schema::hasTable((new FinalTestResult())->getTable())) {
            abort(404);
        }

        $result = FinalTestResult::find($id);

        if (!$result) {
            abort(404);
        }

        return view('admin.final-test-results.show', ['result' => $result]);
    }

    public function updateEvaluation(Request $request, $id)
    {
        $result = FinalTestResult::findOrFail($id);

        $validated = $request->validate([
            'score' => 'required|numeric|min:0|max:100',
            'grammar_score' => 'nullable|numeric|min:0|max:40',
            'lexical_score' => 'nullable|numeric|min:0|max:30',
            'accuracy_score' => 'nullable|numeric|min:0|max:30',
            'passed' => 'nullable|boolean',
            'cefr_level' => 'nullable|string|max:100',
            'ielts_equivalent' => 'nullable|string|max:100',
            'predicate' => 'nullable|string|max:100',
            'feedback_overview' => 'nullable|string|max:5000',
            'feedback_strengths' => 'nullable|string|max:5000',
            'feedback_improvements' => 'nullable|string|max:5000',
            'teacher_notes' => 'nullable|string|max:5000',
            'modules' => 'nullable|array',
        ]);

        $score = (float) $validated['score'];
        $answersData = $result->answers_data ?? [];

        $grammarScore = isset($validated['grammar_score']) ? (float) $validated['grammar_score'] : ($answersData['criteria']['grammar_complexity']['score'] ?? null);
        $lexicalScore = isset($validated['lexical_score']) ? (float) $validated['lexical_score'] : ($answersData['criteria']['lexical_resource']['score'] ?? null);
        $accuracyScore = isset($validated['accuracy_score']) ? (float) $validated['accuracy_score'] : ($answersData['criteria']['translation_accuracy']['score'] ?? null);

        $answersData['score'] = $score;
        $answersData['passed'] = $request->has('passed') ? $request->boolean('passed') : ($score >= 70);

        if ($request->filled('cefr_level')) {
            $answersData['cefr_level'] = $validated['cefr_level'];
        }
        if ($request->filled('ielts_equivalent')) {
            $answersData['ielts_equivalent'] = $validated['ielts_equivalent'];
        }
        if ($request->filled('predicate')) {
            $answersData['predicate'] = $validated['predicate'];
        }

        // Criteria updates
        if ($grammarScore !== null) {
            $answersData['criteria']['grammar_complexity'] = [
                'label' => 'Grammar & Structural Mastery (10 Modul)',
                'score' => $grammarScore,
                'max_score' => 40,
                'percentage' => round(($grammarScore / 40) * 100),
            ];
        }
        if ($lexicalScore !== null) {
            $answersData['criteria']['lexical_resource'] = [
                'label' => 'Lexical Resource & Academic Keywords',
                'score' => $lexicalScore,
                'max_score' => 30,
                'percentage' => round(($lexicalScore / 30) * 100),
            ];
        }
        if ($accuracyScore !== null) {
            $answersData['criteria']['translation_accuracy'] = [
                'label' => 'Translation Fidelity & Completeness',
                'score' => $accuracyScore,
                'max_score' => 30,
                'percentage' => round(($accuracyScore / 30) * 100),
            ];
        }

        // Feedback updates
        $feedbackOverview = $request->input('feedback_overview', $answersData['feedback']['overview'] ?? '');
        $strengthsRaw = $request->input('feedback_strengths');
        $improvementsRaw = $request->input('feedback_improvements');

        $strengthsList = is_string($strengthsRaw)
            ? array_values(array_filter(array_map('trim', explode("\n", $strengthsRaw))))
            : ($answersData['feedback']['strengths'] ?? []);

        $improvementsList = is_string($improvementsRaw)
            ? array_values(array_filter(array_map('trim', explode("\n", $improvementsRaw))))
            : ($answersData['feedback']['improvements'] ?? []);

        $answersData['feedback'] = [
            'overview' => $feedbackOverview,
            'strengths' => $strengthsList,
            'improvements' => $improvementsList,
        ];

        // Modules toggle update
        if ($request->has('modules_submitted') && isset($answersData['module_diagnostics']) && is_array($answersData['module_diagnostics'])) {
            $checkedModules = $request->input('modules', []);
            $masteredCount = 0;
            foreach ($answersData['module_diagnostics'] as $mIdx => &$m) {
                $isMastered = !empty($checkedModules[$mIdx]) || !empty($checkedModules[(string) $mIdx]);
                $m['matched'] = $isMastered;
                $m['mastered'] = $isMastered;
                if ($isMastered) {
                    $masteredCount++;
                }
            }
            unset($m);
            $answersData['mastered_modules_count'] = $masteredCount;
            $answersData['review_modules_count'] = count($answersData['module_diagnostics']) - $masteredCount;
        }

        $result->score = $score;
        $result->answers_data = $answersData;

        $evalData = $result->evaluation_data ?? [];
        $evalData['reviewed_by'] = \Illuminate\Support\Facades\Auth::user()?->name ?? 'Admin';
        $evalData['reviewed_by_id'] = \Illuminate\Support\Facades\Auth::id();
        $evalData['reviewed_at'] = now()->toDateTimeString();
        $evalData['cefr'] = $answersData['cefr_level'] ?? ($evalData['cefr'] ?? null);
        $evalData['predicate'] = $answersData['predicate'] ?? ($evalData['predicate'] ?? null);
        $evalData['passed'] = $answersData['passed'] ?? ($result->score >= 70);
        if ($request->filled('teacher_notes')) {
            $evalData['teacher_notes'] = $validated['teacher_notes'];
        }
        $result->evaluation_data = $evalData;

        $result->save();

        return back()->with('success', 'Evaluasi final test berhasil diperbarui dan disimpan.');
    }

    public function reEvaluate(Request $request, $id)
    {
        $result = FinalTestResult::findOrFail($id);

        $answersData = $result->answers_data ?? [];
        $paragraphAnswers = [];

        if (!empty($answersData['paragraphs']) && is_array($answersData['paragraphs'])) {
            foreach ($answersData['paragraphs'] as $pNum => $pData) {
                $paragraphAnswers[$pNum] = $pData['user_answer'] ?? '';
            }
        } elseif (!empty($answersData['user_translation'])) {
            $parts = explode("\n\n", (string) $answersData['user_translation']);
            foreach ($parts as $idx => $part) {
                $paragraphAnswers[$idx + 1] = trim($part);
            }
        }

        if (empty($paragraphAnswers)) {
            return back()->with('error', 'Tidak dapat menemukan teks terjemahan peserta untuk dihitung ulang.');
        }

        $variant = 'fast-track';
        $testType = (string) ($result->test_type ?? '');
        if (str_contains($testType, 'introductory')) {
            $variant = 'introductory';
        } elseif (str_contains($testType, 'complexity')) {
            $variant = 'complexity';
        } elseif (str_contains($testType, 'proficiency')) {
            $variant = 'proficiency';
        }

        $testData = (new \App\Application\GrammarWriting\GrammarForWritingFinalTestCatalog())->getData($variant);

        $evaluator = new \App\Application\GrammarWriting\EvaluateGrammarForWritingFinalTest();
        $newEvaluation = $evaluator->evaluate($paragraphAnswers, $testData);

        $result->score = $newEvaluation['score'];
        $result->answers_data = $newEvaluation;

        $evalData = $result->evaluation_data ?? [];
        $evalData['re_evaluated_at'] = now()->toDateTimeString();
        $evalData['re_evaluated_by'] = \Illuminate\Support\Facades\Auth::user()?->name ?? 'Admin';
        $evalData['cefr'] = $newEvaluation['cefr_level'];
        $evalData['predicate'] = $newEvaluation['predicate'];
        $evalData['passed'] = $newEvaluation['passed'];
        $result->evaluation_data = $evalData;

        $result->save();

        return back()->with('success', 'Evaluasi otomatis berhasil dihitung ulang secara menyeluruh (Skor baru: ' . $newEvaluation['score'] . ').');
    }

    public function destroy($id)
    {
        $result = FinalTestResult::findOrFail($id);
        $name = $result->name;
        $result->delete();

        return redirect()->route('admin.final-test-results.index')->with('success', "Data hasil ujian {$name} berhasil dihapus.");
    }
}
