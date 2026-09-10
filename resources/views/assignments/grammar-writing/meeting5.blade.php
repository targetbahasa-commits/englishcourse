<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Meeting 5</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .word-correct { color: #2ecc71; font-weight: bold; }
        .word-extra { color: #3498db; font-weight: bold; text-decoration: line-through; }
        .word-missing { color: #f1c40f; font-weight: bold; }
        .word-wrong { color: #e74c3c; font-weight: bold; text-decoration: underline; }
    </style>
</head>
<body class="font-sans antialiased bg-[#F3F4FF] p-8">
    @include('components.impersonation-banner')
    @include('components.program-sidebar', ['programSidebarAlwaysVisible' => true])
    <div class="w-full max-w-[1920px] mx-auto flex flex-col min-h-screen">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <span class="text-sm font-semibold text-purple-600 tracking-wider uppercase">Fast-track Grammar for Writing</span>
                <h1 class="text-2xl font-bold text-gray-800">Gerund, To Infinitive, and Complex Ditransitive Verb (Pertemuan 5)</h1>
            </div>
            <x-grammar-meeting-actions :meetingNumber="5" track="fast-track" />
        </div>

        @if($submitted)
            <div class="bg-purple-600 text-white p-6 rounded-xl text-center mb-6 shadow-md">
                <h2 class="text-2xl font-bold mb-2">Nilai Kamu: {{ $finalScore }} / 100</h2>
                <p class="text-purple-100">{{ $finalScore >= 80 ? 'Luar biasa!' : 'Terus berlatih!' }}</p>
            </div>
        @endif

        <form method="POST" action="{{ parse_url(route('assignments.grammar-writing.meeting5.submit'), PHP_URL_PATH) }}" id="meetingAnswerForm">
            @csrf

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start pb-8">
                <!-- Left Column: Materi (Sticky) -->
                @if(!empty($cheatSheet['__html__']))
                <div class="lg:col-span-5 sticky top-6 self-start max-h-[calc(100vh-2rem)] overflow-y-auto pr-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 sm:p-6">
                        {!! $cheatSheet['__html__'] !!}
                    </div>
                </div>
                @endif

                <!-- Right Column: Exercise -->
                <div class="{{ !empty($cheatSheet['__html__']) ? 'lg:col-span-7' : 'lg:col-span-12' }} space-y-6">
                    <!-- Section A -->
                    <div class="bg-white rounded-3xl shadow-sm border border-purple-100 overflow-visible">
                        <div class="bg-gradient-to-r from-purple-50 via-violet-50 to-white px-5 py-5 sm:px-8 sm:py-6 border-b border-purple-100">
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-800">A. Gerund, To Infinitive, and Complex Ditransitive Verb</h3>
                        </div>
                        <div class="p-5 sm:p-8 space-y-4 sm:space-y-5">
                            <ol class="space-y-4 sm:space-y-5">
                                @foreach($gerundInfinitiveComplex as $idx => $data)
                                    <li class="group rounded-2xl border border-gray-200 bg-white p-4 sm:p-5 transition hover:shadow-md hover:border-purple-200 space-y-3">
                                        <div class="flex items-start justify-between gap-3 sm:gap-4">
                                            <div class="flex items-start gap-3 sm:gap-4 flex-1">
                                                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center text-sm font-bold shrink-0">
                                                    {{ $idx }}
                                                </div>
                                                <div class="pt-1 flex-1">
                                                    <p class="text-gray-800 leading-relaxed">{{ $data['id'] }}</p>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-1.5 shrink-0 pt-0.5">
                                                @if(!empty($data['example']))
                                                    <div x-data="{ open: false }" class="relative inline-block">
                                                        <button type="button" @click="open = !open" @click.outside="open = false" class="w-6 h-6 rounded-md bg-amber-50 border border-amber-200 text-amber-600 flex items-center justify-center text-xs font-bold hover:bg-amber-100 transition-colors focus:outline-none shadow-sm cursor-pointer" title="Contoh Serupa">
                                                            ?
                                                        </button>
                                                        <div x-show="open" x-transition class="absolute bottom-full right-0 mb-2 w-72 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed" style="display: none;">
                                                            <strong class="block mb-1 text-amber-300 border-b border-gray-600 pb-1">Contoh Serupa:</strong>
                                                            {{ is_array($data['example']) ? ($data['example']['id'] ?? '') : $data['example'] }}<br>
                                                            <em class="text-gray-300">{{ is_array($data['example']) ? ($data['example']['en'] ?? '') : '' }}</em>
                                                            <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if(!empty($data['vocab']))
                                                    <div x-data="{ open: false }" class="relative inline-block">
                                                        <button type="button" @click="open = !open" @click.outside="open = false" class="w-6 h-6 rounded-md bg-green-50 border border-green-200 text-green-600 flex items-center justify-center text-xs font-bold hover:bg-green-100 transition-colors focus:outline-none shadow-sm cursor-pointer" title="Vocabulary Helper">
                                                            v
                                                        </button>
                                                        <div x-show="open" x-transition class="absolute bottom-full right-0 mb-2 w-72 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed" style="display: none;">
                                                            <strong class="block mb-2 text-green-300 border-b border-gray-600 pb-1">Vocabulary Helper:</strong>
                                                            <ul class="space-y-1">
                                                                @foreach($data['vocab'] as $word => $info)
                                                                    <li class="flex justify-between gap-3">
                                                                        <span class="text-green-300 font-mono">{{ $word }} <span class="text-gray-400 text-xs">{{ is_array($info) ? ($info['pos'] ?? '') : '' }}</span></span>
                                                                        <span>{{ is_array($info) ? ($info['id'] ?? '') : $info }}</span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="ml-11 sm:ml-13">
                                            <input type="text"
                                                   name="userAnswers[gerundInfinitiveComplex][{{ $idx }}]"
                                                   value="{{ old('userAnswers.gerundInfinitiveComplex.'.$idx, $userAnswers['gerundInfinitiveComplex'][$idx] ?? '') }}"
                                                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition bg-white hover:border-gray-400 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                                   placeholder="Translate to English..."
                                                   {{ $submitted ? 'readonly' : '' }}
                                                   autocomplete="off">

                                            @if($submitted)
                                                @if($results['gerundInfinitiveComplex'][$idx]['score'] == 100)
                                                    <div class="mt-2 text-sm font-bold text-green-600 bg-green-50 p-2 rounded border border-green-100">
                                                        ✓ Sempurna!
                                                    </div>
                                                @else
                                                    <div class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded border border-red-100">
                                                        <strong>Nilai: {{ $results['gerundInfinitiveComplex'][$idx]['score'] }}</strong><br>
                                                        Koreksi: {!! $results['gerundInfinitiveComplex'][$idx]['formatted_answer'] !!}<br>
                                                        <small class="text-gray-600">Jawaban Benar: {{ $data['en'] }}</small>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>

                    <!-- Section B -->
                    <div class="bg-white rounded-3xl shadow-sm border border-blue-100 overflow-visible">
                        <div class="bg-gradient-to-r from-blue-50 via-sky-50 to-white px-5 py-5 sm:px-8 sm:py-6 border-b border-blue-100">
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-800">B. To Infinitive</h3>
                        </div>
                        <div class="p-5 sm:p-8 space-y-4 sm:space-y-5">
                            <ol class="space-y-4 sm:space-y-5">
                                @foreach($toInfinitive as $idx => $data)
                                    <li class="group rounded-2xl border border-gray-200 bg-white p-4 sm:p-5 transition hover:shadow-md hover:border-blue-200 space-y-3">
                                        <div class="flex items-start justify-between gap-3 sm:gap-4">
                                            <div class="flex items-start gap-3 sm:gap-4 flex-1">
                                                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-blue-100 text-blue-700 flex items-center justify-center text-sm font-bold shrink-0">
                                                    {{ $idx }}
                                                </div>
                                                <div class="pt-1 flex-1">
                                                    <p class="text-gray-800 leading-relaxed">{{ $data['id'] }}</p>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-1.5 shrink-0 pt-0.5">
                                                @if(!empty($data['example']))
                                                    <div x-data="{ open: false }" class="relative inline-block">
                                                        <button type="button" @click="open = !open" @click.outside="open = false" class="w-6 h-6 rounded-md bg-amber-50 border border-amber-200 text-amber-600 flex items-center justify-center text-xs font-bold hover:bg-amber-100 transition-colors focus:outline-none shadow-sm cursor-pointer" title="Contoh Serupa">
                                                            ?
                                                        </button>
                                                        <div x-show="open" x-transition class="absolute bottom-full right-0 mb-2 w-72 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed" style="display: none;">
                                                            <strong class="block mb-1 text-amber-300 border-b border-gray-600 pb-1">Contoh Serupa:</strong>
                                                            {{ is_array($data['example']) ? ($data['example']['id'] ?? '') : $data['example'] }}<br>
                                                            <em class="text-gray-300">{{ is_array($data['example']) ? ($data['example']['en'] ?? '') : '' }}</em>
                                                            <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if(!empty($data['vocab']))
                                                    <div x-data="{ open: false }" class="relative inline-block">
                                                        <button type="button" @click="open = !open" @click.outside="open = false" class="w-6 h-6 rounded-md bg-green-50 border border-green-200 text-green-600 flex items-center justify-center text-xs font-bold hover:bg-green-100 transition-colors focus:outline-none shadow-sm cursor-pointer" title="Vocabulary Helper">
                                                            v
                                                        </button>
                                                        <div x-show="open" x-transition class="absolute bottom-full right-0 mb-2 w-72 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed" style="display: none;">
                                                            <strong class="block mb-2 text-green-300 border-b border-gray-600 pb-1">Vocabulary Helper:</strong>
                                                            <ul class="space-y-1">
                                                                @foreach($data['vocab'] as $word => $info)
                                                                    <li class="flex justify-between gap-3">
                                                                        <span class="text-green-300 font-mono">{{ $word }} <span class="text-gray-400 text-xs">{{ is_array($info) ? ($info['pos'] ?? '') : '' }}</span></span>
                                                                        <span>{{ is_array($info) ? ($info['id'] ?? '') : $info }}</span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="ml-11 sm:ml-13">
                                            <input type="text"
                                                   name="userAnswers[toInfinitive][{{ $idx }}]"
                                                   value="{{ old('userAnswers.toInfinitive.'.$idx, $userAnswers['toInfinitive'][$idx] ?? '') }}"
                                                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition bg-white hover:border-gray-400 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                                   placeholder="Translate to English..."
                                                   {{ $submitted ? 'readonly' : '' }}
                                                   autocomplete="off">

                                            @if($submitted)
                                                @if($results['toInfinitive'][$idx]['score'] == 100)
                                                    <div class="mt-2 text-sm font-bold text-green-600 bg-green-50 p-2 rounded border border-green-100">
                                                        ✓ Sempurna!
                                                    </div>
                                                @else
                                                    <div class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded border border-red-100">
                                                        <strong>Nilai: {{ $results['toInfinitive'][$idx]['score'] }}</strong><br>
                                                        Koreksi: {!! $results['toInfinitive'][$idx]['formatted_answer'] !!}<br>
                                                        <small class="text-gray-600">Jawaban Benar: {{ $data['en'] }}</small>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>

                    <!-- Section C -->
                    <div class="bg-white rounded-3xl shadow-sm border border-green-100 overflow-visible">
                        <div class="bg-gradient-to-r from-green-50 via-emerald-50 to-white px-5 py-5 sm:px-8 sm:py-6 border-b border-green-100">
                            <h3 class="text-xl sm:text-2xl font-bold text-gray-800">C. Gerund</h3>
                        </div>
                        <div class="p-5 sm:p-8 space-y-4 sm:space-y-5">
                            <ol class="space-y-4 sm:space-y-5">
                                @foreach($gerund as $idx => $data)
                                    <li class="group rounded-2xl border border-gray-200 bg-white p-4 sm:p-5 transition hover:shadow-md hover:border-green-200 space-y-3">
                                        <div class="flex items-start justify-between gap-3 sm:gap-4">
                                            <div class="flex items-start gap-3 sm:gap-4 flex-1">
                                                <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-green-100 text-green-700 flex items-center justify-center text-sm font-bold shrink-0">
                                                    {{ $idx }}
                                                </div>
                                                <div class="pt-1 flex-1">
                                                    <p class="text-gray-800 leading-relaxed">{{ $data['id'] }}</p>
                                                </div>
                                            </div>

                                            <div class="flex items-center gap-1.5 shrink-0 pt-0.5">
                                                @if(!empty($data['example']))
                                                    <div x-data="{ open: false }" class="relative inline-block">
                                                        <button type="button" @click="open = !open" @click.outside="open = false" class="w-6 h-6 rounded-md bg-amber-50 border border-amber-200 text-amber-600 flex items-center justify-center text-xs font-bold hover:bg-amber-100 transition-colors focus:outline-none shadow-sm cursor-pointer" title="Contoh Serupa">
                                                            ?
                                                        </button>
                                                        <div x-show="open" x-transition class="absolute bottom-full right-0 mb-2 w-72 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed" style="display: none;">
                                                            <strong class="block mb-1 text-amber-300 border-b border-gray-600 pb-1">Contoh Serupa:</strong>
                                                            {{ is_array($data['example']) ? ($data['example']['id'] ?? '') : $data['example'] }}<br>
                                                            <em class="text-gray-300">{{ is_array($data['example']) ? ($data['example']['en'] ?? '') : '' }}</em>
                                                            <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                        </div>
                                                    </div>
                                                @endif

                                                @if(!empty($data['vocab']))
                                                    <div x-data="{ open: false }" class="relative inline-block">
                                                        <button type="button" @click="open = !open" @click.outside="open = false" class="w-6 h-6 rounded-md bg-green-50 border border-green-200 text-green-600 flex items-center justify-center text-xs font-bold hover:bg-green-100 transition-colors focus:outline-none shadow-sm cursor-pointer" title="Vocabulary Helper">
                                                            v
                                                        </button>
                                                        <div x-show="open" x-transition class="absolute bottom-full right-0 mb-2 w-72 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed" style="display: none;">
                                                            <strong class="block mb-2 text-green-300 border-b border-gray-600 pb-1">Vocabulary Helper:</strong>
                                                            <ul class="space-y-1">
                                                                @foreach($data['vocab'] as $word => $info)
                                                                    <li class="flex justify-between gap-3">
                                                                        <span class="text-green-300 font-mono">{{ $word }} <span class="text-gray-400 text-xs">{{ is_array($info) ? ($info['pos'] ?? '') : '' }}</span></span>
                                                                        <span>{{ is_array($info) ? ($info['id'] ?? '') : $info }}</span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                            <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="ml-11 sm:ml-13">
                                            <input type="text"
                                                   name="userAnswers[gerund][{{ $idx }}]"
                                                   value="{{ old('userAnswers.gerund.'.$idx, $userAnswers['gerund'][$idx] ?? '') }}"
                                                   class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition bg-white hover:border-gray-400 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                                   placeholder="Translate to English..."
                                                   {{ $submitted ? 'readonly' : '' }}
                                                   autocomplete="off">

                                            @if($submitted)
                                                @if($results['gerund'][$idx]['score'] == 100)
                                                    <div class="mt-2 text-sm font-bold text-green-600 bg-green-50 p-2 rounded border border-green-100">
                                                        ✓ Sempurna!
                                                    </div>
                                                @else
                                                    <div class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded border border-red-100">
                                                        <strong>Nilai: {{ $results['gerund'][$idx]['score'] }}</strong><br>
                                                        Koreksi: {!! $results['gerund'][$idx]['formatted_answer'] !!}<br>
                                                        <small class="text-gray-600">Jawaban Benar: {{ $data['en'] }}</small>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ol>
                        </div>
                    </div>

                    <!-- Section D: Paragraph Translation -->
                    @if(isset($paragraph))
                    <div class="bg-white rounded-3xl shadow-sm border border-orange-100 overflow-visible">
                        <div class="bg-gradient-to-r from-orange-50 via-amber-50 to-white px-5 py-5 sm:px-8 sm:py-6 border-b border-orange-100 flex items-center justify-between">
                            <div>
                                <h3 class="text-xl sm:text-2xl font-bold text-gray-800">D. Paragraph Translation</h3>
                                <p class="text-sm text-gray-600 mt-1">Translate paragraf berikut ke dalam bahasa Inggris.</p>
                            </div>
                        </div>
                        <div class="p-5 sm:p-8 space-y-4">
                            <p class="text-gray-700 leading-relaxed">{!! $paragraph['id'] !!}</p>

                            @if(!empty($paragraph['vocab']))
                                <div x-data="{ showVocab: false }">
                                    <button type="button" @click="showVocab = !showVocab" class="w-full px-4 py-3 bg-yellow-50 border border-yellow-200 hover:bg-yellow-100 text-yellow-900 font-bold rounded-xl transition-colors flex items-center justify-between text-sm shadow-2xs">
                                        <span class="flex items-center gap-2"><span>📚</span> Vocabulary Bantuan</span>
                                        <svg :class="showVocab ? 'rotate-180' : ''" class="w-5 h-5 transition-transform text-yellow-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    <div x-show="showVocab" x-transition style="display:none;" class="mt-3 bg-yellow-50 border border-yellow-200 p-4 rounded-xl">
                                        <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                            @foreach($paragraph['vocab'] as $en => $data)
                                                <span class="bg-white px-3 py-1.5 rounded-lg border border-yellow-200 text-xs text-gray-700 shadow-xs">
                                                    <strong class="text-indigo-600">{{ $en }}</strong>:
                                                    @if(is_array($data))
                                                        {{ $data['id'] ?? '' }} <span class="text-gray-400 text-[10px]">{{ $data['pos'] ?? '' }}</span>
                                                    @else
                                                        {{ $data }}
                                                    @endif
                                                </span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Jawaban Anda:</label>
                                <textarea
                                    name="userAnswers[paragraph]"
                                    rows="8"
                                    class="w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-transparent transition bg-white hover:border-gray-400 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                    placeholder="Translate the paragraph to English..."
                                    {{ $submitted ? 'readonly' : '' }}
                                    autocomplete="off">{{ old('userAnswers.paragraph', $userAnswers['paragraph'] ?? '') }}</textarea>

                                @if($submitted && isset($results['paragraph']))
                                    @if($results['paragraph']['score'] == 100)
                                        <div class="mt-2 text-sm font-bold text-green-600 bg-green-50 p-2 rounded border border-green-100">
                                            ✓ Sempurna!
                                        </div>
                                    @else
                                        <div class="mt-2 text-sm text-red-600 bg-red-50 p-2 rounded border border-red-100">
                                            <strong>Nilai: {{ $results['paragraph']['score'] }}</strong><br>
                                            Koreksi: {!! $results['paragraph']['formatted_answer'] !!}<br>
                                            <small class="text-gray-600">Jawaban Benar: {{ $paragraph['en'] }}</small>
                                        </div>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        @if(!$submitted)
                            <button type="submit" class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-8 py-3 bg-purple-600 text-white rounded-xl font-bold hover:bg-purple-700 transition-colors shadow-md">
                                Cek Jawaban
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </form>

        @if($submitted)
            <form method="POST" action="{{ parse_url(route('assignments.grammar-writing.meeting5.reset'), PHP_URL_PATH) }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full sm:w-auto px-8 py-3 bg-gray-500 text-white rounded-xl font-bold hover:bg-gray-600 transition-colors shadow-md">
                    Coba Lagi
                </button>
            </form>
        @endif
    </div>

    <!-- INLINE AUTO-SAVE SCRIPT -->
    <script>
    const AutoSave = {
        debounceTimer: null,
        debounceDelay: 500,
        userId: null,
        draftSyncTimer: null,

        init(meetingNumber, userId = null) {
            this.meetingNumber = meetingNumber;
            this.userId = userId || window.userId || 'guest';
            this.storageKey = `grammar_writing_meeting${meetingNumber}_user_${this.userId}`;

            this.isSubmitted = this.checkIfSubmitted();

            if (this.isSubmitted) {
                this.clearSaved();
                return;
            }

            this.restoreAnswers();
            this.setupAutoSave();
        },

        checkIfSubmitted() {
            const isReadonly = document.querySelector('#meetingAnswerForm input[type="text"][readonly]');
            return !!isReadonly;
        },

        setupAutoSave() {
            const form = document.getElementById('meetingAnswerForm');
            if (!form) {
                return;
            }

            const inputs = form.querySelectorAll('input[type="text"], textarea');

            inputs.forEach(input => {
                if (input.readOnly || input.disabled) {
                    return;
                }

                input.addEventListener('input', () => {
                    this.saveAnswers();
                });

                input.addEventListener('blur', () => {
                    this.saveAnswers();
                });

                input.addEventListener('keyup', () => {
                    this.saveAnswers();
                });
            });
        },

        saveAnswers() {
            if (this.isSubmitted) {
                return;
            }

            const form = document.getElementById('meetingAnswerForm');
            if (!form) {
                return;
            }

            const inputs = form.querySelectorAll('input[type="text"], textarea');
            const answers = {};

            inputs.forEach(input => {
                if (input.name && input.value) {
                    answers[input.name] = input.value;
                }
            });

            try {
                localStorage.setItem(this.storageKey, JSON.stringify(answers));
                this.showSaveIndicator();
                this.queueDraftSync(form);
            } catch (e) {
                console.error('Failed to save to localStorage:', e);
            }
        },

        queueDraftSync(form) {
            clearTimeout(this.draftSyncTimer);
            this.draftSyncTimer = setTimeout(() => {
                this.syncDraftToServer(form);
            }, this.debounceDelay);
        },

        async syncDraftToServer(form) {
            if (!form) {
                return false;
            }

            const action = form.getAttribute('action') || '';
            const match = action.match(/\/assignments\/grammar-writing\/fast-track\/meeting(\d+)/);
            if (!match) {
                return false;
            }

            const meetingNumber = match[1];
            const draftEndpoint = '/assignments/grammar-writing/fast-track/meeting' + meetingNumber + '/draft';
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            const payload = {};
            const assignNestedValue = (obj, key, value) => {
                const parts = String(key).replace(/\]/g, '').split('[');
                let ref = obj;

                for (let i = 0; i < parts.length; i++) {
                    const part = parts[i];
                    const isLast = i === parts.length - 1;

                    if (isLast) {
                        ref[part] = value;
                        return;
                    }

                    if (typeof ref[part] !== 'object' || ref[part] === null) {
                        ref[part] = {};
                    }

                    ref = ref[part];
                }
            };

            new FormData(form).forEach((value, key) => {
                if (key === '_token') {
                    return;
                }

                assignNestedValue(payload, key, value);
            });

            try {
                await fetch(draftEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify(payload),
                    keepalive: true,
                });
                return true;
            } catch (e) {
                console.error('Failed to sync draft to server:', e);
                return false;
            }
        },

        restoreAnswers() {
            try {
                const savedData = localStorage.getItem(this.storageKey);

                if (!savedData) {
                    return;
                }

                const answers = JSON.parse(savedData);
                let restoredCount = 0;

                Object.keys(answers).forEach(name => {
                    const input = document.querySelector(`input[name="${name}"], textarea[name="${name}"]`);

                    if (input && !input.value && !input.readOnly) {
                        input.value = answers[name];
                        restoredCount++;
                    }
                });

                if (restoredCount > 0) {
                    this.showRestoreIndicator(restoredCount);
                }
            } catch (e) {
                console.error('Failed to restore from localStorage:', e);
            }
        },

        showRestoreIndicator(count) {
            const indicator = document.createElement('div');
            indicator.className = 'fixed top-4 right-4 bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-sm font-medium';
            indicator.innerHTML = `✓ ${count} jawaban dipulihkan`;
            document.body.appendChild(indicator);

            setTimeout(() => {
                indicator.style.opacity = '0';
                indicator.style.transition = 'opacity 0.3s';
                setTimeout(() => indicator.remove(), 300);
            }, 3000);
        },

        showSaveIndicator() {
            let indicator = document.getElementById('auto-save-indicator');

            if (!indicator) {
                indicator = document.createElement('div');
                indicator.id = 'auto-save-indicator';
                indicator.className = 'fixed bottom-20 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-sm font-medium';
                indicator.style.transition = 'opacity 0.3s';
                indicator.innerHTML = '✓ Tersimpan otomatis';
                document.body.appendChild(indicator);
            }

            indicator.style.opacity = '1';
            indicator.style.backgroundColor = '#10b981';

            const now = new Date();
            const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            indicator.innerHTML = `✓ Tersimpan ${timeStr}`;

            clearTimeout(this.saveIndicatorTimeout);
            this.saveIndicatorTimeout = setTimeout(() => {
                indicator.style.opacity = '0.7';
            }, 3000);
        },

        clearSaved() {
            try {
                localStorage.removeItem(this.storageKey);
            } catch (e) {
                console.error('Failed to clear localStorage:', e);
            }
        }
    };

    window.AutoSave = AutoSave;
    AutoSave.showSaveErrorIndicator = function () {
        const indicator = document.createElement('div');
        indicator.className = 'fixed bottom-20 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-sm font-medium';
        indicator.style.transition = 'opacity 0.3s';
        indicator.innerHTML = '✗ Gagal menyimpan, coba lagi';
        document.body.appendChild(indicator);
        setTimeout(() => {
            indicator.style.opacity = '0';
            setTimeout(() => indicator.remove(), 300);
        }, 3000);
    };

    AutoSave.manualSave = async function () {
        const form = document.getElementById('meetingAnswerForm');
        if (!form) {
            return;
        }

        const btn = document.getElementById('manual-save-btn');
        if (btn) {
            btn.dataset.originalText = btn.dataset.originalText || btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = 'Menyimpan...';
        }

        try {
            const inputs = form.querySelectorAll('input[type="text"], textarea');
            const answers = {};
            inputs.forEach((input) => {
                if (input.name && input.value) {
                    answers[input.name] = input.value;
                }
            });
            localStorage.setItem(this.storageKey, JSON.stringify(answers));
        } catch (e) {
            console.error('[ManualSave] Failed to update localStorage:', e);
        }

        const ok = await this.syncDraftToServer(form);

        if (btn) {
            btn.disabled = false;
            btn.innerHTML = btn.dataset.originalText;
        }

        if (ok) {
            this.showSaveIndicator();
        } else {
            this.showSaveErrorIndicator();
        }
    };


    document.addEventListener('DOMContentLoaded', function() {
        const userId = {{ Auth::id() ?? 'null' }};
        if (userId && !window.location.search.includes('live_preview_for')) {
            AutoSave.init('5', userId);
        }
    });
    </script>

    <x-live-drawing />
    @include('components.student-broadcaster')

    {{-- Consolidated Floating Helper Buttons (hidden during admin Live
         Preview - these are student-only interactive tools, not relevant
         to the admin's read-only observation view) --}}
    @if(!request()->filled('live_preview_for'))
    <div class="fixed bottom-4 right-8 z-50 flex flex-col gap-2 items-end">
        <x-dictionary-button />
        <x-conjunction-button />
        <x-preposition-button />
        <x-pronouns-button />
        <x-verb-patterns-button />
        <x-modal-button />
        <x-tenses-button />
        <x-irregular-verbs-button />
    </div>
    @endif

    @if(!$submitted)
        <div class="fixed bottom-4 z-50" style="left: 50%; transform: translateX(-50%);">
            <button type="button" id="manual-save-btn" onclick="AutoSave.manualSave()"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full text-sm font-semibold shadow-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3M8 7V4a1 1 0 011-1h6a1 1 0 011 1v3M8 7h8"></path></svg>
                Save
            </button>
        </div>
    @endif

</body>
</html>
