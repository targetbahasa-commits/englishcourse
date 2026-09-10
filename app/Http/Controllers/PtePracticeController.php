<?php

namespace App\Http\Controllers;

use App\Models\PtePracticeResult;
use App\Models\PteBookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Services\PteScoringService;

class PtePracticeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Save a practice attempt result.
     * POST /pte/practice/submit
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'module'           => 'required|string|max:80',
            'topic_id'         => 'required|integer|min:1',
            'score'            => 'required|integer|min:0',
            'max_score'        => 'required|integer|min:1',
            'duration_seconds' => 'sometimes|integer|min:0',
            'detail'           => 'sometimes|array',
        ]);

        $result = PtePracticeResult::create([
            'user_id'          => Auth::id(),
            'module'           => $validated['module'],
            'topic_id'         => $validated['topic_id'],
            'score'            => $validated['score'],
            'max_score'        => $validated['max_score'],
            'duration_seconds' => $validated['duration_seconds'] ?? 0,
            'detail'           => $validated['detail'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'result_id' => $result->id,
        ]);
    }

    /**
     * Toggle bookmark for a topic.
     * POST /pte/practice/bookmark
     */
    public function bookmark(Request $request)
    {
        $validated = $request->validate([
            'module'   => 'required|string|max:80',
            'topic_id' => 'required|integer|min:1',
        ]);

        $userId = Auth::id();

        $existing = PteBookmark::where([
            'user_id'  => $userId,
            'module'   => $validated['module'],
            'topic_id' => $validated['topic_id'],
        ])->first();

        if ($existing) {
            $existing->delete();
            $bookmarked = false;
        } else {
            PteBookmark::create([
                'user_id'  => $userId,
                'module'   => $validated['module'],
                'topic_id' => $validated['topic_id'],
            ]);
            $bookmarked = true;
        }

        return response()->json(['success' => true, 'bookmarked' => $bookmarked]);
    }

    /**
     * Get stats for a single topic.
     * GET /pte/practice/stats/{module}/{topic_id}
     */
    public function topicStats(string $module, int $topicId)
    {
        $userId = Auth::id();

        $results = PtePracticeResult::where([
            'user_id'  => $userId,
            'module'   => $module,
            'topic_id' => $topicId,
        ])->latest()->get();

        $bookmarked = PteBookmark::where([
            'user_id'  => $userId,
            'module'   => $module,
            'topic_id' => $topicId,
        ])->exists();

        $attemptCount = $results->count();
        $avgScore = $attemptCount > 0
            ? round($results->sum('score') / $results->sum('max_score') * 90 + 10)
            : null;

        $lastResult = $results->first();

        return response()->json([
            'attempt_count' => $attemptCount,
            'avg_score'     => $avgScore,
            'bookmarked'    => $bookmarked,
            'last_result'   => $lastResult,
        ]);
    }

    /**
     * Get stats for all topics in a module (for index pages).
     * GET /pte/practice/stats/{module}
     */
    public function moduleStats(string $module)
    {
        $userId = Auth::id();

        // Get all results for this module grouped by topic_id
        $results = PtePracticeResult::where([
            'user_id' => $userId,
            'module'  => $module,
        ])->get()->groupBy('topic_id');

        $bookmarks = PteBookmark::where([
            'user_id' => $userId,
            'module'  => $module,
        ])->pluck('topic_id')->toArray();

        $stats = [];
        foreach ($results as $topicId => $topicResults) {
            $attemptCount = $topicResults->count();
            $totalScore   = $topicResults->sum('score');
            $totalMax     = $topicResults->sum('max_score');
            $avgRatio     = $totalMax > 0 ? $totalScore / $totalMax : 0;
            $avgScaled    = round(10 + $avgRatio * 80);

            $stats[$topicId] = [
                'attempt_count' => $attemptCount,
                'avg_score'     => $avgScaled,
                'bookmarked'    => in_array($topicId, $bookmarks),
            ];
        }

        return response()->json([
            'stats'     => $stats,
            'bookmarks' => $bookmarks,
        ]);
    }

    /**
     * Evaluate speaking audio using Groq Whisper + Llama 3.
     * POST /pte/practice/evaluate-speaking
     */
    public function evaluateSpeaking(Request $request)
    {
        $validated = $request->validate([
            'audio'            => 'required|file|mimes:webm,mp3,wav,m4a,ogg|max:20480',
            'module'           => 'required|string|max:80',
            'topic_id'         => 'required|integer|min:1',
            'original_text'    => 'nullable|string',
        ]);

        try {
            $module = $validated['module'];
            $result = app(PteScoringService::class)->scoreSpeaking(
                $request->file('audio'),
                $validated['original_text'] ?? '',
                $module
            );

            if (!$result['success']) {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'],
                ], 400);
            }

            $transcription = $result['transcription'];
            $scores = $result['scores'];

            // Save result
            $dbResult = PtePracticeResult::create([
                'user_id'          => Auth::id(),
                'module'           => $module,
                'topic_id'         => $validated['topic_id'],
                'score'            => $scores['overall_score'] ?? 0,
                'max_score'        => 90,
                'duration_seconds' => round($scores['acoustic_metrics']['duration_seconds'] ?? 0),
                'detail'           => [
                    'transcription'       => $transcription,
                    'content_score'       => $scores['content_score'] ?? 0,
                    'fluency_score'       => $scores['fluency_score'] ?? 0,
                    'pronunciation_score' => $scores['pronunciation_score'] ?? 0,
                    'feedback'            => $scores['feedback'] ?? '',
                    'acoustic_metrics'    => $scores['acoustic_metrics'] ?? [],
                ],
            ]);

            return response()->json([
                'success'       => true,
                'result_id'     => $dbResult->id,
                'scores'        => $scores,
                'transcription' => $transcription
            ]);

        } catch (\Throwable $e) {
            Log::error("evaluateSpeaking Error: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Evaluation failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Evaluate writing using Groq Llama 3.
     * POST /pte/practice/evaluate-writing
     */
    public function evaluateWriting(Request $request)
    {
        $validated = $request->validate([
            'answer'           => 'required|string',
            'module'           => 'required|string|max:80',
            'topic_id'         => 'required|integer|min:1',
            'prompt_text'      => 'nullable|string',
        ]);

        try {
            $module = $validated['module'];
            $answer = $validated['answer'];
            $promptText = $validated['prompt_text'] ?? '';

            $scores = app(PteScoringService::class)->scoreWriting($module, $promptText, $answer);

            // Save result
            $dbResult = PtePracticeResult::create([
                'user_id'          => Auth::id(),
                'module'           => $module,
                'topic_id'         => $validated['topic_id'],
                'score'            => $scores['overall_score'] ?? 0,
                'max_score'        => 90,
                'duration_seconds' => 0,
                'detail'           => [
                    'content_score'    => $scores['content_score'] ?? 0,
                    'form_score'       => $scores['form_score'] ?? 0,
                    'grammar_score'    => $scores['grammar_score'] ?? 0,
                    'vocabulary_score' => $scores['vocabulary_score'] ?? 0,
                    'spelling_score'   => $scores['spelling_score'] ?? 0,
                    'feedback'         => $scores['feedback'] ?? '',
                ],
            ]);

            return response()->json([
                'success' => true,
                'result_id' => $dbResult->id,
                'scores' => $scores
            ]);

        } catch (\Throwable $e) {
            Log::error("evaluateWriting Error: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Evaluation failed: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Save score for deterministic (non-AI) practice tasks.
     * POST /pte/practice/save-score
     */
    public function saveScore(Request $request)
    {
        $validated = $request->validate([
            'module'     => 'required|string|max:80',
            'topic_id'   => 'required|integer|min:1',
            'score'      => 'required|numeric|min:0',
            'max_score'  => 'required|numeric|min:1',
        ]);

        try {
            $score = $validated['score'];
            $maxScore = $validated['max_score'];
            
            // Calculate a scaled PTE score (out of 90) for UI display
            $ratio = max(0, min(1, $score / $maxScore));
            $scaledScore = round(10 + $ratio * 80);

            // Save result to the database
            $dbResult = PtePracticeResult::create([
                'user_id'          => Auth::id(),
                'module'           => $validated['module'],
                'topic_id'         => $validated['topic_id'],
                'score'            => $scaledScore,
                'max_score'        => 90,
                'duration_seconds' => 0,
                'detail'           => [
                    'raw_score' => $score,
                    'raw_max'   => $maxScore,
                ],
            ]);

            return response()->json([
                'success' => true,
                'result_id' => $dbResult->id,
                'scaled_score' => $scaledScore
            ]);

        } catch (\Exception $e) {
            Log::error("saveScore Error: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Failed to save score: ' . $e->getMessage()], 500);
        }
    }
}
