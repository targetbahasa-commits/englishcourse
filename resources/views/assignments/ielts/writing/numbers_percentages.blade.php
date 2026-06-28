@extends('layouts.admin')

@section('head')
    <script src="{{ asset('js/auto-save.js') }}?v={{ time() }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="w-full max-w-[1920px] mx-auto px-6 py-8 flex flex-col min-h-screen" x-data="numbersPercentages({{ $meeting->id }})">
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
                    <h2 class="text-lg font-bold text-indigo-900">Reference: Describing Numbers & Data</h2>
                </div>
                <div class="p-0 flex flex-col justify-center bg-gray-50">
                    <img src="{{ asset('images/materials/ielts-writing/ielts_writing_task1_lesson5_v2.png') }}" class="w-full h-auto shadow-sm" alt="Lesson 5 Theory">
                    <img src="{{ asset('images/materials/ielts-writing/ielts_writing_task1_lesson5_extended.png') }}" class="w-full h-auto shadow-sm border-t border-gray-100" alt="Lesson 5 Further Explanation">
                    <img src="{{ asset('images/materials/ielts-writing/ielts_writing_task1_lesson5_variations.png') }}" class="w-full h-auto rounded-b shadow-sm border-t border-gray-100" alt="Lesson 5 Variations">
                </div>
            </div>
        </div>

        <!-- Right Column: Exercises -->
        <div class="lg:col-span-7 space-y-8">
            <!-- Part 1 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-teal-50 px-6 py-4 border-b border-teal-100">
                    <h3 class="text-lg font-bold text-teal-800">Part 1: Numbers, Fractions, & Percentages</h3>
                    <p class="text-sm text-teal-600 mt-1">Translate using the structure: <span class="font-mono bg-teal-100 px-1 rounded">"The number went up by [X] from [Y] to [Z]"</span></p>
                </div>
                <div class="p-6 space-y-6">
                    <div class="space-y-2">
                        <label for="q1" class="block text-gray-700 font-medium text-base">1. Jumlah siswa meningkat sebanyak 500 orang dari 1.500 menjadi 2.000.</label>
                        <input type="text" id="q1" name="q1" x-model="answers.q1" :class="getInputClass('q1')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="The number of students went up by...">
                        <template x-if="showResults && !isCorrect('q1')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q1[0]"></span></p>
                        </template>
                    </div>
                    
                    <div class="space-y-2">
                        <label for="q2" class="block text-gray-700 font-medium text-base">2. Jumlah siswa meningkat sebesar satu pertiga dari 1.500 menjadi 2.000.</label>
                        <input type="text" id="q2" name="q2" x-model="answers.q2" :class="getInputClass('q2')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="The number...">
                        <template x-if="showResults && !isCorrect('q2')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q2[0]"></span></p>
                        </template>
                    </div>

                    <div class="space-y-2">
                        <label for="q3" class="block text-gray-700 font-medium text-base">3. Jumlah siswa meningkat sebesar 33% dari 1.500 menjadi 2.000.</label>
                        <input type="text" id="q3" name="q3" x-model="answers.q3" :class="getInputClass('q3')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="The number...">
                        <template x-if="showResults && !isCorrect('q3')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q3[0]"></span></p>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Part 2 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-blue-50 px-6 py-4 border-b border-blue-100">
                    <h3 class="text-lg font-bold text-blue-800">Part 2: Multipliers (Double, Treble, -fold, Times)</h3>
                    <p class="text-sm text-blue-600 mt-1">Use the verb and adjective variations from Part B.</p>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Q4 -->
                    <div class="space-y-2">
                        <label for="q4" class="block text-gray-700 font-medium text-base">4. Angka tersebut meningkat dua kali lipat (doubled) antara tahun 2000 dan 2005.</label>
                        <input type="text" id="q4" name="q4" x-model="answers.q4" :class="getInputClass('q4')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="The number doubled...">
                        <template x-if="showResults && !isCorrect('q4')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q4[0]"></span></p>
                        </template>
                    </div>
                    
                    <!-- Q5 -->
                    <div class="space-y-2">
                        <label for="q5" class="block text-gray-700 font-medium text-base">5. Terjadi kenaikan tiga kali lipat (three-fold) dalam penggunaan internet.</label>
                        <input type="text" id="q5" name="q5" x-model="answers.q5" :class="getInputClass('q5')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="There was a...">
                        <template x-if="showResults && !isCorrect('q5')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q5[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q6 -->
                    <div class="space-y-2">
                        <label for="q6" class="block text-gray-700 font-medium text-base">6. Angka di tahun 2020 adalah empat kali lebih besar daripada angka di tahun 2010.</label>
                        <input type="text" id="q6" name="q6" x-model="answers.q6" :class="getInputClass('q6')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="The figure...">
                        <template x-if="showResults && !isCorrect('q6')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q6[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q7 -->
                    <div class="space-y-2">
                        <label for="q7" class="block text-gray-700 font-medium text-base">7. Dia menghasilkan uang lima kali lebih banyak daripada saya.</label>
                        <input type="text" id="q7" name="q7" x-model="answers.q7" :class="getInputClass('q7')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="She earns...">
                        <template x-if="showResults && !isCorrect('q7')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q7[0]"></span></p>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Part 3 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-orange-50 px-6 py-4 border-b border-orange-100">
                    <h3 class="text-lg font-bold text-orange-800">Part 3: Describing Decrease (Fractions)</h3>
                    <p class="text-sm text-orange-600 mt-1">Focus on using fractions for decrease.</p>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Q8 -->
                    <div class="space-y-2">
                        <label for="q8" class="block text-gray-700 font-medium text-base">8. Antara Januari dan Maret, angka tersebut turun sebesar seperempat (one quarter).</label>
                        <input type="text" id="q8" name="q8" x-model="answers.q8" :class="getInputClass('q8')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="Between...">
                        <template x-if="showResults && !isCorrect('q8')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q8[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q9 -->
                    <div class="space-y-2">
                        <label for="q9" class="block text-gray-700 font-medium text-base">9. Angka pada tahun 2022 adalah sepersepuluh (one tenth) dari total tahun 2010.</label>
                        <input type="text" id="q9" name="q9" x-model="answers.q9" :class="getInputClass('q9')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="The figure...">
                        <template x-if="showResults && !isCorrect('q9')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q9[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q10 -->
                    <div class="space-y-2">
                        <label for="q10" class="block text-gray-700 font-medium text-base">10. Antara tahun 2018 dan 2019, jumlahnya berkurang sebesar setengah (by half).</label>
                        <input type="text" id="q10" name="q10" x-model="answers.q10" :class="getInputClass('q10')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="Between...">
                        <template x-if="showResults && !isCorrect('q10')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q10[0]"></span></p>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Part 4 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-purple-50 px-6 py-4 border-b border-purple-100">
                    <h3 class="text-lg font-bold text-purple-800">Part 4: Percentage Placement</h3>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Q11 -->
                    <div class="space-y-2">
                        <label for="q11" class="block text-gray-700 font-medium text-base">11. 10% dari penduduk tinggal di daerah pedesaan.</label>
                        <input type="text" id="q11" name="q11" x-model="answers.q11" :class="getInputClass('q11')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="10% of...">
                        <template x-if="showResults && !isCorrect('q11')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q11[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q12 -->
                    <div class="space-y-2">
                        <label for="q12" class="block text-gray-700 font-medium text-base">12. Tingkat pengangguran di kalangan anak muda berada pada angka 12%.</label>
                        <input type="text" id="q12" name="q12" x-model="answers.q12" :class="getInputClass('q12')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="The unemployment rate...">
                        <template x-if="showResults && !isCorrect('q12')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q12[0]"></span></p>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Part 5 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-pink-50 px-6 py-4 border-b border-pink-100">
                    <h3 class="text-lg font-bold text-pink-800">Part 5: Comparisons</h3>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Q13 -->
                    <div class="space-y-2">
                        <label for="q13" class="block text-gray-700 font-medium text-base">13. 80% remaja menggunakan internet untuk belajar, dibandingkan dengan hanya 25% lansia.</label>
                        <input type="text" id="q13" name="q13" x-model="answers.q13" :class="getInputClass('q13')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="80% of...">
                        <template x-if="showResults && !isCorrect('q13')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q13[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q14 -->
                    <div class="space-y-2">
                        <label for="q14" class="block text-gray-700 font-medium text-base">14. 15% pria pergi bekerja dengan bersepeda, sedangkan hanya 5% wanita yang melakukan hal yang sama.</label>
                        <input type="text" id="q14" name="q14" x-model="answers.q14" :class="getInputClass('q14')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="15% of...">
                        <template x-if="showResults && !isCorrect('q14')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q14[0]"></span></p>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Part 6 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-cyan-50 px-6 py-4 border-b border-cyan-100">
                    <h3 class="text-lg font-bold text-cyan-800">Part 6: Multipliers (Double, Twice, Three times)</h3>
                    <p class="text-sm text-cyan-600 mt-1">Use the patterns from point 1 and 2 in the chart.</p>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Q15 -->
                    <div class="space-y-2">
                        <label for="q15" class="block text-gray-700 font-medium text-base">15. Jumlah pengangguran meningkat dua kali lipat (doubled) antara tahun 2010 dan 2015.</label>
                        <input type="text" id="q15" name="q15" x-model="answers.q15" :class="getInputClass('q15')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="The number...">
                        <template x-if="showResults && !isCorrect('q15')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q15[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q16 -->
                    <div class="space-y-2">
                        <label for="q16" class="block text-gray-700 font-medium text-base">16. Ada dua kali lebih banyak (twice as many) mobil di jalan raya pada tahun 2020 dibandingkan tahun 2010.</label>
                        <input type="text" id="q16" name="q16" x-model="answers.q16" :class="getInputClass('q16')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="There were...">
                        <template x-if="showResults && !isCorrect('q16')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q16[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q17 -->
                    <div class="space-y-2">
                        <label for="q17" class="block text-gray-700 font-medium text-base">17. Tiga kali lebih banyak orang berwisata ke luar negeri pada tahun 2019 dibandingkan dengan (compared to) tahun 1990.</label>
                        <input type="text" id="q17" name="q17" x-model="answers.q17" :class="getInputClass('q17')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="Three times...">
                        <template x-if="showResults && !isCorrect('q17')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q17[0]"></span></p>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Part 7 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-emerald-50 px-6 py-4 border-b border-emerald-100">
                    <h3 class="text-lg font-bold text-emerald-800">Part 7: Twofold and Threefold</h3>
                    <p class="text-sm text-emerald-600 mt-1">Use as adjective (with noun) or adverb (after verb).</p>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Q18 -->
                    <div class="space-y-2">
                        <label for="q18" class="block text-gray-700 font-medium text-base">18. Terjadi kenaikan dua kali lipat (twofold increase) dalam jumlah penggunaan air antara tahun 2005 dan 2010.</label>
                        <input type="text" id="q18" name="q18" x-model="answers.q18" :class="getInputClass('q18')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="There was a...">
                        <template x-if="showResults && !isCorrect('q18')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q18[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q19 -->
                    <div class="space-y-2">
                        <label for="q19" class="block text-gray-700 font-medium text-base">19. Jumlah pengguna internet meningkat tiga kali lipat (increased threefold) selama periode sepuluh tahun tersebut.</label>
                        <input type="text" id="q19" name="q19" x-model="answers.q19" :class="getInputClass('q19')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="The number...">
                        <template x-if="showResults && !isCorrect('q19')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q19[0]"></span></p>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Part 8 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-rose-50 px-6 py-4 border-b border-rose-100">
                    <h3 class="text-lg font-bold text-rose-800">Part 8: Describing Quantities</h3>
                    <p class="text-sm text-rose-600 mt-1">Watch for countable/uncountable nouns and verb forms.</p>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Q20 -->
                    <div class="space-y-2">
                        <label for="q20" class="block text-gray-700 font-medium text-base">20. Jumlah (The number of) siswa yang lulus ujian menurun sebanyak 10.000 menjadi 1 juta dalam tiga bulan terakhir.</label>
                        <input type="text" id="q20" name="q20" x-model="answers.q20" :class="getInputClass('q20')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="The number of...">
                        <template x-if="showResults && !isCorrect('q20')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q20[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q21 -->
                    <div class="space-y-2">
                        <label for="q21" class="block text-gray-700 font-medium text-base">21. Jumlah (The amount of) konsumsi air meningkat dua kali lipat antara bulan Januari dan Februari.</label>
                        <input type="text" id="q21" name="q21" x-model="answers.q21" :class="getInputClass('q21')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="The amount of...">
                        <template x-if="showResults && !isCorrect('q21')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q21[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q22 -->
                    <div class="space-y-2">
                        <label for="q22" class="block text-gray-700 font-medium text-base">22. Proporsi (The proportion of) pengeluaran untuk kesehatan mencapai puncaknya pada tahun 2010.</label>
                        <input type="text" id="q22" name="q22" x-model="answers.q22" :class="getInputClass('q22')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="The proportion of...">
                        <template x-if="showResults && !isCorrect('q22')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q22[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q23 -->
                    <div class="space-y-2">
                        <label for="q23" class="block text-gray-700 font-medium text-base">23. Persentase (The percentage of) penduduk yang menggunakan energi terbarukan melonjak menjadi 35% pada tahun 2022.</label>
                        <input type="text" id="q23" name="q23" x-model="answers.q23" :class="getInputClass('q23')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="The percentage of...">
                        <template x-if="showResults && !isCorrect('q23')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q23[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q24 -->
                    <div class="space-y-2">
                        <label for="q24" class="block text-gray-700 font-medium text-base">24. Data (The figures for) angka kelahiran berfluktuasi dengan tajam (fluctuated sharply) sepanjang tahun tersebut.</label>
                        <input type="text" id="q24" name="q24" x-model="answers.q24" :class="getInputClass('q24')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="The figures for...">
                        <template x-if="showResults && !isCorrect('q24')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q24[0]"></span></p>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Part 9 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-amber-50 px-6 py-4 border-b border-amber-100">
                    <h3 class="text-lg font-bold text-amber-800">Part 9: Fractions & Percentages</h3>
                    <p class="text-sm text-amber-600 mt-1">Use the phrases for varying language (e.g. three-quarters, one in ten).</p>
                </div>
                <div class="p-6 space-y-6">
                    <!-- Q25 -->
                    <div class="space-y-2">
                        <label for="q25" class="block text-gray-700 font-medium text-base">25. Tiga perempat (75%) dari total penduduk memiliki akses internet.</label>
                        <input type="text" id="q25" name="q25" x-model="answers.q25" :class="getInputClass('q25')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="Three quarters of...">
                        <template x-if="showResults && !isCorrect('q25')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q25[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q26 -->
                    <div class="space-y-2">
                        <label for="q26" class="block text-gray-700 font-medium text-base">26. Hampir sepertiga (32%) dari para pekerja memilih untuk bekerja dari rumah.</label>
                        <input type="text" id="q26" name="q26" x-model="answers.q26" :class="getInputClass('q26')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="Almost one third of...">
                        <template x-if="showResults && !isCorrect('q26')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q26[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q27 -->
                    <div class="space-y-2">
                        <label for="q27" class="block text-gray-700 font-medium text-base">27. Satu dari sepuluh (10%) orang lebih suka menggunakan transportasi umum.</label>
                        <input type="text" id="q27" name="q27" x-model="answers.q27" :class="getInputClass('q27')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="One in ten...">
                        <template x-if="showResults && !isCorrect('q27')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q27[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q28 -->
                    <div class="space-y-2">
                        <label for="q28" class="block text-gray-700 font-medium text-base">28. Mayoritas yang sangat besar (75% - 85%) dari responden setuju dengan kebijakan baru tersebut.</label>
                        <input type="text" id="q28" name="q28" x-model="answers.q28" :class="getInputClass('q28')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="A very large majority of...">
                        <template x-if="showResults && !isCorrect('q28')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q28[0]"></span></p>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Part 10 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-lime-50 px-6 py-4 border-b border-lime-100">
                    <h3 class="text-lg font-bold text-lime-800">Part 10: Complex Comparisons</h3>
                    <p class="text-sm text-lime-600 mt-1">Use 'while', 'whereas', or 'compared to'.</p>
                </div>
                <!-- ... existing Q29, Q30 ... -->
                <div class="p-6 space-y-6">
                    <!-- Q29 -->
                    <div class="space-y-2">
                        <label for="q29" class="block text-gray-700 font-medium text-base">29. 65% (Dua pertiga) penduduk desa bekerja di sektor pertanian, sedangkan (whereas) angkanya hanya 5% (satu dari dua puluh) di wilayah kota.</label>
                        <input type="text" id="q29" name="q29" x-model="answers.q29" :class="getInputClass('q29')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="Two thirds of...">
                        <template x-if="showResults && !isCorrect('q29')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q29[0]"></span></p>
                        </template>
                    </div>

                    <!-- Q30 -->
                    <div class="space-y-2">
                        <label for="q30" class="block text-gray-700 font-medium text-base">30. Persentase pengguna ponsel melonjak menjadi 41% pada 2008, dibandingkan dengan (compared to) hanya 10% pada tahun sebelumnya.</label>
                        <input type="text" id="q30" name="q30" x-model="answers.q30" :class="getInputClass('q30')" class="w-full px-4 py-3 rounded-lg border shadow-sm transition-all text-base" placeholder="The percentage of...">
                        <template x-if="showResults && !isCorrect('q30')">
                            <p class="text-sm text-red-600 mt-1">Correct: <span x-text="correctAnswers.q30[0]"></span></p>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('numbersPercentages', (meetingId) => ({
        answers: {},
        showResults: false,
        correctAnswers: {
            q1: ["The number of students went up by 500 from 1,500 to 2,000", "The number of students went up by 500 from 1500 to 2000"],
            q2: ["The number of students went up by one third from 1,500 to 2,000", "The number of students went up by one third from 1500 to 2000"],
            q3: ["The number of students went up by 33% from 1,500 to 2,000", "The number of students went up by 33% from 1500 to 2000"],
            q4: ["The number doubled between 2000 and 2005"],
            q5: ["There was a three-fold increase in internet usage", "There was a three-fold increase in the use of the internet"],
            q6: ["The figure in 2020 was four times greater than that of 2010", "The figure in 2020 was four times higher than that of 2010", "The figure in 2020 was four times greater than the 2010 figure"],
            q7: ["She earns five times more than I do", "He earns five times more than I do"],
            q8: ["Between January and March, the figure fell by one quarter", "Between January and March, the number fell by one quarter"],
            q9: ["The figure in 2022 was one tenth of the 2010 total"],
            q10: ["Between 2018 and 2019, the number dropped by half", "Between 2018 and 2019, the number decreased by half"],
            q11: ["10% of the population lived in rural areas", "10% of the population live in rural areas"],
            q12: ["The unemployment rate among young people stood at 12%", "The level of unemployment among young people stood at 12%"],
            q13: [
                "80% of teenagers use the internet to study compared to only 25% of the elderly", 
                "80% of teenagers use the internet to study, compared to only 25% of the elderly",
                "80% of teenagers use the internet for studying compared to only 25% of the elderly"
            ],
            q14: [
                "15% of men go to work by bicycle whereas only 5% of women do the same", 
                "15% of men go to work by bicycle, whereas only 5% of women do the same",
                "15% of men cycle to work whereas only 5% of women do the same",
                "15% of men go to work by bike whereas only 5% of women do the same"
            ],
            q15: ["The number of unemployed people doubled between 2010 and 2015"],
            q16: [
                "There were twice as many cars on the road in 2020 as in 2010", 
                "There were twice as many cars on the road in 2020 compared to 2010"
            ],
            q17: ["Three times as many people travelled abroad in 2019 compared to 1990"],
            q18: ["There was a twofold increase in the amount of water usage between 2005 and 2010"],
            q19: ["The number of internet users increased threefold over the ten year period"],
            q20: ["The number of international students fell by 5,000", "The number of international students dropped by 5,000"],
            q21: ["The amount of water consumption doubled between January and February"],
            q22: ["The proportion of spending on health reached its peak in 2010"],
            q23: ["The percentage of the population using renewable energy jumped to 35% in 2022"],
            q24: ["The figures for birth rates fluctuated sharply throughout the year"],
            q25: ["Three-quarters of the total population have internet access", "75% of the total population have internet access"],
            q26: ["Almost one third of workers choose to work from home", "Nearly one third of workers choose to work from home"],
            q27: ["One in ten people prefer to use public transport"],
            q28: ["A very large majority of respondents agreed with the new policy"],
            q29: [
                "Two thirds of village residents work in the agricultural sector whereas the figure is only one in twenty in city areas",
                "Two thirds of village residents work in agriculture whereas the figure is only one in twenty in city areas"
            ],
            q30: [
                "The percentage of mobile phone users jumped to 41% in 2008 compared to only 10% in the previous year",
                "The percentage of mobile phone users surged to 41% in 2008 compared to only 10% in the previous year"
            ]
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
{{-- Actually, I'll assume I can just write the HTML directly or create a partial file. For simplicity/robustness, I will replace the includes with direct HTML for now to avoid 'partial not found' errors if I forget to create it. --}}
@endsection
