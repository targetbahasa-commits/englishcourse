<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - {{ $trackTitle }} - Meeting {{ $meetingNumber }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F3F4FF]">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        <main class="flex-1 md:ml-64 p-4 sm:p-6 md:p-8">
            <!-- Topbar -->
            <div class="flex flex-col gap-4 md:flex-row md:justify-between md:items-center mb-6 md:mb-8">
                <div class="relative w-full md:w-96">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" class="w-full py-3 pl-10 pr-4 bg-white rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-green-500 shadow-sm" placeholder="Search">
                </div>
                <div class="flex items-center gap-6">
                    @include('components.topbar-action-icons')
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role) }}</p>
                        </div>
                        <div class="w-10 h-10 bg-purple-200 rounded-full overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=random" alt="User" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Header -->
            <div class="flex flex-col gap-4 md:flex-row md:justify-between md:items-center mb-8">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800">{{ $trackTitle }}</h2>
                    <p class="text-gray-500 text-sm">Meeting {{ $meetingNumber }} &mdash; {{ $topic }}</p>
                </div>
                <x-grammar-meeting-actions :meetingNumber="$meetingNumber ?? $meeting" :track="$track ?? 'complexity'" :reset-route="$resetRoute ?? null" :back-route="$backRoute ?? null" />
            </div>

            @if(!empty($submitted))
                <div class="bg-green-600 text-white p-6 rounded-2xl text-center mb-6 shadow-md">
                    <h2 class="text-2xl font-bold mb-2">Nilai Kamu: {{ $finalScore ?? 0 }} / 100</h2>
                    <p class="text-green-100">{{ ($finalScore ?? 0) >= 80 ? 'Luar biasa!' : 'Terus berlatih!' }}</p>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start pb-8">
                @if(!empty($cheatSheet['__html__']))
                <div class="lg:col-span-5 sticky top-6 self-start max-h-[calc(100vh-2rem)] overflow-y-auto pr-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5 sm:p-6">
                        {!! $cheatSheet['__html__'] !!}
                    </div>
                </div>
                @endif

                <div class="{{ !empty($cheatSheet['__html__']) ? 'lg:col-span-7' : 'lg:col-span-12' }}">
                @if(isset($questions))
                <form method="post" action="{{ $submitRoute ?? '#' }}" class="bg-white rounded-3xl shadow-sm border border-green-100 overflow-visible">
                    @csrf
                    <div class="bg-gradient-to-r from-green-50 via-emerald-50 to-white px-5 py-5 sm:px-8 sm:py-6 border-b border-green-100">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <h3 class="text-xl sm:text-2xl font-bold text-gray-800">A. Translate Kalimat</h3>
                                <p class="text-gray-600 mt-1 text-sm sm:text-base">Terjemahkan dan isi jawaban untuk setiap soal di bawah ini.</p>
                            </div>
                            <span class="inline-flex items-center justify-center rounded-full bg-green-600 text-white text-xs font-bold px-3 py-1.5 w-fit">
                                {{ count($questions) }} Soal
                            </span>
                        </div>
                    </div>

                    <!-- Tips / Guide Box -->
                    @if(!empty($guideBox))
                        <div class="mx-5 sm:mx-8 mt-5 p-4 sm:p-5 rounded-2xl bg-emerald-50/90 border border-emerald-200 text-emerald-950 shadow-xs">
                            {!! $guideBox !!}
                        </div>
                    @else
                        <!-- Tips Penentuan Tenses Box (Default) -->
                        <div class="mx-5 sm:mx-8 mt-5 p-4 sm:p-5 rounded-2xl bg-emerald-50/90 border border-emerald-200 text-emerald-950 shadow-xs">
                            <div class="flex items-center gap-2 mb-2 font-bold text-emerald-900 text-sm sm:text-base">
                                <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span>Tahap-Tahap Penentuan Tenses:</span>
                            </div>
                            <ol class="list-decimal list-inside space-y-2 text-xs sm:text-sm text-emerald-900 leading-relaxed font-medium">
                                <li>
                                    <strong>Tahap 1: Tentukan Jenis Bentuk Kalimat (Verbal, Nominal, atau Pasif)</strong>
                                    <div class="ml-5 text-emerald-800 text-xs font-normal space-y-0.5 mt-0.5">
                                        <div>• <strong>Verbal:</strong> Ada kata kerja aksi aktif (<em>me-, ber-, tanpa awalan</em>).</div>
                                        <div>• <strong>Nominal:</strong> Menyatakan sifat, profesi, atau keberadaan (<em>adalah, merupakan, ada, berada, berupa &rarr; gunakan be</em>).</div>
                                        <div>• <strong>Pasif:</strong> Subjek dikenai tindakan (<em>di-, ter- &rarr; gunakan be + V3</em>).</div>
                                    </div>
                                </li>
                                <li>
                                    <strong>Tahap 2: Tentukan Aspek Bentuk (Aspect)</strong>
                                    <div class="ml-5 text-emerald-800 text-xs font-normal space-y-0.5 mt-0.5">
                                        <div>• <strong>Perfect:</strong> Ada kata <em>sudah, telah, pernah, belum</em> &rarr; <code>have/has/had + V3</code>.</div>
                                        <div>• <strong>Continuous:</strong> Ada kata <em>sedang</em> &rarr; <code>be + V-ing</code>.</div>
                                        <div>• <strong>Modal:</strong> Ada kata <em>bisa/dapat (can), mungkin (may), harus (must), seharusnya (should)</em>.</div>
                                        <div>• <strong>Simple:</strong> Jika tidak ada penanda aspek di atas &rarr; gunakan pola <strong>Simple</strong>.</div>
                                    </div>
                                </li>
                                <li>
                                    <strong>Tahap 3: Tentukan Waktu (Time Frame)</strong>
                                    <div class="ml-5 text-emerald-800 text-xs font-normal space-y-0.5 mt-0.5">
                                        <div>• <strong>Present:</strong> Masa sekarang, kebiasaan, atau fakta umum (<em>default jika tidak ada penanda waktu khusus</em>).</div>
                                        <div>• <strong>Past:</strong> Masa lampau / sejarah / peristiwa selesai (<em>kemarin, tahun lalu, era kuno &rarr; V2 / was / were / had</em>).</div>
                                        <div>• <strong>Future:</strong> Masa depan (<em>akan, tahun depan &rarr; will + V1</em>).</div>
                                    </div>
                                </li>
                            </ol>
                            <div class="mt-3 pt-2.5 border-t border-emerald-200/70 text-xs font-semibold text-emerald-800 flex items-center gap-1">
                                <span>Catatan Kunci:</span> <span>adalah, merupakan, ada, berupa, berada = <strong>Nominal (Wajib be)</strong> | di-, ter- = <strong>Pasif (be + V3)</strong></span>
                            </div>
                        </div>
                    @endif

                    <div class="p-5 sm:p-8 space-y-4 sm:space-y-5">
                        <ol class="space-y-4 sm:space-y-5">
                            @foreach($questions as $i => $q)
                                @php
                                    $helper = $questionHelpers[$i + 1] ?? ['example' => null, 'vocab' => []];
                                    $itemResult = $results[$i + 1] ?? null;
                                @endphp
                                <li class="group rounded-2xl border border-gray-200 bg-white p-4 sm:p-5 transition hover:shadow-md hover:border-green-200 space-y-3 overflow-visible">
                                    <div class="flex items-start gap-3 sm:gap-4">
                                        <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-green-100 text-green-700 flex items-center justify-center text-sm font-bold shrink-0">
                                            {{ $i + 1 }}
                                        </div>
                                        <div class="pt-1 flex-1">
                                            <p class="text-gray-800 leading-relaxed">{{ $q }}</p>
                                        </div>
                                        <div class="flex flex-row items-center gap-1 ml-2">
                                            @if(!empty($helper['example']))
                                                <div x-data="{ open: false }" class="relative inline-block">
                                                    <button type="button" @click="open = !open" @click.outside="open = false" class="w-6 h-6 rounded-md bg-yellow-50 border border-yellow-200 text-yellow-600 flex items-center justify-center text-xs font-bold hover:bg-yellow-100 transition-colors focus:outline-none shadow-sm">
                                                        ?
                                                    </button>
                                                    <div x-show="open" x-transition class="absolute bottom-full right-0 mb-2 w-64 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-center leading-relaxed" style="display: none;">
                                                        <strong class="block mb-1 text-yellow-300">Contoh:</strong>
                                                        {{ $helper['example']['id'] }}<br>
                                                        <em class="text-gray-300">{{ $helper['example']['en'] }}</em>
                                                        <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if(!empty($helper['vocab']) && is_array($helper['vocab']))
                                                <div x-data="{ open: false }" class="relative inline-block">
                                                    <button type="button" @click="open = !open" @click.outside="open = false" class="w-6 h-6 rounded-md bg-green-50 border border-green-200 text-green-600 flex items-center justify-center text-xs font-bold hover:bg-green-100 transition-colors focus:outline-none shadow-sm">
                                                        v
                                                    </button>
                                                    <div x-show="open" x-transition class="absolute bottom-full right-0 mb-2 w-72 bg-gray-800 text-white text-xs rounded-lg p-3 shadow-lg z-10 text-left leading-relaxed" style="display: none;">
                                                        <strong class="block mb-2 text-green-300 border-b border-gray-600 pb-1">Vocabulary Helper:</strong>
                                                        <ul class="space-y-1">
                                                            @foreach($helper['vocab'] as $word => $info)
                                                                <li class="flex justify-between gap-3">
                                                                    <span class="text-green-300 font-mono">{{ $word }} <span class="text-gray-400 text-xs">{{ $info['pos'] }}</span></span>
                                                                    <span>{{ $info['id'] }}</span>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                        <div class="absolute top-full right-2 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                    </div>
                                                </div>
                                            @endif

                                            @if(auth()->check() && auth()->user()->isAdmin() && !empty($helper['original_id']))
                                                <button type="button"
                                                        onclick="openGrammarQuestionEditModal(
                                                            {{ \Illuminate\Support\Js::from($helper['original_id']) }},
                                                            {{ \Illuminate\Support\Js::from($q) }},
                                                            {{ \Illuminate\Support\Js::from($helper['correct_answer'] ?? '') }},
                                                            {{ \Illuminate\Support\Js::from($helper['tense'] ?? '') }},
                                                            {{ \Illuminate\Support\Js::from($helper['vocab'] ?? []) }}
                                                        )"
                                                        class="w-6 h-6 rounded-md bg-yellow-50 border border-yellow-200 text-yellow-600 flex items-center justify-center text-xs font-bold hover:bg-yellow-100 transition-colors focus:outline-none shadow-sm" title="Edit soal">
                                                    e
                                                </button>
                                                <form action="{{ parse_url(route('admin.grammar.question.destroy', $helper['original_id']), PHP_URL_PATH) }}" method="POST" onsubmit="return confirm('Hapus soal ini?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="w-6 h-6 rounded-md bg-red-50 border border-red-200 text-red-600 flex items-center justify-center text-xs font-bold hover:bg-red-100 transition-colors focus:outline-none shadow-sm" title="Hapus">
                                                        x
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="ml-11 sm:ml-13 space-y-2">
                                        @if(!empty($requireTenseAnswer))
                                            @php
                                                $rawAns = $userAnswers[$i + 1] ?? ($draftAnswers[$i + 1] ?? null);
                                                $tenseVal = is_array($rawAns) ? ($rawAns['tense'] ?? '') : '';
                                                $transVal = is_array($rawAns) ? ($rawAns['trans'] ?? '') : (is_string($rawAns) ? $rawAns : '');
                                            @endphp
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-500 mb-1">Nama Tenses</label>
                                                <textarea rows="1"
                                                          name="answers[{{ $i + 1 }}][tense]"
                                                          style="field-sizing: content;"
                                                          class="auto-expand-answer resize-none overflow-hidden grammar-draft-input w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm leading-relaxed focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition bg-white hover:border-gray-400 {{ !empty($submitted) ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                                          placeholder="mis. Present Perfect Passive"
                                                          data-draft-key="{{ $i + 1 }}"
                                                          data-draft-subkey="tense"
                                                          {{ !empty($submitted) ? 'readonly' : '' }}
                                                          autocomplete="off">{{ $tenseVal }}</textarea>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-500 mb-1">Terjemahan</label>
                                                <textarea rows="1"
                                                          name="answers[{{ $i + 1 }}][trans]"
                                                          style="field-sizing: content;"
                                                          class="auto-expand-answer resize-none overflow-hidden grammar-draft-input w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm leading-relaxed focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition bg-white hover:border-gray-400 {{ !empty($submitted) ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                                          placeholder="Tulis bahasa Inggrisnya di sini..."
                                                          data-draft-key="{{ $i + 1 }}"
                                                          data-draft-subkey="trans"
                                                          {{ !empty($submitted) ? 'readonly' : '' }}
                                                          autocomplete="off">{{ $transVal }}</textarea>
                                            </div>

                                            @if(!empty($submitted) && $itemResult)
                                                <div class="mt-1 space-y-1.5 text-xs">
                                                    <div class="{{ ($itemResult['tense_score'] ?? 0) >= 2 ? 'text-green-600 font-semibold' : 'text-amber-700 bg-amber-50 p-2 rounded-lg border border-amber-200' }}">
                                                        <strong>Tenses</strong> (Skor: {{ $itemResult['tense_score'] ?? 0 }}/2)
                                                        @if(($itemResult['tense_score'] ?? 0) < 2)
                                                            <div class="mt-1">Kunci: <span class="italic">{{ $itemResult['tense_correct_answer'] ?? '' }}</span></div>
                                                        @endif
                                                    </div>
                                                    <div class="{{ ($itemResult['trans_score'] ?? 0) >= 3 ? 'text-green-600 font-semibold' : 'text-amber-700 bg-amber-50 p-2 rounded-lg border border-amber-200' }}">
                                                        <strong>Terjemahan</strong> (Skor: {{ $itemResult['trans_score'] ?? 0 }}/3)
                                                        @if(($itemResult['trans_score'] ?? 0) < 3)
                                                            <div class="mt-1">Kunci: <span class="italic">{{ $itemResult['correct_answer'] ?? '' }}</span></div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endif
                                        @else
                                            <textarea rows="1"
                                                      name="answers[{{ $i + 1 }}]"
                                                      style="field-sizing: content;"
                                                      class="auto-expand-answer resize-none overflow-hidden grammar-draft-input w-full px-3 py-2.5 border border-gray-300 rounded-lg text-sm leading-relaxed focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition bg-white hover:border-gray-400 {{ !empty($submitted) ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                                      placeholder="Tulis bahasa Inggrisnya di sini..."
                                                      data-draft-key="{{ $i + 1 }}"
                                                      {{ !empty($submitted) ? 'readonly' : '' }}
                                                      autocomplete="off">{{ $userAnswers[$i + 1] ?? ($draftAnswers[$i + 1] ?? '') }}</textarea>

                                            @if(!empty($submitted) && $itemResult)
                                                <div class="mt-2 text-xs">
                                                    @if(($itemResult['answered'] ?? true) === false)
                                                        <div class="text-gray-500 bg-gray-50 p-2 rounded-lg border border-gray-200">
                                                            Belum dikerjakan - tidak dinilai.
                                                        </div>
                                                    @elseif(($itemResult['score'] ?? 0) >= 4)
                                                        <div class="text-green-600 font-semibold">✓ Benar (Skor: {{ $itemResult['score'] }}/5)</div>
                                                    @else
                                                        <div class="text-amber-700 bg-amber-50 p-2 rounded-lg border border-amber-200 space-y-1">
                                                            <div><strong>Skor:</strong> {{ $itemResult['score'] ?? 0 }}/5</div>
                                                            <div><strong>Kunci:</strong> <span class="italic">{{ $itemResult['correct_answer'] ?? '' }}</span></div>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ol>

                        {{-- Section B: Paragraph Translation --}}
                        @if(isset($paragraph) && !empty($paragraph['id']))
                            <div class="mt-10 pt-8 border-t border-gray-200">
                                <div class="bg-gradient-to-r from-green-50 via-emerald-50 to-white px-5 py-4 sm:px-6 sm:py-5 rounded-2xl border border-green-100 mb-5">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h3 class="text-xl sm:text-2xl font-bold text-gray-800">B. Translate Paragraf</h3>
                                            <p class="text-gray-600 text-xs sm:text-sm mt-0.5">Terjemahkan seluruh paragraf di bawah ini ke dalam bahasa Inggris yang tepat.</p>
                                        </div>
                                        @if(!empty($paragraph['vocab']))
                                            <div x-data="{ open: false }" class="relative inline-block">
                                                <button type="button" @click="open = !open" @click.outside="open = false" class="w-7 h-7 rounded-lg bg-green-50 border border-green-200 text-green-600 flex items-center justify-center text-xs font-bold hover:bg-green-100 transition-colors focus:outline-none shadow-sm cursor-pointer" title="Vocabulary Helper">
                                                    v
                                                </button>
                                                <div x-show="open" x-transition class="absolute bottom-full right-0 mb-2 w-80 bg-gray-800 text-white text-xs rounded-lg p-3.5 shadow-lg z-10 text-left leading-relaxed" style="display: none;">
                                                    <strong class="block mb-2 text-green-300 border-b border-gray-600 pb-1">Vocabulary Helper:</strong>
                                                    <ul class="space-y-1.5">
                                                        @foreach($paragraph['vocab'] as $word => $info)
                                                            <li class="flex justify-between gap-3">
                                                                <span class="text-green-300 font-mono">{{ $word }} <span class="text-gray-400 text-xs">{{ is_array($info) ? ($info['pos'] ?? '') : '' }}</span></span>
                                                                <span>{{ is_array($info) ? ($info['id'] ?? '') : $info }}</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                    <div class="absolute top-full right-3 -mt-1 border-4 border-transparent border-t-gray-800"></div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="p-5 sm:p-6 bg-white rounded-2xl border border-gray-200 space-y-4">
                                    <div class="bg-gray-50 p-4 rounded-xl border border-gray-200">
                                        <p class="text-gray-800 leading-relaxed text-sm sm:text-base font-medium">{{ $paragraph['id'] }}</p>
                                    </div>

                                    @if(!empty($paragraph['vocab']))
                                        <div x-data="{ showVocab: false }">
                                            <button type="button" @click="showVocab = !showVocab" class="w-full px-4 py-2.5 bg-yellow-50 border border-yellow-200 hover:bg-yellow-100 text-yellow-900 font-bold rounded-xl transition-colors flex items-center justify-between text-xs sm:text-sm shadow-xs">
                                                <span class="flex items-center gap-2"><span>Vocabulary Bantuan</span></span>
                                                <svg :class="showVocab ? 'rotate-180' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                                </svg>
                                            </button>
                                            <div x-show="showVocab" x-transition style="display:none;" class="mt-3 bg-yellow-50/70 border border-yellow-200 p-4 rounded-xl">
                                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-2">
                                                    @foreach($paragraph['vocab'] as $en => $info)
                                                        @php
                                                            $idText = is_array($info) ? ($info['id'] ?? '') : $info;
                                                            $posText = is_array($info) ? ($info['pos'] ?? '') : '';
                                                        @endphp
                                                        <span class="bg-white px-3 py-1.5 rounded-lg border border-yellow-200 text-xs text-gray-700 shadow-xs flex justify-between gap-1">
                                                            <strong class="text-green-700 font-mono">{{ $en }} <span class="text-gray-400 font-normal">{{ $posText }}</span></strong>
                                                            <span>{{ $idText }}</span>
                                                        </span>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <div>
                                        <label class="block text-xs sm:text-sm font-bold text-gray-700 mb-1.5">Terjemahan Paragraf Anda:</label>
                                        <textarea
                                            name="userParagraphAnswer"
                                            rows="7"
                                            style="field-sizing: content;"
                                            class="auto-expand-answer resize-none overflow-hidden grammar-draft-input w-full px-3.5 py-3 border border-gray-300 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition bg-white hover:border-gray-400 leading-relaxed {{ !empty($submitted) ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                                            placeholder="Tulis terjemahan paragraf lengkap di sini..."
                                            data-draft-key="paragraph_answer"
                                            {{ !empty($submitted) ? 'readonly' : '' }}>{{ old('userParagraphAnswer', $userParagraphAnswer ?? ($draftParagraph ?? '')) }}</textarea>
                                    </div>

                                    @if(!empty($submitted) && !empty($paragraphResult))
                                        <div class="pt-2 space-y-3">
                                            @if(($paragraphResult['score'] ?? 0) >= 20)
                                                <div class="text-sm font-bold text-green-700 bg-green-50 p-3.5 rounded-xl border border-green-200">
                                                    ✓ Luar Biasa! Skor Paragraf: {{ $paragraphResult['score'] }} / 25
                                                </div>
                                            @else
                                                <div class="text-sm font-bold text-amber-800 bg-amber-50 p-3.5 rounded-xl border border-amber-200">
                                                    Skor Paragraf: {{ $paragraphResult['score'] ?? 0 }} / 25
                                                </div>
                                            @endif

                                            @if(!empty($paragraphResult['formatted_answer']))
                                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 text-xs sm:text-sm leading-relaxed">
                                                    <strong class="block mb-2 text-gray-800">Analisis Perbedaan:</strong>
                                                    <div class="prose max-w-none text-gray-700">
                                                        {!! $paragraphResult['formatted_answer'] !!}
                                                    </div>
                                                </div>
                                            @endif

                                            @if(!empty($paragraph['en']))
                                                <div class="bg-blue-50 p-4 rounded-xl border border-blue-200 text-xs sm:text-sm">
                                                    <strong class="block mb-1 text-blue-900">Kunci Jawaban Paragraf:</strong>
                                                    <p class="text-blue-950 italic leading-relaxed">{{ $paragraph['en'] }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="px-5 py-6 sm:px-8 border-t border-gray-100 bg-gray-50/60 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <a href="{{ $backRoute ?? route('assignments.grammar-writing.track', $track ?? 'complexity') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-xl hover:bg-gray-50 border border-gray-200 transition-all font-medium text-sm shadow-sm group">
                            <svg class="w-4 h-4 text-gray-400 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back
                        </a>
                        <div class="flex items-center gap-3">
                            @if(!empty($submitted) && !empty($resetRoute))
                                <button type="button" onclick="document.getElementById('reset-form').submit();" class="w-full sm:w-auto px-6 py-3 bg-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-300 transition shadow-sm">
                                    Coba Lagi / Reset
                                </button>
                            @endif
                            @if(empty($submitted))
                                <button type="submit" class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-8 py-3 bg-green-600 text-white rounded-xl font-bold hover:bg-green-700 transition shadow-md">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Kirim Jawaban
                                </button>
                            @endif
                        </div>
                    </div>
                </form>

                @if(!empty($submitted) && !empty($resetRoute))
                    <form id="reset-form" method="post" action="{{ $resetRoute }}" class="hidden">
                        @csrf
                    </form>
                @endif
                @else
                <div class="flex flex-col items-center justify-center min-h-[60vh]">
                    <div class="bg-white rounded-3xl shadow-sm p-16 text-center max-w-lg w-full">
                        <div class="w-20 h-20 bg-green-100 rounded-3xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Meeting {{ $meetingNumber }}</h3>
                        <p class="text-green-600 font-semibold text-lg mb-4">{{ $topic }}</p>
                        <p class="text-gray-500 text-sm leading-relaxed">
                            Konten untuk meeting ini sedang disiapkan.<br>
                            Silakan tunggu update berikutnya.
                        </p>
                        <div class="mt-8 pt-6 border-t border-gray-100">
                            <a href="{{ route('assignments.grammar-writing.track', $track ?? 'complexity') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-xl hover:bg-gray-50 border border-gray-200 transition-all font-medium text-sm shadow-sm group">
        <svg class="w-4 h-4 text-gray-400 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back
    </a>
                        </div>
                    </div>
                </div>
                @endif
                </div>
            </div>
        </main>
    </div>


    @include('components.student-broadcaster')

    <x-live-drawing />

    {{-- Consolidated Floating Helper Buttons (hidden during admin Live
         Preview - these are student-only interactive tools, not relevant
         to the admin's read-only observation view) --}}
    @if(!request()->filled('live_preview_for'))
    <div class="fixed bottom-4 right-8 z-50 flex flex-col gap-2 items-end">
        <x-dictionary-button />
        <x-conjunction-button />
        <x-preposition-button />
        <x-pronouns-button />
        <x-adverb-button />
        <x-verb-patterns-button />
        <x-modal-button />
        <x-tenses-button />
        <x-irregular-verbs-button />
    </div>
    @endif

    @if(empty($submitted))
        <div class="fixed bottom-4 z-50" style="left: 50%; transform: translateX(-50%);">
            <button type="button" id="manual-save-btn" onclick="manualSaveGrammarDraft()"
                class="inline-flex items-center justify-center px-6 py-2.5 text-white rounded-full text-sm font-bold shadow-lg hover:shadow-xl transition-all duration-200 cursor-pointer border border-white/20 active:scale-95 hover:brightness-110"
                style="background-color: #1e3a8a;">
                Save
            </button>
        </div>
    @endif

    @if(isset($questions))
    <script>
        (function () {
            const draftUrl = {{ Js::from(route('assignments.grammar-writing.track-meeting.draft', ['track' => $track ?? 'complexity', 'meeting' => $meetingNumber])) }};
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
            const storageKey = 'tb_gw_draft_{{ $track ?? "complexity" }}_m{{ $meetingNumber }}_{{ auth()->id() ?? "guest" }}';
            let draftTimer = null;

            // Admin Live Preview loads this same page inside an iframe under
            // the ADMIN's own authenticated session, not the student being
            // previewed - storageKey above is keyed by auth()->id(), so it
            // would restore/resync the admin's own locally-cached draft
            // (from whenever they last used this page themselves) into the
            // iframe, making an empty student's work look filled in. Skip all
            // localStorage restore/sync in preview mode - real students never
            // load this URL with live_preview_for, so their own autosave is
            // completely unaffected.
            const isLivePreview = window.location.search.includes('live_preview_for');

            function collectAnswers() {
                const answers = {};
                document.querySelectorAll('.grammar-draft-input').forEach((el) => {
                    const subkey = el.dataset.draftSubkey;
                    const key = el.dataset.draftKey;
                    if (!key) return;

                    if (subkey) {
                        if (typeof answers[key] !== 'object' || answers[key] === null) {
                            answers[key] = {};
                        }
                        answers[key][subkey] = el.value;
                    } else {
                        answers[key] = el.value;
                    }
                });
                return answers;
            }

            function saveToLocalStorage(answers) {
                try {
                    localStorage.setItem(storageKey, JSON.stringify({ answers: answers, savedAt: Date.now() }));
                } catch (e) {}
            }

            function restoreFromLocalStorage() {
                try {
                    const raw = localStorage.getItem(storageKey);
                    if (!raw) return;
                    const data = JSON.parse(raw);
                    if (!data || !data.answers) return;

                    let restoredAny = false;
                    document.querySelectorAll('.grammar-draft-input').forEach((el) => {
                        const key = el.dataset.draftKey;
                        const subkey = el.dataset.draftSubkey;
                        if (!key) return;

                        if (subkey && data.answers[key] && typeof data.answers[key] === 'object') {
                            const val = data.answers[key][subkey];
                            if (val && !el.value) {
                                el.value = val;
                                restoredAny = true;
                            }
                        } else if (!subkey && data.answers[key]) {
                            const val = data.answers[key];
                            if (val && !el.value) {
                                el.value = val;
                                restoredAny = true;
                            }
                        }
                    });

                    if (restoredAny) {
                        syncGrammarDraft();
                    }
                } catch (e) {}
            }

            let currentCsrf = csrfToken;

            async function refreshCsrfToken() {
                try {
                    const res = await fetch('/refresh-csrf');
                    if (res.ok) {
                        const json = await res.json();
                        if (json.token) {
                            currentCsrf = json.token;
                            const meta = document.querySelector('meta[name="csrf-token"]');
                            if (meta) meta.setAttribute('content', json.token);
                            return json.token;
                        }
                    }
                } catch (e) {}
                return null;
            }

            async function syncGrammarDraft() {
                // "Ulangi Soal Ini" sets this flag before its reset POST navigates
                // away. Without this guard, the beforeunload listener below (and
                // any input/blur/interval trigger racing the navigation) calls
                // this function with the still-stale DOM values and immediately
                // writes them right back into localStorage/server, undoing the
                // reset the user just confirmed.
                if (window.__grammarResetInProgress) return false;
                const answers = collectAnswers();
                saveToLocalStorage(answers);

                if (!draftUrl) return false;

                try {
                    let response = await fetch(draftUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': currentCsrf,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify({ answers: answers }),
                        keepalive: true,
                    });

                    if (response.status === 419) {
                        const freshToken = await refreshCsrfToken();
                        if (freshToken) {
                            response = await fetch(draftUrl, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': freshToken,
                                    'X-Requested-With': 'XMLHttpRequest',
                                },
                                body: JSON.stringify({ answers: answers }),
                                keepalive: true,
                            });
                        }
                    }

                    return response.ok;
                } catch (e) {
                    console.error('Failed to sync grammar draft:', e);
                    return false;
                }
            }

            function queueGrammarDraftSync() {
                if (window.__grammarResetInProgress) return;
                const answers = collectAnswers();
                saveToLocalStorage(answers);
                clearTimeout(draftTimer);
                draftTimer = setTimeout(syncGrammarDraft, 600);
            }

            if (!isLivePreview) {
                // Restore from localStorage if local copy has more recent answers
                restoreFromLocalStorage();

                document.querySelectorAll('.grammar-draft-input').forEach((el) => {
                    el.addEventListener('input', queueGrammarDraftSync);
                    el.addEventListener('change', queueGrammarDraftSync);
                    el.addEventListener('blur', queueGrammarDraftSync);
                });

                // Periodic heartbeat sync every 45 seconds
                setInterval(() => {
                    const answers = collectAnswers();
                    if (Object.keys(answers).length > 0) {
                        syncGrammarDraft();
                    }
                }, 45000);

                // Lifecycle listeners for mobile / tab switching / reconnecting / focus
                document.addEventListener('visibilitychange', () => {
                    syncGrammarDraft();
                });
                window.addEventListener('focus', () => {
                    syncGrammarDraft();
                });
                window.addEventListener('online', () => {
                    syncGrammarDraft();
                });
                window.addEventListener('pageshow', () => {
                    restoreFromLocalStorage();
                    syncGrammarDraft();
                });
                window.addEventListener('beforeunload', () => {
                    syncGrammarDraft();
                });
            }

            async function manualSaveGrammarDraft() {
                const btn = document.getElementById('manual-save-btn');
                if (btn) {
                    btn.dataset.originalText = btn.dataset.originalText || btn.innerHTML;
                    btn.disabled = true;
                    btn.innerHTML = 'Menyimpan...';
                }

                const ok = await syncGrammarDraft();

                if (btn) {
                    btn.disabled = false;
                    btn.innerHTML = btn.dataset.originalText;
                }

                const indicator = document.createElement('div');
                if (ok) {
                    indicator.className = 'fixed bottom-20 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-sm font-medium';
                    indicator.innerHTML = '\u2713 Tersimpan';
                } else {
                    indicator.className = 'fixed bottom-20 left-1/2 transform -translate-x-1/2 bg-amber-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-sm font-medium';
                    indicator.innerHTML = '\u2713 Tersimpan di browser';
                }
                document.body.appendChild(indicator);
                setTimeout(() => {
                    indicator.style.transition = 'opacity 0.3s';
                    indicator.style.opacity = '0';
                    setTimeout(() => indicator.remove(), 300);
                }, 3000);
            }
            window.manualSaveGrammarDraft = manualSaveGrammarDraft;
        })();
    </script>
    @endif

    @if(auth()->check() && auth()->user()->isAdmin())
        {{-- Shared admin "Edit soal" modal for this template - every meeting
             that reads its questions from grammar_questions (see
             GrammarWritingSessionController::meeting2SentenceData() for the
             first one) reuses this same modal/JS pair, so it isn't
             duplicated per meeting the way meeting3.blade.php's own copy is. --}}
        <div x-data="{ open: false, id: null, question: '', answer: '', tense: '', vocab: {} }"
             @open-grammar-question-edit-modal.window="open = true; id = $event.detail.id; question = $event.detail.question; answer = $event.detail.answer; tense = $event.detail.tense; vocab = $event.detail.vocab || {}"
             x-show="open" x-cloak
             class="fixed inset-0 z-[100000] bg-black/60 backdrop-blur-sm flex items-center justify-center p-4" style="display: none;">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg p-6 sm:p-7 border border-gray-100" @click.outside="open = false">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Edit Soal</h3>
                <form method="POST" :action="`{{ url('/admin/assignments/grammar-writing/questions') }}/${id}`">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kalimat (Indonesia)</label>
                            <textarea name="question_text" x-model="question" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jawaban Benar (English)</label>
                            <textarea name="correct_answer" x-model="answer" rows="2" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm" required></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Tenses</label>
                            <input type="text" name="tense" x-model="tense" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Vocab (JSON)</label>
                            <textarea name="vocab" x-text="JSON.stringify(vocab, null, 2)" @input="vocab = $event.target.value" rows="4" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-xs font-mono"></textarea>
                        </div>
                    </div>
                    <div class="flex gap-3 mt-6">
                        <button type="button" @click="open = false" class="flex-1 py-2.5 px-4 rounded-xl border border-gray-300 text-gray-700 font-semibold text-sm hover:bg-gray-50 transition">Batal</button>
                        <button type="submit" class="flex-1 py-2.5 px-4 rounded-xl bg-blue-600 text-white font-semibold text-sm hover:bg-blue-700 transition">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            window.openGrammarQuestionEditModal = function(id, question, answer, tense, vocab) {
                window.dispatchEvent(new CustomEvent('open-grammar-question-edit-modal', { detail: { id, question, answer, tense, vocab } }));
            };
        </script>
    @endif

</body>
</html>
