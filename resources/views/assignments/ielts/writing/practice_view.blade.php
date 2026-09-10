@extends('layouts.admin')

@section('title', ($meeting->title ?? 'Latihan Writing') . ' - IELTS Writing')

@php
    // Always computed, regardless of which branch below renders, so the
    // chart-drawing script at the bottom of this view always has a value.
    $chartPayload = \App\Support\IeltsTask1ChartResolver::resolve($meeting);
@endphp

@section('content')
<style>
    .row-indigo { background-color: #eef2ff; }
    .row-fuchsia { background-color: #fdf4ff; }
    .row-hover-yellow:hover { background-color: #fef9c3 !important; }
</style>

@section('head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"></script>
    <script src="{{ asset('js/auto-save.js') }}?v={{ time() }}"></script>
    <script>
        window.APP_VERSION = '{{ now()->timestamp }}';
    </script>
@endsection
<div class="relative w-full h-screen flex flex-col max-w-[1920px] mx-auto bg-gray-50" 
     x-data='practiceView({{ $meeting->meeting_number }}, {{ $task }}, @json($meeting->idioms ?? []), @json($meeting->collocations ?? []))'
     @toggle-collocations.window="isCollocationsOpen = !isCollocationsOpen; if(isCollocationsOpen) isIdiomsOpen = false"
     @toggle-idioms.window="isIdiomsOpen = !isIdiomsOpen; if(isIdiomsOpen) isCollocationsOpen = false">
    
    <!-- Header (Fixed Height / Flex Child) -->
    <div class="flex-none bg-white border-b border-gray-200 px-4 sm:px-6 py-4 z-30">
        <div class="flex items-center justify-between gap-4">
            <!-- Left Side: Back Button + Title -->
            <div class="flex items-center gap-4 min-w-0">
                <!-- Back Button Logic -->
                @if(isset($meeting) && $meeting->category === 'practice_item')
                    <!-- always use backUrl for practice items (keeps the "type" query param) -->
                    <a href="{{ $backUrl ?? route('assignments.ielts-academic.writing.practice.index') }}" class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors shrink-0">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                @elseif((isset($meeting) && $meeting->id == 45) || ($meeting->meeting_number >= 1010 && $meeting->meeting_number <= 1029))
                    <a href="{{ route('assignments.ielts-academic.writing.meeting', ['task' => 1, 'id' => 9]) }}" class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors shrink-0">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                @elseif((isset($meeting) && $meeting->id == 54) || ($meeting->meeting_number >= 1030 && $meeting->meeting_number <= 1049))
                    <a href="{{ route('assignments.ielts-academic.writing.meeting', ['task' => 1, 'id' => 10]) }}" class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors shrink-0">
                        <svg class="w-5 h-5 text_gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                @elseif((isset($meeting) && $meeting->id == 64) || ($meeting->meeting_number >= 1050 && $meeting->meeting_number <= 1069))
                    <a href="{{ route('assignments.ielts-academic.writing.meeting', ['task' => 1, 'id' => 11]) }}" class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors shrink-0">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                @elseif((isset($meeting) && $meeting->id == 74) || ($meeting->meeting_number >= 1070 && $meeting->meeting_number <= 1089))
                    <a href="{{ route('assignments.ielts-academic.writing.meeting', ['task' => 1, 'id' => 12]) }}" class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors shrink-0">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                @elseif($meeting->meeting_number < 110)
                    <a href="{{ route('assignments.ielts-academic.writing.meeting', ['task' => 1, 'id' => 16]) }}" class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors shrink-0">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                @else
                    <a href="{{ $backUrl ?? route('assignments.ielts-academic.writing.practice.index') }}" class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors shrink-0">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                @endif
                
                <!-- Title & Meta -->
                <div class="min-w-0">
                    <span class="text-xs font-bold text-teal-600 tracking-wider uppercase block truncate">IELTS Task {{ $meeting->task_type }} Practice</span>
                    <h1 class="text-lg sm:text-xl font-bold text-gray-900 truncate" title="{{ $meeting->title }}">{{ $meeting->title }}</h1>
                </div>
            </div>

            <!-- Right Side: Admin Actions -->
            <div class="flex items-center gap-3 shrink-0">
                @if(Auth::check() && Auth::user()->role === 'admin')
                    <button type="button" @click="previewEvaluasi()" :disabled="loading" class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white font-bold text-sm rounded-lg shadow-sm transition-colors flex items-center gap-2" title="Khusus Admin: Preview Hasil Evaluasi AI (menggunakan sistem evaluasi yang sama dengan submission asli)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        <span>Preview Evaluasi</span>
                    </button>
                    <button @click="openEditModal()" class="text-gray-400 hover:text-blue-600 transition-colors p-2 rounded-lg hover:bg-blue-50" title="Edit Topic">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    </button>
                    <form action="{{ route('assignments.ielts.writing.destroy', $meeting->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this topic?');" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors p-2 rounded-lg hover:bg-red-50" title="Delete Topic">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Main Content Grid (Flex Grow) -->
    <div class="flex-1 min-h-0 w-full px-4 sm:px-6 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 h-full">
            <!-- Left Column: The Chart / Task Info -->
            <div id="left-panel" class="relative min-w-0 lg:col-span-5 h-full overflow-y-auto pr-2 pb-32 custom-scrollbar flex flex-col">

            @if($meeting->task_type == 1 && $meeting->meeting_number >= 1000 && $meeting->meeting_number < 2000)
                <!-- Textbook Style IELTS Academic Writing Task 1 (Cambridge IELTS Style) -->
                @php
                    $rawPrompt = trim(strip_tags($meeting->prompt ?? '', '<br><b><i><strong><em>'));
                    $chartType = 'chart';
                    if ($meeting->meeting_number >= 1110 && $meeting->meeting_number <= 1129) {
                        $chartType = 'diagram';
                    } elseif ($meeting->meeting_number >= 1130 && $meeting->meeting_number <= 1139) {
                        $chartType = 'map';
                    } elseif (($meeting->meeting_number >= 1100 && $meeting->meeting_number <= 1109) || ($meeting->meeting_number >= 1140 && $meeting->meeting_number <= 1149)) {
                        $chartType = 'bar chart';
                    } elseif ($meeting->meeting_number >= 1200 && $meeting->meeting_number <= 1249) {
                        $chartType = 'pie chart';
                    } elseif ($meeting->meeting_number >= 1300 && $meeting->meeting_number <= 1349) {
                        $chartType = 'table';
                    } elseif ($meeting->meeting_number >= 1500 && $meeting->meeting_number <= 1549) {
                        $chartType = 'diagram';
                    } elseif ($meeting->meeting_number >= 1600 && $meeting->meeting_number <= 1649) {
                        $chartType = 'map';
                    } elseif ($meeting->meeting_number >= 1010 && $meeting->meeting_number <= 1059) {
                        $chartType = 'graph';
                    }

                    if (empty($rawPrompt)) {
                        $academicPrompt = "The {$chartType} below shows " . strtolower($meeting->title) . ".<br><br>Summarise the information by selecting and reporting the main features, and make comparisons where relevant.";
                    } elseif (!preg_match('/^The\s+([a-z\s]+)\s+below\s+shows/i', $rawPrompt)) {
                        $academicPrompt = "The {$chartType} below shows " . strtolower($meeting->title) . ".<br><br>" . $rawPrompt;
                    } else {
                        $academicPrompt = $rawPrompt;
                    }

                    $academicPrompt = preg_replace('/^(<br\s*\/?>|\s)+/i', '', $academicPrompt);
                    $academicPrompt = preg_replace('/(<br\s*\/?>|\s)+$/i', '', $academicPrompt);
                @endphp

                <div class="bg-white p-6 md:p-8 rounded-2xl shadow-sm border border-gray-200 mb-6 font-sans">
                    <!-- WRITING Header Badge -->
                    <div class="flex justify-center mb-6">
                        <span class="text-xl font-bold bg-black text-white px-6 py-1.5 uppercase tracking-widest shadow-xs">WRITING</span>
                    </div>

                    <div class="space-y-4 text-gray-900 text-[15px] leading-relaxed">
                        <h2 class="font-bold text-base tracking-wide uppercase text-gray-900 mb-1">WRITING TASK 1</h2>
                        <p class="text-gray-700 text-sm">You should spend about 20 minutes on this task.</p>

                        <!-- Textbook Question Box with 2px Black Border -->
                        <div class="border-2 border-gray-900 p-6 bg-white my-6 font-semibold italic text-gray-900 leading-relaxed shadow-2xs">
                            {!! $academicPrompt !!}
                        </div>

                        <!-- Standard Instructions Below Box -->
                        <div class="space-y-2 text-gray-800 text-sm font-normal pt-2 mb-6">
                            <p>Write at least 150 words.</p>
                        </div>
                    </div>

                    <!-- The Chart Container -->
                    <div class="overflow-x-auto pt-6 border-t border-gray-100">
                        @if($chartPayload['kind'] === 'line')
                            <!-- Line Chart -->
                            <div class="relative h-[580px] w-full min-w-[300px]" style="height: 580px;">
                                <canvas id="practiceLineChart"></canvas>
                            </div>
                        @elseif($chartPayload['kind'] === 'bar')
                            <!-- Bar Chart -->
                            <div class="relative h-[580px] w-full min-w-[300px]" style="height: 580px;">
                                <canvas id="practiceBarChart"></canvas>
                            </div>
                        @elseif($chartPayload['kind'] === 'pie')
                            <!-- Pie Chart (Single, Double, or Triple) -->
                            <div id="practicePieContainer" class="w-full flex flex-col items-center justify-center min-h-[500px] p-2">
                                <h3 id="pieMainTitle" class="text-center font-bold text-gray-900 text-lg mb-4 hidden"></h3>
                                <div id="pieGrid" class="w-full flex flex-wrap justify-center items-center gap-6">
                                    <div class="relative h-[480px] w-full max-w-[460px] flex justify-center">
                                        <canvas id="practicePieChart"></canvas>
                                    </div>
                                </div>
                                <div id="pieSharedLegend" class="flex flex-wrap justify-center items-center gap-3 mt-6"></div>
                            </div>
                        @elseif($chartPayload['kind'] === 'table')
                            <!-- Table -->
                            <div id="practiceTableContainer" class="overflow-x-auto rounded-xl shadow-lg border border-gray-100 hidden">
                                <!-- Table will be injected here by JS -->
                            </div>
                        @elseif($chartPayload['kind'] === 'mixed')
                            <!-- Mixed -->
                            <div id="practiceMixedContainer" class="w-full flex flex-col gap-8 justify-center items-center h-auto min-h-[600px] p-4">
                                <!-- Canvases injected by JS -->
                            </div>
                        @elseif($chartPayload['kind'] === 'flowchart')
                            <!-- Flow Chart -->
                            <div class="flex justify-center items-center py-4">
                                @if($chartPayload['imageUrl'])
                                    <img src="{{ $chartPayload['imageUrl'] }}" alt="{{ $chartPayload['alt'] }}" class="max-w-full h-auto rounded-lg shadow-sm border border-gray-200">
                                @else
                                    <div class="text-center p-8 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                        <p class="text-gray-500">Flow Chart Diagram not available for this meeting.</p>
                                    </div>
                                @endif
                            </div>
                        @elseif($chartPayload['kind'] === 'map')
                            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                                @if($chartPayload['imageUrl'])
                                    <div class="flex justify-center">
                                        <img src="{{ $chartPayload['imageUrl'] }}" alt="{{ $meeting->title }} Map" class="w-full max-h-[850px] object-contain rounded-lg shadow-sm border border-gray-200 cursor-pointer hover:shadow-md transition-shadow" onclick="window.open(this.src, '_blank')">
                                    </div>
                                    <p class="text-xs text-center text-gray-400 mt-2">💡 Klik gambar untuk membuka dalam ukuran penuh</p>
                                @else
                                    <div class="text-center p-8 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                        <p class="text-gray-500">Map Diagram not available for this meeting.</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @else
                    <!-- Textbook Style IELTS General Writing Task 1 (Cambridge IELTS Style) -->
                    @php
                        $promptRaw = $meeting->prompt ?? '';
                        $boxContent = $promptRaw;
                        $salutationVal = 'Dear Sir or Madam,';

                        if (strpos($promptRaw, 'Write at least 150 words.') !== false) {
                            $parts = explode('Write at least 150 words.', $promptRaw);
                            $boxContent = trim($parts[0], " <br>\t\n\r");
                            
                            if (isset($parts[1]) && strpos($parts[1], 'Dear ') !== false) {
                                $salutationParts = explode('Dear ', $parts[1]);
                                if (isset($salutationParts[1])) {
                                    $salutationVal = 'Dear ' . strip_tags(trim($salutationParts[1]));
                                }
                            } elseif (isset($parts[1]) && strpos($parts[1], 'Dear') !== false) {
                                $salutationParts = explode('Dear', $parts[1]);
                                if (isset($salutationParts[1])) {
                                    $salutationVal = 'Dear' . strip_tags(trim($salutationParts[1]));
                                }
                            }
                        }

                        $formattedBoxContent = $boxContent;
                        if (!empty($boxContent) && strpos($boxContent, '<ul') === false && strpos($boxContent, '<li') === false) {
                            $normContent = str_replace('\n', "\n", $boxContent);
                            $normContent = preg_replace('/(?<!^)\s+-\s+/', "\n- ", $normContent);
                            
                            $lines = explode("\n", $normContent);
                            $outArr = [];
                            $inList = false;

                            foreach ($lines as $lineStr) {
                                $trimmedLine = trim($lineStr);
                                if (empty($trimmedLine)) continue;

                                if (str_starts_with($trimmedLine, '-')) {
                                    if (!$inList) {
                                        $outArr[] = '<ul class="list-disc pl-6 space-y-1.5 my-3 font-normal not-italic text-gray-800">';
                                        $inList = true;
                                    }
                                    $itemText = trim(substr($trimmedLine, 1));
                                    $outArr[] = '<li class="leading-relaxed">' . e($itemText) . '</li>';
                                } else {
                                    if ($inList) {
                                        $outArr[] = '</ul>';
                                        $inList = false;
                                    }
                                    $outArr[] = '<p class="mb-2 leading-relaxed">' . nl2br(e($trimmedLine)) . '</p>';
                                }
                            }

                            if ($inList) {
                                $outArr[] = '</ul>';
                            }
                            $formattedBoxContent = implode("\n", $outArr);
                        }
                    @endphp

                    <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-200 mb-6 font-sans">
                        <!-- WRITING Header Badge -->
                        <div class="flex justify-center mb-8">
                            <span class="text-xl font-bold bg-black text-white px-6 py-1.5 uppercase tracking-widest shadow-xs">WRITING</span>
                        </div>

                        <div class="space-y-4 text-gray-900 text-[15px] leading-relaxed">
                            <h2 class="font-bold text-base tracking-wide uppercase text-gray-900 mb-1">WRITING TASK 1</h2>
                            <p class="text-gray-700 text-sm">You should spend about 20 minutes on this task.</p>

                            <!-- Textbook Question Box with Black Border -->
                            <div class="border-2 border-gray-900 p-6 bg-white my-6 font-semibold italic text-gray-900 leading-relaxed shadow-2xs">
                                {!! $formattedBoxContent !!}
                            </div>

                            <!-- Standard IELTS Instructions Below Box -->
                            <div class="space-y-2 text-gray-900 text-sm font-normal pt-2">
                                <p>Write at least 150 words.</p>
                                <p>You do <strong class="font-bold uppercase">NOT</strong> need to write any addresses.</p>
                                <p>Begin your letter as follows:</p>
                                <p class="text-2xl font-serif font-bold italic text-gray-900 pt-3 pl-1 tracking-wide">
                                    {{ $salutationVal }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Useful Formal Letter Guidance & Formula Box -->
                    <div class="bg-gradient-to-br from-slate-50 via-teal-50/40 to-emerald-50/30 border border-teal-100 rounded-2xl p-5 shadow-xs mb-6">
                        <h4 class="font-bold text-slate-800 text-sm tracking-wide uppercase mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Formal Letter Structure & Useful Expressions
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-xs text-slate-600">
                            <div class="bg-white p-3 rounded-xl border border-slate-100 shadow-2xs">
                                <strong class="text-slate-800 block mb-1">Salutation & Sign-off:</strong>
                                <p class="mb-1">• <em>Unknown Name:</em> <code class="bg-slate-100 px-1 py-0.5 rounded text-slate-700 font-mono">Dear Sir or Madam,</code> &rarr; <code class="bg-slate-100 px-1 py-0.5 rounded text-slate-700 font-mono">Yours faithfully,</code></p>
                                <p>• <em>Known Name:</em> <code class="bg-slate-100 px-1 py-0.5 rounded text-slate-700 font-mono">Dear Mr. Smith,</code> &rarr; <code class="bg-slate-100 px-1 py-0.5 rounded text-slate-700 font-mono">Yours sincerely,</code></p>
                            </div>
                            <div class="bg-white p-3 rounded-xl border border-slate-100 shadow-2xs">
                                <strong class="text-slate-800 block mb-1">Opening Expressions:</strong>
                                <p class="mb-1">• <em>I am writing to express my dissatisfaction regarding...</em></p>
                                <p>• <em>I am writing to formally request / inquire about...</em></p>
                            </div>
                    </div>
                @endif

            @if(isset($meeting) && $meeting->task_type == 2)
            <!-- Task 2 Layout Plan -->
            <div class="mt-6 space-y-4">
                <div class="p-3 bg-orange-50 border border-orange-100 rounded-xl">
                    <h4 class="font-bold text-orange-800 mb-2">Body Paragraph 1</h4>
                        <textarea name="plan_body1" x-model="plan.body1"
                                x-init="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                                @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                                class="w-full bg-white/50 border-orange-200 rounded-lg text-sm text-orange-900 placeholder-orange-300 focus:ring-orange-500 focus:border-orange-500 p-2 min-h-[80px] overflow-hidden resize-none"
                                placeholder="• Topic Sentence (Main Idea 1)&#10;• Explain/Expand&#10;• Example"></textarea>
                </div>

                <div class="p-3 bg-orange-50 border border-orange-100 rounded-xl">
                    <h4 class="font-bold text-orange-800 mb-2">Body Paragraph 2</h4>
                        <textarea name="plan_body2" x-model="plan.body2"
                                x-init="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                                @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                                class="w-full bg-white/50 border-orange-200 rounded-lg text-sm text-orange-900 placeholder-orange-300 focus:ring-orange-500 focus:border-orange-500 p-2 min-h-[80px] overflow-hidden resize-none"
                                placeholder="• Topic Sentence (Main Idea 2)&#10;• Explain/Expand&#10;• Example"></textarea>
                </div>

                <!-- Dynamic Extra Paragraphs -->
                <template x-for="(extra, index) in plan.extras" :key="index">
                    <div class="p-3 bg-orange-50 border border-orange-100 rounded-xl relative group">
                        <h4 class="font-bold text-orange-800 mb-2" x-text="'Body Paragraph ' + (index + 3)"></h4>
                        <button @click="removeParagraph(index)" class="absolute top-2 right-2 text-orange-300 hover:text-orange-600 p-1 bg-orange-50 rounded-full" title="Remove Paragraph">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                            <textarea :name="'plan_extra_' + index" x-model="plan.extras[index]"
                                    x-init="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                                    @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                                    class="w-full bg-white/50 border-orange-200 rounded-lg text-sm text-orange-900 placeholder-orange-300 focus:ring-orange-500 focus:border-orange-500 p-2 min-h-[80px] overflow-hidden resize-none"
                                    placeholder="• Topic Sentence&#10;• Explain/Expand&#10;• Example"></textarea>
                    </div>
                </template>

                <!-- Add Paragraph Button -->
                <button @click="addParagraph()" class="w-full py-2 border-2 border-dashed border-orange-200 rounded-xl text-orange-400 font-bold hover:bg-orange-50 hover:border-orange-300 transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Add Paragraph
                </button>
            </div>
            @endif

            <!-- Detailed Text Analysis (below the chart/prompt, visible ONLY in Results Mode) -->
            <div id="detailed-text-analysis" x-show="showResults" class="mb-6 bg-white rounded-xl shadow-sm border border-indigo-200 overflow-hidden shrink-0" style="display: none;">
                <div class="p-4 border-b border-indigo-100 bg-indigo-50 flex justify-between items-center">
                    <h3 class="font-bold text-indigo-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Detailed Text Analysis
                    </h3>
                    <div class="flex items-center gap-3 text-xs font-medium">
                        <span class="bg-red-100 text-red-600 px-2 py-0.5 rounded">Error</span>
                        <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded">Improvement</span>
                        <span class="bg-yellow-100 text-yellow-700 px-2 py-0.5 rounded">Suggestion</span>
                    </div>
                </div>
                <div class="p-6 prose prose-indigo max-w-none leading-loose text-lg text-gray-800 bg-white">
                    <div x-show="!result?.correction_html" class="text-center py-8">
                         <p class="text-gray-400 italic animate-pulse mb-2">Analyzing text structure and grammar...</p>
                         <div class="text-left opacity-50" x-html="essay.replace(/\n/g, '<br>')"></div>
                    </div>
                    <div x-html="safeHtml"></div>
                </div>
            </div>
        </div>

        <!-- Right Column: Writing Area & Results -->
        <div id="writing-panel" class="min-w-0 lg:col-span-7 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden h-full flex flex-col">
            
            <!-- WRITING MODE HEADER -->
            <div x-show="!showResults" class="bg-indigo-50 px-6 py-4 border-b border-indigo-100 flex-none flex justify-between items-center">
                <div>
                     <div class="flex items-center gap-3">
                         <h3 class="text-lg font-bold text-indigo-800">Your Response</h3>
                         <span class="inline-flex items-center gap-1 bg-white px-2.5 py-1 rounded-lg border border-indigo-200 text-indigo-900 text-xs font-semibold shadow-xs">
                             <span>Count: <span x-text="wordCount" class="font-bold text-indigo-700">0</span> words</span>
                         </span>
                     </div>
                     <p class="text-sm text-indigo-600 mt-1">Write at least {{ $task == 2 ? '250' : '150' }} words.</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="text-xs font-mono bg-white px-2 py-1 rounded text-indigo-600 border border-indigo-100">
                        <span x-text="new Date(time * 1000).toISOString().substr(11, 8)">00:00:00</span>
                    </div>
                     <button @click="submitEssay()" :disabled="loading" class="px-6 py-2.5 bg-orange-600 text-white rounded-xl hover:bg-orange-700 transition shadow-lg font-bold text-base flex items-center gap-2 transform hover:scale-105 active:scale-95">
                        <span x-show="!loading">Submit Essay</span>
                        <span x-show="loading" class="animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full"></span>
                     </button>
                </div>
            </div>

            <!-- Helper Buttons Toolbar -->


            <!-- RESULT MODE HEADER -->
            <div x-show="showResults" class="bg-indigo-50 px-6 py-4 border-b border-indigo-100 flex-none flex justify-between items-center">
                 <h3 class="text-lg font-bold text-indigo-800">Evaluation Results</h3>
                 <div class="flex items-center gap-3">
                     <template x-if="lastSubmissionId">
                         <a :href="'/assignments/ielts-academic/writing/submission/' + lastSubmissionId" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg shadow-sm transition-colors" target="_blank">
                             <span>Halaman Hasil Pengerjaan Lengkap ↗</span>
                         </a>
                     </template>
                     <button @click="showResults = false" class="text-sm text-indigo-600 hover:text-indigo-800 underline">Back to Edit</button>
                 </div>
            </div>

            <!-- WRITING MODE CONTENT -->
            <div x-show="!showResults" class="p-6 flex-1 overflow-y-auto custom-scrollbar pb-32">
                <!-- Error Alert -->
                <div x-show="error" class="mb-4 p-3 bg-red-50 text-red-700 rounded text-sm" style="display: none;">
                    <p x-text="error"></p>
                    <template x-if="lastSubmissionId">
                        <div class="mt-2">
                            <p class="text-xs text-red-600 mb-2">Jawaban Anda sudah tersimpan. Sistem penilaian AI sedang bermasalah — silakan coba kirim ulang untuk mendapatkan penilaian.</p>
                            <button @click="retrySubmission()" :disabled="loading" class="px-4 py-1.5 bg-red-600 hover:bg-red-700 disabled:opacity-50 text-white text-xs font-bold rounded-lg transition-colors">
                                <span x-show="!loading">Coba Kirim Ulang</span>
                                <span x-show="loading">Mengirim...</span>
                            </button>
                        </div>
                    </template>
                </div>

                <textarea name="essay" x-model="essay" rows="25" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 transition-all text-base placeholder-gray-400 font-mono leading-relaxed resize-y" placeholder="{{ ($meeting->meeting_number >= 2000 || !empty($isGeneral)) ? 'Dear Sir or Madam,&#10;&#10;I am writing to...' : 'The chart illustrates...' }}"></textarea>

                <div class="mt-2 flex justify-end items-center text-xs text-gray-400">
                    <button @click="refreshEssay()" class="hover:text-red-500 flex items-center gap-1 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                        Reset Essay
                    </button>
                </div>
            </div>

            <!-- RESULT MODE CONTENT -->
             <div x-show="showResults" class="flex flex-col h-full overflow-hidden" x-data="{ activeTab: 'feedback' }" style="display: none;">
                
                <!-- Score Cards (Matched to Task 2 Design) -->
                <div class="p-6 border-b border-gray-100 bg-gray-50 flex flex-wrap gap-4 items-center justify-between">
                    <!-- Overall -->
                     <div class="flex items-center gap-3">
                        <span class="text-sm font-bold text-gray-500 uppercase tracking-wide">Overall</span>
                        <div class="w-12 h-12 rounded-full bg-indigo-100 flex items-center justify-center border-2 border-indigo-200">
                             <span class="text-xl font-extrabold text-indigo-700" x-text="result?.scores?.overall_band || '-'"></span>
                        </div>
                    </div>

                    <!-- Sub-scores -->
                    <div class="flex gap-3 overflow-x-auto pb-2">
                        <div class="flex flex-col items-center p-3 bg-white border border-gray-100 rounded-xl shadow-sm min-w-[80px]">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1">Task</span>
                            <span class="text-lg font-bold text-gray-800" x-text="result?.scores?.task_achievement || '-'"></span>
                        </div>
                         <div class="flex flex-col items-center p-3 bg-white border border-gray-100 rounded-xl shadow-sm min-w-[80px]">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1">Coherence</span>
                            <span class="text-lg font-bold text-gray-800" x-text="result?.scores?.coherence_cohesion || '-'"></span>
                        </div>
                         <div class="flex flex-col items-center p-3 bg-white border border-gray-100 rounded-xl shadow-sm min-w-[80px]">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1">Lexical</span>
                            <span class="text-lg font-bold text-gray-800" x-text="result?.scores?.lexical_resource || '-'"></span>
                        </div>
                         <div class="flex flex-col items-center p-3 bg-white border border-gray-100 rounded-xl shadow-sm min-w-[80px]">
                            <span class="text-[10px] font-bold text-gray-400 uppercase tracking-wide mb-1">Grammar</span>
                            <span class="text-lg font-bold text-gray-800" x-text="result?.scores?.grammatical_range || '-'"></span>
                        </div>
                    </div>
                </div>

                <!-- Tabs (Matched to Task 2 Design) -->
                <div class="flex border-b border-gray-200 bg-white overflow-x-auto no-scrollbar shadow-sm z-10">
                    <nav class="flex -mb-px">
                        <button @click="activeTab = 'feedback'" :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'feedback', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'feedback' }" class="whitespace-nowrap py-4 px-6 border-b-2 font-bold text-sm transition-colors uppercase tracking-wide">Examiner Feedback</button>
                        <button @click="activeTab = 'task_response'" :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'task_response', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'task_response' }" class="whitespace-nowrap py-4 px-6 border-b-2 font-bold text-sm transition-colors uppercase tracking-wide">Task Achievement</button>
                        <button @click="activeTab = 'coherence'" :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'coherence', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'coherence' }" class="whitespace-nowrap py-4 px-6 border-b-2 font-bold text-sm transition-colors uppercase tracking-wide">Coherence</button>
                        <button @click="activeTab = 'lexical'" :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'lexical', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'lexical' }" class="whitespace-nowrap py-4 px-6 border-b-2 font-bold text-sm transition-colors uppercase tracking-wide">Lexical</button>
                        <button @click="activeTab = 'grammar'" :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'grammar', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'grammar' }" class="whitespace-nowrap py-4 px-6 border-b-2 font-bold text-sm transition-colors uppercase tracking-wide">Grammar</button>
                        <button @click="activeTab = 'better'" :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'better', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'better' }" class="whitespace-nowrap py-4 px-6 border-b-2 font-bold text-sm transition-colors uppercase tracking-wide flex items-center gap-2">
                            <span>Model Answer</span>
                            <span x-show="improving && !result?.better_version" class="animate-spin h-3 w-3 border-2 border-indigo-500 border-t-transparent rounded-full"></span>
                        </button>
                    </nav>
                </div>
                
                <!-- CONTENT AREA -->
                <div class="flex-1 overflow-y-auto bg-gray-50/50 p-6">
                    
                    <!-- FEEDBACK TAB (Overall Summary) -->
                    <div x-show="activeTab === 'feedback'" class="max-w-3xl mx-auto space-y-6">
                         <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <h4 class="text-gray-800 font-bold mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Examiner Summary
                            </h4>
                            <p x-show="!result?.feedback?.overall_comment && !feedbackFailed" class="text-gray-400 italic animate-pulse py-4">Generating detailed feedback...</p>
                            <div x-show="feedbackFailed && !result?.feedback?.overall_comment" class="bg-amber-50 border border-amber-200 text-amber-800 p-3 rounded-lg flex items-center justify-between gap-4">
                                <span class="text-sm">Detailed feedback is taking longer than usual.</span>
                                <button type="button" @click="getFeedback()" class="text-sm font-semibold text-orange-600 hover:text-orange-700 whitespace-nowrap flex-shrink-0">Try again</button>
                            </div>
                            <p x-show="result?.feedback?.overall_comment" x-text="result?.feedback?.overall_comment" class="text-gray-600 leading-relaxed whitespace-pre-line"></p>
                        </div>
                    </div>

                    <!-- TASK ACHIEVEMENT TAB -->
                    <div x-show="activeTab === 'task_response'" class="max-w-3xl mx-auto space-y-6">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <strong class="block text-xs uppercase text-indigo-500 font-bold mb-3 tracking-wider">Task Achievement Detailed Feedback</strong>
                            <p x-show="!result?.feedback?.task_achievement && !feedbackFailed" class="text-gray-400 italic animate-pulse">Generating...</p>
                            <div x-show="feedbackFailed && !result?.feedback?.task_achievement" class="bg-amber-50 border border-amber-200 text-amber-800 p-3 rounded-lg flex items-center justify-between gap-4 mb-3">
                                <span class="text-sm">Detailed feedback is taking longer than usual.</span>
                                <button type="button" @click="getFeedback()" class="text-sm font-semibold text-orange-600 hover:text-orange-700 whitespace-nowrap flex-shrink-0">Try again</button>
                            </div>
                            <template x-if="getBulletPoints(result?.feedback?.task_achievement)">
                                <ul class="list-disc list-inside space-y-1.5 text-gray-700 leading-relaxed">
                                    <template x-for="(point, idx) in getBulletPoints(result?.feedback?.task_achievement)" :key="idx">
                                        <li x-text="point"></li>
                                    </template>
                                </ul>
                            </template>
                            <p x-show="result?.feedback?.task_achievement && !getBulletPoints(result?.feedback?.task_achievement)" x-text="result?.feedback?.task_achievement" class="text-gray-700 leading-relaxed"></p>
                        </div>

                         <!-- Upgrade Action -->
                        <div class="bg-green-50 p-6 rounded-xl border border-green-100 flex flex-col items-center justify-center text-center gap-4">
                            <h4 class="font-bold text-green-800">Want to boost your Task Achievement score?</h4>
                            <p class="text-sm text-green-700 max-w-md">Get specific advice on which content is missing or underdeveloped.</p>
                            <button @click="upgradeTaskResponse()" :disabled="taskResponseUpgrading" class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-sm transition-all transform hover:scale-105 flex items-center gap-2">
                                <svg x-show="!taskResponseUpgrading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                <span x-show="taskResponseUpgrading" class="animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full"></span>
                                <span>Analyze & Upgrade Task Achievement (Band 7-9)</span>
                            </button>
                        </div>
                        
                        <!-- Upgrade Results -->
                        <div x-show="result?.task_response_improvements?.length > 0" class="mt-4 border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm border-collapse bg-white">
                                    <thead class="bg-gray-50 border-b border-gray-200">
                                        <tr>
                                            <th class="p-3 font-bold text-gray-700 w-1/3">Kutipan Asli (English) / Masalah</th>
                                            <th class="p-3 font-bold text-gray-700 w-1/3">Penjelasan</th>
                                            <th class="p-3 font-bold text-gray-700 w-1/3">Perbaikan (English)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <template x-for="(item, idx) in result?.task_response_improvements || []" :key="idx">
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="p-3 align-top text-red-700" x-text="item.text"></td>
                                                <td class="p-3 align-top text-gray-600 text-xs leading-relaxed" x-text="item.explanation"></td>
                                                <td class="p-3 align-top font-medium text-green-700" x-text="item.improved"></td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- COHERENCE TAB -->
                    <div x-show="activeTab === 'coherence'" class="max-w-3xl mx-auto space-y-6">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <strong class="block text-xs uppercase text-indigo-500 font-bold mb-3 tracking-wider">Coherence & Cohesion Detailed Feedback</strong>
                            <p x-show="!result?.feedback?.coherence_cohesion && !feedbackFailed" class="text-gray-400 italic animate-pulse">Generating...</p>
                            <div x-show="feedbackFailed && !result?.feedback?.coherence_cohesion" class="bg-amber-50 border border-amber-200 text-amber-800 p-3 rounded-lg flex items-center justify-between gap-4 mb-3">
                                <span class="text-sm">Detailed feedback is taking longer than usual.</span>
                                <button type="button" @click="getFeedback()" class="text-sm font-semibold text-orange-600 hover:text-orange-700 whitespace-nowrap flex-shrink-0">Try again</button>
                            </div>
                            <template x-if="getBulletPoints(result?.feedback?.coherence_cohesion)">
                                <ul class="list-disc list-inside space-y-1.5 text-gray-700 leading-relaxed">
                                    <template x-for="(point, idx) in getBulletPoints(result?.feedback?.coherence_cohesion)" :key="idx">
                                        <li x-text="point"></li>
                                    </template>
                                </ul>
                            </template>
                            <p x-show="result?.feedback?.coherence_cohesion && !getBulletPoints(result?.feedback?.coherence_cohesion)" x-text="result?.feedback?.coherence_cohesion" class="text-gray-700 leading-relaxed"></p>
                        </div>
                        
                        <!-- Used Cohesive Devices -->
                        <div x-show="result?.cohesive_devices_used?.length > 0" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100" style="display: none;">
                            <strong class="block text-xs uppercase text-blue-500 font-bold mb-4 tracking-wider">Linking Words & Connections Used</strong>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <template x-for="(device, idx) in result?.cohesive_devices_used || []" :key="idx">
                                    <div class="flex flex-col bg-gray-50 border border-gray-200 rounded-lg p-3 shadow-sm">
                                        <span class="text-indigo-700 font-bold mb-1" x-text="device.word"></span>
                                        <span class="text-xs text-gray-600" x-text="device.evaluation"></span>
                                    </div>
                                </template>
                            </div>
                        </div>

                         <!-- Upgrade Action -->
                        <div class="bg-blue-50 p-6 rounded-xl border border-blue-100 flex flex-col items-center justify-center text-center gap-4">
                            <h4 class="font-bold text-blue-800">Improve flow and linking words?</h4>
                            <button @click="upgradeCoherence()" :disabled="coherenceUpgrading" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-sm transition-all transform hover:scale-105 flex items-center gap-2">
                                <svg x-show="!coherenceUpgrading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                <span x-show="coherenceUpgrading" class="animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full"></span>
                                <span>Analyze & Upgrade Coherence (Band 7-9)</span>
                            </button>
                        </div>

                        <!-- Upgrade Results -->
                        <div x-show="result?.feedback?.coherence_improvements?.length > 0" class="mt-4 border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm border-collapse bg-white">
                                    <thead class="bg-gray-50 border-b border-gray-200">
                                        <tr>
                                            <th class="p-3 font-bold text-gray-700 w-1/3">Kutipan Asli (English) / Masalah</th>
                                            <th class="p-3 font-bold text-gray-700 w-1/3">Penjelasan</th>
                                            <th class="p-3 font-bold text-gray-700 w-1/3">Perbaikan (English)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <template x-for="(item, idx) in result?.feedback?.coherence_improvements || []" :key="idx">
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="p-3 align-top text-red-700" x-text="item.text"></td>
                                                <td class="p-3 align-top text-gray-600 text-xs leading-relaxed" x-text="item.explanation"></td>
                                                <td class="p-3 align-top font-medium text-green-700" x-text="item.improved"></td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- LEXICAL TAB -->
                    <div x-show="activeTab === 'lexical'" class="max-w-3xl mx-auto space-y-6">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <strong class="block text-xs uppercase text-indigo-500 font-bold mb-3 tracking-wider">Lexical Resource Detailed Feedback</strong>
                            <p x-show="!result?.feedback?.lexical_resource && !feedbackFailed" class="text-gray-400 italic animate-pulse">Generating...</p>
                            <div x-show="feedbackFailed && !result?.feedback?.lexical_resource" class="bg-amber-50 border border-amber-200 text-amber-800 p-3 rounded-lg flex items-center justify-between gap-4 mb-3">
                                <span class="text-sm">Detailed feedback is taking longer than usual.</span>
                                <button type="button" @click="getFeedback()" class="text-sm font-semibold text-orange-600 hover:text-orange-700 whitespace-nowrap flex-shrink-0">Try again</button>
                            </div>
                            <template x-if="getBulletPoints(result?.feedback?.lexical_resource)">
                                <ul class="list-disc list-inside space-y-1.5 text-gray-700 leading-relaxed">
                                    <template x-for="(point, idx) in getBulletPoints(result?.feedback?.lexical_resource)" :key="idx">
                                        <li x-text="point"></li>
                                    </template>
                                </ul>
                            </template>
                            <p x-show="result?.feedback?.lexical_resource && !getBulletPoints(result?.feedback?.lexical_resource)" x-text="result?.feedback?.lexical_resource" class="text-gray-700 leading-relaxed"></p>
                        </div>
                        
                        <!-- Good Vocabulary Used -->
                        <div x-show="result?.good_vocabulary_used?.length > 0" class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100" style="display: none;">
                            <strong class="block text-xs uppercase text-teal-500 font-bold mb-4 tracking-wider">Good Vocabulary & Expressions Used</strong>
                            <div class="flex flex-wrap gap-2">
                                <template x-for="(vocab, idx) in result?.good_vocabulary_used || []" :key="idx">
                                    <div class="bg-teal-50 border border-teal-200 rounded-full px-4 py-2 flex items-center gap-2 shadow-sm">
                                        <span class="font-bold text-teal-800" x-text="vocab.word"></span>
                                        <span class="text-xs text-teal-600 border-l border-teal-300 pl-2" x-text="vocab.meaning"></span>
                                    </div>
                                </template>
                            </div>
                        </div>
                        
                         <!-- Upgrade Results -->
                         <div x-show="result?.vocabulary_improvements?.length > 0" class="mb-4 border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm border-collapse bg-white">
                                    <thead class="bg-gray-50 border-b border-gray-200">
                                        <tr>
                                            <th class="p-3 font-bold text-gray-700 w-1/3">Kutipan Asli (English) / Masalah</th>
                                            <th class="p-3 font-bold text-gray-700 w-1/3">Penjelasan</th>
                                            <th class="p-3 font-bold text-gray-700 w-1/3">Perbaikan (English)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <template x-for="(item, idx) in result?.vocabulary_improvements || []" :key="idx">
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="p-3 align-top text-red-700" x-text="item.text"></td>
                                                <td class="p-3 align-top text-gray-600 text-xs leading-relaxed" x-text="item.explanation"></td>
                                                <td class="p-3 align-top font-medium text-green-700" x-text="item.improved"></td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                         </div>
                        
                        <!-- Upgrade Action -->
                        <div class="bg-indigo-50 p-6 rounded-xl border border-indigo-100 flex flex-col items-center justify-center text-center gap-4">
                            <h4 class="font-bold text-indigo-800">Learn Band 9 Vocabulary?</h4>
                             <button @click="upgradeLexical()" :disabled="lexicalUpgrading" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-sm transition-all transform hover:scale-105 flex items-center gap-2">
                                <svg x-show="!lexicalUpgrading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                <span x-show="lexicalUpgrading" class="animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full"></span>
                                <span>Analyze & Upgrade Vocabulary (Band 7-9)</span>
                            </button>
                        </div>
                    </div>

                    <!-- GRAMMAR TAB -->
                    <div x-show="activeTab === 'grammar'" class="max-w-3xl mx-auto space-y-6">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <strong class="block text-xs uppercase text-indigo-500 font-bold mb-3 tracking-wider">Grammatical Range Detailed Feedback</strong>
                            <p x-show="!result?.feedback?.grammatical_range && !feedbackFailed" class="text-gray-400 italic animate-pulse">Generating...</p>
                            <div x-show="feedbackFailed && !result?.feedback?.grammatical_range" class="bg-amber-50 border border-amber-200 text-amber-800 p-3 rounded-lg flex items-center justify-between gap-4 mb-3">
                                <span class="text-sm">Detailed feedback is taking longer than usual.</span>
                                <button type="button" @click="getFeedback()" class="text-sm font-semibold text-orange-600 hover:text-orange-700 whitespace-nowrap flex-shrink-0">Try again</button>
                            </div>
                            <template x-if="getBulletPoints(result?.feedback?.grammatical_range)">
                                <ul class="list-disc list-inside space-y-1.5 text-gray-700 leading-relaxed">
                                    <template x-for="(point, idx) in getBulletPoints(result?.feedback?.grammatical_range)" :key="idx">
                                        <li x-text="point"></li>
                                    </template>
                                </ul>
                            </template>
                            <p x-show="result?.feedback?.grammatical_range && !getBulletPoints(result?.feedback?.grammatical_range)" x-text="result?.feedback?.grammatical_range" class="text-gray-700 leading-relaxed"></p>
                        </div>

                         <!-- Upgrade Results -->
                         <div x-show="result?.grammar_improvements?.length > 0" class="mb-4 border border-gray-200 rounded-xl overflow-hidden shadow-sm">
                            <div class="overflow-x-auto">
                                <table class="w-full text-left text-sm border-collapse bg-white">
                                    <thead class="bg-gray-50 border-b border-gray-200">
                                        <tr>
                                            <th class="p-3 font-bold text-gray-700 w-1/3">Kutipan Asli (English) / Masalah</th>
                                            <th class="p-3 font-bold text-gray-700 w-1/3">Penjelasan</th>
                                            <th class="p-3 font-bold text-gray-700 w-1/3">Perbaikan (English)</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        <template x-for="(item, idx) in result?.grammar_improvements || []" :key="idx">
                                            <tr class="hover:bg-gray-50 transition-colors">
                                                <td class="p-3 align-top text-red-700" x-text="item.text"></td>
                                                <td class="p-3 align-top text-gray-600 text-xs leading-relaxed" x-text="item.explanation"></td>
                                                <td class="p-3 align-top font-medium text-green-700" x-text="item.improved"></td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                         </div>

                         <!-- Upgrade Action -->
                        <div class="bg-purple-50 p-6 rounded-xl border border-purple-100 flex flex-col items-center justify-center text-center gap-4">
                            <h4 class="font-bold text-purple-800">Master Complex Structures?</h4>
                             <button @click="upgradeGrammar()" :disabled="grammarUpgrading" class="px-6 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-lg shadow-sm transition-all transform hover:scale-105 flex items-center gap-2">
                                <svg x-show="!grammarUpgrading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                <span x-show="grammarUpgrading" class="animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full"></span>
                                <span>Analyze & Upgrade Grammar (Band 7-9)</span>
                            </button>
                        </div>
                    </div>

                    <!-- BETTER VERSION TAB -->
                    <div x-show="activeTab === 'better'" class="max-w-3xl mx-auto">
                         <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden">
                            <div class="absolute top-0 right-0 p-4 opacity-10">
                                <svg class="w-32 h-32 text-indigo-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path></svg>
                            </div>
                            <h4 class="text-2xl font-bold text-gray-900 mb-6">Band 9 Model Answer</h4>
                            <div class="prose prose-lg max-w-none text-gray-700 leading-relaxed font-serif">
                                <div x-show="!result?.better_version" class="animate-pulse text-gray-400 py-8">Crafting Band 9 Version...</div>
                                <div x-html="result?.better_version?.replace(/\n/g, '<br>')"></div>
                            </div>
                         </div>
                    </div>

                </div>
             </div>
        </div>
    </div>
    <!-- EDIT MODAL -->
    @if(Auth::check() && Auth::user()->role === 'admin')
    <div x-show="showEditModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="fixed inset-0 bg-black bg-opacity-50" @click="showEditModal = false" x-transition.opacity></div>
        <div class="relative min-h-screen flex items-center justify-center p-4">
            <div class="relative bg-white rounded-2xl shadow-xl max-w-lg w-full p-6" x-transition.scale>
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Edit Practice Topic</h3>
                    <button @click="showEditModal = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form action="{{ route('assignments.ielts.writing.update', $meeting->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                            <input type="text" name="title" x-model="editForm.title" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Meeting Number</label>
                            <input type="number" name="meeting_number" x-model="editForm.meeting_number" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                            <p class="mt-1 text-xs text-gray-500">Current ID: {{ $meeting->meeting_number }}</p>
                        </div>

                         <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Diagram/Image (Optional)</label>
                            <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="mt-1 text-xs text-gray-500">Upload to replace the diagram. Max 2MB.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Prompt</label>
                            <textarea name="prompt" x-model="editForm.prompt" rows="5" class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500 font-mono text-sm" required></textarea>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-end gap-3">
                        <button type="button" @click="showEditModal = false" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
    
    @include('assignments.ielts.writing.partials.practice_panels')
    @include('assignments.ielts.writing.practice_toolbar')
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const chartConfig = @json($chartPayload);

    const setInstruction = (title, type = 'chart') => {
        const box = document.getElementById('questionInstructionBox');
        if (box) {
            box.innerHTML = `
                <p class="font-bold mb-2 text-gray-800">The ${type} below shows ${title}.</p>
                <p class="italic text-gray-600">Summarise the information by selecting and reporting the main features, and make comparisons where relevant.</p>
            `;
            box.classList.remove('hidden');
        }
    };

    const pieLabelsPlugin = {
        id: 'pieLabelsPlugin',
        afterDraw: function(chart) {
            if (chart.config.type !== 'pie') return;
            const ctx = chart.ctx;
            chart.data.datasets.forEach((dataset, i) => {
                const meta = chart.getDatasetMeta(i);
                meta.data.forEach((element, index) => {
                    const value = dataset.data[index];
                    if (value === 0 || value === null || value === undefined) return;

                    let total = dataset.data.reduce((acc, curr) => acc + curr, 0);
                    let percentage = Math.round((value / total) * 100) + '%';

                    const position = element.tooltipPosition();

                    const bg = (Array.isArray(dataset.backgroundColor) ? dataset.backgroundColor[index] : dataset.backgroundColor) || '#ffffff';
                    const isLight = bg === '#ffffff' || bg === '#d1d5db' || bg === '#e5e7eb' || bg === '#9ca3af' || bg.toLowerCase().includes('fff') || bg === 'white';

                    ctx.save();
                    ctx.font = 'bold 15px sans-serif';
                    ctx.fillStyle = isLight ? '#111827' : '#ffffff';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';

                    if (!isLight) {
                        ctx.shadowColor = 'rgba(0, 0, 0, 0.5)';
                        ctx.shadowBlur = 3;
                    }

                    ctx.fillText(percentage, position.x, position.y);
                    ctx.restore();
                });
            });
        }
    };

    if (chartConfig.kind === 'line') {
        const lineCanvas = document.getElementById('practiceLineChart');
        if (lineCanvas) {
            setInstruction(chartConfig.title, 'chart');

            const cambridgeColors = ['#111827', '#1f2937', '#374151', '#4b5563', '#000000'];
            const cambridgeDashes = [[], [6, 4], [2, 2], [8, 4], [4, 4]];
            const cambridgePointStyles = ['triangle', 'rect', 'rectRot', 'crossRot', 'circle'];

            const styledDatasets = chartConfig.datasets.map((ds, idx) => {
                const color = cambridgeColors[idx % cambridgeColors.length];
                return {
                    ...ds,
                    fill: false,
                    tension: 0,
                    borderWidth: 2.5,
                    borderColor: color,
                    borderDash: ds.borderDash || cambridgeDashes[idx % cambridgeDashes.length],
                    pointStyle: ds.pointStyle || cambridgePointStyles[idx % cambridgePointStyles.length],
                    pointRadius: 6,
                    pointHoverRadius: 8,
                    pointBackgroundColor: (idx % 2 === 1) ? '#ffffff' : color,
                    pointBorderColor: color,
                    pointBorderWidth: 2
                };
            });

            new Chart(lineCanvas.getContext('2d'), {
                type: 'line',
                data: {
                    labels: chartConfig.labels,
                    datasets: styledDatasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    elements: {
                        line: { tension: 0 }
                    },
                    plugins: {
                        title: { display: true, text: chartConfig.title, font: { size: 16, weight: 'bold' } },
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: { size: 13 },
                                usePointStyle: true,
                                padding: 20
                            }
                        }
                    },
                    scales: chartConfig.scales || {
                        y: { grid: { color: 'rgba(0,0,0,0.08)' } },
                        x: { grid: { color: 'rgba(0,0,0,0.08)' } }
                    }
                }
            });
        }
    } else if (chartConfig.kind === 'bar') {
        const barCanvas = document.getElementById('practiceBarChart');
        if (barCanvas) {
            setInstruction(chartConfig.title, 'chart');

            const cambridgeBarColors = [
                { bg: '#111827', border: '#111827' }, // Dark Charcoal / Black
                { bg: '#9ca3af', border: '#111827' }, // Medium Gray
                { bg: '#e5e7eb', border: '#111827' }, // Light Gray
                { bg: '#374151', border: '#111827' }, // Dark Slate
                { bg: '#ffffff', border: '#111827' }  // White with black border
            ];

            const styledDatasets = chartConfig.datasets.map((ds, idx) => {
                const col = cambridgeBarColors[idx % cambridgeBarColors.length];
                return {
                    ...ds,
                    backgroundColor: col.bg,
                    borderColor: col.border,
                    borderWidth: 1.5,
                    borderRadius: 0,
                    barPercentage: 0.85,
                    categoryPercentage: 0.8
                };
            });

            new Chart(barCanvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: chartConfig.labels,
                    datasets: styledDatasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: { 
                            display: true, 
                            text: chartConfig.title, 
                            font: { size: 16, weight: 'bold', family: 'sans-serif' },
                            color: '#111827',
                            padding: { top: 10, bottom: 20 }
                        },
                        legend: { 
                            position: 'bottom', 
                            labels: { 
                                font: { size: 13, family: 'sans-serif' },
                                color: '#111827',
                                usePointStyle: false,
                                boxWidth: 18,
                                boxHeight: 12,
                                padding: 15
                            } 
                        }
                    },
                    scales: {
                        y: { 
                            border: { color: '#111827', width: 1.5 },
                            grid: { color: 'rgba(0, 0, 0, 0.12)' },
                            ticks: {
                                font: { size: 12, family: 'sans-serif' },
                                color: '#111827',
                                callback: function(val) {
                                    return val + (chartConfig.yUnit ? chartConfig.yUnit : (chartConfig.title.includes('%') ? '%' : ''));
                                }
                            },
                            title: {
                                display: true,
                                text: chartConfig.yLabel || (chartConfig.title.includes('%') ? '% of people' : ''),
                                color: '#111827',
                                font: { size: 13, weight: 'bold' }
                            }
                        },
                        x: {
                            border: { color: '#111827', width: 1.5 },
                            grid: { display: false },
                            ticks: {
                                font: { size: 12, weight: '500', family: 'sans-serif' },
                                color: '#111827'
                            }
                        }
                    }
                }
            });
        }
    } else if (chartConfig.kind === 'pie') {
        const container = document.getElementById('practicePieContainer');
        if (container) {
            setInstruction(chartConfig.title, 'chart');

            const pieGrid = document.getElementById('pieGrid');
            const pieSharedLegend = document.getElementById('pieSharedLegend');
            const pieMainTitle = document.getElementById('pieMainTitle');

            if (pieMainTitle) {
                pieMainTitle.innerText = chartConfig.title;
                pieMainTitle.classList.remove('hidden');
            }

            // Standardize into sub-charts array
            let subCharts = chartConfig.charts;
            if (!subCharts && chartConfig.datasets && chartConfig.datasets.length > 1) {
                subCharts = chartConfig.datasets.map(ds => ({
                    subTitle: ds.label || '',
                    data: ds.data
                }));
            } else if (!subCharts && chartConfig.datasets && chartConfig.datasets.length === 1) {
                subCharts = [{
                    subTitle: '',
                    data: chartConfig.datasets[0].data
                }];
            }

            if (!subCharts) {
                subCharts = [{ subTitle: '', data: [] }];
            }

            const labels = chartConfig.labels || [];
            const cambridgePieColors = ['#111827', '#d1d5db', '#6b7280', '#ffffff', '#9ca3af', '#374151'];

            if (pieGrid) pieGrid.innerHTML = '';
            if (pieSharedLegend) pieSharedLegend.innerHTML = '';

            const numCharts = subCharts.length;
            const chartWidthClass = numCharts === 1 ? 'max-w-[460px] w-full' : (numCharts === 2 ? 'w-full md:w-[46%]' : 'w-full md:w-[31%]');
            const chartHeightClass = numCharts === 1 ? 'h-[400px]' : (numCharts === 2 ? 'h-[360px]' : 'h-[320px]');

            subCharts.forEach((cItem, cIdx) => {
                const card = document.createElement('div');
                card.className = `flex flex-col items-center justify-center ${chartWidthClass} p-2`;
                
                if (cItem.subTitle) {
                    const subHeader = document.createElement('h4');
                    subHeader.className = 'font-bold text-gray-900 text-base mb-3 text-center tracking-tight';
                    subHeader.innerText = cItem.subTitle;
                    card.appendChild(subHeader);
                }

                const canvasWrapper = document.createElement('div');
                canvasWrapper.className = `relative w-full ${chartHeightClass}`;

                const canvas = document.createElement('canvas');
                canvas.id = `pieSubChart_${cIdx}`;
                canvasWrapper.appendChild(canvas);
                card.appendChild(canvasWrapper);
                pieGrid.appendChild(card);

                const bgColors = cItem.data.map((_, idx) => cambridgePieColors[idx % cambridgePieColors.length]);

                new Chart(canvas.getContext('2d'), {
                    type: 'pie',
                    plugins: [pieLabelsPlugin],
                    data: {
                        labels: labels,
                        datasets: [{
                            data: cItem.data,
                            backgroundColor: bgColors,
                            borderColor: '#111827',
                            borderWidth: 1.5
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            title: { display: false },
                            legend: { 
                                display: numCharts === 1, 
                                position: 'bottom', 
                                labels: { font: { size: 13, family: 'sans-serif' }, color: '#111827', padding: 15 } 
                            }
                        }
                    }
                });
            });

            // Build shared legend if double or triple pie chart
            if (numCharts > 1 && pieSharedLegend) {
                labels.forEach((label, idx) => {
                    const color = cambridgePieColors[idx % cambridgePieColors.length];
                    const legendItem = document.createElement('div');
                    legendItem.className = 'flex items-center gap-2 text-sm text-gray-800 font-medium px-3 py-1.5 bg-gray-50 border border-gray-200 rounded-md shadow-xs';
                    
                    const box = document.createElement('span');
                    box.style.width = '14px';
                    box.style.height = '14px';
                    box.style.backgroundColor = color;
                    box.style.border = '1.5px solid #111827';
                    box.style.borderRadius = '2px';
                    box.style.display = 'inline-block';
                    
                    const text = document.createElement('span');
                    text.innerText = label;
                    
                    legendItem.appendChild(box);
                    legendItem.appendChild(text);
                    pieSharedLegend.appendChild(legendItem);
                });
            }
        }
    } else if (chartConfig.kind === 'table') {
        const tableContainer = document.getElementById('practiceTableContainer');
        if (tableContainer) {
            setInstruction(chartConfig.title || 'Table Data', 'table');

            const renderSingleTable = (tableData) => {
                const titleHtml = tableData.title
                    ? `<h4 class="font-bold text-gray-900 text-base mb-3 text-center tracking-tight">${tableData.title}</h4>`
                    : '';

                let tableHtml = `
                    <div class="my-4 overflow-x-auto">
                        ${titleHtml}
                        <table class="min-w-full bg-white border-2 border-gray-900 text-sm md:text-base text-gray-900 border-collapse">
                            <thead>
                                <tr class="bg-gray-100 font-bold uppercase text-gray-900 tracking-wide border-b-2 border-gray-900">
                `;

                tableData.headers.forEach((header, idx) => {
                    const alignClass = idx === 0 ? 'text-left' : 'text-center';
                    tableHtml += `<th class="px-4 py-3 border border-gray-900 ${alignClass}">${header}</th>`;
                });

                tableHtml += `</tr></thead><tbody class="font-medium text-gray-900">`;

                tableData.rows.forEach((row, rowIndex) => {
                    tableHtml += `<tr class="bg-white hover:bg-gray-50 transition-colors">`;
                    row.forEach((cell, index) => {
                        const alignClass = index === 0 ? 'text-left font-bold text-gray-900' : 'text-center text-gray-900';
                        tableHtml += `<td class="px-4 py-3 border border-gray-400 ${alignClass}">${cell}</td>`;
                    });
                    tableHtml += `</tr>`;
                });

                tableHtml += `</tbody></table></div>`;
                return tableHtml;
            };

            let html = '';
            if (Array.isArray(chartConfig.doubleTables) && chartConfig.doubleTables.length > 0) {
                html = '<div class="space-y-6">';
                chartConfig.doubleTables.forEach((tableData) => {
                    html += renderSingleTable(tableData);
                });
                html += '</div>';
            } else {
                html = renderSingleTable(chartConfig);
            }

            tableContainer.innerHTML = html;
            tableContainer.classList.remove('hidden');
        }
    } else if (chartConfig.kind === 'mixed') {
        const mixedContainer = document.getElementById('practiceMixedContainer');
        if (mixedContainer) {
            const configs = chartConfig.charts || [];
            if (configs.length === 0) {
                mixedContainer.innerHTML = '<p class="text-gray-500 text-center py-10">No mixed chart data available for this practice item.</p>';
            } else {
                const title = configs[0].title || 'statistical data';
                setInstruction(title, 'charts');

                mixedContainer.innerHTML = '';

                // Cambridge textbook-style grayscale palette, matching the standalone
                // line/pie chart types elsewhere on this page. Only applied when the
                // chart's own data doesn't already specify explicit colors.
                const grayscaleFill = ['#111827', '#4b5563', '#9ca3af', '#d1d5db', '#6b7280', '#374151'];
                const grayscaleBorder = ['#111827', '#1f2937', '#374151', '#4b5563', '#000000'];

                configs.forEach((config, index) => {
                    const wrapper = document.createElement('div');
                    wrapper.className = "relative w-full min-w-[300px] flex-shrink-0 bg-white rounded-lg shadow-sm border border-gray-100 p-4 overflow-auto";
                    wrapper.style.height = "500px";

                    if (config.type === 'table') {
                        let tableHtml = `
                            <div class="h-full w-full flex flex-col">
                                ${config.title ? `<h3 class="text-center font-bold text-gray-700 mb-2" style="font-size: 16px;">${config.title}</h3>` : ''}
                                <div class="overflow-auto flex-1">
                                    <table class="min-w-full text-base text-center text-gray-800 whitespace-nowrap">
                                        <thead class="bg-gray-800 font-extrabold uppercase text-white tracking-wider shadow-md sticky top-0">
                                            <tr>`;

                        config.headers.forEach(header => {
                            tableHtml += `<th class="px-4 py-3 text-sm">${header}</th>`;
                        });

                        tableHtml += `   </tr>
                                        </thead>
                                        <tbody class="divide-y divide-gray-100 font-bold text-sm">`;

                        config.rows.forEach((row, rowIndex) => {
                            const rowClass = rowIndex % 2 === 0 ? 'bg-gray-100' : 'bg-white';
                            tableHtml += `<tr class="${rowClass} hover:bg-gray-200 transition-colors duration-150">`;
                            row.forEach((cell, cellIndex) => {
                                const alignClass = cellIndex === 0 ? 'text-left text-gray-800' : '';
                                tableHtml += `<td class="px-4 py-3 ${alignClass}">${cell}</td>`;
                            });
                            tableHtml += `</tr>`;
                        });

                        tableHtml += `   </tbody>
                                    </table>
                                </div>
                            </div>`;

                        wrapper.innerHTML = tableHtml;
                        mixedContainer.appendChild(wrapper);
                    } else if (config.type === 'pie_group') {
                        // Multiple small pie charts (e.g. one per year) sharing the same labels.
                        wrapper.innerHTML = '';
                        wrapper.classList.add('flex', 'flex-col');

                        if (config.title) {
                            const titleEl = document.createElement('h3');
                            titleEl.className = "text-center font-bold text-gray-700 mb-2";
                            titleEl.style.fontSize = '16px';
                            titleEl.textContent = config.title;
                            wrapper.appendChild(titleEl);
                        }

                        const chartsRow = document.createElement('div');
                        chartsRow.className = "flex-1 flex flex-row gap-4 justify-center items-stretch min-h-0";
                        wrapper.appendChild(chartsRow);
                        mixedContainer.appendChild(wrapper);

                        (config.charts || []).forEach((subChart, subIndex) => {
                            const subWrapper = document.createElement('div');
                            subWrapper.className = "relative flex-1 min-w-[150px]";
                            const subCanvas = document.createElement('canvas');
                            subCanvas.id = `mixedChart_${index}_${subIndex}`;
                            subWrapper.appendChild(subCanvas);
                            chartsRow.appendChild(subWrapper);

                            new Chart(subCanvas.getContext('2d'), {
                                type: 'pie',
                                plugins: [pieLabelsPlugin],
                                data: {
                                    labels: config.labels,
                                    datasets: [{
                                        data: subChart.data,
                                        backgroundColor: subChart.backgroundColor || grayscaleFill,
                                        borderColor: '#111827',
                                        borderWidth: 1.5
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: {
                                        title: { display: true, text: subChart.subTitle || '', font: { size: 14, weight: 'bold' }, color: '#111827' },
                                        legend: { position: 'bottom', labels: { font: { size: 11 }, color: '#111827' } }
                                    }
                                }
                            });
                        });
                    } else {
                        const canvas = document.createElement('canvas');
                        canvas.id = `mixedChart_${index}`;
                        canvas.style.width = '100%';
                        canvas.style.height = '100%';

                        wrapper.appendChild(canvas);
                        mixedContainer.appendChild(wrapper);

                        const chartType = config.type || 'bar';
                        const styledDatasets = (config.datasets || []).map((ds, dsIdx) => ({
                            ...ds,
                            backgroundColor: ds.backgroundColor || grayscaleFill[dsIdx % grayscaleFill.length],
                            borderColor: ds.borderColor || grayscaleBorder[dsIdx % grayscaleBorder.length],
                        }));

                        new Chart(canvas.getContext('2d'), {
                            type: chartType,
                            plugins: chartType === 'pie' ? [pieLabelsPlugin] : [],
                            data: {
                                labels: config.labels,
                                datasets: styledDatasets
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    title: { display: !!config.title, text: config.title, font: { size: 16 } },
                                    legend: { position: 'bottom', labels: { font: { size: 14 } } }
                                },
                                scales: config.scales || {}
                            }
                        });
                    }
                });
            }
        }
    } else if (chartConfig.kind === 'flowchart' || chartConfig.kind === 'map') {
        if (chartConfig.instructionTitle) {
            setInstruction(chartConfig.instructionTitle, chartConfig.instructionType);
        }
    }
});

// Some drafted/pasted essay content (e.g. copied from an AI chat that used math-mode
// markup) ends up with literal LaTeX temperature notation like "$105^{\circ}\text{C}$"
// instead of plain "105°C". This has shown up baked into a student/admin's saved essay
// text (localStorage/autosave) for at least one Task 1 item. Sanitize on every load so
// it self-heals wherever it recurs, rather than patching one meeting's stored text.
function sanitizeLatexDegrees(text) {
    if (!text) return text;
    return text
        .replace(/\$?\s*(\d+(?:\.\d+)?)\s*\^\{?\\circ\}?\s*\\text\{([A-Za-z]+)\}\s*\$?/g, '$1°$2')
        .replace(/\$?\s*(\d+(?:\.\d+)?)\s*\^\{?\\circ\}?\s*\$?/g, '$1°');
}

document.addEventListener('alpine:init', () => {
    Alpine.data('practiceView', (meetingId, taskType, idioms = [], collocations = []) => ({
        // State
        essay: '', 
        time: 0,
        interval: null,
        loading: false,
        improving: false,
        error: null,
        lastSubmissionId: null,
        showResults: false,
        feedbackFailed: false,
        correctionFailed: false,
        improveFailed: false,
        taskResponseUpgrading: false,
        coherenceUpgrading: false,
        lexicalUpgrading: false,
        grammarUpgrading: false,
        // Helper Panels
        isIdiomsOpen: false,
        isCollocationsOpen: false,
        idioms: idioms,
        collocations: collocations,
        // Plan State
        plan: {
            intro: '',
            body1: '',
            body2: '',
            conclusion: '',
            extras: []
        },
        draftSyncTimer: null,
        _essayRestoredLocally: false,

        // Admin Edit State
        showEditModal: false,
        editForm: {
            title: '',
            meeting_number: '',
            prompt: ''
        },

        result: {
            scores: {},
            feedback: null,
            correction_html: null,
            better_version: null,
            grammar_improvements: [],
            cohesive_devices_used: [],
            good_vocabulary_used: [],
            vocabulary_improvements: []
        },
        
        // Computed
        get wordCount() {
            if (this.essay.trim() === '') {
                return 0;
            }

            const tokens = this.essay.trim().split(/\s+/).filter(Boolean);

            // Count only tokens containing letters; pure numbers/punctuation are excluded.
            return tokens.filter(token => /[A-Za-z]/.test(token)).length;
        },

        get hasCategories() {
             return this.collocations && this.collocations.length > 0 && !!this.collocations[0].category;
        },

        get groupedCollocations() {
             if (!this.hasCategories) return {};
             return this.collocations.reduce((acc, item) => {
                 if (!item) return acc;
                 const cat = item.category || 'General';
                 if (!acc[cat]) acc[cat] = [];
                 acc[cat].push(item);
                 return acc;
             }, {});
        },

        
        get safeHtml() {
            const html = this.result?.correction_html;
            if (!html || html === 'undefined') return '<p class="text-gray-500 italic">No correction generated.</p>';
            return html;
        },

        // Init
        init() {
            // Restore Essay local backup if exists (AutoSave handles main restore)
            const key = 'ielts_writing_practice_' + meetingId;
            const saved = localStorage.getItem(key);
            if (saved && saved !== 'undefined') {
                 this.essay = sanitizeLatexDegrees(saved);
                 this._essayRestoredLocally = true;
            }

            this.$watch('essay', (val) => {
                 localStorage.setItem(key, val);
                 this.queueDraftSync();
            });

            this.time = (taskType == 2) ? 2400 : 1200; // 40 mins for Task 2, 20 mins for Task 1
            
            this.interval = setInterval(() => { 
                if (this.time > 0) {
                    this.time--; 
                } else {
                    clearInterval(this.interval);
                }
            }, 1000);
            
            // Call the other initialization logic
            this.initProperties();
        },
        
        addParagraph() {
            this.plan.extras.push('');
        },

        removeParagraph(index) {
            this.plan.extras.splice(index, 1);
        },

        refreshEssay() {
            if (confirm('Reset semua teks essay?')) {
                this.essay = '';
                if (window.AutoSave && typeof window.AutoSave.clearSaved === 'function') {
                    try { window.AutoSave.clearSaved(); } catch (e) { console.warn('AutoSave clearSaved failed', e); }
                }
            }
        },

        // Helper to initialize properties
        initProperties() {
            // Load Plan
            const planKey = 'ielts_plan_practice_' + meetingId;
            const savedPlan = localStorage.getItem(planKey);
            let planRestoredLocally = false;
            if (savedPlan) {
                try {
                     const parsed = JSON.parse(savedPlan);
                     this.plan = { ...this.plan, ...parsed };
                     if (!this.plan.extras) this.plan.extras = [];
                     planRestoredLocally = true;
                } catch(e) { console.error('Error loading plan', e); }
            }

            if (!this._essayRestoredLocally || !planRestoredLocally) {
                this.restoreFromServerAnswers(!this._essayRestoredLocally, !planRestoredLocally);
            }

            // Watch Plan
            this.$watch('plan', (val) => {
                localStorage.setItem(planKey, JSON.stringify(val));
                this.queueDraftSync();
            });

            // Initialize External AutoSave
            if (window.AutoSave) {
                window.AutoSave.init(meetingId, '{{ Auth::id() }}');
            }

            setTimeout(() => {
                // Sync Essay
                const textarea = document.querySelector('textarea[name="essay"]');
                if (textarea && textarea.value) {
                    this.essay = sanitizeLatexDegrees(textarea.value);
                }
            }, 500);
            
            this.showEditModal = false; // Ensure modal is closed
            this.editForm.title = {!! json_encode($meeting->title) !!}; 
             // Pre-fill form data but don't show modal
            this.editForm.meeting_number = {{ $meeting->meeting_number }};
            this.editForm.prompt = {!! json_encode($meeting->prompt) !!};
        },

        // Rebuilds essay/plan from the flat "essay"/"plan_body1"/
        // "plan_extra_{index}" shape saveMeetingDraft() stores server-side
        // (see buildDraftPayload() below - the exact inverse of this).
        // Only restores whichever of essay/plan this browser's localStorage
        // didn't already have, so a student switching devices (or clearing
        // storage) doesn't lose an in-progress draft synced from elsewhere.
        restoreFromServerAnswers(restoreEssay, restorePlan) {
            const flat = {{ Js::from($savedAnswers ?? []) }};
            if (!flat || typeof flat !== 'object' || Array.isArray(flat) || Object.keys(flat).length === 0) {
                return;
            }

            if (restoreEssay && flat.essay !== undefined) {
                this.essay = sanitizeLatexDegrees(flat.essay);
            }

            if (restorePlan) {
                if (flat.plan_body1 !== undefined) this.plan.body1 = flat.plan_body1;
                if (flat.plan_body2 !== undefined) this.plan.body2 = flat.plan_body2;

                const extras = Object.keys(flat)
                    .filter((k) => /^plan_extra_\d+$/.test(k))
                    .map((k) => ({ index: parseInt(k.replace('plan_extra_', ''), 10), value: flat[k] }))
                    .sort((a, b) => a.index - b.index)
                    .map((item) => item.value);
                if (extras.length > 0) {
                    this.plan.extras = extras;
                }
            }
        },

        // Inverse of restoreFromServerAnswers() - flattens essay/plan into
        // the same "essay"/"plan_body1"/"plan_extra_{index}" names the
        // fields themselves carry (see their name/:name attributes above),
        // so the admin live-preview's flatten()-and-match-by-name injection
        // works with no server-side reshaping needed.
        buildDraftPayload() {
            const payload = {
                essay: this.essay,
                plan_body1: this.plan.body1,
                plan_body2: this.plan.body2,
            };
            (this.plan.extras || []).forEach((value, index) => {
                payload['plan_extra_' + index] = value;
            });
            return payload;
        },

        queueDraftSync() {
            clearTimeout(this.draftSyncTimer);
            this.draftSyncTimer = setTimeout(() => this.syncDraftToServer(), 800);
        },

        async syncDraftToServer() {
            try {
                await fetch('/assignments/ielts-academic/writing/meeting/{{ $meeting->id }}/draft', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({ userAnswers: this.buildDraftPayload() }),
                    keepalive: true,
                });
            } catch (e) {
                console.error('Failed to sync draft to server:', e);
            }
        },

        // Admin Actions
        openEditModal() {
            this.showEditModal = true;
        },
        
        previewEvaluasi() {
            // Admin preview: run the SAME live AI evaluation pipeline real students use,
            // instead of showing fake canned scores. Uses a sample essay only if the
            // admin hasn't written one.
            if (!this.essay || this.essay.trim().length < 50) {
                this.essay = "The line graph illustrates website traffic over time from 2010 to 2020. Overall, traffic experienced a steady upward trend over the ten-year period, with notable peaks observed in the final quarter. The numbers rose sharply between 2012 and 2015 before stabilizing towards the end of the period.";
            }
            this.submitEssay();
        },

        getBulletPoints(text) {
            if (!text || typeof text !== 'string') return null;
            const parts = text.split(/(?:^|\s)-\s+/).map(p => p.trim()).filter(p => p.length > 0);
            return parts.length > 1 ? parts : null;
        },

        async fetchWithTimeout(url, options = {}, timeoutMs = 70000) {
            const controller = new AbortController();
            const timer = setTimeout(() => controller.abort(), timeoutMs);
            try {
                return await fetch(url, { ...options, signal: controller.signal });
            } catch (e) {
                if (e.name === 'AbortError') {
                    throw new Error('Request timed out. The server took too long to respond.');
                }
                throw e;
            } finally {
                clearTimeout(timer);
            }
        },

        scrollToAnalysis() {
            let attempts = 0;
            const doScroll = () => {
                attempts++;
                const leftPanel = document.getElementById('left-panel');
                const analysisCard = document.getElementById('detailed-text-analysis');
                
                if (!leftPanel || !analysisCard) return;

                const isVisible = analysisCard.offsetHeight > 0 || analysisCard.getClientRects().length > 0;
                if (!isVisible && attempts < 15) {
                    setTimeout(doScroll, 50);
                    return;
                }

                const leftPanelRect = leftPanel.getBoundingClientRect();
                const cardRect = analysisCard.getBoundingClientRect();
                
                let targetScrollTop = 0;
                if (cardRect.top > 0) {
                    targetScrollTop = leftPanel.scrollTop + (cardRect.top - leftPanelRect.top) - 16;
                } else if (analysisCard.offsetTop > 0) {
                    targetScrollTop = analysisCard.offsetTop - 16;
                }

                if (targetScrollTop > 0) {
                    leftPanel.scrollTo({
                        top: targetScrollTop,
                        behavior: 'smooth'
                    });
                }
            };

            this.$nextTick(() => {
                setTimeout(doScroll, 50);
            });
        },

        // Actions
        async submitEssay() {
             if (this.essay.trim().length < 50) {
                 alert('Please write at least 50 characters.');
                 return;
             }
             
             this.loading = true;
             this.error = null;
             this.lastSubmissionId = null;
             this.showResults = true;
             // Keep previous results visible while loading new ones?? No, clear them to show spinners.
             this.result = { scores: {}, feedback: null, correction_html: null, better_version: null, grammar_improvements: [], cohesive_devices_used: [], good_vocabulary_used: [], vocabulary_improvements: [] };

             this.scrollToAnalysis();

             try {
                // 1. Evaluate Scores
                const response = await this.fetchWithTimeout('/assignments/ielts-academic/writing/evaluate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({ essay: this.essay, task_type: '{{ $meeting->task_type }}', meeting_id: '{{ $meeting->id ?? '' }}' })
                });

                if (!response.ok) {
                    let errorMsg = 'Evaluation failed. Server returned ' + response.status;
                    try {
                        const errorData = await response.json();
                        if (errorData.error) errorMsg = errorData.error;
                        // The essay is saved server-side regardless of AI success/failure -
                        // this id lets the student (or an admin/teacher later) retry grading
                        // without needing to resubmit the essay text.
                        if (errorData.submission_id) this.lastSubmissionId = errorData.submission_id;
                    } catch (e) {
                         console.warn('Could not parse error JSON', e);
                    }
                    throw new Error(errorMsg);
                }
                const data = await response.json();
                if (data.submission_id) this.lastSubmissionId = data.submission_id;

                if (data.redirect_url) {
                    if (data.message) alert(data.message);
                    window.location.href = data.redirect_url;
                    return;
                }

                this.result.scores = data.scores || {};

                // 2. Parallel Fetch for Feedback & Correction & Improvement
                await Promise.all([
                    this.getFeedback(),
                    this.getCorrection(),
                    this.improveEssay()
                ]);

                if (this.lastSubmissionId) {
                    this.persistFullFeedback();
                }

             } catch (e) {
                 console.error(e);
                 this.error = e.message;
                 this.loading = false;
             }
        },

        async persistFullFeedback() {
            if (!this.lastSubmissionId) return;
            try {
                await fetch(`/assignments/ielts-academic/writing/submission/${this.lastSubmissionId}/save-feedback`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({
                        scores: this.result.scores,
                        feedback: this.result.feedback,
                        correction_html: this.result.correction_html,
                        better_version: this.result.better_version
                    })
                });
            } catch (e) {
                console.warn('Persist feedback error:', e);
            }
        },

        // Retries AI scoring for an essay that already failed and was saved server-side
        // (see lastSubmissionId above) - reusable by Student (own submission), Admin, or
        // Teacher via the same backend endpoint/authorization check.
        async retrySubmission() {
             if (!this.lastSubmissionId) return;

             this.loading = true;
             this.error = null;

             try {
                const response = await this.fetchWithTimeout(`/assignments/ielts-academic/writing/submission/${this.lastSubmissionId}/retry`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    }
                });

                if (!response.ok) {
                    let errorMsg = 'Gagal mengirim ulang. Server returned ' + response.status;
                    try {
                        const errorData = await response.json();
                        if (errorData.error) errorMsg = errorData.error;
                        if (errorData.submission_id) this.lastSubmissionId = errorData.submission_id;
                    } catch (e) {
                        console.warn('Could not parse error JSON', e);
                    }
                    throw new Error(errorMsg);
                }

                const data = await response.json();
                this.result.scores = data.scores || {};

                this.getFeedback();
                this.getCorrection();
                this.improveEssay();
             } catch (e) {
                 console.error(e);
                 this.error = e.message;
                 this.loading = false;
             }
        },

        async getFeedback() {
             try {
                const response = await this.fetchWithTimeout('/assignments/ielts-academic/writing/feedback', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                    body: JSON.stringify({ essay: this.essay, task_type: '{{ $meeting->task_type }}', meeting_id: '{{ $meeting->id ?? '' }}' })
                });
                const data = await response.json();
                if (data.feedback) {
                    this.result.feedback = data.feedback;
                    if (data.feedback.grammar_improvements) {
                        this.result.grammar_improvements = data.feedback.grammar_improvements;
                    }
                    if (data.feedback.cohesive_devices_used) {
                        this.result.cohesive_devices_used = data.feedback.cohesive_devices_used;
                    }
                    if (data.feedback.good_vocabulary_used) {
                        this.result.good_vocabulary_used = data.feedback.good_vocabulary_used;
                    }
                    if (data.feedback.vocabulary_improvements) {
                        this.result.vocabulary_improvements = data.feedback.vocabulary_improvements;
                    }
                    this.feedbackFailed = false;
                } else {
                    this.feedbackFailed = true;
                }
             } catch (e) {
                console.error(e);
                this.feedbackFailed = true;
             } finally {
                this.loading = false; // Stop loading spinner on submit button once feedback settles
             }
        },

        async getCorrection() {
             try {
                const response = await this.fetchWithTimeout('/assignments/ielts-academic/writing/correct', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                    body: JSON.stringify({ essay: this.essay, task_type: '{{ $meeting->task_type }}', meeting_id: '{{ $meeting->id ?? '' }}' })
                });
                const data = await response.json();
                if (data.correction_html) {
                    this.result.correction_html = data.correction_html;
                    this.correctionFailed = false;
                    this.scrollToAnalysis();
                } else {
                    this.correctionFailed = true;
                }
             } catch (e) {
                console.error(e);
                this.correctionFailed = true;
             }
        },

        async improveEssay() {
             this.improving = true;
             try {
                const response = await this.fetchWithTimeout('/assignments/ielts-academic/writing/improve', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                    body: JSON.stringify({ essay: this.essay, task_type: '{{ $meeting->task_type }}', meeting_id: '{{ $meeting->id ?? '' }}' })
                });
                const data = await response.json();
                if (data.better_version) {
                    this.result.better_version = data.better_version;
                    this.improveFailed = false;
                } else {
                    this.improveFailed = true;
                }
             } catch (e) {
                console.error(e);
                this.improveFailed = true;
             }
             finally { this.improving = false; }
        },

        // --- UPGRADE METHODS ---
        async upgradeTaskResponse() {
            this.taskResponseUpgrading = true;
            try {
                const response = await this.fetchWithTimeout('/assignments/ielts-academic/writing/task-response', {
                    method: 'POST', body: JSON.stringify({ essay: this.essay, task_type: '{{ $meeting->task_type }}', meeting_id: '{{ $meeting->id ?? '' }}' }),
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
                });
                const data = await response.json();
                if (data.task_response_improvements) this.result.task_response_improvements = data.task_response_improvements;
            } catch (e) { console.error(e); } finally { this.taskResponseUpgrading = false; }
        },
        async upgradeCoherence() {
            this.coherenceUpgrading = true;
            try {
                const response = await this.fetchWithTimeout('/assignments/ielts-academic/writing/coherence', {
                    method: 'POST', body: JSON.stringify({ essay: this.essay, task_type: '{{ $meeting->task_type }}', meeting_id: '{{ $meeting->id ?? '' }}' }),
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
                });
                const data = await response.json();
                if (data.coherence_improvements) this.result.feedback.coherence_improvements = data.coherence_improvements;
            } catch (e) { console.error(e); } finally { this.coherenceUpgrading = false; }
        },
        async upgradeLexical() {
            this.lexicalUpgrading = true;
            try {
                const response = await this.fetchWithTimeout('/assignments/ielts-academic/writing/vocabulary', {
                    method: 'POST', body: JSON.stringify({ essay: this.essay, task_type: '{{ $meeting->task_type }}', meeting_id: '{{ $meeting->id ?? '' }}' }),
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
                });
                const data = await response.json();
                if (data.lexical_improvements) this.result.vocabulary_improvements = data.lexical_improvements;
                if (data.topic_vocabularies) this.result.collocations = data.topic_vocabularies;
            } catch (e) { console.error(e); } finally { this.lexicalUpgrading = false; }
        },
        async upgradeGrammar() {
            this.grammarUpgrading = true;
            try {
                const response = await this.fetchWithTimeout('/assignments/ielts-academic/writing/grammar', {
                    method: 'POST', body: JSON.stringify({ essay: this.essay, task_type: '{{ $meeting->task_type }}', meeting_id: '{{ $meeting->id ?? '' }}' }),
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
                });
                const data = await response.json();
                if (data.grammar_improvements) this.result.grammar_improvements = data.grammar_improvements;
            } catch (e) { console.error(e); } finally { this.grammarUpgrading = false; }
        }
    }));
});
</script>
@endpush
@endsection
