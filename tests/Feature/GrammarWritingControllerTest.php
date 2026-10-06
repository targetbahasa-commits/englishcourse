<?php

namespace Tests\Feature;

use App\Application\GrammarWriting\BuildGrammarWritingMeeting1ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting4ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting5ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting10ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting11ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting16ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting17ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting18ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting19ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting9ViewData;
use App\Application\GrammarWriting\BuildGrammarWritingMeeting3ViewData;
use App\Domain\GrammarWriting\Repositories\GrammarWritingRepository;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting1Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting4Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting5Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting10Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting11Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting16Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting17Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting18Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting19Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting2Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting3Submission;
use App\Application\GrammarWriting\EvaluateGrammarWritingMeeting9Submission;
use App\Models\GrammarQuestion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class GrammarWritingControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutMiddleware();

        DB::table('programs')->insert([
            'name' => 'Grammar for Writing',
            'slug' => 'grammar-for-writing',
            'period' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }

    private function makeGrammarWritingRepository(): GrammarWritingRepository
    {
        return $this->createMock(GrammarWritingRepository::class);
    }

    public function test_meeting1_get_renders_builder_payload(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $builder = new class($this->makeGrammarWritingRepository()) extends BuildGrammarWritingMeeting1ViewData {
            public function __construct(GrammarWritingRepository $repository)
            {
                parent::__construct($repository);
            }

            public function handle(bool $hasSectionColumn, array $fallbackParagraph, array $fallbackQuestions, array $fallbackVocab): array
            {
                return [
                    'questions' => [1 => ['id' => 'Question 1', 'en' => 'Answer 1', 'db_id' => 0, 'vocab' => []]],
                    'paragraphData' => ['id' => 'Paragraph id', 'en' => 'Paragraph en'],
                    'vocabList' => ['word' => ['id' => 'kata', 'pos' => '(n)', 'db_id' => 0]],
                    'submitted' => false,
                ];
            }
        };

        $this->app->instance(BuildGrammarWritingMeeting1ViewData::class, $builder);

        $response = $this->get(route('assignments.grammar-writing.meeting1'));

        $response->assertOk();
        $response->assertViewIs('assignments.grammar-writing.meeting1');
        $response->assertViewHas('submitted', false);
        $response->assertViewHas('paragraphData', ['id' => 'Paragraph id', 'en' => 'Paragraph en']);
    }

    public function test_introductory_track_renders_ten_meetings(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('assignments.grammar-writing.track', 'introductory'));

        $response->assertOk();
        $response->assertViewIs('assignments.grammar-writing-track');
        $response->assertViewHas('trackData', function (array $trackData): bool {
            return $trackData['title'] === 'Introductory Grammar for Writing'
                && count($trackData['meetings']) === 10
                && $trackData['meetings'][0]['title'] === 'Meeting 1'
                && $trackData['meetings'][9]['title'] === 'Meeting 10'
                && $trackData['meetings'][0]['available'] === true;
        });
    }

    public function test_proficiency_track_renders_ten_meetings(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('assignments.grammar-writing.track', 'proficiency'));

        $response->assertOk();
        $response->assertViewIs('assignments.grammar-writing-track');
        $response->assertViewHas('trackData', function (array $trackData): bool {
            return $trackData['title'] === 'Proficiency Grammar for Writing'
                && count($trackData['meetings']) === 10
                && $trackData['meetings'][0]['topic'] === 'Hedging and cautious claims'
                && $trackData['meetings'][9]['topic'] === 'Editing for precision and style'
                && $trackData['meetings'][0]['available'] === true;
        });
    }

    public function test_complexity_track_renders_ten_meetings(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('assignments.grammar-writing.track', 'complexity'));

        $response->assertOk();
        $response->assertViewIs('assignments.grammar-writing-track');
        $response->assertViewHas('trackData', function (array $trackData): bool {
            return $trackData['title'] === 'Complexity Grammar for Writing'
                && count($trackData['meetings']) === 10
                && $trackData['meetings'][0]['title'] === 'Meeting 1'
                && $trackData['meetings'][9]['title'] === 'Meeting 10'
                && $trackData['meetings'][0]['source_meeting_number'] === 11
                && $trackData['meetings'][0]['available'] === true;
        });
    }

    public function test_proficiency_meeting_page_renders_focus_points(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('assignments.grammar-writing.proficiency.meeting', 1));

        $response->assertOk();
        $response->assertViewIs('assignments.grammar-writing-proficiency-meeting');
        $response->assertViewHas('meetingData', function (array $meetingData): bool {
            return $meetingData['title'] === 'Meeting 1'
                && $meetingData['topic'] === 'Hedging and cautious claims'
                && count($meetingData['focus_points']) === 3;
        });
    }

    public function test_meeting1_submit_renders_view_using_builder_composed_payload(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $questions = new Collection([
            (object) ['question_number' => 1, 'question_text' => 'Pertanyaan', 'correct_answer' => 'Answer'],
        ]);
        $paragraph = ['id' => 'Paragraf', 'en' => 'Paragraph'];

        $builder = new class($this->makeGrammarWritingRepository(), $questions, $paragraph) extends BuildGrammarWritingMeeting1ViewData {
            public function __construct(GrammarWritingRepository $repository, private Collection $questions, private array $paragraph)
            {
                parent::__construct($repository);
            }

            public function loadQuestionModels(bool $hasSectionColumn, array $fallbackQuestions): Collection
            {
                return $this->questions;
            }

            public function resolveParagraphData(bool $hasSectionColumn, array $fallbackParagraph): array
            {
                return $this->paragraph;
            }

            public function composeViewData(Collection $questions, array $paragraphData, array $fallbackVocab, array $overrides = []): array
            {
                return [
                'questions' => [1 => ['id' => 'Pertanyaan', 'en' => 'Answer']],
                'paragraphData' => $paragraphData,
                'vocabList' => ['word' => ['id' => 'kata', 'pos' => '(n)']],
                'submitted' => true,
                'score' => 88,
                'results' => [
                    1 => [
                        'formatted_answer' => 'Answer',
                        'correct_answer' => 'Answer',
                        'score' => 38,
                    ],
                ],
                'paragraphResult' => [
                    'formatted_answer' => 'Paragraph',
                    'score' => 50,
                ],
                ];
            }
        };

        $evaluator = new class extends EvaluateGrammarWritingMeeting1Submission {
            public function handle($questions, $requestData, $paragraphReference): array
            {
                return [
                    'finalScore' => 88,
                    'results' => [
                        1 => [
                            'formatted_answer' => 'Answer',
                            'correct_answer' => 'Answer',
                            'score' => 38,
                        ],
                    ],
                    'paragraphResult' => [
                        'formatted_answer' => 'Paragraph',
                        'score' => 50,
                    ],
                ];
            }
        };

        $this->app->instance(BuildGrammarWritingMeeting1ViewData::class, $builder);
        $this->app->instance(EvaluateGrammarWritingMeeting1Submission::class, $evaluator);

        $response = $this->post(route('assignments.grammar-writing.meeting1.submit'), [
            'userAnswers' => ['1' => 'Answer'],
            'userParagraphAnswer' => 'Paragraph',
        ]);

        $response->assertOk();
        $response->assertViewIs('assignments.grammar-writing.meeting1');
        $response->assertViewHas('submitted', true);
        $response->assertViewHas('score', 88);

        $this->assertDatabaseHas('meeting_scores', [
            'user_id' => $user->id,
            'meeting_number' => 1,
            'score' => 88,
        ]);
    }

    public function test_meeting1_reset_redirects_to_clean_get_route(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->withSession([
            'meeting1_submitted' => true,
            'meeting1_results' => ['1' => 'ok'],
            'meeting1_paragraph_result' => ['status' => 'ok'],
            'meeting1_final_score' => 88,
            'meeting1_user_answers' => ['1' => 'Answer'],
            'meeting1_user_paragraph_answer' => 'Paragraph answer',
        ])->post(route('assignments.grammar-writing.meeting1.reset'));

        $response->assertRedirect(route('assignments.grammar-writing.meeting1'));
        $response->assertSessionMissing('meeting1_submitted');
        $response->assertSessionMissing('meeting1_results');
        $response->assertSessionMissing('meeting1_paragraph_result');
        $response->assertSessionMissing('meeting1_final_score');
        $response->assertSessionMissing('meeting1_user_answers');
        $response->assertSessionMissing('meeting1_user_paragraph_answer');
    }

    public function test_meeting2_submit_stores_session_and_score_only_when_evaluation_requests_it(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $evaluator = new class extends EvaluateGrammarWritingMeeting2Submission {
            public function handle(int $stage, array $input, array $tenses, array $translationSentences, array $translationMatrix, int $scorePart1, ?string $track = null): array
            {
                return [
                    'session' => [
                        'meeting2_stage' => 2,
                        'meeting2_results' => ['part1' => 'ok'],
                        'meeting2_total_score' => 91,
                    ],
                    'saveScore' => true,
                    'totalScore' => 91,
                ];
            }
        };

        $this->app->instance(EvaluateGrammarWritingMeeting2Submission::class, $evaluator);

        $response = $this->withSession([
            'meeting2_stage' => 1,
            'meeting2_score_part1' => 40,
        ])->post(route('assignments.grammar-writing.meeting1.submit'), [
            'dummy' => 'value',
        ]);

        $response->assertRedirect(route('assignments.grammar-writing.meeting1'));
        $response->assertSessionHas('meeting2_stage', 2);
        $response->assertSessionHas('meeting2_total_score', 91);

        $this->assertDatabaseHas('meeting_scores', [
            'user_id' => $user->id,
            'meeting_number' => 2,
            'score' => 91,
        ]);
    }

    public function test_meeting2_submit_skips_score_persistence_when_evaluation_is_not_final(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $evaluator = new class extends EvaluateGrammarWritingMeeting2Submission {
            public function handle(int $stage, array $input, array $tenses, array $translationSentences, array $translationMatrix, int $scorePart1, ?string $track = null): array
            {
                return [
                    'session' => [
                        'meeting2_stage' => 2,
                        'meeting2_results' => ['part1' => 'draft'],
                    ],
                    'saveScore' => false,
                    'totalScore' => null,
                ];
            }
        };

        $this->app->instance(EvaluateGrammarWritingMeeting2Submission::class, $evaluator);

        $response = $this->withSession([
            'meeting2_stage' => 1,
            'meeting2_score_part1' => 40,
        ])->post(route('assignments.grammar-writing.meeting1.submit'), [
            'dummy' => 'value',
        ]);

        $response->assertRedirect(route('assignments.grammar-writing.meeting1'));
        $response->assertSessionHas('meeting2_stage', 2);
        $response->assertSessionHas('meeting2_results', ['part1' => 'draft']);

        $this->assertDatabaseMissing('meeting_scores', [
            'user_id' => $user->id,
            'meeting_number' => 2,
        ]);
    }

    public function test_meeting3_submit_redirects_with_shared_session_payload_and_saves_score(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $questions = new Collection([
            (object) ['question_number' => 1, 'correct_answer' => 'Correct'],
        ]);
        $paragraphRecord = new GrammarQuestion(['correct_answer' => 'Paragraph']);

        $builder = new class($this->makeGrammarWritingRepository(), $questions, $paragraphRecord) extends BuildGrammarWritingMeeting3ViewData {
            public function __construct(GrammarWritingRepository $repository, private Collection $questions, private GrammarQuestion $paragraphRecord)
            {
                parent::__construct($repository);
            }

            public function loadQuestionModels(array $fallbackQuestions, bool $hasSectionColumn): Collection
            {
                return $this->questions;
            }

            public function resolveParagraphRecord(bool $hasSectionColumn): ?GrammarQuestion
            {
                return $this->paragraphRecord;
            }
        };

        $evaluator = new class extends EvaluateGrammarWritingMeeting3Submission {
            public function handle($questions, $userParagraphAnswer, $userAnswers, $correctParagraphAnswer): array
            {
                return [
                    'meeting3_submitted' => true,
                    'meeting3_results' => ['1' => 'ok'],
                    'meeting3_paragraph_result' => ['status' => 'ok'],
                    'meeting3_final_score' => 84,
                    'meeting3_user_answers' => ['1' => 'Correct'],
                    'meeting3_user_paragraph_answer' => 'Paragraph answer',
                ];
            }
        };

        $this->app->instance(BuildGrammarWritingMeeting3ViewData::class, $builder);
        $this->app->instance(EvaluateGrammarWritingMeeting3Submission::class, $evaluator);

        $response = $this->post(route('assignments.grammar-writing.meeting3.submit'), [
            'userAnswers' => ['1' => 'Correct'],
            'userParagraphAnswer' => 'Paragraph answer',
        ]);

        $response->assertRedirect(route('assignments.grammar-writing.meeting3'));
        $response->assertSessionHas('meeting3_submitted', true);
        $response->assertSessionHas('meeting3_final_score', 84);

        $this->assertDatabaseHas('meeting_scores', [
            'user_id' => $user->id,
            'meeting_number' => 3,
            'score' => 84,
        ]);
    }

    public function test_meeting3_reset_clears_shared_session_keys_and_redirects(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->withSession([
            'meeting3_submitted' => true,
            'meeting3_results' => ['1' => 'ok'],
            'meeting3_paragraph_result' => ['status' => 'ok'],
            'meeting3_final_score' => 84,
            'meeting3_user_answers' => ['1' => 'Correct'],
            'meeting3_user_paragraph_answer' => 'Paragraph answer',
        ])->post(route('assignments.grammar-writing.meeting3.reset'));

        $response->assertRedirect(route('assignments.grammar-writing.meeting3'));
        $response->assertSessionMissing('meeting3_submitted');
        $response->assertSessionMissing('meeting3_results');
        $response->assertSessionMissing('meeting3_paragraph_result');
        $response->assertSessionMissing('meeting3_final_score');
        $response->assertSessionMissing('meeting3_user_answers');
        $response->assertSessionMissing('meeting3_user_paragraph_answer');
    }

    public function test_meeting5_get_renders_builder_payload(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $builder = new class($this->makeGrammarWritingRepository()) extends BuildGrammarWritingMeeting5ViewData {
            public function __construct(GrammarWritingRepository $repository)
            {
                parent::__construct($repository);
            }

            public function handle(array $tenseExamples = []): array
            {
                return [
                    'gerundInfinitiveComplex' => collect([1 => ['id' => 'Question 1', 'en' => 'Answer 1']]),
                    'toInfinitive' => collect([]),
                    'gerund' => collect([]),
                    'paragraph' => ['id' => 'Paragraph text', 'en' => 'Paragraph en'],
                    'submitted' => false,
                    'results' => [],
                    'finalScore' => 0,
                    'userAnswers' => [],
                ];
            }
        };

        $this->app->instance(BuildGrammarWritingMeeting5ViewData::class, $builder);

        $response = $this->get(route('assignments.grammar-writing.meeting5'));

        $response->assertOk();
        $response->assertViewIs('assignments.grammar-writing.meeting5');
        $response->assertViewHas('submitted', false);
    }

    public function test_meeting5_submit_redirects_with_session_payload_and_saves_score(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $builder = new class($this->makeGrammarWritingRepository()) extends BuildGrammarWritingMeeting5ViewData {
            public function __construct(GrammarWritingRepository $repository)
            {
                parent::__construct($repository);
            }

            public function loadSections(): array
            {
                return [
                    collect([1 => ['id' => 'Question 1', 'en' => 'Answer 1']]),
                    collect([]),
                    collect([]),
                    ['id' => 'Paragraph text', 'en' => 'Paragraph en'],
                ];
            }
        };

        $evaluator = new class extends EvaluateGrammarWritingMeeting5Submission {
            public function handle(array $userAnswers, mixed $sentenceQuestions = [], mixed $matrixQuestions = [], mixed $prQuestions = [], mixed $unused = []): array
            {
                return [
                    'meeting5_submitted' => true,
                    'meeting5_results' => ['1' => ['score' => 12]],
                    'meeting5_final_score' => 87,
                    'meeting5_user_answers' => $userAnswers,
                ];
            }
        };

        $this->app->instance(BuildGrammarWritingMeeting5ViewData::class, $builder);
        $this->app->instance(EvaluateGrammarWritingMeeting5Submission::class, $evaluator);

        $response = $this->post(route('assignments.grammar-writing.meeting5.submit'), [
            'userAnswers' => ['Custom answer'],
        ]);

        $response->assertRedirect(route('assignments.grammar-writing.meeting5'));
        $response->assertSessionHas('meeting5_submitted', true);
        $response->assertSessionHas('meeting5_final_score', 87);
        $response->assertSessionHas('meeting5_user_answers', ['Custom answer']);

        $this->assertDatabaseHas('meeting_scores', [
            'user_id' => $user->id,
            'meeting_number' => 5,
            'score' => 87,
        ]);
    }

    public function test_meeting5_reset_clears_shared_session_keys_and_redirects(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->withSession([
            'meeting5_submitted' => true,
            'meeting5_results' => ['1' => ['score' => 12]],
            'meeting5_final_score' => 87,
            'meeting5_user_answers' => ['Custom answer'],
        ])->post(route('assignments.grammar-writing.meeting5.reset'));

        $response->assertRedirect(route('assignments.grammar-writing.meeting5'));
        $response->assertSessionMissing('meeting5_submitted');
        $response->assertSessionMissing('meeting5_results');
        $response->assertSessionMissing('meeting5_final_score');
        $response->assertSessionMissing('meeting5_user_answers');
    }

    public function test_meeting9_get_renders_builder_payload(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $builder = new class($this->makeGrammarWritingRepository()) extends BuildGrammarWritingMeeting9ViewData {
            public function __construct(GrammarWritingRepository $repository)
            {
                parent::__construct($repository);
            }

            public function handle(array $fallbackQuestions, array $fallbackParagraph): array
            {
                return [
                    'questions' => [],
                    'paragraph' => ['id' => 'Paragraph id', 'en' => 'Paragraph en', 'vocab' => []],
                    'fullParagraphId' => 'Paragraph id',
                    'fullParagraphEn' => 'Paragraph en',
                    'paragraphVocab' => [],
                    'submitted' => false,
                    'results' => [],
                    'paragraphResult' => [],
                    'finalScore' => 0,
                    'userAnswers' => [],
                    'userParagraphAnswer' => '',
                ];
            }
        };

        $this->app->instance(BuildGrammarWritingMeeting9ViewData::class, $builder);

        $response = $this->get(route('assignments.grammar-writing.meeting9'));

        $response->assertOk();
        $response->assertViewIs('assignments.grammar-writing.meeting9');
        $response->assertViewHas('submitted', false);
        $response->assertViewHas('fullParagraphEn', 'Paragraph en');
    }

    public function test_meeting9_submit_redirects_with_session_payload_and_saves_score(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $paragraph = ['id' => 'Paragraph id', 'en' => 'Paragraph en', 'vocab' => []];

        $builder = new class($this->makeGrammarWritingRepository(), $paragraph) extends BuildGrammarWritingMeeting9ViewData {
            public function __construct(GrammarWritingRepository $repository, private array $paragraph)
            {
                parent::__construct($repository);
            }

            public function loadParagraph(array $fallbackParagraph): array
            {
                return $this->paragraph;
            }
        };

        $evaluator = new class extends EvaluateGrammarWritingMeeting9Submission {
            public function handle(string $userParagraphAnswer, string $correctText): array
            {
                return [
                    'meeting9_submitted' => true,
                    'meeting9_results' => [],
                    'meeting9_paragraph_result' => ['score' => 84, 'formatted_answer' => $userParagraphAnswer, 'max_score' => 100],
                    'meeting9_final_score' => 84,
                    'meeting9_user_answers' => [],
                    'meeting9_user_paragraph_answer' => $userParagraphAnswer,
                ];
            }
        };

        $this->app->instance(BuildGrammarWritingMeeting9ViewData::class, $builder);
        $this->app->instance(EvaluateGrammarWritingMeeting9Submission::class, $evaluator);

        $response = $this->post(route('assignments.grammar-writing.meeting9.submit'), [
            'userParagraphAnswer' => 'Paragraph answer',
        ]);

        $response->assertRedirect(route('assignments.grammar-writing.meeting9'));
        $response->assertSessionHas('meeting9_submitted', true);
        $response->assertSessionHas('meeting9_final_score', 84);
        $response->assertSessionHas('meeting9_user_paragraph_answer', 'Paragraph answer');

        $this->assertDatabaseHas('meeting_scores', [
            'user_id' => $user->id,
            'meeting_number' => 9,
            'score' => 84,
        ]);
    }

    public function test_meeting9_reset_clears_shared_session_keys_and_redirects(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->withSession([
            'meeting9_submitted' => true,
            'meeting9_results' => [],
            'meeting9_paragraph_result' => ['score' => 84],
            'meeting9_final_score' => 84,
            'meeting9_user_answers' => [],
            'meeting9_user_paragraph_answer' => 'Paragraph answer',
        ])->post(route('assignments.grammar-writing.meeting9.reset'));

        $response->assertRedirect(route('assignments.grammar-writing.meeting9'));
        $response->assertSessionMissing('meeting9_submitted');
        $response->assertSessionMissing('meeting9_results');
        $response->assertSessionMissing('meeting9_paragraph_result');
        $response->assertSessionMissing('meeting9_final_score');
        $response->assertSessionMissing('meeting9_user_answers');
        $response->assertSessionMissing('meeting9_user_paragraph_answer');
    }

    public function test_meeting4_get_renders_builder_payload(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $builder = new class($this->makeGrammarWritingRepository()) extends BuildGrammarWritingMeeting4ViewData {
            public function __construct(GrammarWritingRepository $repository)
            {
                parent::__construct($repository);
            }

            public function handle(array $tenseExamples, array $vocabularies): array
            {
                return [
                    'questions' => [1 => ['id' => 'Question 1', 'en' => 'Answer 1']],
                    'fullParagraphId' => 'Paragraph id',
                    'fullParagraphEn' => 'Paragraph en',
                    'paragraphSentences' => [],
                    'paragraphVocab' => [],
                    'submitted' => false,
                    'results' => [],
                    'paragraphResult' => [],
                    'finalScore' => 0,
                    'userAnswers' => [],
                    'userParagraphAnswer' => '',
                ];
            }
        };

        $this->app->instance(BuildGrammarWritingMeeting4ViewData::class, $builder);

        $response = $this->get(route('assignments.grammar-writing.meeting4'));

        $response->assertOk();
        $response->assertViewIs('assignments.grammar-writing.meeting4');
        $response->assertViewHas('submitted', false);
        $response->assertViewHas('fullParagraphId', 'Paragraph id');
    }

    public function test_meeting4_submit_redirects_with_shared_session_payload_and_saves_score(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $questions = [1 => ['id' => 'Question 1', 'en' => 'Answer 1']];
        $paragraphRecord = new GrammarQuestion(['correct_answer' => 'Paragraph']);

        $builder = new class($this->makeGrammarWritingRepository(), $questions, $paragraphRecord) extends BuildGrammarWritingMeeting4ViewData {
            public function __construct(GrammarWritingRepository $repository, private array $questions, private GrammarQuestion $paragraphRecord)
            {
                parent::__construct($repository);
            }

            public function loadQuestionRecords(array $fallbackQuestions, bool $hasSectionColumn): Collection
            {
                return new Collection($this->questions);
            }

            public function formatQuestionsForView(Collection $questionRecords): array
            {
                return $this->questions;
            }

            public function resolveParagraphRecord(bool $hasSectionColumn): ?GrammarQuestion
            {
                return $this->paragraphRecord;
            }
        };

        $evaluator = new class extends EvaluateGrammarWritingMeeting4Submission {
            public function handle($questions, $userParagraphAnswer, $userAnswers, $correctParagraphAnswer): array
            {
                return [
                    'meeting4_submitted' => true,
                    'meeting4_results' => ['1' => 'ok'],
                    'meeting4_paragraph_result' => ['status' => 'ok'],
                    'meeting4_final_score' => 81,
                    'meeting4_user_answers' => ['1' => 'Answer 1'],
                    'meeting4_user_paragraph_answer' => 'Paragraph answer',
                ];
            }
        };

        $this->app->instance(BuildGrammarWritingMeeting4ViewData::class, $builder);
        $this->app->instance(EvaluateGrammarWritingMeeting4Submission::class, $evaluator);

        $response = $this->post(route('assignments.grammar-writing.meeting4.submit'), [
            'userAnswers' => ['1' => 'Answer 1'],
            'userParagraphAnswer' => 'Paragraph answer',
        ]);

        $response->assertRedirect(route('assignments.grammar-writing.meeting4'));
        $response->assertSessionHas('meeting4_submitted', true);
        $response->assertSessionHas('meeting4_final_score', 81);

        $this->assertDatabaseHas('meeting_scores', [
            'user_id' => $user->id,
            'meeting_number' => 4,
            'score' => 81,
        ]);
    }

    public function test_meeting4_reset_clears_shared_session_keys_and_redirects(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->withSession([
            'meeting4_submitted' => true,
            'meeting4_results' => ['1' => 'ok'],
            'meeting4_paragraph_result' => ['status' => 'ok'],
            'meeting4_final_score' => 81,
            'meeting4_user_answers' => ['1' => 'Answer 1'],
            'meeting4_user_paragraph_answer' => 'Paragraph answer',
        ])->post(route('assignments.grammar-writing.meeting4.reset'));

        $response->assertRedirect(route('assignments.grammar-writing.meeting4'));
        $response->assertSessionMissing('meeting4_submitted');
        $response->assertSessionMissing('meeting4_results');
        $response->assertSessionMissing('meeting4_paragraph_result');
        $response->assertSessionMissing('meeting4_final_score');
        $response->assertSessionMissing('meeting4_user_answers');
        $response->assertSessionMissing('meeting4_user_paragraph_answer');
    }

    public function test_meeting20_reset_clears_its_special_session_keys_and_redirects(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->withSession([
            'meeting20_submitted' => true,
            'meeting20_user_paragraph_answer' => 'Answer',
            'meeting20_paragraph_result' => ['score' => 50],
            'meeting20_final_score' => 50,
        ])->post(route('assignments.grammar-writing.meeting20.reset'));

        $response->assertRedirect(route('assignments.grammar-writing.meeting20'));
        $response->assertSessionMissing('meeting20_submitted');
        $response->assertSessionMissing('meeting20_user_paragraph_answer');
        $response->assertSessionMissing('meeting20_paragraph_result');
        $response->assertSessionMissing('meeting20_final_score');
    }

    public function test_meeting10_submit_redirects_with_session_payload_and_saves_score(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $questions = new Collection([
            ['id' => 'Question', 'en' => 'Correct answer'],
        ]);
        $paragraph = ['id' => 'Paragraph id', 'en' => 'Paragraph answer', 'vocab' => []];

        $builder = new class($this->makeGrammarWritingRepository(), $questions, $paragraph) extends BuildGrammarWritingMeeting10ViewData {
            public function __construct(GrammarWritingRepository $repository, private Collection $questions, private array $paragraph)
            {
                parent::__construct($repository);
            }

            public function loadQuestions(): Collection
            {
                return $this->questions;
            }

            public function loadParagraph(array $fallbackParagraph): array
            {
                return $this->paragraph;
            }
        };

        $evaluator = new class extends EvaluateGrammarWritingMeeting10Submission {
            public function handle(Collection $questions, string $correctParagraph, array $userAnswers, string $userParagraphAnswer): array
            {
                return [
                    'meeting10_submitted' => true,
                    'meeting10_results' => [0 => ['score' => 10]],
                    'meeting10_paragraph_result' => ['score' => 20, 'formatted_answer' => 'Paragraph answer', 'max_score' => 20],
                    'meeting10_final_score' => 95,
                    'meeting10_user_answers' => $userAnswers,
                    'meeting10_user_paragraph_answer' => $userParagraphAnswer,
                ];
            }
        };

        $this->app->instance(BuildGrammarWritingMeeting10ViewData::class, $builder);
        $this->app->instance(EvaluateGrammarWritingMeeting10Submission::class, $evaluator);

        $response = $this->post(route('assignments.grammar-writing.meeting10.submit'), [
            'userAnswers' => ['Custom answer'],
            'userParagraphAnswer' => 'Paragraph answer',
        ]);

        $response->assertRedirect(route('assignments.grammar-writing.meeting10'));
        $response->assertSessionHas('meeting10_submitted', true);
        $response->assertSessionHas('meeting10_final_score', 95);
        $response->assertSessionHas('meeting10_user_answers', ['Custom answer']);

        $this->assertDatabaseHas('meeting_scores', [
            'user_id' => $user->id,
            'meeting_number' => 10,
            'score' => 95,
        ]);
    }

    public function test_meeting10_get_renders_builder_payload(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $builder = new class($this->makeGrammarWritingRepository()) extends BuildGrammarWritingMeeting10ViewData {
            public function __construct(GrammarWritingRepository $repository)
            {
                parent::__construct($repository);
            }

            public function handle(array $fallbackParagraph, array $examples, int $meetingNumber = 10): array
            {
                return [
                    'questions' => collect([
                        1 => [
                            'id' => 'Question 1',
                            'en' => 'Answer 1',
                            'type' => 'Comparative',
                            'vocab' => [],
                            'example' => ['id' => 'Example id', 'en' => 'Example en'],
                            'db_id' => 0,
                        ],
                    ]),
                    'paragraph' => ['id' => 'Paragraph id', 'en' => 'Paragraph en', 'vocab' => [], 'db_id' => 0],
                    'fullParagraphId' => 'Paragraph id',
                    'fullParagraphEn' => 'Paragraph en',
                    'paragraphVocab' => [],
                    'examples' => ['Comparative' => ['id' => 'Example id', 'en' => 'Example en']],
                    'submitted' => false,
                    'results' => [],
                    'paragraphResult' => [],
                    'finalScore' => 0,
                    'userAnswers' => [],
                    'userParagraphAnswer' => '',
                ];
            }
        };

        $this->app->instance(BuildGrammarWritingMeeting10ViewData::class, $builder);

        $response = $this->get(route('assignments.grammar-writing.meeting10'));

        $response->assertOk();
        $response->assertViewIs('assignments.grammar-writing.meeting10');
        $response->assertViewHas('submitted', false);
        $response->assertViewHas('fullParagraphEn', 'Paragraph en');
    }

    public function test_meeting10_reset_clears_shared_session_keys_and_redirects(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->withSession([
            'meeting10_submitted' => true,
            'meeting10_results' => [0 => ['score' => 10]],
            'meeting10_paragraph_result' => ['score' => 20],
            'meeting10_final_score' => 95,
            'meeting10_user_answers' => ['Custom answer'],
            'meeting10_user_paragraph_answer' => 'Paragraph answer',
        ])->post(route('assignments.grammar-writing.meeting10.reset'));

        $response->assertRedirect(route('assignments.grammar-writing.meeting10'));
        $response->assertSessionMissing('meeting10_submitted');
        $response->assertSessionMissing('meeting10_results');
        $response->assertSessionMissing('meeting10_paragraph_result');
        $response->assertSessionMissing('meeting10_final_score');
        $response->assertSessionMissing('meeting10_user_answers');
        $response->assertSessionMissing('meeting10_user_paragraph_answer');
    }

    public function test_meeting11_get_renders_builder_payload(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $builder = new class($this->makeGrammarWritingRepository()) extends BuildGrammarWritingMeeting11ViewData {
            public function __construct(GrammarWritingRepository $repository)
            {
                parent::__construct($repository);
            }

            public function handle(array $fallbackQuestions, array $fallbackParagraph): array
            {
                return [
                    'questions' => collect([
                        0 => [
                            'id' => 'Question 1',
                            'en' => 'Answer 1',
                            'vocab' => [],
                            'example' => 'Example 1',
                            'db_id' => 0,
                        ],
                    ]),
                    'fullParagraphId' => 'Paragraph id',
                    'fullParagraphEn' => 'Paragraph en',
                    'paragraphVocab' => [],
                    'paragraphDbId' => 0,
                    'submitted' => false,
                    'results' => [],
                    'paragraphResult' => [],
                    'finalScore' => 0,
                    'userAnswers' => [],
                    'userParagraphAnswer' => '',
                ];
            }
        };

        $this->app->instance(BuildGrammarWritingMeeting11ViewData::class, $builder);

        $response = $this->get(route('assignments.grammar-writing.meeting11'));

        $response->assertOk();
        $response->assertViewIs('assignments.grammar-writing.meeting11');
        $response->assertViewHas('submitted', false);
        $response->assertViewHas('fullParagraphEn', 'Paragraph en');
    }

    public function test_meeting11_submit_redirects_with_session_payload_and_saves_score(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $questions = new Collection([
            0 => ['id' => 'Question 1', 'en' => 'Answer 1', 'vocab' => [], 'example' => 'Example 1', 'db_id' => 0],
        ]);
        $paragraph = ['id' => 'Paragraph id', 'en' => 'Paragraph en', 'vocab' => [], 'db_id' => 0];

        $builder = new class($this->makeGrammarWritingRepository(), $questions, $paragraph) extends BuildGrammarWritingMeeting11ViewData {
            public function __construct(GrammarWritingRepository $repository, private Collection $questions, private array $paragraph)
            {
                parent::__construct($repository);
            }

            public function loadQuestions(array $fallbackQuestions): Collection
            {
                return $this->questions;
            }

            public function loadParagraph(array $fallbackParagraph): array
            {
                return $this->paragraph;
            }
        };

        $evaluator = new class extends EvaluateGrammarWritingMeeting11Submission {
            public function handle(Collection $questions, string $correctParagraph, array $userAnswers, string $userParagraphAnswer): array
            {
                return [
                    'meeting11_submitted' => true,
                    'meeting11_results' => [0 => ['score' => 10]],
                    'meeting11_paragraph_result' => ['score' => 18, 'formatted_answer' => 'Paragraph answer', 'max_score' => 20],
                    'meeting11_final_score' => 93,
                    'meeting11_user_answers' => $userAnswers,
                    'meeting11_user_paragraph_answer' => $userParagraphAnswer,
                ];
            }
        };

        $this->app->instance(BuildGrammarWritingMeeting11ViewData::class, $builder);
        $this->app->instance(EvaluateGrammarWritingMeeting11Submission::class, $evaluator);

        $response = $this->post(route('assignments.grammar-writing.meeting11.submit'), [
            'userAnswers' => ['Custom answer'],
            'userParagraphAnswer' => 'Paragraph answer',
        ]);

        $response->assertRedirect(route('assignments.grammar-writing.meeting11'));
        $response->assertSessionHas('meeting11_submitted', true);
        $response->assertSessionHas('meeting11_final_score', 93);
        $response->assertSessionHas('meeting11_user_answers', ['Custom answer']);

        $this->assertDatabaseHas('meeting_scores', [
            'user_id' => $user->id,
            'meeting_number' => 11,
            'score' => 93,
        ]);
    }

    public function test_meeting11_reset_clears_shared_session_keys_and_redirects(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->withSession([
            'meeting11_submitted' => true,
            'meeting11_results' => [0 => ['score' => 10]],
            'meeting11_paragraph_result' => ['score' => 18],
            'meeting11_final_score' => 93,
            'meeting11_user_answers' => ['Custom answer'],
            'meeting11_user_paragraph_answer' => 'Paragraph answer',
        ])->post(route('assignments.grammar-writing.meeting11.reset'));

        $response->assertRedirect(route('assignments.grammar-writing.meeting11'));
        $response->assertSessionMissing('meeting11_submitted');
        $response->assertSessionMissing('meeting11_results');
        $response->assertSessionMissing('meeting11_paragraph_result');
        $response->assertSessionMissing('meeting11_final_score');
        $response->assertSessionMissing('meeting11_user_answers');
        $response->assertSessionMissing('meeting11_user_paragraph_answer');
    }

    public function test_meeting16_get_renders_builder_payload(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $builder = new class($this->makeGrammarWritingRepository()) extends BuildGrammarWritingMeeting16ViewData {
            public function __construct(GrammarWritingRepository $repository)
            {
                parent::__construct($repository);
            }

            public function handle(array $fallbackParagraph): array
            {
                return [
                    'submitted' => false,
                    'results' => [],
                    'paragraphResult' => [],
                    'finalScore' => 0,
                    'userAnswers' => [],
                    'userParagraphAnswer' => '',
                    'questions' => [],
                    'fullParagraphId' => 'Paragraph id',
                    'fullParagraphEn' => 'Paragraph en',
                    'paragraphVocab' => [],
                    'paragraphDbId' => 0,
                ];
            }
        };

        $this->app->instance(BuildGrammarWritingMeeting16ViewData::class, $builder);

        $response = $this->get(route('assignments.grammar-writing.meeting16'));

        $response->assertOk();
        $response->assertViewIs('assignments.grammar-writing.meeting16');
        $response->assertViewHas('submitted', false);
        $response->assertViewHas('fullParagraphEn', 'Paragraph en');
    }

    public function test_meeting16_submit_redirects_with_session_payload_and_saves_score(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $paragraph = ['id' => 'Paragraph id', 'en' => 'Paragraph en', 'vocab' => [], 'db_id' => 0];

        $builder = new class($this->makeGrammarWritingRepository(), $paragraph) extends BuildGrammarWritingMeeting16ViewData {
            public function __construct(GrammarWritingRepository $repository, private array $paragraph)
            {
                parent::__construct($repository);
            }

            public function loadParagraph(array $fallbackParagraph): array
            {
                return $this->paragraph;
            }
        };

        $evaluator = new class extends EvaluateGrammarWritingMeeting16Submission {
            public function handle(string $correctParagraph, string $userParagraphAnswer): array
            {
                return [
                    'meeting16_submitted' => true,
                    'meeting16_results' => [],
                    'meeting16_paragraph_result' => ['score' => 82, 'formatted_answer' => 'Paragraph answer', 'max_score' => 100],
                    'meeting16_final_score' => 82,
                    'meeting16_user_answers' => [],
                    'meeting16_user_paragraph_answer' => $userParagraphAnswer,
                ];
            }
        };

        $this->app->instance(BuildGrammarWritingMeeting16ViewData::class, $builder);
        $this->app->instance(EvaluateGrammarWritingMeeting16Submission::class, $evaluator);

        $response = $this->post(route('assignments.grammar-writing.meeting16.submit'), [
            'userParagraphAnswer' => 'Paragraph answer',
        ]);

        $response->assertRedirect(route('assignments.grammar-writing.meeting16'));
        $response->assertSessionHas('meeting16_submitted', true);
        $response->assertSessionHas('meeting16_final_score', 82);
        $response->assertSessionHas('meeting16_user_paragraph_answer', 'Paragraph answer');

        $this->assertDatabaseHas('meeting_scores', [
            'user_id' => $user->id,
            'meeting_number' => 16,
            'score' => 82,
        ]);
    }

    public function test_meeting16_reset_clears_shared_session_keys_and_redirects(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->withSession([
            'meeting16_submitted' => true,
            'meeting16_results' => [],
            'meeting16_paragraph_result' => ['score' => 82],
            'meeting16_final_score' => 82,
            'meeting16_user_answers' => [],
            'meeting16_user_paragraph_answer' => 'Paragraph answer',
        ])->post(route('assignments.grammar-writing.meeting16.reset'));

        $response->assertRedirect(route('assignments.grammar-writing.meeting16'));
        $response->assertSessionMissing('meeting16_submitted');
        $response->assertSessionMissing('meeting16_results');
        $response->assertSessionMissing('meeting16_paragraph_result');
        $response->assertSessionMissing('meeting16_final_score');
        $response->assertSessionMissing('meeting16_user_answers');
        $response->assertSessionMissing('meeting16_user_paragraph_answer');
    }

    public function test_meeting18_get_renders_builder_payload(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $builder = new class($this->makeGrammarWritingRepository()) extends BuildGrammarWritingMeeting18ViewData {
            public function __construct(GrammarWritingRepository $repository)
            {
                parent::__construct($repository);
            }

            public function handle(array $fallbackQuestions, array $fallbackParagraph): array
            {
                return [
                    'questions' => [
                        0 => [
                            'id' => 'Question 1',
                            'en' => 'Answer 1',
                            'vocab' => [],
                            'example' => ['id' => 'Example id', 'en' => 'Example en'],
                            'db_id' => 0,
                        ],
                    ],
                    'fullParagraphId' => 'Paragraph id',
                    'fullParagraphEn' => 'Paragraph en',
                    'paragraphVocab' => [],
                    'paragraphDbId' => 0,
                    'submitted' => false,
                    'results' => [],
                    'paragraphResult' => [],
                    'finalScore' => 0,
                    'userAnswers' => [],
                    'userParagraphAnswer' => '',
                ];
            }
        };

        $this->app->instance(BuildGrammarWritingMeeting18ViewData::class, $builder);

        $response = $this->get(route('assignments.grammar-writing.meeting18'));

        $response->assertOk();
        $response->assertViewIs('assignments.grammar-writing.meeting18');
        $response->assertViewHas('submitted', false);
        $response->assertViewHas('fullParagraphEn', 'Paragraph en');
    }

    public function test_meeting18_submit_redirects_with_session_payload_and_saves_score(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $questions = [
            0 => ['id' => 'Question 1', 'en' => 'Answer 1', 'vocab' => [], 'example' => ['id' => 'Example id', 'en' => 'Example en'], 'db_id' => 0],
        ];
        $paragraph = ['id' => 'Paragraph id', 'en' => 'Paragraph en', 'vocab' => [], 'db_id' => 0];

        $builder = new class($this->makeGrammarWritingRepository(), $questions, $paragraph) extends BuildGrammarWritingMeeting18ViewData {
            public function __construct(GrammarWritingRepository $repository, private array $questions, private array $paragraph)
            {
                parent::__construct($repository);
            }

            public function loadQuestions(array $fallbackQuestions): array
            {
                return $this->questions;
            }

            public function loadParagraph(array $fallbackParagraph): array
            {
                return $this->paragraph;
            }
        };

        $evaluator = new class extends EvaluateGrammarWritingMeeting18Submission {
            public function handle(array $questions, string $correctParagraph, array $userAnswers, string $userParagraphAnswer): array
            {
                return [
                    'meeting18_submitted' => true,
                    'meeting18_results' => [0 => ['score' => 14]],
                    'meeting18_paragraph_result' => ['score' => 17, 'formatted_answer' => 'Paragraph answer', 'max_score' => 20],
                    'meeting18_final_score' => 94,
                    'meeting18_user_answers' => $userAnswers,
                    'meeting18_user_paragraph_answer' => $userParagraphAnswer,
                ];
            }
        };

        $this->app->instance(BuildGrammarWritingMeeting18ViewData::class, $builder);
        $this->app->instance(EvaluateGrammarWritingMeeting18Submission::class, $evaluator);

        $response = $this->post(route('assignments.grammar-writing.meeting18.submit'), [
            'userAnswers' => ['Custom answer'],
            'userParagraphAnswer' => 'Paragraph answer',
        ]);

        $response->assertRedirect(route('assignments.grammar-writing.meeting18'));
        $response->assertSessionHas('meeting18_submitted', true);
        $response->assertSessionHas('meeting18_final_score', 94);
        $response->assertSessionHas('meeting18_user_answers', ['Custom answer']);

        $this->assertDatabaseHas('meeting_scores', [
            'user_id' => $user->id,
            'meeting_number' => 18,
            'score' => 94,
        ]);
    }

    public function test_meeting18_reset_clears_shared_session_keys_and_redirects(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->withSession([
            'meeting18_submitted' => true,
            'meeting18_results' => [0 => ['score' => 14]],
            'meeting18_paragraph_result' => ['score' => 17],
            'meeting18_final_score' => 94,
            'meeting18_user_answers' => ['Custom answer'],
            'meeting18_user_paragraph_answer' => 'Paragraph answer',
        ])->post(route('assignments.grammar-writing.meeting18.reset'));

        $response->assertRedirect(route('assignments.grammar-writing.meeting18'));
        $response->assertSessionMissing('meeting18_submitted');
        $response->assertSessionMissing('meeting18_results');
        $response->assertSessionMissing('meeting18_paragraph_result');
        $response->assertSessionMissing('meeting18_final_score');
        $response->assertSessionMissing('meeting18_user_answers');
        $response->assertSessionMissing('meeting18_user_paragraph_answer');
    }

    public function test_meeting19_get_renders_builder_payload(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $builder = new class($this->makeGrammarWritingRepository()) extends BuildGrammarWritingMeeting19ViewData {
            public function __construct(GrammarWritingRepository $repository)
            {
                parent::__construct($repository);
            }

            public function handle(array $fallbackQuestions, array $fallbackParagraph): array
            {
                return [
                    'questions' => [
                        0 => [
                            'id' => 'Question 1',
                            'en' => 'Answer 1',
                            'vocab' => [],
                            'type' => 'Sentence Adverb',
                            'adverb' => 'indeed',
                            'example' => ['id' => 'Example id', 'en' => 'Example en'],
                        ],
                    ],
                    'fullParagraphId' => 'Paragraph id',
                    'fullParagraphEn' => 'Paragraph en',
                    'paragraphVocab' => [],
                    'submitted' => false,
                    'results' => [],
                    'paragraphResult' => [],
                    'finalScore' => 0,
                    'userAnswers' => [],
                    'userParagraphAnswer' => '',
                ];
            }
        };

        $this->app->instance(BuildGrammarWritingMeeting19ViewData::class, $builder);

        $response = $this->get(route('assignments.grammar-writing.meeting19'));

        $response->assertOk();
        $response->assertViewIs('assignments.grammar-writing.meeting19');
        $response->assertViewHas('submitted', false);
        $response->assertViewHas('fullParagraphEn', 'Paragraph en');
    }

    public function test_meeting19_submit_redirects_with_session_payload_and_saves_score(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $questions = [
            0 => ['id' => 'Question 1', 'en' => 'Answer 1', 'vocab' => [], 'type' => 'Sentence Adverb', 'adverb' => 'indeed', 'example' => ['id' => 'Example id', 'en' => 'Example en']],
        ];
        $paragraph = ['id' => 'Paragraph id', 'en' => 'Paragraph en', 'vocab' => []];

        $builder = new class($this->makeGrammarWritingRepository(), $questions, $paragraph) extends BuildGrammarWritingMeeting19ViewData {
            public function __construct(GrammarWritingRepository $repository, private array $questions, private array $paragraph)
            {
                parent::__construct($repository);
            }

            public function loadQuestions(array $fallbackQuestions): array
            {
                return $this->questions;
            }

            public function loadParagraph(array $fallbackParagraph): array
            {
                return $this->paragraph;
            }
        };

        $evaluator = new class extends EvaluateGrammarWritingMeeting19Submission {
            public function handle(array $questions, string $correctParagraph, array $userAnswers, string $userParagraphAnswer): array
            {
                return [
                    'meeting19_submitted' => true,
                    'meeting19_results' => [0 => ['score' => 13]],
                    'meeting19_paragraph_result' => ['score' => 19, 'formatted_answer' => 'Paragraph answer', 'max_score' => 20],
                    'meeting19_final_score' => 92,
                    'meeting19_user_answers' => $userAnswers,
                    'meeting19_user_paragraph_answer' => $userParagraphAnswer,
                ];
            }
        };

        $this->app->instance(BuildGrammarWritingMeeting19ViewData::class, $builder);
        $this->app->instance(EvaluateGrammarWritingMeeting19Submission::class, $evaluator);

        $response = $this->post(route('assignments.grammar-writing.meeting19.submit'), [
            'userAnswers' => ['Custom answer'],
            'userParagraphAnswer' => 'Paragraph answer',
        ]);

        $response->assertRedirect(route('assignments.grammar-writing.meeting19'));
        $response->assertSessionHas('meeting19_submitted', true);
        $response->assertSessionHas('meeting19_final_score', 92);
        $response->assertSessionHas('meeting19_user_answers', ['Custom answer']);

        $this->assertDatabaseHas('meeting_scores', [
            'user_id' => $user->id,
            'meeting_number' => 19,
            'score' => 92,
        ]);
    }

    public function test_meeting19_reset_clears_shared_session_keys_and_redirects(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->withSession([
            'meeting19_submitted' => true,
            'meeting19_results' => [0 => ['score' => 13]],
            'meeting19_paragraph_result' => ['score' => 19],
            'meeting19_final_score' => 92,
            'meeting19_user_answers' => ['Custom answer'],
            'meeting19_user_paragraph_answer' => 'Paragraph answer',
        ])->post(route('assignments.grammar-writing.meeting19.reset'));

        $response->assertRedirect(route('assignments.grammar-writing.meeting19'));
        $response->assertSessionMissing('meeting19_submitted');
        $response->assertSessionMissing('meeting19_results');
        $response->assertSessionMissing('meeting19_paragraph_result');
        $response->assertSessionMissing('meeting19_final_score');
        $response->assertSessionMissing('meeting19_user_answers');
        $response->assertSessionMissing('meeting19_user_paragraph_answer');
    }

    public function test_meeting17_submit_redirects_with_keyed_question_payload_and_saves_score(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $questions = [
            1 => ['id' => 'Question one', 'en' => 'Correct one'],
            2 => ['id' => 'Question two', 'en' => 'Correct two'],
        ];
        $paragraph = ['id' => 'Paragraph id', 'en' => 'Paragraph answer', 'vocab' => [], 'db_id' => 0];

        $builder = new class($this->makeGrammarWritingRepository(), $questions, $paragraph) extends BuildGrammarWritingMeeting17ViewData {
            public function __construct(GrammarWritingRepository $repository, private array $questions, private array $paragraph)
            {
                parent::__construct($repository);
            }

            public function loadQuestions(array $fallbackQuestions): array
            {
                return $this->questions;
            }

            public function loadParagraph(array $fallbackParagraph): array
            {
                return $this->paragraph;
            }
        };

        $evaluator = new class extends EvaluateGrammarWritingMeeting17Submission {
            public function handle(array $questions, string $correctParagraph, array $userAnswers, string $userParagraphAnswer): array
            {
                return [
                    'meeting17_submitted' => true,
                    'meeting17_results' => [1 => ['score' => 10], 2 => ['score' => 8]],
                    'meeting17_paragraph_result' => ['score' => 18, 'formatted_answer' => 'Paragraph answer', 'max_score' => 20],
                    'meeting17_final_score' => 90,
                    'meeting17_user_answers' => $userAnswers,
                    'meeting17_user_paragraph_answer' => $userParagraphAnswer,
                ];
            }
        };

        $this->app->instance(BuildGrammarWritingMeeting17ViewData::class, $builder);
        $this->app->instance(EvaluateGrammarWritingMeeting17Submission::class, $evaluator);

        $response = $this->post(route('assignments.grammar-writing.meeting17.submit'), [
            'userAnswers' => [1 => 'Custom one', 2 => 'Custom two'],
            'userParagraphAnswer' => 'Paragraph answer',
        ]);

        $response->assertRedirect(route('assignments.grammar-writing.meeting17'));
        $response->assertSessionHas('meeting17_submitted', true);
        $response->assertSessionHas('meeting17_final_score', 90);
        $response->assertSessionHas('meeting17_user_answers', [1 => 'Custom one', 2 => 'Custom two']);

        $this->assertDatabaseHas('meeting_scores', [
            'user_id' => $user->id,
            'meeting_number' => 17,
            'score' => 90,
        ]);
    }

    public function test_meeting17_get_renders_builder_payload(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $builder = new class($this->makeGrammarWritingRepository()) extends BuildGrammarWritingMeeting17ViewData {
            public function __construct(GrammarWritingRepository $repository)
            {
                parent::__construct($repository);
            }

            public function handle(array $fallbackQuestions, array $fallbackParagraph): array
            {
                return [
                    'questions' => [
                        1 => [
                            'id' => 'Question 1',
                            'en' => 'Answer 1',
                            'example' => ['id' => 'Example id', 'en' => 'Example en'],
                            'vocab' => [],
                            'db_id' => 0,
                        ],
                    ],
                    'fullParagraphId' => 'Paragraph id',
                    'fullParagraphEn' => 'Paragraph en',
                    'paragraphVocab' => [],
                    'paragraphDbId' => 0,
                    'nounClauseExample' => ['id' => 'Clause id', 'en' => 'Clause en'],
                    'submitted' => false,
                    'results' => [],
                    'paragraphResult' => [],
                    'finalScore' => 0,
                    'userAnswers' => [],
                    'userParagraphAnswer' => '',
                ];
            }
        };

        $this->app->instance(BuildGrammarWritingMeeting17ViewData::class, $builder);

        $response = $this->get(route('assignments.grammar-writing.meeting17'));

        $response->assertOk();
        $response->assertViewIs('assignments.grammar-writing.meeting17');
        $response->assertViewHas('submitted', false);
        $response->assertViewHas('fullParagraphEn', 'Paragraph en');
    }

    public function test_meeting17_reset_clears_shared_session_keys_and_redirects(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->withSession([
            'meeting17_submitted' => true,
            'meeting17_results' => [1 => ['score' => 10]],
            'meeting17_paragraph_result' => ['score' => 18],
            'meeting17_final_score' => 90,
            'meeting17_user_answers' => [1 => 'Custom one'],
            'meeting17_user_paragraph_answer' => 'Paragraph answer',
        ])->post(route('assignments.grammar-writing.meeting17.reset'));

        $response->assertRedirect(route('assignments.grammar-writing.meeting17'));
        $response->assertSessionMissing('meeting17_submitted');
        $response->assertSessionMissing('meeting17_results');
        $response->assertSessionMissing('meeting17_paragraph_result');
        $response->assertSessionMissing('meeting17_final_score');
        $response->assertSessionMissing('meeting17_user_answers');
        $response->assertSessionMissing('meeting17_user_paragraph_answer');
    }
}