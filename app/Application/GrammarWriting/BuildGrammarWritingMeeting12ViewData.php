<?php

namespace App\Application\GrammarWriting;

use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;


use App\Application\GrammarWriting\Concerns\LoadsFallbackGrammarWritingQuestions;
use App\Application\GrammarWriting\Concerns\LoadsGrammarWritingParagraph;
use Illuminate\Support\Collection;

class BuildGrammarWritingMeeting12ViewData
{
    public function __construct(
        protected readonly GrammarWritingRepository $repository
    ) {}

    use LoadsFallbackGrammarWritingQuestions;
    use LoadsGrammarWritingParagraph;

    public function handle(array $fallbackQuestions, array $fallbackParagraph, int $meetingNumber = 12): array
    {
        $questions = $this->loadQuestions($fallbackQuestions);
        $paragraph = $this->loadParagraph($fallbackParagraph);

        $targetUserId = request()->query('live_preview_for') ? (int) request()->query('live_preview_for') : auth()->id();

        // 1. Session values (if student is logged in directly)
        $submitted = session('meeting12_submitted', session('meeting' . $meetingNumber . '_submitted', false));
        $results = session('meeting12_results', session('meeting' . $meetingNumber . '_results', []));
        $paragraphResult = session('meeting12_paragraph_result', session('meeting' . $meetingNumber . '_paragraph_result', []));
        $finalScore = session('meeting12_final_score', session('meeting' . $meetingNumber . '_final_score', 0));
        $userAnswers = session('meeting12_user_answers', session('meeting' . $meetingNumber . '_user_answers', []));
        $userParagraphAnswer = session('meeting12_user_paragraph_answer', session('meeting' . $meetingNumber . '_user_paragraph_answer', ''));

        // 2. Cache check (for live drafts)
        if ($targetUserId) {
            $cachedUserAnswers = \Illuminate\Support\Facades\Cache::get('user_' . $targetUserId . '_meeting' . $meetingNumber . '_user_answers')
                ?? \Illuminate\Support\Facades\Cache::get('user_' . $targetUserId . '_meeting12_user_answers')
                ?? \Illuminate\Support\Facades\Cache::get('user_' . $targetUserId . '_fast-track_meeting' . $meetingNumber . '_draft_answers');

            $cachedParagraphAnswer = \Illuminate\Support\Facades\Cache::get('user_' . $targetUserId . '_meeting' . $meetingNumber . '_user_paragraph_answer')
                ?? \Illuminate\Support\Facades\Cache::get('user_' . $targetUserId . '_meeting12_user_paragraph_answer')
                ?? \Illuminate\Support\Facades\Cache::get('user_' . $targetUserId . '_fast-track_meeting' . $meetingNumber . '_draft_paragraph_answer');

            if ($cachedUserAnswers !== null && is_array($cachedUserAnswers)) {
                $userAnswers = $cachedUserAnswers;
            }
            if ($cachedParagraphAnswer !== null && is_string($cachedParagraphAnswer)) {
                $userParagraphAnswer = $cachedParagraphAnswer;
            }

            // 3. Database Draft fallback
            if (empty($userAnswers) || $userParagraphAnswer === '') {
                try {
                    $draft = \App\Models\AssignmentDraft::where('user_id', $targetUserId)
                        ->whereIn('meeting_number', [$meetingNumber, 12])
                        ->latest('updated_at')
                        ->first();

                    if ($draft && !empty($draft->answers)) {
                        $draftAnswers = is_array($draft->answers) ? $draft->answers : (json_decode((string) $draft->answers, true) ?? []);
                        if (isset($draftAnswers['paragraph_answer']) && $userParagraphAnswer === '') {
                            $userParagraphAnswer = (string) $draftAnswers['paragraph_answer'];
                            unset($draftAnswers['paragraph_answer']);
                        } elseif (isset($draftAnswers['meeting12_user_paragraph_answer']) && $userParagraphAnswer === '') {
                            $userParagraphAnswer = (string) $draftAnswers['meeting12_user_paragraph_answer'];
                        } elseif (isset($draftAnswers['meeting' . $meetingNumber . '_user_paragraph_answer']) && $userParagraphAnswer === '') {
                            $userParagraphAnswer = (string) $draftAnswers['meeting' . $meetingNumber . '_user_paragraph_answer'];
                        } elseif (isset($draftAnswers['userParagraphAnswer']) && $userParagraphAnswer === '') {
                            $userParagraphAnswer = (string) $draftAnswers['userParagraphAnswer'];
                        }

                        if (empty($userAnswers)) {
                            $userAnswers = $draftAnswers['meeting12_user_answers']
                                ?? ($draftAnswers['meeting' . $meetingNumber . '_user_answers']
                                ?? ($draftAnswers['userAnswers']
                                ?? ($draftAnswers['user_answers']
                                ?? $draftAnswers)));
                        }
                    }
                } catch (\Throwable $e) {}
            }

            // 4. MeetingScore fallback (if submitted)
            if ((!$submitted || empty($userAnswers)) && $targetUserId) {
                try {
                    $scoreRecord = \App\Models\MeetingScore::where('user_id', $targetUserId)
                        ->whereIn('meeting_number', [$meetingNumber, 12])
                        ->latest('submitted_at')
                        ->first();

                    if ($scoreRecord && !empty($scoreRecord->answers)) {
                        $scoreAnswers = is_array($scoreRecord->answers) ? $scoreRecord->answers : (json_decode((string) $scoreRecord->answers, true) ?? []);
                        if (!empty($scoreAnswers)) {
                            $submitted = true;
                            $finalScore = (int) ($scoreRecord->score ?? $scoreAnswers['meeting12_final_score'] ?? $scoreAnswers['meeting' . $meetingNumber . '_final_score'] ?? 0);
                            $results = $scoreAnswers['meeting12_results'] ?? ($scoreAnswers['meeting' . $meetingNumber . '_results'] ?? $results);
                            $paragraphResult = $scoreAnswers['meeting12_paragraph_result'] ?? ($scoreAnswers['meeting' . $meetingNumber . '_paragraph_result'] ?? $paragraphResult);
                            if (empty($userAnswers)) {
                                $userAnswers = $scoreAnswers['meeting12_user_answers']
                                    ?? ($scoreAnswers['meeting' . $meetingNumber . '_user_answers']
                                    ?? ($scoreAnswers['user_answers']
                                    ?? ($scoreAnswers['userAnswers']
                                    ?? ($scoreAnswers['answers'] ?? []))));
                            }
                            if ($userParagraphAnswer === '') {
                                $userParagraphAnswer = (string) ($scoreAnswers['meeting12_user_paragraph_answer']
                                    ?? ($scoreAnswers['meeting' . $meetingNumber . '_user_paragraph_answer']
                                    ?? ($scoreAnswers['paragraph_answer']
                                    ?? ($scoreAnswers['user_paragraph_answer']
                                    ?? ($scoreAnswers['userParagraphAnswer'] ?? '')))));
                            }
                        }
                    }
                } catch (\Throwable $e) {}
            }
        }

        return [
            'questions' => $questions,
            'fullParagraphId' => $paragraph['id'],
            'fullParagraphEn' => $paragraph['en'],
            'paragraphVocab' => $paragraph['vocab'],
            'paragraphDbId' => $paragraph['db_id'],
            'submitted' => $submitted,
            'results' => $results,
            'paragraphResult' => $paragraphResult,
            'finalScore' => $finalScore,
            'userAnswers' => $userAnswers,
            'userParagraphAnswer' => $userParagraphAnswer,
        ];
    }

    public function loadQuestions(array $fallbackQuestions): Collection
    {
        return $this->loadFallbackQuestionsForMeeting(
            12,
            $fallbackQuestions,
            function ($question) {
                return [
                    'id' => $question->question_text,
                    'en' => $question->correct_answer,
                    'type' => $question->structure,
                    'conjunction' => $question->formula,
                    'example' => is_array($question->example) ? $question->example : ['id' => '', 'en' => ''],
                    'vocab' => is_array($question->vocab) ? $question->vocab : [],
                    'db_id' => $question->id,
                ];
            },
            function ($question) {
                return [
                    'id' => $question['id'],
                    'en' => $question['en'],
                    'type' => $question['type'] ?? '',
                    'conjunction' => $question['conjunction'] ?? '',
                    'example' => $question['example'] ?? ['id' => '', 'en' => ''],
                    'vocab' => $question['vocab'] ?? [],
                    'db_id' => null,
                ];
            }
        );
    }

    public function loadParagraph(array $fallbackParagraph): array
    {
        return $this->loadMeetingParagraph(12, $fallbackParagraph, fn ($vocab) => $vocab ?? []);
    }
}