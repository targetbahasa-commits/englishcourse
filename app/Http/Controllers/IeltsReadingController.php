<?php

namespace App\Http\Controllers;

use App\Application\IeltsReading\BuildIeltsReadingIndexData;
use App\Application\IeltsReading\BuildLegacyIeltsReadingMaterialData;
use App\Application\IeltsReading\BuildIeltsReadingMaterialData;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;
use App\Models\IeltsReadingPassage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class IeltsReadingController extends Controller
{
    use HandlesAssignmentAccess;

    public function __construct(
        private readonly BuildIeltsReadingIndexData $buildIeltsReadingIndexData,
        private readonly BuildIeltsReadingMaterialData $buildIeltsReadingMaterialData,
        private readonly BuildLegacyIeltsReadingMaterialData $buildLegacyIeltsReadingMaterialData,
    ) {
        $this->registerAssignmentAccessMiddleware();
    }

    public function index()
    {
        return view('assignments.ielts.reading.index', $this->buildIeltsReadingIndexData->handle(Auth::user()));
    }

    public function practiceIndex()
    {
        $answerKeyMaterialIds = IeltsReadingPassage::query()
            ->whereHas('questions', function ($query) {
                $query->whereNotNull('correct_answer')
                    ->orWhere(function ($subQuery) {
                        $subQuery->whereNotNull('explanation')
                            ->where('explanation', '!=', '');
                    });
            })
            ->pluck('material_id')
            ->map(static fn ($id) => (int) $id)
            ->unique()
            ->values()
            ->all();

        return view('assignments.ielts.reading.practice-index', [
            'answerKeyMaterialIds' => $answerKeyMaterialIds,
        ]);
    }

    public function material(int $id)
    {
        $material = $this->buildIeltsReadingMaterialData->material($id, Auth::user());

        if ($material instanceof RedirectResponse) {
            return $material;
        }

        if ($material !== null) {
            return view('assignments.ielts.reading.material', $material);
        }

        $legacyMaterial = $this->buildLegacyIeltsReadingMaterialData->material($id);

        if ($legacyMaterial === null) {
            abort(404);
        }

        return view('assignments.ielts.reading.material', $legacyMaterial);
    }
}
