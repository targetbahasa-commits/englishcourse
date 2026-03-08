<?php

namespace App\Http\Controllers;

use App\Models\FreeTestResult;
use App\Models\OutreachMessage;
use App\Models\Program;
use App\Jobs\SendOutreachFollowUpJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FreeTestController extends Controller
{
    public function show($type)
    {
        $validTypes = ['ielts_academic', 'ielts_general', 'toefl_itp', 'pte_academic'];
        if (!in_array($type, $validTypes)) {
            abort(404);
        }

        return view('free-tests.show', compact('type'));
    }

    public function submit(Request $request, $type)
    {
        $validTypes = ['ielts_academic', 'ielts_general', 'toefl_itp', 'pte_academic'];
        if (!in_array($type, $validTypes)) {
            abort(404);
        }

        // Mock simulation score generator
        $score = mt_rand(350, 677); // Default mock for TOEFL ITP
        
        if (str_starts_with($type, 'ielts_') || $type === 'pte_academic') {
            $score = mt_rand(40, 90) / 10; // Mock for IELTS (4.0 - 9.0)
        }

        // Mock Evaluation Feedback
        $evaluationData = [
            'strengths' => ['Reading Comprehension', 'Basic Grammar Structures'],
            'weaknesses' => ['Advanced Vocabulary', 'Listening Speed & Accuracy'],
        ];

        $result = FreeTestResult::create([
            'user_id' => Auth::id(),
            'test_type' => $type,
            'score' => $score,
            'evaluation_data' => $evaluationData
        ]);

        // Sprint 4: Dispatch the automated follow-up email job (delayed by 1 minute for realism)
        SendOutreachFollowUpJob::dispatch($result)->delay(now()->addMinute());

        return redirect()->route('free-test.result', $result->id);
    }

    public function result($id)
    {
        $result = FreeTestResult::where('user_id', Auth::id())->findOrFail($id);
        
        // Find matching outreach message
        $outreachMessage = OutreachMessage::where('test_type', $result->test_type)
            ->where('target_role', Auth::user()->role)
            ->where('min_score', '<=', $result->score)
            ->where('max_score', '>=', $result->score)
            ->first();

        // Find a recommended program based on score level
        $recommendedProgram = null;
        if ($outreachMessage && $outreachMessage->program_id ?? false) {
            $recommendedProgram = Program::find($outreachMessage->program_id);
        }
        // Fallback: recommend first active program if none found
        if (!$recommendedProgram) {
            $recommendedProgram = Program::where('is_active', true)->first();
        }

        return view('free-tests.result', compact('result', 'outreachMessage', 'recommendedProgram'));
    }
}
