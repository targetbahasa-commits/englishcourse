<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Application\AdminLead\GetLeadsList;
use App\Application\AdminLead\GetLeadsStats;
use App\Application\AdminLead\UpdateLeadStatus;

class AdminLeadController extends Controller
{
    public function __construct(
        private readonly GetLeadsList $getLeadsList,
        private readonly GetLeadsStats $getLeadsStats,
        private readonly UpdateLeadStatus $updateLeadStatus
    ) {
    }

    public function index(Request $request)
    {
        $status = $request->has('status') && $request->status !== '' ? $request->status : null;
        $search = $request->has('search') && $request->search !== '' ? $request->search : null;

        $leads = $this->getLeadsList->execute($status, $search, 15);
        $stats = $this->getLeadsStats->execute();

        return view('admin.leads.index', [
            'leads' => $leads,
            'totalLeads' => $stats['totalLeads'],
            'pendingLeads' => $stats['pendingLeads'],
            'contactedLeads' => $stats['contactedLeads'],
            'enrolledLeads' => $stats['enrolledLeads'],
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,contacted,enrolled'
        ]);

        $this->updateLeadStatus->execute((int) $id, $request->status);

        return back()->with('success', 'Lead status updated successfully.');
    }
}
