@extends('layouts.admin')

@section('head')
    <script src="{{ asset('js/auto-save.js') }}?v={{ time() }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="w-full max-w-[1920px] mx-auto px-6 py-8 flex flex-col min-h-screen" x-data="comparisonStructures({{ $meeting->id }})">
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
             <button type="button" @click="checkAnswers()" class="px-6 py-2 bg-indigo-600 text-white font-bold rounded-lg shadow-md hover:bg-indigo-700 transition-colors flex items-center gap-2">
                <span>Check Answers</span>
             </button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start pb-32">
        
        <!-- Left Column: Theory (Sticky) -->
        <div class="lg:col-span-5 sticky top-6 self-start space-y-6 max-h-[calc(100vh-2rem)] overflow-y-auto pr-2 custom-scrollbar">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-indigo-50 px-6 py-4 border-b border-indigo-100 flex justify-between items-center">
                    <h2 class="text-lg font-bold text-indigo-900">Reference: Comparisons & Grammar</h2>
                </div>
                <div class="p-0 flex flex-col justify-center bg-gray-50">
                    <img src="{{ asset('images/ielts_writing_task1_lesson6_comparisons.png') }}" class="w-full h-auto shadow-sm" alt="Simple Comparisons">
                    <img src="{{ asset('images/ielts_writing_task1_lesson6_comparative_adjectives.png') }}" class="w-full h-auto shadow-sm border-t border-gray-100" alt="Comparative Adjectives">
                    <img src="{{ asset('images/ielts_writing_task1_lesson6_transitions.png') }}" class="w-full h-auto shadow-sm border-t border-gray-100" alt="Transitions & Conjunctions">
                </div>
            </div>
        </div>

        <!-- Right Column: Exercises -->
        <div class="lg:col-span-7 space-y-8">
            <!-- Part 1 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-blue-50 px-6 py-4 border-b border-blue-100">
                    <h3 class="text-lg font-bold text-blue-800">Part 1: Perubahan Angka & Multiplier (Gambar 1 & 2)</h3>
                    <p class="text-sm text-blue-600 mt-1">Gunakan kata 'double', 'treble', atau akhiran '-fold'.</p>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Q31 -->
                    <div class="space-y-2">
                        <label for="q31" class="block text-gray-700 font-medium text-base">1. Jumlah pengangguran meningkat dua kali lipat antara tahun 2005 dan 2009.</label>
                        <input type="text" id="q31" name="q31" x-model="answers.q31" :class="getInputClass('q31')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="The number...">
                        <template x-if="showResults && !isCorrect('q31')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q31[0]"></span></p>
                        </template>
                    </div>
                    <!-- Q32 -->
                    <div class="space-y-2">
                        <label for="q32" class="block text-gray-700 font-medium text-base">2. Terjadi peningkatan dua kali lipat (twofold) dalam jumlah pengangguran.</label>
                        <input type="text" id="q32" name="q32" x-model="answers.q32" :class="getInputClass('q32')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="There was a...">
                        <template x-if="showResults && !isCorrect('q32')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q32[0]"></span></p>
                        </template>
                    </div>
                    <!-- Q33 -->
                    <div class="space-y-2">
                        <label for="q33" class="block text-gray-700 font-medium text-base">3. Angka tersebut meningkat tiga kali lipat (trebled) dalam kurun waktu empat tahun.</label>
                        <input type="text" id="q33" name="q33" x-model="answers.q33" :class="getInputClass('q33')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="The figure...">
                        <template x-if="showResults && !isCorrect('q33')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q33[0]"></span></p>
                        </template>
                    </div>
                    <!-- Q34 -->
                    <div class="space-y-2">
                        <label for="q34" class="block text-gray-700 font-medium text-base">4. Ada dua kali lebih banyak pengangguran pada tahun 2009 dibandingkan dengan tahun 2005.</label>
                        <input type="text" id="q34" name="q34" x-model="answers.q34" :class="getInputClass('q34')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="There were...">
                        <template x-if="showResults && !isCorrect('q34')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q34[0]"></span></p>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Part 2 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-purple-50 px-6 py-4 border-b border-purple-100">
                    <h3 class="text-lg font-bold text-purple-800">Part 2: Subjek & Kesesuaian Kata Kerja (Gambar 2)</h3>
                    <p class="text-sm text-purple-600 mt-1">Perhatikan penggunaan Singular/Plural Verb dan Countable/Uncountable Nouns.</p>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Q35 -->
                    <div class="space-y-2">
                        <label for="q35" class="block text-gray-700 font-medium text-base">5. Jumlah (The number of) orang yang tidak bekerja turun sebanyak 99.000 orang.</label>
                        <input type="text" id="q35" name="q35" x-model="answers.q35" :class="getInputClass('q35')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="The number of...">
                        <template x-if="showResults && !isCorrect('q35')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q35[0]"></span></p>
                        </template>
                    </div>
                    <!-- Q36 -->
                    <div class="space-y-2">
                        <label for="q36" class="block text-gray-700 font-medium text-base">6. Jumlah (The amount of) curah hujan meningkat dua kali lipat antara bulan Mei dan Juni.</label>
                        <input type="text" id="q36" name="q36" x-model="answers.q36" :class="getInputClass('q36')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="The amount of...">
                        <template x-if="showResults && !isCorrect('q36')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q36[0]"></span></p>
                        </template>
                    </div>
                    <!-- Q37 -->
                    <div class="space-y-2">
                        <label for="q37" class="block text-gray-700 font-medium text-base">7. Angka-angka (The figures for) pemenjaraan berfluktuasi dengan tajam sepanjang periode tersebut.</label>
                        <input type="text" id="q37" name="q37" x-model="answers.q37" :class="getInputClass('q37')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="The figures for...">
                        <template x-if="showResults && !isCorrect('q37')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q37[0]"></span></p>
                        </template>
                    </div>
                    <!-- Q38 -->
                    <div class="space-y-2">
                        <label for="q38" class="block text-gray-700 font-medium text-base">8. Proporsi (The proportion of) pengeluaran untuk perabotan mencapai puncaknya pada tahun 2001.</label>
                        <input type="text" id="q38" name="q38" x-model="answers.q38" :class="getInputClass('q38')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="The proportion of...">
                        <template x-if="showResults && !isCorrect('q38')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q38[0]"></span></p>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Part 3 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-yellow-50 px-6 py-4 border-b border-yellow-100">
                    <h3 class="text-lg font-bold text-yellow-800">Part 3: Pecahan, Persentase, & Kualifikasi (Gambar 3)</h3>
                    <p class="text-sm text-yellow-600 mt-1">Gantilah persentase dengan pecahan atau kualifikasi yang tepat.</p>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Q39 -->
                    <div class="space-y-2">
                        <label for="q39" class="block text-gray-700 font-medium text-base">9. Tiga perempat (75%) dari responden setuju dengan kebijakan tersebut.</label>
                        <input type="text" id="q39" name="q39" x-model="answers.q39" :class="getInputClass('q39')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="Three quarters of...">
                        <template x-if="showResults && !isCorrect('q39')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q39[0]"></span></p>
                        </template>
                    </div>
                    <!-- Q40 -->
                    <div class="space-y-2">
                        <label for="q40" class="block text-gray-700 font-medium text-base">10. Hampir setengah (49%) dari populasi menggunakan internet setiap hari.</label>
                        <input type="text" id="q40" name="q40" x-model="answers.q40" :class="getInputClass('q40')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="Almost half of...">
                        <template x-if="showResults && !isCorrect('q40')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q40[0]"></span></p>
                        </template>
                    </div>
                    <!-- Q41 -->
                    <div class="space-y-2">
                        <label for="q41" class="block text-gray-700 font-medium text-base">11. Hampir sepertiga (32%) dari siswa memilih kursus bahasa Inggris.</label>
                        <input type="text" id="q41" name="q41" x-model="answers.q41" :class="getInputClass('q41')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="Nearly one third of...">
                        <template x-if="showResults && !isCorrect('q41')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q41[0]"></span></p>
                        </template>
                    </div>
                    <!-- Q42 -->
                    <div class="space-y-2">
                        <label for="q42" class="block text-gray-700 font-medium text-base">12. Satu dari sepuluh (10%) orang lebih memilih bepergian dengan kereta api.</label>
                        <input type="text" id="q42" name="q42" x-model="answers.q42" :class="getInputClass('q42')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="One in ten...">
                        <template x-if="showResults && !isCorrect('q42')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q42[0]"></span></p>
                        </template>
                    </div>
                    <!-- Q43 -->
                    <div class="space-y-2">
                        <label for="q43" class="block text-gray-700 font-medium text-base">13. Mayoritas yang sangat besar (75% - 85%) dari anggaran digunakan untuk kesehatan.</label>
                        <input type="text" id="q43" name="q43" x-model="answers.q43" :class="getInputClass('q43')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="A very large majority of...">
                        <template x-if="showResults && !isCorrect('q43')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q43[0]"></span></p>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Part 4 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-orange-50 px-6 py-4 border-b border-orange-100">
                    <h3 class="text-lg font-bold text-orange-800">Part 4: Perbandingan & Superlatif (Gambar 4 & 5)</h3>
                    <p class="text-sm text-orange-600 mt-1">Gunakan struktur 'compared to' dan kata sifat perbandingan.</p>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Q44 -->
                    <div class="space-y-2">
                        <label for="q44" class="block text-gray-700 font-medium text-base">14. Harga di Inggris tinggi dibandingkan dengan harga di Kanada dan Australia.</label>
                        <input type="text" id="q44" name="q44" x-model="answers.q44" :class="getInputClass('q44')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="Prices in the UK...">
                        <template x-if="showResults && !isCorrect('q44')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q44[0]"></span></p>
                        </template>
                    </div>
                    <!-- Q45 -->
                    <div class="space-y-2">
                        <label for="q45" class="block text-gray-700 font-medium text-base">15. Sektor pertanian adalah yang paling produktif di antara semua sektor.</label>
                        <input type="text" id="q45" name="q45" x-model="answers.q45" :class="getInputClass('q45')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="The agricultural sector...">
                        <template x-if="showResults && !isCorrect('q45')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q45[0]"></span></p>
                        </template>
                    </div>
                    <!-- Q46 -->
                    <div class="space-y-2">
                        <label for="q46" class="block text-gray-700 font-medium text-base">16. Angka untuk ekspor kopi sedikit lebih tinggi daripada angka untuk ekspor teh.</label>
                        <input type="text" id="q46" name="q46" x-model="answers.q46" :class="getInputClass('q46')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="The figure for...">
                        <template x-if="showResults && !isCorrect('q46')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q46[0]"></span></p>
                        </template>
                    </div>
                    <!-- Q47 -->
                    <div class="space-y-2">
                        <label for="q47" class="block text-gray-700 font-medium text-base">17. Negara tersebut adalah satu-satunya dengan proporsi yang jauh lebih tinggi pada penggunaan energi surya.</label>
                        <input type="text" id="q47" name="q47" x-model="answers.q47" :class="getInputClass('q47')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="Country X is the only...">
                        <template x-if="showResults && !isCorrect('q47')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q47[0]"></span></p>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Part 5 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-teal-50 px-6 py-4 border-b border-teal-100">
                    <h3 class="text-lg font-bold text-teal-800">Part 5: Transisi & Konjungsi (Gambar 6)</h3>
                    <p class="text-sm text-teal-600 mt-1">Gunakan 'however', 'whereas', atau 'twice as much as'.</p>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Q48 -->
                    <div class="space-y-2">
                        <label for="q48" class="block text-gray-700 font-medium text-base">18. Timur Tengah memproduksi tingkat minyak yang tinggi; namun (however), Jepang tidak memproduksi sama sekali.</label>
                        <input type="text" id="q48" name="q48" x-model="answers.q48" :class="getInputClass('q48')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="The Middle East...">
                        <template x-if="showResults && !isCorrect('q48')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q48[0]"></span></p>
                        </template>
                    </div>
                    <!-- Q49 -->
                    <div class="space-y-2">
                        <label for="q49" class="block text-gray-700 font-medium text-base">19. Sementara (While/Whereas) Amerika Serikat memproduksi banyak gas alam, Korea Selatan tidak memproduksi apa pun.</label>
                        <input type="text" id="q49" name="q49" x-model="answers.q49" :class="getInputClass('q49')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="While the USA...">
                        <template x-if="showResults && !isCorrect('q49')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q49[0]"></span></p>
                        </template>
                    </div>
                    <!-- Q50 -->
                    <div class="space-y-2">
                        <label for="q50" class="block text-gray-700 font-medium text-base">20. Timur Tengah memproduksi minyak dua kali lebih banyak (twice as much) daripada Eropa.</label>
                        <input type="text" id="q50" name="q50" x-model="answers.q50" :class="getInputClass('q50')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="The Middle East produces...">
                        <template x-if="showResults && !isCorrect('q50')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q50[0]"></span></p>
                        </template>
                    </div>
                    <!-- Q51 -->
                    <div class="space-y-2">
                        <label for="q51" class="block text-gray-700 font-medium text-base">21. Rusia mengonsumsi sedikit lebih banyak minyak daripada Jerman.</label>
                        <input type="text" id="q51" name="q51" x-model="answers.q51" :class="getInputClass('q51')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="Russia consumes...">
                        <template x-if="showResults && !isCorrect('q51')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q51[0]"></span></p>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('comparisonStructures', (meetingId) => ({
        answers: {},
        showResults: false,
        correctAnswers: {
            // Part 1
            q31: ["The number of unemployed people doubled between 2005 and 2009", "The number of people who were unemployed doubled between 2005 and 2009"],
            q32: ["There was a twofold increase in the number of unemployed people", "There was a two-fold increase in the number of unemployed people"],
            q33: ["The figure trebled over a period of four years", "The figure trebled in a period of four years", "The figure trebled within four years"],
            q34: ["There were twice as many unemployed people in 2009 compared to 2005", "There were twice as many unemployed people in 2009 as in 2005"],

            // Part 2
            q35: ["The number of unemployed people fell by 99,000", "The number of people who were unemployed dropped by 99,000", "The number of people who were unemployed fell by 99,000"],
            q36: ["The amount of rainfall doubled between May and June"],
            q37: ["The figures for imprisonment fluctuated sharply throughout the period"],
            q38: ["The proportion of spending on furniture peaked in 2001", "The proportion of expenditure on furniture peaked in 2001"],

            // Part 3
            q39: ["Three quarters of respondents agreed with the policy", "75% of respondents agreed with the policy"],
            q40: ["Almost half of the population use the internet daily", "Nearly half of the population use the internet daily"],
            q41: ["Almost one third of students choose English courses", "Nearly one third of students choose English courses"],
            q42: ["One in ten people prefer to travel by train", "One in ten people prefer traveling by train"],
            q43: ["A very large majority of the budget is used for health", "A very large majority of the budget is spent on health"],

            // Part 4
            q44: [
                "Prices in the UK are high compared to prices in Canada and Australia", 
                "Prices in the UK are high compared with prices in Canada and Australia"
            ],
            q45: ["The agricultural sector is the most productive of all sectors", "The agriculture sector is the most productive of all sectors"],
            q46: ["The figure for coffee exports is slightly higher than the figure for tea exports"],
            q47: ["The country is the only one with a noticeably higher proportion of solar energy use", "Country X is the only one with a noticeably higher proportion of solar energy use"],

            // Part 5
            q48: ["The Middle East produces high levels of oil; however, Japan produces none"],
            q49: [
                "While the USA produces large amounts of natural gas, South Korea produces none", 
                "Whereas the USA produces large amounts of natural gas, South Korea produces none"
            ],
            q50: ["The Middle East produces twice as much oil as Europe"],
            q51: ["Russia consumes slightly more oil than Germany"]
        },

        init() {
            if (window.AutoSave) {
                window.AutoSave.init(meetingId, '{{ Auth::id() }}');
            }
            
            // Sync restored values to Alpine data
            setTimeout(() => {
                const inputs = document.querySelectorAll('input[name^="q"]');
                inputs.forEach(el => {
                    if (el.value) {
                        this.answers[el.name] = el.value;
                    }
                });
            }, 500);

            this.$watch('answers', (val) => {
                this.showResults = false; // Reset checking on edit
            });
        },

        checkAnswers() {
            this.showResults = true;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },

        isCorrect(key) {
            if (!this.answers[key]) return false;
            const userAns = this.answers[key].trim().toLowerCase().replace(/[.,]/g, '');
            // Simple validation: check if user answer matches any of the correct options (normalized)
            return this.correctAnswers[key].some(opt => {
                return opt.toLowerCase().replace(/[.,]/g, '') === userAns;
            });
        },

        getInputClass(key) {
            if (!this.showResults) return 'border-gray-300 focus:ring-teal-500 focus:border-teal-500';
            return this.isCorrect(key) 
                ? 'border-green-500 bg-green-50 text-green-700' 
                : 'border-red-500 bg-red-50 text-red-700';
        }
    }));
});
</script>

@include('assignments.ielts.writing.practice_toolbar')
@endsection
