<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GrammarPlacementResult;
use Illuminate\Http\Request;

class GrammarPlacementController extends Controller
{
    public function resultsIndex(Request $request)
    {
        $query = GrammarPlacementResult::with(['recommendedProgram', 'package'])->orderByDesc('id');

        if ($request->filled('package_id')) {
            $query->where('grammar_placement_package_id', $request->package_id);
        }

        $results = $query->paginate(20)->withQueryString();

        return view('admin.grammar-placement.results.index', compact('results'));
    }

    public function resultsShow(GrammarPlacementResult $result)
    {
        $result->load(['recommendedProgram', 'package', 'student']);

        return view('admin.grammar-placement.results.show', compact('result'));
    }
}
