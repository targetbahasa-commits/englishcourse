<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use Illuminate\Http\Request;

class ScholarshipController extends Controller
{
    /**
     * Display a listing of active scholarships.
     */
    public function index()
    {
        $scholarships = Scholarship::where('is_active', true)
            ->where('deadline', '>=', now()->startOfDay())
            ->latest()
            ->paginate(12);

        return view('scholarships.index', compact('scholarships'));
    }

    /**
     * Display the specified scholarship details.
     */
    public function show(Scholarship $scholarship)
    {
        if (!$scholarship->is_active && (!auth()->check() || auth()->user()->role !== 'admin')) {
            abort(404);
        }

        return view('scholarships.show', compact('scholarship'));
    }
}
