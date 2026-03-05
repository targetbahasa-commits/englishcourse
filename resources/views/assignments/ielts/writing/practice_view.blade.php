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
                @if((isset($meeting) && $meeting->id == 45) || ($meeting->meeting_number >= 1010 && $meeting->meeting_number <= 1019))
                    <a href="{{ route('assignments.ielts-academic.writing.meeting', ['task' => 1, 'id' => 9]) }}" class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors shrink-0">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                @elseif((isset($meeting) && $meeting->id == 54) || ($meeting->meeting_number >= 1020 && $meeting->meeting_number <= 1029))
                    <a href="{{ route('assignments.ielts-academic.writing.meeting', ['task' => 1, 'id' => 10]) }}" class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors shrink-0">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                @elseif((isset($meeting) && $meeting->id == 64) || ($meeting->meeting_number >= 1030 && $meeting->meeting_number <= 1039))
                    <a href="{{ route('assignments.ielts-academic.writing.meeting', ['task' => 1, 'id' => 11]) }}" class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors shrink-0">
                        <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                @elseif((isset($meeting) && $meeting->id == 74) || ($meeting->meeting_number >= 1040 && $meeting->meeting_number <= 1049))
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
                @if($meeting->meeting_number >= 1010 && $meeting->meeting_number <= 1019)
                    <!-- Line Chart -->
                    <div class="relative h-[800px] w-full min-w-[300px]" style="height: 800px;">
                        <canvas id="practiceLineChart"></canvas>
                    </div>
                @elseif($meeting->meeting_number >= 1020 && $meeting->meeting_number <= 1029)
                    <!-- Bar Chart -->
                    <div class="relative h-[800px] w-full min-w-[300px]" style="height: 800px;">
                        <canvas id="practiceBarChart"></canvas>
                    </div>
                @elseif($meeting->meeting_number >= 1030 && $meeting->meeting_number <= 1039)
                    <!-- Pie Chart -->
                    <div class="relative h-[800px] w-full flex justify-center min-w-[300px]" style="height: 800px;">
                        <canvas id="practicePieChart"></canvas>
                    </div>
                @elseif($meeting->meeting_number >= 1040 && $meeting->meeting_number <= 1049)
                    <!-- Table -->
                    <div id="practiceTableContainer" class="overflow-x-auto rounded-xl shadow-lg border border-gray-100 hidden">
                        <!-- Table will be injected here by JS -->
                    </div>
                @elseif($meeting->meeting_number >= 1050 && $meeting->meeting_number <= 1059)
                    <!-- Mixed -->
                    <div id="practiceMixedContainer" class="w-full flex flex-col gap-8 justify-center items-center h-auto min-h-[600px] p-4">
                        <!-- Canvases injected by JS -->
                    </div>
                @elseif($meeting->meeting_number >= 1060 && $meeting->meeting_number <= 1069)
                    <!-- Flow Chart -->
                    <!-- Flow Chart -->
                    <div class="flex justify-center items-center py-4">
                        @if($meeting->meeting_number == 1060)
                             <img src="{{ asset('images/practice/cement_production.png') }}" alt="Cement and Concrete Production Process" class="max-w-full h-auto rounded-lg shadow-sm border border-gray-200">
                        @elseif($meeting->meeting_number == 1061)
                             <img src="{{ asset('images/practice/coconut_oil_production.png') }}" alt="Coconut Oil Manufacturing Process" class="max-w-full h-auto rounded-lg shadow-sm border border-gray-200">
                        @elseif($meeting->meeting_number == 1062)
                             <img src="{{ asset('images/practice/glass_container_production.png') }}" alt="Glass Container Production Process" class="max-w-full h-auto rounded-lg shadow-sm border border-gray-200">
                        @elseif($meeting->meeting_number == 1063)
                             <img src="{{ asset('images/practice/sheep_cloning_process.png') }}" alt="Sheep Embryo Cloning Process" class="max-w-full h-auto rounded-lg shadow-sm border border-gray-200">
                        @elseif($meeting->meeting_number == 1064)
                             <img src="{{ asset('images/practice/water_treatment_process.jpg') }}" alt="Water Treatment Process" class="max-w-full h-auto rounded-lg shadow-sm border border-gray-200">
                        @elseif($meeting->meeting_number == 1065)
                             <img src="{{ asset('images/practice/hydroelectric_power_process.png') }}" alt="Hydroelectric Power Generation Process" class="max-w-full h-auto rounded-lg shadow-sm border border-gray-200">
                        @elseif($meeting->meeting_number == 1066)
                             <img src="{{ asset('images/practice/frog_life_cycle.png') }}" alt="Life Cycle of a Frog" class="max-w-full h-auto rounded-lg shadow-sm border border-gray-200">
                        @elseif($meeting->meeting_number == 1067)
                             <img src="{{ asset('images/practice/silkworm_life_cycle.png') }}" alt="Life Cycle of the Silkworm" class="max-w-full h-auto rounded-lg shadow-sm border border-gray-200">
                        @elseif($meeting->meeting_number == 1068)
                             <img src="{{ asset('images/practice/water_cycle.png') }}" alt="Water Cycle" class="max-w-full h-auto rounded-lg shadow-sm border border-gray-200">
                        @elseif($meeting->meeting_number == 1069)
                             <img src="{{ asset('images/practice/milk_production.png') }}" alt="Milk Production Process" class="max-w-full h-auto rounded-lg shadow-sm border border-gray-200">
                        @else 
                             <!-- Fallback/Placeholder -->
                            <div class="text-center p-8 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                                <p class="text-gray-500">Flow Chart Diagram not available for this meeting.</p>
                            </div>
                        @endif
                    </div>
                @elseif($meeting->meeting_number >= 1070 && $meeting->meeting_number <= 1079)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                        @php
                            $imageUrl = null;
                            if($meeting->image) {
                                $imageUrl = asset($meeting->image);
                            } else {
                                // Fallback to hardcoded paths
                                $mapImages = [
                                    1070 => 'images/practice/paradise_island.png',
                                    1071 => 'images/practice/happy_valley_shopping_center.png',
                                    1072 => 'images/practice/felixstone.png',
                                    1073 => 'images/practice/seaville.png',
                                    1074 => 'images/practice/islip_town_centre.png',
                                    1075 => 'images/practice/ryemouth_village.png',
                                    1076 => 'images/practice/science_park.png',
                                    1077 => 'images/practice/meadowside_fonton.png',
                                    1078 => 'images/practice/university_sports_centre.png',
                                    1079 => 'images/practice/beachfront_area.png',
                                ];
                                if(isset($mapImages[$meeting->meeting_number])) {
                                    $imageUrl = asset($mapImages[$meeting->meeting_number]);
                                }
                            }
                        @endphp

                        @if($imageUrl)
                            <img src="{{ $imageUrl }}" alt="{{ $meeting->title }} Map" class="max-w-full h-auto rounded-lg shadow-sm border border-gray-200">
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
        <div class="min-w-0 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden h-full flex flex-col">
            
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
                            Refresh
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
                        <div x-show="result?.task_response_improvements" class="space-y-4">
                            <template x-for="(item, idx) in result?.task_response_improvements" :key="idx">
                                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                                    <div class="flex items-start gap-4">
                                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-bold text-sm">!</div>
                                        <div class="flex-1">
                                            <p class="text-red-800 font-medium mb-2 border-l-4 border-red-200 pl-3 italic text-sm" x-text="item.text"></p>
                                            <div class="flex items-center gap-2 mb-2">
                                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                                <span class="font-bold text-green-700" x-text="item.improved"></span>
                                            </div>
                                            <p class="text-gray-500 text-xs" x-text="item.explanation"></p>
                                        </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- COHERENCE TAB -->
                    <div x-show="activeTab === 'coherence'" class="max-w-3xl mx-auto space-y-6">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <strong class="block text-xs uppercase text-indigo-500 font-bold mb-3 tracking-wider">Coherence & Cohesion Detailed Feedback</strong>
                            <p x-show="!result?.feedback" class="text-gray-400 italic animate-pulse">Generating...</p>
                            <p x-text="result?.feedback?.coherence_cohesion" class="text-gray-700 leading-relaxed"></p>
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
                        <div x-show="result?.feedback?.coherence_improvements?.length > 0" class="space-y-3">
                             <template x-for="(item, idx) in result?.feedback?.coherence_improvements" :key="idx">
                                <div class="bg-white p-3 rounded-lg border border-gray-100 flex items-center justify-between gap-4">
                                     <div class="flex items-center gap-2">
                                        <span class="text-red-400 line-through text-sm" x-text="item.text"></span>
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                        <span class="text-green-600 font-bold text-sm bg-green-50 px-2 py-1 rounded" x-text="item.improved"></span>
                                    </div>
                                    <span class="text-xs text-gray-400 italic" x-text="item.explanation"></span>
                                </div>
                             </template>
                        </div>
                    </div>

                    <!-- LEXICAL TAB -->
                    <div x-show="activeTab === 'lexical'" class="max-w-3xl mx-auto space-y-6">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                            <strong class="block text-xs uppercase text-indigo-500 font-bold mb-3 tracking-wider">Lexical Resource Detailed Feedback</strong>
                            <p x-show="!result?.feedback" class="text-gray-400 italic animate-pulse">Generating...</p>
                            <p x-text="result?.feedback?.lexical_resource" class="text-gray-700 leading-relaxed"></p>
                        </div>
                        
                        <!-- Upgrade Action -->
                        <div class="bg-indigo-50 p-6 rounded-xl border border-indigo-100 flex flex-col items-center justify-center text-center gap-4">
                            <h4 class="font-bold text-indigo-800">Learn Band 9 Vocabulary?</h4>
                             <button @click="upgradeLexical()" :disabled="loading" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg shadow-sm transition-all transform hover:scale-105 flex items-center gap-2">
                                <svg x-show="!loading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                <span x-show="loading" class="animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full"></span>
                                <span>Analyze & Upgrade Vocabulary (Band 7-9)</span>
                            </button>
                        </div>

                         <!-- Upgrade Results -->
                         <div x-show="result?.vocabulary_improvements?.length > 0" class="space-y-4">
                             <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <template x-for="(item, idx) in result?.vocabulary_improvements" :key="idx">
                                    <div class="bg-white p-3 rounded-lg border border-gray-100 text-sm">
                                        <div class="flex justify-between items-center mb-1">
                                            <span class="text-red-400 line-through" x-text="item.text"></span>
                                            <span class="text-green-600 font-bold" x-text="item.improved"></span>
                                        </div>
                                        <p class="text-xs text-gray-500" x-text="item.explanation"></p>
                                    </div>
                                </template>
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
                        <div class="bg-purple-50 p-6 rounded-xl border border-purple-100 flex flex-col items-center justify-center text-center gap-4">
                            <h4 class="font-bold text-purple-800">Master Complex Structures?</h4>
                             <button @click="upgradeGrammar()" :disabled="loading" class="px-6 py-2.5 bg-purple-600 hover:bg-purple-700 text-white font-bold rounded-lg shadow-sm transition-all transform hover:scale-105 flex items-center gap-2">
                                <svg x-show="!loading" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                                <span x-show="loading" class="animate-spin h-5 w-5 border-2 border-white border-t-transparent rounded-full"></span>
                                <span>Analyze & Upgrade Grammar (Band 7-9)</span>
                            </button>
                        </div>

                        <!-- Upgrade Results -->
                         <div x-show="result?.grammar_improvements?.length > 0" class="space-y-4">
                             <template x-for="(item, idx) in result?.grammar_improvements" :key="idx">
                                <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                                    <div class="flex items-start gap-3">
                                        <div class="flex-shrink-0 w-8 h-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center font-bold text-sm" x-text="idx + 1"></div>
                                        <div>
                                            <p class="text-red-800 line-through decoration-red-300 text-sm mb-1" x-text="item.text"></p>
                                            <p class="text-green-700 font-bold mb-1" x-text="item.improved"></p>
                                            <p class="text-gray-500 text-xs italic" x-text="item.explanation"></p>
                                        </div>
                                    </div>
                                </div>
                             </template>
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
        ]
    };

    // --- Line Chart Data Configs ---
    const lineConfigs = {
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
        }
    };

    // --- Bar Chart Data Configs ---
    const barConfigs = {
        1020: { // Trade Volume (Original)
            title: 'Trade Volume (Billion USD)',
            labels: ['USA', 'China', 'India', 'Russia', 'Japan'],
            datasets: [
                { label: 'Export', data: [500, 700, 300, 400, 450], backgroundColor: 'rgba(59, 130, 246, 0.8)', borderColor: '#2563eb', borderWidth: 2 },
                { label: 'Import', data: [800, 600, 400, 200, 500], backgroundColor: 'rgba(239, 68, 68, 0.8)', borderColor: '#dc2626', borderWidth: 2 }
            ]
        },
        1021: { // Graduate Employment
            title: 'Graduate Employment Rates by Field (%)',
            labels: ['Science', 'Engineering', 'Arts', 'Business', 'Law'],
            datasets: [
                { label: '2010', data: [85, 92, 70, 78, 88], backgroundColor: 'rgba(59, 130, 246, 0.8)', borderColor: '#2563eb', borderWidth: 2 },
                { label: '2020', data: [90, 95, 65, 75, 82], backgroundColor: 'rgba(239, 68, 68, 0.8)', borderColor: '#dc2626', borderWidth: 2 }
            ]
        },
        1022: { // Tourism
            title: 'Annual Tourist Arrivals (Millions)',
            labels: ['France', 'USA', 'Spain', 'China', 'Italy'],
            datasets: [
                { label: '2018', data: [89, 79, 83, 63, 62], backgroundColor: 'rgba(59, 130, 246, 0.8)', borderColor: '#2563eb', borderWidth: 2 },
                { label: '2019', data: [91, 80, 84, 66, 65], backgroundColor: 'rgba(239, 68, 68, 0.8)', borderColor: '#dc2626', borderWidth: 2 }
            ]
        },
        1023: { // Screen Time
            title: 'Average Daily Screen Time (Hours)',
            labels: ['Teens', 'Young Adults', 'Adults', 'Seniors'],
            datasets: [
                { label: 'Mobile', data: [4.5, 5.0, 3.5, 1.5], backgroundColor: 'rgba(59, 130, 246, 0.8)', borderColor: '#2563eb', borderWidth: 2 },
                { label: 'Desktop', data: [2.0, 3.5, 4.0, 2.0], backgroundColor: 'rgba(239, 68, 68, 0.8)', borderColor: '#dc2626', borderWidth: 2 }
            ]
        },
        1024: { // Renewable Energy
            title: 'Renewable Energy Capacity (GW)',
            labels: ['Wind', 'Solar', 'Hydro', 'Biomass'],
            datasets: [
                { label: '2015', data: [433, 227, 1064, 106], backgroundColor: 'rgba(59, 130, 246, 0.8)', borderColor: '#2563eb', borderWidth: 2 },
                { label: '2020', data: [733, 714, 1154, 127], backgroundColor: 'rgba(239, 68, 68, 0.8)', borderColor: '#dc2626', borderWidth: 2 },
                { label: '2025 (Projected)', data: [1100, 1200, 1300, 150], backgroundColor: 'rgba(16, 185, 129, 0.8)', borderColor: '#059669', borderWidth: 2 }
            ]
        },
        1025: { // Gender Pay Gap
            title: 'Average Hourly Earnings ($)',
            labels: ['Healthcare', 'Education', 'Finance', 'Tech', 'Construction'],
            datasets: [
                { label: 'Men', data: [35, 30, 45, 50, 28], backgroundColor: 'rgba(59, 130, 246, 0.8)', borderColor: '#2563eb', borderWidth: 2 },
                { label: 'Women', data: [32, 29, 38, 42, 26], backgroundColor: 'rgba(239, 68, 68, 0.8)', borderColor: '#dc2626', borderWidth: 2 },
                { label: 'Industry Avg', data: [33.5, 29.5, 41.5, 46, 27], backgroundColor: 'rgba(245, 158, 11, 0.8)', borderColor: '#d97706', borderWidth: 2 }
            ]
        },
        1026: { // Household Waste
            title: 'Weekly Household Waste (kg)',
            labels: ['Paper', 'Plastic', 'Glass', 'Metal', 'Organic'],
            datasets: [
                { label: 'Recycled', data: [5, 3, 2, 1, 8], backgroundColor: 'rgba(16, 185, 129, 0.8)', borderColor: '#059669', borderWidth: 2 },
                { label: 'Landfill', data: [1, 4, 0.5, 0.2, 2], backgroundColor: 'rgba(75, 85, 99, 0.8)', borderColor: '#374151', borderWidth: 2 },
                { label: 'Compost', data: [4, 0.5, 0.1, 0, 7], backgroundColor: 'rgba(245, 158, 11, 0.8)', borderColor: '#d97706', borderWidth: 2 }
            ]
        },
        1027: { // Transportation Mode
            title: 'Commuting Method to Work (%)',
            labels: ['Car', 'Bus', 'Train', 'Bike', 'Walk'],
            datasets: [
                { label: 'City A', data: [45, 25, 20, 5, 5], backgroundColor: 'rgba(59, 130, 246, 0.8)', borderColor: '#2563eb', borderWidth: 2 },
                { label: 'City B', data: [30, 30, 25, 10, 5], backgroundColor: 'rgba(245, 158, 11, 0.8)', borderColor: '#d97706', borderWidth: 2 },
                { label: 'City C', data: [15, 35, 35, 10, 5], backgroundColor: 'rgba(16, 185, 129, 0.8)', borderColor: '#059669', borderWidth: 2 },
                { label: 'City D', data: [10, 20, 40, 20, 10], backgroundColor: 'rgba(139, 92, 246, 0.8)', borderColor: '#7c3aed', borderWidth: 2 }
            ]
        },
        1028: { // Housing Types
            title: 'Housing Preferences by Age Group (%)',
            labels: ['Young Adults', 'Families', 'Retirees'],
            datasets: [
                { label: 'Apartment', data: [60, 10, 20], backgroundColor: 'rgba(59, 130, 246, 0.8)', borderColor: '#2563eb', borderWidth: 2 },
                { label: 'House', data: [10, 70, 40], backgroundColor: 'rgba(239, 68, 68, 0.8)', borderColor: '#dc2626', borderWidth: 2 },
                { label: 'Condo', data: [20, 10, 30], backgroundColor: 'rgba(16, 185, 129, 0.8)', borderColor: '#059669', borderWidth: 2 },
                { label: 'Townhouse', data: [10, 10, 10], backgroundColor: 'rgba(245, 158, 11, 0.8)', borderColor: '#d97706', borderWidth: 2 }
            ]
        },
        1029: { // Olympic Medals
            title: 'Olympic Medals Won (Top 5 Countries)',
            labels: ['USA', 'China', 'Japan', 'GB', 'ROC'],
            datasets: [
                { label: 'Gold', data: [39, 38, 27, 22, 20], backgroundColor: '#eab308', borderColor: '#ca8a04', borderWidth: 2 },
                { label: 'Silver', data: [41, 32, 14, 21, 28], backgroundColor: '#94a3b8', borderColor: '#475569', borderWidth: 2 },
                { label: 'Bronze', data: [33, 18, 17, 22, 23], backgroundColor: '#b45309', borderColor: '#78350f', borderWidth: 2 },
                { label: 'Total', data: [113, 88, 58, 65, 71], backgroundColor: '#3b82f6', borderColor: '#2563eb', borderWidth: 2 }
            ]
        }
    };

    // --- Pie Chart Data Configs ---
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
        }
    };
    
    // Logic to render specific table based on ID existing in DOM
    const tableContainer = document.getElementById('practiceTableContainer');
    if (tableContainer) {
        const config = tableConfigs[meetingId] || tableConfigs[1040];
        setInstruction(config.title || 'Table Data', 'table');
        
        let html = `
            <table class="min-w-full text-base text-center text-gray-800 whitespace-nowrap">
                <thead class="bg-gradient-to-r from-blue-600 to-indigo-600 font-extrabold uppercase text-white tracking-wider shadow-md">
                    <tr>`;
        
        config.headers.forEach(header => {
            html += `<th class="px-4 py-3 text-lg">${header}</th>`;
        });
        
        html += `   </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 font-bold">`;
                
        config.rows.forEach((row, rowIndex) => {
            const rowClass = rowIndex % 2 === 0 ? 'row-indigo' : 'row-fuchsia';
            html += `<tr class="${rowClass} row-hover-yellow transition-colors duration-150">`;
            row.forEach((cell, index) => {
                let cellContent = cell;
                if (config.badges && config.badges[index] && config.badges[index][cell]) {
                    const color = config.badges[index][cell];
                    const bgClass = color === 'red' ? 'bg-red-100 text-red-800' :
                                    color === 'orange' ? 'bg-orange-100 text-orange-800' :
                                    color === 'yellow' ? 'bg-yellow-100 text-yellow-800' :
                                    color === 'green' ? 'bg-green-100 text-green-800' :
                                    color === 'blue' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800';
                    cellContent = `<span class="px-3 py-1.5 ${bgClass} rounded-full text-sm font-extrabold">${cell}</span>`;
                }
                
                const alignClass = index === 0 ? 'text-left text-indigo-700' : '';
                html += `<td class="px-4 py-3 text-lg ${alignClass}">${cellContent}</td>`;
            });

            html += `</tr>`;
        });
        
        html += `   </tbody>
            </table>`;
            
        tableContainer.innerHTML = html;
        tableContainer.classList.remove('hidden');
    }





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
        const config = barConfigs[meetingId] || barConfigs[1020];
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

    const pieCanvas = document.getElementById('practicePieChart');
    if (pieCanvas) {
        // Fallback to 1030 if config not found
        const config = pieConfigs[meetingId] || pieConfigs[1030];
        setInstruction(config.title, 'chart');

        new Chart(pieCanvas.getContext('2d'), {
            type: 'pie',
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
        const configs = mixedConfigs[meetingId] || mixedConfigs[1050]; // Now an array of chart objects
        
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

                new Chart(canvas.getContext('2d'), {
                    type: config.type || 'bar',
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

    // Logic for Flow Chart (1060-1069)
    if (meetingId >= 1060 && meetingId <= 1069) {
        if (meetingId === 1060) {
            setInstruction('the stages and equipment used in the cement-making process, and how cement is used to produce concrete for building purposes', 'diagram');
        } else if (meetingId === 1061) {
            setInstruction('the mass manufacturing of coconut oil', 'process diagram');
        } else if (meetingId === 1062) {
            setInstruction('how glass containers are made. The steps of the process are numbered 1 to 9', 'process diagram');
        } else if (meetingId === 1063) {
            setInstruction('the process by which sheep embryos are cloned', 'diagram');
        } else if (meetingId === 1064) {
            setInstruction('the process of the water treatment', 'diagram');
        } else if (meetingId === 1065) {
            setInstruction('the process by which electricity is generated in two types of hydroelectric power station', 'diagram');
        } else if (meetingId === 1066) {
            setInstruction('the life cycle of a frog', 'diagram');
        } else if (meetingId === 1067) {
            setInstruction('the life cycle of the silkworm and the stages in the production of silk cloth', 'diagrams');
        } else if (meetingId === 1068) {
            setInstruction('the water cycle, which is the continuous movement of water on, above and below the surface of the Earth', 'diagram');
        } else if (meetingId === 1069) {
            setInstruction('the process by which milk and related products are produced', 'diagram');
        }
    }

    // Logic for Maps (1070-1079)
    if (meetingId >= 1070 && meetingId <= 1079) {
            if (meetingId === 1070) {
            setInstruction('Paradise Island in the past and at present', 'maps');
        } else if (meetingId === 1071) {
            setInstruction('Happy Valley Shopping Center in 1982 and 2012', 'maps');
        } else if (meetingId === 1072) {
            setInstruction('Felixstone in 1967 and 2001', 'maps');
        } else if (meetingId === 1073) {
            setInstruction('the coastal village of Seaville in 1980 and 2010', 'diagrams');
        } else if (meetingId === 1074) {
             setInstruction('the centre of a small town called Islip as it is now, and plans for its development', 'maps');
        } else if (meetingId === 1075) {
             setInstruction('the development of the village of Ryemouth between 1995 and present', 'maps');
        } else if (meetingId === 1076) {
             setInstruction('a science park in 2008 and the same park today', 'maps');
        } else if (meetingId === 1077) {
             setInstruction('the changes that have taken place in Meadowside village and Fonton, a neighbouring town, since 1962', 'maps');
        } else if (meetingId === 1078) {
             setInstruction('the layout of a university sports centre now, and how it will look after redevelopment', 'maps');
        } else if (meetingId === 1079) {
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
            better_version: null
        },
        
        // Computed
        get wordCount() {
            return this.essay.trim() === '' ? 0 : this.essay.trim().split(/\s+/).length;
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
            if (confirm('Are you sure you want to clear your answer? This cannot be undone.')) {
                this.essay = '';
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
             this.result = { scores: {}, feedback: null, correction_html: null, better_version: null }; 
             
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
