<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\ResolvesPlacementTestPackage;
use App\Http\Controllers\Controller;
use App\Models\PlacementListeningBank;
use App\Models\PlacementListeningQuestion;
use App\Models\PlacementTestPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminPlacementListeningController extends Controller
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

        $banks = PlacementListeningBank::where('placement_test_package_id', $package->id)
            ->withCount('questions')
            ->orderBy('order')
            ->orderBy('id')
            ->get();
        $packages = PlacementTestPackage::orderBy('order')->orderBy('id')->get();

        return view('admin.placement-test.listening.index', compact('banks', 'package', 'packages'));
    }

    public function store(Request $request)
    {
        $packageId = $request->validate(['placement_test_package_id' => 'required|exists:placement_test_packages,id'])['placement_test_package_id'];
        $data = $this->validateBank($request);
        $data['placement_test_package_id'] = $packageId;

        if ($request->hasFile('audio')) {
            $data['audio'] = $request->file('audio')->store('placement-listening', 'public');
        }

        PlacementListeningBank::create($data);

        return redirect()->route('admin.placement-test.listening.index', ['package_id' => $packageId])
            ->with('success', 'Listening bank created.');
    }

    public function update(Request $request, PlacementListeningBank $listening)
    {
        $data = $this->validateBank($request);

        if ($request->hasFile('audio')) {
            if ($listening->audio) {
                Storage::disk('public')->delete($listening->audio);
            }
            $data['audio'] = $request->file('audio')->store('placement-listening', 'public');
        }

        $listening->update($data);

        return back()->with('success', 'Listening bank updated.');
    }

    public function destroy(PlacementListeningBank $listening)
    {
        if ($listening->audio) {
            Storage::disk('public')->delete($listening->audio);
        }
        $listening->delete();

        return back()->with('success', 'Listening bank deleted.');
    }

    public function show(PlacementListeningBank $listening)
    {
        $listening->load('questions');

        return view('admin.placement-test.listening.show', ['bank' => $listening]);
    }

    public function storeQuestion(Request $request, PlacementListeningBank $listening)
    {
        $data = $this->validateQuestion($request);
        $listening->questions()->create($data);

        return back()->with('success', 'Question added.');
    }

    public function updateQuestion(Request $request, PlacementListeningBank $listening, PlacementListeningQuestion $question)
    {
        $data = $this->validateQuestion($request);
        $question->update($data);

        return back()->with('success', 'Question updated.');
    }

    public function destroyQuestion(PlacementListeningBank $listening, PlacementListeningQuestion $question)
    {
        $question->delete();

        return back()->with('success', 'Question deleted.');
    }

    private function validateBank(Request $request): array
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'level' => 'nullable|in:' . implode(',', self::CEFR_LEVELS),
            'transcript' => 'required|string',
            'duration' => 'nullable|integer|min:0',
            'status' => 'required|in:draft,ready',
            'order' => 'nullable|integer|min:0',
            'audio' => 'nullable|file|mimes:webm,mp3,wav,m4a,ogg|max:20480',
        ]);

        unset($data['audio']);

        return $data;
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
