@extends('layouts.admin')

@section('title', 'Submission Detail - ' . ($submission->user->name ?? 'Unknown'))

@section('content')
<div class="p-8">
    <div class="mb-8 flex items-center justify-between">
        <div>
            <a href="{{ route('admin.assignment-results.show', $program) }}" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Back to {{ $program->name }}
            </a>
            <h1 class="text-4xl font-bold text-gray-900">Submission Detail</h1>
            <p class="text-gray-500 mt-2">Student submission for meeting {{ $submission->meeting_number }}.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium">
            {{ session('success') }}
        </div>
    @endif

    @if(($submission->answers_data['ai_enabled'] ?? true) === false)
        <div class="mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 text-sm font-medium">
            ⚠️ Penilaian AI dinonaktifkan saat siswa submit jawaban ini — skor otomatis di bawah belum mencerminkan penilaian sesungguhnya. Mohon isi Nilai Guru secara manual.
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-sm font-semibold text-gray-500 uppercase">Student</p>
            <p class="text-2xl font-bold text-gray-900 mt-2">{{ $submission->user->name ?? 'N/A' }}</p>
            <p class="text-sm text-gray-500 mt-1">{{ $submission->user->email ?? 'N/A' }}</p>
            <p class="text-xs text-gray-400 mt-3">User ID: {{ $submission->user->id ?? 'N/A' }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-sm font-semibold text-gray-500 uppercase">Skor Otomatis</p>
            <p class="text-4xl font-bold text-indigo-600 mt-2">{{ $submission->score ?? 'Pending' }}</p>
            @if($submission->teacher_score !== null)
                <p class="text-sm font-semibold text-purple-700 mt-1">Nilai Guru: {{ number_format($submission->teacher_score, 1) }}</p>
            @endif
            <p class="text-sm text-gray-500 mt-2">Meeting {{ $submission->meeting_number }}</p>
            <p class="text-xs text-gray-400 mt-3">Submitted at: {{ $submission->submitted_at ? $submission->submitted_at->format('M d, Y H:i') : 'Not submitted' }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-sm font-semibold text-gray-500 uppercase">Program</p>
            <p class="text-2xl font-bold text-gray-900 mt-2">{{ $program->name }}</p>
            <p class="text-sm text-gray-500 mt-2">Program slug: {{ $program->slug }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Submitted Answers</h2>

            <style>
                .word-diff .word-correct { color: #2ecc71; font-weight: bold; }
                .word-diff .word-extra { color: #3498db; font-weight: bold; text-decoration: line-through; }
                .word-diff .word-missing { color: #f1c40f; font-weight: bold; }
                .word-diff .word-wrong { color: #e74c3c; font-weight: bold; text-decoration: underline; }
            </style>

            @if(!empty($submission->answers_data) && is_array($submission->answers_data))
                @include('partials.grammar-writing-answers-tree', ['data' => $submission->answers_data])
            @else
                <div class="text-center py-12 text-gray-500">
                    <p>No stored answer payload is available for this submission.</p>
                    <p class="mt-2 text-xs">If this is a legacy or unrecorded submission, the submission score may still be visible.</p>
                </div>
            @endif
        </div>

        @include('partials.submission-review-form', ['meetingScore' => $submission, 'reviewRoute' => route('admin.assignment-results.submission.review', [$program, $submission])])
    </div>
</div>
@endsection
