@extends('layouts.admin')

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
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 h-full">
            <!-- Left Column: The Chart / Task Info -->
            <div class="min-w-0 h-full overflow-y-auto pr-2 pb-32 custom-scrollbar flex flex-col">
                <!-- Header Removed as requested, spacer invalid -->
            
            <div id="questionInstructionBox" class="bg-white border border-gray-300 p-4 rounded-lg shadow-sm mb-6 hidden">
                <!-- Content injected by JS -->
            </div>

            <div class="overflow-x-auto">
                @if($meeting->meeting_number == 111 || ($meeting->meeting_number >= 1010 && $meeting->meeting_number <= 1029))
                    <!-- Line Chart -->
                    <div class="relative h-[580px] w-full min-w-[300px]" style="height: 580px;">
                        <canvas id="practiceLineChart"></canvas>
                    </div>
                @elseif(($meeting->meeting_number >= 1030 && $meeting->meeting_number <= 1049) || $meeting->id == 67)
                    <!-- Bar Chart -->
                    <div class="relative h-[580px] w-full min-w-[300px]" style="height: 580px;">
                        <canvas id="practiceBarChart"></canvas>
                    </div>
                @elseif($meeting->meeting_number >= 1050 && $meeting->meeting_number <= 1069)
                    <!-- Pie Chart -->
                    @php
                        $doublePieIds = range(1054, 1069); // 5th-20th pie items (based on sequential meeting numbers)
                    @endphp
                    @if(in_array($meeting->meeting_number, $doublePieIds))
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="relative h-[520px] w-full min-w-[300px]" style="height: 520px;">
                                <canvas id="practicePieChart1"></canvas>
                            </div>
                            <div class="relative h-[520px] w-full min-w-[300px]" style="height: 520px;">
                                <canvas id="practicePieChart2"></canvas>
                            </div>
                        </div>
                    @else
                        <div class="relative h-[580px] w-full flex justify-center min-w-[300px]" style="height: 580px;">
                            <canvas id="practicePieChart"></canvas>
                        </div>
                    @endif
                @elseif($meeting->meeting_number >= 1070 && $meeting->meeting_number <= 1089)
                    <!-- Table -->
                    <div id="practiceTableContainer" class="overflow-x-auto rounded-xl shadow-lg border border-gray-100 hidden">
                        <!-- Table will be injected here by JS -->
                    </div>
                @elseif($meeting->meeting_number >= 1090 && $meeting->meeting_number <= 1109)
                    <!-- Mixed -->
                    <div id="practiceMixedContainer" class="w-full flex flex-col gap-8 justify-center items-center h-auto min-h-[600px] p-4">
                        <!-- Canvases injected by JS -->
                    </div>
                @elseif($meeting->meeting_number >= 1110 && $meeting->meeting_number <= 1129)
                    <!-- Flow Chart -->
                    <!-- Flow Chart -->
                    <div class="flex justify-center items-center py-4">
                        @if($meeting->meeting_number == 1110)
                             <img src="{{ asset('images/practice/cement_production.png') }}" alt="Cement and Concrete Production Process" class="max-w-full h-auto rounded-lg shadow-sm border border-gray-200">
                        @elseif($meeting->meeting_number == 1111)
                             <img src="{{ asset('images/practice/coconut_oil_production.png') }}" alt="Coconut Oil Manufacturing Process" class="max-w-full h-auto rounded-lg shadow-sm border border-gray-200">
                        @elseif($meeting->meeting_number == 1112)
                             <img src="{{ asset('images/practice/glass_container_production.png') }}" alt="Glass Container Production Process" class="max-w-full h-auto rounded-lg shadow-sm border border-gray-200">
                        @elseif($meeting->meeting_number == 1113)
                             <img src="{{ asset('images/practice/sheep_cloning_process.png') }}" alt="Sheep Embryo Cloning Process" class="max-w-full h-auto rounded-lg shadow-sm border border-gray-200">
                        @elseif($meeting->meeting_number == 1114)
                             <img src="{{ asset('images/practice/water_treatment_process.jpg') }}" alt="Water Treatment Process" class="max-w-full h-auto rounded-lg shadow-sm border border-gray-200">
                        @elseif($meeting->meeting_number == 1115)
                             <img src="{{ asset('images/practice/hydroelectric_power_process.png') }}" alt="Hydroelectric Power Generation Process" class="max-w-full h-auto rounded-lg shadow-sm border border-gray-200">
                        @elseif($meeting->meeting_number == 1116)
                             <img src="{{ asset('images/practice/frog_life_cycle.png') }}" alt="Life Cycle of a Frog" class="max-w-full h-auto rounded-lg shadow-sm border border-gray-200">
                        @elseif($meeting->meeting_number == 1117)
                             <img src="{{ asset('images/practice/silkworm_life_cycle.png') }}" alt="Life Cycle of the Silkworm" class="max-w-full h-auto rounded-lg shadow-sm border border-gray-200">
                        @elseif($meeting->meeting_number == 1118)
                             <img src="{{ asset('images/practice/water_cycle.png') }}" alt="Water Cycle" class="max-w-full h-auto rounded-lg shadow-sm border border-gray-200">
                            @elseif($meeting->meeting_number == 1119)
                             <img src="{{ asset('images/practice/milk_production.png') }}" alt="Milk Production Process" class="max-w-full h-auto rounded-lg shadow-sm border border-gray-200">
                            @elseif($meeting->meeting_number == 1125)
                                @php
                                    $seaTurtlePngPath = public_path('images/practice/sea_turtle_life_cycle.png');
                                    $seaTurtlePngVersion = file_exists($seaTurtlePngPath) ? filemtime($seaTurtlePngPath) : time();
                                @endphp
                                <img src="{{ asset('images/practice/sea_turtle_life_cycle.png') }}?v={{ $seaTurtlePngVersion }}" alt="Life Cycle of Sea Turtles" class="max-w-full h-auto rounded-lg shadow-sm border border-gray-200">
                        @else 
                             <!-- Fallback/Placeholder -->
                            <div class="text-center p-8 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                <p class="text-gray-500">Flow Chart Diagram not available for this meeting.</p>
                            </div>
                        @endif
                    </div>
                @elseif($meeting->meeting_number >= 1130 && $meeting->meeting_number <= 1149)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                        @php
                            $imageUrl = null;
                            if($meeting->image) {
                                $imageUrl = asset($meeting->image);
                            } else {
                                // Fallback to hardcoded paths
                                $mapImages = [
                                    1130 => 'images/practice/paradise_island.png',
                                    1131 => 'images/practice/happy_valley_shopping_center.png',
                                    1132 => 'images/practice/felixstone.png',
                                    1133 => 'images/practice/seaville.png',
                                    1134 => 'images/practice/islip_town_centre.png',
                                    1135 => 'images/practice/ryemouth_village.png',
                                    1136 => 'images/practice/science_park.png',
                                    1137 => 'images/practice/meadowside_fonton.png',
                                    1138 => 'images/practice/university_sports_centre.png',
                                    1139 => 'images/practice/beachfront_area.png',
                                ];
                                if(isset($mapImages[$meeting->meeting_number])) {
                                    $imageUrl = asset($mapImages[$meeting->meeting_number]);
                                }
                            }
                        @endphp

                        @if($imageUrl)
                            <div class="flex justify-center">
                                <img src="{{ $imageUrl }}" alt="{{ $meeting->title }} Map" class="w-4/5 max-h-[600px] object-contain rounded-lg shadow-sm border border-gray-200">
                            </div>
                        @else
                            <div class="text-center p-8 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                <p class="text-gray-500">Map Diagram not available for this meeting.</p>
                            </div>
                        @endif


                    </div>
                @endif
                    </div>


            @if(isset($meeting) && $meeting->task_type == 2)
            <!-- Task 2 Layout Plan -->
            <div class="mt-6 space-y-4">
                <div class="p-3 bg-orange-50 border border-orange-100 rounded-xl">
                    <h4 class="font-bold text-orange-800 mb-2">Body Paragraph 1</h4>
                        <textarea x-model="plan.body1" 
                                x-init="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                                @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'"
                                class="w-full bg-white/50 border-orange-200 rounded-lg text-sm text-orange-900 placeholder-orange-300 focus:ring-orange-500 focus:border-orange-500 p-2 min-h-[80px] overflow-hidden resize-none" 
                                placeholder="• Topic Sentence (Main Idea 1)&#10;• Explain/Expand&#10;• Example"></textarea>
                </div>

                <div class="p-3 bg-orange-50 border border-orange-100 rounded-xl">
                    <h4 class="font-bold text-orange-800 mb-2">Body Paragraph 2</h4>
                        <textarea x-model="plan.body2" 
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
                            <textarea x-model="plan.extras[index]" 
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

            <!-- Detailed Text Analysis (Visible ONLY in Results Mode) -->
            <div x-show="showResults" class="mt-8 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" style="display: none;">
                <div class="p-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                    <h3 class="font-bold text-gray-700 flex items-center gap-2">
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
                         <!-- Fallback to plain essay if analyzing -->
                         <div class="text-left opacity-50" x-html="essay.replace(/\n/g, '<br>')"></div>
                    </div>
                    <div x-html="safeHtml"></div>
                </div>
            </div>
        </div>

        <!-- Right Column: Writing Area & Results -->
        <div id="writing-panel" class="min-w-0 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden h-full flex flex-col">
            
            <!-- WRITING MODE HEADER -->
            <div x-show="!showResults" class="bg-indigo-50 px-6 py-4 border-b border-indigo-100 flex-none flex justify-between items-center">
                <div>
                     <h3 class="text-lg font-bold text-indigo-800">Your Response</h3>
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
                 <button @click="showResults = false" class="text-sm text-indigo-600 hover:text-indigo-800 underline">Back to Edit</button>
            </div>

            <!-- WRITING MODE CONTENT -->
            <div x-show="!showResults" class="p-6 flex-1 overflow-y-auto custom-scrollbar pb-32">
                <!-- Error Alert -->
                <div x-show="error" class="mb-4 p-3 bg-red-50 text-red-700 rounded text-sm" x-text="error" style="display: none;"></div>

                <textarea name="essay" x-model="essay" rows="25" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-indigo-500 transition-all text-base placeholder-gray-400 font-mono leading-relaxed resize-y" placeholder="The chart illustrates..."></textarea>
                
                <div class="mt-4 flex flex-wrap justify-between items-center gap-4 text-sm text-gray-500">
                     <span class="flex items-center gap-4">
                        <span>Count: <span x-text="wordCount" class="font-bold text-gray-800"></span> words</span>
                        <button @click="refreshEssay()" class="text-gray-400 hover:text-red-500 text-xs flex items-center gap-1 transition-colors">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            Reset Essay
                        </button>
                     </span>
                     <span class="text-xs text-indigo-500 font-medium">Write at least {{ $task == 2 ? '250' : '150' }} words.</span>
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
                        <button @click="activeTab = 'analysis'" :class="{ 'border-indigo-500 text-indigo-600': activeTab === 'analysis', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': activeTab !== 'analysis' }" class="whitespace-nowrap py-4 px-6 border-b-2 font-bold text-sm transition-colors uppercase tracking-wide">Text Analysis</button>
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
                            <p x-show="!result?.feedback" class="text-gray-400 italic animate-pulse py-4">Generating detailed feedback...</p>
                            <p x-text="result?.feedback?.overall_comment" class="text-gray-600 leading-relaxed"></p>
                        </div>
                    </div>

                    <!-- TASK ACHIEVEMENT TAB -->
                    <div x-show="activeTab === 'task_response'" class="max-w-3xl mx-auto space-y-6">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <strong class="block text-xs uppercase text-indigo-500 font-bold mb-3 tracking-wider">Task Achievement Detailed Feedback</strong>
                            <p x-show="!result?.feedback" class="text-gray-400 italic animate-pulse">Generating...</p>
                            <p x-text="result?.feedback?.task_achievement" class="text-gray-700 leading-relaxed"></p>
                        </div>

                         <!-- Upgrade Action -->
                        <div class="bg-green-50 p-6 rounded-xl border border-green-100 flex flex-col items-center justify-center text-center gap-4">
                            <h4 class="font-bold text-green-800">Want to boost your Task Achievement score?</h4>
                            <p class="text-sm text-green-700 max-w-md">Get specific advice on which content is missing or underdeveloped.</p>
                            <button @click="upgradeTaskResponse()" :disabled="loading" class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-sm transition-all transform hover:scale-105 flex items-center gap-2">
                                <svg x-show="!loading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                <span x-show="loading" class="animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full"></span>
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
                            <p x-show="!result?.feedback" class="text-gray-400 italic animate-pulse">Generating...</p>
                            <p x-text="result?.feedback?.coherence_cohesion" class="text-gray-700 leading-relaxed"></p>
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
                            <button @click="upgradeCoherence()" :disabled="loading" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-sm transition-all transform hover:scale-105 flex items-center gap-2">
                                <svg x-show="!loading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                <span x-show="loading" class="animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full"></span>
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
                            <p x-show="!result?.feedback" class="text-gray-400 italic animate-pulse">Generating...</p>
                            <p x-text="result?.feedback?.lexical_resource" class="text-gray-700 leading-relaxed"></p>
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
                        
                        <!-- Upgrade Action -->
                        <div x-show="!result?.vocabulary_improvements?.length" class="bg-indigo-50 p-6 rounded-xl border border-indigo-100 flex flex-col items-center justify-center text-center gap-4">
                            <h4 class="font-bold text-indigo-800">Learn Band 9 Vocabulary?</h4>
                             <button @click="upgradeLexical()" :disabled="loading" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-sm transition-all transform hover:scale-105 flex items-center gap-2">
                                <svg x-show="!loading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                <span x-show="loading" class="animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full"></span>
                                <span>Analyze & Upgrade Vocabulary (Band 7-9)</span>
                            </button>
                        </div>

                         <!-- Upgrade Results -->
                         <div x-show="result?.vocabulary_improvements?.length > 0" class="mt-4 border border-gray-200 rounded-xl overflow-hidden shadow-sm">
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
                    </div>

                    <!-- GRAMMAR TAB -->
                    <div x-show="activeTab === 'grammar'" class="max-w-3xl mx-auto space-y-6">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <strong class="block text-xs uppercase text-indigo-500 font-bold mb-3 tracking-wider">Grammatical Range Detailed Feedback</strong>
                            <p x-show="!result?.feedback" class="text-gray-400 italic animate-pulse">Generating...</p>
                            <p x-text="result?.feedback?.grammatical_range" class="text-gray-700 leading-relaxed"></p>
                        </div>

                         <!-- Upgrade Action -->
                        <div x-show="!result?.grammar_improvements?.length" class="bg-purple-50 p-6 rounded-xl border border-purple-100 flex flex-col items-center justify-center text-center gap-4">
                            <h4 class="font-bold text-purple-800">Master Complex Structures?</h4>
                             <button @click="upgradeGrammar()" :disabled="loading" class="px-6 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-lg shadow-sm transition-all transform hover:scale-105 flex items-center gap-2">
                                <svg x-show="!loading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                <span x-show="loading" class="animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full"></span>
                                <span>Analyze & Upgrade Grammar (Band 7-9)</span>
                            </button>
                        </div>

                        <!-- Upgrade Results -->
                         <div x-show="result?.grammar_improvements?.length > 0" class="mt-4 border border-gray-200 rounded-xl overflow-hidden shadow-sm">
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
                    </div>

                    <!-- ANALYSIS TAB -->
                    <div x-show="activeTab === 'analysis'" class="max-w-3xl mx-auto">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                             <div class="p-4 border-b border-gray-100 bg-indigo-50/50 flex justify-between items-center">
                                <h3 class="font-bold text-indigo-800">Detailed Text Analysis</h3>
                                <div class="flex items-center gap-3 text-xs font-medium">
                                    <span class="bg-red-100 text-red-600 px-2 py-1 rounded">Error</span>
                                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded">Improvement</span>
                                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded">Suggestion</span>
                                </div>
                            </div>
                            <div class="p-6 prose prose-indigo max-w-none leading-loose text-lg text-gray-800">
                                <div x-show="!result?.correction_html" class="text-gray-400 italic animate-pulse py-8 text-center">Analyzing text structure and grammar...</div>
                                <div x-html="safeHtml"></div>
                            </div>
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
    const meetingId = {{ $meeting->meeting_number }};

    // Helper to Set Instruction
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

    // --- Mixed Chart Data Configs (Array supports multiple charts) ---
    const mixedConfigs = {
        1050: [{ // Visitors & Spend (Combo)
            type: 'bar',
            title: 'Weekly Visitors & Spending',
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [
                { type: 'bar', label: 'Visitors', data: [120, 150, 180, 200, 250, 500, 450], backgroundColor: ['#a78bfa', '#8b5cf6', '#7c3aed', '#6d28d9', '#5b21b6', '#4c1d95', '#2e1065'], borderColor: '#7c3aed', borderWidth: 2, yAxisID: 'y' },
                { type: 'line', label: 'Avg Spend ($)', data: [20, 22, 25, 25, 30, 45, 50], borderColor: '#10b981', backgroundColor: 'rgba(16, 185, 129, 0.1)', borderWidth: 4, pointBackgroundColor: '#10b981', pointRadius: 5, tension: 0.4, fill: true, yAxisID: 'y1' }
            ],
            scales: { y: { text: 'Number of Visitors' }, y1: { text: 'Spend ($)' } }
        }],
        1051: [ // Sales vs Profit (Two Side-by-Side Lines)
            {
                type: 'line',
                title: 'Annual Sales ($M)',
                labels: ['2018', '2019', '2020', '2021', '2022'],
                datasets: [{ label: 'Sales', data: [10, 12, 15, 14, 18], borderColor: '#2563eb', borderWidth: 4, tension: 0.4, fill: true, backgroundColor: 'rgba(37, 99, 235, 0.1)' }],
                scales: { y: { text: 'Amount ($M)' } }
            },
            {
                type: 'line',
                title: 'Annual Profit ($M)',
                labels: ['2018', '2019', '2020', '2021', '2022'],
                datasets: [{ label: 'Profit', data: [2, 3, 4, 3.5, 5], borderColor: '#16a34a', borderWidth: 4, tension: 0.4, fill: true, backgroundColor: 'rgba(22, 163, 74, 0.1)' }],
                scales: { y: { text: 'Amount ($M)' } }
            }
        ],
        1052: [ // Hospital Complementary Medicine (User Example 2)
            {
                type: 'line',
                title: '% of US Hospitals using Comp. Medicine',
                labels: ['1985', '1990', '1995', '2000', '2005', '2010'],
                datasets: [{ label: '% of Hospitals', data: [2, 4, 7, 12, 30, 40], borderColor: '#dc2626', borderWidth: 4, pointRadius: 4, tension: 0.2, fill: false }],
                scales: { y: { text: '% of Hospitals', min: 0, max: 45 } }
            },
            {
                type: 'bar',
                title: 'Most Common Approaches (2012)',
                labels: ['Natural Products', 'Deep Breathing', 'Yoga', 'Chiropractic', 'Meditation', 'Massage', 'Diet', 'Homeopathy'],
                datasets: [{ label: 'Percentage', data: [17.7, 10.9, 10.1, 8.4, 8.0, 6.9, 3.0, 2.2], backgroundColor: ['#3b82f6', '#0ea5e9', '#06b6d4', '#14b8a6', '#10b981', '#84cc16', '#eab308', '#f59e0b'] }],
                scales: { y: { text: 'Percentage (%)' } }
            }
        ],
        1053: [ // Population (Bar) & Growth (Line) Side-by-Side
            {
                type: 'bar',
                title: 'Population (Millions)',
                labels: ['2000', '2005', '2010', '2015', '2020'],
                datasets: [{ label: 'Population', data: [50, 52, 55, 58, 60], backgroundColor: ['#86efac', '#4ade80', '#22c55e', '#16a34a', '#15803d'] }],
                scales: { y: { text: 'Millions' } }
            },
            {
                type: 'line',
                title: 'Growth Rate (%)',
                labels: ['2000', '2005', '2010', '2015', '2020'],
                datasets: [{ label: 'Rate', data: [1.5, 1.4, 1.2, 1.0, 0.8], borderColor: '#ea580c', borderWidth: 4, pointRadius: 5 }],
                scales: { y: { text: 'Percentage' } }
            }
        ],
        1054: [ // Exports (Pie) & Imports (Pie)
            {
                type: 'pie',
                title: 'Exports Share',
                labels: ['Electronics', 'Textiles', 'Agri', 'Services'],
                datasets: [{ data: [40, 20, 15, 25], backgroundColor: ['#3b82f6', '#ef4444', '#10b981', '#f59e0b'] }],
                scales: {} 
            },
            {
                type: 'pie',
                title: 'Imports Share',
                labels: ['Electronics', 'Textiles', 'Agri', 'Services'],
                datasets: [{ data: [35, 25, 20, 20], backgroundColor: ['#6366f1', '#ec4899', '#14b8a6', '#facc15'] }],
                scales: {}
            }
        ],
        1055: [ // Online Shopping (User Example 1)
            {
                type: 'pie',
                title: 'Frequency of Online Shopping (2015)',
                labels: ['Weekly', 'Few times/month', 'Less Often', 'Never'],
                datasets: [{ data: [37, 28, 20, 15], backgroundColor: ['#84cc16', '#dc2626', '#8b5cf6', '#3b82f6'] }],
                scales: {}
            },
            {
                type: 'bar',
                title: 'Shopping Preferences (Online vs Store)',
                labels: ['All', 'Weekly', 'Monthly', 'Less Freq'],
                datasets: [
                    { label: 'Buy Online', data: [34, 62, 42, 18], backgroundColor: '#3b82f6' },
                    { label: 'Buy In Store', data: [65, 37, 58, 82], backgroundColor: '#dc2626' }
                ],
                scales: { y: { text: 'Percentage' } }
            }
        ],
        1056: [ // Housing Sales (Bar) & Type Dist (Pie) - Was Gray
            {
                type: 'bar',
                title: 'Annual Sales Volume',
                labels: ['2019', '2020', '2021', '2022'],
                datasets: [{ label: 'Units Sold', data: [500, 450, 600, 550], backgroundColor: ['#cbd5e1', '#94a3b8', '#64748b', '#475569'] }], // Shades of slate, distinct
                scales: { y: { text: 'Units' } }
            },
            {
                type: 'pie',
                title: 'Property Types',
                labels: ['Detached', 'Semi', 'Apartment'],
                datasets: [{ data: [40, 35, 25], backgroundColor: ['#2dd4bf', '#a855f7', '#fb923c'] }],
                scales: {}
            }
        ],
        1057: [ // Energy Production (Pie) & Consumption (Line)
            {
                type: 'pie',
                title: 'Energy Sources',
                labels: ['Coal', 'Gas', 'Renewable', 'Nuclear'],
                datasets: [{ data: [30, 25, 35, 10], backgroundColor: ['#ef4444', '#f59e0b', '#22c55e', '#3b82f6'] }],
                scales: {}
            },
            {
                type: 'line',
                title: 'Consumption Trend (TWh)',
                labels: ['2015', '2016', '2017', '2018', '2019'],
                datasets: [{ label: 'Usage', data: [95, 105, 112, 118, 125], borderColor: '#0ea5e9', borderWidth: 4, fill: true, backgroundColor: 'rgba(14, 165, 233, 0.1)' }],
                scales: { y: { text: 'TWh' } }
            }
        ],
        1058: [ // Financial: Revenue, Cost, Profit (3 Bar Charts)
            {
                type: 'bar',
                title: 'Revenue ($k)',
                labels: ['Q1', 'Q2', 'Q3', 'Q4'],
                datasets: [{ label: 'Revenue', data: [50, 60, 55, 70], backgroundColor: '#10b981' }],
                scales: { y: { text: '$k' } }
            },
            {
                type: 'bar',
                title: 'Cost ($k)',
                labels: ['Q1', 'Q2', 'Q3', 'Q4'],
                datasets: [{ label: 'Cost', data: [30, 35, 32, 40], backgroundColor: '#ef4444' }],
                scales: { y: { text: '$k' } }
            },
            {
                type: 'bar',
                title: 'Profit ($k)',
                labels: ['Q1', 'Q2', 'Q3', 'Q4'],
                datasets: [{ label: 'Profit', data: [20, 25, 23, 30], backgroundColor: '#3b82f6' }],
                scales: { y: { text: '$k' } }
            }
        ],
        1059: [ // Anthropology Graduates (User Example 3: Pie + Table)
            {
                type: 'pie',
                title: 'Destination of Graduates',
                labels: ['Full-time work', 'Part-time work', 'Unemployed', 'FT Postgrad', 'PT Work+Study', 'Unknown'],
                datasets: [{ data: [52, 15, 12, 8, 5, 8], backgroundColor: ['#3b82f6', '#10b981', '#ef4444', '#f59e0b', '#8b5cf6', '#64748b'] }],
                scales: {}
            },
            {
                type: 'table',
                title: 'Salaries after 5 years',
                headers: ['Type of employment', '$25k-49k', '$50k-74k', '$75k-99k', '$100k+'],
                rows: [
                    ['Freelance consultants', '5%', '15%', '40%', '40%'],
                    ['Government sector', '5%', '15%', '30%', '50%'],
                    ['Private companies', '10%', '35%', '25%', '30%']
                ]
            }
        ],
        1090: [ // Reference-based: Online shopping (Pie + Bar)
            {
                type: 'pie',
                title: '% of U.S. Adults who shop Online (2015)',
                labels: ['Weekly', 'A few times a month', 'Less Often', 'Never'],
                datasets: [{
                    data: [15, 28, 37, 20],
                    backgroundColor: ['#4f81bd', '#c0504d', '#9bbb59', '#8064a2']
                }],
                scales: {}
            },
            {
                type: 'bar',
                title: 'Shopping preferences of US Adults who Purchase Online',
                labels: ['All Online Shoppers', 'Weekly online shoppers', 'Monthly online shoppers', 'Less frequent online shoppers'],
                datasets: [
                    { label: 'Buy online', data: [34, 62, 42, 18], backgroundColor: '#4f81bd' },
                    { label: 'Buy in physical store', data: [65, 37, 58, 82], backgroundColor: '#c0504d' }
                ],
                scales: { y: { text: 'Percentage (%)', min: 0, max: 90 } }
            }
        ],
        1091: [ // Reference-based: History graduates (Pie + Table)
            {
                type: 'pie',
                title: 'Destination of History Graduates after Undergraduate Degree',
                labels: ['Full-time work', 'Part-time work', 'Full-time postgrad study', 'Part-time postgrad study', 'Unemployed', 'Unknown'],
                datasets: [{
                    data: [56, 15, 7, 4, 12, 6],
                    backgroundColor: ['#5a5a5a', '#b3b3b3', '#8f8f8f', '#1f1f1f', '#d0d0d0', '#a0a0a0']
                }],
                scales: {}
            },
            {
                type: 'table',
                title: 'Employment Sectors of History Graduates',
                headers: ['Employment Sectors', 'Percentage', 'Average Income in Pounds Sterling'],
                rows: [
                    ['Solicitor', '18%', '57,000'],
                    ['History Teacher', '30%', '32,000'],
                    ['Archaeologist', '6%', '29,000'],
                    ['Historian', '9%', '49,000'],
                    ['Other', '37%', '30,000']
                ]
            }
        ],
        1092: [
            {
                type: 'pie',
                title: 'Primary Transport Mode of City Commuters',
                labels: ['Car', 'Bus', 'Train', 'Bike/Walk'],
                datasets: [{ data: [46, 24, 18, 12], backgroundColor: ['#4f81bd', '#c0504d', '#9bbb59', '#8064a2'] }],
                scales: {}
            },
            {
                type: 'bar',
                title: 'Commuter Preference by Frequency Group',
                labels: ['All commuters', 'Daily commuters', 'Weekly commuters', 'Occasional commuters'],
                datasets: [
                    { label: 'Use public transport', data: [44, 58, 47, 29], backgroundColor: '#4f81bd' },
                    { label: 'Use private vehicle', data: [56, 42, 53, 71], backgroundColor: '#c0504d' }
                ],
                scales: { y: { text: 'Percentage (%)', min: 0, max: 90 } }
            }
        ],
        1093: [
            {
                type: 'pie',
                title: 'Postgraduate Destination of Science Graduates',
                labels: ['Full-time work', 'Part-time work', 'Further study', 'Unemployed', 'Unknown'],
                datasets: [{ data: [52, 18, 16, 9, 5], backgroundColor: ['#5a5a5a', '#b3b3b3', '#8f8f8f', '#1f1f1f', '#d0d0d0'] }],
                scales: {}
            },
            {
                type: 'table',
                title: 'Employment Sectors of Science Graduates',
                headers: ['Employment Sectors', 'Percentage', 'Average Income in Pounds Sterling'],
                rows: [
                    ['Engineering', '26%', '54,000'],
                    ['Teaching', '22%', '35,000'],
                    ['Laboratory', '14%', '38,000'],
                    ['Research', '11%', '47,000'],
                    ['Other', '27%', '33,000']
                ]
            }
        ],
        1094: [
            {
                type: 'bar',
                title: 'Average Monthly Household Utility Spending',
                labels: ['Electricity', 'Water', 'Internet', 'Gas'],
                datasets: [
                    { label: '2018', data: [78, 31, 44, 52], backgroundColor: '#4f81bd' },
                    { label: '2025', data: [92, 36, 58, 49], backgroundColor: '#c0504d' }
                ],
                scales: { y: { text: 'USD' } }
            },
            {
                type: 'table',
                title: 'Utility Tariff Structure (2025)',
                headers: ['Utility', 'Base Tariff', 'Peak Tariff', 'Average Bill'],
                rows: [
                    ['Electricity', '$0.14/kWh', '$0.22/kWh', '$92'],
                    ['Water', '$1.9/m3', '$2.4/m3', '$36'],
                    ['Internet', '$42/month', '$58/month', '$58'],
                    ['Gas', '$0.10/kWh', '$0.16/kWh', '$49']
                ]
            }
        ],
        1095: [
            {
                type: 'pie',
                title: 'Preferred Grocery Purchase Channel',
                labels: ['In-store only', 'Mostly in-store', 'Mostly online', 'Online only'],
                datasets: [{ data: [33, 29, 24, 14], backgroundColor: ['#4f81bd', '#c0504d', '#9bbb59', '#8064a2'] }],
                scales: {}
            },
            {
                type: 'bar',
                title: 'Grocery Buying Preference by Age Group',
                labels: ['18-29', '30-44', '45-60', '60+'],
                datasets: [
                    { label: 'Prefer online', data: [61, 49, 31, 18], backgroundColor: '#4f81bd' },
                    { label: 'Prefer physical store', data: [39, 51, 69, 82], backgroundColor: '#c0504d' }
                ],
                scales: { y: { text: 'Percentage (%)', min: 0, max: 90 } }
            }
        ],
        1096: [
            {
                type: 'pie',
                title: 'Destination of IT Graduates',
                labels: ['Full-time work', 'Contract work', 'Postgraduate study', 'Unemployed', 'Unknown'],
                datasets: [{ data: [58, 17, 11, 8, 6], backgroundColor: ['#5a5a5a', '#b3b3b3', '#8f8f8f', '#1f1f1f', '#d0d0d0'] }],
                scales: {}
            },
            {
                type: 'table',
                title: 'Employment Sectors of IT Graduates',
                headers: ['Employment Sectors', 'Percentage', 'Average Income in Pounds Sterling'],
                rows: [
                    ['Software Engineer', '32%', '61,000'],
                    ['Data Analyst', '21%', '49,000'],
                    ['IT Support', '15%', '34,000'],
                    ['Cybersecurity', '10%', '58,000'],
                    ['Other', '22%', '36,000']
                ]
            }
        ],
        1097: [
            {
                type: 'bar',
                title: 'Annual Tourist Arrivals by Region',
                labels: ['Europe', 'Asia', 'Americas', 'Africa'],
                datasets: [
                    { label: '2019 (millions)', data: [128, 142, 98, 44], backgroundColor: '#4f81bd' },
                    { label: '2025 (millions)', data: [136, 161, 107, 53], backgroundColor: '#c0504d' }
                ],
                scales: { y: { text: 'Millions' } }
            },
            {
                type: 'table',
                title: 'Average Tourist Spending per Trip (2025)',
                headers: ['Region', 'Leisure', 'Business', 'Total Average'],
                rows: [
                    ['Europe', '$810', '$1,120', '$930'],
                    ['Asia', '$730', '$1,060', '$860'],
                    ['Americas', '$790', '$1,180', '$940'],
                    ['Africa', '$620', '$980', '$770']
                ]
            }
        ],
        1098: [
            {
                type: 'pie',
                title: 'Device Used for Online Learning',
                labels: ['Laptop', 'Desktop', 'Tablet', 'Phone'],
                datasets: [{ data: [49, 18, 16, 17], backgroundColor: ['#4f81bd', '#c0504d', '#9bbb59', '#8064a2'] }],
                scales: {}
            },
            {
                type: 'bar',
                title: 'Preferred Learning Mode by User Group',
                labels: ['All users', 'Daily users', 'Weekly users', 'Occasional users'],
                datasets: [
                    { label: 'Prefer online mode', data: [57, 69, 55, 33], backgroundColor: '#4f81bd' },
                    { label: 'Prefer classroom mode', data: [43, 31, 45, 67], backgroundColor: '#c0504d' }
                ],
                scales: { y: { text: 'Percentage (%)', min: 0, max: 90 } }
            }
        ],
        1099: [
            {
                type: 'pie',
                title: 'Destination of Business Graduates',
                labels: ['Full-time work', 'Part-time work', 'Postgraduate study', 'Unemployed', 'Unknown'],
                datasets: [{ data: [54, 19, 10, 11, 6], backgroundColor: ['#5a5a5a', '#b3b3b3', '#8f8f8f', '#1f1f1f', '#d0d0d0'] }],
                scales: {}
            },
            {
                type: 'table',
                title: 'Employment Sectors of Business Graduates',
                headers: ['Employment Sectors', 'Percentage', 'Average Income in Pounds Sterling'],
                rows: [
                    ['Finance', '24%', '56,000'],
                    ['Sales', '21%', '41,000'],
                    ['Marketing', '17%', '45,000'],
                    ['Operations', '13%', '43,000'],
                    ['Other', '25%', '34,000']
                ]
            }
        ],
        1100: [
            {
                type: 'bar',
                title: 'Electricity Generation by Source',
                labels: ['Solar', 'Wind', 'Hydro', 'Gas', 'Coal'],
                datasets: [
                    { label: '2015 (TWh)', data: [32, 51, 88, 142, 171], backgroundColor: '#4f81bd' },
                    { label: '2025 (TWh)', data: [94, 116, 101, 138, 102], backgroundColor: '#c0504d' }
                ],
                scales: { y: { text: 'TWh' } }
            },
            {
                type: 'table',
                title: 'Average Carbon Emission by Source (2025)',
                headers: ['Source', 'gCO2/kWh', 'Share of Grid', 'Trend'],
                rows: [
                    ['Solar', '48', '17%', 'Up'],
                    ['Wind', '14', '21%', 'Up'],
                    ['Hydro', '24', '18%', 'Stable'],
                    ['Gas', '450', '25%', 'Down'],
                    ['Coal', '820', '19%', 'Down']
                ]
            }
        ],
        1101: [
            {
                type: 'pie',
                title: 'How People Access News',
                labels: ['Mobile apps', 'TV', 'Web portals', 'Print media'],
                datasets: [{ data: [38, 27, 23, 12], backgroundColor: ['#4f81bd', '#c0504d', '#9bbb59', '#8064a2'] }],
                scales: {}
            },
            {
                type: 'bar',
                title: 'Trust Level by News Channel',
                labels: ['All adults', '18-29', '30-49', '50+'],
                datasets: [
                    { label: 'Trust digital sources', data: [41, 63, 44, 23], backgroundColor: '#4f81bd' },
                    { label: 'Trust traditional sources', data: [59, 37, 56, 77], backgroundColor: '#c0504d' }
                ],
                scales: { y: { text: 'Percentage (%)', min: 0, max: 90 } }
            }
        ],
        1102: [
            {
                type: 'pie',
                title: 'Destination of Arts Graduates',
                labels: ['Full-time work', 'Freelance', 'Postgraduate study', 'Unemployed', 'Unknown'],
                datasets: [{ data: [43, 21, 14, 15, 7], backgroundColor: ['#5a5a5a', '#b3b3b3', '#8f8f8f', '#1f1f1f', '#d0d0d0'] }],
                scales: {}
            },
            {
                type: 'table',
                title: 'Employment Sectors of Arts Graduates',
                headers: ['Employment Sectors', 'Percentage', 'Average Income in Pounds Sterling'],
                rows: [
                    ['Design', '23%', '39,000'],
                    ['Teaching', '19%', '34,000'],
                    ['Media', '16%', '42,000'],
                    ['Administration', '12%', '31,000'],
                    ['Other', '30%', '29,000']
                ]
            }
        ],
        1103: [
            {
                type: 'bar',
                title: 'Hospital Patient Visits by Department',
                labels: ['Emergency', 'Cardiology', 'Pediatrics', 'Orthopedics'],
                datasets: [
                    { label: '2020 (thousand)', data: [122, 74, 83, 61], backgroundColor: '#4f81bd' },
                    { label: '2025 (thousand)', data: [138, 81, 90, 69], backgroundColor: '#c0504d' }
                ],
                scales: { y: { text: 'Thousand visits' } }
            },
            {
                type: 'table',
                title: 'Average Waiting Time and Cost (2025)',
                headers: ['Department', 'Avg Waiting Time', 'Avg Cost per Visit', 'Satisfaction'],
                rows: [
                    ['Emergency', '56 min', '$120', '78%'],
                    ['Cardiology', '38 min', '$190', '84%'],
                    ['Pediatrics', '31 min', '$95', '88%'],
                    ['Orthopedics', '42 min', '$170', '81%']
                ]
            }
        ],
        1104: [
            {
                type: 'pie',
                title: 'Household Waste Composition',
                labels: ['Organic', 'Plastic', 'Paper', 'Glass/Metal'],
                datasets: [{ data: [41, 24, 22, 13], backgroundColor: ['#4f81bd', '#c0504d', '#9bbb59', '#8064a2'] }],
                scales: {}
            },
            {
                type: 'bar',
                title: 'Waste Processing Method by Area',
                labels: ['Urban', 'Suburban', 'Rural', 'National Avg'],
                datasets: [
                    { label: 'Recycled', data: [48, 39, 31, 41], backgroundColor: '#4f81bd' },
                    { label: 'Landfilled', data: [52, 61, 69, 59], backgroundColor: '#c0504d' }
                ],
                scales: { y: { text: 'Percentage (%)', min: 0, max: 90 } }
            }
        ],
        1105: [
            {
                type: 'pie',
                title: 'Destination of Language Graduates',
                labels: ['Full-time work', 'Part-time work', 'Further study', 'Unemployed', 'Unknown'],
                datasets: [{ data: [49, 20, 13, 12, 6], backgroundColor: ['#5a5a5a', '#b3b3b3', '#8f8f8f', '#1f1f1f', '#d0d0d0'] }],
                scales: {}
            },
            {
                type: 'table',
                title: 'Employment Sectors of Language Graduates',
                headers: ['Employment Sectors', 'Percentage', 'Average Income in Pounds Sterling'],
                rows: [
                    ['Translation', '25%', '44,000'],
                    ['Teaching', '29%', '33,000'],
                    ['Tourism', '14%', '31,000'],
                    ['Publishing', '8%', '36,000'],
                    ['Other', '24%', '30,000']
                ]
            }
        ],
        1106: [
            {
                type: 'bar',
                title: 'Quarterly E-commerce Revenue by Category',
                labels: ['Electronics', 'Fashion', 'Home Goods', 'Beauty'],
                datasets: [
                    { label: 'Q1 (million USD)', data: [84, 63, 52, 41], backgroundColor: '#4f81bd' },
                    { label: 'Q4 (million USD)', data: [102, 71, 64, 56], backgroundColor: '#c0504d' }
                ],
                scales: { y: { text: 'Million USD' } }
            },
            {
                type: 'table',
                title: 'Average Basket Value and Return Rate',
                headers: ['Category', 'Avg Basket Value', 'Return Rate', 'YoY Growth'],
                rows: [
                    ['Electronics', '$189', '7.2%', '11%'],
                    ['Fashion', '$74', '13.4%', '8%'],
                    ['Home Goods', '$96', '6.3%', '14%'],
                    ['Beauty', '$52', '4.9%', '16%']
                ]
            }
        ],
        1107: [
            {
                type: 'pie',
                title: 'Preferred Banking Channel',
                labels: ['Mobile app', 'Online web', 'Branch visit', 'Phone banking'],
                datasets: [{ data: [44, 27, 21, 8], backgroundColor: ['#4f81bd', '#c0504d', '#9bbb59', '#8064a2'] }],
                scales: {}
            },
            {
                type: 'bar',
                title: 'Channel Preference by Customer Segment',
                labels: ['All customers', 'Premium', 'Standard', 'Senior'],
                datasets: [
                    { label: 'Prefer digital banking', data: [71, 83, 74, 39], backgroundColor: '#4f81bd' },
                    { label: 'Prefer in-person banking', data: [29, 17, 26, 61], backgroundColor: '#c0504d' }
                ],
                scales: { y: { text: 'Percentage (%)', min: 0, max: 90 } }
            }
        ],
        1108: [
            {
                type: 'pie',
                title: 'Destination of Engineering Graduates',
                labels: ['Full-time work', 'Part-time work', 'Postgraduate study', 'Unemployed', 'Unknown'],
                datasets: [{ data: [61, 12, 15, 7, 5], backgroundColor: ['#5a5a5a', '#b3b3b3', '#8f8f8f', '#1f1f1f', '#d0d0d0'] }],
                scales: {}
            },
            {
                type: 'table',
                title: 'Employment Sectors of Engineering Graduates',
                headers: ['Employment Sectors', 'Percentage', 'Average Income in Pounds Sterling'],
                rows: [
                    ['Civil Engineering', '20%', '52,000'],
                    ['Mechanical Engineering', '23%', '55,000'],
                    ['Software Engineering', '27%', '63,000'],
                    ['Manufacturing', '11%', '46,000'],
                    ['Other', '19%', '37,000']
                ]
            }
        ],
        1109: [
            {
                type: 'bar',
                title: 'Public School Enrollment by Level',
                labels: ['Primary', 'Lower Secondary', 'Upper Secondary', 'Vocational'],
                datasets: [
                    { label: '2016 (thousand)', data: [690, 472, 328, 119], backgroundColor: '#4f81bd' },
                    { label: '2025 (thousand)', data: [721, 496, 351, 164], backgroundColor: '#c0504d' }
                ],
                scales: { y: { text: 'Thousand students' } }
            },
            {
                type: 'table',
                title: 'Teacher-Student Ratio and Graduation Rate (2025)',
                headers: ['Level', 'Teacher-Student Ratio', 'Graduation Rate', 'Average Annual Cost'],
                rows: [
                    ['Primary', '1:24', '96%', '$2,100'],
                    ['Lower Secondary', '1:22', '92%', '$2,600'],
                    ['Upper Secondary', '1:20', '89%', '$3,200'],
                    ['Vocational', '1:17', '86%', '$3,800']
                ]
            }
        ]
    };

    // Safety fallback: if any mixed meeting key is missing, map 1090-1109 to 1050-1059.
    for (let id = 1090; id <= 1109; id += 1) {
        if (!mixedConfigs[id]) {
            const sourceId = 1050 + ((id - 1090) % 10);
            mixedConfigs[id] = mixedConfigs[sourceId];
        }
    }

    // --- Line Chart Data Configs ---
    const lineConfigs = {
        111: { // Population Statistics (fallback for meeting 111)
            title: 'Population Statistics',
            labels: ['2010', '2012', '2014', '2016', '2018'],
            datasets: [
                { label: 'Total Population (millions)', data: [62, 65, 68, 70, 73], borderColor: '#3b82f6', backgroundColor: 'rgba(59, 130, 246, 0.1)', borderWidth: 4, pointBackgroundColor: '#3b82f6', pointRadius: 5, tension: 0.4, fill: true }
            ]
        },
        1010: { // Solar vs Coal (Original)
            title: 'Energy Production (TWh)',
            labels: ['2010', '2012', '2014', '2016', '2018', '2020'],
            datasets: [
                { label: 'Solar Energy', data: [10, 15, 25, 40, 60, 80], borderColor: '#3b82f6', backgroundColor: 'rgba(59, 130, 246, 0.1)', borderWidth: 4, pointBackgroundColor: '#3b82f6', pointRadius: 5, tension: 0.4, fill: true },
                { label: 'Coal Energy', data: [80, 75, 70, 60, 50, 40], borderColor: '#ef4444', backgroundColor: 'rgba(239, 68, 68, 0.1)', borderWidth: 4, pointBackgroundColor: '#ef4444', pointRadius: 5, tension: 0.4, fill: true }
            ]
        },
        1011: { // Electric vs Petrol Cars
            title: 'Car Sales Market Share (%)',
            labels: ['2015', '2016', '2017', '2018', '2019', '2020'],
            datasets: [
                { label: 'Electric Cars', data: [5, 12, 20, 35, 55, 70], borderColor: '#3b82f6', backgroundColor: 'rgba(59, 130, 246, 0.1)', borderWidth: 4, pointBackgroundColor: '#3b82f6', pointRadius: 5, tension: 0.4, fill: true },
                { label: 'Petrol Cars', data: [85, 80, 70, 55, 35, 20], borderColor: '#ef4444', backgroundColor: 'rgba(239, 68, 68, 0.1)', borderWidth: 4, pointBackgroundColor: '#ef4444', pointRadius: 5, tension: 0.4, fill: true }
            ]
        },
        1012: { // Book Sales
            title: 'Book Sales (Millions)',
            labels: ['2000', '2005', '2010', '2015', '2020'],
            datasets: [
                { label: 'Digital Books', data: [2, 10, 40, 75, 95], borderColor: '#3b82f6', backgroundColor: 'rgba(59, 130, 246, 0.1)', borderWidth: 4, pointBackgroundColor: '#3b82f6', pointRadius: 5, tension: 0.4, fill: true },
                { label: 'Physical Books', data: [90, 80, 55, 30, 15], borderColor: '#ef4444', backgroundColor: 'rgba(239, 68, 68, 0.1)', borderWidth: 4, pointBackgroundColor: '#ef4444', pointRadius: 5, tension: 0.4, fill: true }
            ]
        },
        1013: { // Coffee vs Tea
            title: 'Daily Consumption (Cups per Person)',
            labels: ['1990', '1995', '2000', '2005', '2010', '2015'],
            datasets: [
                { label: 'Coffee', data: [1.2, 1.5, 2.1, 2.5, 3.0, 3.2], borderColor: '#3b82f6', backgroundColor: 'rgba(59, 130, 246, 0.1)', borderWidth: 4, pointBackgroundColor: '#3b82f6', pointRadius: 5, tension: 0.4, fill: true },
                { label: 'Tea', data: [3.5, 3.2, 2.8, 2.4, 2.0, 1.8], borderColor: '#ef4444', backgroundColor: 'rgba(239, 68, 68, 0.1)', borderWidth: 4, pointBackgroundColor: '#ef4444', pointRadius: 5, tension: 0.4, fill: true },
                { label: 'Water', data: [4.0, 4.1, 4.2, 4.3, 4.5, 5.0], borderColor: '#10b981', backgroundColor: 'rgba(16, 185, 129, 0.1)', borderWidth: 4, pointBackgroundColor: '#10b981', pointRadius: 5, tension: 0.4, fill: true }
            ]
        },
        1014: { // Population Growth
            title: 'Population Growth (Millions)',
            labels: ['1960', '1970', '1980', '1990', '2000', '2010'],
            datasets: [
                { label: 'Urban', data: [100, 150, 250, 400, 600, 850], borderColor: '#3b82f6', backgroundColor: 'rgba(59, 130, 246, 0.1)', borderWidth: 4, pointBackgroundColor: '#3b82f6', pointRadius: 5, tension: 0.4, fill: true },
                { label: 'Rural', data: [900, 880, 850, 800, 750, 700], borderColor: '#ef4444', backgroundColor: 'rgba(239, 68, 68, 0.1)', borderWidth: 4, pointBackgroundColor: '#ef4444', pointRadius: 5, tension: 0.4, fill: true },
                { label: 'Suburban', data: [50, 100, 200, 350, 450, 500], borderColor: '#f59e0b', backgroundColor: 'rgba(245, 158, 11, 0.1)', borderWidth: 4, pointBackgroundColor: '#f59e0b', pointRadius: 5, tension: 0.4, fill: true }
            ]
        },
        1015: { // Internet Users
            title: 'Internet Users (% of Population)',
            labels: ['2000', '2005', '2010', '2015', '2020', '2025'],
            datasets: [
                { label: 'Developed Countries', data: [40, 60, 75, 85, 90, 95], borderColor: '#3b82f6', backgroundColor: 'rgba(59, 130, 246, 0.1)', borderWidth: 4, pointBackgroundColor: '#3b82f6', pointRadius: 5, tension: 0.4, fill: true },
                { label: 'Developing Countries', data: [5, 15, 30, 50, 70, 85], borderColor: '#ef4444', backgroundColor: 'rgba(239, 68, 68, 0.1)', borderWidth: 4, pointBackgroundColor: '#ef4444', pointRadius: 5, tension: 0.4, fill: true }
            ]
        },
        1016: { // Temperature Change
            title: 'Global Temperature Anomaly (°C)',
            labels: ['1980', '1990', '2000', '2010', '2020'],
            datasets: [
                { label: 'Land', data: [0.1, 0.3, 0.6, 0.9, 1.2], borderColor: '#ef4444', backgroundColor: 'rgba(239, 68, 68, 0.1)', borderWidth: 4, pointBackgroundColor: '#ef4444', pointRadius: 5, tension: 0.4, fill: true },
                { label: 'Ocean', data: [0.05, 0.15, 0.35, 0.55, 0.75], borderColor: '#3b82f6', backgroundColor: 'rgba(59, 130, 246, 0.1)', borderWidth: 4, pointBackgroundColor: '#3b82f6', pointRadius: 5, tension: 0.4, fill: true }
            ]
        },
        1017: { // Fast Food Consumption
            title: 'Weekly Fast Food Consumption (Times)',
            labels: ['2010', '2012', '2014', '2016', '2018', '2020'],
            datasets: [
                { label: 'Pizza', data: [1, 1.5, 2, 2.5, 3, 3.5], borderColor: '#f59e0b', backgroundColor: 'rgba(245, 158, 11, 0.1)', borderWidth: 4, pointBackgroundColor: '#f59e0b', pointRadius: 5, tension: 0.4, fill: true },
                { label: 'Burgers', data: [2, 2.2, 2.3, 2.1, 1.8, 1.5], borderColor: '#ef4444', backgroundColor: 'rgba(239, 68, 68, 0.1)', borderWidth: 4, pointBackgroundColor: '#ef4444', pointRadius: 5, tension: 0.4, fill: true },
                { label: 'Salads', data: [0.5, 0.8, 1.2, 1.8, 2.5, 3.0], borderColor: '#10b981', backgroundColor: 'rgba(16, 185, 129, 0.1)', borderWidth: 4, pointBackgroundColor: '#10b981', pointRadius: 5, tension: 0.4, fill: true }
            ]
        },
        1018: { // Smartphone Ownership
            title: 'Smartphone Ownership by Age Group (%)',
            labels: ['2012', '2014', '2016', '2018', '2020'],
            datasets: [
                { label: '18-29', data: [60, 75, 85, 95, 98], borderColor: '#3b82f6', backgroundColor: 'rgba(59, 130, 246, 0.1)', borderWidth: 4, pointBackgroundColor: '#3b82f6', pointRadius: 5, tension: 0.4, fill: true },
                { label: '30-49', data: [40, 55, 70, 85, 92], borderColor: '#10b981', backgroundColor: 'rgba(16, 185, 129, 0.1)', borderWidth: 4, pointBackgroundColor: '#10b981', pointRadius: 5, tension: 0.4, fill: true },
                { label: '50-64', data: [20, 30, 45, 60, 75], borderColor: '#f59e0b', backgroundColor: 'rgba(245, 158, 11, 0.1)', borderWidth: 4, pointBackgroundColor: '#f59e0b', pointRadius: 5, tension: 0.4, fill: true }
            ]
        },
        1019: { // Precious Metal Prices
            title: 'Average Precious Metal Prices (USD per oz)',
            labels: ['2015', '2016', '2017', '2018', '2019', '2020'],
            datasets: [
                { label: 'Gold', data: [1160, 1250, 1260, 1270, 1390, 1770], borderColor: '#eab308', backgroundColor: 'rgba(234, 179, 8, 0.1)', borderWidth: 4, pointBackgroundColor: '#eab308', pointRadius: 5, tension: 0.4, fill: true },
                { label: 'Silver', data: [16, 17, 17, 16, 16, 20], borderColor: '#9ca3af', backgroundColor: 'rgba(156, 163, 175, 0.1)', borderWidth: 4, pointBackgroundColor: '#9ca3af', pointRadius: 5, tension: 0.4, fill: true },
                { label: 'Platinum', data: [1050, 980, 950, 850, 850, 900], borderColor: '#6366f1', backgroundColor: 'rgba(99, 102, 241, 0.1)', borderWidth: 4, pointBackgroundColor: '#6366f1', pointRadius: 5, tension: 0.4, fill: true },
                { label: 'Palladium', data: [690, 610, 870, 1030, 1500, 2300], borderColor: '#ec4899', backgroundColor: 'rgba(236, 72, 153, 0.1)', borderWidth: 4, pointBackgroundColor: '#ec4899', pointRadius: 5, tension: 0.4, fill: true }
            ]
        },
        // additional line chart practices
        1020: { title: 'Radio and Television Audiences (UK Oct–Dec 1992)', labels: ['6am','9am','12pm','3pm','6pm','9pm','12am'], datasets: [{ label:'Radio (%)', data:[20,30,25,35,45,50,40], borderColor:'#3b82f6', backgroundColor:'rgba(59,130,246,0.1)', borderWidth:4, pointRadius:4, tension:0.4, fill:true }, { label:'Television (%)', data:[10,25,40,55,65,70,60], borderColor:'#ef4444', backgroundColor:'rgba(239,68,68,0.1)', borderWidth:4, pointRadius:4, tension:0.4, fill:true }] },
        1021: { title: 'Channel One News Viewing Figures', labels: ['Jan','Apr','Jul','Oct'], datasets: [{ label:'1pm', data:[2,3,2.5,3], borderColor:'#3b82f6', backgroundColor:'rgba(59,130,246,0.1)', borderWidth:4, pointRadius:4, tension:0.4, fill:true }, { label:'6pm', data:[4,5,4.5,5], borderColor:'#10b981', backgroundColor:'rgba(16,185,129,0.1)', borderWidth:4, pointRadius:4, tension:0.4, fill:true }, { label:'9:30pm', data:[3,3.5,3,3.5], borderColor:'#f59e0b', backgroundColor:'rgba(245,158,11,0.1)', borderWidth:4, pointRadius:4, tension:0.4, fill:true }, { label:'11pm', data:[2.5,2,2.2,2], borderColor:'#6366f1', backgroundColor:'rgba(99,102,241,0.1)', borderWidth:4, pointRadius:4, tension:0.4, fill:true }] },
        1022: { title: 'Tourist Attractions in Scotland', labels: ['2010','2012','2014','2016'], datasets: [{ label:'Aquarium', data:[15,18,20,22], borderColor:'#3b82f6', backgroundColor:'rgba(59,130,246,0.1)', borderWidth:4, pointRadius:4, tension:0.4, fill:true }, { label:'Castle', data:[25,23,24,26], borderColor:'#ef4444', backgroundColor:'rgba(239,68,68,0.1)', borderWidth:4, pointRadius:4, tension:0.4, fill:true }, { label:'Zoo', data:[10,12,15,17], borderColor:'#10b981', backgroundColor:'rgba(16,185,129,0.1)', borderWidth:4, pointRadius:4, tension:0.4, fill:true }, { label:'Festival', data:[5,8,12,15], borderColor:'#f59e0b', backgroundColor:'rgba(245,158,11,0.1)', borderWidth:4, pointRadius:4, tension:0.4, fill:true }] },
        1023: { title: 'Daily Energy Consumption Fluctuations', labels: ['0h','6h','12h','18h','24h'], datasets: [{ label:'Residential', data:[30,20,50,40,30], borderColor:'#3b82f6', backgroundColor:'rgba(59,130,246,0.1)', borderWidth:4, pointRadius:4, tension:0.4, fill:true }, { label:'Industrial', data:[40,60,30,50,40], borderColor:'#ef4444', backgroundColor:'rgba(239,68,68,0.1)', borderWidth:4, pointRadius:4, tension:0.4, fill:true }] },
        1024: { title: 'Internet Usage by Age Group', labels: ['Morning','Afternoon','Evening','Night'], datasets: [{ label:'18-25', data:[20,35,50,40], borderColor:'#3b82f6', backgroundColor:'rgba(59,130,246,0.1)', borderWidth:4, pointRadius:4, tension:0.4, fill:true }, { label:'26-40', data:[15,30,45,35], borderColor:'#10b981', backgroundColor:'rgba(16,185,129,0.1)', borderWidth:4, pointRadius:4, tension:0.4, fill:true }, { label:'41-60', data:[10,20,30,25], borderColor:'#f59e0b', backgroundColor:'rgba(245,158,11,0.1)', borderWidth:4, pointRadius:4, tension:0.4, fill:true }] },
        1025: { title: 'Temperature Variations Over a Week', labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'], datasets: [{ label:'Morning (Naik)', data:[15,16,18,19,20,21,22], borderColor:'#3b82f6', backgroundColor:'rgba(59,130,246,0.1)', borderWidth:4, pointRadius:4, tension:0, fill:true }, { label:'Afternoon (Turun)', data:[28,27,26,25,24,23,22], borderColor:'#ef4444', backgroundColor:'rgba(239,68,68,0.1)', borderWidth:4, pointRadius:4, tension:0, fill:true }, { label:'Evening (Stabil)', data:[20,20,20,20,20,20,20], borderColor:'#10b981', backgroundColor:'rgba(16,185,129,0.1)', borderWidth:4, pointRadius:4, tension:0, fill:true }, { label:'Night (Fluktuasi)', data:[18,21,19,22,18,20,17], borderColor:'#f59e0b', backgroundColor:'rgba(245,158,11,0.1)', borderWidth:4, pointRadius:4, tension:0, fill:true }] },
        1026: { title: 'Stock Market Index Changes', labels: ['9am','11am','1pm','3pm','5pm'], datasets: [ { label:'NASDAQ', data:[25, 30, 28, 32, 35], borderColor:'#3b82f6', backgroundColor:'rgba(59,130,246,0.1)', borderWidth:4, pointRadius:4, tension:0, fill:true }, { label:'Dow Jones', data:[30, 28, 29, 27, 25], borderColor:'#ef4444', backgroundColor:'rgba(239,68,68,0.1)', borderWidth:4, pointRadius:4, tension:0, fill:true }, { label:'S&P 500', data:[20, 22, 24, 23, 26], borderColor:'#10b981', backgroundColor:'rgba(16,185,129,0.1)', borderWidth:4, pointRadius:4, tension:0, fill:true }, { label:'FTSE 100', data:[15, 18, 17, 19, 18], borderColor:'#f59e0b', backgroundColor:'rgba(245,158,11,0.1)', borderWidth:4, pointRadius:4, tension:0, fill:true }, { label:'CAC 40', data:[12, 14, 16, 15, 17], borderColor:'#8b5cf6', backgroundColor:'rgba(139,92,246,0.1)', borderWidth:4, pointRadius:4, tension:0, fill:true } ] },
        1027: { title: 'Water Usage Throughout the Day', labels: ['0h','4h','8h','12h','16h','20h','24h'], datasets: [{ label:'Residential (Fluktuasi)', data:[50,30,40,80,70,60,55], borderColor:'#3b82f6', backgroundColor:'rgba(59,130,246,0.1)', borderWidth:4, pointRadius:4, tension:0, fill:true }, { label:'Commercial (Naik)', data:[40,45,50,55,60,65,70], borderColor:'#ef4444', backgroundColor:'rgba(239,68,68,0.1)', borderWidth:4, pointRadius:4, tension:0, fill:true }, { label:'Industrial (Stabil)', data:[60,58,60,59,61,60,59], borderColor:'#10b981', backgroundColor:'rgba(16,185,129,0.1)', borderWidth:4, pointRadius:4, tension:0, fill:true }, { label:'Agricultural (Turun)', data:[70,65,60,55,50,45,40], borderColor:'#f59e0b', backgroundColor:'rgba(245,158,11,0.1)', borderWidth:4, pointRadius:4, tension:0, fill:true }] },
        1028: { title: 'Flight Departures by Time of Day', labels: ['6am','9am','12pm','3pm','6pm','9pm'], datasets: [ { label:'Domestic (Naik)', data:[5,10,15,20,25,30], borderColor:'#3b82f6', backgroundColor:'rgba(59,130,246,0.1)', borderWidth:4, pointRadius:4, tension:0, fill:true }, { label:'International (Fluktuasi)', data:[3,7,5,18,15,8], borderColor:'#ef4444', backgroundColor:'rgba(239,68,68,0.1)', borderWidth:4, pointRadius:4, tension:0, fill:true }, { label:'Regional (Stabil)', data:[8,9,8,9,8,9], borderColor:'#10b981', backgroundColor:'rgba(16,185,129,0.1)', borderWidth:4, pointRadius:4, tension:0, fill:true }, { label:'Cargo (Turun)', data:[12,10,8,6,4,2], borderColor:'#f59e0b', backgroundColor:'rgba(245,158,11,0.1)', borderWidth:4, pointRadius:4, tension:0, fill:true } ] },
        1029: { title: 'Retail Store Footfall', labels: ['8am','10am','12pm','2pm','4pm','6pm','8pm'], datasets: [ { label:'Weekday (Fluktuasi)', data:[20,40,30,80,60,50,30], borderColor:'#3b82f6', backgroundColor:'rgba(59,130,246,0.1)', borderWidth:4, pointRadius:4, tension:0, fill:true }, { label:'Weekend (Naik)', data:[15,20,30,40,50,55,60], borderColor:'#10b981', backgroundColor:'rgba(16,185,129,0.1)', borderWidth:4, pointRadius:4, tension:0, fill:true }, { label:'Holiday (Stabil)', data:[25,25,25,25,25,25,25], borderColor:'#f59e0b', backgroundColor:'rgba(245,158,11,0.1)', borderWidth:4, pointRadius:4, tension:0, fill:true }, { label:'Peak Hours (Turun)', data:[90,80,70,60,50,40,30], borderColor:'#8b5cf6', backgroundColor:'rgba(139,92,246,0.1)', borderWidth:4, pointRadius:4, tension:0, fill:true } ] }
    };

    // --- Bar Chart Data Configs ---
    const barConfigs = {
        1030: { // Trade Volume (Original)
            title: 'Trade Volume (Billion USD)',
            labels: ['USA', 'China', 'India', 'Russia', 'Japan'],
            datasets: [
                { label: 'Export', data: [500, 700, 300, 400, 450], backgroundColor: 'rgba(59, 130, 246, 0.8)', borderColor: '#2563eb', borderWidth: 2 },
                { label: 'Import', data: [800, 600, 400, 200, 500], backgroundColor: 'rgba(239, 68, 68, 0.8)', borderColor: '#dc2626', borderWidth: 2 }
            ]
        },
        1031: { // Graduate Employment
            title: 'Graduate Employment Rates by Field (%)',
            labels: ['Science', 'Engineering', 'Arts', 'Business', 'Law'],
            datasets: [
                { label: '2010', data: [85, 92, 70, 78, 88], backgroundColor: 'rgba(59, 130, 246, 0.8)', borderColor: '#2563eb', borderWidth: 2 },
                { label: '2020', data: [90, 95, 65, 75, 82], backgroundColor: 'rgba(239, 68, 68, 0.8)', borderColor: '#dc2626', borderWidth: 2 }
            ]
        },
        1032: { // Tourism
            title: 'Annual Tourist Arrivals (Millions)',
            labels: ['France', 'USA', 'Spain', 'China', 'Italy'],
            datasets: [
                { label: '2018', data: [89, 79, 83, 63, 62], backgroundColor: 'rgba(59, 130, 246, 0.8)', borderColor: '#2563eb', borderWidth: 2 },
                { label: '2019', data: [91, 80, 84, 66, 65], backgroundColor: 'rgba(239, 68, 68, 0.8)', borderColor: '#dc2626', borderWidth: 2 }
            ]
        },
        1033: { // Screen Time
            title: 'Average Daily Screen Time (Hours)',
            labels: ['Teens', 'Young Adults', 'Adults', 'Seniors'],
            datasets: [
                { label: 'Mobile', data: [4.5, 5.0, 3.5, 1.5], backgroundColor: 'rgba(59, 130, 246, 0.8)', borderColor: '#2563eb', borderWidth: 2 },
                { label: 'Desktop', data: [2.0, 3.5, 4.0, 2.0], backgroundColor: 'rgba(239, 68, 68, 0.8)', borderColor: '#dc2626', borderWidth: 2 }
            ]
        },
        1034: { // Renewable Energy
            title: 'Renewable Energy Capacity (GW)',
            labels: ['Wind', 'Solar', 'Hydro', 'Biomass'],
            datasets: [
                { label: '2015', data: [433, 227, 1064, 106], backgroundColor: 'rgba(59, 130, 246, 0.8)', borderColor: '#2563eb', borderWidth: 2 },
                { label: '2020', data: [733, 714, 1154, 127], backgroundColor: 'rgba(239, 68, 68, 0.8)', borderColor: '#dc2626', borderWidth: 2 },
                { label: '2025 (Projected)', data: [1100, 1200, 1300, 150], backgroundColor: 'rgba(16, 185, 129, 0.8)', borderColor: '#059669', borderWidth: 2 }
            ]
        },
        1035: { // Gender Pay Gap
            title: 'Average Hourly Earnings ($)',
            labels: ['Healthcare', 'Education', 'Finance', 'Tech', 'Construction'],
            datasets: [
                { label: 'Men', data: [35, 30, 45, 50, 28], backgroundColor: 'rgba(59, 130, 246, 0.8)', borderColor: '#2563eb', borderWidth: 2 },
                { label: 'Women', data: [32, 29, 38, 42, 26], backgroundColor: 'rgba(239, 68, 68, 0.8)', borderColor: '#dc2626', borderWidth: 2 },
                { label: 'Industry Avg', data: [33.5, 29.5, 41.5, 46, 27], backgroundColor: 'rgba(245, 158, 11, 0.8)', borderColor: '#d97706', borderWidth: 2 }
            ]
        },
        1036: { // Household Waste
            title: 'Weekly Household Waste (kg)',
            labels: ['Paper', 'Plastic', 'Glass', 'Metal', 'Organic'],
            datasets: [
                { label: 'Recycled', data: [5, 3, 2, 1, 8], backgroundColor: 'rgba(16, 185, 129, 0.8)', borderColor: '#059669', borderWidth: 2 },
                { label: 'Landfill', data: [1, 4, 0.5, 0.2, 2], backgroundColor: 'rgba(75, 85, 99, 0.8)', borderColor: '#374151', borderWidth: 2 },
                { label: 'Compost', data: [4, 0.5, 0.1, 0, 7], backgroundColor: 'rgba(245, 158, 11, 0.8)', borderColor: '#d97706', borderWidth: 2 }
            ]
        },
        1037: { // Transportation Mode
            title: 'Commuting Method to Work (%)',
            labels: ['Car', 'Bus', 'Train', 'Bike', 'Walk'],
            datasets: [
                { label: 'City A', data: [45, 25, 20, 5, 5], backgroundColor: 'rgba(59, 130, 246, 0.8)', borderColor: '#2563eb', borderWidth: 2 },
                { label: 'City B', data: [30, 30, 25, 10, 5], backgroundColor: 'rgba(245, 158, 11, 0.8)', borderColor: '#d97706', borderWidth: 2 },
                { label: 'City C', data: [15, 35, 35, 10, 5], backgroundColor: 'rgba(16, 185, 129, 0.8)', borderColor: '#059669', borderWidth: 2 },
                { label: 'City D', data: [10, 20, 40, 20, 10], backgroundColor: 'rgba(139, 92, 246, 0.8)', borderColor: '#7c3aed', borderWidth: 2 }
            ]
        },
        1038: { // Housing Types
            title: 'Housing Preferences by Age Group (%)',
            labels: ['Young Adults', 'Families', 'Retirees'],
            datasets: [
                { label: 'Apartment', data: [60, 10, 20], backgroundColor: 'rgba(59, 130, 246, 0.8)', borderColor: '#2563eb', borderWidth: 2 },
                { label: 'House', data: [10, 70, 40], backgroundColor: 'rgba(239, 68, 68, 0.8)', borderColor: '#dc2626', borderWidth: 2 },
                { label: 'Condo', data: [20, 10, 30], backgroundColor: 'rgba(16, 185, 129, 0.8)', borderColor: '#059669', borderWidth: 2 },
                { label: 'Townhouse', data: [10, 10, 10], backgroundColor: 'rgba(245, 158, 11, 0.8)', borderColor: '#d97706', borderWidth: 2 }
            ]
        },
        1039: { // Olympic Medals
            title: 'Olympic Medals Won (Top 5 Countries)',
            labels: ['USA', 'China', 'Japan', 'GB', 'ROC'],
            datasets: [
                { label: 'Gold', data: [39, 38, 27, 22, 20], backgroundColor: '#eab308', borderColor: '#ca8a04', borderWidth: 2 },
                { label: 'Silver', data: [41, 32, 14, 21, 28], backgroundColor: '#94a3b8', borderColor: '#475569', borderWidth: 2 },
                { label: 'Bronze', data: [33, 18, 17, 22, 23], backgroundColor: '#b45309', borderColor: '#78350f', borderWidth: 2 },
                { label: 'Total', data: [113, 88, 58, 65, 71], backgroundColor: '#3b82f6', borderColor: '#2563eb', borderWidth: 2 }
            ]
        },
        1040: { // Manufacturing Output by Country
            title: 'Manufacturing Output by Country',
            labels: ['Country A','Country B','Country C','Country D'],
            datasets: [
                { label: '2010', data: [50,60,70,80], backgroundColor: 'rgba(59,130,246,0.8)', borderColor: '#2563eb', borderWidth: 2 },
                { label: '2020', data: [60,70,80,90], backgroundColor: 'rgba(239,68,68,0.8)', borderColor: '#dc2626', borderWidth: 2 }
            ]
        },
        1041: { // Retail Sales by Category
            title: 'Retail Sales by Category',
            labels: ['Electronics','Clothing','Food','Furniture','Toys'],
            datasets: [
                { label: '2019', data: [20,30,25,15,10], backgroundColor: 'rgba(59,130,246,0.8)', borderColor: '#2563eb', borderWidth: 2 },
                { label: '2021', data: [25,35,20,18,12], backgroundColor: 'rgba(239,68,68,0.8)', borderColor: '#dc2626', borderWidth: 2 }
            ]
        },
        1042: { // Annual Coffee Consumption
            title: 'Annual Coffee Consumption (kg per capita)',
            labels: ['Country A','Country B','Country C','Country D'],
            datasets: [
                { label: '2015', data: [4,5,3,6], backgroundColor:'rgba(59,130,246,0.8)',borderColor:'#2563eb',borderWidth:2 },
                { label: '2020', data: [5,6,4,7], backgroundColor:'rgba(239,68,68,0.8)',borderColor:'#dc2626',borderWidth:2 }
            ]
        },
        1043: { // Internet Connectivity
            title: 'Internet Connectivity Speed by Region',
            labels: ['North','South','East','West'],
            datasets:[
                { label:'Average Mbps', data:[50,60,55,45], backgroundColor:'rgba(59,130,246,0.8)',borderColor:'#2563eb',borderWidth:2 }
            ]
        },
        1044: { // Public Transport Usage
            title: 'Public Transportation Usage Trends',
            labels: ['Bus','Train','Metro','Tram'],
            datasets:[
                { label:'Users (Millions)', data:[30,40,50,20], backgroundColor:'rgba(239,68,68,0.8)',borderColor:'#dc2626',borderWidth:2 }
            ]
        },
        1045: { // Movie Box Office
            title: 'Movie Box Office Revenue by Genre',
            labels: ['Action','Comedy','Drama','Horror','Sci-Fi'],
            datasets:[
                { label:'Revenue ($M)', data:[120,90,80,60,100], backgroundColor:'rgba(59,130,246,0.8)',borderColor:'#2563eb',borderWidth:2 }
            ]
        },
        1046: { // Life Expectancy
            title: 'Average Life Expectancy by Country',
            labels: ['Country A','Country B','Country C','Country D','Country E'],
            datasets:[
                { label:'Years', data:[78,80,75,82,79], backgroundColor:'rgba(16,185,129,0.8)',borderColor:'#059669',borderWidth:2 }
            ]
        },
        1047: { // Fast Food Growth
            title: 'Fast Food Restaurant Growth',
            labels: ['2010','2012','2014','2016','2018'],
            datasets:[
                { label:'McDonalds', data:[800, 950, 1100, 1300, 1500], backgroundColor:'rgba(59,130,246,0.8)',borderColor:'#2563eb',borderWidth:2 },
                { label:'KFC', data:[600, 750, 900, 1050, 1200], backgroundColor:'rgba(239,68,68,0.8)',borderColor:'#dc2626',borderWidth:2 },
                { label:'Subway', data:[500, 620, 740, 860, 980], backgroundColor:'rgba(16,185,129,0.8)',borderColor:'#059669',borderWidth:2 },
                { label:'Burger King', data:[400, 520, 640, 760, 880], backgroundColor:'rgba(245,158,11,0.8)',borderColor:'#d97706',borderWidth:2 }
            ]
        },
        1048: { // University Funding
            title: 'University Funding by Department (%)',
            labels: ['Science','Arts','Business','Engineering','Medicine'],
            datasets:[
                { label:'2018', data:[22, 18, 19, 21, 20], backgroundColor:'rgba(59,130,246,0.8)',borderColor:'#2563eb',borderWidth:2 },
                { label:'2019', data:[23, 17, 20, 20, 20], backgroundColor:'rgba(239,68,68,0.8)',borderColor:'#dc2626',borderWidth:2 },
                { label:'2020', data:[24, 16, 21, 19, 20], backgroundColor:'rgba(16,185,129,0.8)',borderColor:'#059669',borderWidth:2 }
            ]
        },
        1049: { // Vehicle Ownership
            title: 'Vehicle Ownership Across Age Groups',
            labels: ['18-25','26-35','36-45','46-55','56+'],
            datasets:[
                { label:'Cars', data:[50,60,70,65,55], backgroundColor:'rgba(59,130,246,0.8)',borderColor:'#2563eb',borderWidth:2 },
                { label:'Motorcycles', data:[30,40,50,45,35], backgroundColor:'rgba(239,68,68,0.8)',borderColor:'#dc2626',borderWidth:2 },
                { label:'Bicycles', data:[20,15,10,12,18], backgroundColor:'rgba(16,185,129,0.8)',borderColor:'#059669',borderWidth:2 },
                { label:'Public Transport Passes', data:[10,15,20,25,30], backgroundColor:'rgba(245,158,11,0.8)',borderColor:'#d97706',borderWidth:2 }
            ]
        },
        67: { // Custom for Meeting 67
            title: 'Market Share by Product Category (%)',
            labels: ['Electronics', 'Clothing', 'Food', 'Furniture', 'Books'],
            datasets: [
                { label: 'Company A', data: [20, 30, 25, 15, 10], backgroundColor: 'rgba(59, 130, 246, 0.8)', borderColor: '#2563eb', borderWidth: 2 },
                { label: 'Company B', data: [25, 20, 30, 20, 15], backgroundColor: 'rgba(239, 68, 68, 0.8)', borderColor: '#dc2626', borderWidth: 2 },
                { label: 'Company C', data: [15, 25, 20, 25, 20], backgroundColor: 'rgba(16, 185, 129, 0.8)', borderColor: '#059669', borderWidth: 2 },
                { label: 'Company D', data: [30, 15, 15, 20, 25], backgroundColor: 'rgba(245, 158, 11, 0.8)', borderColor: '#d97706', borderWidth: 2 },
                { label: 'Company E', data: [10, 10, 10, 20, 30], backgroundColor: 'rgba(139, 92, 246, 0.8)', borderColor: '#7c3aed', borderWidth: 2 }
            ]
        }
    };

    // --- Pie Chart Data Configs ---
    // palettes for double pie charts (left normal, right different)
    const pieLightPalette = ['#3b82f6', '#10b981', '#f59e0b', '#ec4899', '#8b5cf6'];
    const pieDarkPalette  = ['#5c3d2e', '#dc2626', '#6b7280', '#000000', '#fde047', '#86efac', '#06b6d4'];
    const pieConfigs = {
        1030: { // Household Spending (Original)
            title: 'Average Household Spending',
            labels: ['Housing', 'Food', 'Transport', 'Entertainment', 'Savings'],
            datasets: [{ 
                data: [35, 25, 15, 15, 10], 
                backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        1031: { // Global Energy Mix
            title: 'Global Energy Consumption by Source',
            labels: ['Oil', 'Coal', 'Gas', 'Renewables', 'Nuclear'],
            datasets: [{ 
                data: [31, 27, 23, 15, 4], 
                backgroundColor: ['#1f2937', '#4b5563', '#9ca3af', '#10b981', '#f59e0b'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        1032: { // Diet/Food Consumption
            title: 'Average Daily Calorie Intake',
            labels: ['Grains', 'Meat', 'Dairy', 'Fruits/Veg', 'Sugars'],
            datasets: [{ 
                data: [45, 20, 15, 15, 5], 
                backgroundColor: ['#f59e0b', '#ef4444', '#3b82f6', '#10b981', '#8b5cf6'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        1033: { // Browser Market Share
            title: 'Web Browser Market Share',
            labels: ['Chrome', 'Safari', 'Edge', 'Firefox', 'Other'],
            datasets: [{ 
                data: [65, 18, 5, 3, 9], 
                backgroundColor: ['#3b82f6', '#06b6d4', '#2563eb', '#f97316', '#64748b'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        1034: { // Music Streaming
            title: 'Music Streaming Platform Subscribers (Millions)',
            labels: ['Spotify', 'Apple Music', 'Amazon', 'Tencent', 'Others'],
            datasets: [{ 
                data: [320, 160, 130, 130, 260], 
                backgroundColor: ['#10b981', '#ef4444', '#3b82f6', '#16a34a', '#64748b'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        1035: { // Mobile OS
            title: 'Mobile Operating System Share',
            labels: ['Android', 'iOS', 'Others'],
            datasets: [{ 
                data: [71, 28, 1], 
                backgroundColor: ['#3b82f6', '#000000', '#9ca3af'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        1036: { // Water Usage
            title: 'Global Water Usage by Sector',
            labels: ['Agriculture', 'Industrial', 'Domestic'],
            datasets: [{ 
                data: [70, 19, 11], 
                backgroundColor: ['#10b981', '#6b7280', '#3b82f6'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        1037: { // Online Sales
            title: 'Online Retail Sales by Category (Million USD)',
            labels: ['Fashion', 'Electronics', 'Toys', 'Furniture', 'Food'],
            datasets: [{ 
                data: [2500, 2200, 1800, 1500, 2000], 
                backgroundColor: ['#ec4899', '#3b82f6', '#f59e0b', '#8b5cf6', '#10b981'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        1038: { // Education Level
            title: 'Educational Attainment (Adults 25-64)',
            labels: ['Below Upper Secondary', 'Upper Secondary', 'Tertiary'],
            datasets: [{ 
                data: [20, 45, 35], 
                backgroundColor: ['#ef4444', '#f59e0b', '#3b82f6'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        1039: { // Employment Sectors
            title: 'Employment by Economic Sector (Thousands)',
            labels: ['Services', 'Industry', 'Agriculture'],
            datasets: [{ 
                data: [5200, 2300, 2500], 
                backgroundColor: ['#3b82f6', '#6b7280', '#10b981'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        }
    };

    const doublePieConfigs = {
        // 5th-20th pie practices (meeting 1054-1069)
        1054: {
            left: {
                title: 'Reasons for cycling to work',
                labels: ['Health and fitness', 'Less pollution', 'No parking problems', 'No costs', 'Faster than driving'],
                datasets: [{ data: [35, 25, 15, 10, 15], backgroundColor: ['#f97316', '#fde047', '#22c55e', '#a16207', '#4b5563'], borderWidth: 2, borderColor: '#ffffff' }]
            },
            right: {
                title: 'Reasons for driving to work',
                labels: ['Comfort', 'Distance to work', 'Reliability', 'Safer at night', 'Transporting items'],
                datasets: [{ data: [28, 22, 18, 18, 14], backgroundColor: ['#2563eb', '#7c3aed', '#facc15', '#14b8a6', '#ef4444'], borderWidth: 2, borderColor: '#ffffff' }]
            }
        },
        1055: {
            left: {
                title: 'Why people prefer public transport',
                labels: ['Cost', 'No parking', 'Less stress', 'Eco-friendly', 'Relaxing'],
                datasets: [{ data: [30, 20, 18, 17, 15], backgroundColor: ['#10b981', '#6b7280', '#f97316', '#0ea5e9', '#8b5cf6'], borderWidth: 2, borderColor: '#ffffff' }]
            },
            right: {
                title: 'Why people prefer private cars',
                labels: ['Convenience', 'Privacy', 'Flexible schedule', 'Faster routes', 'Comfort'],
                datasets: [{ data: [35, 18, 17, 15, 15], backgroundColor: ['#3b82f6', '#f59e0b', '#ef4444', '#22c55e', '#a855f7'], borderWidth: 2, borderColor: '#ffffff' }]
            }
        },
        1056: {
            left: {
                title: 'Reasons to shop online',
                labels: ['Convenience', 'Variety', 'Better prices', 'Reviews', 'No travel'],
                datasets: [{ data: [33, 25, 20, 12, 10], backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#8b5cf6', '#64748b'], borderWidth: 2, borderColor: '#ffffff' }]
            },
            right: {
                title: 'Reasons to shop in-store',
                labels: ['See product', 'Immediate pickup', 'Try before buy', 'No shipping', 'Social experience'],
                datasets: [{ data: [28, 22, 18, 16, 16], backgroundColor: ['#ef4444', '#f97316', '#6366f1', '#0ea5e9', '#a16207'], borderWidth: 2, borderColor: '#ffffff' }]
            }
        },
        1057: {
            left: {
                title: 'Reasons for drinking coffee',
                labels: ['Energy boost', 'Taste', 'Routine', 'Social', 'Warmth'],
                datasets: [{ data: [35, 20, 18, 15, 12], backgroundColor: ['#3b82f6', '#ef4444', '#f59e0b', '#10b981', '#8b5cf6'], borderWidth: 2, borderColor: '#ffffff' }]
            },
            right: {
                title: 'Reasons for drinking tea',
                labels: ['Relaxing', 'Health benefits', 'Taste', 'Tradition', 'Variety'],
                datasets: [{ data: [30, 22, 18, 16, 14], backgroundColor: ['#10b981', '#0ea5e9', '#f97316', '#6366f1', '#a855f7'], borderWidth: 2, borderColor: '#ffffff' }]
            }
        },
        1058: {
            left: {
                title: 'Preferred summer vacation',
                labels: ['Beach', 'City tour', 'Nature', 'Adventure sports', 'Cruise'],
                datasets: [{ data: [35, 25, 20, 10, 10], backgroundColor: ['#3b82f6', '#f59e0b', '#10b981', '#ef4444', '#8b5cf6'], borderWidth: 2, borderColor: '#ffffff' }]
            },
            right: {
                title: 'Preferred winter vacation',
                labels: ['Skiing', 'City markets', 'Relaxing resort', 'Cultural tour', 'Family visit'],
                datasets: [{ data: [25, 20, 20, 18, 17], backgroundColor: ['#1d4ed8', '#9333ea', '#eab308', '#047857', '#dc2626'], borderWidth: 2, borderColor: '#ffffff' }]
            }
        },
        1059: {
            left: {
                title: 'Why people stream movies at home',
                labels: ['Cost', 'Convenience', 'Variety', 'No ads', 'Comfort'],
                datasets: [{ data: [30, 25, 20, 15, 10], backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'], borderWidth: 2, borderColor: '#ffffff' }]
            },
            right: {
                title: 'Why people go to the cinema',
                labels: ['Big screen', 'Sound quality', 'Social', 'New releases', 'Experience'],
                datasets: [{ data: [28, 22, 18, 16, 16], backgroundColor: ['#1f2937', '#0f766e', '#7c3aed', '#c2410c', '#065f46'], borderWidth: 2, borderColor: '#ffffff' }]
            }
        },
        1060: {
            left: {
                title: 'Why people eat fast food',
                labels: ['Speed', 'Taste', 'Price', 'Convenience', 'Availability'],
                datasets: [{ data: [32, 25, 20, 15, 8], backgroundColor: ['#ef4444', '#f97316', '#3b82f6', '#10b981', '#8b5cf6'], borderWidth: 2, borderColor: '#ffffff' }]
            },
            right: {
                title: 'Why people cook at home',
                labels: ['Healthier', 'Cost saving', 'Family time', 'Custom recipes', 'Control ingredients'],
                datasets: [{ data: [30, 22, 18, 16, 14], backgroundColor: ['#1d4ed8', '#16a34a', '#7c3aed', '#9333ea', '#dc2626'], borderWidth: 2, borderColor: '#ffffff' }]
            }
        },
        1061: {
            left: {
                title: 'Why some people prefer online learning',
                labels: ['Flexibility', 'Cost', 'Access', 'Self pace', 'Variety'],
                datasets: [{ data: [34, 22, 18, 14, 12], backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'], borderWidth: 2, borderColor: '#ffffff' }]
            },
            right: {
                title: 'Why some prefer classroom learning',
                labels: ['Interaction', 'Structure', 'Networking', 'Immediate feedback', 'Motivation'],
                datasets: [{ data: [28, 24, 18, 16, 14], backgroundColor: ['#1f2937', '#0f766e', '#7c3aed', '#c2410c', '#065f46'], borderWidth: 2, borderColor: '#ffffff' }]
            }
        },
        1062: {
            left: {
                title: 'Reasons for choosing smartphones',
                labels: ['Brand', 'Camera', 'Battery', 'Price', 'Features'],
                datasets: [{ data: [30, 25, 20, 15, 10], backgroundColor: ['#3b82f6', '#f97316', '#10b981', '#8b5cf6', '#ef4444'], borderWidth: 2, borderColor: '#ffffff' }]
            },
            right: {
                title: 'Reasons for choosing tablets',
                labels: ['Screen size', 'Portability', 'Battery', 'Price', 'Apps'],
                datasets: [{ data: [27, 24, 18, 16, 15], backgroundColor: ['#1d4ed8', '#16a34a', '#7c3aed', '#9333ea', '#dc2626'], borderWidth: 2, borderColor: '#ffffff' }]
            }
        },
        1063: {
            left: {
                title: 'Popular music formats',
                labels: ['Streaming', 'CDs', 'Vinyl', 'Downloads', 'Radio'],
                datasets: [{ data: [40, 20, 10, 15, 15], backgroundColor: ['#3b82f6', '#ef4444', '#10b981', '#f59e0b', '#8b5cf6'], borderWidth: 2, borderColor: '#ffffff' }]
            },
            right: {
                title: 'Why people listen to music',
                labels: ['Relax', 'Focus', 'Workout', 'Celebrate', 'Social'],
                datasets: [{ data: [30, 25, 18, 15, 12], backgroundColor: ['#10b981', '#3b82f6', '#f97316', '#ef4444', '#a855f7'], borderWidth: 2, borderColor: '#ffffff' }]
            }
        },
        1064: {
            left: {
                title: 'Reasons for exercising at a gym',
                labels: ['Equipment', 'Classes', 'Motivation', 'Social', 'Comfort'],
                datasets: [{ data: [30, 22, 18, 15, 15], backgroundColor: ['#3b82f6', '#f59e0b', '#10b981', '#ef4444', '#8b5cf6'], borderWidth: 2, borderColor: '#ffffff' }]
            },
            right: {
                title: 'Reasons for exercising outdoors',
                labels: ['Fresh air', 'Scenery', 'Cost free', 'Flexibility', 'Sunlight'],
                datasets: [{ data: [28, 24, 20, 14, 14], backgroundColor: ['#10b981', '#0ea5e9', '#f97316', '#6366f1', '#a855f7'], borderWidth: 2, borderColor: '#ffffff' }]
            }
        },
        1065: {
            left: {
                title: 'Why people study alone',
                labels: ['Focus', 'Schedule', 'Pace', 'Less distraction', 'Comfort'],
                datasets: [{ data: [32, 24, 18, 15, 11], backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'], borderWidth: 2, borderColor: '#ffffff' }]
            },
            right: {
                title: 'Why people study in groups',
                labels: ['Discussion', 'Motivation', 'Help', 'Accountability', 'Fun'],
                datasets: [{ data: [28, 26, 18, 14, 14], backgroundColor: ['#ef4444', '#f97316', '#0ea5e9', '#6366f1', '#a855f7'], borderWidth: 2, borderColor: '#ffffff' }]
            }
        },
        1066: {
            left: {
                title: 'Why people own dogs',
                labels: ['Companionship', 'Security', 'Exercise', 'Loyalty', 'Fun'],
                datasets: [{ data: [30, 25, 18, 15, 12], backgroundColor: ['#3b82f6', '#ef4444', '#10b981', '#f59e0b', '#8b5cf6'], borderWidth: 2, borderColor: '#ffffff' }]
            },
            right: {
                title: 'Why people own cats',
                labels: ['Low maintenance', 'Quiet', 'Independent', 'Companionship', 'Cleanliness'],
                datasets: [{ data: [28, 22, 20, 15, 15], backgroundColor: ['#10b981', '#3b82f6', '#f97316', '#ef4444', '#6366f1'], borderWidth: 2, borderColor: '#ffffff' }]
            }
        },
        1067: {
            left: {
                title: 'Commuting by public transport',
                labels: ['Cost', 'Reliability', 'Convenience', 'Crowding', 'Safety'],
                datasets: [{ data: [32, 22, 20, 14, 12], backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'], borderWidth: 2, borderColor: '#ffffff' }]
            },
            right: {
                title: 'Commuting by car',
                labels: ['Privacy', 'Flexibility', 'Comfort', 'Speed', 'Cost'],
                datasets: [{ data: [30, 24, 18, 16, 12], backgroundColor: ['#ef4444', '#f97316', '#0ea5e9', '#6366f1', '#a855f7'], borderWidth: 2, borderColor: '#ffffff' }]
            }
        },
        1068: {
            left: {
                title: 'Favorite sweet snacks',
                labels: ['Chocolate', 'Ice Cream', 'Cookies', 'Cake', 'Candy'],
                datasets: [{ data: [30, 25, 20, 15, 10], backgroundColor: ['#ef4444', '#f97316', '#3b82f6', '#10b981', '#8b5cf6'], borderWidth: 2, borderColor: '#ffffff' }]
            },
            right: {
                title: 'Favorite savory snacks',
                labels: ['Chips', 'Nuts', 'Pretzels', 'Crackers', 'Popcorn'],
                datasets: [{ data: [28, 24, 18, 15, 15], backgroundColor: ['#3b82f6', '#f59e0b', '#10b981', '#ef4444', '#6366f1'], borderWidth: 2, borderColor: '#ffffff' }]
            }
        },
        1069: {
            left: {
                title: 'Most important health priority',
                labels: ['Exercise', 'Diet', 'Sleep', 'Stress', 'Hydration'],
                datasets: [{ data: [30, 25, 20, 15, 10], backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'], borderWidth: 2, borderColor: '#ffffff' }]
            },
            right: {
                title: 'Secondary health focus',
                labels: ['Mental health', 'Routine check-ups', 'Social life', 'Hygiene', 'Vaccinations'],
                datasets: [{ data: [25, 20, 18, 17, 20], backgroundColor: ['#10b981', '#3b82f6', '#f97316', '#ef4444', '#6366f1'], borderWidth: 2, borderColor: '#ffffff' }]
            }
        }
    };

    // apply light/dark palettes to all double‐pie configs so the right chart
    // uses the same color hues as the left but in a darker shade
    for (const id in doublePieConfigs) {
        const entry = doublePieConfigs[id];
        if (entry.left && entry.left.datasets && entry.left.datasets[0]) {
            entry.left.datasets[0].backgroundColor = pieLightPalette;
        }
        if (entry.right && entry.right.datasets && entry.right.datasets[0]) {
            entry.right.datasets[0].backgroundColor = pieDarkPalette;
        }
    }

    const morePieConfigs = {
        1050: { // Average Household Spending (Pie)
            title: 'Average Household Spending',
            labels: ['Housing', 'Food', 'Transport', 'Entertainment', 'Savings'],
            datasets: [{
                data: [35, 25, 15, 15, 10],
                backgroundColor: ['#ef4444', '#3b82f6', '#f59e0b', '#10b981', '#8b5cf6'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        1051: { // Energy Sources
            title: 'Energy Generated by Source',
            labels: ['Wind', 'Solar', 'Hydro', 'Fossil', 'Nuclear'],
            datasets: [{
                data: [25, 20, 30, 15, 10],
                backgroundColor: ['#3b82f6', '#f59e0b', '#10b981', '#ef4444', '#6366f1'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        1052: { // Mobile OS Share
            title: 'Mobile OS Market Share',
            labels: ['Android', 'iOS', 'Others'],
            datasets: [{
                data: [72, 25, 3],
                backgroundColor: ['#10b981', '#2563eb', '#9ca3af'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        1053: { // Browser Market Share
            title: 'Web Browser Market Share',
            labels: ['Chrome', 'Safari', 'Edge', 'Firefox', 'Other'],
            datasets: [{
                data: [65, 18, 5, 3, 9],
                backgroundColor: ['#3b82f6', '#06b6d4', '#2563eb', '#f97316', '#64748b'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        1054: { // Education Attainment
            title: 'Educational Attainment (Adults 25-64)',
            labels: ['Below Upper Secondary', 'Upper Secondary', 'Tertiary'],
            datasets: [{
                data: [20, 45, 35],
                backgroundColor: ['#ef4444', '#f59e0b', '#3b82f6'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        1055: { // Transport Modes
            title: 'Transport Mode Usage',
            labels: ['Car', 'Bus', 'Train', 'Bicycle', 'Walking'],
            datasets: [{
                data: [45, 20, 15, 10, 10],
                backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        1056: { // Meal Preferences
            title: 'Preferred Meal Type',
            labels: ['Vegetarian', 'Vegan', 'Meat', 'Seafood', 'Other'],
            datasets: [{
                data: [25, 10, 40, 15, 10],
                backgroundColor: ['#10b981', '#22c55e', '#3b82f6', '#f97316', '#a855f7'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        1057: { // Social Media Platforms
            title: 'Social Media Platform Use',
            labels: ['Facebook', 'Instagram', 'Twitter', 'TikTok', 'LinkedIn'],
            datasets: [{
                data: [30, 25, 15, 20, 10],
                backgroundColor: ['#3b82f6', '#ec4899', '#0ea5e9', '#f97316', '#0ea5e9'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        1058: { // Vacation Types
            title: 'Preferred Vacation Type',
            labels: ['Beach', 'City', 'Nature', 'Cruise', 'Adventure'],
            datasets: [{
                data: [35, 20, 25, 10, 10],
                backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        1059: { // Device Ownership
            title: 'Device Ownership',
            labels: ['Smartphone', 'Tablet', 'Laptop', 'Desktop'],
            datasets: [{
                data: [65, 25, 45, 35],
                backgroundColor: ['#3b82f6', '#a855f7', '#10b981', '#f97316'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        1060: { // Meal Delivery Usage
            title: 'Meal Delivery Service Usage',
            labels: ['Daily', 'Weekly', 'Monthly', 'Rarely'],
            datasets: [{
                data: [15, 35, 30, 20],
                backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        1061: { // Exercise Habits
            title: 'Exercise Frequency',
            labels: ['Daily', '3-4 times/wk', '1-2 times/wk', 'Rarely'],
            datasets: [{
                data: [20, 30, 25, 25],
                backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        1062: { // Music Genre Preference
            title: 'Music Genre Preference',
            labels: ['Pop', 'Rock', 'Hip-Hop', 'Classical', 'Jazz'],
            datasets: [{
                data: [30, 25, 20, 15, 10],
                backgroundColor: ['#3b82f6', '#ef4444', '#f59e0b', '#10b981', '#8b5cf6'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        1063: { // Book Genre Popularity
            title: 'Book Genre Popularity',
            labels: ['Fiction', 'Non-fiction', 'Mystery', 'Sci-Fi', 'Romance'],
            datasets: [{
                data: [30, 25, 15, 15, 15],
                backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        1064: { // Movie Genre Preference
            title: 'Movie Genre Preference',
            labels: ['Action', 'Comedy', 'Drama', 'Horror', 'Animation'],
            datasets: [{
                data: [25, 20, 25, 15, 15],
                backgroundColor: ['#3b82f6', '#f59e0b', '#10b981', '#ef4444', '#8b5cf6'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        1065: { // Pet Ownership
            title: 'Pet Ownership',
            labels: ['Dogs', 'Cats', 'Fish', 'Birds', 'Others'],
            datasets: [{
                data: [35, 30, 15, 10, 10],
                backgroundColor: ['#3b82f6', '#ef4444', '#10b981', '#f59e0b', '#8b5cf6'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        1066: { // Vegetable Preference
            title: 'Preferred Vegetables',
            labels: ['Tomato', 'Potato', 'Carrot', 'Broccoli', 'Spinach'],
            datasets: [{
                data: [25, 20, 20, 20, 15],
                backgroundColor: ['#10b981', '#f59e0b', '#3b82f6', '#ef4444', '#8b5cf6'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        1067: { // Drink Preference
            title: 'Drink Preference',
            labels: ['Water', 'Tea', 'Coffee', 'Soda', 'Juice'],
            datasets: [{
                data: [25, 20, 25, 15, 15],
                backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        1068: { // Weekly Screen Time
            title: 'Weekly Screen Time Distribution',
            labels: ['TV', 'Phone', 'Tablet', 'Laptop', 'Other'],
            datasets: [{
                data: [35, 30, 15, 15, 5],
                backgroundColor: ['#3b82f6', '#f59e0b', '#10b981', '#ef4444', '#8b5cf6'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        1069: { // Coffee Consumption
            title: 'Coffee Consumption Frequency',
            labels: ['Daily', 'Weekly', 'Monthly', 'Rarely'],
            datasets: [{
                data: [30, 40, 20, 10],
                backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444'],
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        }
    };

    Object.assign(pieConfigs, morePieConfigs);

    // --- Table Data Configs ---
    const tableConfigs = {
        1040: { // City Population (Original) - 4 cols, 4 rows
            headers: ['City', 'Pop. (M)', 'Area (km²)', 'Density'],
            rows: [
                ['Tokyo', '37.4', '2,194', 'Higher'],
                ['Delhi', '29.3', '1,484', 'High'],
                ['Shanghai', '26.3', '6,340', 'Medium'],
                ['Sao Paulo', '21.8', '1,521', 'High']
            ],
            badges: { 3: { 'Higher': 'red', 'High': 'orange', 'Medium': 'yellow' } }
        },
        1041: { // University Rankings - 3 cols, 5 rows
            headers: ['University', 'Country', 'Rank 2023'],
            rows: [
                ['MIT', 'USA', '1'],
                ['Cambridge', 'UK', '2'],
                ['Oxford', 'UK', '3'],
                ['Harvard', 'USA', '4'],
                ['Stanford', 'USA', '5']
            ],
            badges: { 2: { '1': 'green', '2': 'green', '3': 'green', '4': 'green', '5': 'green' } }
        },
        1042: { // Nutrient Content - 5 cols, 6 rows
            headers: ['Food', 'Calories', 'Protein', 'Fat', 'Carbs'],
            rows: [
                ['Chicken', '165', '31g', '3.6g', '0g'],
                ['Salmon', '208', '20g', '13g', '0g'],
                ['Eggs', '155', '13g', '11g', '1.1g'],
                ['Almonds', '579', '21g', '49g', '22g'],
                ['Rice', '130', '2.7g', '0.3g', '28g'],
                ['Milk', '42', '3.4g', '1g', '5g']
            ],
            badges: {}
        },
        1043: { // Travel Destinations - 4 cols, 3 rows
            headers: ['Destination', 'Avg Cost', 'Visitors', 'Rating'],
            rows: [
                ['Paris', '$2500', '19.1 M', '4.8'],
                ['Bangkok', '$1200', '22.7 M', '4.6'],
                ['Dubai', '$1800', '15.9 M', '4.9']
            ],
            badges: { 3: { '4.8': 'green', '4.6': 'blue', '4.9': 'green' } }
        },
        1044: { // Internet Speeds - 3 cols, 5 rows
            headers: ['Country', 'Speed (Mbps)', 'Global Rank'],
            rows: [
                ['Singapore', '245.5', '1'],
                ['South Korea', '240.3', '2'],
                ['UAE', '238.1', '3'],
                ['Chile', '220.4', '4'],
                ['China', '210.8', '5']
            ],
            badges: { 2: { '1': 'green', '2': 'green', '3': 'blue', '4': 'blue', '5': 'blue' } }
        },
        1045: { // Top Tech Companies - 5 cols, 4 rows
            headers: ['Company', 'Market Cap', 'HQ', 'Founded', 'Employees'],
            rows: [
                ['Apple', '$3.05 T', 'USA', '1976', '164k'],
                ['Microsoft', '$2.80 T', 'USA', '1975', '221k'],
                ['Alphabet', '$1.75 T', 'USA', '1998', '190k'],
                ['Amazon', '$1.55 T', 'USA', '1994', '1.5M']
            ],
            badges: {}
        },
        1046: { // Weather - 4 cols, 6 rows
            headers: ['Month', 'Temp (°C)', 'Rainfall', 'Humidity'],
            rows: [
                ['January', '5', '80mm', '75%'],
                ['March', '10', '70mm', '70%'],
                ['May', '18', '60mm', '65%'],
                ['July', '28', '20mm', '50%'],
                ['September', '22', '40mm', '60%'],
                ['November', '8', '85mm', '80%']
            ],
            badges: { 3: { '75%': 'blue', '70%': 'blue', '65%': 'yellow', '50%': 'orange', '60%': 'yellow', '80%': 'blue' } }
        },
        1047: { // Vehicle Sales - 3 cols, 4 rows
            headers: ['Type', '2021 Sales', 'Trend'],
            rows: [
                ['Sedan', '45,000', 'Down'],
                ['SUV', '75,000', 'Up'],
                ['Truck', '42,000', 'Stable'],
                ['EV', '25,000', 'Rapid Up']
            ],
            badges: { 2: { 'Down': 'red', 'Up': 'green', 'Stable': 'yellow', 'Rapid Up': 'green' } }
        },
        1048: { // Coffee Production - 5 cols, 3 rows
            headers: ['Country', 'Output', 'Share', 'Type', 'Export'],
            rows: [
                ['Brazil', '3.5M', '35%', 'Arabica', '80%'],
                ['Vietnam', '1.8M', '18%', 'Robusta', '90%'],
                ['Colombia', '0.8M', '8%', 'Arabica', '75%']
            ],
            badges: { 4: { '80%': 'green', '90%': 'green', '75%': 'blue' } }
        },
        1049: { // Smartphone Specs - 4 cols, 5 rows
            headers: ['Model', 'Screen', 'Battery', 'Cam (MP)'],
            rows: [
                ['Phone X', '6.1"', '3200mAh', '12'],
                ['Phone Pro', '6.7"', '4300mAh', '48'],
                ['Galaxy S', '6.2"', '4000mAh', '50'],
                ['Pixel 7', '6.3"', '4355mAh', '50'],
                ['Note Ultra', '6.9"', '5000mAh', '108']
            ],
            badges: {}
        },
        1070: {
            title: 'Population Statistics',
            headers: ['Year', 'Population (millions)', 'Annual Growth (%)'],
            rows: [
                ['2010', '62', '1.2'],
                ['2012', '65', '1.3'],
                ['2014', '68', '1.2'],
                ['2016', '70', '1.1'],
                ['2018', '73', '1.0']
            ],
            badges: { 2: { '1.2': 'green', '1.3': 'green', '1.1': 'yellow', '1.0': 'yellow' } }
        },
        1071: {
            title: 'Annual Revenue by Sector',
            headers: ['Sector', '2018 ($m)', '2020 ($m)', '2022 ($m)'],
            rows: [
                ['Manufacturing', '245', '261', '289'],
                ['Technology', '198', '244', '318'],
                ['Retail', '176', '184', '211'],
                ['Energy', '154', '169', '193'],
                ['Healthcare', '133', '148', '172']
            ],
            badges: { 3: { '289': 'green', '318': 'green', '211': 'blue', '193': 'blue', '172': 'yellow' } }
        },
        1072: {
            title: 'Nutritional Content of Foods',
            headers: ['Food Item', 'Calories', 'Protein (g)', 'Fat (g)', 'Carbs (g)'],
            rows: [
                ['Oatmeal', '68', '2.4', '1.4', '12.0'],
                ['Boiled Egg', '155', '13.0', '11.0', '1.1'],
                ['Greek Yogurt', '97', '9.0', '4.0', '3.9'],
                ['Banana', '89', '1.1', '0.3', '22.8'],
                ['Grilled Salmon', '208', '20.0', '13.0', '0.0']
            ],
            badges: { 1: { '208': 'orange', '155': 'yellow', '97': 'blue', '89': 'blue', '68': 'green' } }
        },
        1073: {
            title: 'Travel Destinations',
            headers: ['Destination', 'Avg Cost ($)', 'Visitors (m)', 'Satisfaction'],
            rows: [
                ['Kyoto', '1450', '8.2', '4.7/5'],
                ['Barcelona', '1320', '9.5', '4.6/5'],
                ['Dubai', '1760', '12.1', '4.5/5'],
                ['Vancouver', '1580', '7.4', '4.8/5'],
                ['Cape Town', '1210', '6.8', '4.7/5']
            ],
            badges: { 3: { '4.8/5': 'green', '4.7/5': 'green', '4.6/5': 'blue', '4.5/5': 'yellow' } }
        },
        1074: {
            title: 'Internet Speeds by Country',
            headers: ['Country', 'Avg Speed (Mbps)', 'Global Rank'],
            rows: [
                ['Singapore', '284.9', '1'],
                ['United Arab Emirates', '269.1', '2'],
                ['Hong Kong', '266.5', '3'],
                ['South Korea', '254.3', '4'],
                ['Chile', '247.8', '5'],
                ['United States', '226.4', '9']
            ],
            badges: { 2: { '1': 'green', '2': 'green', '3': 'blue', '4': 'blue', '5': 'yellow', '9': 'yellow' } }
        },
        1075: {
            title: 'Top Tech Companies',
            headers: ['Company', 'Market Cap ($tn)', 'HQ', 'Founded', 'Employees'],
            rows: [
                ['Apple', '3.1', 'USA', '1976', '161k'],
                ['Microsoft', '2.9', 'USA', '1975', '221k'],
                ['Alphabet', '1.9', 'USA', '1998', '182k'],
                ['Amazon', '1.8', 'USA', '1994', '1.53m'],
                ['TSMC', '0.7', 'Taiwan', '1987', '73k']
            ],
            badges: { 1: { '3.1': 'green', '2.9': 'green', '1.9': 'blue', '1.8': 'blue', '0.7': 'yellow' } }
        },
        1076: {
            title: 'Weather and Climate Data',
            headers: ['Month', 'Temp (°C)', 'Rainfall (mm)', 'Humidity (%)'],
            rows: [
                ['January', '6', '78', '74'],
                ['March', '11', '66', '69'],
                ['May', '18', '54', '63'],
                ['July', '28', '22', '49'],
                ['September', '23', '38', '58'],
                ['November', '10', '81', '77']
            ],
            badges: { 3: { '74': 'blue', '69': 'blue', '63': 'yellow', '49': 'orange', '58': 'yellow', '77': 'blue' } }
        },
        1077: {
            title: 'Vehicle Sales Data',
            headers: ['Vehicle Type', 'Units Sold', 'Market Share', 'Trend'],
            rows: [
                ['SUV', '84,000', '34%', 'Up'],
                ['Sedan', '51,000', '21%', 'Down'],
                ['Pickup', '47,500', '19%', 'Stable'],
                ['Hybrid', '32,000', '13%', 'Rapid Up'],
                ['Electric', '28,500', '11%', 'Rapid Up']
            ],
            badges: { 3: { 'Up': 'green', 'Down': 'red', 'Stable': 'yellow', 'Rapid Up': 'green' } }
        },
        1078: {
            title: 'Coffee Production Statistics',
            headers: ['Country', 'Output (m bags)', 'Global Share', 'Main Variety', 'Export Ratio'],
            rows: [
                ['Brazil', '66.4', '37%', 'Arabica', '82%'],
                ['Vietnam', '30.2', '17%', 'Robusta', '91%'],
                ['Colombia', '12.6', '7%', 'Arabica', '74%'],
                ['Indonesia', '11.9', '6%', 'Robusta', '68%']
            ],
            badges: { 4: { '82%': 'green', '91%': 'green', '74%': 'blue', '68%': 'yellow' } }
        },
        1079: {
            title: 'Smartphone Technical Specifications',
            headers: ['Model', 'Screen', 'Battery', 'Camera (MP)', 'Price ($)'],
            rows: [
                ['Nova X', '6.1', '3200', '12', '699'],
                ['Apex Pro', '6.7', '4300', '48', '999'],
                ['Pixel Air', '6.3', '4355', '50', '899'],
                ['Galaxy Ultra', '6.8', '5000', '108', '1199'],
                ['Zen Lite', '6.0', '4100', '64', '749']
            ],
            badges: { 4: { '699': 'green', '749': 'green', '899': 'blue', '999': 'yellow', '1199': 'orange' } }
        },
        1080: {
            title: 'Hotel Amenities and Ratings',
            headers: ['Hotel Chain', 'Free Wi-Fi', 'Pool', 'Breakfast', 'Guest Rating'],
            rows: [
                ['Harbor Stay', 'Yes', 'Yes', 'Included', '4.6'],
                ['City Nest', 'Yes', 'No', 'Optional', '4.2'],
                ['Royal Crest', 'Yes', 'Yes', 'Included', '4.8'],
                ['Budget Inn', 'Yes', 'No', 'Not Included', '3.9']
            ],
            badges: { 4: { '4.8': 'green', '4.6': 'green', '4.2': 'blue', '3.9': 'yellow' } }
        },
        1081: {
            title: 'Student Test Scores by Subject',
            headers: ['Subject', 'Midterm Avg', 'Final Avg', 'Pass Rate'],
            rows: [
                ['Mathematics', '74', '79', '88%'],
                ['Science', '71', '76', '84%'],
                ['English', '78', '82', '91%'],
                ['History', '69', '74', '80%'],
                ['Economics', '73', '77', '86%']
            ],
            badges: { 3: { '91%': 'green', '88%': 'green', '86%': 'blue', '84%': 'blue', '80%': 'yellow' } }
        },
        1082: {
            title: 'Annual Rainfall and Precipitation',
            headers: ['Region', 'Spring (mm)', 'Summer (mm)', 'Winter (mm)'],
            rows: [
                ['North Coast', '210', '124', '298'],
                ['Central Plain', '165', '98', '244'],
                ['Highlands', '189', '132', '276'],
                ['South Basin', '142', '86', '201']
            ],
            badges: { 3: { '298': 'blue', '276': 'blue', '244': 'yellow', '201': 'yellow' } }
        },
        1083: {
            title: 'E-commerce Sales Performance',
            headers: ['Retailer', 'Revenue ($m)', 'Orders (k)', 'Margin', 'Growth'],
            rows: [
                ['ShopLink', '420', '980', '18%', '12%'],
                ['CartHub', '365', '910', '16%', '9%'],
                ['NovaMall', '298', '760', '14%', '15%'],
                ['Urban Basket', '255', '690', '13%', '7%']
            ],
            badges: { 4: { '15%': 'green', '12%': 'green', '9%': 'blue', '7%': 'yellow' } }
        },
        1084: {
            title: 'University Degree Statistics',
            headers: ['Degree Type', 'Graduates', 'Employment Rate', 'Median Salary ($)'],
            rows: [
                ['Engineering', '1,240', '93%', '58,000'],
                ['Business', '1,860', '89%', '51,000'],
                ['Computer Science', '980', '95%', '62,000'],
                ['Arts', '1,120', '78%', '39,000'],
                ['Health Sciences', '840', '94%', '56,000']
            ],
            badges: { 2: { '95%': 'green', '94%': 'green', '93%': 'green', '89%': 'blue', '78%': 'yellow' } }
        },
        1085: {
            title: 'Sales of Fairtrade-labelled coffee and bananas (1999 & 2004)',
            doubleTables: [
                {
                    headers: ['Coffee', '1999 (millions of euros)', '2004 (millions of euros)'],
                    rows: [
                        ['UK', '1.5', '20'],
                        ['Switzerland', '3', '6'],
                        ['Denmark', '1.8', '2'],
                        ['Belgium', '1', '1.7'],
                        ['Sweden', '0.8', '1']
                    ]
                },
                {
                    headers: ['Bananas', '1999 (millions of euros)', '2004 (millions of euros)'],
                    rows: [
                        ['UK', '15', '47'],
                        ['Switzerland', '1', '5.5'],
                        ['Denmark', '0.6', '4'],
                        ['Belgium', '1.8', '1'],
                        ['Sweden', '2', '0.9']
                    ]
                }
            ]
        },
        1086: {
            title: 'Energy production and household use (2010 & 2020)',
            doubleTables: [
                {
                    headers: ['Energy source', '2010 (TWh)', '2020 (TWh)'],
                    rows: [
                        ['Solar', '18', '74'],
                        ['Wind', '42', '96'],
                        ['Hydro', '88', '102'],
                        ['Coal', '210', '128'],
                        ['Gas', '156', '149']
                    ]
                },
                {
                    headers: ['Household use', '2010 (%)', '2020 (%)'],
                    rows: [
                        ['Lighting', '18', '12'],
                        ['Cooling/Heating', '42', '39'],
                        ['Cooking', '21', '19'],
                        ['Entertainment', '11', '16'],
                        ['Other', '8', '14']
                    ]
                }
            ]
        },
        1087: {
            title: 'Mobile OS users and app revenue (2018 & 2023)',
            doubleTables: [
                {
                    headers: ['Operating system', '2018 (millions)', '2023 (millions)'],
                    rows: [
                        ['Android', '1850', '2620'],
                        ['iOS', '980', '1410'],
                        ['HarmonyOS', '0', '280'],
                        ['Others', '230', '95']
                    ]
                },
                {
                    headers: ['App category', '2018 ($bn)', '2023 ($bn)'],
                    rows: [
                        ['Games', '48', '79'],
                        ['Productivity', '16', '33'],
                        ['Social Media', '21', '46'],
                        ['Streaming', '14', '37']
                    ]
                }
            ]
        },
        1088: {
            title: 'Tourist arrivals and tourism receipts (2012 & 2022)',
            doubleTables: [
                {
                    headers: ['Country', '2012 (millions)', '2022 (millions)'],
                    rows: [
                        ['France', '83', '79'],
                        ['Spain', '57', '71'],
                        ['Thailand', '22', '39'],
                        ['Japan', '8', '32'],
                        ['Turkey', '36', '51']
                    ]
                },
                {
                    headers: ['Country', '2012 ($bn)', '2022 ($bn)'],
                    rows: [
                        ['France', '56', '68'],
                        ['Spain', '57', '76'],
                        ['Thailand', '34', '59'],
                        ['Japan', '14', '44'],
                        ['Turkey', '29', '51']
                    ]
                }
            ]
        },
        1089: {
            title: 'Public transport usage and accident totals (2015 & 2025)',
            doubleTables: [
                {
                    headers: ['Transport mode', '2015 (million trips)', '2025 (million trips)'],
                    rows: [
                        ['Bus', '420', '510'],
                        ['Metro', '310', '448'],
                        ['Tram', '126', '174'],
                        ['Commuter rail', '204', '282']
                    ]
                },
                {
                    headers: ['Transport mode', '2015 (incidents)', '2025 (incidents)'],
                    rows: [
                        ['Bus', '142', '96'],
                        ['Metro', '48', '31'],
                        ['Tram', '27', '19'],
                        ['Commuter rail', '61', '44']
                    ]
                }
            ]
        }
    };
    
    // Logic to render specific table based on ID existing in DOM
    const tableContainer = document.getElementById('practiceTableContainer');
    if (tableContainer) {
        const tableFallbackIds = Object.keys(tableConfigs)
            .map(Number)
            .filter(id => id >= 1070 && id <= 1089)
            .sort((left, right) => left - right);
        const fallbackId = tableFallbackIds[Math.abs(meetingId) % tableFallbackIds.length] || 1070;
        const config = tableConfigs[meetingId] || tableConfigs[fallbackId];
        setInstruction(config.title || 'Table Data', 'table');
        
        const renderSingleTable = (tableData, useNeutralTheme = false) => {
            const tableClass = useNeutralTheme
                ? 'min-w-full text-base text-center text-gray-800 whitespace-nowrap border-2 border-gray-500'
                : 'min-w-full text-base text-center text-gray-800 whitespace-nowrap';
            const theadClass = useNeutralTheme
                ? 'bg-gray-200 font-extrabold uppercase text-gray-900 tracking-wide'
                : 'bg-gradient-to-r from-blue-600 to-indigo-600 font-extrabold uppercase text-white tracking-wider shadow-md';
            const tbodyClass = useNeutralTheme
                ? 'font-bold'
                : 'divide-y divide-gray-100 font-bold';

            let tableHtml = `<table class="${tableClass}"><thead class="${theadClass}"><tr>`;

            tableData.headers.forEach(header => {
                tableHtml += `<th class="px-4 py-3 text-lg border border-gray-400">${header}</th>`;
            });

            tableHtml += `</tr></thead><tbody class="${tbodyClass}">`;

            tableData.rows.forEach((row, rowIndex) => {
                const rowClass = useNeutralTheme
                    ? (rowIndex % 2 === 0 ? 'bg-white' : 'bg-gray-50')
                    : (rowIndex % 2 === 0 ? 'row-indigo' : 'row-fuchsia');
                tableHtml += `<tr class="${rowClass} ${useNeutralTheme ? '' : 'row-hover-yellow transition-colors duration-150'}">`;
                row.forEach((cell, index) => {
                    let cellContent = cell;
                    if (tableData.badges && tableData.badges[index] && tableData.badges[index][cell]) {
                        const color = tableData.badges[index][cell];
                        const bgClass = color === 'red' ? 'bg-red-100 text-red-800' :
                                        color === 'orange' ? 'bg-orange-100 text-orange-800' :
                                        color === 'yellow' ? 'bg-yellow-100 text-yellow-800' :
                                        color === 'green' ? 'bg-green-100 text-green-800' :
                                        color === 'blue' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800';
                        cellContent = `<span class="px-3 py-1.5 ${bgClass} rounded-full text-sm font-extrabold">${cell}</span>`;
                    }

                    const alignClass = index === 0 ? 'text-left text-indigo-700' : '';
                    tableHtml += `<td class="px-4 py-3 text-lg border border-gray-300 ${alignClass}">${cellContent}</td>`;
                });
                tableHtml += `</tr>`;
            });

            tableHtml += `</tbody></table>`;
            return tableHtml;
        };

        let html = '';
        if (Array.isArray(config.doubleTables) && config.doubleTables.length > 0) {
            html = '<div class="space-y-6">';
            config.doubleTables.forEach((tableData) => {
                html += renderSingleTable(tableData, true);
            });
            html += '</div>';
        } else {
            html = renderSingleTable(config);
        }
            
        tableContainer.innerHTML = html;
        tableContainer.classList.remove('hidden');
    }





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
                    
                    ctx.save();
                    ctx.font = 'bold 16px sans-serif';
                    ctx.fillStyle = 'white';
                    ctx.textAlign = 'center';
                    ctx.textBaseline = 'middle';
                    
                    ctx.shadowColor = 'rgba(0, 0, 0, 0.7)';
                    ctx.shadowBlur = 4;
                    ctx.shadowOffsetX = 1;
                    ctx.shadowOffsetY = 1;
                    
                    ctx.fillText(percentage, position.x, position.y);
                    ctx.restore();
                });
            });
        }
    };

    // Logic to render specific charts based on ID existing in DOM
    const lineCanvas = document.getElementById('practiceLineChart');
    if (lineCanvas) {
        // Fallback to 1010 if config not found
        const config = lineConfigs[meetingId] || lineConfigs[1010];
        setInstruction(config.title, 'chart');
        
        new Chart(lineCanvas.getContext('2d'), {
            type: 'line',
            data: {
                labels: config.labels,
                datasets: config.datasets
            },
            options: { 
                responsive: true, 
                maintainAspectRatio: false, 
                elements: {
                    line: { tension: 0 }
                },
                plugins: { 
                    title: { display: true, text: config.title, font: { size: 16 } },
                    legend: { position: 'bottom', labels: { font: { size: 14 } } }
                },
                scales: {
                    y: { grid: { color: 'rgba(0,0,0,0.05)' } },
                    x: { grid: { color: 'rgba(0,0,0,0.05)' } }
                }
            }
        });
    }

    const barCanvas = document.getElementById('practiceBarChart');
    if (barCanvas) {
        // Fallback to 1020 if config not found
        const config = barConfigs[meetingId] || barConfigs[1030];
        setInstruction(config.title, 'chart');

        new Chart(barCanvas.getContext('2d'), {
            type: 'bar',
            data: {
                labels: config.labels,
                datasets: config.datasets
            },
            options: { 
                 responsive: true, 
                 maintainAspectRatio: false, 
                 plugins: { 
                     title: { display: true, text: config.title, font: { size: 16 } },
                     legend: { position: 'bottom', labels: { font: { size: 14 } } }
                 },
                 scales: {
                    y: { grid: { color: 'rgba(0,0,0,0.05)' } }
                 }
            }
        });
    }

    // Double-pie chart support for a range of pie practices (e.g., 5th-20th pie item)
    const doublePieConfig = doublePieConfigs[meetingId];

    if (doublePieConfig) {
        const pieCanvas1 = document.getElementById('practicePieChart1');
        const pieCanvas2 = document.getElementById('practicePieChart2');

        if (pieCanvas1 && pieCanvas2) {
            setInstruction(`${doublePieConfig.left.title} & ${doublePieConfig.right.title}`, 'chart');

            new Chart(pieCanvas1.getContext('2d'), {
                type: 'pie',
                plugins: [pieLabelsPlugin],
                data: {
                    labels: doublePieConfig.left.labels,
                    datasets: doublePieConfig.left.datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: { display: true, text: doublePieConfig.left.title, font: { size: 16 } },
                        legend: { position: 'bottom', labels: { font: { size: 14 } } }
                    }
                }
            });

            new Chart(pieCanvas2.getContext('2d'), {
                type: 'pie',
                plugins: [pieLabelsPlugin],
                data: {
                    labels: doublePieConfig.right.labels,
                    datasets: doublePieConfig.right.datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        title: { display: true, text: doublePieConfig.right.title, font: { size: 16 } },
                        legend: { position: 'bottom', labels: { font: { size: 14 } } }
                    }
                }
            });
        }
        return;
    }

    const pieCanvas = document.getElementById('practicePieChart');
    if (pieCanvas) {
        // Fallback to 1030 if config not found
        const config = pieConfigs[meetingId] || pieConfigs[1050];
        setInstruction(config.title, 'chart');

        new Chart(pieCanvas.getContext('2d'), {
            type: 'pie',
            plugins: [pieLabelsPlugin],
            data: {
                labels: config.labels,
                datasets: config.datasets
            },
            options: { 
                 responsive: true, 
                 maintainAspectRatio: false, 
                 plugins: { 
                     title: { display: true, text: config.title, font: { size: 16 } },
                     legend: { position: 'bottom', labels: { font: { size: 14 } } }
                 }
            }
        });
    }

    // Logic to render Mixed Charts (Multi-Chart Support)
    const mixedContainer = document.getElementById('practiceMixedContainer');
    if (mixedContainer) {
        const configs = mixedConfigs[meetingId] || mixedConfigs[1090] || mixedConfigs[1050] || [];
        if (!Array.isArray(configs) || configs.length === 0) {
            mixedContainer.innerHTML = '<p class="text-gray-500 text-center py-10">No mixed chart data available for this practice item.</p>';
            return;
        }
        
        // Use first title or generic text
        const title = configs[0].title || 'statistical data';
        setInstruction(title, 'charts');
        
        // Clear container first
        mixedContainer.innerHTML = '';

        configs.forEach((config, index) => {
            // ... (rest of mixed chart rendering) ...
            // Create wrapper
            const wrapper = document.createElement('div');
            // Removed flex-1 to prevent unequal sizing, added flex-shrink-0 to enforce height
            wrapper.className = "relative w-full min-w-[300px] flex-shrink-0 bg-white rounded-lg shadow-sm border border-gray-100 p-4 overflow-auto";
            wrapper.style.height = "500px"; // Increased fixed height for better visibility
            
            // Check if type is 'table'
            if (config.type === 'table') {
                // ... (table logic) ...
                let tableHtml = `
                    <div class="h-full w-full flex flex-col">
                        ${config.title ? `<h3 class="text-center font-bold text-gray-700 mb-2" style="font-size: 16px;">${config.title}</h3>` : ''}
                        <div class="overflow-auto flex-1">
                            <table class="min-w-full text-base text-center text-gray-800 whitespace-nowrap">
                                <thead class="bg-gradient-to-r from-blue-600 to-indigo-600 font-extrabold uppercase text-white tracking-wider shadow-md sticky top-0">
                                    <tr>`;
                
                config.headers.forEach(header => {
                    tableHtml += `<th class="px-4 py-3 text-sm">${header}</th>`;
                });
                
                tableHtml += `   </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 font-bold text-sm">`;
                                
                config.rows.forEach((row, rowIndex) => {
                    const rowClass = rowIndex % 2 === 0 ? 'bg-indigo-50' : 'bg-white';
                    tableHtml += `<tr class="${rowClass} hover:bg-yellow-50 transition-colors duration-150">`;
                    row.forEach((cell, cellIndex) => {
                        const alignClass = cellIndex === 0 ? 'text-left text-indigo-700' : '';
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

            } else {
                // Chart Rendering Logic (Default)
                const canvas = document.createElement('canvas');
                canvas.id = `mixedChart_${index}`;
                canvas.style.width = '100%';
                canvas.style.height = '100%';
                
                wrapper.appendChild(canvas);
                mixedContainer.appendChild(wrapper);

                const chartType = config.type || 'bar';
                new Chart(canvas.getContext('2d'), {
                    type: chartType,
                    plugins: chartType === 'pie' ? [pieLabelsPlugin] : [],
                    data: {
                        labels: config.labels,
                        datasets: config.datasets
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

    // Logic for Flow Chart (1110-1129)
    if (meetingId >= 1110 && meetingId <= 1129) {
        if (meetingId === 1110) {
            setInstruction('the stages and equipment used in the cement-making process, and how cement is used to produce concrete for building purposes', 'diagram');
        } else if (meetingId === 1111) {
            setInstruction('the mass manufacturing of coconut oil', 'process diagram');
        } else if (meetingId === 1112) {
            setInstruction('how glass containers are made. The steps of the process are numbered 1 to 9', 'process diagram');
        } else if (meetingId === 1113) {
            setInstruction('the process by which sheep embryos are cloned', 'diagram');
        } else if (meetingId === 1114) {
            setInstruction('the process of the water treatment', 'diagram');
        } else if (meetingId === 1115) {
            setInstruction('the process by which electricity is generated in two types of hydroelectric power station', 'diagram');
        } else if (meetingId === 1116) {
            setInstruction('the life cycle of a frog', 'diagram');
        } else if (meetingId === 1117) {
            setInstruction('the life cycle of the silkworm and the stages in the production of silk cloth', 'diagrams');
        } else if (meetingId === 1118) {
            setInstruction('the water cycle, which is the continuous movement of water on, above and below the surface of the Earth', 'diagram');
        } else if (meetingId === 1119) {
            setInstruction('the process by which milk and related products are produced', 'diagram');
        } else if (meetingId === 1125) {
            setInstruction('the life cycle of sea turtles, from hatching through open ocean migration to adulthood and nesting', 'diagram');
        }
    }

        // Logic for Maps (1130-1139)
        if (meetingId >= 1130 && meetingId <= 1139) {
              if (meetingId === 1130) {
            setInstruction('Paradise Island in the past and at present', 'maps');
           } else if (meetingId === 1131) {
            setInstruction('Happy Valley Shopping Center in 1982 and 2012', 'maps');
           } else if (meetingId === 1132) {
            setInstruction('Felixstone in 1967 and 2001', 'maps');
           } else if (meetingId === 1133) {
            setInstruction('the coastal village of Seaville in 1980 and 2010', 'diagrams');
           } else if (meetingId === 1134) {
             setInstruction('the centre of a small town called Islip as it is now, and plans for its development', 'maps');
           } else if (meetingId === 1135) {
             setInstruction('the development of the village of Ryemouth between 1995 and present', 'maps');
           } else if (meetingId === 1136) {
             setInstruction('a science park in 2008 and the same park today', 'maps');
           } else if (meetingId === 1137) {
             setInstruction('the changes that have taken place in Meadowside village and Fonton, a neighbouring town, since 1962', 'maps');
           } else if (meetingId === 1138) {
             setInstruction('the layout of a university sports centre now, and how it will look after redevelopment', 'maps');
           } else if (meetingId === 1139) {
             setInstruction('a beachfront area in Australia in 1950 and today', 'maps');
        }
    }
});

document.addEventListener('alpine:init', () => {
    Alpine.data('practiceView', (meetingId, taskType, idioms = [], collocations = []) => ({
        // State
        essay: '', 
        time: 0,
        interval: null,
        loading: false,
        improving: false,
        error: null,
        showResults: false,
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
                 this.essay = saved;
            }
            
            this.$watch('essay', (val) => {
                 localStorage.setItem(key, val);
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
            if (savedPlan) {
                try {
                     const parsed = JSON.parse(savedPlan);
                     this.plan = { ...this.plan, ...parsed };
                     if (!this.plan.extras) this.plan.extras = []; 
                } catch(e) { console.error('Error loading plan', e); }
            }

            // Watch Plan
            this.$watch('plan', (val) => {
                localStorage.setItem(planKey, JSON.stringify(val));
            });

            // Initialize External AutoSave
            if (window.AutoSave) {
                window.AutoSave.init(meetingId, '{{ Auth::id() }}');
            }

            setTimeout(() => {
                // Sync Essay
                const textarea = document.querySelector('textarea[name="essay"]');
                if (textarea && textarea.value) {
                    this.essay = textarea.value;
                }
            }, 500);
            
            this.showEditModal = false; // Ensure modal is closed
            this.editForm.title = {!! json_encode($meeting->title) !!}; 
             // Pre-fill form data but don't show modal
            this.editForm.meeting_number = {{ $meeting->meeting_number }};
            this.editForm.prompt = {!! json_encode($meeting->prompt) !!};
        },
        
        // Admin Actions
        openEditModal() {
            this.showEditModal = true;
        },
        
        // Actions
        async submitEssay() {
             if (this.essay.trim().length < 50) {
                 alert('Please write at least 50 characters.');
                 return;
             }
             
             this.loading = true;
             this.error = null;
             this.showResults = true;
             // Keep previous results visible while loading new ones?? No, clear them to show spinners.
             this.result = { scores: {}, feedback: null, correction_html: null, better_version: null, grammar_improvements: [], cohesive_devices_used: [], good_vocabulary_used: [], vocabulary_improvements: [] }; 
             
             try {
                // 1. Evaluate Scores
                const response = await fetch('/assignments/ielts-academic/writing/evaluate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({ essay: this.essay, task_type: '{{ $meeting->task_type }}' })
                });
                
                if (!response.ok) {
                    let errorMsg = 'Evaluation failed. Server returned ' + response.status;
                    try {
                        const errorData = await response.json();
                        if (errorData.error) errorMsg = errorData.error;
                    } catch (e) {
                         console.warn('Could not parse error JSON', e);
                    }
                    throw new Error(errorMsg);
                }
                const data = await response.json();
                this.result.scores = data.scores || {};
                
                // 2. Parallel Fetch for Feedback & Correction & Improvement
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
                const response = await fetch('/assignments/ielts-academic/writing/feedback', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                    body: JSON.stringify({ essay: this.essay, task_type: '{{ $meeting->task_type }}' })
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
                    this.loading = false; // Stop loading spinner on submit button once feedback arrives
                }
             } catch (e) { console.error(e); }
        },

        async getCorrection() {
             try {
                const response = await fetch('/assignments/ielts-academic/writing/correct', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                    body: JSON.stringify({ essay: this.essay, task_type: '{{ $meeting->task_type }}' })
                });
                const data = await response.json();
                if (data.correction_html) this.result.correction_html = data.correction_html;
             } catch (e) { console.error(e); }
        },

        async improveEssay() {
             this.improving = true;
             try {
                const response = await fetch('/assignments/ielts-academic/writing/improve', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content },
                    body: JSON.stringify({ essay: this.essay, task_type: '{{ $meeting->task_type }}' })
                });
                const data = await response.json();
                if (data.better_version) this.result.better_version = data.better_version;
             } catch (e) { console.error(e); }
             finally { this.improving = false; }
        },

        // --- UPGRADE METHODS ---
        async upgradeTaskResponse() {
            this.loading = true;
            try {
                const response = await fetch('/assignments/ielts-academic/writing/task-response', {
                    method: 'POST', body: JSON.stringify({ essay: this.essay, task_type: '{{ $meeting->task_type }}' }),
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
                });
                const data = await response.json();
                if (data.task_response_improvements) this.result.task_response_improvements = data.task_response_improvements;
            } catch (e) { console.error(e); } finally { this.loading = false; }
        },
        async upgradeCoherence() {
            this.loading = true;
            try {
                const response = await fetch('/assignments/ielts-academic/writing/coherence', {
                    method: 'POST', body: JSON.stringify({ essay: this.essay, task_type: '{{ $meeting->task_type }}' }),
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
                });
                const data = await response.json();
                if (data.coherence_improvements) this.result.feedback.coherence_improvements = data.coherence_improvements;
            } catch (e) { console.error(e); } finally { this.loading = false; }
        },
        async upgradeLexical() {
            this.loading = true;
            try {
                const response = await fetch('/assignments/ielts-academic/writing/vocabulary', {
                    method: 'POST', body: JSON.stringify({ essay: this.essay, task_type: '{{ $meeting->task_type }}' }),
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
                });
                const data = await response.json();
                if (data.lexical_improvements) this.result.vocabulary_improvements = data.lexical_improvements;
                if (data.topic_vocabularies) this.result.collocations = data.topic_vocabularies;
            } catch (e) { console.error(e); } finally { this.loading = false; }
        },
        async upgradeGrammar() {
            this.loading = true;
            try {
                const response = await fetch('/assignments/ielts-academic/writing/grammar', {
                    method: 'POST', body: JSON.stringify({ essay: this.essay, task_type: '{{ $meeting->task_type }}' }),
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content }
                });
                const data = await response.json();
                if (data.grammar_improvements) this.result.grammar_improvements = data.grammar_improvements;
            } catch (e) { console.error(e); } finally { this.loading = false; }
        }
    }));
});
</script>
@endpush
@endsection
