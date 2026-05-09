@extends('layouts.admin')

@section('head')
    <script src="{{ asset('js/auto-save.js') }}?v={{ time() }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="w-full max-w-[1920px] mx-auto px-6 py-8 flex flex-col min-h-screen" x-data="reducingClauses({{ $meeting->id }})">
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
        
        <!-- Left Column: Reference Image (Sticky) -->
        <div class="lg:col-span-5 sticky top-6 self-start space-y-6 max-h-[calc(100vh-2rem)] overflow-y-auto pr-2 custom-scrollbar">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-indigo-50 px-6 py-4 border-b border-indigo-100 flex justify-between items-center">
                    <h2 class="text-lg font-bold text-indigo-900">Reference: Reducing Clauses</h2>
                </div>
                <div class="p-0 flex flex-col justify-center bg-gray-50">
                    <img src="{{ asset('images/ielts_writing_task1_lesson7_reducing.png') }}" class="w-full h-auto shadow-sm" alt="Reducing Clauses Explanation">
                </div>
            </div>
            
            <!-- Instructions Box -->
            <div class="bg-yellow-50 rounded-xl p-5 border border-yellow-200">
                <h3 class="font-bold text-yellow-800 mb-2">Instructions</h3>
                <p class="text-yellow-800 text-sm">
                    Translate the following sentences into English. Use <strong>participle phrases</strong> (verb-ing) to replace the clauses starting with "which".
                    <br><br>
                    <strong>Example:</strong><br>
                    <em>"Angka tersebut naik, yang mencapai puncaknya di bulan Mei."</em><br>
                    <span class="text-green-700 font-mono">The figure rose, reaching a peak in May.</span>
                </p>
            </div>
        </div>

        <!-- Right Column: Exercises -->
        <div class="lg:col-span-7 space-y-8">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-green-50 px-6 py-4 border-b border-green-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-green-800">Latihan Translate: Reducing Clauses</h3>
                </div>
                
                <div class="p-6 space-y-6">
                    <!-- Q1 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">1. Angka tersebut kemudian turun tajam menjadi di bawah 5000, yang merupakan (which was) rekor terendah dalam 40 tahun.</label>
                        <input type="text" name="q1" x-model="answers.q1" :class="getInputClass('q1')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="The figure then fell sharply...">
                        <template x-if="showResults && !isCorrect('q1')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q1[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q2 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">2. Jumlah pengunjung terbesar datang dari Amerika Serikat, yang meningkat (which rose) dari 345 menjadi 609 ribu.</label>
                        <input type="text" name="q2" x-model="answers.q2" :class="getInputClass('q2')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="The largest number of visitors...">
                        <template x-if="showResults && !isCorrect('q2')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q2[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q3 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">3. Biaya sewa melonjak dari 11% menjadi 21%, yang meningkat dua kali lipat (which doubled) selama periode sepuluh tahun tersebut.</label>
                        <input type="text" name="q3" x-model="answers.q3" :class="getInputClass('q3')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Rental costs surged...">
                        <template x-if="showResults && !isCorrect('q3')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q3[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q4 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">4. Konsumsi tetap tidak berubah dengan dua puncak kecil, yang sesuai (which corresponded) dengan dua penurunan pada penggunaan energi nuklir.</label>
                        <input type="text" name="q4" x-model="answers.q4" :class="getInputClass('q4')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Consumption remained unchanged...">
                        <template x-if="showResults && !isCorrect('q4')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q4[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q5 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">5. Email dan pesan instan berada di posisi ketiga dan keempat, yang mencatat (which scored) angka masing-masing 17% dan 16% untuk pria.</label>
                        <input type="text" name="q5" x-model="answers.q5" :class="getInputClass('q5')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Email and instant messaging...">
                        <template x-if="showResults && !isCorrect('q5')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q5[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q6 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">6. Jumlah uang yang ditabung turun drastis, yang berkurang (which stepped down) dari 6% menjadi hanya 2%.</label>
                        <input type="text" name="q6" x-model="answers.q6" :class="getInputClass('q6')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="The amount of money saved...">
                        <template x-if="showResults && !isCorrect('q6')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q6[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q7 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">7. Jumlah pengguna internet mencapai 1,5 juta, yang merupakan dua kali lipat (which was double) dari perkiraan awal.</label>
                        <input type="text" name="q7" x-model="answers.q7" :class="getInputClass('q7')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="The number of internet users...">
                        <template x-if="showResults && !isCorrect('q7')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q7[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q8 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">8. Jumlah pengguna internet melonjak lagi selama Maret dan April, yang melampaui (which outstripped) prediksi dengan selisih yang besar.</label>
                        <input type="text" name="q8" x-model="answers.q8" :class="getInputClass('q8')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="The number of internet users...">
                        <template x-if="showResults && !isCorrect('q8')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q8[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q9 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">9. Angka pengangguran meningkat menjadi 10%, yang menandakan (which signaled) krisis ekonomi terburuk.</label>
                        <input type="text" name="q9" x-model="answers.q9" :class="getInputClass('q9')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Unemployment figures rose...">
                        <template x-if="showResults && !isCorrect('q9')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q9[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q10 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">10. Produksi gandum naik mencapai 500 ton, yang melampaui (which surpassed) target tahunan.</label>
                        <input type="text" name="q10" x-model="answers.q10" :class="getInputClass('q10')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Wheat production rose...">
                        <template x-if="showResults && !isCorrect('q10')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q10[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q11 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">11. Penggunaan batu bara menurun perlahan, yang mencapai (which reached) titik terendahnya di tahun 2010.</label>
                        <input type="text" name="q11" x-model="answers.q11" :class="getInputClass('q11')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Coal usage declined slowly...">
                        <template x-if="showResults && !isCorrect('q11')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q11[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q12 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">12. Populasi kota meningkat pesat, yang menyebabkan (which led) pada kurangnya ketersediaan perumahan.</label>
                        <input type="text" name="q12" x-model="answers.q12" :class="getInputClass('q12')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="The city's population...">
                        <template x-if="showResults && !isCorrect('q12')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q12[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q13 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">13. Harga minyak berfluktuasi sepanjang tahun, yang berakhir (which ended) pada angka $80 per barel.</label>
                        <input type="text" name="q13" x-model="answers.q13" :class="getInputClass('q13')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Oil prices fluctuated...">
                        <template x-if="showResults && !isCorrect('q13')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q13[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q14 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">14. Tingkat kelulusan siswa naik menjadi 95%, yang merupakan (which was) pencapaian tertinggi sekolah tersebut.</label>
                        <input type="text" name="q14" x-model="answers.q14" :class="getInputClass('q14')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Student graduation rates...">
                        <template x-if="showResults && !isCorrect('q14')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q14[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q15 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">15. Investasi asing turun di kuartal kedua, yang mencerminkan (which reflected) ketidakpastian pasar.</label>
                        <input type="text" name="q15" x-model="answers.q15" :class="getInputClass('q15')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="Foreign investment fell...">
                        <template x-if="showResults && !isCorrect('q15')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q15[0]"></span></p>
                        </template>
                    </div>

                    <!-- Check Answers Button -->
                    <div class="flex justify-end pt-4">
                        <button @click="checkAnswers()" class="px-8 py-3 bg-green-600 text-white font-bold rounded-lg shadow hover:bg-green-700 transition-all transform hover:scale-105">
                            Check Answers
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('reducingClauses', (meetingId) => ({
        answers: {},
        showResults: false,
        correctAnswers: {
            q1: ["The figure then fell sharply to below 5000, being a record low in 40 years", "The figure then fell sharply to below 5000, reaching a record low in 40 years"],
            q2: ["The largest number of visitors came from the USA, rising from 345 to 609 thousand", "The largest number of visitors came from the United States, rising from 345 to 609 thousand"],
            q3: ["Rental costs surged from 11% to 21%, doubling over the ten year period", "Rental costs surged from 11% to 21%, doubling over the ten-year period"],
            q4: ["Consumption remained unchanged with two small peaks, corresponding to two falls in nuclear power use", "Consumption remained unchanged with two small peaks, corresponding to two drops in nuclear power use"],
            q5: ["Email and instant messaging came in third and fourth, scoring 17% and 16% respectively for men", "Email and instant messaging were in third and fourth, scoring 17% and 16% respectively for men"],
            q6: ["The amount of money saved fell drastically, stepping down from 6% to only 2%", "The amount of money saved dropped drastically, stepping down from 6% to only 2%"],
            q7: ["The number of internet users reached 1.5 million, being double the initial estimate", "The number of internet users reached 1.5 million, being twice the initial estimate"],
            q8: ["The number of internet users surged again during March and April, outstripping predictions by a wide margin"],
            q9: ["Unemployment figures rose to 10%, signaling the worst economic crisis", "Unemployment figures rose to 10%, signalling the worst economic crisis"],
            q10: ["Wheat production rose to reach 500 tons, surpassing the annual target", "Wheat production rose to 500 tons, surpassing the annual target"],
            q11: ["Coal usage declined slowly, reaching its lowest point in 2010"],
            q12: ["The city's population increased rapidly, leading to a lack of housing availability", "The city's population rose rapidly, leading to a lack of housing availability"],
            q13: ["Oil prices fluctuated throughout the year, ending at $80 per barrel"],
            q14: ["Student graduation rates rose to 95%, being the school's highest achievement", "Student graduation rates increased to 95%, being the school's highest achievement"],
            q15: ["Foreign investment fell in the second quarter, reflecting market uncertainty", "Foreign investment dropped in the second quarter, reflecting market uncertainty"]
        },

        init() {
            if (window.AutoSave) {
                window.AutoSave.init(meetingId, '{{ Auth::id() }}');
            }
            
            setTimeout(() => {
                const inputs = document.querySelectorAll('input[name^="q"]');
                inputs.forEach(el => {
                    if (el.value) {
                         this.answers[el.name] = el.value;
                    }
                });
            }, 500);
        },

        checkAnswers() {
            this.showResults = true;
        },

        getInputClass(questionId) {
            if (!this.showResults) return 'border-gray-300';
            return this.isCorrect(questionId) ? 'border-green-500 bg-green-50' : 'border-red-500 bg-red-50';
        },

        isCorrect(questionId) {
            if (!this.answers[questionId]) return false;
            
            // Normalize user answer (remove punctuation at end, lowercase, extra spaces)
            const userAnswer = this.answers[questionId].toLowerCase().trim().replace(/[.,;]$/, '');
            
            return this.correctAnswers[questionId].some(answer => {
                const normalizedKey = answer.toLowerCase().trim().replace(/[.,;]$/, '');
                return userAnswer === normalizedKey;
            });
        }
    }));
});
</script>
@endsection
