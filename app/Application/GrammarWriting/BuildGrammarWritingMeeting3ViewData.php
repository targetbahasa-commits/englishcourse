<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;
use App\Application\GrammarWriting\Concerns\LoadsLegacyGrammarWritingQuestions;
use App\Application\GrammarWriting\Concerns\ResolvesLegacyGrammarWritingParagraph;
use Illuminate\Support\Collection;

class BuildGrammarWritingMeeting3ViewData
{
    public function __construct(
        protected readonly GrammarWritingRepository $repository
    ) {}

    use LoadsLegacyGrammarWritingQuestions;
    use ResolvesLegacyGrammarWritingParagraph;

    public function handle(array $fallbackQuestions, array $fallbackParagraph, bool $hasSectionColumn): array
    {
        $questions = $this->formatQuestionsForView(
            $this->loadQuestionModels($fallbackQuestions, $hasSectionColumn)
        );

        $paragraph = $this->resolveParagraphRecord($hasSectionColumn);
        $paragraphData = $paragraph
            ? [
                'id' => $paragraph->question_text,
                'en' => $paragraph->correct_answer,
                'vocab' => is_array($paragraph->vocab) ? $paragraph->vocab : (is_string($paragraph->vocab) ? json_decode($paragraph->vocab, true) : []),
            ]
            : [
                'id' => $fallbackParagraph['id'],
                'en' => $fallbackParagraph['en'],
                'vocab' => $fallbackParagraph['vocab'] ?? [],
            ];

        // Admin Live Preview loads this exact page (with ?live_preview_for=)
        // under the ADMIN's own authenticated session, not the student being
        // previewed. Using auth()->id()/session()/Cache below would prefill
        // the page with the ADMIN's own cache/session/database draft instead
        // of the real student's - the correct per-student data is safely
        // injected client-side afterward by injectSnapshotIntoIframe() in
        // current-assignment.blade.php.
        $isLivePreview = request()->filled('live_preview_for');
        $userId = $isLivePreview ? null : auth()->id();
        $cachedUserAnswers = $userId ? \Illuminate\Support\Facades\Cache::get('user_' . $userId . '_meeting3_user_answers') : null;
        $cachedParagraphAnswer = $userId ? \Illuminate\Support\Facades\Cache::get('user_' . $userId . '_meeting3_user_paragraph_answer') : null;
        $userAnswers = $cachedUserAnswers !== null ? $cachedUserAnswers : ($isLivePreview ? [] : session('meeting3_user_answers', []));
        $paragraphAnswer = $cachedParagraphAnswer !== null ? $cachedParagraphAnswer : ($isLivePreview ? '' : session('meeting3_user_paragraph_answer', ''));

        if ((empty($userAnswers) || $paragraphAnswer === '') && $userId) {
            try {
                $programId = \App\Models\Program::where('slug', 'fast-track-grammar-for-writing')->value('id');
                if ($programId) {
                    $draft = \App\Models\AssignmentDraft::where('user_id', $userId)
                        ->where('program_id', $programId)
                        ->where('meeting_number', 3)
                        ->first();
                    if ($draft && is_array($draft->answers)) {
                        $draftAnswers = $draft->answers;
                        if (isset($draftAnswers['paragraph_answer'])) {
                            if ($paragraphAnswer === '') {
                                $paragraphAnswer = (string) $draftAnswers['paragraph_answer'];
                            }
                            unset($draftAnswers['paragraph_answer']);
                        }
                        if (empty($userAnswers)) {
                            $userAnswers = $draftAnswers;
                        }
                    }
                }
            } catch (\Throwable $e) {
                // Ignore if AssignmentDraft table is unavailable
            }
        }

        $submitted = $isLivePreview ? false : session('meeting3_submitted', false);
        $results = $isLivePreview ? [] : session('meeting3_results', []);
        $paragraphResult = $isLivePreview ? [] : session('meeting3_paragraph_result', []);
        $finalScore = $isLivePreview ? 0 : session('meeting3_final_score', 0);

        if (!$submitted && $userId) {
            try {
                $programId = \App\Models\Program::where('slug', 'fast-track-grammar-for-writing')->value('id') ?? auth()->user()?->program_id;
                if ($programId) {
                    $scoreRecord = \App\Models\MeetingScore::where('user_id', $userId)
                        ->where('program_id', $programId)
                        ->where('meeting_number', 3)
                        ->latest('submitted_at')
                        ->first();

                    if ($scoreRecord) {
                        $submitted = true;
                        $finalScore = $scoreRecord->score;
                        $scoreData = is_array($scoreRecord->answers) ? $scoreRecord->answers : json_decode($scoreRecord->answers ?? '[]', true);
                        if (!empty($scoreData)) {
                            $results = $scoreData['meeting3_results'] ?? ($scoreData['results'] ?? []);
                            $paragraphResult = $scoreData['meeting3_paragraph_result'] ?? ($scoreData['paragraph_result'] ?? []);
                            if (empty($userAnswers) && isset($scoreData['meeting3_user_answers'])) {
                                $userAnswers = $scoreData['meeting3_user_answers'];
                            }
                            if ($paragraphAnswer === '' && isset($scoreData['meeting3_user_paragraph_answer'])) {
                                $paragraphAnswer = $scoreData['meeting3_user_paragraph_answer'];
                            }
                        }
                    }
                }
            } catch (\Throwable $e) {}
        }

        $formattedUserAnswers = [];
        if (is_array($userAnswers)) {
            foreach ($userAnswers as $k => $v) {
                if (is_array($v)) {
                    $formattedUserAnswers[$k] = $v;
                } elseif (is_string($v) || is_numeric($v)) {
                    $formattedUserAnswers[$k] = ['trans' => (string) $v];
                }
            }
        }

        return [
            'questions' => $questions,
            'fullParagraphId' => $paragraphData['id'],
            'fullParagraphEn' => $paragraphData['en'],
            'paragraphVocab' => $paragraphData['vocab'] ?? [],
            'submitted' => $submitted,
            'results' => $results,
            'paragraphResult' => $paragraphResult,
            'finalScore' => $finalScore,
            'userAnswers' => $formattedUserAnswers,
            'userParagraphAnswer' => $paragraphAnswer,
            'paragraphId' => $paragraph->id ?? 0,
        ];
    }

    public function loadQuestionModels(array $fallbackQuestions, bool $hasSectionColumn): Collection
    {
        return $this->loadLegacyQuestionModels(
            3,
            $hasSectionColumn,
            $fallbackQuestions,
            null,
            function ($question, $number) {
                return (object) [
                    'question_number' => (int) $number,
                    'question_text' => $question['id'] ?? '',
                    'correct_answer' => $question['en'] ?? '',
                    'tense' => $question['tense'] ?? '',
                    'vocab' => $question['vocab'] ?? [],
                    'id' => 0,
                ];
            }
        );
    }

    public function resolveParagraphRecord(bool $hasSectionColumn): mixed
    {
        return $this->resolveLegacyParagraphRecord(3, $hasSectionColumn);
    }

    public function formatQuestionsForView(Collection $questions): array
    {
        return $questions
            ->reject(fn ($question) => (int) (is_array($question) ? ($question['q_num'] ?? $question['question_number'] ?? 0) : ($question->question_number ?? 0)) === 999)
            ->mapWithKeys(function ($question) {
            if (is_array($question)) {
                $qNum = (int) ($question['q_num'] ?? $question['question_number'] ?? 1);
                return [$qNum => [
                    'id' => $question['id'] ?? '',
                    'en' => $question['en'] ?? '',
                    'tense' => $question['tense'] ?? '',
                    'vocab' => is_array($question['vocab'] ?? null) ? $question['vocab'] : [],
                    'original_id' => $question['original_id'] ?? 0,
                    'q_num' => $qNum,
                ]];
            }

            $qNum = (int) ($question->question_number ?? 1);
            return [$qNum => [
                'id' => $question->question_text ?? '',
                'en' => $question->correct_answer ?? '',
                'tense' => $question->tense ?? '',
                'vocab' => is_array($question->vocab) ? $question->vocab : (is_string($question->vocab) ? json_decode($question->vocab, true) : []),
                'original_id' => $question->id ?? 0,
                'q_num' => $qNum,
            ]];
        })->toArray();
    }
}