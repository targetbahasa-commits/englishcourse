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
                $query->where('test_type', $request->test_type);
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
            (object)['test_slug' => 'introductory-grammar-for-writing', 'test_label' => 'Introductory Grammar for Writing'],
            (object)['test_slug' => 'complexity-grammar-for-writing', 'test_label' => 'Grammar for Writing Complexity'],
            (object)['test_slug' => 'proficiency-grammar-for-writing', 'test_label' => 'Grammar for Writing Proficiency'],
            (object)['test_slug' => 'fast-track-grammar-for-writing', 'test_label' => 'Grammar for Writing Fast Track'],
            (object)['test_slug' => 'introductory-speaking', 'test_label' => 'Introductory Speaking'],
            (object)['test_slug' => 'intermediate-speaking', 'test_label' => 'Intermediate Speaking'],
            (object)['test_slug' => 'advanced-speaking', 'test_label' => 'Advanced Speaking'],
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

        $date = $result->completed_at ? \Carbon\Carbon::parse($result->completed_at)->format('d M Y') : $result->created_at->format('d M Y');

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
}
