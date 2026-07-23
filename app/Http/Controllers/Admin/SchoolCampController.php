<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RegistrationLead;
use Illuminate\Http\Request;

class SchoolCampController extends Controller
{
    /**
     * Display a listing of School English Camp leads.
     */
    public function index(Request $request)
    {
        $query = RegistrationLead::query()
            ->where('program_interest', 'PARE English School Camp')
            ->orWhere('source', 'school_program');

        // Optional filtering by status
        if ($request->filled('status')) {
            $query->where('status', $request->query('status'));
        }

        $leads = $query->orderBy('created_at', 'desc')->paginate(20)->withQueryString();

        return view('admin.school-camp.index', compact('leads'));
    }
}
