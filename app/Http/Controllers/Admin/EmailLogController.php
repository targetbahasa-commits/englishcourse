<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmailLog;

class EmailLogController extends Controller
{
    public function index(Request $request)
    {
        $query = EmailLog::with(['user', 'registrationLead', 'payment'])
            ->orderBy('sent_at', 'desc')
            ->orderByDesc('id');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('to_email', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('related_type')) {
            $query->where('related_type', $request->related_type);
        }

        $logs = $query->paginate(25)->withQueryString();

        $counts = [
            'total'     => EmailLog::count(),
            'sent'      => EmailLog::where('status', 'sent')->count(),
            'failed'    => EmailLog::where('status', 'failed')->count(),
        ];

        return view('admin.email-logs.index', compact('logs', 'counts'));
    }

    public function show(EmailLog $emailLog)
    {
        $emailLog->load(['user', 'registrationLead', 'payment']);
        return view('admin.email-logs.show', compact('emailLog'));
    }
}
