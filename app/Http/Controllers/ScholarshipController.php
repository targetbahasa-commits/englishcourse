<?php

namespace App\Http\Controllers;

use App\Application\Scholarship\ListActiveScholarships;
use Illuminate\Http\Request;

class ScholarshipController extends Controller
{
    public function __construct(
        private readonly ListActiveScholarships $listActiveScholarships,
    ) {
    }

    public function index()
    {
        $scholarships = $this->listActiveScholarships->handle(12);

        return view('scholarships.index', compact('scholarships'));
    }

    public function show(\App\Models\Scholarship $scholarship)
    {
        if (!$scholarship->is_active && (!auth()->check() || auth()->user()->role !== 'admin')) {
            abort(404);
        }

        return view('scholarships.show', compact('scholarship'));
    }
}
