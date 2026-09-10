<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ResolvesPlacementTestPackage;
use App\Http\Controllers\Controller;
use App\Models\PlacementReadingPassage;
use App\Models\PlacementReadingQuestion;
use App\Models\PlacementTestPackage;
use Illuminate\Http\Request;

class AdminPlacementReadingController extends Controller
{
    use ResolvesPlacementTestPackage;

    private const CEFR_LEVELS = ['A1', 'A2', 'B1', 'B2', 'C1', 'C2'];
    private const ANSWER_LETTERS = ['A', 'B', 'C', 'D'];

    public function index(Request $request)
    {
        $package = $this->resolvePackage($request);
        if (!$package) {
            return redirect()->route('admin.placement-test.packages.index')
                ->with('error', 'Buat paket tes kompetensi terlebih dahulu.');
        }

        $passages = PlacementReadingPassage::where('placement_test_package_id', $package->id)
            ->withCount('questions')
            ->orderBy('order')
            ->orderBy('id')
            ->get();
        $packages = PlacementTestPackage::orderBy('order')->orderBy('id')->get();

        return view('admin.placement-test.reading.index', compact('passages', 'package', 'packages'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'placement_test_package_id' => 'required|exists:placement_test_packages,id',
            'title' => 'required|string|max:255',
            'passage_text' => 'required|string',
            'level' => 'nullable|in:' . implode(',', self::CEFR_LEVELS),
            'status' => 'required|in:draft,ready',
            'order' => 'nullable|integer|min:0',
        ]);

        PlacementReadingPassage::create($data);

        return redirect()->route('admin.placement-test.reading.index', ['package_id' => $data['placement_test_package_id']])
            ->with('success', 'Reading passage created.');
    }

    public function update(Request $request, PlacementReadingPassage $reading)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'passage_text' => 'required|string',
            'level' => 'nullable|in:' . implode(',', self::CEFR_LEVELS),
            'status' => 'required|in:draft,ready',
            'order' => 'nullable|integer|min:0',
        ]);

        $reading->update($data);

        return back()->with('success', 'Reading passage updated.');
    }

    public function destroy(PlacementReadingPassage $reading)
    {
        $reading->delete();

        return back()->with('success', 'Reading passage deleted.');
    }

    public function show(PlacementReadingPassage $reading)
    {
        $reading->load('questions');

        return view('admin.placement-test.reading.show', ['passage' => $reading]);
    }

    public function storeQuestion(Request $request, PlacementReadingPassage $reading)
    {
        $data = $this->validateQuestion($request);
        $reading->questions()->create($data);

        return back()->with('success', 'Question added.');
    }

    public function updateQuestion(Request $request, PlacementReadingPassage $reading, PlacementReadingQuestion $question)
    {
        $data = $this->validateQuestion($request);
        $question->update($data);

        return back()->with('success', 'Question updated.');
    }

    public function destroyQuestion(PlacementReadingPassage $reading, PlacementReadingQuestion $question)
    {
        $question->delete();

        return back()->with('success', 'Question deleted.');
    }

    private function validateQuestion(Request $request): array
    {
        $data = $request->validate([
            'question_text' => 'required|string',
            'options' => 'required|array|size:4',
            'options.*' => 'required|string|max:500',
            'correct_answer' => 'required|in:' . implode(',', self::ANSWER_LETTERS),
            'explanation' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
        ]);

        $data['options'] = array_values($data['options']);

        return $data;
    }
}
