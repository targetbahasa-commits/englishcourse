@extends('layouts.admin')

@section('head')
    <script src="{{ asset('js/auto-save.js') }}?v={{ time() }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container mx-auto px-4 py-8 h-screen flex flex-col" x-data="connectingTrend({{ $meeting->id }})">
    <form method="POST" action="#" id="connectingTrendForm">
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
                <span>Submit</span>
             </button>
        </div>
    </div>

    <!-- Content Wrapper -->
    <div class="flex-1 overflow-y-auto pb-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="space-y-8">
            <!-- Answer Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <template x-for="item in items" :key="item.id">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-300 flex flex-col h-full card-hover relative overflow-hidden">
                        
                        <!-- Badge -->
                        <div class="absolute top-0 right-0 bg-teal-600 text-white text-xs font-bold px-3 py-1 rounded-bl-lg shadow-sm z-10" x-text="'Graph ' + item.id"></div>

                        <!-- Graph Image Slice -->
                        <div class="w-full bg-no-repeat border-b border-gray-100"
                             :style="`
                                width: 100%;
                                padding-bottom: 100%;
                                height: 0;
                                background-image: url('{{ asset('images/connecting_trend.png') }}');
                                background-position: ${item.x * 50}% ${item.y * 100}%;
                                background-size: 300% 200%;
                            `">
                        </div>

                        <div class="p-3 flex-1 flex flex-col">
                            <textarea 
                                class="w-full h-20 p-2.5 rounded-lg border border-gray-200 focus:ring-2 focus:ring-teal-100 focus:border-teal-400 focus:outline-none transition-all resize-none text-sm leading-relaxed" 
                                :placeholder="'Describe trend ' + item.id + '...'"
                                x-model="answers[item.id]"
                                :name="'answer_' + item.id"
                            ></textarea>
                        </div>
                    </div>
                </template>
            </div>
        </div>
            </div>
            </form>
        </div>
    </div>
</div>
</div>

<!-- Alpine Data for the page -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('connectingTrend', (meetingId) => ({
            answers: {},
            loading: false,
            items: [
                { id: 'A', x: 0, y: 0 },
                { id: 'B', x: 1, y: 0 },
                { id: 'C', x: 2, y: 0 },
                { id: 'D', x: 0, y: 1 },
                { id: 'E', x: 1, y: 1 },
                { id: 'F', x: 2, y: 1 },
            ],
            init() {
                // Initialize External AutoSave
                if (window.AutoSave) {
                    window.AutoSave.init(meetingId, '{{ Auth::id() }}');
                }

                // Restore from AutoSave (optional overlap, but AutoSave handles restoration)
                // However, we need to sync x-model 'answers' with the restored DOM values if AutoSave runs first.
                // Actually AutoSave updates DOM values. Alpine might overwrite them if 'answers' is empty.
                // Let's rely on AutoSave restoring to input, then syncing back to x-model? 
                // Or better: Let AutoSave handle it, and we update 'answers' from DOM after valid restore?
                setTimeout(() => {
                    this.items.forEach(item => {
                        const el = document.querySelector(`[name="answer_${item.id}"]`);
                        if(el && el.value) {
                             this.answers[item.id] = el.value;
                        }
                    });
                }, 500);
            },
            submit() {
                this.loading = true;
                const key = 'connecting_trend_autosave_' + meetingId;
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
