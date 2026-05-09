<?php

namespace App\Http\Controllers;

use App\Application\FreeTest\GetTestResult;
use App\Application\FreeTest\SubmitFreeTest;
use App\Domain\FreeTest\Repositories\FreeTestRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FreeTestController extends Controller
{
    private const VALID_TYPES = ['ielts_academic', 'ielts_general', 'toefl_itp', 'pte_academic'];

    public function __construct(
        private readonly SubmitFreeTest $submitFreeTest,
        private readonly GetTestResult $getTestResult,
        private readonly FreeTestRepository $repository,
    ) {
    }

    public function show($type)
    {
        if (! in_array($type, self::VALID_TYPES)) {
            abort(404);
        }

        return view('free-tests.show', compact('type'));
    }

    public function submit(Request $request, $type)
    {
        if (! in_array($type, self::VALID_TYPES)) {
            abort(404);
        }

        $evaluationData = [
            'strengths'   => ['Reading Comprehension', 'Basic Grammar Structures'],
            'weaknesses'  => ['Advanced Vocabulary', 'Listening Speed & Accuracy'],
        ];

        $result = $this->submitFreeTest->execute(Auth::id(), $type, $evaluationData);

        return redirect()->route('free-test.result', $result->id);
    }

    public function result($id)
    {
        $data = $this->getTestResult->execute((int) $id, Auth::id(), Auth::user()->role);

        return view('free-tests.result', $data);
    }

    public function downloadCertificate($id)
    {
        $result = $this->repository->findResultOrFail((int) $id, Auth::id());
        $certificate = $this->repository->findCertificate($result->test_type);

        if (! $certificate) {
            return back()->with('error', 'Sertifikat tidak tersedia untuk jenis ujian ini.');
        }

        $data = [
            'user'        => Auth::user(),
            'result'      => $result,
            'certificate' => $certificate,
            'testName'    => ucwords(str_replace('_', ' ', $result->test_type)),
            'date'        => $result->created_at->format('d F Y'),
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('free-tests.certificate-pdf', $data)
            ->setPaper('a4', 'landscape');

        return $pdf->download('Sertifikat_'.str_replace(' ', '_', $data['testName']).'_'.Auth::user()->name.'.pdf');
    }
}
