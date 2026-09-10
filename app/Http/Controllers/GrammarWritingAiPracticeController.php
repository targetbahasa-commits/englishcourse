<?php

namespace App\Http\Controllers;

use App\Application\GrammarWriting\GenerateGrammarVariationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GrammarWritingAiPracticeController extends Controller
{
    public function generateVariation(Request $request, GenerateGrammarVariationService $generator)
    {
        $track = $request->input('track', 'fast-track');
        $meetingNumber = (int) $request->input('meeting_number', 1);

        $variation = $generator->generateGenericVariation($track, $meetingNumber);

        $sessionVarKey = "grammar_ai_var_{$track}_{$meetingNumber}";
        $sessionUseKey = "grammar_use_ai_{$track}_{$meetingNumber}";
        $sessionAttemptKey = "grammar_ai_attempt_{$track}_{$meetingNumber}";

        $nextAttempt = (int) session($sessionAttemptKey, 0) + 1;

        session([
            $sessionVarKey => $variation,
            $sessionUseKey => true,
            $sessionAttemptKey => $nextAttempt,
            // Legacy / meeting-specific keys
            "meeting{$meetingNumber}_ai_variation" => $variation,
            "meeting{$meetingNumber}_use_ai_variation" => true,
            "meeting{$meetingNumber}_ai_attempt" => $nextAttempt,
            "meeting{$meetingNumber}_stage" => 1,
            "meeting{$meetingNumber}_trans_results" => [],
            "meeting{$meetingNumber}_score_part1" => 0,
            "meeting{$meetingNumber}_score_part2" => 0,
            "meeting{$meetingNumber}_total_score" => 0,
            "meeting{$meetingNumber}_user_answers" => [],
        ]);

        // Clean draft in DB for clean sheet
        $userId = Auth::id();
        if ($userId) {
            try {
                \App\Models\AssignmentDraft::where('user_id', $userId)
                    ->where('meeting_number', $meetingNumber)
                    ->delete();
            } catch (\Throwable $e) {}
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'attempt' => $nextAttempt,
                'is_ai_generated' => $variation['is_ai_generated'] ?? true,
                'message' => 'Soal variasi baru berhasil dibuat!',
            ]);
        }

        return back()->with('success', 'Soal variasi baru dari AI berhasil dibuat!');
    }

    public function switchMode(Request $request)
    {
        $track = $request->input('track', 'fast-track');
        $meetingNumber = (int) $request->input('meeting_number', 1);
        $mode = $request->input('mode', 'default');

        $sessionUseKey = "grammar_use_ai_{$track}_{$meetingNumber}";
        $isAi = ($mode === 'ai');

        session([
            $sessionUseKey => $isAi,
            "meeting{$meetingNumber}_use_ai_variation" => $isAi,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['success' => true, 'mode' => $mode]);
        }

        return back();
    }
}