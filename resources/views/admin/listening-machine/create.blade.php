<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Listening Material — {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .step-line { transition: width .5s ease; }
        .diff-del { background:#fee2e2; text-decoration:line-through; color:#b91c1c; }
        .diff-add { background:#dcfce7; color:#15803d; }
        [x-cloak] { display:none !important; }
        .speaker-card { transition: border-color .2s, box-shadow .2s; }
        .spinner { animation: spin 1s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50" x-data="listeningWizard()" x-cloak>
@include('components.impersonation-banner')

<div class="flex min-h-screen">
    @include('components.sidebar-admin')

    <main class="flex-1 md:ml-64">

        {{-- ── Header ── --}}
        <div class="bg-white border-b border-gray-200 px-8 py-5 sticky top-0 z-20">
            <div class="max-w-4xl mx-auto flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.listening-machine.index') }}" class="p-2 text-gray-400 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Create Listening Material</h1>
                        <p class="text-xs text-gray-500">AI-powered 4-step wizard</p>
                    </div>
                </div>
                {{-- Step indicator --}}
                <div class="flex items-center gap-4">
                    <button type="button" @click="clearDraft()" x-show="localStorage.getItem('listening_wizard_draft')" class="text-xs font-semibold text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition" style="display: none;" x-effect="$el.style.display = localStorage.getItem('listening_wizard_draft') ? '' : 'none'">
                        Clear Draft
                    </button>
                    <div class="flex items-center gap-1.5">
                    @foreach(['Settings','Humanize','Audio'] as $i => $label)
                    <div class="flex items-center gap-1.5">
                        <button type="button" @click="goToStep({{ $i + 1 }})"
                                class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition"
                                :class="currentStep === {{ $i + 1 }}
                                    ? 'bg-violet-600 text-white'
                                    : (currentStep > {{ $i + 1 }} ? 'bg-violet-100 text-violet-700' : 'bg-gray-100 text-gray-500')">
                            <span class="w-5 h-5 rounded-full flex items-center justify-center text-xs font-bold"
                                  :class="currentStep > {{ $i + 1 }} ? 'bg-violet-600 text-white' : ''">
                                <template x-if="currentStep > {{ $i + 1 }}">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                                </template>
                                <template x-if="currentStep <= {{ $i + 1 }}">
                                    <span>{{ $i + 1 }}</span>
                                </template>
                            </span>
                            <span class="hidden sm:inline">{{ $label }}</span>
                        </button>
                        @if($i < 2)
                        <div class="w-6 h-0.5 rounded-full" :class="currentStep > {{ $i + 1 }} ? 'bg-violet-400' : 'bg-gray-200'"></div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto px-8 py-10">

            {{-- ════════════════════════════════════════════════════════════ --}}
            {{-- STEP 1 — Settings & Raw Transcript                          --}}
            {{-- ════════════════════════════════════════════════════════════ --}}
            <div x-show="currentStep === 1" class="space-y-6">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 space-y-6">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <span class="w-7 h-7 bg-violet-600 text-white rounded-full flex items-center justify-center text-sm font-bold">1</span>
                        Material Settings
                    </h2>

                    <div class="grid grid-cols-2 gap-5">
                        <div class="col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Title <span class="text-red-500">*</span></label>
                            <input type="text" x-model="form.title" placeholder="e.g. Lecture on Climate Change"
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent">
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Target Class <span class="text-red-500">*</span></label>
                            <select x-model="form.classType" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-violet-500">
                                <option value="ielts">IELTS</option>
                                <option value="toefl">TOEFL</option>
                                <option value="pteacademic">PTE Academic</option>
                                <option value="regularclass">Regular Class</option>
                            </select>
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Level <span class="text-red-500">*</span></label>
                            <select x-model="form.level" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-violet-500">
                                @foreach($levels as $l)
                                <option>{{ $l }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Topic / Theme</label>
                            <input type="text" x-model="form.topic" placeholder="e.g. Environment, Technology…"
                                   class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Accent</label>
                            <select x-model="form.accent" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-violet-500">
                                @foreach($accents as $a)
                                <option>{{ $a }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">TTS Engine</label>
                            <select x-model="form.engine" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-violet-500">
                                @foreach($engines as $eng)
                                <option>{{ $eng }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-2 sm:col-span-1">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Voice Mode</label>
                            <select x-model="form.voice" class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-violet-500">
                                @foreach($voices as $v)
                                <option>{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
<!-- Background Sound Settings moved to Audio Generation Step -->
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                            Raw Transcript <span class="text-red-500">*</span>
                            <span class="ml-2 text-xs font-normal text-gray-400">Paste your rough notes or draft script here.</span>
                        </label>
                        <textarea x-model="form.rawTranscript" rows="10"
                                  placeholder="Paste your raw transcript here. For dialogue, you can write:&#10;Speaker A: ...&#10;Speaker B: ...&#10;&#10;Or just write a paragraph for a monologue."
                                  class="w-full px-4 py-3 border border-gray-200 rounded-xl text-sm font-mono focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent resize-y"></textarea>
                        <div class="flex justify-between mt-1.5">
                            <span class="text-xs text-gray-400" x-text="form.rawTranscript.length + ' characters'"></span>
                            <span class="text-xs text-gray-400">~<span x-text="Math.ceil(form.rawTranscript.split(/\s+/).filter(Boolean).length / 130)"></span> min read</span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="button" @click="validateStep1()"
                            class="px-8 py-3 bg-violet-600 hover:bg-violet-700 text-white font-semibold rounded-xl transition shadow-sm">
                        Next: Humanize Script →
                    </button>
                </div>
            </div>

            {{-- ════════════════════════════════════════════════════════════ --}}
            {{-- STEP 2 — Humanize                                           --}}
            {{-- ════════════════════════════════════════════════════════════ --}}
            <div x-show="currentStep === 2" class="space-y-6">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 space-y-5">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                            <span class="w-7 h-7 bg-violet-600 text-white rounded-full flex items-center justify-center text-sm font-bold">2</span>
                            ✨ Humanize Transcript
                        </h2>
                        <button type="button" @click="runHumanize()"
                                :disabled="humanizeLoading"
                                class="inline-flex items-center gap-2 px-5 py-2.5 bg-violet-600 hover:bg-violet-700 disabled:opacity-60 text-white text-sm font-semibold rounded-xl transition">
                            <svg x-show="humanizeLoading" class="w-4 h-4 spinner" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            <svg x-show="!humanizeLoading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span x-text="humanizeLoading ? 'Humanizing…' : (form.humanizedTranscript ? 'Re-Humanize' : 'Humanize with AI')"></span>
                        </button>
                    </div>

                    {{-- Custom Prompt --}}
                    <div class="rounded-xl border border-violet-200 bg-violet-50/50 p-4 space-y-2">
                        <label class="flex items-center gap-1.5 text-sm font-semibold text-violet-800">
                            <svg class="w-4 h-4 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Custom Prompt <span class="text-xs font-normal text-violet-500">(optional)</span>
                        </label>
                        <textarea x-model="form.customPrompt" rows="2"
                                  placeholder="e.g. Make the dialogue more academic. Use British slang. Add a third speaker named [Interviewer]."
                                  class="w-full px-3 py-2.5 border border-violet-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-violet-400 bg-white resize-none text-gray-700 placeholder-gray-400"></textarea>
                        <p class="text-xs text-violet-500">Tambahkan instruksi khusus ke AI sebelum humanize. Kosongkan jika tidak perlu.</p>
                    </div>

                    <p class="text-sm text-gray-500">
                        The AI will rewrite your raw transcript into a natural, exam-quality listening script with native fillers, contractions, and proper speaker flow.
                    </p>

                    {{-- Error --}}
                    <div x-show="humanizeError" class="p-4 bg-red-50 border border-red-200 rounded-xl text-red-700 text-sm" x-text="humanizeError"></div>

                    {{-- Before / After --}}
                    <div class="grid grid-cols-2 gap-4" x-show="form.humanizedTranscript">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wide mb-2">Original</p>
                            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-sm text-gray-600 font-mono whitespace-pre-wrap max-h-64 overflow-y-auto" x-text="form.rawTranscript"></div>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-violet-600 uppercase tracking-wide mb-2">✨ Humanized</p>
                            <div class="bg-violet-50 border border-violet-200 rounded-xl p-4 text-sm text-gray-800 font-mono whitespace-pre-wrap max-h-64 overflow-y-auto" x-text="form.humanizedTranscript"></div>
                        </div>
                    </div>

                    {{-- Empty state --}}
                    <div x-show="!form.humanizedTranscript && !humanizeLoading" class="flex flex-col items-center py-12 text-gray-400">
                        <svg class="w-12 h-12 mb-3 text-violet-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        <p class="text-sm">Click "Humanize with AI" to rewrite your transcript</p>
                    </div>

                    {{-- Loading skeleton --}}
                    <div x-show="humanizeLoading" class="space-y-3 animate-pulse">
                        <div class="h-4 bg-violet-100 rounded w-3/4"></div>
                        <div class="h-4 bg-violet-100 rounded w-full"></div>
                        <div class="h-4 bg-violet-100 rounded w-5/6"></div>
                        <div class="h-4 bg-violet-100 rounded w-4/5"></div>
                    </div>
                </div>

                <div class="flex justify-between">
                    <button type="button" @click="currentStep = 1" class="px-6 py-3 text-gray-600 hover:text-gray-900 font-semibold transition">← Back</button>
                    <button type="button" @click="validateStep2()"
                            :disabled="!form.humanizedTranscript"
                            class="px-8 py-3 bg-violet-600 hover:bg-violet-700 disabled:opacity-50 text-white font-semibold rounded-xl transition shadow-sm">
                        Next: Voice & Audio →
                    </button>
                </div>
            </div>

            {{-- ════════════════════════════════════════════════════════════ --}}
            {{-- STEP 3 — Audio Generation                                   --}}
            {{-- ════════════════════════════════════════════════════════════ --}}
            <div x-show="currentStep === 3" class="space-y-6">
                <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 space-y-6">
                    <h2 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <span class="w-7 h-7 bg-violet-600 text-white rounded-full flex items-center justify-center text-sm font-bold">3</span>
                        Voice Assignment & Audio Generation
                    </h2>

                    {{-- Speaker voice assignment --}}
                    <div>
                        <p class="text-sm font-semibold text-gray-700 mb-3" x-text="'Assign ' + form.engine + ' Voice to Each Speaker'"></p>
                        <div class="space-y-3">
                            <template x-for="(spk, idx) in speakers" :key="idx">
                                <div class="flex items-center gap-4 p-4 border border-gray-200 rounded-xl speaker-card hover:border-violet-300">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-violet-400 to-purple-600 flex items-center justify-center text-white font-bold text-sm flex-shrink-0" x-text="spk.tag.slice(-1)"></div>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-gray-800" x-text="spk.tag"></p>
                                        <p class="text-xs text-gray-400">Detected from humanized script</p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <select x-model="spk.voice_id" class="py-2 px-3 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-violet-500">
                                            <optgroup label="Kokoro Voices" x-show="form.engine === 'Kokoro'">
                                                @foreach($kokoroVoices as $id => $label)
                                                <option value="{{ $id }}">{{ $label }}</option>
                                                @endforeach
                                            </optgroup>
                                            <optgroup label="F5-TTS Voices" x-show="form.engine === 'F5-TTS'">
                                                @foreach($f5Voices as $id => $label)
                                                <option value="{{ $id }}">{{ $label }}</option>
                                                @endforeach
                                            </optgroup>
                                            <optgroup label="XTTS Voices" x-show="form.engine === 'XTTS'">
                                                @foreach($xttsVoices as $id => $label)
                                                <option value="{{ $id }}">{{ $label }}</option>
                                                @endforeach
                                            </optgroup>
                                            <optgroup label="ChatTTS Seeds" x-show="form.engine === 'ChatTTS'">
                                                @foreach($chatttsSeeds as $id => $label)
                                                <option value="{{ $id }}">{{ $label }}</option>
                                                @endforeach
                                            </optgroup>
                                        </select>
                                        <button type="button"
                                                @click="playSample(form.engine, spk.voice_id)"
                                                class="p-2 transition rounded-full"
                                                :class="playingVoice === form.engine + spk.voice_id ? 'text-red-600 bg-red-50 hover:bg-red-100' : 'text-violet-600 hover:bg-violet-100'"
                                                title="Listen to Voice Sample">
                                            <template x-if="playingVoice !== form.engine + spk.voice_id">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </template>
                                            <template x-if="playingVoice === form.engine + spk.voice_id">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                    <rect x="9" y="9" width="6" height="6" fill="currentColor" rx="1"></rect>
                                                </svg>
                                            </template>
                                        </button>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Transcript Editor --}}
                    <div>
                        <div class="flex items-center justify-between mb-2">
                            <div>
                                <label class="text-sm font-semibold text-gray-700">Transcript Editor</label>
                                <span class="text-xs text-gray-400 block sm:inline sm:ml-2">Anda dapat mengedit teks ini untuk mengatur jeda.</span>
                            </div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <button type="button" @click="insertPause(30)" class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded border border-gray-200 transition whitespace-nowrap">
                                    + Jeda 30 Detik
                                </button>
                                <button type="button" @click="insertPause(60)" class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-semibold rounded border border-gray-200 transition whitespace-nowrap">
                                    + Jeda 60 Detik
                                </button>
                                <div class="flex items-center gap-1 border border-gray-200 rounded p-1 bg-gray-50">
                                    <input type="number" x-model="customPauseValue" class="w-16 px-1 py-0.5 text-xs border border-gray-300 rounded focus:outline-none focus:border-violet-500 text-center" min="1" placeholder="Val">
                                    <select x-model="customPauseUnit" class="text-xs bg-white border border-gray-300 rounded py-0.5 px-1 focus:outline-none focus:border-violet-500">
                                        <option value="seconds">Detik</option>
                                        <option value="minutes">Menit</option>
                                    </select>
                                    <button type="button" @click="insertCustomPause()" class="px-2 py-0.5 bg-violet-100 hover:bg-violet-200 text-violet-700 text-xs font-semibold rounded transition whitespace-nowrap">
                                        + Tambah
                                    </button>
                                </div>
                            </div>
                        </div>
                        <textarea id="transcript-editor" x-model="form.humanizedTranscript" rows="10"
                                  class="w-full bg-white border border-gray-200 rounded-xl p-4 text-sm text-gray-700 font-mono focus:outline-none focus:ring-2 focus:ring-violet-500 resize-y"></textarea>
                    </div>

                    {{-- ══════════════════════════════════════════════════════ --}}
                    {{-- 3-STEP AUDIO GENERATION                               --}}
                    {{-- ══════════════════════════════════════════════════════ --}}

                    {{-- STEP 1: Generate Speech --}}
                    <div class="space-y-3">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center justify-center w-7 h-7 rounded-full text-xs font-bold"
                                 :class="speechDone ? 'bg-emerald-500 text-white' : 'bg-gray-200 text-gray-600'">
                                <svg x-show="speechDone" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span x-show="!speechDone">1</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-700">Generate Speech (Kokoro TTS)</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <button type="button" @click="runGenerateSpeech()"
                                    :disabled="speechLoading"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 disabled:opacity-60 text-white text-sm font-semibold rounded-xl transition shadow-sm">
                                <svg x-show="speechLoading" class="w-4 h-4 spinner" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                <svg x-show="!speechLoading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"/></svg>
                                <span x-text="speechLoading ? 'Generating speech…' : (speechDone ? 'Re-Generate Speech' : 'Generate Speech')"></span>
                            </button>
                            <span x-show="speechLoading" class="text-xs text-gray-500 animate-pulse">Kokoro TTS is synthesizing…</span>
                            <span x-show="speechDone && !speechLoading" class="text-xs text-emerald-600 font-medium">✓ Speech ready</span>
                        </div>
                        <div x-show="speechError" class="p-3 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm" x-text="speechError"></div>
                        <div x-show="speechUrl && !finalAudioUrl" class="p-4 bg-gray-50 border border-gray-200 rounded-xl">
                            <p class="text-xs text-gray-500 mb-2">Preview Speech (without background):</p>
                            <audio controls class="w-full h-9" :src="speechUrl"></audio>
                        </div>
                    </div>

                                        {{-- Background Sound Settings --}}
                    <div class="space-y-3 pt-4 border-t border-gray-100">
                        <div class="col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                                Background Sound
                                <span class="ml-2 text-xs font-normal text-gray-400">(overlaid at -20dB)</span>
                            </label>
                            <div class="flex flex-wrap gap-2">
                                @php $bgOptions = ['none','cafe','airport','library','office','classroom','street','custom_upload','ai_generated']; @endphp
                                @foreach($bgOptions as $bg)
                                <button type="button" @click="form.background = '{{ $bg }}'"
                                        :class="form.background === '{{ $bg }}' ? 'bg-violet-600 text-white border-violet-600' : 'bg-white text-gray-700 border-gray-200 hover:border-violet-400'"
                                        class="px-4 py-2 border rounded-xl text-sm font-medium transition capitalize">
                                    {{ $bg === 'none' ? '🔇 None' : match($bg) {
                                        'cafe' => '☕ Cafe',
                                        'airport' => '✈️ Airport',
                                        'library' => '📚 Library',
                                        'office' => '💼 Office',
                                        'classroom' => '🏫 Classroom',
                                        'street' => '🏙️ Street',
                                        'custom_upload' => '📁 Upload Sendiri',
                                        'ai_generated' => '🤖 AI Generated',
                                        default => ucfirst($bg)
                                    } }}
                                </button>
                                @endforeach
                            </div>

                            <div x-show="form.background === 'ai_generated'" class="mt-4 p-4 border border-violet-200 bg-violet-50 rounded-xl space-y-3">
                                <div>
                                    <label class="block text-sm font-semibold text-violet-800 mb-1">Atmosphere Prompt</label>
                                    <input type="text" x-model="form.sfxPrompt" placeholder="e.g. busy cafe with people talking and cups clinking" class="w-full px-3 py-2 border border-violet-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-violet-500">
                                    <p class="text-xs text-violet-600 mt-1">AudioGen is running locally on this Mac. First generation might take ~30 seconds.</p>
                                </div>
                                <div class="flex items-center gap-4 mt-3">
                                    <label class="text-sm font-semibold text-violet-800 whitespace-nowrap">Durasi Looping Audio:</label>
                                    <select x-model.number="form.sfxDuration" class="px-3 py-2 border border-violet-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-violet-500 bg-white">
                                        <option value="5">5 Detik</option>
                                        <option value="10">10 Detik</option>
                                        <option value="15">15 Detik</option>
                                        <option value="20">20 Detik</option>
                                        <option value="30">30 Detik</option>
                                    </select>
                                    <span class="text-xs text-violet-600">Durasi lebih panjang = jeda looping lebih natural, tapi proses lebih lama.</span>
                                </div>
                            </div>
                            <div x-show="form.background === 'custom_upload'" class="mt-4 p-4 border border-violet-200 bg-violet-50 rounded-xl space-y-3">
                                <div>
                                    <label class="block text-sm font-semibold text-violet-800 mb-1">Upload File Background (MP3/WAV)</label>
                                    <input type="file" accept="audio/*" @change="uploadCustomSfx($event)" class="w-full px-3 py-2 border border-violet-200 bg-white rounded-lg text-sm">
                                    <p class="text-xs text-violet-600 mt-1" x-text="sfxLoading ? 'Mengupload...' : (sfxDone ? 'File berhasil diupload!' : 'Pilih file audio dari komputer Anda.')"></p>
                                </div>
                            </div>


                        <div x-show="form.background !== 'none'" class="mt-4 p-4 border border-violet-200 bg-violet-50 rounded-xl space-y-3">
                            <label class="block text-sm font-semibold text-violet-800 mb-1">Volume Background (dB)</label>
                            <div class="flex items-center gap-4">
                                <input type="range" min="-40" max="0" step="1" x-model.number="sfxVolume" class="w-full h-2 bg-violet-200 rounded-lg appearance-none cursor-pointer accent-violet-600">
                                <span class="text-sm font-mono text-violet-800 font-bold w-12" x-text="sfxVolume + ' dB'"></span>
                            </div>
                            <p class="text-xs text-violet-600 mt-1">Gunakan volume minus (contoh: -15 dB) agar suara latar tidak terlalu keras.</p>
                        </div>
                        </div>
                    </div>

                    {{-- STEP 2: Generate Background SFX (only if ai_generated) --}}
                    <div x-show="form.background === 'ai_generated'" class="space-y-3 pt-2 border-t border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center justify-center w-7 h-7 rounded-full text-xs font-bold"
                                 :class="sfxDone ? 'bg-violet-500 text-white' : 'bg-gray-200 text-gray-600'">
                                <svg x-show="sfxDone" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span x-show="!sfxDone">2</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-700">Generate Background Sound (AudioGen AI)</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <button type="button" @click="runGenerateSfx()"
                                    :disabled="sfxLoading || !speechDone"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-violet-600 hover:bg-violet-700 disabled:opacity-50 text-white text-sm font-semibold rounded-xl transition shadow-sm">
                                <svg x-show="sfxLoading" class="w-4 h-4 spinner" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                <svg x-show="!sfxLoading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/></svg>
                                <span x-text="sfxLoading ? 'Generating background… (30-90s)' : (sfxDone ? 'Re-Generate Background' : 'Generate Background Sound')"></span>
                            </button>
                            <span x-show="!speechDone && !sfxLoading" class="text-xs text-gray-400">Generate speech first</span>
                            <span x-show="sfxLoading" class="text-xs text-violet-500 animate-pulse">AudioGen is composing…</span>
                            <span x-show="sfxDone && !sfxLoading" class="text-xs text-violet-600 font-medium">✓ Background ready</span>
                        </div>
                        <div x-show="sfxError" class="p-3 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm" x-text="sfxError"></div>
                        
                        <!-- Preview SFX Audio -->
                        <div x-show="sfxUrl && sfxDone" class="mt-4 p-4 bg-gray-50 rounded-xl border border-gray-100">
                            <label class="block text-xs font-semibold text-gray-500 mb-2">Preview Background Sound:</label>
                            <audio :src="sfxUrl" controls class="w-full h-10 outline-none"></audio>
                        </div>
                    </div>

                    {{-- STEP 3: Compile & Mix --}}
                    <div x-show="speechDone && (['ai_generated', 'custom_upload'].includes(form.background) ? sfxDone : true)" class="space-y-3 pt-2 border-t border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="flex items-center justify-center w-7 h-7 rounded-full text-xs font-bold"
                                 :class="finalAudioUrl ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-600'">
                                <svg x-show="finalAudioUrl" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                <span x-show="!finalAudioUrl" x-text="form.background === 'ai_generated' ? '3' : '2'"></span>
                            </div>
                            <span class="text-sm font-semibold text-gray-700" x-text="form.background === 'ai_generated' ? 'Compile & Mix Audio' : 'Finalize Audio'"></span>
                        </div>

                        <div class="flex items-center gap-3">
                            <button type="button" @click="runCompileAudio()"
                                    :disabled="compileLoading"
                                    class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 disabled:opacity-60 text-white text-sm font-semibold rounded-xl transition shadow-sm">
                                <svg x-show="compileLoading" class="w-4 h-4 spinner" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                <svg x-show="!compileLoading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span x-text="compileLoading ? 'Compiling…' : (finalAudioUrl ? 'Re-Compile' : (form.background === 'ai_generated' ? 'Compile & Mix' : 'Finalize' ))"></span>
                            </button>
                            <span x-show="compileLoading" class="text-xs text-blue-500 animate-pulse">Mixing audio layers…</span>
                        </div>
                        <div x-show="compileError" class="p-3 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm" x-text="compileError"></div>
                    </div>

                    {{-- FINAL Audio Player --}}
                    <div x-show="finalAudioUrl" class="p-5 bg-gradient-to-r from-violet-50 to-purple-50 border border-violet-200 rounded-xl space-y-3">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                            </svg>
                            <span class="text-sm font-semibold text-violet-800">Audio Generated Successfully!</span>
                            <span class="ml-auto text-xs text-violet-600 font-mono" x-text="form.duration ? Math.floor(form.duration/60) + ':' + String(form.duration%60).padStart(2,'0') : ''"></span>
                        </div>
                        <audio controls class="w-full" style="accent-color:#7c3aed;" :src="finalAudioUrl"></audio>
                        <div class="flex justify-between items-center mt-3">
                            <span x-show="exportMessage" class="text-sm font-semibold" :class="exportMessage.includes('berhasil') ? 'text-green-600' : 'text-red-600'" x-text="exportMessage"></span>
                            <button type="button" @click="exportAudio()" :disabled="isExporting" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-violet-300 text-violet-700 hover:bg-violet-50 disabled:opacity-60 text-sm font-semibold rounded-lg transition shadow-sm">
                                <svg x-show="isExporting" class="w-4 h-4 spinner" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                <svg x-show="!isExporting" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                <span x-text="isExporting ? 'Menyalin...' : 'Simpan ke Folder Project'"></span>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- ── Final Save Form ── --}}
                <form :action="'{{ route('admin.listening-machine.store') }}'" method="POST" @submit="prepareFormSubmit($event)">
                    @csrf
                    <input type="hidden" name="title"                x-model="form.title">
                    <input type="hidden" name="engine"               x-model="form.engine">
                    <input type="hidden" name="level"                x-model="form.level">
                    <input type="hidden" name="topic"                x-model="form.topic">
                    <input type="hidden" name="accent"               x-model="form.accent">
                    <input type="hidden" name="voice"                x-model="form.voice">
                    <input type="hidden" name="background_sound"     x-model="form.background">
                    <input type="hidden" name="transcript"           x-model="form.rawTranscript">
                    <input type="hidden" name="humanized_transcript" x-model="form.humanizedTranscript">
                    <input type="hidden" name="audio_path"           x-model="form.audioPath">
                    <input type="hidden" name="duration"             x-model="form.duration">
                    <div id="questions-hidden-inputs"></div>

                    <div class="flex justify-between items-center mt-6">
                        <button type="button" @click="currentStep = 2" class="px-6 py-3 text-gray-600 hover:text-gray-900 font-semibold transition">← Back</button>
                        <button type="submit"
                                class="px-10 py-3 bg-violet-700 hover:bg-violet-800 text-white font-bold rounded-xl transition shadow-md text-base">
                            💾 Save Listening Bank
                        </button>
                    </div>
                </form>
            </div>

        </div>{{-- /max-w --}}
    </main>
</div>

<script>
function listeningWizard() {
    return {
        currentStep: 1,

        form: {
            title: '',
            classType: 'ielts',
            engine: 'Kokoro',
            level: '{{ $levels[2] }}',
            topic: '',
            accent: 'UK',
            voice: '{{ $voices[2] }}',
            background: 'none',
            sfxPrompt: '',
            sfxDuration: 10,
            rawTranscript: '',
            customPrompt: '',
            humanizedTranscript: '',
            audioUrl: '',
            audioPath: '',
            duration: null,
        },

        speakers: [{ tag: 'Speaker A', voice_id: 'bf_emma' }],

        qConfig: { type: 'multiple_choice', count: 5 },
        questions: [],

        humanizeLoading: false,
        humanizeError: '',

        // ── Step state ───────────────────────────────────────────────────
        currentJobId: null,

        speechLoading: false,
        speechError:   '',
        speechDone:    false,
        speechUrl:     null,

        sfxLoading: false,
        sfxError:   '',
        sfxDone:    false,
        sfxUrl:     null,
        sfxVolume:  -15,

        compileLoading: false,
        compileError:   '',
        finalAudioUrl:  null,

        audioPreview: null,
        playingVoice: null,
        isExporting: false,
        exportMessage: '',
        
        customPauseValue: 5,
        customPauseUnit: 'seconds',

        questionsLoading: false,
        questionsError: '',

        // ── Init & Autosave ────────────────────────────────────────────────
        isNewSession: false,

        init() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('new')) {
                // Mark as new session — skip loading old draft, but DON'T delete it yet.
                // It will only be overwritten once the user starts filling meaningful data.
                this.isNewSession = true;
                const newUrl = window.location.protocol + "//" + window.location.host + window.location.pathname;
                window.history.replaceState({path: newUrl}, '', newUrl);
            } else {
                const draft = localStorage.getItem('listening_wizard_draft');
                if (draft) {
                    try {
                        const parsed = JSON.parse(draft);
                        if (parsed.currentStep) this.currentStep = parsed.currentStep;
                        if (parsed.form) this.form = { ...this.form, ...parsed.form };
                        if (parsed.speakers) this.speakers = parsed.speakers;
                        if (parsed.qConfig) this.qConfig = { ...this.qConfig, ...parsed.qConfig };
                        if (parsed.questions) this.questions = parsed.questions;
                    } catch(e) {}
                }
            }

            // Autosave watches
            this.$watch('form', () => this.saveDraft(), { deep: true });
            this.$watch('speakers', () => this.saveDraft(), { deep: true });
            this.$watch('questions', () => this.saveDraft(), { deep: true });
            this.$watch('qConfig', () => this.saveDraft(), { deep: true });
            this.$watch('currentStep', () => this.saveDraft());
        },

        saveDraft() {
            // If this is a new session (opened via "Create New Material"),
            // only start saving once the user has actually typed something meaningful.
            // This prevents overwriting the old draft if the user just opens and goes back.
            if (this.isNewSession) {
                const hasMeaningfulData = this.form.title.trim().length > 0
                    || this.form.rawTranscript.trim().length > 10;
                if (!hasMeaningfulData) return;
                // User has started typing — transition to normal save mode
                this.isNewSession = false;
            }
            const draft = {
                currentStep: this.currentStep,
                form: this.form,
                speakers: this.speakers,
                qConfig: this.qConfig,
                questions: this.questions,
            };
            localStorage.setItem('listening_wizard_draft', JSON.stringify(draft));
        },

        clearDraft() {
            if (confirm('Are you sure you want to clear your current progress?')) {
                localStorage.removeItem('listening_wizard_draft');
                window.location.reload();
            }
        },

        // ── Navigation ──────────────────────────────────────────────────────
        goToStep(n) {
            if (n < this.currentStep) this.currentStep = n;
        },

        // ── Step 1 Validation ────────────────────────────────────────────────
        validateStep1() {
            if (!this.form.title.trim()) { alert('Please enter a title.'); return; }
            if (!this.form.rawTranscript.trim() || this.form.rawTranscript.length < 50) {
                alert('Transcript must be at least 50 characters.'); return;
            }
            this.currentStep = 2;
        },

        // ── Step 2 Validation ────────────────────────────────────────────────
        validateStep2() {
            if (!this.form.humanizedTranscript) { alert('Please humanize the transcript first.'); return; }
            this.currentStep = 3;
        },

        // ── AJAX: Humanize ────────────────────────────────────────────────────
        async runHumanize() {
            this.humanizeLoading = true;
            this.humanizeError   = '';

            try {
                const res = await fetch('{{ route('admin.listening-machine.humanize') }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        transcript: this.form.rawTranscript,
                        voice_mode: this.form.voice,
                        level: this.form.level,
                        accent: this.form.accent,
                        custom_prompt: this.form.customPrompt,
                    }),
                });
                const textData = await res.text();
                let data;
                try {
                    data = JSON.parse(textData);
                } catch(e) {
                    throw new Error('Server mengembalikan error non-JSON (mungkin timeout atau 500 HTML).');
                }
                
                if (!res.ok || data.error) throw new Error(data.error || 'Unknown error');

                this.form.humanizedTranscript = data.humanized;

                // Rebuild speakers from detected tags
                if (data.is_dialogue && data.speaker_tags && data.speaker_tags.length > 1) {
                    let voicePool = ['bf_emma', 'bm_george', 'af_sarah', 'am_adam'];
                    const voicePref = this.form.voice.toLowerCase();
                    const isF5 = this.form.engine === 'F5-TTS';
                    const isXTTS = this.form.engine === 'XTTS';
                    const isChatTTS = this.form.engine === 'ChatTTS';

                    if (isF5) voicePool = ['f5_female_1', 'f5_male_1', 'f5_female_2', 'f5_male_2'];
                    else if (isXTTS) voicePool = ['Claribel Dervla', 'Craig Goya', 'Daisy Studious', 'Damien Black'];
                    else if (isChatTTS) voicePool = ['seed_100', 'seed_300', 'seed_200', 'seed_400'];

                    if (voicePref.includes('male + male')) {
                        if (isF5) voicePool = ['f5_male_1', 'f5_male_2'];
                        else if (isXTTS) voicePool = ['Craig Goya', 'Damien Black'];
                        else if (isChatTTS) voicePool = ['seed_300', 'seed_400'];
                        else voicePool = ['bm_george', 'am_adam', 'bm_lewis', 'am_michael'];
                    } else if (voicePref.includes('female + female')) {
                        if (isF5) voicePool = ['f5_female_1', 'f5_female_2'];
                        else if (isXTTS) voicePool = ['Claribel Dervla', 'Daisy Studious'];
                        else if (isChatTTS) voicePool = ['seed_100', 'seed_200'];
                        else voicePool = ['bf_emma', 'af_sarah', 'bf_isabella', 'af_bella'];
                    }

                    this.speakers = data.speaker_tags.map((tag, i) => ({
                        tag: tag.replace(/\s*:\s*$/, '').replace(/^\[/, '').replace(/\]$/, ''),
                        voice_id: voicePool[i % voicePool.length],
                    }));
                } else {
                    const isMale = this.form.voice.toLowerCase().includes('male') && !this.form.voice.toLowerCase().includes('female');
                    const isF5 = this.form.engine === 'F5-TTS';
                    const isXTTS = this.form.engine === 'XTTS';
                    const isChatTTS = this.form.engine === 'ChatTTS';
                    let defVoice = isMale ? 'bm_george' : 'bf_emma';
                    if (isF5) defVoice = isMale ? 'f5_male_1' : 'f5_female_1';
                    else if (isXTTS) defVoice = isMale ? 'Craig Goya' : 'Claribel Dervla';
                    else if (isChatTTS) defVoice = isMale ? 'seed_300' : 'seed_100';

                    this.speakers = [{ tag: 'Speaker A', voice_id: defVoice }];
                }
            } catch(e) {
                this.humanizeError = e.message;
            } finally {
                this.humanizeLoading = false;
            }
        },

        // ── Shared: poll Python job status until done/error ─────────────────
        pollJob(jobId, step, onDone, onError, statusMsg) {
            // Poll via Laravel proxy to avoid CORS (browser → Laravel → Python)
            const POLL_URL = '{{ route('admin.listening-machine.job-status', '__JOB_ID__') }}';
            const MAX = 600; // 30 minutes max (600 × 3s) untuk AudioGen CPU yang lambat
            let tries = 0;
            const tick = async () => {
                if (tries++ > MAX) {
                    onError('Timeout: proses terlalu lama. Coba lagi.');
                    return;
                }
                try {
                    const url = POLL_URL.replace('__JOB_ID__', jobId);
                    const r = await fetch(url);
                    const d = await r.json();
                    if (d.status === 'done' && d.step === step) {
                        onDone(d);
                    } else if (d.status === 'error') {
                        onError(d.error || 'Terjadi error di server Python.');
                    } else {
                        // Still processing — update status message
                        if (statusMsg && d.message) statusMsg(d.message);
                        setTimeout(tick, 3000);
                    }
                } catch(e) {
                    setTimeout(tick, 3000); // retry on network error
                }
            };
            tick();
        },

        // ── AJAX: Step 1 — Generate Speech (Kokoro) ─────────────────────────
        async runGenerateSpeech() {
            if (!this.form.humanizedTranscript.trim()) {
                this.speechError = 'Transcript masih kosong. Lakukan Humanize terlebih dahulu.';
                return;
            }
            this.speechLoading  = true;
            this.speechError    = '';
            this.speechDone     = false;
            this.sfxDone        = false;
            this.finalAudioUrl  = null;
            this.currentJobId   = crypto.randomUUID();

            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            try {
                const res = await fetch('{{ route('admin.listening-machine.generate-audio') }}', {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({
                        file_id:              this.currentJobId,
                        humanized_transcript: this.form.humanizedTranscript,
                        speakers:             this.speakers,
                        engine:               this.form.engine,
                    }),
                });

                const text = await res.text();
                let data;
                try { data = JSON.parse(text); } catch(e) {
                    throw new Error('Server error: ' + text.substring(0, 100));
                }
                if (!res.ok || data.error) throw new Error(data.error || 'Request failed');

                // Job accepted — now poll Python directly for completion
                this.pollJob(
                    this.currentJobId,
                    'speech',
                    (d) => {
                        // Done
                        this.speechUrl    = `/storage/listening-banks/${this.currentJobId}_speech.mp3`;
                        this.speechDone   = true;
                        this.speechLoading= false;
                        this.speechError  = '';
                        // Auto-compile if no background needed
                        if (this.form.background !== 'ai_generated' && this.form.background !== 'custom_upload') {
                            this.runCompileAudio();
                        }
                    },
                    (err) => { this.speechError = err; this.speechLoading = false; },
                    (msg) => { /* optional: show progress msg */ }
                );
            } catch(e) {
                this.speechError  = e.message || 'Gagal memulai generate speech.';
                this.speechLoading = false;
            }
        },

        // ── AJAX: Step 2 — Generate SFX (AudioGen) ──────────────────────────
        async runGenerateSfx() {
            if (!this.currentJobId) { this.sfxError = 'Generate speech terlebih dahulu.'; return; }
            if (!this.form.sfxPrompt.trim()) { this.sfxError = 'Masukkan deskripsi suara latar (Atmosphere Prompt).'; return; }

            this.sfxLoading    = true;
            this.sfxError      = '';
            this.sfxDone       = false;
            this.sfxUrl        = null;
            this.finalAudioUrl = null;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            try {
                const res = await fetch('{{ route('admin.listening-machine.generate-sfx') }}', {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ file_id: this.currentJobId, sfx_prompt: this.form.sfxPrompt, duration: this.form.sfxDuration }),
                });

                const text = await res.text();
                let data;
                try { data = JSON.parse(text); } catch(e) {
                    throw new Error('Server error: ' + text.substring(0, 100));
                }
                if (!res.ok || data.error) throw new Error(data.error || 'Request failed');

                // Poll Python for SFX completion
                this.pollJob(
                    this.currentJobId,
                    'sfx',
                    (d) => {
                        this.sfxUrl = `/storage/listening-banks/${this.currentJobId}_sfx.wav`;
                        this.sfxDone = true; 
                        this.sfxLoading = false; 
                        this.sfxError = ''; 
                    },
                    (err) => { this.sfxError = err; this.sfxLoading = false; }
                );
            } catch(e) {
                this.sfxError   = e.message || 'Gagal memulai generate background.';
                this.sfxLoading = false;
            }
        },


        async uploadCustomSfx(event) {
            const file = event.target.files[0];
            if (!file) return;
            if (!this.currentJobId) {
                alert('Generate speech terlebih dahulu agar file memiliki ID Job.');
                event.target.value = '';
                return;
            }

            this.sfxLoading = true;
            this.sfxDone = false;
            
            const formData = new FormData();
            formData.append('file_id', this.currentJobId);
            formData.append('audio', file);

            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                const res = await fetch('/api/upload-sfx', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': csrfToken },
                    body: formData
                });
                const data = await res.json();
                
                if (data.success) {
                    this.sfxDone = true;
                } else {
                    alert(data.error || 'Upload failed');
                }
            } catch (err) {
                alert('Upload error: ' + err.message);
            } finally {
                this.sfxLoading = false;
            }
        },

        // ── AJAX: Step 3 — Compile (Mix Speech + SFX) ───────────────────────
        async runCompileAudio() {
            if (!this.currentJobId) { this.compileError = 'Generate speech terlebih dahulu.'; return; }
            this.compileLoading = true;
            this.compileError   = '';
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            try {
                const res = await fetch('{{ route('admin.listening-machine.compile-audio') }}', {
                    method: 'POST',
                    headers: { 'Accept': 'application/json', 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                    body: JSON.stringify({ file_id: this.currentJobId, sfx_volume: this.sfxVolume }),
                });

                const text = await res.text();
                let data;
                try { data = JSON.parse(text); } catch(e) {
                    throw new Error('Server error: ' + text.substring(0, 100));
                }
                if (!res.ok || data.error) throw new Error(data.error || 'Compile request failed');

                // Poll Python for compile completion
                this.pollJob(
                    this.currentJobId,
                    'compile',
                    (d) => {
                        const fileId = this.currentJobId;
                        this.finalAudioUrl   = `/storage/listening-banks/${fileId}.mp3?t=${Date.now()}`;
                        this.form.audioUrl   = this.finalAudioUrl;
                        this.form.audioPath  = `listening-banks/${fileId}.mp3`;
                        this.compileLoading  = false;
                        this.compileError    = '';
                        // Estimate duration from transcript word count
                        if (!this.form.duration) {
                            const words = this.form.humanizedTranscript.split(/\s+/).length;
                            this.form.duration = Math.round(words / 130 * 60);
                        }
                    },
                    (err) => { this.compileError = err; this.compileLoading = false; }
                );
            } catch(e) {
                this.compileError   = e.message || 'Gagal memulai compile.';
                this.compileLoading = false;
            }
        },

        async exportAudio() {
            if (!this.form.audioPath) return;
            this.isExporting = true;
            this.exportMessage = '';
            
            try {
                const res = await fetch('{{ route('admin.listening-machine.export-to-public') }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        audio_path: this.form.audioPath,
                        class_type: this.form.classType,
                        level: this.form.level,
                        title: this.form.title,
                    }),
                });
                const data = await res.json();
                if (!res.ok || data.error) throw new Error(data.error || 'Terjadi kesalahan saat menyalin file');
                this.exportMessage = '✓ ' + data.message;
            } catch (err) {
                this.exportMessage = '✕ ' + err.message;
            } finally {
                this.isExporting = false;
            }
        },

        // ── Insert Pause ──────────────────────────────────────────────────────
        insertCustomPause() {
            let val = parseInt(this.customPauseValue);
            if (isNaN(val) || val <= 0) return;
            if (this.customPauseUnit === 'minutes') {
                val = val * 60;
            }
            this.insertPause(val);
        },
        
        insertPause(seconds) {
            const textarea = document.getElementById('transcript-editor');
            if (textarea) {
                const start = textarea.selectionStart;
                const end = textarea.selectionEnd;
                const text = this.form.humanizedTranscript;
                const pauseText = `\n[PAUSE ${seconds}]\n`;
                this.form.humanizedTranscript = text.substring(0, start) + pauseText + text.substring(end);
                
                // Set cursor position after the inserted text
                setTimeout(() => {
                    textarea.selectionStart = textarea.selectionEnd = start + pauseText.length;
                    textarea.focus();
                }, 10);
            } else {
                this.form.humanizedTranscript += `\n[PAUSE ${seconds}]\n`;
            }
        },

        // ── Preview Voice Sample ──────────────────────────────────────────────
        playSample(engine, voiceId) {
            const currentId = engine + voiceId;
            if (this.playingVoice === currentId && this.audioPreview) {
                this.audioPreview.pause();
                this.audioPreview.currentTime = 0;
                this.playingVoice = null;
                return;
            }

            if (this.audioPreview) {
                this.audioPreview.pause();
            }
            
            const safeEngine = engine.toLowerCase().replace(/[^a-z0-9]/g, '');
            const safeVoice = voiceId.toLowerCase().replace(/[^a-z0-9_]/g, '_');
            const url = `/samples/${safeEngine}/${safeVoice}.mp3?v={{ filemtime(public_path('samples/kokoro/af_heart.mp3')) }}`;
            
            this.audioPreview = new Audio(url);
            this.playingVoice = currentId;
            
            this.audioPreview.onended = () => {
                this.playingVoice = null;
            };

            this.audioPreview.play().catch(e => {
                this.playingVoice = null;
                alert(`Sample audio file not found!\n\nPlease make sure to upload the sample file to your server at:\npublic${url}`);
            });
        },

        // ── AJAX: Generate Questions ──────────────────────────────────────────
        async runGenerateQuestions() {
            this.questionsLoading = true;
            this.questionsError   = '';

            try {
                const res = await fetch('{{ route('admin.listening-machine.generate-questions') }}', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    },
                    body: JSON.stringify({
                        humanized_transcript: this.form.humanizedTranscript,
                        question_type: this.qConfig.type,
                        question_count: this.qConfig.count,
                        level: this.form.level,
                    }),
                });
                const textData = await res.text();
                let data;
                try {
                    data = JSON.parse(textData);
                } catch(e) {
                    throw new Error('Gagal memproses response (bukan JSON).');
                }
                
                if (!res.ok || data.error) throw new Error(data.error || 'Unknown error');

                this.questions = data.questions;
            } catch(e) {
                this.questionsError = e.message;
            } finally {
                this.questionsLoading = false;
            }
        },

        // ── Prepare hidden form inputs before submit ──────────────────────────
        prepareFormSubmit(event) {
            localStorage.removeItem('listening_wizard_draft'); // Clear draft on submit
            const container = document.getElementById('questions-hidden-inputs');
            container.innerHTML = '';
            this.questions.forEach((q, i) => {
                const fields = {
                    [`questions[${i}][type]`]:           q.type || 'multiple_choice',
                    [`questions[${i}][question_text]`]:  q.question_text,
                    [`questions[${i}][correct_answer]`]: q.correct_answer,
                    [`questions[${i}][explanation]`]:    q.explanation || '',
                };
                if (q.options && q.options.length) {
                    q.options.forEach((opt, oi) => {
                        fields[`questions[${i}][options][${oi}]`] = opt;
                    });
                }
                Object.entries(fields).forEach(([name, value]) => {
                    const inp = document.createElement('input');
                    inp.type  = 'hidden';
                    inp.name  = name;
                    inp.value = value ?? '';
                    container.appendChild(inp);
                });
            });
        },
    };
}
</script>
</body>
</html>
