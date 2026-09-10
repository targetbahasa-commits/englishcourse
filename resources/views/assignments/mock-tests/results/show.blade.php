@extends('layouts.dashboard')

@php
    $rawScores = $result->raw_scores ?? [
        'listening' => $result->listening_correct,
        'structure' => $result->structure_correct,
        'reading' => $result->reading_correct,
    ];

    $scaledScores = $result->scaled_scores ?? [
        'listening' => $result->listening_score,
        'structure' => $result->structure_score,
        'reading' => $result->reading_score,
    ];

    $resultPayload = $result->result_payload ?? [];
    $answeredCount = $resultPayload['answered_count'] ?? count($result->answers_data ?? []);
    $correctCount = $resultPayload['correct_count'] ?? array_sum($rawScores);
    $questionCount = $resultPayload['question_count'] ?? 140;
@endphp

@section('content')
<div class="mx-auto max-w-6xl space-y-6">
    <div class="rounded-3xl border border-emerald-100 bg-gradient-to-br from-emerald-50 via-white to-teal-50 p-6 shadow-sm md:p-8">
        <div class="flex flex-col gap-5 md:flex-row md:items-start md:justify-between">
            <div>
                <p class="text-sm font-bold uppercase tracking-[0.2em] text-emerald-600">{{ $result->exam_label }} Result</p>
                <h1 class="mt-2 text-3xl font-extrabold text-slate-900 md:text-4xl">Mock Test Package {{ $result->package_number }}</h1>
                <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-600">
                    {{ $result->source_label }} for {{ $result->name }}. Completed {{ optional($result->completed_at ?? $result->created_at)->format('d M Y, H:i') }}.
                </p>
            </div>
            <div class="rounded-3xl bg-white px-6 py-5 text-center shadow-sm ring-1 ring-emerald-100">
                <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">Total Score</p>
                <p class="mt-2 text-5xl font-black text-emerald-600">{{ $result->total_score }}</p>
            </div>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-4">
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <p class="text-xs font-bold uppercase tracking-[0.18em] text-slate-400">Exam</p>
            <p class="mt-2 text-lg font-bold text-slate-900">{{ $result->exam_label }}</p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <p class="text-xs font-bold uppercase tracking-[0.18em] text-slate-400">Submitted By</p>
            <p class="mt-2 text-lg font-bold text-slate-900">{{ ucfirst($result->submitted_by_role ?? 'user') }}</p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <p class="text-xs font-bold uppercase tracking-[0.18em] text-slate-400">Answered</p>
            <p class="mt-2 text-lg font-bold text-slate-900">{{ $answeredCount }} / {{ $questionCount }}</p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <p class="text-xs font-bold uppercase tracking-[0.18em] text-slate-400">Correct</p>
            <p class="mt-2 text-lg font-bold text-slate-900">{{ $correctCount }}</p>
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-3">
        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-bold uppercase tracking-[0.16em] text-slate-400">Listening</p>
            <p class="mt-4 text-4xl font-black text-red-600">{{ $scaledScores['listening'] ?? 0 }}</p>
            <p class="mt-2 text-sm text-slate-500">Raw correct: {{ $rawScores['listening'] ?? 0 }}</p>
        </div>
        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-bold uppercase tracking-[0.16em] text-slate-400">Structure</p>
            <p class="mt-4 text-4xl font-black text-indigo-600">{{ $scaledScores['structure'] ?? 0 }}</p>
            <p class="mt-2 text-sm text-slate-500">Raw correct: {{ $rawScores['structure'] ?? 0 }}</p>
        </div>
        <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            <p class="text-sm font-bold uppercase tracking-[0.16em] text-slate-400">Reading</p>
            <p class="mt-4 text-4xl font-black text-emerald-600">{{ $scaledScores['reading'] ?? 0 }}</p>
            <p class="mt-2 text-sm text-slate-500">Raw correct: {{ $rawScores['reading'] ?? 0 }}</p>
        </div>
    </div>

    <div class="rounded-3xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="text-xl font-bold text-slate-900">Result Summary</h2>
                <p class="mt-1 text-sm text-slate-500">Saved from the assignment mock test flow and ready to be extended for IELTS or PTE later.</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('assignments.toefl-itp.mockup.package', ['package' => $result->package_number]) }}" class="inline-flex items-center rounded-xl border border-slate-300 bg-white px-4 py-2 text-sm font-bold text-slate-700 transition hover:bg-white">
                    Reopen Mock Test
                </a>
                @if(auth()->check() && auth()->user()->isAdmin())
                    <a href="{{ route('admin.toefl-mockup-results.index') }}" class="inline-flex items-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-bold text-white transition hover:bg-indigo-700">
                        Back to Mockup Results
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
