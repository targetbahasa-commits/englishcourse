@extends('layouts.admin')

@section('title', 'Hasil Tes Kompetensi - ' . ($result->user->name ?? ''))

@section('content')
<div class="p-8">
    <a href="{{ route('admin.placement-test.results.index') }}" class="text-sm text-gray-500 hover:text-gray-700">&larr; Back to Results</a>

    <div class="flex justify-between items-start mt-2 mb-6">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">{{ $result->user->name ?? '—' }}</h2>
            <p class="text-sm text-gray-500">{{ $result->user->email ?? '' }}</p>
            <p class="text-xs text-gray-400 mt-1">Paket: {{ $result->package->title ?? '—' }}</p>
        </div>
        @if($result->cefr_level)
            <div class="text-right">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-lg font-bold bg-indigo-100 text-indigo-800">{{ $result->cefr_level }}</span>
                <p class="text-xs text-gray-500 mt-1">Overall: {{ $result->overall_percentage }}%</p>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-4 gap-4 mb-8">
        @foreach ([['Reading', $result->reading_score], ['Listening', $result->listening_score], ['Writing', $result->writing_score], ['Speaking', $result->speaking_score]] as [$label, $score])
            <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm text-center">
                <p class="text-xs text-gray-500 uppercase font-semibold">{{ $label }}</p>
                <p class="text-2xl font-bold text-gray-800 mt-1">{{ $score ?? '—' }}{{ $score !== null ? '%' : '' }}</p>
            </div>
        @endforeach
    </div>

    @if($recommendedPrograms->isNotEmpty())
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm mb-6">
            <h3 class="font-semibold text-gray-800 mb-3">Program yang Direkomendasikan</h3>
            <div class="flex flex-wrap gap-2">
                @foreach($recommendedPrograms as $program)
                    <span class="inline-flex items-center px-3 py-1.5 rounded-lg text-sm font-medium bg-blue-50 text-blue-700 border border-blue-100">{{ $program->name }}</span>
                @endforeach
            </div>
        </div>
    @endif

    @php
        $writingAnswer = data_get($result->answers_data, 'writing.essay');
        $writingEval = data_get($result->evaluation_data, 'writing');
        $speakingAudio = data_get($result->answers_data, 'speaking.audio_path');
        $speakingEval = data_get($result->evaluation_data, 'speaking');
    @endphp

    @if($writingAnswer)
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm mb-6">
            <h3 class="font-semibold text-gray-800 mb-3">Writing</h3>
            <p class="text-sm text-gray-800 whitespace-pre-line bg-gray-50 p-4 rounded-lg mb-3">{{ $writingAnswer }}</p>
            @if($writingEval)
                <p class="text-sm text-gray-600 mb-2"><span class="font-semibold">CEFR estimate:</span> {{ data_get($writingEval, 'cefr_estimate', '—') }}</p>
                @if(data_get($writingEval, 'scores'))
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-3">
                        @foreach (data_get($writingEval, 'scores', []) as $criterion => $value)
                            <div class="text-xs bg-gray-50 rounded-lg p-2">
                                <div class="text-gray-500 uppercase">{{ str_replace('_', ' ', $criterion) }}</div>
                                <div class="font-bold text-gray-800">{{ $value }}</div>
                            </div>
                        @endforeach
                    </div>
                @endif
                @if(data_get($writingEval, 'feedback'))
                    <p class="text-sm text-gray-600 italic">{{ data_get($writingEval, 'feedback') }}</p>
                @endif
            @else
                <p class="text-sm text-amber-600 italic">Belum dinilai AI.</p>
            @endif
        </div>
    @endif

    @if($speakingAudio)
        <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm mb-6">
            <h3 class="font-semibold text-gray-800 mb-3">Speaking</h3>
            <audio controls src="{{ asset('storage/' . $speakingAudio) }}" class="w-full mb-3"></audio>
            @if($speakingEval)
                <p class="text-sm text-gray-600 mb-2"><span class="font-semibold">CEFR estimate:</span> {{ data_get($speakingEval, 'cefr_estimate', '—') }}</p>
                @if(data_get($speakingEval, 'transcript'))
                    <p class="text-xs text-gray-500 mb-2"><span class="font-semibold">Transcript:</span> {{ data_get($speakingEval, 'transcript') }}</p>
                @endif
                @if(data_get($speakingEval, 'feedback'))
                    <p class="text-sm text-gray-600 italic">{{ data_get($speakingEval, 'feedback') }}</p>
                @endif
            @else
                <p class="text-sm text-amber-600 italic">Belum dinilai AI.</p>
            @endif
        </div>
    @endif

    <div class="grid grid-cols-2 gap-6">
        @foreach (['reading' => 'Reading', 'listening' => 'Listening'] as $skillKey => $skillLabel)
            @php $skillData = data_get($result->answers_data, $skillKey); @endphp
            @if($skillData)
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm">
                    <h3 class="font-semibold text-gray-800 mb-2">{{ $skillLabel }}</h3>
                    <p class="text-sm text-gray-600">Correct: {{ data_get($skillData, 'correct', 0) }} / {{ data_get($skillData, 'total', 0) }}</p>
                </div>
            @endif
        @endforeach
    </div>
</div>
@endsection
