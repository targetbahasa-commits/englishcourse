<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrochureController extends Controller
{
    /**
     * Display the public brochure page (online / offline).
     */
    public function index(string $type = 'offline')
    {
        if (!in_array($type, ['online', 'offline'])) {
            abort(404);
        }

        $programs = Program::where('is_active', true)
            ->where('slug', 'not like', 'cambridge-%')
            ->where('slug', 'not like', 'toefl-itp-mock-package-%')
            ->with(['classPeriods' => function($q) {
                $q->whereIn('status', ['active', 'upcoming'])
                  ->where(function($query) {
                      $query->whereNull('end_date')
                            ->orWhere('end_date', '>=', now()->toDateString());
                  })
                  ->orderBy('start_date', 'asc');
            }])
            ->get();

        return view('brochure', compact('programs', 'type'));
    }

    /**
     * View or download the PDF brochure for a program.
     */
    public function pdf(Request $request, string $slug)
    {
        $program = Program::with(['classPeriods' => function($q) {
                $q->whereIn('status', ['active', 'upcoming'])
                  ->where(function($query) {
                      $query->whereNull('end_date')
                            ->orWhere('end_date', '>=', now()->toDateString());
                  })
                  ->orderBy('start_date', 'asc');
            }])
            ->where('slug', $slug)
            ->orWhere('id', $slug)
            ->firstOrFail();

        $mode = $request->query('mode', 'offline');
        if (!in_array($mode, ['online', 'offline'])) {
            $mode = 'offline';
        }

        $isDownload = $request->boolean('download') || $request->query('download') == '1';
        $filename = 'Brosur-TargetBahasa-' . $program->slug . '.pdf';

        // Check if admin uploaded a custom brochure PDF
        if ($program->brochure_pdf && Storage::disk('public')->exists($program->brochure_pdf)) {
            if ($isDownload) {
                return Storage::disk('public')->download($program->brochure_pdf, $filename);
            }
            return response()->file(Storage::disk('public')->path($program->brochure_pdf), [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
            ]);
        }

        // Generate dynamic PDF brochure using DomPDF
        $pdf = Pdf::loadView('pdf.program-brochure', [
            'program' => $program,
            'mode' => $mode,
        ])->setPaper('a4', 'portrait');

        if ($isDownload) {
            return $pdf->download($filename);
        }

        return $pdf->stream($filename);
    }
}
