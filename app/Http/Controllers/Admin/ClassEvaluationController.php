<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClassEvaluationController extends Controller
{
    /**
     * Display a listing of all class evaluations for admin.
     */
    public function index(Request $request)
    {
        // Currently a placeholder/empty state for Class Evaluations
        return view('admin.class-evaluations.index');
    }
}
