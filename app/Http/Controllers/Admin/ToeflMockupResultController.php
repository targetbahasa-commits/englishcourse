<?php

namespace App\Http\Controllers\Admin;

use App\Application\Program\ManagePrograms;
use App\Application\ToeflMockup\ListMockupResults;
use App\Http\Controllers\Controller;
use App\Models\ToeflMockupResult;

class ToeflMockupResultController extends Controller
{
    public function __construct(
        private readonly ListMockupResults $listMockupResults,
        private readonly ManagePrograms $managePrograms
    ) {}

    
    public function updateStatus(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:completed,in_progress,abandoned,not_started'
        ]);

        $result = \App\Models\ToeflMockupResult::findOrFail($id);
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

    public function index(\Illuminate\Http\Request $request)
    {
        $query = \App\Models\ToeflMockupResult::where('is_reported', true)->with('user')
            ->whereHas('user', function ($q) {
                $q->where('role', '!=', 'admin');
            })
            ->orderByDesc('created_at');

        // Search by name, email, or candidate ID
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by test type
        if ($request->filled('test_type') && $request->test_type !== 'All Types') {
            $slug = $request->test_type;
            
            if (str_starts_with($slug, 'toefl-itp-mock-package-')) {
                $packageNum = str_replace('toefl-itp-mock-package-', '', $slug);
                $query->where('exam_type', 'toefl_itp')
                      ->where('test_family', 'mock_test')
                      ->where('package_number', $packageNum);
            } elseif (str_starts_with($slug, 'cambridge-')) {
                $query->where(function($q) use ($slug) {
                    $val = str_replace('-', '_', $slug);
                    $q->where('test_family', 'like', "%{$slug}%")
                      ->orWhere('source_context', 'like', "%{$slug}%")
                      ->orWhere('test_family', 'like', "%{$val}%")
                      ->orWhere('source_context', 'like', "%{$val}%");
                });
            } else {
                $query->where('exam_type', $slug);
            }
        }

        $results = $query->paginate(15)->withQueryString();

        // Populate exam types dynamically from Mock Tests
        $mockPrograms = $this->managePrograms->listMockTests()['programs'];
        
        $testTypes = collect([]);
        foreach ($mockPrograms as $program) {
            $testTypes->put($program->slug, $program->name);
        }

        // Stats
        $stats = [
            'total' => $results->total(),
            'completed' => $results->total(), // All mockup results are completed
            'in_progress' => 0, // Mockup results don't have in-progress state
            'takers' => \App\Models\ToeflMockupResult::where('is_reported', true)->whereHas('user', function ($q) {
                $q->where('role', '!=', 'admin');
            })->distinct('email')->count('email'), // Count unique emails
        ];

        return view('admin.toefl-mockup-results.index', compact('results', 'testTypes', 'stats'));
    }

    public function certificate($id)
    {
        $result = \App\Models\ToeflMockupResult::where('is_reported', true)->with('user')->findOrFail($id);
        $testType = $result->exam_type ?? 'toefl_itp'; // Fallback to toefl_itp
        $certificate = \App\Models\FreeTestCertificate::where('test_type', $testType)->whereNull('program_id')->first();

        if (!$certificate) {
            return back()->with('error', 'Sertifikat untuk tipe tes ini belum disiapkan.');
        }

        $date = $result->completed_at ? \Carbon\Carbon::parse($result->completed_at)->format('d M Y') : $result->created_at->format('d M Y');

        $data = [
            'result'      => $result,
            'certificate' => $certificate,
            'testName'    => 'Mock Test',
            'user'        => (object) ['name' => $result->name ?? ($result->user->name ?? 'Student')],
            'date'        => $date,
        ];

        return \Barryvdh\DomPDF\Facade\Pdf::loadView('free-tests.certificate-pdf', $data)->stream('Certificate.pdf');
    }

    public function show(int $id)
    {
        $result = ToeflMockupResult::where('is_reported', true)->with('user')->findOrFail($id);

        return view('admin.toefl-mockup-results.show', compact('result'));
    }
}
