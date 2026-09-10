<?php

namespace App\Http\Controllers;

use App\Application\IeltsReading\BuildIeltsReadingIndexData;
use App\Application\IeltsReading\BuildLegacyIeltsReadingMaterialData;
use App\Application\IeltsReading\BuildIeltsReadingMaterialData;
use App\Application\IeltsReading\BuildIeltsReadingSkillData;
use App\Application\IeltsReading\QuestionAnswerKeyResolver;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use App\Http\Controllers\Concerns\EvaluatesClassPeriodEnd;
use App\Models\IeltsReadingPassage;
use App\Models\IeltsReadingPracticeResult;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class IeltsReadingController extends Controller
{
    use HandlesAssignmentAccess;
    use EvaluatesClassPeriodEnd;

    public function __construct(
        private readonly BuildIeltsReadingIndexData $buildIeltsReadingIndexData,
        private readonly BuildIeltsReadingMaterialData $buildIeltsReadingMaterialData,
        private readonly BuildLegacyIeltsReadingMaterialData $buildLegacyIeltsReadingMaterialData,
        private readonly BuildIeltsReadingSkillData $buildIeltsReadingSkillData,
    ) {
        $this->registerAssignmentAccessMiddleware();
    }

    public function index()
    {
        $data = $this->buildIeltsReadingIndexData->handle(Auth::user());
        $data['isClassEnded'] = $this->isStudentClassPeriodEnded('ielts-academic');

        return view('assignments.ielts.reading.index', $data);
    }

    private function getAnswerKeyMaterialIds(): array
    {
        return IeltsReadingPassage::query()
            ->whereHas('questions', function ($query) {
                $query->where(function ($q) {
                    $q->whereNotNull('correct_answer')
                      ->where('correct_answer', '!=', '')
                      ->where('correct_answer', '!=', '[]');
                })
                ->orWhere(function ($q) {
                    $q->whereNotNull('explanation')
                      ->where('explanation', '!=', '');
                })
                ->orWhere('data', 'LIKE', '%"correct_answer"%');
            })
            ->pluck('material_id')
            ->map(static fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->all();
    }

    public function generalIndex()
    {
        $answerKeyMaterialIds = $this->getAnswerKeyMaterialIds();

        $studentResults = Auth::check() ? IeltsReadingPracticeResult::where('user_id', Auth::id())->get()->keyBy('material_id') : collect();

        return view('assignments.ielts.reading.practice-index', [
            'answerKeyMaterialIds' => $answerKeyMaterialIds,
            'isGeneral' => true,
            'isClassEnded' => $this->isStudentClassPeriodEnded('ielts-general-full-package'),
            'studentResults' => $studentResults,
        ]);
    }

    public function generalPracticeIndex()
    {
        return $this->generalIndex();
    }

    public function practiceIndex()
    {
        $answerKeyMaterialIds = $this->getAnswerKeyMaterialIds();
        $questionCounts = $this->getQuestionCounts();

        $studentResults = Auth::check() ? IeltsReadingPracticeResult::where('user_id', Auth::id())->get()->keyBy('material_id') : collect();

        return view('assignments.ielts.reading.practice-index', [
            'answerKeyMaterialIds' => $answerKeyMaterialIds,
            'questionCounts' => $questionCounts,
            'studentResults' => $studentResults,
        ]);
    }

    /**
     * Real per-material question count, keyed by material_id. Each grammar_questions-style
     * row can represent a *block* of several numbered sub-questions (e.g. "Questions 1-7"
     * stored as one row with a correct_answer map of 7 entries), so the count is the sum
     * of correct_answer keys per row, not the row count - the practice-index cards
     * previously hardcoded "40 questions" for every test regardless of the real total.
     */
    private function getQuestionCounts(): array
    {
        $counts = [];
        $passages = IeltsReadingPassage::with('questions')->get();
        foreach ($passages as $passage) {
            $materialId = (int) $passage->material_id;
            $counts[$materialId] = $counts[$materialId] ?? 0;
            foreach ($passage->questions as $question) {
                $answers = $question->correct_answer;
                if (is_array($answers) && count($answers) > 0) {
                    $counts[$materialId] += count($answers);
                } elseif (!empty($answers)) {
                    $counts[$materialId] += 1;
                }
            }
        }
        return $counts;
    }

    public function submitPractice(Request $request)
    {
        $request->validate([
            'material_id' => 'required|integer',
            'answers' => 'required|array',
        ]);

        $materialId = $request->input('material_id');
        $userAnswers = $request->input('answers');

        // Fetch material sections
        $materialData = $this->buildIeltsReadingMaterialData->material($materialId, Auth::user());
        if (!is_array($materialData) || !isset($materialData['content'])) {
            return response()->json(['error' => 'Material not found'], 404);
        }

        $isSingle = isset($materialData['content']['passage_title']);
        $sections = $isSingle ? [$materialData['content']] : $materialData['content'];

        // Generate Answer Key Data from PHP
        $resolver = app(QuestionAnswerKeyResolver::class);
        $keys = [];
        foreach (collect($sections)->flatMap(fn($s) => $s['questions'] ?? []) as $q) {
            $keys = $keys + $resolver->resolve($q);
        }

        $correctCount = 0;
        $totalCount = count($keys);

        // Evaluate user answers server-side
        foreach ($keys as $qid => $data) {
            if (!isset($data['correct'])) continue;
            
            $userAnswer = $userAnswers[$qid] ?? null;
            $isCorrect = false;

            if (is_array($data['correct'])) {
                if (is_array($userAnswer)) {
                    $sortedUser = $userAnswer;
                    $sortedCorrect = $data['correct'];
                    sort($sortedUser);
                    sort($sortedCorrect);
                    $isCorrect = json_encode($sortedUser) === json_encode($sortedCorrect);
                } else {
                    $normalizedCorrect = array_map(fn($c) => strtolower(trim((string)$c)), $data['correct']);
                    $isCorrect = $userAnswer && in_array(strtolower(trim((string)$userAnswer)), $normalizedCorrect);
                }
            } else {
                $ansStr = strtolower(trim((string)($userAnswer ?? '')));
                $corrStr = strtolower(trim((string)($data['correct'] ?? '')));
                $isCorrect = $ansStr === $corrStr && $ansStr !== '';
            }

            if ($isCorrect) {
                $correctCount++;
            }
        }

        // Calculate Band Score
        $isGeneralTest = ($materialId > 100);
        $bandScore = $this->calculateBandScore($correctCount, $isGeneralTest);

        // Save to Database
        if (Auth::check()) {
            IeltsReadingPracticeResult::updateOrCreate(
                [
                    'user_id' => Auth::id(),
                    'material_id' => $materialId,
                ],
                [
                    'correct_count' => $correctCount,
                    'total_questions' => $totalCount,
                    'band_score' => $bandScore,
                    'answers_data' => $userAnswers,
                ]
            );
        }

        return response()->json([
            'correct' => $correctCount,
            'total' => $totalCount,
            'band_score' => $bandScore,
            'answer_key' => $keys,
        ]);
    }

    private function calculateBandScore($correct, bool $isGeneral = false)
    {
        if ($isGeneral) {
            if ($correct >= 40) return 9.0;
            if ($correct >= 39) return 8.5;
            if ($correct >= 37) return 8.0;
            if ($correct >= 36) return 7.5;
            if ($correct >= 34) return 7.0;
            if ($correct >= 32) return 6.5;
            if ($correct >= 30) return 6.0;
            if ($correct >= 27) return 5.5;
            if ($correct >= 23) return 5.0;
            if ($correct >= 19) return 4.5;
            if ($correct >= 15) return 4.0;
            if ($correct >= 12) return 3.5;
            if ($correct >= 9) return 3.0;
            if ($correct >= 6) return 2.5;
            if ($correct >= 4) return 2.0;
            if ($correct >= 2) return 1.0;
            return 0.0;
        }

        if ($correct >= 39) return 9.0;
        if ($correct >= 37) return 8.5;
        if ($correct >= 35) return 8.0;
        if ($correct >= 33) return 7.5;
        if ($correct >= 30) return 7.0;
        if ($correct >= 27) return 6.5;
        if ($correct >= 23) return 6.0;
        if ($correct >= 19) return 5.5;
        if ($correct >= 15) return 5.0;
        if ($correct >= 13) return 4.5;
        if ($correct >= 10) return 4.0;
        if ($correct >= 8) return 3.5;
        if ($correct >= 6) return 3.0;
        if ($correct >= 4) return 2.5;
        if ($correct >= 2) return 2.0;
        if ($correct >= 1) return 1.0;
        return 0.0;
    }

    public function material(int $id)
    {
        $material = $this->buildIeltsReadingMaterialData->material($id, Auth::user());

        if ($material instanceof RedirectResponse) {
            return $material;
        }

        if ($material !== null) {
            if (is_array($material)) {
                $material['isClassEnded'] = $this->isStudentClassPeriodEnded('ielts-academic');
            }

            return view('assignments.ielts.reading.material', $material);
        }

        $legacyMaterial = $this->buildLegacyIeltsReadingMaterialData->material($id);

        if ($legacyMaterial === null) {
            abort(404);
        }

        if (is_array($legacyMaterial)) {
            $legacyMaterial['isClassEnded'] = $this->isStudentClassPeriodEnded('ielts-academic');
        }

        return view('assignments.ielts.reading.material', $legacyMaterial);
    }

    public function skill(string $skill)
    {
        $material = $this->buildIeltsReadingSkillData->handle($skill);

        if ($material === null) {
            abort(404);
        }

        $material['isClassEnded'] = $this->isStudentClassPeriodEnded('ielts-academic');

        return view('assignments.ielts.reading.material', $material);
    }

    public function generalMaterial(int $id)
    {
        $targetId = $id;
        if ($id >= 1 && $id <= 30) {
            if (\App\Models\IeltsReadingPassage::where('material_id', 100 + $id)->exists()) {
                $targetId = 100 + $id;
            }
        }

        $material = $this->buildIeltsReadingMaterialData->material($targetId, Auth::user());

        if ($material instanceof RedirectResponse) {
            return $material;
        }

        if ($material !== null) {
            if (is_array($material)) {
                $material['isClassEnded'] = $this->isStudentClassPeriodEnded('ielts-general-full-package');
                $material['isGeneral'] = true;
            }

            return view('assignments.ielts.reading.material', $material);
        }

        $legacyMaterial = $this->buildLegacyIeltsReadingMaterialData->material($id);

        if ($legacyMaterial === null) {
            abort(404);
        }

        if (is_array($legacyMaterial)) {
            $legacyMaterial['isClassEnded'] = $this->isStudentClassPeriodEnded('ielts-general-full-package');
            $legacyMaterial['isGeneral'] = true;
        }

        return view('assignments.ielts.reading.material', $legacyMaterial);
    }
}
