@extends('layouts.admin')

@section('head')
    <script src="{{ asset('js/auto-save.js') }}?v={{ time() }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container mx-auto px-4 py-8 h-screen flex flex-col" x-data="labelingTrends({{ $meeting->id }})">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('assignments.ielts-academic.writing.index', ['task' => 1]) }}" class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                 <span class="text-sm font-semibold text-teal-600 tracking-wider uppercase">IELTS Writing Task 1</span>
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
    <div class="flex-1 overflow-y-auto pb-32">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left Column: Sticky Graph -->
                <div class="lg:col-span-7 sticky top-6">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-widest mb-4">Reference Graph</h3>
                        <div class="rounded-lg overflow-hidden border border-gray-100">
                            <img src="{{ asset('images/labeling_trends.png') }}" 
                                 alt="Radio Station Listeners Graph" 
                                 class="w-full h-auto object-contain">
                        </div>
                        <p class="mt-4 text-sm text-gray-500 italic">
                            Refer to this graph to answer the questions on the right.
                        </p>
                    </div>
                </div>

                <!-- Right Column: Questions & Essay -->
                <div class="lg:col-span-5 space-y-6">
                    
                    <!-- Instructions -->
                    <div class="bg-blue-50 rounded-xl p-6 border border-blue-100">
                        <p class="text-lg text-blue-900 font-medium">
                            {{ $meeting->prompt }}<br>
                            <span class="text-sm text-blue-600 font-normal mt-1 block">👇 Look at the graph on the left and write the correct year(s) for each trend description.</span>
                        </p>
                    </div>

                    <!-- Manual Input Grid -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-sm font-bold text-gray-500 uppercase tracking-widest">Match trends to years</h3>
                            <span class="px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-medium">14 Questions</span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <template x-for="item in labels" :key="item.id">
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 hover:border-teal-300 transition-colors">
                                    <label :for="'label_' + item.id" class="block mb-2 text-gray-800 font-medium text-sm">
                                        <span class="text-teal-600 font-bold mr-1" x-text="item.id + '.'"></span>
                                        <span x-text="item.text"></span>
                                    </label>
                                    <input type="text" 
                                           :id="'label_' + item.id"
                                           :name="'label_' + item.id"
                                           x-model="answers['label_' + item.id]"
                                           placeholder="e.g. 1960" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-shadow text-sm">
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Essay Section -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 flex items-center gap-2">
                            <span>✍️</span> Connecting Trends Description
                        </h3>
                        <textarea 
                            class="w-full h-64 p-4 rounded-xl border border-gray-200 focus:ring-2 focus:ring-teal-100 focus:border-teal-400 focus:outline-none transition-all resize-none text-base leading-relaxed bg-gray-50 from-gray-50 to-white" 
                            placeholder="Describe the changes shown in the graph and connect the trends..."
                            x-model="answers.essay"
                            name="essay"
                        ></textarea>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<!-- Alpine Data -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('labelingTrends', (meetingId) => ({
            answers: { essay: '' },
            loading: false,
            labels: [
                { id: 1, text: 'mild fluctuations' },
                { id: 2, text: 'a peak' },
                { id: 3, text: 'a period of instability' },
                { id: 4, text: 'a significant increase' },
                { id: 5, text: 'a partial growth' },
                { id: 6, text: 'a record high' },
                { id: 7, text: 'figures climbing back' },
                { id: 8, text: 'a marked rise' },
                { id: 9, text: 'a dramatic decrease' },
                { id: 10, text: 'a period of slight volatility' },
                { id: 11, text: 'a leveling out' },
                { id: 12, text: 'a sharp decline' },
                { id: 13, text: 'a plateau' },
                { id: 14, text: 'figures remaining constant' }
            ],

            init() {
                if (window.AutoSave) {
                    window.AutoSave.init(meetingId, '{{ Auth::id() }}');
                }
                
                // Sync restored values to Alpine data
                setTimeout(() => {
                    // Sync labels
                    const inputs = document.querySelectorAll('input[name^="label_"]');
                    inputs.forEach(el => {
                        if(el.value) {
                             const key = el.name; // matches x-model key
                             this.answers[key] = el.value;
                        }
                    });
                    // Sync essay
                    const essay = document.querySelector('textarea[name="essay"]');
                    if(essay && essay.value) {
                        this.answers.essay = essay.value;
                    }
                }, 500);
            },

            submit() {
                this.loading = true;
                const key = 'labeling_trends_autosave_v3_' + meetingId;
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
