<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
    <script>
        // Shared Turnstile callback — stores the latest verified token globally
        window.cfTurnstileToken = null;
        function onTurnstileVerified(token) {
            window.cfTurnstileToken = token;
        }
        function onTurnstileExpired() {
            window.cfTurnstileToken = null;
        }
    </script>
    <style>
        html,
        body {
            height: 100%;
            overflow: hidden;
        }

        @keyframes avatarPulse {
            0% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4);
            }

            50% {
                box-shadow: 0 0 0 15px rgba(59, 130, 246, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0);
            }
        }

        .avatar-speaking {
            animation: avatarPulse 1.5s infinite ease-in-out;
            border-color: #3b82f6 !important;
        }

        @media (min-width: 768px) {
            .desktop-animated-border {
                position: relative;
                padding: 2px;
                border-radius: 0.75rem;
                overflow: hidden;
                z-index: 1;
            }
            .desktop-animated-border::before {
                content: '';
                position: absolute;
                width: 200vw;
                height: 200vw;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: -1;
                /* Biru cerah (cyan/sky) */
                background: conic-gradient(transparent 70%, #38bdf8 85%, #22d3ee 100%);
                /* 3 putaran (15s) + jeda 60s = total 75s */
                animation: rotate-border-transform 75s linear infinite;
            }
            .desktop-animated-border-inner {
                border-radius: calc(0.75rem - 2px) !important;
                height: 100%;
                width: 100%;
            }
        }
        @keyframes rotate-border-transform {
            0% { transform: translate(-50%, -50%) rotate(0deg); opacity: 1; }
            20% { transform: translate(-50%, -50%) rotate(1080deg); opacity: 1; } /* 20% dari 75s = 15s (3 putaran) */
            20.01% { transform: translate(-50%, -50%) rotate(1080deg); opacity: 0; }
            99.99% { transform: translate(-50%, -50%) rotate(1080deg); opacity: 0; }
            100% { transform: translate(-50%, -50%) rotate(0deg); opacity: 1; }
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-50">
    @php
        $textToSpeak = '';
        if (str_starts_with($type, 'speaking')) {
            $textToSpeak .= "Part 1. ";
            if (isset($test->part1_questions) && is_array($test->part1_questions)) {
                $textToSpeak .= implode(' ', $test->part1_questions) . ' ';
            }
            $textToSpeak .= "Part 2. ";
            $questionsArray = is_string($test->questions) ? json_decode($test->questions, true) : $test->questions;
            if (is_array($questionsArray)) {
                $textToSpeak .= implode(' ', $questionsArray) . ' ';
            }
            $textToSpeak .= "Part 3. ";
            $part3Array = isset($test->part3_questions) ? (is_string($test->part3_questions) ? json_decode($test->part3_questions, true) : $test->part3_questions) : [];
            if (is_array($part3Array)) {
                $textToSpeak .= implode(' ', $part3Array);
            }
        } else {
            if (isset($test->prompt)) {
                $textToSpeak = $test->prompt;
            } elseif (isset($test->questions)) {
                $questionsArray = is_string($test->questions) ? json_decode($test->questions, true) : $test->questions;
                if (is_array($questionsArray)) {
                    $textToSpeak = implode(' ', $questionsArray);
                }
            }
        }

        // Combine idioms and collocations
        $allCollocations = [];
        $part2Collo = isset($test->collocations) ? (is_string($test->collocations) ? json_decode($test->collocations, true) : $test->collocations) : [];
        if (is_array($part2Collo))
            $allCollocations = array_merge($allCollocations, $part2Collo);
        $part3Collo = isset($test->part3_collocations) ? (is_string($test->part3_collocations) ? json_decode($test->part3_collocations, true) : $test->part3_collocations) : [];
        if (is_array($part3Collo))
            $allCollocations = array_merge($allCollocations, $part3Collo);

        $allIdioms = [];
        $part2Idioms = isset($test->idioms) ? (is_string($test->idioms) ? json_decode($test->idioms, true) : $test->idioms) : [];
        if (is_array($part2Idioms))
            $allIdioms = array_merge($allIdioms, $part2Idioms);
        $part3Idioms = isset($test->part3_idioms) ? (is_string($test->part3_idioms) ? json_decode($test->part3_idioms, true) : $test->part3_idioms) : [];
        if (is_array($part3Idioms))
            $allIdioms = array_merge($allIdioms, $part3Idioms);
    @endphp
    <div class="fixed inset-0 z-0 flex flex-col bg-gray-50"
        x-data="promoTest({ promptText: {{ json_encode($textToSpeak) }}, part1Questions: {{ json_encode($test->part1_questions ?? []) }}, part2Questions: {{ json_encode(is_string($test->questions ?? '[]') ? json_decode($test->questions ?? '[]', true) : ($test->questions ?? [])) }}, part3Questions: {{ json_encode(isset($test->part3_questions) ? (is_string($test->part3_questions) ? json_decode($test->part3_questions, true) : $test->part3_questions) : []) }}, collocations: {{ json_encode($allCollocations) }}, idioms: {{ json_encode($allIdioms) }}, isSpeakingTest: {{ str_starts_with($type, 'speaking') ? 'true' : 'false' }}, isAdmin: {{ (auth()->check() && auth()->user()->isAdmin()) ? 'true' : 'false' }} })">

        <!-- Header (always visible) -->
        <div class="flex-none bg-white border-b border-gray-200 shadow-sm z-10 w-full pl-0">
            <div class="px-4 md:px-6 py-4 flex flex-wrap md:flex-nowrap items-center justify-between relative gap-4">
                <div class="flex items-center gap-4 z-10 w-full md:w-auto justify-between md:justify-start">
                    <div class="flex items-center gap-4">
                        @if(str_starts_with($type, 'speaking'))
                            <div class="p-2.5 bg-gradient-to-br from-gray-700 to-black rounded-xl shadow-md">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                                    </path>
                                </svg>
                            </div>
                        @else
                            <div class="p-2.5 bg-gradient-to-br from-gray-700 to-black rounded-xl shadow-md shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                    </path>
                                </svg>
                            </div>
                        @endif
                        <div>
                            <h1 class="text-lg md:text-xl font-bold text-gray-800 line-clamp-1">{{ $test->title }}</h1>
                            <p class="text-xs md:text-sm text-gray-500">Free Practice Test</p>
                        </div>
                    </div>
                    <!-- Exit button moved here for mobile only -->
                    <div class="md:hidden flex items-center z-10 shrink-0">
                        <a href="{{ url('/') }}"
                            class="flex items-center gap-2 px-3 py-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition-all whitespace-nowrap">
                            Exit
                        </a>
                    </div>
                </div>



                <!-- TOOLBAR IN HEADER -->
                <!-- TOOLBAR -->
                @if(str_starts_with($type, 'writing'))
                    <style>
                        @media (max-width: 767px) {
                            .mobile-floating-toolbar {
                                position: fixed !important;
                                bottom: 0;
                                left: 0;
                                right: 0;
                                padding: 0.5rem;
                                z-index: 90 !important;
                            }
                            .mobile-transparent-bg {
                                background-color: transparent !important;
                            }
                        }
                    </style>
                    <div class="w-full md:flex-1 md:mx-4 min-w-0 flex items-center z-10 order-last md:order-none overflow-x-auto custom-scrollbar pb-2 md:pb-0 mobile-floating-toolbar" x-data="{ showTools: false }">
                        <div class="rounded-xl w-max md:w-full flex flex-col md:flex-row md:items-center min-w-min mx-auto desktop-animated-border">
                            <div class="rounded-xl p-1 w-full flex flex-col md:flex-row md:items-center desktop-animated-border-inner bg-gray-100" :class="showTools ? '' : 'mobile-transparent-bg'">
                                <!-- Toggle Button for Mobile -->
                                <div class="md:hidden w-full flex justify-center p-1">
                                    <button @click="showTools = !showTools" 
                                            :class="showTools ? 'text-yellow-300 bg-red-600 hover:bg-red-700' : 'text-white bg-black hover:bg-gray-800'"
                                            class="text-xs font-semibold rounded-lg px-4 py-2 shadow-md flex items-center gap-2 transition-all">
                                        <svg x-show="!showTools" class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                                        <svg x-show="showTools" class="w-4 h-4 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        <span x-text="showTools ? 'Tutup Alat Bantuan' : 'Buka Alat Bantuan (Tools)'"></span>
                                    </button>
                                </div>
                                
                                <!-- Toolbar Content -->
                                <div :class="showTools ? 'block' : 'hidden md:block'">
                                    @include('promo.promo_toolbar')
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- LOGO POSITIONING -->
                @if(str_starts_with($type, 'speaking'))
                    <div
                        class="hidden md:flex absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 justify-center pointer-events-none z-0">
                        <img src="{{ asset('images/company/TARGET.png') }}" alt="Target Bahasa"
                            class="h-20 w-auto object-contain pointer-events-auto">
                    </div>
                @endif

                <div class="hidden md:flex items-center gap-4 z-10 ml-auto shrink-0">
                    @if(!str_starts_with($type, 'speaking'))
                        <img src="{{ asset('images/company/TARGET.png') }}" alt="Target Bahasa"
                            class="h-10 md:h-16 w-auto object-contain mr-2">
                    @endif
                    <a href="{{ url('/') }}"
                        class="flex items-center gap-2 px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium rounded-lg transition-all whitespace-nowrap">
                        Exit
                    </a>
                </div>
            </div>
        </div>

        @if(str_starts_with($type, 'writing'))
            @include('promo.promo_panels')

            <!-- SPLIT SCREEN LAYOUT for Writing -->
            <div class="flex-1 relative overflow-y-auto overflow-x-hidden md:overflow-hidden flex flex-col md:flex-row w-full">

                <!-- LEFT PANEL: Instructions & Form -->
                <div
                    class="relative w-full md:w-2/5 md:overflow-y-auto bg-white border-b md:border-b-0 md:border-r border-gray-200 custom-scrollbar shrink-0 z-10">
                    <div class="px-4 md:px-8 py-6 md:py-8 max-w-2xl mx-auto" style="padding-bottom: 2rem;">
                        <!-- WRITING header -->
                        <div class="flex justify-center mb-8">
                            <span
                                class="text-xl font-bold bg-gray-900 text-white px-6 py-1.5 uppercase tracking-widest">WRITING</span>
                        </div>

                        <div class="mb-8 space-y-4 text-gray-800 text-[15px] leading-relaxed flex flex-col">
                            <div class="flex items-center justify-between" x-data="{ showAdminEditModal: false }">
                                <p class="font-bold text-base tracking-wide uppercase">
                                    {{ $type === 'writing_t1' ? 'WRITING TASK 1' : 'WRITING TASK 2' }}
                                </p>
                                @if(auth()->check() && auth()->user()->isAdmin() && $type === 'writing_t1')
                                    <button type="button" @click="showAdminEditModal = true"
                                        class="text-xs bg-indigo-100 text-indigo-700 hover:bg-indigo-200 px-3 py-1.5 rounded-full font-bold flex items-center gap-1 transition-colors z-10 relative">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                            </path>
                                        </svg>
                                        Edit Task
                                    </button>

                                    <template x-teleport="body">
                                        <div x-show="showAdminEditModal"
                                            class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-gray-900 bg-opacity-50"
                                            style="display: none;">
                                            <div @click.outside="showAdminEditModal = false"
                                                class="bg-white rounded-xl shadow-2xl w-full max-w-lg p-6 relative overflow-hidden flex flex-col max-h-[90vh]">
                                                <div class="flex justify-between items-center mb-4">
                                                    <h3 class="text-xl font-bold text-gray-800">Edit Task 1 (Admin)</h3>
                                                    <button @click="showAdminEditModal = false"
                                                        class="text-gray-400 hover:text-gray-600">
                                                        <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                        </svg>
                                                    </button>
                                                </div>

                                                <form
                                                    action="{{ route('promo.test.update.admin', ['type' => $type, 'id' => $id]) }}"
                                                    method="POST" enctype="multipart/form-data" class="overflow-y-auto pr-2">
                                                    @csrf

                                                    <div class="mb-4">
                                                        <label class="block text-sm font-bold text-gray-700 mb-1">Prompt
                                                            Text</label>
                                                        <textarea name="prompt" rows="4"
                                                            class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm p-3">{{ $test->prompt ?? '' }}</textarea>
                                                    </div>

                                                    <div class="mb-4">
                                                        <label class="block text-sm font-bold text-gray-700 mb-1">Upload
                                                            Diagram/Map (SVG/PNG/JPG)</label>
                                                        @if(isset($test->image) && $test->image)
                                                            <div class="mb-2 text-sm text-gray-500">
                                                                Current: <a href="{{ asset($test->image) }}" target="_blank"
                                                                    class="text-indigo-600 underline">View Image</a>
                                                            </div>
                                                        @endif
                                                        <input type="file" name="image" accept=".svg,.png,.jpg,.jpeg"
                                                            class="w-full border border-gray-300 rounded-lg p-2 text-sm">
                                                        <p class="text-xs text-gray-500 mt-1">Recommended: SVG format for
                                                            sharpest quality.</p>
                                                    </div>

                                                    <div class="mt-6 flex justify-end gap-3 border-t pt-4">
                                                        <button type="button" @click="showAdminEditModal = false"
                                                            class="px-4 py-2 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium text-sm">Cancel</button>
                                                        <button type="submit"
                                                            class="px-4 py-2 bg-indigo-600 text-white hover:bg-indigo-700 rounded-lg font-bold text-sm">Save
                                                            Changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </template>
                                @endif
                            </div>
                            <p>You should spend about {{ $type === 'writing_t1' ? '20' : '40' }} minutes on this task.</p>
                            @if($type === 'writing_t2')
                                <p>Write about the following topic:</p>
                            @endif

                            <div
                                class="border border-gray-800 p-5 font-bold italic bg-slate-100 shadow-sm mt-5 mb-5 md:mx-4 space-y-4 text-gray-900">
                                @if(isset($test->prompt))
                                    {!! nl2br(e($test->prompt)) !!}
                                @elseif(isset($test->questions) && is_array($test->questions))
                                    @foreach($test->questions as $q)
                                        <p>{{ $q }}</p>
                                    @endforeach
                                @else
                                    <p>No prompt available.</p>
                                @endif
                            </div>

                            @if(isset($test->image) && $test->image)
                                <div class="mt-8 mb-8 text-center flex justify-center">
                                    <img src="{{ asset($test->image) }}" alt="Task Image" class="max-w-full h-auto">
                                </div>
                            @elseif($test->id == 36)
                                <div class="mt-8 mb-8 relative w-full shrink-0" style="height: 350px; min-height: 350px;">
                                    <canvas id="promoChart"></canvas>
                                </div>
                                <script src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.umd.js"></script>
                                <script>
                                    setTimeout(() => {
                                        const ctx = document.getElementById('promoChart');
                                        if (ctx && typeof Chart !== 'undefined') {
                                            new Chart(ctx, {
                                                type: 'bar',
                                                data: {
                                                    labels: ['Science', 'Arts', 'Engineering', 'Business', 'IT'],
                                                    datasets: [
                                                        { label: '2010', data: [12000, 15000, 8000, 18000, 5000], backgroundColor: '#9ca3af' },
                                                        { label: '2020', data: [18000, 11000, 15000, 22000, 13000], backgroundColor: '#374151' }
                                                    ]
                                                },
                                                options: { responsive: true, maintainAspectRatio: false, plugins: { title: { display: true, text: 'University Subject Enrolments (2010 vs 2020)' } } }
                                            });
                                        }
                                    }, 500);
                                </script>
                            @endif

                            @if($type === 'writing_t2')
                                <p>Give reasons for your answer and include any relevant examples from your own knowledge or
                                    experience.</p>
                            @endif
                            <p class="mb-10 mt-6">Write at least {{ $type === 'writing_t1' ? '150' : '250' }} words.</p>
                        </div>

                        <div class="mt-12 pt-8 border-t border-gray-200 shrink-0">
                            <h3 class="font-bold text-gray-800 mb-6 uppercase tracking-wide">Your Information</h3>
                            <div class="space-y-5">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Full Name</label>
                                    <input type="text" x-model="form.name" required
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="John Doe">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                                    <input type="email" x-model="form.email" required
                                        class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-indigo-500 focus:ring-indigo-500"
                                        placeholder="john@example.com">
                                </div>
                            </div>
                            <div class="mt-8 pt-6 pb-8 border-t border-gray-100 flex flex-col items-center">
                                <a href="{{ url('/brochure/' . (request('b') ?: 'offline')) }}" target="_blank"
                                    class="inline-flex items-center gap-2 text-sm text-red-600 hover:text-red-700 transition-colors group">
                                    <svg class="w-4 h-4 text-red-500 group-hover:text-red-600" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span
                                        class="font-medium underline decoration-transparent group-hover:decoration-red-300 underline-offset-4 transition-all">Informasi
                                        Kelas IELTS Target Bahasa</span>
                                    <svg class="w-3.5 h-3.5 opacity-0 -ml-1 group-hover:opacity-100 group-hover:ml-0 transform group-hover:-translate-y-0.5 group-hover:translate-x-0.5 transition-all"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                        </path>
                                    </svg>
                                </a>
                                <div class="mt-3 text-xs text-gray-500 text-center">
                                    <p>Jalan Brawijaya 64 Pare Kediri - Kampung Inggris Pare</p>
                                    <p class="mt-1 text-green-600 font-bold text-sm">WhatsApp 0857 0661 5607</p>
                                </div>
                                <div class="mt-6 cf-turnstile" data-sitekey="{{ env('TURNSTILE_SITE_KEY') }}"
                                    data-action="submit"
                                    data-callback="onTurnstileVerified"
                                    data-expired-callback="onTurnstileExpired"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT PANEL: Editor & Feedback -->
                <div
                    class="relative w-full md:w-3/5 overflow-y-visible md:overflow-y-auto bg-gray-50 custom-scrollbar flex flex-col flex-1 min-h-[600px] md:min-h-0">
                    <div class="px-4 md:px-4 py-6 flex-1 flex flex-col w-full h-full md:min-h-full">
                        <form @submit.prevent="submitTest"
                            class="flex-1 flex flex-col bg-white rounded-2xl shadow-sm border border-gray-200 relative mb-6 h-full">
                            @csrf

                            <!-- Toolbar Area -->
                            <div
                                class="flex items-center justify-between border-b border-gray-200 px-6 py-4 bg-gray-50/50 rounded-t-2xl shrink-0 flex-wrap gap-4">
                                <div class="flex items-center gap-4">
                                    <h3 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Your Answer
                                        ({{ $type === 'writing_t1' ? 'Task 1' : 'Task 2' }})</h3>

                                    <template x-if="isAdmin">
                                        <div
                                            class="flex items-center gap-2 bg-purple-100 px-3 py-1.5 rounded-lg border border-purple-200">
                                            <select x-model="adminTargetBand"
                                                class="w-24 text-xs border-purple-300 rounded-md shadow-sm focus:border-purple-500 focus:ring-purple-500 bg-white text-purple-900 py-1 font-bold text-center">
                                                <option value="2.0">B 2.0</option>
                                                <option value="2.5">B 2.5</option>
                                                <option value="3.0">B 3.0</option>
                                                <option value="3.5">B 3.5</option>
                                                <option value="4.0">B 4.0</option>
                                                <option value="4.5">B 4.5</option>
                                                <option value="5.0">B 5.0</option>
                                                <option value="5.5">B 5.5</option>
                                                <option value="6.0">B 6.0</option>
                                                <option value="6.5">B 6.5</option>
                                                <option value="7.0">B 7.0</option>
                                                <option value="7.5">B 7.5</option>
                                                <option value="8.0">B 8.0</option>
                                                <option value="8.5">B 8.5</option>
                                                <option value="9.0">B 9.0</option>
                                            </select>
                                            <button type="button" @click="adminDebugSubmit"
                                                class="inline-flex justify-center items-center gap-1 py-1 px-2 rounded-md shadow-sm text-xs font-semibold text-white bg-purple-600 hover:bg-purple-700 focus:outline-none transition-colors whitespace-nowrap">
                                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                </svg>
                                                Auto Eval
                                            </button>
                                        </div>
                                    </template>
                                </div>
                                <div class="text-sm text-gray-500 font-medium flex items-center gap-4">
                                    <button type="button" @click="resetWriting()"
                                        class="text-gray-400 hover:text-gray-600 transition-colors p-1"
                                        title="Restart test">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                    </button>
                                    <div class="flex items-center gap-1.5 px-3 py-1 rounded-lg"
                                        :class="timeLeft <= 300 && timeLeft > 0 ? 'text-red-600 bg-red-50 animate-pulse' : (timeLeft === 0 ? 'text-red-600 bg-red-50' : (timeLeft <= 900 ? 'text-yellow-600 bg-yellow-50' : 'text-gray-700 bg-gray-100'))">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span class="font-mono font-bold tracking-wider" x-text="formattedTime"></span>
                                    </div>
                                    <div>
                                        <span x-show="(form.answer_text || '').length > 0"
                                            class="text-green-600 font-semibold flex items-center gap-1 inline-flex"><span
                                                class="w-2 h-2 rounded-full bg-green-500"></span> Writing...</span>
                                        <span x-show="(form.answer_text || '').length === 0"
                                            class="flex items-center gap-1 inline-flex"><span
                                                class="w-2 h-2 rounded-full bg-gray-400"></span> Not started</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Textarea -->
                            <div class="flex-1 relative bg-transparent min-h-[300px] md:min-h-[400px]">
                                <textarea x-show="!msOpen" x-model="form.answer_text" @input="startWritingTimerIfTyping()"
                                    required
                                    class="absolute inset-0 w-full h-full p-6 resize-none border-none focus:ring-0 focus:outline-none text-gray-800 text-base leading-relaxed bg-transparent custom-scrollbar"
                                    placeholder="Type your answer here..." spellcheck="false"
                                    :disabled="isSubmitting || timeLeft === 0"></textarea>

                                <!-- Mirror Overlay for Magic Sentence -->
                                <div x-show="msOpen" x-cloak
                                    class="absolute inset-0 w-full h-full z-10 bg-white rounded-xl">

                                    <!-- Floating Toast Explanation (bottom center) -->
                                    <div class="absolute bottom-4 inset-x-0 flex justify-center pointer-events-none z-20">
                                        <div
                                            class="bg-gray-900 bg-opacity-90 text-white px-4 py-2 rounded-full shadow-lg text-[11px] sm:text-xs flex items-center gap-2 backdrop-blur-sm transition-opacity">
                                            <svg class="w-3.5 h-3.5 text-blue-300" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                            </svg>
                                            <span class="text-white"><strong>Magic Sentence:</strong> Ketik B. Indonesia →
                                                tekan <kbd
                                                    class="bg-gray-700 text-white rounded px-1 font-mono">Ctrl+Enter</kbd> /
                                                <kbd class="bg-gray-700 text-white rounded px-1 font-mono">Cmd+Return</kbd>
                                                untuk translate ke gaya IELTS.</span>
                                        </div>
                                    </div>

                                    <!-- Content Area — identical to textarea padding & typography -->
                                    <div class="absolute inset-0 w-full h-full p-6 text-gray-800 text-base leading-relaxed overflow-y-auto whitespace-pre-wrap break-words custom-scrollbar cursor-text"
                                        style="-webkit-user-select: auto; user-select: auto;"
                                        @click="if($refs.msInput) { 
                                            $refs.msInput.focus(); 
                                            try {
                                                let sel = window.getSelection();
                                                let range = document.createRange();
                                                range.selectNodeContents($refs.msInput);
                                                range.collapse(false);
                                                sel.removeAllRanges();
                                                sel.addRange(range);
                                            } catch(e) {}
                                        }"><span x-text="form.answer_text"></span><span x-ref="msInput" contenteditable="true" inputmode="text"
                                            style="-webkit-user-select: text; user-select: text;"
                                            class="outline-none border-b-2 border-dashed border-blue-400 bg-blue-50 text-blue-900 empty:before:content-[attr(data-placeholder)] empty:before:text-blue-300 cursor-text inline"
                                            data-placeholder="Ketik kalimat di sini..."
                                            @keydown.enter.ctrl.prevent="msText = $el.innerText; translateSentence()"
                                            @keydown.enter.meta.prevent="msText = $el.innerText; translateSentence()"
                                            @input="msText = $el.innerText; if(!timerStarted) startWritingTimer()"></span><button
                                            type="button" x-show="msText.trim().length > 0 && !msLoading"
                                            @click.stop="if($refs.msInput) { msText = $refs.msInput.innerText; translateSentence(); }"
                                            class="inline-flex items-center justify-center w-4 h-4 ml-0.5 bg-blue-500 hover:bg-blue-600 text-white rounded shadow-sm transition-transform hover:scale-110 focus:outline-none align-baseline"
                                            title="Translate (Ctrl+Enter / Cmd+Enter)">
                                            <svg class="w-2.5 h-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                    d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                            </svg>
                                        </button><span x-show="msLoading"
                                            class="inline-flex items-center ml-1 text-blue-500 align-baseline">
                                            <svg class="animate-spin w-3.5 h-3.5" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                    stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                        </span>
                                    </div>
                                </div>

                                <!-- Magic Sentence Teleport Target -->
                                <div id="magic-sentence-container"></div>
                            </div>

                            <!-- Footer area -->
                            <div
                                class="border-t border-gray-200 px-6 py-4 pb-20 md:pb-4 bg-gray-50 rounded-b-2xl flex items-center justify-between shrink-0 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
                                <div class="flex flex-col">
                                    <span class="text-2xl font-bold text-gray-700 font-mono" x-text="wordCount">0</span>
                                    <span class="text-xs text-gray-400 font-medium uppercase tracking-wider">Words</span>
                                </div>
                                <div
                                    class="hidden md:block text-xs text-white bg-gray-900 px-3 py-1.5 rounded-full font-medium shadow-sm">
                                    Anda akan langsung mendapatkan Feedback
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="text-xs text-gray-500 italic max-w-[200px] text-right">*Tombol Submit akan
                                        aktif jika "Your Information" dan jawaban sudah terisi.</span>
                                    <button type="submit"
                                        :disabled="isSubmitting || form.answer_text.length === 0 || form.name === '' || form.email === ''"
                                        class="px-6 py-2.5 bg-blue-500 hover:bg-blue-600 text-white font-semibold rounded-lg shadow-sm transition-all focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 flex items-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed">
                                        <svg x-show="isSubmitting" class="animate-spin h-5 w-5 text-white"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                        <span x-text="isSubmitting ? 'Evaluating...' : 'Submit & Get Feedback'"></span>
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div x-show="errorMessage" x-cloak
                            class="mt-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg shrink-0">
                            <p class="font-bold">Error</p>
                            <p x-text="errorMessage"></p>
                            <button type="button" x-show="retryableSubmissionId" @click="retrySubmission()"
                                :disabled="isSubmitting"
                                class="mt-3 px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 disabled:opacity-50">
                                <span x-text="isSubmitting ? 'Mengirim ulang...' : 'Coba Kirim Ulang'"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        @else
            <!-- STANDARD LAYOUT FOR SPEAKING / OTHERS -->
            <div
                class="{{ str_starts_with($type, 'speaking') ? 'max-w-5xl' : 'max-w-2xl' }} mx-auto px-4 w-full py-8 flex-1 overflow-y-auto">
                <div class="bg-white rounded-[28px] shadow-md border border-slate-200 overflow-hidden">
                    <div
                        class="p-6 md:p-8 {{ str_starts_with($type, 'speaking') ? 'grid md:grid-cols-12 gap-8 items-start' : 'space-y-6' }}">

                        @if(str_starts_with($type, 'speaking'))
                            <!-- LEFT COLUMN: Avatar -->
                            <div
                                class="md:col-span-5 lg:col-span-4 flex flex-col items-center space-y-6 md:sticky md:top-6 border-b md:border-b-0 md:border-r border-gray-200 pb-6 md:pb-0 md:pr-6">
                                <div class="relative w-56 h-56 sm:w-80 sm:h-80 shrink-0 transition-all duration-300 transform">
                                    <div class="w-full h-full rounded-2xl flex items-center justify-center overflow-hidden shadow-lg border-4 transition-colors duration-300"
                                        :class="isTTSSpeaking ? 'border-blue-500' : (['af_heart', 'af_nova', 'af_sky', 'bf_emma'].includes(examinerVoice) ? 'border-pink-100 bg-pink-50' : 'border-blue-100 bg-blue-50')">
                                        <template x-if="echomimicVideoUrl">
                                            <video :src="echomimicVideoUrl" autoplay playsinline @ended="videoEnded()"
                                                class="w-full h-full object-cover transition-opacity duration-300"></video>
                                        </template>
                                        <template x-if="!echomimicVideoUrl">
                                            <img :src="['af_heart', 'af_nova', 'af_sky', 'bf_emma'].includes(examinerVoice) ? '{{ asset('images/promo/hallo_avatar.png') }}' : '{{ asset('images/promo/male_avatar.png') }}'"
                                                alt="Examiner Avatar"
                                                class="w-full h-full object-cover transition-opacity duration-300" />
                                        </template>
                                    </div>



                                    <div
                                        class="absolute -bottom-2 -right-2 bg-red-500 text-white text-[10px] font-bold px-2 py-1 rounded-full border-2 border-white shadow flex items-center gap-1 animate-pulse z-20">
                                        <div class="w-1.5 h-1.5 bg-white rounded-full"></div> LIVE
                                    </div>
                                </div>
                                <div class="flex flex-col text-center">
                                    <span
                                        class="text-2xl font-extrabold text-gray-900 tracking-tight leading-none mb-2 uppercase">AI
                                        EXAMINER</span>
                                    <span
                                        class="text-xs font-bold px-3 py-1 mx-auto rounded uppercase tracking-wider w-max shadow-sm transition-colors duration-300"
                                        :class="isTTSSpeaking ? 'bg-blue-600 text-white border-blue-600 animate-pulse' : (['af_heart', 'af_nova', 'af_sky', 'bf_emma'].includes(examinerVoice) ? 'bg-pink-100 text-pink-700 border border-pink-200' : 'bg-blue-100 text-blue-700 border border-blue-200')"
                                        x-text="isTTSSpeaking ? 'Speaking...' : (['af_heart', 'af_nova', 'af_sky', 'bf_emma'].includes(examinerVoice) ? 'Female Voice' : 'Male Voice')">
                                    </span>
                                </div>
                                <div class="w-full text-left">
                                    <label
                                        class="block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wide">Examiner
                                        Voice</label>
                                    <select x-model="examinerVoice" @change="saveData(); if(!showBeginScreen) speakQuestion()"
                                        class="w-full text-sm border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500 bg-gray-50 text-gray-700 py-2 cursor-pointer">
                                        <optgroup label="Female Voices">
                                            <option value="af_heart">American Female (Heart)</option>
                                            <option value="af_nova">American Female (Nova)</option>
                                            <option value="af_sky">American Female (Sky)</option>
                                            <option value="bf_emma">British Female (Emma)</option>
                                        </optgroup>
                                        <optgroup label="Male Voices">
                                            <option value="am_echo">American Male (Echo)</option>
                                            <option value="am_michael">American Male (Michael)</option>
                                            <option value="bm_george">British Male (George)</option>
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                        @endif

                        <!-- RIGHT COLUMN: Questions & Form -->
                        <div
                            class="{{ str_starts_with($type, 'speaking') ? 'md:col-span-7 lg:col-span-8 flex flex-col space-y-6' : 'space-y-6 w-full' }}">
                            @if(!str_starts_with($type, 'speaking'))
                                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between mb-4">
                                    <div class="flex items-center gap-5 sm:justify-start justify-center w-full sm:w-auto">
                                        <div
                                            class="relative w-32 h-32 sm:w-40 sm:h-40 shrink-0 transition-all duration-300 transform">
                                            <div class="w-full h-full rounded-2xl flex items-center justify-center overflow-hidden shadow-lg border-4 transition-colors duration-300"
                                                :class="isTTSSpeaking ? 'border-blue-500' : 'border-blue-100 bg-blue-50'">
                                                <img :src="['af_heart', 'af_nova', 'af_sky', 'bf_emma'].includes(examinerVoice) ? '{{ asset('images/promo/hallo_avatar.png') }}' : '{{ asset('images/promo/male_avatar.png') }}'"
                                                    alt="Examiner Avatar"
                                                    class="w-full h-full object-cover transition-opacity duration-300" />
                                            </div>
                                        </div>
                                        <div class="flex flex-col text-left">
                                            <span
                                                class="text-2xl font-extrabold text-gray-900 tracking-tight leading-none mb-2 uppercase">EXAMINER</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- PRACTICE AREA WRAPPER -->
                            <div class="relative rounded-2xl">
                                <!-- Begin Screen Overlay -->
                                <div x-show="showBeginScreen" x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                                    class="absolute inset-0 z-30 flex flex-col items-center pt-16 bg-white/95 backdrop-blur-sm rounded-2xl">
                                    <div class="flex flex-col items-center gap-6 p-8 text-center max-w-sm sticky top-10">
                                        <!-- Speaker icon -->
                                        <div
                                            class="w-24 h-24 rounded-full bg-blue-100 flex items-center justify-center shadow-lg">
                                            <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15.536 8.464a5 5 0 010 7.072m2.828-9.9a9 9 0 010 12.728M5.586 15H4a1 1 0 01-1-1v-4a1 1 0 011-1h1.586l4.707-4.707C10.923 3.663 12 4.109 12 5v14c0 .891-1.077 1.337-1.707.707L5.586 15z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="text-2xl font-bold text-gray-800 mb-2">Ready to practice?</h3>
                                            <p class="text-gray-500 text-sm mb-4">Click begin to start your speaking
                                                practice.<br>Make sure your microphone is ready.</p>
                                        </div>
                                        <button type="button" @click="beginPractice()"
                                            class="w-full py-4 px-8 bg-blue-500 hover:bg-blue-600 text-white text-lg font-bold rounded-2xl shadow-lg hover:shadow-xl transform hover:scale-105 transition-all flex items-center justify-center gap-3">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Begin
                                        </button>
                                    </div>
                                </div>

                                <!-- Countdown Overlay -->
                                <div x-show="ttsCountdown > 0" x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 scale-50"
                                    x-transition:enter-end="opacity-100 scale-100"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100 scale-100"
                                    x-transition:leave-end="opacity-0 scale-150"
                                    class="absolute inset-0 z-40 flex items-center justify-center bg-white/90 backdrop-blur-sm rounded-2xl pointer-events-none">
                                    <span class="text-6xl font-black text-blue-500 animate-pulse"
                                        x-text="ttsCountdown"></span>
                                </div>

                                <!-- PROMPT/QUESTION -->
                                <div x-data="{ showPrompt: false }" class="mb-6">
                                    <div x-show="activeTab !== 'part2'" class="flex justify-center mb-4">
                                        <button type="button" @click="showPrompt = !showPrompt"
                                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-white border border-gray-300 border-dashed rounded-full text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none transition-colors">
                                            <svg x-show="!showPrompt" class="w-5 h-5 text-gray-500" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                            <svg x-show="showPrompt" class="w-5 h-5 text-gray-500" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21">
                                                </path>
                                            </svg>
                                            <span x-text="showPrompt ? 'Hide Question Text' : 'Show Question Text'"></span>
                                        </button>
                                    </div>

                                    <div x-show="showPrompt || activeTab === 'part2'" x-collapse>
                                        <div
                                            class="border-2 border-gray-800 p-5 font-bold italic bg-white shadow-sm space-y-4 text-gray-800">
                                            @if(str_starts_with($type, 'speaking'))
                                                <!-- Tabs Header -->
                                                <div class="flex space-x-2 border-b border-gray-200 mb-6">
                                                    <button type="button"
                                                        @click="if(isAdmin) { activeTab = 'part1'; speakCurrent() }"
                                                        :class="activeTab === 'part1' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 ' + (isAdmin ? 'hover:text-gray-700 hover:border-gray-300' : 'opacity-70 cursor-not-allowed')"
                                                        class="whitespace-nowrap pb-4 px-4 border-b-2 font-medium text-sm transition-colors"
                                                        :disabled="!isAdmin" title="Only Admin can switch parts manually">Part
                                                        1</button>
                                                    <button type="button"
                                                        @click="if(isAdmin) { if(!recordings['part2_0']) { startPart2Flow(); } else { activeTab = 'part2'; part2State = 'idle'; speakCurrent(); } }"
                                                        :class="activeTab === 'part2' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 ' + (isAdmin ? 'hover:text-gray-700 hover:border-gray-300' : 'opacity-70 cursor-not-allowed')"
                                                        class="whitespace-nowrap pb-4 px-4 border-b-2 font-medium text-sm transition-colors"
                                                        :disabled="!isAdmin" title="Only Admin can switch parts manually">Part
                                                        2</button>
                                                    <button type="button"
                                                        @click="if(isAdmin) { activeTab = 'part3'; speakCurrent() }"
                                                        :class="activeTab === 'part3' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 ' + (isAdmin ? 'hover:text-gray-700 hover:border-gray-300' : 'opacity-70 cursor-not-allowed')"
                                                        class="whitespace-nowrap pb-4 px-4 border-b-2 font-medium text-sm transition-colors"
                                                        :disabled="!isAdmin" title="Only Admin can switch parts manually">Part
                                                        3</button>
                                                </div>

                                                <!-- Part 1 Content -->
                                                <div x-show="activeTab === 'part1'" class="mb-6">
                                                    <h4 class="text-lg font-black text-gray-900 not-italic mb-3">Part 1: General
                                                        Questions</h4>
                                                    <template x-if="part1Questions.length > 0">
                                                        <div class="bg-blue-50 p-6 rounded-2xl border border-blue-100">
                                                            <p class="text-xl font-medium text-blue-900"
                                                                x-text="part1Questions[part1Index]"></p>
                                                        </div>
                                                    </template>
                                                </div>

                                                <!-- Part 2 Content -->
                                                <div x-show="activeTab === 'part2'" class="mb-6" style="display: none;">

                                                    <!-- Intro Banner -->
                                                    <div x-show="part2State === 'intro'"
                                                        class="bg-blue-100 p-8 rounded-2xl text-center shadow-inner">
                                                        <h3 class="text-2xl font-bold text-blue-900 mb-4">Kita akan melanjutkan
                                                            ke Part 2</h3>
                                                        <p class="text-blue-800 font-medium">Anda akan mendapatkan waktu
                                                            persiapan 1 menit untuk mempersiapkan membicarakan daftar pertanyaan
                                                            berikut.<br>Kemudian, Anda akan berbicara 1-2 menit.</p>
                                                        <p class="text-5xl font-black text-blue-600 mt-6"
                                                            x-text="part2IntroTimeLeft"></p>
                                                    </div>

                                                    <div x-show="part2State !== 'intro'">
                                                        <h4 class="text-lg font-black text-gray-900 not-italic mb-3">Part 2: Cue
                                                            Card</h4>

                                                        <div x-show="part2State === 'prep'"
                                                            class="mb-4 bg-amber-50 border border-amber-200 text-amber-800 p-4 rounded-xl flex items-center justify-between shadow-sm">
                                                            <div class="font-bold flex items-center gap-2">
                                                                <svg class="w-5 h-5 animate-pulse" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                                </svg>
                                                                Preparation Time
                                                            </div>
                                                            <div class="text-2xl font-black"
                                                                x-text="formatPart2Time(part2PrepTimeLeft)"></div>
                                                        </div>

                                                        <div x-show="part2State === 'transition'"
                                                            class="mb-4 bg-red-500 text-white p-4 rounded-xl text-center shadow-lg transform scale-105 transition-all">
                                                            <div class="font-bold text-lg mb-1">Recording starting in...</div>
                                                            <div class="text-5xl font-black" x-text="part2TransitionTimeLeft">
                                                            </div>
                                                        </div>

                                                        <div
                                                            class="bg-gray-50 p-6 rounded-2xl border border-gray-200 shadow-inner">
                                                            <template x-for="(q, index) in part2Questions" :key="index">
                                                                <div>
                                                                    <template x-if="index === 0">
                                                                        <p class="font-bold text-gray-900 mb-4 text-lg"
                                                                            x-text="q"></p>
                                                                    </template>
                                                                    <template x-if="index > 0 && q.trim().startsWith('-')">
                                                                        <p class="ml-6 text-gray-700 mb-2 flex items-start">
                                                                            <span class="mr-2 text-gray-400">•</span> <span
                                                                                x-text="q.replace(/^- /, '')"></span>
                                                                        </p>
                                                                    </template>
                                                                    <template x-if="index > 0 && !q.trim().startsWith('-')">
                                                                        <p class="mt-6 text-gray-800 font-medium italic"
                                                                            x-text="q"></p>
                                                                    </template>
                                                                </div>
                                                            </template>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Part 3 Content -->
                                                <div x-show="activeTab === 'part3'" style="display: none;">
                                                    <h4 class="text-lg font-black text-gray-900 not-italic mb-3">Part 3:
                                                        Follow-up Questions</h4>
                                                    <template x-if="part3Questions.length > 0">
                                                        <div class="bg-purple-50 p-6 rounded-2xl border border-purple-100">
                                                            <p class="text-xl font-medium text-purple-900"
                                                                x-text="part3Questions[part3Index]"></p>
                                                        </div>
                                                    </template>
                                                </div>
                                            @else
                                                @if(isset($test->prompt))
                                                    {!! nl2br(e($test->prompt)) !!}
                                                @elseif(isset($test->questions))
                                                    @php
                                                        $questionsArray = is_string($test->questions) ? json_decode($test->questions, true) : $test->questions;
                                                    @endphp
                                                    @if(is_array($questionsArray))
                                                        @foreach($questionsArray as $q)
                                                            <p>{{ $q }}</p>
                                                        @endforeach
                                                    @else
                                                        <p>No prompt available.</p>
                                                    @endif
                                                @else
                                                    <p>No prompt available.</p>
                                                @endif
                                            @endif

                                            @if(isset($test->image) && $test->image)
                                                <div class="mt-4">
                                                    <img src="{{ asset($test->image) }}" alt="Task Image"
                                                        class="max-w-full h-auto rounded-2xl shadow-sm">
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Buttons moved down -->
                                </div>

                                <!-- TEST FORM -->
                                <form @submit.prevent="submitTest" class="space-y-6">
                                    @csrf

                                    <!-- SPEAKING INPUT -->
                                    <div>
                                        @if(str_starts_with($type, 'speaking'))
                                            <div class="mb-6 flex flex-wrap md:flex-nowrap items-center justify-between gap-2">
                                                <div class="flex items-center gap-1.5 md:gap-3">
                                                    <button type="button" @click="isCollocationsOpen = !isCollocationsOpen"
                                                        class="inline-flex items-center justify-center w-10 h-10 md:w-auto md:h-auto md:px-6 md:py-2 bg-white hover:bg-gray-50 text-gray-700 font-bold rounded-xl md:text-sm transition-colors shadow-sm border border-gray-300 shrink-0" title="Collocations">
                                                        <svg class="md:hidden w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path></svg>
                                                        <span class="hidden md:inline">Collocations</span>
                                                    </button>
                                                    <button type="button" @click="isIdiomsOpen = !isIdiomsOpen"
                                                        class="inline-flex items-center justify-center w-10 h-10 md:w-auto md:h-auto md:px-6 md:py-2 bg-white hover:bg-gray-50 text-gray-700 font-bold rounded-xl md:text-sm transition-colors shadow-sm border border-gray-300 shrink-0" title="Idioms">
                                                        <svg class="md:hidden w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                                        <span class="hidden md:inline">Idioms</span>
                                                    </button>
                                                    @include('promo.dictionary_modal', ['buttonClass' => 'inline-flex items-center justify-center w-10 h-10 md:w-auto md:h-auto md:px-6 md:py-2 bg-white hover:bg-gray-50 text-gray-700 font-bold rounded-xl md:text-sm transition-colors shadow-sm border border-gray-300 shrink-0', 'hideTextOnMobile' => true])
                                                    <button type="button" @click="openIdeasPanel()"
                                                        class="inline-flex items-center justify-center w-10 h-10 md:w-auto md:h-auto md:px-6 md:py-2 bg-white hover:bg-gray-50 text-gray-700 font-bold rounded-xl md:text-sm transition-colors shadow-sm border border-gray-300 shrink-0" title="Idea">
                                                        <svg class="md:hidden w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"></path></svg>
                                                        <span class="hidden md:inline">Idea</span>
                                                    </button>
                                                </div>
                                                <div x-show="hasNext()" class="ml-auto">
                                                    <button type="button" @click="advanceNext()" :disabled="!currentAudioUrl"
                                                        class="px-4 md:px-6 py-2 md:py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold shadow-md transition-all flex items-center gap-1 md:gap-2 disabled:opacity-50 disabled:cursor-not-allowed shrink-0"
                                                        title="Record an answer before moving to the next question">
                                                        <span class="md:hidden">Next</span>
                                                        <span class="hidden md:inline">Next Question</span>
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                        @endif

                                        <label class="block text-sm font-medium text-gray-900 mb-4"
                                            x-text="type === 'speaking' ? 'Record Answer for ' + (activeTab === 'part1' ? 'Part 1, Q' + (part1Index + 1) : (activeTab === 'part2' ? 'Part 2' : 'Part 3, Q' + (part3Index + 1))) : 'Record Your Answer'">Record
                                            Your Answer</label>
                                        <div
                                            class="flex flex-col items-center justify-center p-8 border-2 border-dashed border-gray-300 rounded-3xl bg-slate-50">

                                            <!-- Part 2 Custom Recording Block -->
                                            <template x-if="activeTab === 'part2'">
                                                <div class="w-full">
                                                    <div x-show="part2State === 'intro' || part2State === 'prep' || part2State === 'transition'"
                                                        class="text-center w-full text-gray-500 italic">
                                                        Recording will start automatically...
                                                    </div>

                                                    <div x-show="part2State === 'recording'"
                                                        class="text-center w-full mb-4">
                                                        <div
                                                            class="inline-flex flex-col items-center bg-red-50 border border-red-100 p-6 rounded-2xl w-full">
                                                            <div
                                                                class="text-red-600 font-bold mb-2 uppercase tracking-wider text-sm flex items-center gap-2">
                                                                <span
                                                                    class="w-3 h-3 bg-red-500 rounded-full animate-pulse"></span>
                                                                Recording Now
                                                            </div>
                                                            <div class="text-4xl font-black text-red-700 mb-6"
                                                                x-text="formatPart2Time(part2RecordTimeLeft)"></div>
                                                            <button type="button" @click="stopPart2Recording()"
                                                                class="px-8 py-3 bg-red-600 hover:bg-red-700 text-white rounded-full font-bold shadow-md transition-all flex items-center gap-2 mx-auto">
                                                                <svg class="w-5 h-5" fill="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <rect x="6" y="6" width="12" height="12" rx="2"></rect>
                                                                </svg>
                                                                Stop Recording
                                                            </button>
                                                        </div>
                                                    </div>

                                                    <div x-show="part2State === 'idle'">
                                                        <div x-show="!currentAudioUrl" class="text-center w-full">
                                                            <p class="text-gray-500 italic mb-4">Click below to manually
                                                                start recording for Part 2 if you didn't finish it.</p>
                                                            <button type="button" @click="startPart2Recording()"
                                                                class="mx-auto w-20 h-20 rounded-full flex items-center justify-center transition-all shadow-md focus:outline-none focus:ring-4 focus:ring-offset-2 border-4 bg-white text-gray-800 border-gray-800 hover:bg-gray-100 focus:ring-gray-500">
                                                                <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                                                    viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                                                                    </path>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                        <div x-show="currentAudioUrl"
                                                            class="w-full max-w-md mx-auto text-center">
                                                            <audio :src="currentAudioUrl" controls
                                                                class="w-full mb-4"></audio>
                                                            <button type="button" @click="resetRecording"
                                                                class="text-sm text-red-600 hover:text-red-800 font-medium">
                                                                <svg class="w-4 h-4 inline mr-1" fill="none"
                                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        stroke-width="2"
                                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                    </path>
                                                                </svg>
                                                                Delete and Record Again
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>

                                            <!-- Normal Recording Block for Part 1 and Part 3 -->
                                            <template x-if="activeTab !== 'part2'">
                                                <div class="w-full">
                                                    <div x-show="!currentAudioUrl" class="text-center w-full">
                                                        <button type="button" @click="toggleRecording"
                                                            class="mx-auto w-20 h-20 rounded-full flex items-center justify-center transition-all shadow-md focus:outline-none focus:ring-4 focus:ring-offset-2 border-4"
                                                            :class="isRecording ? 'bg-black text-white border-black animate-pulse focus:ring-gray-500' : 'bg-white text-gray-800 border-gray-800 hover:bg-gray-100 focus:ring-gray-500'">
                                                            <svg x-show="!isRecording" class="w-8 h-8" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                                                                </path>
                                                            </svg>
                                                            <svg x-show="isRecording" class="w-8 h-8" fill="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <rect x="6" y="6" width="12" height="12" rx="2"></rect>
                                                            </svg>
                                                        </button>
                                                        <p class="mt-4 text-sm font-medium"
                                                            :class="isRecording ? 'text-red-600' : 'text-gray-600'"
                                                            x-text="isRecording ? 'Recording... Click to stop' : 'Click to start recording'">
                                                        </p>
                                                    </div>
                                                    <div x-show="currentAudioUrl"
                                                        class="w-full max-w-md mx-auto text-center">
                                                        <audio :src="currentAudioUrl" controls class="w-full mb-4"></audio>
                                                        <button type="button" @click="resetRecording"
                                                            class="text-sm text-red-600 hover:text-red-800 font-medium">
                                                            <svg class="w-4 h-4 inline mr-1" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                </path>
                                                            </svg>
                                                            Delete and Record Again
                                                        </button>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>

                                    <div class="mt-4 flex flex-col items-center">
                                        <button type="submit"
                                            :disabled="isSubmitting || form.name === '' || form.email === '' || (type === 'speaking' && Object.keys(recordings).length === 0)"
                                            class="w-full inline-flex justify-center items-center gap-2 py-3 px-4 rounded-2xl shadow-lg text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors disabled:opacity-60 disabled:cursor-not-allowed">
                                            <svg x-show="isSubmitting" class="animate-spin -ml-1 h-5 w-5 text-white"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                    stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                                </path>
                                            </svg>
                                            <span
                                                x-text="isSubmitting ? 'Evaluating...' : 'Submit & Get Instant Feedback'"></span>
                                        </button>

                                        <template x-if="isAdmin">
                                            <div
                                                class="mt-4 p-4 border border-purple-200 bg-purple-50 rounded-2xl flex flex-col items-center gap-3">
                                                <label class="text-sm font-semibold text-purple-800">Admin: Dummy Band
                                                    Score</label>
                                                <select x-model="adminTargetBand"
                                                    class="w-full max-w-xs text-sm border-purple-300 rounded-xl shadow-sm focus:border-purple-500 focus:ring-purple-500 bg-white text-purple-900 py-2 cursor-pointer font-bold text-center">
                                                    <option value="2.0">Band 2.0</option>
                                                    <option value="2.5">Band 2.5</option>
                                                    <option value="3.0">Band 3.0</option>
                                                    <option value="3.5">Band 3.5</option>
                                                    <option value="4.0">Band 4.0</option>
                                                    <option value="4.5">Band 4.5</option>
                                                    <option value="5.0">Band 5.0</option>
                                                    <option value="5.5">Band 5.5</option>
                                                    <option value="6.0">Band 6.0</option>
                                                    <option value="6.5">Band 6.5</option>
                                                    <option value="7.0">Band 7.0</option>
                                                    <option value="7.5">Band 7.5</option>
                                                    <option value="8.0">Band 8.0</option>
                                                    <option value="8.5">Band 8.5</option>
                                                    <option value="9.0">Band 9.0</option>
                                                </select>
                                                <button type="button" @click="adminDebugSubmit"
                                                    class="w-full inline-flex justify-center items-center gap-2 py-3 px-4 rounded-xl shadow-sm text-sm font-semibold text-purple-700 bg-purple-100 hover:bg-purple-200 focus:outline-none transition-colors border border-purple-200">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                                    </svg>
                                                    [ADMIN] Auto Fill & Skip to Evaluation
                                                </button>
                                            </div>
                                        </template>

                                        <span class="text-xs text-slate-500 italic text-center mt-3">*Tombol Submit akan
                                            aktif jika "Your Information" dan rekaman suara sudah terisi.</span>
                                    </div>

                                    <div class="pt-6 border-t border-slate-200 mt-6">
                                        <h3 class="text-base font-bold text-gray-900 mb-4">Your Information</h3>
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 mb-2">Full
                                                    Name</label>
                                                <input type="text" x-model="form.name" required
                                                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                                                    placeholder="John Doe">
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                                                <input type="email" x-model="form.email" required
                                                    class="w-full rounded-2xl border border-slate-300 bg-white px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:outline-none"
                                                    placeholder="john@example.com">
                                            </div>
                                        </div>
                                        <div class="mt-8 pt-6 pb-2 border-t border-gray-100 flex flex-col items-center">
                                            <a href="{{ url('/brochure/' . (request('b') ?: 'offline')) }}" target="_blank"
                                                class="inline-flex items-center gap-2 text-sm text-red-600 hover:text-red-700 transition-colors group">
                                                <svg class="w-4 h-4 text-red-500 group-hover:text-red-600" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                    </path>
                                                </svg>
                                                <span
                                                    class="font-medium underline decoration-transparent group-hover:decoration-red-300 underline-offset-4 transition-all">Informasi
                                                    Kelas IELTS Target Bahasa</span>
                                                <svg class="w-3.5 h-3.5 opacity-0 -ml-1 group-hover:opacity-100 group-hover:ml-0 transform group-hover:-translate-y-0.5 group-hover:translate-x-0.5 transition-all"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                                    </path>
                                                </svg>
                                            </a>
                                            <div class="mt-3 text-xs text-gray-500 text-center">
                                                <p>Jalan Brawijaya 64 Pare Kediri - Kampung Inggris Pare</p>
                                                <p class="mt-1 text-green-600 font-bold text-sm">WhatsApp 0857 0661 5607</p>
                                            </div>
                                            <div class="mt-6 cf-turnstile" data-sitekey="{{ env('TURNSTILE_SITE_KEY') }}"
                                                data-action="submit"
                                                data-callback="onTurnstileVerified"
                                                data-expired-callback="onTurnstileExpired"></div>
                                        </div>
                                    </div>

                                    <div x-show="errorMessage" x-cloak
                                        class="mt-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg">
                                        <p class="font-bold">Error</p>
                                        <p x-text="errorMessage"></p>
                                        <button type="button" x-show="retryableSubmissionId" @click="retrySubmission()"
                                            :disabled="isSubmitting"
                                            class="mt-3 px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700 disabled:opacity-50">
                                            <span x-text="isSubmitting ? 'Mengirim ulang...' : 'Coba Kirim Ulang'"></span>
                                        </button>
                                    </div>
                                </form>
                            </div> <!-- END PRACTICE AREA WRAPPER -->

                            <!-- Idioms Slide-over/Panel -->
                            <template x-if="isIdiomsOpen">
                                <div class="fixed inset-y-0 right-0 w-80 z-[60] flex pointer-events-none">
                                    <div class="w-full h-full pointer-events-auto transition-transform transform bg-white shadow-2xl flex flex-col items-start"
                                        x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500"
                                        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                                        x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500"
                                        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">

                                        <!-- Header -->
                                        <div
                                            class="flex-shrink-0 px-6 py-4 border-b border-gray-200 w-full flex items-center justify-between bg-orange-50">
                                            <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                                                <span class="text-2xl">💡</span> Useful Idioms
                                            </h2>
                                            <button @click="isIdiomsOpen = false"
                                                class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                                <span class="sr-only">Close panel</span>
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Content -->
                                        <div class="flex-1 overflow-y-auto w-full p-6 bg-white custom-scrollbar">
                                            <template x-if="idioms && idioms.length > 0">
                                                <div class="space-y-6">
                                                    <template x-for="(idiom, index) in idioms" :key="index">
                                                        <div
                                                            class="bg-white border rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow border-orange-100">
                                                            <h3 class="text-lg font-bold text-orange-600 mb-1"
                                                                x-text="idiom.phrase"></h3>
                                                            <p class="text-gray-700 italic mb-1" x-text="idiom.meaning"></p>
                                                            <p class="text-sm text-gray-500 italic mb-2"
                                                                x-text="idiom.meaning_id" x-show="idiom.meaning_id"></p>
                                                            <div
                                                                class="bg-gray-50 p-2 rounded text-sm text-gray-600 border-l-2 border-gray-300">
                                                                <span
                                                                    class="font-semibold text-gray-400 text-xs uppercase tracking-wide">Example:</span><br>
                                                                <span x-text="idiom.example"></span>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </div>
                                            </template>
                                            <template x-if="!idioms || idioms.length === 0">
                                                <div
                                                    class="flex flex-col items-center justify-center h-full text-center text-gray-500">
                                                    <svg class="w-16 h-16 mb-4 text-gray-300" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <p>No specific idioms found for this topic.</p>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <!-- Ideas Slide-over/Panel -->
                            <template x-if="isIdeasOpen">
                                <div class="fixed inset-y-0 right-0 w-96 z-[60] flex pointer-events-none">
                                    <div class="w-full h-full pointer-events-auto transition-transform transform bg-white shadow-2xl flex flex-col items-start"
                                        x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500"
                                        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
                                        x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500"
                                        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">

                                        <!-- Header -->
                                        <div
                                            class="flex-shrink-0 px-6 py-4 border-b border-gray-200 w-full flex items-center justify-between bg-blue-50">
                                            <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                                                Speaking Ideas
                                            </h2>
                                            <button @click="isIdeasOpen = false"
                                                class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                                <span class="sr-only">Close panel</span>
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Content -->
                                        <div class="flex-1 overflow-y-auto w-full p-6 bg-white custom-scrollbar">
                                            <div x-html="ideasHtml"></div>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            <!-- Collocations Slide-over/Panel -->
                            <template x-if="isCollocationsOpen">
                                <div class="fixed inset-y-0 left-0 w-80 z-[60] flex pointer-events-none">
                                    <div class="w-full h-full pointer-events-auto transition-transform transform bg-white shadow-2xl flex flex-col items-start"
                                        x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500"
                                        x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
                                        x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500"
                                        x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">

                                        <!-- Header -->
                                        <div
                                            class="flex-shrink-0 px-6 py-4 border-b border-gray-200 w-full flex items-center justify-between bg-teal-50">
                                            <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                                                <span class="text-2xl">🔗</span> Useful Collocations
                                            </h2>
                                            <button @click="isCollocationsOpen = false"
                                                class="text-gray-400 hover:text-gray-500 focus:outline-none">
                                                <span class="sr-only">Close panel</span>
                                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Content -->
                                        <div class="flex-1 overflow-y-auto w-full p-6 bg-white custom-scrollbar">
                                            <template x-if="collocations && collocations.length > 0">
                                                <div class="space-y-6">
                                                    <template x-for="(collocation, index) in collocations" :key="index">
                                                        <div
                                                            class="bg-white border rounded-xl p-4 shadow-sm hover:shadow-md transition-shadow border-teal-100">
                                                            <h3 class="text-lg font-bold text-teal-600 mb-1"
                                                                x-text="collocation.phrase"></h3>
                                                            <p class="text-gray-700 italic mb-1"
                                                                x-text="collocation.meaning"></p>
                                                            <p class="text-sm text-gray-500 italic mb-2"
                                                                x-text="collocation.meaning_id"
                                                                x-show="collocation.meaning_id"></p>
                                                            <div
                                                                class="bg-gray-50 p-2 rounded text-sm text-gray-600 border-l-2 border-gray-300">
                                                                <span
                                                                    class="font-semibold text-gray-400 text-xs uppercase tracking-wide">Example:</span><br>
                                                                <span x-text="collocation.example"></span>
                                                            </div>
                                                        </div>
                                                    </template>
                                                </div>
                                            </template>
                                            <template x-if="!collocations || collocations.length === 0">
                                                <div
                                                    class="flex flex-col items-center justify-center h-full text-center text-gray-500">
                                                    <svg class="w-16 h-16 mb-4 text-gray-300" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <p>No specific collocations found for this topic.</p>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div> <!-- END RIGHT COLUMN -->
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        function promoTest(config) {
            return {
                type: '{{ $type }}',
                id: {{ $id }},
                isAdmin: config.isAdmin || false,
                promptText: config.promptText || '',
                isSpeakingTest: config.isSpeakingTest || false,
                part1Questions: config.part1Questions,
                part2Questions: config.part2Questions,
                part3Questions: config.part3Questions,
                activeTab: 'part1',
                part1Index: 0,
                part3Index: 0,
                ttsCountdown: 0,
                echomimicVideoUrl: null,
                isTTSSpeaking: false,
                currentAudioUtterance: null,
                countdownTimer: null,

                // Magic Sentence State
                msOpen: false,
                toggleMagicSentence() {
                    this.msOpen = !this.msOpen;
                    if (this.msOpen) {
                        this.msText = '';
                        if (this.$refs.msInput) {
                            this.$refs.msInput.innerText = '';
                        }
                        setTimeout(() => {
                            if (this.$refs.msInput) {
                                this.$refs.msInput.focus();
                                try {
                                    let sel = window.getSelection();
                                    let range = document.createRange();
                                    range.selectNodeContents(this.$refs.msInput);
                                    range.collapse(false);
                                    sel.removeAllRanges();
                                    sel.addRange(range);
                                } catch(e) {}
                            }
                        }, 50);
                    }
                },
                msText: '',
                msLoading: false,
                msError: null,
                async translateSentence() {
                    if (!this.msText.trim()) return;
                    this.msLoading = true;
                    this.msError = null;
                    try {
                        const response = await fetch('/api/ollama/translate-sentence', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=\'csrf-token\']')?.getAttribute('content')
                            },
                            body: JSON.stringify({ text: this.msText.trim() })
                        });
                        if (!response.ok) throw new Error('Translation failed.');
                        const data = await response.json();
                        if (data.translation) {
                            let currentText = this.form.answer_text || '';
                            let prefix = currentText.length > 0 && !currentText.endsWith(' ') && !currentText.endsWith('\n') ? ' ' : '';
                            this.form.answer_text = currentText + prefix + data.translation;

                            this.msText = '';
                            this.msOpen = false;
                        } else {
                            this.msError = 'Unexpected response from AI.';
                        }
                    } catch (e) {
                        this.msError = e.message;
                    } finally {
                        this.msLoading = false;
                    }
                },
                examinerVoice: 'af_heart',
                showBeginScreen: true,
                form: {
                    name: '',
                    email: '',
                    whatsapp_number: '',
                    answer_text: ''
                },
                isSubmitting: false,
                feedback: null,
                errorMessage: null,
                retryableSubmissionId: null,

                isCollocationsOpen: false,
                isIdiomsOpen: false,
                isIdeasOpen: false,
                isLoadingIdeas: false,
                ideasHtml: '',
                lastQuestionIdeas: null,
                collocations: config.collocations || [],
                idioms: config.idioms || [],

                // Audio specific
                isRecording: false,
                mediaRecorder: null,
                audioChunks: [],
                recordings: {}, // e.g. { 'part1_0': { blob: Blob, question: 'text' } }

                part2State: 'idle', // 'idle', 'intro', 'prep', 'transition', 'recording'
                part2IntroTimeLeft: 5,
                part2PrepTimeLeft: 60,
                part2TransitionTimeLeft: 3,
                part2RecordTimeLeft: 120,
                part2TimerInterval: null,

                get currentRecordingKey() {
                    if (this.activeTab === 'part1') return 'part1_' + this.part1Index;
                    if (this.activeTab === 'part2') return 'part2_0';
                    if (this.activeTab === 'part3') return 'part3_' + this.part3Index;
                    return 'default';
                },

                hasNext() {
                    if (this.activeTab === 'part1') return true;
                    if (this.activeTab === 'part2') return this.part3Questions.length > 0;
                    if (this.activeTab === 'part3') return this.part3Index < this.part3Questions.length - 1;
                    return false;
                },

                advanceNext() {
                    this.ideasHtml = '';
                    this.lastQuestionIdeas = null;
                    if (this.activeTab === 'part1') {
                        this.nextPart1();
                    } else if (this.activeTab === 'part2') {
                        this.clearPart2Timers();
                        if (this.isRecording) this.stopRecording();
                        this.part2State = 'idle';
                        this.activeTab = 'part3';
                        this.part3Index = 0;
                        this.speakCurrent();
                    } else if (this.activeTab === 'part3') {
                        this.nextPart3();
                    }
                    if (this.isIdeasOpen) {
                        this.openIdeasPanel();
                    }
                },

                startPart2Flow() {
                    this.activeTab = 'part2';
                    this.part2State = 'intro';
                    this.part2IntroTimeLeft = 5;
                    this.clearPart2Timers();

                    if ('speechSynthesis' in window) window.speechSynthesis.cancel();
                    if (this.currentAudioUtterance) {
                        this.currentAudioUtterance.pause();
                    }
                    this.isTTSSpeaking = false;

                    this.part2TimerInterval = setInterval(() => {
                        this.part2IntroTimeLeft--;
                        if (this.part2IntroTimeLeft <= 0) {
                            this.startPart2Prep();
                        }
                    }, 1000);
                },

                startPart2Prep() {
                    this.clearPart2Timers();
                    this.part2State = 'prep';
                    this.part2PrepTimeLeft = 60;

                    this.part2TimerInterval = setInterval(() => {
                        this.part2PrepTimeLeft--;
                        if (this.part2PrepTimeLeft <= 0) {
                            this.startPart2Transition();
                        }
                    }, 1000);
                },

                startPart2Transition() {
                    this.clearPart2Timers();
                    this.part2State = 'transition';
                    this.part2TransitionTimeLeft = 3;

                    this.part2TimerInterval = setInterval(() => {
                        this.part2TransitionTimeLeft--;
                        if (this.part2TransitionTimeLeft <= 0) {
                            this.startPart2Recording();
                        }
                    }, 1000);
                },

                async startPart2Recording() {
                    this.clearPart2Timers();
                    this.part2State = 'recording';
                    this.part2RecordTimeLeft = 120;

                    if (!this.isRecording) {
                        await this.startRecording();
                    }

                    this.part2TimerInterval = setInterval(() => {
                        this.part2RecordTimeLeft--;
                        if (this.part2RecordTimeLeft <= 0) {
                            this.stopPart2Recording();
                        }
                    }, 1000);
                },

                stopPart2Recording() {
                    this.clearPart2Timers();
                    if (this.isRecording) {
                        this.stopRecording();
                    }
                    this.part2State = 'idle';
                    this.activeTab = 'part3';
                    this.part3Index = 0;
                    this.speakCurrent();
                },

                clearPart2Timers() {
                    if (this.part2TimerInterval) {
                        clearInterval(this.part2TimerInterval);
                        this.part2TimerInterval = null;
                    }
                },

                formatPart2Time(seconds) {
                    let m = Math.floor(seconds / 60);
                    let s = seconds % 60;
                    return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
                },

                get currentAudioUrl() {
                    const data = this.recordings[this.currentRecordingKey];
                    if (data && data.blob) {
                        // If it already has an object URL we can use it, or create one on the fly.
                        return URL.createObjectURL(data.blob);
                    }
                    return null;
                },

                get wordCount() {
                    if (!this.form.answer_text) return 0;
                    return this.form.answer_text.trim().split(/\s+/).filter(word => word.length > 0).length;
                },

                timeLeft: {{ str_starts_with($type, 'writing') ? ($type === 'writing_t1' ? (20 * 60) : (40 * 60)) : 0 }},
                timerInterval: null,
                timerStarted: false,
                get formattedTime() {
                    if (this.timeLeft <= 0) return '00:00';
                    let m = Math.floor(this.timeLeft / 60);
                    let s = this.timeLeft % 60;
                    return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
                },

                get storageKey() {
                    return `promo_test_data_${this.type}_${this.id}`;
                },

                saveData() {
                    const key = this.storageKey;
                    const payload = {
                        form: this.form,
                        examinerVoice: this.examinerVoice,
                        timeLeft: this.timeLeft,
                        timerStarted: this.timerStarted,
                        timestamp: Date.now()
                    };
                    console.log('[AutoSave] Saving to key:', key, '| answer length:', (this.form.answer_text || '').length);
                    localStorage.setItem(key, JSON.stringify(payload));
                },

                loadData() {
                    const key = this.storageKey;
                    const stored = localStorage.getItem(key);
                    console.log('[AutoSave] Loading from key:', key, '| found:', !!stored);
                    if (stored) {
                        try {
                            const data = JSON.parse(stored);
                            if (data.submittedAt && (Date.now() - data.submittedAt > 3600000)) {
                                localStorage.removeItem(key);
                                console.log('[AutoSave] Cleared (submitted > 1hr ago)');
                                return;
                            }
                            if (data.form) {
                                this.form.name = data.form.name || '';
                                this.form.email = data.form.email || '';
                                this.form.whatsapp_number = data.form.whatsapp_number || '';
                                this.form.answer_text = data.form.answer_text || '';
                                console.log('[AutoSave] Restored answer length:', (this.form.answer_text || '').length);
                            }
                            if (data.examinerVoice) {
                                this.examinerVoice = data.examinerVoice;
                            }
                            if (data.timeLeft !== undefined) {
                                this.timeLeft = data.timeLeft;
                            }
                            if (data.timerStarted !== undefined) {
                                this.timerStarted = data.timerStarted;
                            }
                        } catch (e) {
                            console.error('[AutoSave] Parse error:', e);
                        }
                    }
                },

                init() {
                    if (this.isSpeakingTest) {
                        fetch('{{ route('promo.test.echomimic-avatar') }}')
                            .then(r => r.json())
                            .then(data => {
                                if (data.success && data.url) {
                                    this.echomimicVideoUrl = data.url;
                                }
                            })
                            .catch(e => console.error(e));
                    }

                    // Load pre-rendered videos database
                    fetch('/web_assets/database.json')
                        .then(res => res.json())
                        .then(data => {
                            this.videoDatabase = data;
                        })
                        .catch(e => {
                            console.log('No pre-rendered video database found.');
                            this.videoDatabase = [];
                        });

                    // Load saved data FIRST before registering watchers
                    this.loadData();

                    // Use $nextTick so watchers are registered AFTER the initial
                    // data load has propagated — prevents load from triggering save
                    this.$nextTick(() => {
                        this.$watch('form.name', () => this.saveData());
                        this.$watch('form.email', () => this.saveData());
                        this.$watch('form.whatsapp_number', () => this.saveData());
                        this.$watch('form.answer_text', (value) => {
                            this.saveData();
                            if (this.type.startsWith('writing') && !this.timerStarted && (value || '').trim().length > 0) {
                                this.startWritingTimer();
                            }
                        });

                        if (this.type.startsWith('writing')) {
                            if (this.timerStarted && this.timeLeft > 0) {
                                this.startWritingTimer();
                            }
                        }
                    });
                },

                resetWriting() {
                    if (confirm('Are you sure you want to restart this test? Your answer will be cleared and the timer will be reset.')) {
                        this.form.answer_text = '';
                        this.timerStarted = false;
                        if (this.timerInterval) {
                            clearInterval(this.timerInterval);
                            this.timerInterval = null;
                        }
                        this.timeLeft = this.type === 'writing_t1' ? (20 * 60) : (40 * 60);
                        this.saveData();
                        if (this.msOpen) {
                            this.msText = '';
                            if (this.$refs.msInput) {
                                this.$refs.msInput.innerText = '';
                            }
                        }
                    }
                },

                startWritingTimerIfTyping() {
                    if (this.type.startsWith('writing') && !this.timerStarted && (this.form.answer_text || '').trim().length > 0) {
                        this.startWritingTimer();
                    }
                },

                startWritingTimer() {
                    if (this.timerInterval) return;
                    this.timerStarted = true;
                    this.saveData();
                    this.timerInterval = setInterval(() => {
                        if (this.timeLeft > 0) {
                            this.timeLeft--;
                            if (this.timeLeft % 5 === 0) this.saveData(); // Save periodically
                            if (this.timeLeft === 0) {
                                clearInterval(this.timerInterval);
                                this.handleTimeUp();
                            }
                        } else {
                            clearInterval(this.timerInterval);
                        }
                    }, 1000);
                },

                beginPractice() {
                    this.showBeginScreen = false;
                    // Unlock audio context within this user gesture
                    if (!this.currentAudioUtterance) {
                        this.currentAudioUtterance = new Audio();
                    }
                    this.currentAudioUtterance.src = 'data:audio/wav;base64,UklGRiQAAABXQVZFZm10IBAAAAABAAEARKwAAIhYAQACABAAZGF0YQAAAAA=';
                    this.currentAudioUtterance.volume = 0.001;
                    this.currentAudioUtterance.play().catch(() => { });

                    // Small delay then start countdown
                    setTimeout(() => this.startTTSCountdown(), 300);
                },

                startTTSCountdown() {
                    this.ttsCountdown = 5;

                    this.countdownTimer = setInterval(() => {
                        this.ttsCountdown--;
                        if (this.ttsCountdown <= 0) {
                            clearInterval(this.countdownTimer);
                            this.ttsCountdown = 0;
                            if (this.isSpeakingTest) {
                                this.activeTab = 'part1';
                                this.part1Index = 0;
                                this.speakCurrent();
                            } else {
                                this.speakQuestion();
                            }
                        }
                    }, 1000);
                },

                nextPart1() {
                    if (this.part1Index < this.part1Questions.length - 1) {
                        this.part1Index++;
                        this.speakCurrent();
                    } else {
                        this.startPart2Flow();
                    }
                },

                nextPart3() {
                    if (this.part3Index < this.part3Questions.length - 1) {
                        this.part3Index++;
                        this.speakCurrent();
                    }
                },

                speakCurrent() {
                    if (!this.isSpeakingTest) return;
                    if (this.activeTab === 'part2') return; // Do not read Part 2 questions

                    let text = '';
                    if (this.activeTab === 'part1') {
                        text = this.part1Questions[this.part1Index] || '';
                    } else if (this.activeTab === 'part3') {
                        text = this.part3Questions[this.part3Index] || '';
                    }
                    this.promptText = text;
                    this.speakQuestion();
                },

                // video database init moved to the main init() method
                videoDatabase: [],

                videoEnded() {
                    this.isTTSSpeaking = false;
                    // Optionally clear the video so it goes back to static avatar, 
                    // but keeping it on the last frame might look better, or just hide it.
                    // this.echomimicVideoUrl = null;
                },

                speakQuestion() {
                    this.isTTSSpeaking = true;
                    if (this.currentAudioUtterance) {
                        this.currentAudioUtterance.pause();
                        this.currentAudioUtterance.currentTime = 0;
                    }
                    if ('speechSynthesis' in window) window.speechSynthesis.cancel();

                    if (!this.promptText) {
                        this.isTTSSpeaking = false;
                        return;
                    }

                    // Check if we have a pre-rendered video for this exact text
                    const matchedVideo = this.videoDatabase.find(v => v.text.trim().toLowerCase() === this.promptText.trim().toLowerCase());

                    const isFemaleVoice = ['af_heart', 'af_nova', 'af_sky', 'bf_emma'].includes(this.examinerVoice);

                    if (matchedVideo) {
                        if (isFemaleVoice && matchedVideo.video_path) {
                            console.log('Playing pre-rendered female video:', matchedVideo.video_path);
                            this.echomimicVideoUrl = matchedVideo.video_path;
                            return;
                        } else if (!isFemaleVoice && matchedVideo.video_path_male) {
                            console.log('Playing pre-rendered male video:', matchedVideo.video_path_male);
                            this.echomimicVideoUrl = matchedVideo.video_path_male;
                            return;
                        }
                    }

                    // Fallback to TTS and image avatar
                    this.echomimicVideoUrl = null;

                    const fallbackToWebSpeech = (reason) => {
                        console.warn('Kokoro TTS failed (' + reason + '), no fallback provided.');
                        this.isTTSSpeaking = false;
                    };

                    try {
                        const audioUrl = '{{ route('tts.stream') }}?text=' + encodeURIComponent(this.promptText) + '&voice=' + encodeURIComponent(this.examinerVoice);

                        if (!this.currentAudioUtterance) {
                            this.currentAudioUtterance = new Audio();
                        }
                        this.currentAudioUtterance.src = audioUrl;
                        this.currentAudioUtterance.volume = 1;

                        this.currentAudioUtterance.oncanplay = () => {
                            this.isTTSSpeaking = true;
                        };
                        this.currentAudioUtterance.onplaying = () => {
                            this.isTTSSpeaking = true;
                        };
                        this.currentAudioUtterance.onended = () => {
                            this.isTTSSpeaking = false;
                        };
                        this.currentAudioUtterance.onerror = (e) => {
                            fallbackToWebSpeech('audio error');
                        };

                        const playPromise = this.currentAudioUtterance.play();
                        if (playPromise !== undefined) {
                            playPromise.catch(error => {
                                fallbackToWebSpeech('play() rejected: ' + error.message);
                            });
                        }
                    } catch (error) {
                        fallbackToWebSpeech('exception: ' + error.message);
                    }
                },

                handleTimeUp() {
                    if (this.form.name && this.form.email && this.form.answer_text) {
                        this.submitTest();
                    } else {
                        alert("Waktu habis! Essay sudah tidak bisa diedit. Silakan lengkapi 'Your Information' (atau jawaban Anda) lalu klik Submit untuk mendapatkan feedback AI.");
                    }
                },

                async toggleRecording() {
                    if (this.isRecording) {
                        this.stopRecording();
                    } else {
                        await this.startRecording();
                    }
                },

                async startRecording() {
                    try {
                        const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                        this.mediaRecorder = new MediaRecorder(stream);
                        this.audioChunks = [];

                        const recordingTab = this.activeTab;
                        const recordingIndex = this.activeTab === 'part1' ? this.part1Index : (this.activeTab === 'part3' ? this.part3Index : 0);
                        const recordingKey = this.currentRecordingKey;

                        this.mediaRecorder.ondataavailable = (event) => {
                            this.audioChunks.push(event.data);
                        };

                        this.mediaRecorder.onstop = () => {
                            const blob = new Blob(this.audioChunks, { type: 'audio/webm' });

                            let questionText = '';
                            if (recordingTab === 'part1') questionText = this.part1Questions[recordingIndex] || '';
                            else if (recordingTab === 'part2') questionText = "Part 2: " + this.part2Questions.join(' ');
                            else if (recordingTab === 'part3') questionText = this.part3Questions[recordingIndex] || '';

                            this.recordings[recordingKey] = {
                                blob: blob,
                                question: questionText
                            };
                            this.recordings = { ...this.recordings }; // trigger reactivity
                        };

                        this.mediaRecorder.start();
                        this.isRecording = true;
                    } catch (err) {
                        alert("Could not access microphone: " + err.message);
                    }
                },

                stopRecording() {
                    if (!this.mediaRecorder || this.mediaRecorder.state === 'inactive') return;
                    this.mediaRecorder.stop();
                    this.isRecording = false;
                    this.mediaRecorder.stream.getTracks().forEach(track => track.stop());
                },

                async openIdeasPanel() {
                    this.isIdeasOpen = true;
                    if (this.lastQuestionIdeas === this.currentQuestionText) return;

                    this.lastQuestionIdeas = this.currentQuestionText;
                    this.isLoadingIdeas = true;
                    this.ideasHtml = '<div class="flex items-center gap-2 text-gray-500"><svg class="w-5 h-5 animate-spin text-blue-600" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Generating ideas...</div>';

                    try {
                        const res = await fetch('/api/ollama/ideas', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                            body: JSON.stringify({ prompt: this.currentQuestionText, task: 'speaking' })
                        });
                        const data = await res.json();
                        if (data.html) {
                            this.ideasHtml = '<div class="prose prose-sm prose-blue max-w-none">' + data.html + '</div>';
                        } else {
                            this.ideasHtml = '<p class="text-red-500">Gagal memuat ide.</p>';
                            this.lastQuestionIdeas = null;
                        }
                    } catch (e) {
                        this.ideasHtml = '<p class="text-red-500">Gagal memuat ide.</p>';
                        this.lastQuestionIdeas = null;
                    }
                    this.isLoadingIdeas = false;
                },

                resetRecording() {
                    delete this.recordings[this.currentRecordingKey];
                    this.recordings = { ...this.recordings };
                },
                adminTargetBand: '7.5',

                async adminDebugSubmit() {
                    if (!this.isAdmin) return;
                    this.isSubmitting = true;
                    this.errorMessage = null;

                    try {
                        const formData = new FormData();
                        formData.append('_token', '{{ csrf_token() }}');
                        formData.append('name', 'Admin Debugger');
                        formData.append('email', 'admin@targetbahasa.com');
                        formData.append('whatsapp_number', '081234567890');
                        formData.append('is_admin_debug', '1');
                        formData.append('target_band_score', this.adminTargetBand);
                        formData.append('answer_text', 'Dummy text to bypass validation');

                        const response = await fetch(`/promo/test/${this.type}/${this.id}/submit`, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            throw new Error(data.message || 'Server error occurred');
                        }

                        const urlParams = new URLSearchParams(window.location.search);
                        const bParam = urlParams.get('b');
                        let redirectUrl = `/promo/test/${this.type}/${this.id}/ielts-academic-evaluation/${data.submission_id}`;
                        if (bParam) {
                            redirectUrl += `?b=${bParam}`;
                        }
                        window.location.href = redirectUrl;
                    } catch (error) {
                        this.errorMessage = error.message;
                    } finally {
                        this.isSubmitting = false;
                    }
                },

                async submitTest() {
                    this.isSubmitting = true;
                    this.errorMessage = null;
                    this.feedback = null;

                    try {
                        const formData = new FormData();

                        // Add Cloudflare Turnstile response (from shared global callback)
                        const cfResponse = window.cfTurnstileToken || document.querySelector('[name="cf-turnstile-response"]')?.value;
                        if (!cfResponse) {
                            throw new Error('Mohon lengkapi verifikasi captcha terlebih dahulu.');
                        }
                        formData.append('cf-turnstile-response', cfResponse);

                        formData.append('_token', '{{ csrf_token() }}');
                        formData.append('name', this.form.name);
                        formData.append('email', this.form.email);
                        formData.append('whatsapp_number', this.form.whatsapp_number);

                        if (this.type.startsWith('writing')) {
                            formData.append('answer_text', this.form.answer_text);
                        } else if (this.type === 'speaking') {
                            if (Object.keys(this.recordings).length === 0) throw new Error("Please record your answer first.");

                            let index = 0;
                            for (const key in this.recordings) {
                                const rec = this.recordings[key];
                                formData.append('audio_files[]', rec.blob, 'recording_' + index + '.webm');
                                formData.append('questions[]', rec.question);
                                index++;
                            }
                        }

                        const response = await fetch(`/promo/test/${this.type}/${this.id}/submit`, {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        if (!response.ok) {
                            throw new Error(data.message || 'Server error occurred');
                        }

                        if (!data.success) {
                            // Answer + lead were already saved server-side even though AI
                            // evaluation failed. Offer a retry instead of losing the answer.
                            this.errorMessage = data.message || 'Terjadi kesalahan saat evaluasi AI.';
                            this.retryableSubmissionId = data.retryable ? data.submission_id : null;
                            return;
                        }

                        this.finishSubmission(data.submission_id);

                    } catch (error) {
                        this.errorMessage = error.message;
                    } finally {
                        this.isSubmitting = false;
                    }
                },

                async retrySubmission() {
                    if (!this.retryableSubmissionId) return;
                    this.isSubmitting = true;
                    this.errorMessage = null;

                    try {
                        const response = await fetch(`/promo/test/${this.type}/${this.id}/submit/retry/${this.retryableSubmissionId}`, {
                            method: 'POST',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        });

                        const data = await response.json();

                        if (!response.ok || !data.success) {
                            // Still failed - keep the retry button available (submission stays saved).
                            this.errorMessage = data.message || 'Sistem AI masih bermasalah. Silakan coba lagi.';
                            return;
                        }

                        this.finishSubmission(data.submission_id);

                    } catch (error) {
                        this.errorMessage = error.message;
                    } finally {
                        this.isSubmitting = false;
                    }
                },

                finishSubmission(submissionId) {
                    // Set submitted timestamp
                    const stored = localStorage.getItem(this.storageKey);
                    let storageData = stored ? JSON.parse(stored) : {};
                    storageData.submittedAt = Date.now();
                    localStorage.setItem(this.storageKey, JSON.stringify(storageData));

                    // Redirect to the result page
                    const urlParams = new URLSearchParams(window.location.search);
                    const bParam = urlParams.get('b');
                    let redirectUrl = `/promo/test/${this.type}/${this.id}/ielts-academic-evaluation/${submissionId}`;
                    if (bParam) {
                        redirectUrl += `?b=${bParam}`;
                    }
                    window.location.href = redirectUrl;
                }
            }
        }
    </script>
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
    </div>
</body>

</html>