@extends('layouts.admin')

@section('title', 'Assignment Results - ' . $program->name)

@push('styles')
    <style>
        .score-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.5rem;
            font-weight: 700;
            font-size: 0.875rem;
        }
        
        .score-excellent { background-color: #dcfce7; color: #166534; }
        .score-good { background-color: #dbeafe; color: #1e40af; }
        .score-fair { background-color: #fef3c7; color: #92400e; }
        .score-poor { background-color: #fee2e2; color: #991b1b; }
        
        .score-badge.pending { background-color: #f3f4f6; color: #6b7280; }
    </style>
@endpush

@section('content')
<div class="p-8">
    <!-- Header with Back Button -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.assignment-results.index') }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Back to All Results
            </a>
            <h1 class="text-4xl font-bold text-gray-900">{{ $program->name }}</h1>
            <p class="text-gray-500 mt-2">Assignment submission and scoring details</p>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-sm font-semibold text-gray-500 uppercase">Total Submissions</p>
            <p class="text-4xl font-bold text-gray-900 mt-2">{{ $totalSubmissions }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-sm font-semibold text-gray-500 uppercase">Completed</p>
            <p class="text-4xl font-bold text-green-600 mt-2">{{ $completedSubmissions }}</p>
            <p class="text-xs text-gray-500 mt-2">{{ $totalSubmissions > 0 ? round(($completedSubmissions / $totalSubmissions) * 100) : 0 }}% completed</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-sm font-semibold text-gray-500 uppercase">Average Score</p>
            <p class="text-4xl font-bold text-indigo-600 mt-2">{{ $averageScore ? number_format($averageScore, 1) : 'N/A' }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-sm font-semibold text-gray-500 uppercase">Unique Students</p>
            <p class="text-4xl font-bold text-purple-600 mt-2">{{ $uniqueStudents }}</p>
        </div>
    </div>

    <!-- Submissions by Meeting -->
    @if($submissionsByMeeting->count() > 0)
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-8 p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-4">Submissions by Meeting</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Meeting</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Completed</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Progress</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($submissionsByMeeting as $meeting)
                    <tr class="hover:bg-blue-50 transition">
                        <td class="px-6 py-4 font-semibold text-gray-900">Meeting {{ $meeting->meeting_number }}</td>
                        <td class="px-6 py-4">
                            <span class="text-lg font-bold text-gray-900">{{ $meeting->total }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-700 text-sm font-semibold">
                                {{ $meeting->completed }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-32 h-2 bg-gray-200 rounded-full overflow-hidden">
                                    @php
                                        $percentage = $meeting->total > 0 ? ($meeting->completed / $meeting->total) * 100 : 0;
                                    @endphp
                                    <div class="h-full bg-blue-600 rounded-full" style="width: {{ $percentage }}%"></div>
                                </div>
                                <span class="text-sm font-semibold text-gray-900">{{ round($percentage) }}%</span>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- In Progress (Not Yet Submitted) -->
    @if($inProgressSubmissions->count() > 0)
    <div x-data="{ viewingDraft: null }">
    <div class="bg-white rounded-2xl shadow-sm border border-amber-100 mb-8 p-6">
        <div class="flex items-center gap-2 mb-2">
            <span class="relative flex h-2.5 w-2.5">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-amber-500"></span>
            </span>
            <h2 class="text-2xl font-bold text-gray-900">Sedang Dikerjakan (Belum Submit)</h2>
        </div>
        <p class="text-sm text-gray-500 mb-6">Siswa yang sudah mulai mengerjakan tapi belum menekan tombol submit. Progres dihitung dari jumlah jawaban yang sudah terisi, bukan hasil penilaian.</p>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-amber-50 border-b border-amber-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Student Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Meeting</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Batch Kelas</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Teacher</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Progres</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Terakhir Disimpan</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($inProgressSubmissions as $draft)
                    @php
                        $draftClassPeriod = $draft->user?->enrollments->first()?->classPeriod ?? $draft->user?->classPeriod;
                        $draftAnswers = is_array($draft->answers) ? $draft->answers : [];
                        $draftTotalCount = count($draftAnswers);
                        $draftFilledCount = collect($draftAnswers)->filter(function ($value) {
                            if (is_array($value)) {
                                return collect($value)->contains(fn ($v) => trim((string) $v) !== '');
                            }
                            return trim((string) $value) !== '';
                        })->count();
                    @endphp
                    <tr class="hover:bg-amber-50/50 transition">
                        <td class="px-6 py-4">
                            <p class="font-semibold text-gray-900">{{ $draft->user->name ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-500 mt-1">ID: {{ $draft->user->id ?? 'N/A' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-amber-100 text-amber-700 text-sm font-semibold">
                                Meeting {{ $draft->meeting_number }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($draftClassPeriod)
                                <p class="text-sm font-semibold text-gray-900">{{ $draftClassPeriod->name }}</p>
                                @if($draftClassPeriod->batch_number)
                                    <p class="text-xs text-gray-500">Batch {{ $draftClassPeriod->batch_number }}</p>
                                @endif
                            @else
                                <span class="text-sm text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-600">{{ $draftClassPeriod->teacher->name ?? '—' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if($draftTotalCount > 0)
                                <div class="flex items-center gap-2">
                                    <div class="w-20 h-2 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-amber-500 rounded-full" style="width: {{ round(($draftFilledCount / $draftTotalCount) * 100) }}%"></div>
                                    </div>
                                    <span class="text-xs font-semibold text-gray-700">{{ $draftFilledCount }}/{{ $draftTotalCount }}</span>
                                </div>
                            @else
                                <span class="text-sm text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-600">{{ $draft->last_saved_at?->diffForHumans() }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $draftQuestions = \App\Http\Controllers\Admin\AdminGrammarWritingReviewController::resolveQuestionsForMeeting(
                                    $program->slug ?? '',
                                    (int) $draft->meeting_number
                                );
                            @endphp
                            <button type="button"
                                @click="viewingDraft = { name: @js($draft->user->name ?? 'N/A'), meta: @js('Meeting ' . $draft->meeting_number), savedAt: @js($draft->last_saved_at?->diffForHumans()), answers: @js($draftAnswers), questions: @js($draftQuestions) }"
                                class="text-xs font-semibold text-blue-600 hover:text-blue-800">
                                Lihat Jawaban
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Draft Answers Modal -->
    <div x-show="viewingDraft" x-cloak @keydown.escape.window="viewingDraft = null" @click.self="viewingDraft = null"
         class="fixed inset-0 bg-black/50 backdrop-blur-xs flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[85vh] flex flex-col overflow-hidden border border-gray-100" @click.stop>
            <!-- Modal Header -->
            <div class="flex items-start justify-between p-6 pb-4 border-b border-gray-100 bg-slate-50/50 shrink-0">
                <div>
                    <h3 class="text-lg font-extrabold text-gray-900" x-text="viewingDraft?.name"></h3>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-orange-100 text-orange-800" x-text="viewingDraft?.meta"></span>
                        <span class="text-xs text-gray-400">&bull;</span>
                        <span class="text-xs text-gray-500 font-medium" x-text="'Tersimpan ' + viewingDraft?.savedAt"></span>
                    </div>
                </div>
                <button type="button" @click="viewingDraft = null" class="w-8 h-8 rounded-full bg-white border border-gray-200 text-gray-400 hover:text-gray-700 hover:bg-gray-100 flex items-center justify-center transition shrink-0 shadow-xs">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Modal Content -->
            <div class="p-6 space-y-4 overflow-y-auto max-h-[calc(85vh-100px)]">
                <template x-for="(value, key) in (viewingDraft?.answers || {})" :key="key">
                    <div class="border border-gray-200/90 rounded-2xl p-4 bg-gray-50/70 hover:bg-gray-50 transition space-y-2.5">
                        <!-- Item Header / Question Number -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-lg text-xs font-bold bg-indigo-100 text-indigo-800"
                                      x-text="key === 'paragraph_answer' || key === 'userParagraphAnswer' ? 'Latihan Paragraf' : (isNaN(key) ? key : 'Soal ' + key)">
                                </span>
                            </div>
                        </div>

                        <!-- Isi Soal (Warna Merah) -->
                        <template x-if="(viewingDraft?.questions && viewingDraft?.questions[key]) || (typeof value === 'object' && value !== null && (value.question || value.question_text))">
                            <div class="bg-red-50 border border-red-200 rounded-xl p-3">
                                <span class="text-[10px] font-bold text-red-500 uppercase tracking-wider block mb-1">Soal:</span>
                                <p class="text-sm font-bold text-red-600 leading-relaxed whitespace-pre-wrap" x-html="(viewingDraft?.questions && viewingDraft?.questions[key]) || value.question || value.question_text"></p>
                            </div>
                        </template>

                        <!-- Case 1: Value is an Object (e.g. {tense: '...', trans: '...'}) -->
                        <template x-if="typeof value === 'object' && value !== null && !Array.isArray(value)">
                            <div class="space-y-2.5">
                                <!-- Tense if present -->
                                <template x-if="value.tense">
                                    <div class="flex items-center gap-2">
                                        <span class="text-xs font-semibold text-gray-500 uppercase">Tense:</span>
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold bg-blue-50 text-blue-700 border border-blue-200/80" x-text="value.tense"></span>
                                    </div>
                                </template>

                                <!-- Translation / Answer if present -->
                                <template x-if="value.trans !== undefined || value.answer !== undefined || value.user_answer !== undefined">
                                    <div>
                                        <span class="text-xs font-semibold text-gray-500 uppercase block mb-1">Terjemahan / Jawaban:</span>
                                        <div class="text-sm font-medium text-gray-900 bg-white p-3 rounded-xl border border-gray-200 shadow-2xs whitespace-pre-wrap leading-relaxed" 
                                             x-text="(value.trans || value.answer || value.user_answer || '(kosong)')">
                                        </div>
                                    </div>
                                </template>

                                <!-- Verb Forms (v2 / v3) if present -->
                                <template x-if="value.v2 || value.v3">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 pt-1">
                                        <div class="bg-white p-3 rounded-xl border border-gray-200 shadow-2xs">
                                            <span class="text-[10px] font-bold text-gray-400 block uppercase mb-0.5">V2 (Simple Past)</span>
                                            <span class="text-sm font-bold text-gray-800" x-text="value.v2 || '—'"></span>
                                        </div>
                                        <div class="bg-white p-3 rounded-xl border border-gray-200 shadow-2xs">
                                            <span class="text-[10px] font-bold text-gray-400 block uppercase mb-0.5">V3 (Past Participle)</span>
                                            <span class="text-sm font-bold text-gray-800" x-text="value.v3 || '—'"></span>
                                        </div>
                                    </div>
                                </template>

                                <!-- Generic Fallback for other Object properties -->
                                <template x-for="(subVal, subKey) in value" :key="subKey">
                                    <template x-if="!['tense', 'trans', 'answer', 'user_answer', 'v2', 'v3'].includes(subKey)">
                                        <div class="bg-white p-3 rounded-xl border border-gray-200 shadow-2xs">
                                            <span class="text-xs font-bold text-gray-500 uppercase block mb-1" x-text="subKey"></span>
                                            <div class="text-sm text-gray-800 whitespace-pre-wrap" x-text="typeof subVal === 'object' ? JSON.stringify(subVal, null, 2) : (subVal || '(kosong)')"></div>
                                        </div>
                                    </template>
                                </template>
                            </div>
                        </template>

                        <!-- Case 2: Value is a Plain String / Primitive -->
                        <template x-if="typeof value !== 'object' || value === null">
                            <div class="text-sm font-medium text-gray-900 bg-white p-3 rounded-xl border border-gray-200 shadow-2xs whitespace-pre-wrap leading-relaxed" 
                                 x-text="value || '(kosong)'">
                            </div>
                        </template>

                        <!-- Case 3: Value is an Array -->
                        <template x-if="Array.isArray(value)">
                            <div class="space-y-2">
                                <template x-for="(item, idx) in value" :key="idx">
                                    <div class="bg-white p-3 rounded-xl border border-gray-200 shadow-2xs text-sm text-gray-800 flex items-start gap-2.5">
                                        <span class="text-xs font-bold text-gray-400 shrink-0" x-text="(idx + 1) + '.'"></span>
                                        <span class="font-medium" x-text="typeof item === 'object' ? JSON.stringify(item) : (item || '(kosong)')"></span>
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>
                </template>

                <p x-show="!viewingDraft?.answers || Object.keys(viewingDraft.answers).length === 0" class="text-sm text-gray-400 text-center py-8">
                    Belum ada jawaban tersimpan.
                </p>
            </div>
        </div>
    </div>
    </div>
    @endif

    <!-- Recent Submissions -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6">Recent Submissions</h2>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Student Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Meeting</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Batch Kelas</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Teacher</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Score</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Review Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Submitted</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($program->meetingScores as $submission)
                    @php
                        // The student's Enrollment for THIS program is the
                        // authoritative source (a student can be enrolled in
                        // several programs under different batches) -
                        // User::classPeriod() is the older single-assignment
                        // fallback for students who never got a proper
                        // Enrollment row.
                        $classPeriod = $submission->user?->enrollments->first()?->classPeriod
                            ?? $submission->user?->classPeriod;
                    @endphp
                    <tr class="hover:bg-blue-50 transition">
                        <td class="px-6 py-4">
                            <div>
                                <a href="{{ route('admin.assignment-results.submission', [$program, $submission]) }}" class="font-semibold text-gray-900 hover:text-blue-600 hover:underline">
                                    {{ $submission->user->name ?? 'N/A' }}
                                </a>
                                <p class="text-xs text-gray-500 mt-1">ID: {{ $submission->user->id ?? 'N/A' }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-600">{{ $submission->user->email ?? 'N/A' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold">
                                Meeting {{ $submission->meeting_number }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($classPeriod)
                                <p class="text-sm font-semibold text-gray-900">{{ $classPeriod->name }}</p>
                                @if($classPeriod->batch_number)
                                    <p class="text-xs text-gray-500">Batch {{ $classPeriod->batch_number }}</p>
                                @endif
                            @else
                                <span class="text-sm text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-600">{{ $classPeriod->teacher->name ?? '—' }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if($submission->score !== null)
                            <span class="score-badge
                                @if($submission->score >= 80) score-excellent
                                @elseif($submission->score >= 60) score-good
                                @elseif($submission->score >= 40) score-fair
                                @else score-poor
                                @endif">
                                {{ $submission->score }}
                            </span>
                            @else
                            <span class="score-badge pending">—</span>
                            @endif
                            @if($submission->teacher_score !== null)
                                <div class="text-xs font-semibold text-purple-700 mt-1">Guru: {{ number_format($submission->teacher_score, 1) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($submission->reviewed_at)
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-0.5 rounded bg-purple-100 text-purple-800">
                                    ✓ Reviewed
                                </span>
                                <p class="text-xs text-gray-500 mt-1">{{ $submission->reviewer->name ?? '' }}</p>
                            @else
                                <span class="inline-flex items-center gap-1 text-[11px] font-medium px-2 py-0.5 rounded bg-gray-100 text-gray-600">
                                    Belum Review
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            @if($submission->submitted_at)
                            <div>
                                <p class="text-sm font-semibold text-gray-900">{{ $submission->submitted_at->format('M d, Y') }}</p>
                                <p class="text-xs text-gray-500">{{ $submission->submitted_at->format('H:i') }}</p>
                            </div>
                            @else
                            <p class="text-sm text-gray-500">Not submitted</p>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center">
                            <p class="text-gray-500">No submissions found for this program.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
