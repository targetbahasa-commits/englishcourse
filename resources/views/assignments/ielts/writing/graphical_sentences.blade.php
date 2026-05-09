@extends('layouts.admin')

@section('head')
    <script src="{{ asset('js/auto-save.js') }}?v={{ time() }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="w-full max-w-[1920px] mx-auto px-6 py-8 flex flex-col min-h-screen" x-data="graphicalSentences({{ $meeting->id }})">
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
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start pb-32 w-full">
        <!-- Left Column: Reference (Sticky) -->
        <div class="lg:col-span-5 sticky top-6 self-start space-y-6 max-h-[calc(100vh-2rem)] overflow-y-auto pr-2 custom-scrollbar">
            
            <!-- Theory Box 1: What are Graphical Sentences? -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-teal-50 px-6 py-4 border-b border-teal-100">
                    <h2 class="text-lg font-bold text-teal-900">Apa itu Kalimat Grafis?</h2>
                </div>
                <div class="p-6 text-gray-700 space-y-4 text-sm leading-relaxed">
                    <p>
                        <strong>Kalimat grafis</strong> adalah satu kalimat yang menjelaskan tren utama, pola, atau fitur penting yang ditampilkan pada grafik, bagan, diagram, atau peta.
                    </p>
                    <p>
                        Dalam IELTS Writing Task 1, kamu perlu menulis:
                    </p>
                    <ul class="list-disc list-inside space-y-2">
                        <li><strong>Kalimat overview</strong> di awal (merangkum tren secara umum)</li>
                        <li><strong>Kalimat deskriptif</strong> pada paragraf isi (menjelaskan data secara lebih spesifik)</li>
                    </ul>
                    <p class="bg-blue-50 p-3 rounded border border-blue-100 text-blue-900 italic">
                        Kalimat grafis yang baik harus jelas, ringkas, dan menggunakan kosakata yang tepat untuk menjelaskan tren serta perubahan.
                    </p>
                </div>
            </div>

            <!-- Theory Box 2: Basic Structure -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-teal-50 px-6 py-4 border-b border-teal-100">
                    <h2 class="text-lg font-bold text-teal-900">Struktur Kalimat Dasar</h2>
                </div>
                <div class="p-6 text-gray-700 space-y-3 text-sm leading-relaxed">
                    <div class="bg-indigo-50 p-3 rounded border border-indigo-100">
                        <p class="font-bold text-indigo-900 mb-2">Subjek + Kata Kerja + Preposisi/Objek</p>
                        <p class="text-indigo-800">The unemployment rate <strong>rose</strong> <strong>from</strong> 5% <strong>to</strong> 10%.</p>
                    </div>
                    
                    <div class="bg-green-50 p-3 rounded border border-green-100">
                        <p class="font-bold text-green-900 mb-2">Subjek + Kata Kerja + Objek + Frasa Preposisional</p>
                        <p class="text-green-800">Cell phone usage increased significantly <strong>between 2000 and 2010</strong>.</p>
                    </div>

                    <div class="bg-orange-50 p-3 rounded border border-orange-100">
                        <p class="font-bold text-orange-900 mb-2">Struktur There + Kata Kerja</p>
                        <p class="text-orange-800"><strong>There was</strong> a sharp decline in vehicle sales.</p>
                    </div>
                </div>
            </div>

            <!-- Theory Box 3: Describing Trends Chart -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-teal-50 px-6 py-4 border-b border-teal-100">
                    <h2 class="text-lg font-bold text-teal-900">Describing Trends, Language of Change</h2>
                </div>
                <div class="p-4 bg-gray-50">
                    <img
                        src="{{ asset('images/trends_vocabulary.png') }}"
                        alt="Describing trends and language of change reference chart"
                        class="w-full h-auto rounded-lg border border-gray-200 bg-white"
                        loading="lazy"
                    >
                </div>
            </div>
        </div>

        <!-- Right Column: Practice -->
        <div class="lg:col-span-7 space-y-8">
            
            <!-- Exercise 3: Multi-Chart Practice -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-6 py-4 border-b border-gray-100">
                    <h3 class="text-lg font-bold text-gray-800">Exercise 3: Look at the graphs below. Then describe the changes.</h3>
                    <p class="text-sm text-gray-600 mt-1">Isi dua kolom jawaban untuk setiap graph: Verb dan Noun.</p>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <template x-for="item in exercises3" :key="item.id">
                            <div class="border border-gray-200 rounded-lg p-4 bg-white">
                                <div class="relative w-full bg-gray-50 border border-gray-100 rounded-lg overflow-hidden mb-3" style="aspect-ratio: 276/256;">
                                    <div class="absolute inset-0 bg-no-repeat bg-cover"
                                        :style="`
                                            background-image: url('{{ asset('assets/images/ielts/graphs_composite.png') }}');
                                            background-position: ${item.x * 50}% ${item.y * 33.33}%;
                                            background-size: 300% 400%;
                                        `">
                                    </div>
                                    <div class="absolute top-2 left-2 bg-white/90 backdrop-blur px-2 py-0.5 rounded-full text-xs font-bold text-gray-700" x-text="item.id"></div>
                                </div>

                                <label class="block mb-2">
                                    <p class="font-semibold text-gray-800 text-sm" x-text="item.prompt"></p>
                                </label>

                                <div class="space-y-2">
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Jawaban 1 (Verb)</label>
                                        <textarea
                                            :value="userAnswers[item.id]?.verb || ''"
                                            @input="setAnswer(item.id, 'verb', $event.target.value); autoResize($event.target)"
                                            x-init="$nextTick(() => autoResize($el))"
                                            :placeholder="'Contoh: rose'"
                                            class="w-full min-h-[2.5rem] p-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:outline-none transition-all text-sm resize-none overflow-hidden leading-relaxed"
                                        ></textarea>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-600 mb-1">Jawaban 2 (Noun)</label>
                                        <textarea
                                            :value="userAnswers[item.id]?.noun || ''"
                                            @input="setAnswer(item.id, 'noun', $event.target.value); autoResize($event.target)"
                                            x-init="$nextTick(() => autoResize($el))"
                                            :placeholder="'Contoh: a rise'"
                                            class="w-full min-h-[2.5rem] p-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:border-teal-500 focus:outline-none transition-all text-sm resize-none overflow-hidden leading-relaxed"
                                        ></textarea>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-sm text-yellow-900">
                        <p><strong>Note:</strong> Use a <strong>future tense</strong> to describe changes in items <strong>J, K, and L</strong>.</p>
                        <p class="mt-1"><strong>Example:</strong> It is predicted that the number of radio listeners will fall to 45,000 people in 2030.</p>
                    </div>
                    
                    <div class="flex gap-3 pt-4">
                        <button @click="submit()" :disabled="loading" class="flex-1 px-6 py-3 bg-orange-600 text-white font-bold rounded-lg hover:bg-orange-700 transition-colors disabled:opacity-50">
                            <span x-show="!loading">Submit Answers</span>
                            <span x-show="loading">Saving...</span>
                        </button>
                        <button @click="checkAnswers()" class="flex-1 px-6 py-3 bg-teal-600 text-white font-bold rounded-lg hover:bg-teal-700 transition-colors">
                            Check My Answers
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Alpine Data for the page -->
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('graphicalSentences', (meetingId) => ({
            userAnswers: {},
            loading: false,
            exercises3: [
                { id: 'A', prompt: 'Graph A (Car sales in \'000)', x: 0, y: 0 },
                { id: 'B', prompt: 'Graph B (Car sales)', x: 1, y: 0 },
                { id: 'C', prompt: 'Graph C (Car sales)', x: 2, y: 0 },
                { id: 'D', prompt: 'Graph D (Net users in \'000)', x: 0, y: 1 },
                { id: 'E', prompt: 'Graph E (Net users)', x: 1, y: 1 },
                { id: 'F', prompt: 'Graph F (Net users)', x: 2, y: 1 },
                { id: 'G', prompt: 'Graph G (Cases of polio in \'000)', x: 0, y: 2 },
                { id: 'H', prompt: 'Graph H (Cases of polio)', x: 1, y: 2 },
                { id: 'I', prompt: 'Graph I (Cases of polio)', x: 2, y: 2 },
                { id: 'J', prompt: 'Graph J (Radio listeners in \'000)', x: 0, y: 3 },
                { id: 'K', prompt: 'Graph K (Radio listeners)', x: 1, y: 3 },
                { id: 'L', prompt: 'Graph L (Radio listeners)', x: 2, y: 3 },
            ],
            setAnswer(id, type, value) {
                if (!this.userAnswers[id]) {
                    this.userAnswers[id] = { verb: '', noun: '' };
                }
                this.userAnswers[id][type] = value;
            },
            autoResize(el) {
                if (!el) return;
                el.style.height = 'auto';
                el.style.height = `${el.scrollHeight}px`;
            },
            init() {
                if (window.AutoSave) {
                    window.AutoSave.init(meetingId, '{{ Auth::id() }}');
                }

                setTimeout(() => {
                    document.querySelectorAll('textarea').forEach(el => this.autoResize(el));
                }, 300);
            },
            submit() {
                this.loading = true;
                const key = 'graphical_sentences_autosave_' + meetingId;
                localStorage.setItem(key, JSON.stringify(this.userAnswers));
                
                setTimeout(() => {
                    this.loading = false;
                    alert('Your answers have been saved!');
                }, 1000);
            },
            checkAnswers() {
                alert('Your answers have been recorded. Continue practicing to improve your sentence structure!');
            }
        }))
    })
</script>
@include('assignments.ielts.writing.practice_toolbar')
@endsection
