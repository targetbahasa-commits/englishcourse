<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EnrollmentRequest;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnrollmentRequestController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'pending');

        $requests = EnrollmentRequest::with(['user', 'program', 'classPeriod', 'approver'])
            ->when($status, function ($query, $status) {
                if ($status !== 'all') {
                    $query->where('status', $status);
                }
            })
            ->latest()
            ->paginate(20)
            ->withQueryString();

        // For each request, find the related payment and registration lead
        $userIds = $requests->pluck('user_id')->unique()->filter();

        $paymentMap = \App\Models\Payment::whereIn('user_id', $userIds)
            ->latest()
            ->get()
            ->groupBy(fn($p) => $p->user_id . '_' . $p->program_id)
            ->map(fn($group) => $group->first());

        $leadMap = \App\Models\RegistrationLead::whereIn('converted_user_id', $userIds)
            ->whereNotNull('converted_user_id')
            ->get()
            ->keyBy(fn($l) => $l->converted_user_id . '_' . $l->program_id);

        return view('admin.enrollment-requests.index', compact('requests', 'status', 'paymentMap', 'leadMap'));
    }

    public function approve(Request $request, EnrollmentRequest $enrollmentRequest)
    {
        if ($enrollmentRequest->status !== 'pending') {
            return back()->with('error', 'Request ini sudah tidak pending.');
        }

        $validated = $request->validate([
            'class_period_id' => 'required|exists:class_periods,id',
            'notes' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();

            $enrollmentRequest->update([
                'status' => 'approved',
                'class_period_id' => $validated['class_period_id'],
                'notes' => $validated['notes'],
                'approved_by' => auth()->id(),
                'approved_at' => now()
            ]);

            // Create actual enrollment
            Enrollment::firstOrCreate(
                [
                    'user_id' => $enrollmentRequest->user_id,
                    'program_id' => $enrollmentRequest->program_id,
                ],
                [
                    'class_period_id' => $validated['class_period_id'],
                    'status' => 'active'
                ]
            );

            // Also update the class_period_id on existing enrollment if it was just created/updated
            Enrollment::where('user_id', $enrollmentRequest->user_id)
                ->where('program_id', $enrollmentRequest->program_id)
                ->update(['class_period_id' => $validated['class_period_id']]);
                
            // Update the user's main program_id
            $enrollmentRequest->user->update(['program_id' => $enrollmentRequest->program_id]);

            DB::commit();

            return back()->with('success', 'Pendaftaran berhasil dikonfirmasi dan student telah dimasukkan ke kelas.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan saat konfirmasi: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, EnrollmentRequest $enrollmentRequest)
    {
        if ($enrollmentRequest->status !== 'pending') {
            return back()->with('error', 'Request ini sudah tidak pending.');
        }

        $validated = $request->validate([
            'notes' => 'nullable|string'
        ]);

        $enrollmentRequest->update([
            'status' => 'rejected',
            'notes' => $validated['notes'],
            'approved_by' => auth()->id(),
            'approved_at' => now()
        ]);

        return back()->with('success', 'Pendaftaran berhasil ditolak.');
    }
}
