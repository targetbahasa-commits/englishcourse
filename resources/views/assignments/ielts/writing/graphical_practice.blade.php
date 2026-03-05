@extends('layouts.admin')

@section('head')
    <script src="{{ asset('js/auto-save.js') }}?v={{ time() }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container mx-auto px-4 py-8 h-screen flex flex-col">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('assignments.ielts-academic.writing.index', ['task' => $task]) }}" class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                 <span class="text-sm font-semibold text-teal-600 tracking-wider uppercase">IELTS Writing Task {{ $task }}</span>
                <h1 class="text-2xl font-bold text-gray-800">{{ $meeting->title }}</h1>
            </div>
        </div>

        <div class="flex gap-4 items-center">
             <button type="button" @click.prevent="submit()" :disabled="loading" class="px-6 py-2 bg-orange-600 text-white font-bold rounded-lg shadow-md hover:bg-orange-700 transition-colors flex items-center gap-2">
                <span>Submit Essay</span>
             </button>
        </div>
    </div>

    <!-- Content Wrapper -->
    <div class="flex-1 overflow-y-auto pb-8" x-data="graphicalPractice({{ $meeting->id }})">
        <div class="max-w-6xl mx-auto w-full space-y-8">
            
            <!-- Questions Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Using Alpine Loop for Graph A-L -->
                <template x-for="item in [
                    { id: 'A', title: 'Graph A (Car sales in \'000)', x: 0, y: 0 },
                    { id: 'B', title: 'Graph B (Car sales)', x: 1, y: 0 },
                    { id: 'C', title: 'Graph C (Car sales)', x: 2, y: 0 },
                    { id: 'D', title: 'Graph D (Net users in \'000)', x: 0, y: 1 },
                    { id: 'E', title: 'Graph E (Net users)', x: 1, y: 1 },
                    { id: 'F', title: 'Graph F (Net users)', x: 2, y: 1 },
                    { id: 'G', title: 'Graph G (Cases of polio in \'000)', x: 0, y: 2 },
                    { id: 'H', title: 'Graph H (Cases of polio)', x: 1, y: 2 },
                    { id: 'I', title: 'Graph I (Cases of polio)', x: 2, y: 2 },
                    { id: 'J', title: 'Graph J (Radio listeners in \'000)', x: 0, y: 3 },
                    { id: 'K', title: 'Graph K (Radio listeners)', x: 1, y: 3 },
                    { id: 'L', title: 'Graph L (Radio listeners)', x: 2, y: 3 }
                ]" :key="item.id">
                    
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
                        <!-- Graph Image Slice -->
                        <div class="relative w-full bg-gray-50 border-b border-gray-100 overflow-hidden group" style="aspect-ratio: 276/256;">
                           <div class="absolute inset-0 bg-no-repeat bg-cover transform transition-transform duration-500 group-hover:scale-110"
                                :style="`
                                    background-image: url('{{ asset('assets/images/ielts/graphs_composite.png') }}');
                                    background-position: ${item.x * 50}% ${item.y * 33.33}%;
                                    background-size: 300% 400%;
                                `">
                           </div>
                           <div class="absolute top-2 left-2 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-xs font-bold text-gray-700 shadow-sm" x-text="item.title"></div>
                        </div>

                        <!-- Answer Box -->
                        <div class="p-4 flex-1 flex flex-col">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Describe the trend in one sentence:</label>
                            <textarea 
                                class="w-full h-24 p-3 rounded-lg border border-gray-200 focus:ring-2 focus:ring-teal-100 focus:border-teal-400 focus:outline-none transition-all resize-none text-sm leading-relaxed" 
                                :placeholder="'Type your answer for ' + item.id + '...'"
                                x-model="answers[item.id]"
                                :name="'answer_' + item.id"
                            ></textarea>
                            
                            <div class="mt-2 flex justify-between items-center text-xs text-gray-400">
                                <span>Write clearly and concisely.</span>
                            </div>
                        </div>
                    </div>

                </template>
            </div>



        </div>
    </div>
</div>
<!-- Alpine Data for the page -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('graphicalPractice', (meetingId) => ({
            answers: {},
            loading: false,
            init() {
                if (window.AutoSave) {
                    window.AutoSave.init(meetingId, '{{ Auth::id() }}');
                }
                
                // Sync restored values to Alpine data
                setTimeout(() => {
                    const textareas = document.querySelectorAll('textarea[name^="answer_"]');
                    textareas.forEach(el => {
                        if (el.value) {
                            const id = el.name.replace('answer_', '');
                            this.answers[id] = el.value;
                        }
                    });
                }, 500);
            },
            submit() {
                this.loading = true;
                const key = 'graphical_autosave_' + meetingId;
                localStorage.setItem(key, JSON.stringify(this.answers));
                
                setTimeout(() => {
                    this.loading = false;
                    alert('Practice saved successfully!');
                }, 1000);
            }
        }))
    })
</script>
@include('assignments.ielts.writing.practice_toolbar')
@endsection
