<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OnlineTestResult;
use Illuminate\Http\Request;

class OnlineTestResultController extends Controller
{
    
    public function updateStatus(\Illuminate\Http\Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:completed,in_progress,abandoned,not_started'
        ]);

        $result = \App\Models\OnlineTestResult::findOrFail($id);
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
        $query = OnlineTestResult::with('taker')
            ->whereHas('user', function ($q) {
                $q->where('role', '!=', 'admin');
            })
            ->orderByDesc('created_at');

        // Filter by test type
        if ($request->filled('test_type')) {
            $query->where('test_slug', $request->test_type);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search by taker name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('taker', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('candidate_id', 'like', "%{$search}%");
            });
        }

        $results = $query->paginate(20)->withQueryString();

        // Standard test types for filter dropdown
        $testTypes = collect([
            (object)['test_slug' => 'ielts_academic', 'test_label' => 'IELTS Academic'],
            (object)['test_slug' => 'ielts_general', 'test_label' => 'IELTS General'],
            (object)['test_slug' => 'toefl_itp', 'test_label' => 'TOEFL ITP'],
            (object)['test_slug' => 'pte_academic', 'test_label' => 'PTE Academic'],
        ]);

        // Get unique statuses for filter dropdown
        $statuses = OnlineTestResult::select('status')
            ->distinct()
            ->orderBy('status')
            ->pluck('status');
            
        // Stats
        $stats = [
            'total' => $results->total(),
            'completed' => OnlineTestResult::whereHas('user', function ($q) {
                $q->where('role', '!=', 'admin');
            })->where('status', 'completed')->count(),
            'in_progress' => OnlineTestResult::whereHas('user', function ($q) {
                $q->where('role', '!=', 'admin');
            })->where('status', 'in_progress')->count(),
            'takers' => OnlineTestResult::whereHas('user', function ($q) {
                $q->where('role', '!=', 'admin');
            })->distinct('online_test_taker_id')->count('online_test_taker_id'),
        ];

        return view('admin.online-test-results.index', compact('results', 'testTypes', 'statuses', 'stats'));
    }

    public function certificate($id)
    {
        $result = \App\Models\OnlineTestResult::with('taker')->findOrFail($id);
        $certificate = \App\Models\FreeTestCertificate::where('test_type', $result->test_slug)->whereNull('program_id')->first();

        if (!$certificate) {
            return back()->with('error', 'Sertifikat untuk tipe tes ini belum disiapkan.');
        }

        $date = $result->completed_at ? \Carbon\Carbon::parse($result->completed_at)->format('d M Y') : $result->created_at->format('d M Y');

        $data = [
            'result'      => $result,
            'certificate' => $certificate,
            'testName'    => $result->test_label ?? 'Online Test',
            'user'        => (object) ['name' => $result->taker->name ?? 'Student'],
            'date'        => $date,
        ];

        return \Barryvdh\DomPDF\Facade\Pdf::loadView('free-tests.certificate-pdf', $data)->stream('Certificate.pdf');
    }

    public function show($id)
    {
        $result = OnlineTestResult::with('taker')->findOrFail($id);

        return view('admin.online-test-results.show', compact('result'));
    }
}
