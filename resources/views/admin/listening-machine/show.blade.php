<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $bank->title }} — Listening Bank</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak]{display:none!important}
        .q-card { transition: box-shadow .2s; }
        .q-card:hover { box-shadow: 0 4px 20px rgba(109,40,217,.08); }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
@include('components.impersonation-banner')

<div class="flex min-h-screen">
    @include('components.sidebar-admin')

    <main class="flex-1 md:ml-64">

        {{-- ── Header ── --}}
        <div class="bg-white border-b border-gray-200 px-8 py-6">
            <div class="max-w-6xl mx-auto">
                <div class="flex items-center gap-3 mb-1">
                    <a href="{{ route('admin.listening-machine.index') }}" class="text-gray-400 hover:text-gray-700 transition text-sm">Listening Bank</a>
                    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="text-sm text-gray-600 font-medium">{{ $bank->title }}</span>
                </div>
                <div class="flex items-start justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">{{ $bank->title }}</h1>
                        <div class="flex flex-wrap items-center gap-2 mt-2">
                            <span class="px-2.5 py-1 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-lg">{{ $bank->level }}</span>
                            <span class="px-2.5 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-lg">{{ $bank->accent }}</span>
                            <span class="px-2.5 py-1 bg-gray-100 text-gray-600 text-xs font-medium rounded-lg">{{ $bank->voice }}</span>
                            @if($bank->background_sound !== 'none')
                            <span class="px-2.5 py-1 bg-violet-100 text-violet-700 text-xs font-medium rounded-lg capitalize">🎵 {{ $bank->background_sound }}</span>
                            @endif
                            @php
                                $statusColor = ['ready'=>'bg-green-100 text-green-700','processing'=>'bg-amber-100 text-amber-700','draft'=>'bg-gray-100 text-gray-600','failed'=>'bg-red-100 text-red-700'];
                            @endphp
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full {{ $statusColor[$bank->status] ?? 'bg-gray-100 text-gray-600' }}">
                                {{ ucfirst($bank->status) }}
                            </span>
                        </div>
                    </div>
                    <form action="{{ route('admin.listening-machine.destroy', $bank) }}" method="POST"
                          onsubmit="return confirm('Delete this listening bank and all its questions?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-100 rounded-xl transition border border-red-200">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="max-w-6xl mx-auto px-8 py-8">
            <div class="grid grid-cols-3 gap-8">

                {{-- ── LEFT: Audio + Transcript ── --}}
                <div class="col-span-2 space-y-6">

                    {{-- Audio Player --}}
                    <div class="bg-gradient-to-br from-violet-700 to-purple-900 rounded-2xl p-8 text-white shadow-xl">
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center backdrop-blur-sm">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.536 8.464a5 5 0 010 7.072M12 9a3 3 0 000 6m9.964-4.5A9 9 0 1112 3"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl font-bold">{{ $bank->title }}</h2>
                                <p class="text-violet-200 text-sm">{{ $bank->topic ?? 'Listening Practice' }}</p>
                            </div>
                            <div class="ml-auto text-right">
                                <p class="text-2xl font-bold font-mono">{{ $bank->duration_formatted }}</p>
                                <p class="text-violet-300 text-xs">Duration</p>
                            </div>
                        </div>

                        @if($bank->audio_url)
                        <audio controls class="w-full rounded-xl" style="accent-color:#c4b5fd;">
                            <source src="{{ $bank->audio_url }}" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                        <div class="flex justify-between mt-3">
                            <a href="{{ $bank->audio_url }}" download class="inline-flex items-center gap-1.5 text-violet-200 hover:text-white text-xs font-medium transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                Download MP3
                            </a>
                            <span class="text-violet-300 text-xs">{{ $bank->questions->count() }} exam questions</span>
                        </div>
                        @else
                        <div class="text-center py-6 text-violet-300">
                            <svg class="w-10 h-10 mx-auto mb-2 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                            </svg>
                            <p class="text-sm">No audio file generated yet</p>
                        </div>
                        @endif
                    </div>

                    {{-- Transcript Tabs --}}
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden" x-data="{ tab: 'humanized' }">
                        <div class="flex border-b border-gray-200">
                            <button @click="tab='humanized'" :class="tab==='humanized' ? 'border-b-2 border-violet-600 text-violet-700 font-semibold' : 'text-gray-500 hover:text-gray-700'"
                                    class="px-6 py-4 text-sm transition">Humanized Script</button>
                            <button @click="tab='raw'" :class="tab==='raw' ? 'border-b-2 border-violet-600 text-violet-700 font-semibold' : 'text-gray-500 hover:text-gray-700'"
                                    class="px-6 py-4 text-sm transition">Original Transcript</button>
                        </div>
                        <div class="p-6">
                            <div x-show="tab==='humanized'" class="prose prose-sm max-w-none text-gray-700 leading-relaxed whitespace-pre-wrap font-mono text-sm">{{ $bank->humanized_transcript ?? '—' }}</div>
                            <div x-show="tab==='raw'" class="prose prose-sm max-w-none text-gray-600 leading-relaxed whitespace-pre-wrap font-mono text-sm">{{ $bank->transcript }}</div>
                        </div>
                    </div>

                </div>

                {{-- ── RIGHT: Metadata + Questions ── --}}
                <div class="space-y-6">

                    {{-- Metadata card --}}
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 space-y-4">
                        <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wide">Details</h3>
                        @php
                            $meta = [
                                ['label' => 'Level',      'value' => $bank->level],
                                ['label' => 'Accent',     'value' => $bank->accent],
                                ['label' => 'Voice',      'value' => $bank->voice],
                                ['label' => 'Background', 'value' => ucfirst($bank->background_sound)],
                                ['label' => 'Duration',   'value' => $bank->duration_formatted],
                                ['label' => 'Questions',  'value' => $bank->questions->count() . ' items'],
                                ['label' => 'Created',    'value' => $bank->created_at->format('d M Y, H:i')],
                            ];
                        @endphp
                        @foreach($meta as $item)
                        <div class="flex items-center justify-between py-2.5 border-b border-gray-50 last:border-0">
                            <span class="text-xs text-gray-400 font-medium">{{ $item['label'] }}</span>
                            <span class="text-xs text-gray-800 font-semibold">{{ $item['value'] }}</span>
                        </div>
                        @endforeach
                    </div>

                    {{-- Questions accordion --}}
                    @if($bank->questions->count())
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                            <h3 class="text-sm font-bold text-gray-700">Exam Questions</h3>
                            <span class="px-2 py-1 bg-indigo-100 text-indigo-700 text-xs font-bold rounded-full">{{ $bank->questions->count() }}</span>
                        </div>
                        <div class="divide-y divide-gray-100" x-data="{open: null}">
                            @foreach($bank->questions as $q)
                            <div class="q-card">
                                <button type="button" @click="open = open === {{ $loop->index }} ? null : {{ $loop->index }}"
                                        class="w-full flex items-start gap-3 px-5 py-4 text-left hover:bg-gray-50 transition">
                                    <span class="w-6 h-6 bg-indigo-100 text-indigo-700 rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">{{ $loop->iteration }}</span>
                                    <span class="text-sm text-gray-800 font-medium flex-1 leading-snug">{{ Str::limit($q->question_text, 80) }}</span>
                                    <svg class="w-4 h-4 text-gray-400 flex-shrink-0 mt-0.5 transition" :class="open === {{ $loop->index }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                <div x-show="open === {{ $loop->index }}" x-transition class="px-5 pb-5 space-y-2">
                                    <p class="text-sm text-gray-800 font-medium">{{ $q->question_text }}</p>
                                    @if($q->options)
                                    <div class="space-y-1.5 mt-2">
                                        @foreach($q->options as $oi => $opt)
                                        <div class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs {{ str_starts_with($opt, $q->correct_answer) ? 'bg-green-50 border border-green-200 text-green-800 font-semibold' : 'bg-gray-50 text-gray-700' }}">
                                            <span class="font-mono font-bold">{{ chr(65 + $oi) }})</span>
                                            <span>{{ preg_replace('/^[A-D]\)\s*/', '', $opt) }}</span>
                                        </div>
                                        @endforeach
                                    </div>
                                    @else
                                    <div class="flex gap-2 mt-2">
                                        @foreach(['True','False','Not Given'] as $ans)
                                        <span class="px-3 py-1 rounded-lg text-xs font-semibold {{ $q->correct_answer === $ans ? 'bg-green-100 text-green-700 border border-green-300' : 'bg-gray-100 text-gray-500' }}">{{ $ans }}</span>
                                        @endforeach
                                    </div>
                                    @endif
                                    @if($q->explanation)
                                    <div class="mt-2 p-3 bg-amber-50 border border-amber-100 rounded-lg text-xs text-amber-800">
                                        <strong>Explanation:</strong> {{ $q->explanation }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @else
                    <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 text-center text-gray-400">
                        <svg class="w-10 h-10 mx-auto mb-2 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-sm">No questions generated</p>
                    </div>
                    @endif

                </div>{{-- /right col --}}
            </div>
        </div>

    </main>
</div>
</body>
</html>
