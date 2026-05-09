<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\EmailLog;

class EmailLogController extends Controller
{
    public function index()
    {
        $logs = EmailLog::orderBy('sent_at', 'desc')->paginate(20);
        return view('admin.email-logs.index', compact('logs'));
    }

    public function show(EmailLog $emailLog)
    {
        return view('admin.email-logs.show', compact('emailLog'));
    }
}
