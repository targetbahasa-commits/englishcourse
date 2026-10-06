@extends('layouts.admin')

@section('title', ($meeting->title ?? 'Reducing Clauses') . ' - IELTS Writing Task ' . ($task ?? 1))

@section('head')
    <script src="{{ asset('js/auto-save.js') }}?v={{ time() }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="w-full max-w-[1920px] mx-auto px-6 py-8 flex flex-col min-h-screen" x-data="reducingClauses({{ $meeting->id }}, {{ Js::from($savedAnswers ?? []) }})">
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
             <button type="button" @click.prevent="submit()" :disabled="loading" class="px-6 py-2 bg-orange-600 text-white font-bold rounded-lg shadow-md hover:bg-orange-700 transition-colors flex items-center gap-2">
                <span x-show="!loading">Submit Answers</span>
                <span x-show="loading">Saving...</span>
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
                    <img src="{{ asset('images/materials/ielts-writing/ielts_writing_task1_lesson7_reducing.png') }}" class="w-full h-auto shadow-sm" alt="Reducing Clauses Explanation">
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
                        <textarea rows="1" name="q1" x-model="answers.q1" :style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block getInputClass('q1') resize-none overflow-hidden" style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none overflow-hidden" placeholder="The figure then fell sharply..."></textarea>
                        <template x-if="showResults && !isCorrect('q1')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q1[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q2 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">2. Jumlah pengunjung terbesar datang dari Amerika Serikat, yang meningkat (which rose) dari 345 menjadi 609 ribu.</label>
                        <textarea rows="1" name="q2" x-model="answers.q2" :style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block getInputClass('q2') resize-none overflow-hidden" style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none overflow-hidden" placeholder="The largest number of visitors..."></textarea>
                        <template x-if="showResults && !isCorrect('q2')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q2[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q3 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">3. Biaya sewa melonjak dari 11% menjadi 21%, yang meningkat dua kali lipat (which doubled) selama periode sepuluh tahun tersebut.</label>
                        <textarea rows="1" name="q3" x-model="answers.q3" :style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block getInputClass('q3') resize-none overflow-hidden" style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none overflow-hidden" placeholder="Rental costs surged..."></textarea>
                        <template x-if="showResults && !isCorrect('q3')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q3[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q4 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">4. Konsumsi tetap tidak berubah dengan dua puncak kecil, yang sesuai (which corresponded) dengan dua penurunan pada penggunaan energi nuklir.</label>
                        <textarea rows="1" name="q4" x-model="answers.q4" :style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block getInputClass('q4') resize-none overflow-hidden" style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none overflow-hidden" placeholder="Consumption remained unchanged..."></textarea>
                        <template x-if="showResults && !isCorrect('q4')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q4[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q5 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">5. Email dan pesan instan berada di posisi ketiga dan keempat, yang mencatat (which scored) angka masing-masing 17% dan 16% untuk pria.</label>
                        <textarea rows="1" name="q5" x-model="answers.q5" :style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block getInputClass('q5') resize-none overflow-hidden" style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none overflow-hidden" placeholder="Email and instant messaging..."></textarea>
                        <template x-if="showResults && !isCorrect('q5')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q5[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q6 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">6. Jumlah uang yang ditabung turun drastis, yang berkurang (which stepped down) dari 6% menjadi hanya 2%.</label>
                        <textarea rows="1" name="q6" x-model="answers.q6" :style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block getInputClass('q6') resize-none overflow-hidden" style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none overflow-hidden" placeholder="The amount of money saved..."></textarea>
                        <template x-if="showResults && !isCorrect('q6')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q6[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q7 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">7. Jumlah pengguna internet mencapai 1,5 juta, yang merupakan dua kali lipat (which was double) dari perkiraan awal.</label>
                        <textarea rows="1" name="q7" x-model="answers.q7" :style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block getInputClass('q7') resize-none overflow-hidden" style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none overflow-hidden" placeholder="The number of internet users..."></textarea>
                        <template x-if="showResults && !isCorrect('q7')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q7[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q8 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">8. Jumlah pengguna internet melonjak lagi selama Maret dan April, yang melampaui (which outstripped) prediksi dengan selisih yang besar.</label>
                        <textarea rows="1" name="q8" x-model="answers.q8" :style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block getInputClass('q8') resize-none overflow-hidden" style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none overflow-hidden" placeholder="The number of internet users..."></textarea>
                        <template x-if="showResults && !isCorrect('q8')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q8[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q9 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">9. Angka pengangguran meningkat menjadi 10%, yang menandakan (which signaled) krisis ekonomi terburuk.</label>
                        <textarea rows="1" name="q9" x-model="answers.q9" :style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block getInputClass('q9') resize-none overflow-hidden" style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none overflow-hidden" placeholder="Unemployment figures rose..."></textarea>
                        <template x-if="showResults && !isCorrect('q9')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q9[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q10 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">10. Produksi gandum naik mencapai 500 ton, yang melampaui (which surpassed) target tahunan.</label>
                        <textarea rows="1" name="q10" x-model="answers.q10" :style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block getInputClass('q10') resize-none overflow-hidden" style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none overflow-hidden" placeholder="Wheat production rose..."></textarea>
                        <template x-if="showResults && !isCorrect('q10')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q10[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q11 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">11. Penggunaan batu bara menurun perlahan, yang mencapai (which reached) titik terendahnya di tahun 2010.</label>
                        <textarea rows="1" name="q11" x-model="answers.q11" :style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block getInputClass('q11') resize-none overflow-hidden" style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none overflow-hidden" placeholder="Coal usage declined slowly..."></textarea>
                        <template x-if="showResults && !isCorrect('q11')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q11[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q12 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">12. Populasi kota meningkat pesat, yang menyebabkan (which led) pada kurangnya ketersediaan perumahan.</label>
                        <textarea rows="1" name="q12" x-model="answers.q12" :style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block getInputClass('q12') resize-none overflow-hidden" style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none overflow-hidden" placeholder="The city's population..."></textarea>
                        <template x-if="showResults && !isCorrect('q12')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q12[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q13 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">13. Harga minyak berfluktuasi sepanjang tahun, yang berakhir (which ended) pada angka $80 per barel.</label>
                        <textarea rows="1" name="q13" x-model="answers.q13" :style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block getInputClass('q13') resize-none overflow-hidden" style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none overflow-hidden" placeholder="Oil prices fluctuated..."></textarea>
                        <template x-if="showResults && !isCorrect('q13')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q13[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q14 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">14. Tingkat kelulusan siswa naik menjadi 95%, yang merupakan (which was) pencapaian tertinggi sekolah tersebut.</label>
                        <textarea rows="1" name="q14" x-model="answers.q14" :style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block getInputClass('q14') resize-none overflow-hidden" style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none overflow-hidden" placeholder="Student graduation rates..."></textarea>
                        <template x-if="showResults && !isCorrect('q14')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q14[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q15 -->
                    <div class="space-y-2">
                        <label class="block text-gray-700 font-medium text-base">15. Investasi asing turun di kuartal kedua, yang mencerminkan (which reflected) ketidakpastian pasar.</label>
                        <textarea rows="1" name="q15" x-model="answers.q15" :style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block getInputClass('q15') resize-none overflow-hidden" style="field-sizing: content;" @input="$el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'" x-init="$nextTick(() => { if ($el.scrollHeight > 0) { $el.style.height = 'auto'; $el.style.height = $el.scrollHeight + 'px'; } })" class="auto-expand-answer block w-full px-4 py-3 rounded-lg border shadow-sm transition-all focus:ring-2 focus:ring-green-500 focus:border-green-500 resize-none overflow-hidden" placeholder="Foreign investment fell..."></textarea>
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
    Alpine.data('reducingClauses', (meetingId, savedAnswers = {}) => ({
        // Seeded from the student's last autosaved draft (see
        // IeltsWritingController::showMeeting()) - previously this always
        // started empty, so a normal page refresh looked like it had
        // wiped the student's answers even though they were already
        // safely saved server-side the whole time.
        answers: savedAnswers || {},
        loading: false,
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
                const inputs = document.querySelectorAll('input[name^="q"], textarea[name^="q"]');
                inputs.forEach(el => {
                    if (el.value) {
                         this.answers[el.name] = el.value;
                    }
                    if (el.scrollHeight > 0) { el.style.height = 'auto'; el.style.height = el.scrollHeight + 'px'; }
                });
            }, 500);

            this.$root.addEventListener('input', (e) => {
                if (e.target.matches('input[type="text"][name^="q"], textarea[name^="q"]')) {
                    this.queueDraftSync();
                }
            });
        },

        checkAnswers() {
            this.showResults = true;
        },

        draftSyncTimer: null,
        queueDraftSync() {
            if (window.showAutosaveIndicator) {
                window.showAutosaveIndicator('Menyimpan draft...', 'saving');
            }
            clearTimeout(this.draftSyncTimer);
            this.draftSyncTimer = setTimeout(() => this.syncDraftToServer(), 800);
        },
        async syncDraftToServer() {
            try {
                await fetch('/assignments/ielts-academic/writing/meeting/' + meetingId + '/draft', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({ userAnswers: this.answers }),
                    keepalive: true,
                });
                if (window.showAutosaveIndicator) {
                    window.showAutosaveIndicator();
                }
            } catch (e) {
                console.error('Failed to sync draft to server:', e);
                if (window.showAutosaveIndicator) {
                    window.showAutosaveIndicator('Gagal menyimpan draft', 'error');
                }
            }
        },
        async submit() {
            this.loading = true;
            const formattedEssay = Object.keys(this.correctAnswers)
                .map(key => `${key}: ${this.answers[key] || '-'}`)
                .join("\n");

            try {
                const response = await fetch('/assignments/ielts-academic/writing/evaluate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({ essay: formattedEssay || 'No answers provided', task_type: '1', meeting_id: meetingId })
                });
                const data = await response.json();
                this.loading = false;
                if (data.redirect_url) {
                    if (data.message) alert(data.message);
                    window.location.href = data.redirect_url;
                    return;
                }
                if (data.submission_id) {
                    if (confirm('Jawaban berhasil dikirim! Apakah Anda ingin melihat halaman hasil pengerjaan lengkap?')) {
                        window.open('/assignments/ielts-academic/writing/submission/' + data.submission_id, '_blank');
                    }
                } else {
                    alert('Jawaban berhasil disimpan!');
                }
            } catch (e) {
                this.loading = false;
                alert('Jawaban berhasil disimpan secara lokal!');
            }
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
