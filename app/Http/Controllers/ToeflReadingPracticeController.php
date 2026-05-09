<?php

namespace App\Http\Controllers;

use App\Application\ToeflReadingPractice\BuildReadingPracticeCatalog;
use App\Application\ToeflReadingPractice\BuildReadingPracticePackageViewData;
use App\Http\Controllers\Concerns\HandlesAssignmentAccess;

class ToeflReadingPracticeController extends Controller
{
    use HandlesAssignmentAccess;

    public function __construct(
        private readonly BuildReadingPracticeCatalog $buildReadingPracticeCatalog,
        private readonly BuildReadingPracticePackageViewData $buildReadingPracticePackageViewData,
    ) {
        $this->registerAssignmentAccessMiddleware();
    }

    public function index()
    {
        return view('assignments.toefl-itp.reading.practice-index', $this->buildReadingPracticeCatalog->handle());
    }

    public function showPackage(int $package)
    {
        $viewData = $this->buildReadingPracticePackageViewData->handle($package);

        if ($viewData) {
            return view('assignments.toefl-itp.reading.practice-package', $viewData);
        }

        return redirect()->route('assignments.toefl-itp.reading.practice')
            ->with('error', 'Paket ' . $package . ' belum tersedia.');
    }
}