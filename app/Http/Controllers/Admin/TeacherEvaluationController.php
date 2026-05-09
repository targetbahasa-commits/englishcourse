<?php

namespace App\Http\Controllers\Admin;

use App\Application\Teacher\GetTeacherEvaluations;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TeacherEvaluationController extends Controller
{
    public function __construct(
        private readonly GetTeacherEvaluations $useCase
    ) {}

    /**
     * Display a listing of all teacher evaluations for admin.
     */
    public function index(Request $request)
    {
        $filters = [];
        if ($request->filled('teacher_id')) {
            $filters['teacher_id'] = $request->teacher_id;
        }

        $data = $this->useCase->execute($filters, 20);

        return view('admin.evaluations.index', $data);
    }
}
