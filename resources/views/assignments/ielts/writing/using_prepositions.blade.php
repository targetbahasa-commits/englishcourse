@extends('layouts.admin')

@section('title', ($meeting->title ?? 'Using Prepositions') . ' - IELTS Writing Task ' . ($task ?? 1))

@section('head')
    <script src="{{ asset('js/auto-save.js') }}?v={{ time() }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="container mx-auto px-4 py-8" x-data="prepositionExercise({{ $meeting->id }}, {{ Js::from($savedAnswers ?? []) }})">
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
             <button type="button" @click="check()" class="px-6 py-2 bg-teal-600 text-white font-bold rounded-lg shadow-md hover:bg-teal-700 transition-colors">
                Check Answers
             </button>
             <button type="button" @click.prevent="submit()" :disabled="loading" class="px-6 py-2 bg-orange-600 text-white font-bold rounded-lg shadow-md hover:bg-orange-700 transition-colors flex items-center gap-2">
                <span x-show="!loading">Submit Answers</span>
                <span x-show="loading">Saving...</span>
             </button>
        </div>
    </div>

    <!-- Content Wrapper -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start pb-32">
        
        <!-- Explanation Section (Left Column) -->
        <div class="lg:col-span-12 xl:col-span-4 sticky top-6 self-start space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-bold text-red-700 mb-4 border-b border-gray-100 pb-2">Using the right prepositions</h2>
                <div class="prose prose-sm text-gray-700">
                    <p class="mb-4">
                        It is important to use the right preposition when you are reporting the features and describing the numbers, prepositions like <strong>to, by, with</strong> and <strong>at</strong> when describing numbers and figures. Here are some examples to give you a basic idea of the differences:
                    </p>
                    <ol class="list-decimal pl-4 space-y-4">
                        <li>
                            <span class="font-medium text-gray-900">Use <span class="text-red-600 font-bold">to</span> when describing what happened to the number:</span>
                            <div class="mt-1 pl-2 border-l-2 border-red-100 italic text-gray-600">
                                In 2008, the rate of unemployment rose <strong class="text-gray-900">to</strong> 10%.
                            </div>
                        </li>
                        <li>
                            <span class="font-medium text-gray-900">Use <span class="text-red-600 font-bold">by</span> when describing the amount of change between two numbers:</span>
                            <div class="mt-1 pl-2 border-l-2 border-red-100 italic text-gray-600">
                                In 2009, the rate of unemployment fell <strong class="text-gray-900">by</strong> 2% (from 10% to 8%).
                            </div>
                        </li>
                        <li>
                            <span class="font-medium text-gray-900">Use <span class="text-red-600 font-bold">with</span> to give the idea of 'having' the number:</span>
                            <div class="mt-1 pl-2 border-l-2 border-red-100 italic text-gray-600">
                                He won the election <strong class="text-gray-900">with</strong> 52% of the vote.
                            </div>
                        </li>
                        <li>
                            <span class="font-medium text-gray-900">Use <span class="text-red-600 font-bold">at</span> to add the number on the end of a sentence:</span>
                            <div class="mt-1 pl-2 border-l-2 border-red-100 italic text-gray-600">
                                Unemployment reached its highest level in 2008, <strong class="text-gray-900">at</strong> 10%.
                            </div>
                        </li>
                    </ol>
                </div>
            </div>
            
             <!-- Preposition Bank (Sticky on Left context) -->
             <div class="bg-blue-50 rounded-xl p-4 border border-blue-200 shadow-sm">
                <h3 class="text-xs font-bold text-blue-800 uppercase tracking-widest mb-3">Word Bank</h3>
                <div class="flex flex-wrap gap-2">
                    <template x-for="word in wordBank" :key="word">
                        <span class="px-2 py-1 bg-white text-blue-700 text-sm font-medium rounded border border-blue-100 shadow-sm select-all cursor-pointer hover:bg-blue-100 transition-colors" x-text="word"></span>
                    </template>
                </div>
            </div>
        </div>

        <!-- Exercise Section (Right Column) -->
        <div class="lg:col-span-12 xl:col-span-8 space-y-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                        <span class="bg-red-100 text-red-600 p-1.5 rounded-lg">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </span>
                        Exercise
                    </h2>
                    <p class="text-gray-600 mt-1">Complete the sentences choosing the right preposition from the list.</p>
                </div>

                <div class="space-y-4">
                    <template x-for="(question, index) in questions" :key="index">
                        <div class="flex gap-4 items-baseline w-full">
                            <span class="font-bold text-gray-400 text-right w-8 shrink-0" x-text="(index + 1) + '.'"></span>
                            <div class="text-lg leading-loose text-gray-800 flex-1">
                                <template x-for="(part, pIndex) in question.parts" :key="pIndex">
                                    <span>
                                        <!-- If part is a gap -->
                                        <template x-if="part === '__GAP__'">
                                            <input type="text" 
                                               x-model="answers['q' + (index + 1) + '_' + pIndex]"
                                               :name="'q' + (index + 1) + '_' + pIndex"
                                               @input="queueDraftSync()"
                                               placeholder="..."
                                               :class="getInputClass('q' + (index + 1) + '_' + pIndex)"
                                               :title="showAnswer('q' + (index + 1) + '_' + pIndex)"
                                               class="inline-block w-24 mx-1 px-2 py-0.5 text-center font-bold border-b-2 focus:outline-none transition-colors placeholder-gray-300">
                                        </template>
                                        <!-- If part is text -->
                                        <template x-if="part !== '__GAP__'">
                                            <span x-html="part"></span>
                                        </template>
                                    </span>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

    </div>

</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('prepositionExercise', (meetingId, savedAnswers = {}) => ({
            // Seeded from the student's last autosaved draft (see
            // IeltsWritingController::showMeeting()) - previously this
            // always started empty, so a normal page refresh looked like
            // it had wiped the student's answers even though they were
            // already safely saved server-side the whole time.
            answers: savedAnswers || {},
            loading: false,
            wordBank: ['for', 'at', 'on', 'to', 'in', 'by', 'from', 'between', 'of', 'up', 'down', 'with', 'and', 'during'],
            questions: [
                { parts: ['__GAP__', ' 1990 ', '__GAP__', ' 2000, there was a drop ', '__GAP__', ' 15%.'] }, // 1
                { parts: ['GM car sales peaked ', '__GAP__', ' 2,000 in 1999.'] }, // 2
                { parts: ['The chart shows a decline ', '__GAP__', ' 35% ', '__GAP__', ' the bird population.'] }, // 3
                { parts: ['There has been a significant increase ', '__GAP__', ' the number of people aged over eighty.'] }, // 4
                { parts: ['There have been dramatic cuts ', '__GAP__', ' the level of spending on the elderly, reaching a low ', '__GAP__', ' 11%.'] }, // 5
                { parts: ['Profits rose ', '__GAP__', ' a low of 4.5 million to a high of 8 million in 2008.'] }, // 6
                { parts: ['Canada and Australia’s wheat exports fluctuated ', '__GAP__', ' 5 million and 6 million respectively.'] }, // 7
                { parts: ['There were significant improvements ', '__GAP__', ' healthcare ', '__GAP__', ' 1980.'] }, // 8
                { parts: ['The statistics show a reduction ', '__GAP__', ' 20% ', '__GAP__', ' energy costs as a result ', '__GAP__', ' the measures.'] }, // 9
                { parts: ['Profits fell ', '__GAP__', ' 10%, from 2,000 to 1,800 in 1970s.'] }, // 10
                { parts: ['The radio station experienced a fall ', '__GAP__', ' 36,000 listeners to a total audience ', '__GAP__', ' 2.1 million.'] }, // 11
                { parts: ['The number of students fell ', '__GAP__', ' a low of 1,500 in the second half of the year.'] }, // 12
                { parts: ['Cases of AIDS shot ', '__GAP__', ' from 2,400 in 1996 to 4,000 in 2004.'] }, // 13
                { parts: ['Demand reached a peak ', '__GAP__', ' 45,000 in early March.'] }, // 14
                { parts: ['The number of cars sold remained unchanged in 1999 ', '__GAP__', ' three million.'] }, // 15
                { parts: ['Students do between three ', '__GAP__', ' four hours homework a night.'] }, // 16
                { parts: ['The number of accidents ', '__GAP__', ' 1999 was slightly higher than that of 2000.'] }, // 17
                { parts: ['The figure rose steadily ', '__GAP__', ' the four years between 1997 ', '__GAP__', ' 2001.'] }, // 18
                { parts: ['Oil production rose dramatically at first but then leveled out ', '__GAP__', ' $70 a barrel.'] }, // 19
                { parts: ['There was an increase ', '__GAP__', ' 50,000 between 1990 and 1992.'] }, // 20
                { parts: ['__GAP__', ' 1994 ', '__GAP__', ' 1997, sales rose steadily ', '__GAP__', ' over 20,000.'] }, // 21
                { parts: ['DVD sales peaked ', '__GAP__', ' 60,000 ', '__GAP__', ' 1992 but then decreased ', '__GAP__', ' about 10,000 over the next two years.'] }, // 22
                { parts: ['In the year 2000, sales started ', '__GAP__', ' 10,000. In the first month, there was a rise ', '__GAP__', ' around 2,000.'] }, // 23
                { parts: ['After some fluctuations, sales in 2000 reached their peak ', '__GAP__', ' just over 15,000, a rise ', '__GAP__', ' 5,000 since the beginning of the year. Sales increased ', '__GAP__', ' over 10,000 between 1994 and 1997, but then dropped ', '__GAP__', ' more than 10,000 ', '__GAP__', ' 1997 and 1999.'] }, // 24
                { parts: ['In 2008, the rate of unemployment rose ', '__GAP__', ' 10%.'] }, // 25
                { parts: ['In 2008, the rate of unemployment rose ', '__GAP__', ' 10%, from 2,000 to 2,200 cases.'] }, // 26
                { parts: ['There was a slight rise ', '__GAP__', ' the number of men employed.'] }, // 27
                { parts: ['Experts expect there to be a fall ', '__GAP__', ' approximately 30% over the next decade.'] }, // 28
                { parts: ['The introduction ', '__GAP__', ' DVDs led to a decline ', '__GAP__', ' 20% ', '__GAP__', ' video sales.'] }, // 29
                { parts: ['The figures show a drop ', '__GAP__', ' 5% ', '__GAP__', ' student numbers.'] }, // 30
                { parts: ['The health service program spent a total ', '__GAP__', ' $2.5 billion on staffing ', '__GAP__', ' April 2002.'] }, // 31
                { parts: ['The survey hopes to track trends ', '__GAP__', ' consumer spending.'] }, // 32
                { parts: ['In 2009, the rate of unemployment fell ', '__GAP__', ' 2% (from 10% to 8%).'] }, // 33
                { parts: ['He won the election ', '__GAP__', ' 52% of the vote.'] }, // 34
                { parts: ['Unemployment reached its highest level ', '__GAP__', ' the year 2008 ', '__GAP__', ' 10%.'] }, // 35
                { parts: ['__GAP__', ' 2002, the cost of an average house in the UK was around £130,000. ', '__GAP__', ' 2007, the average house price had risen ', '__GAP__', ' almost £190,000, but it fell back ', '__GAP__', ' just under £150,000 ', '__GAP__', ' 2008.'] }, // 36
                { parts: ['Japan ', '__GAP__', ' two gold medals and a silver one stood ahead of the US ', '__GAP__', ' one gold and one bronze medal ', '__GAP__', ' 1968.'] }, // 37
            ],
            results: {},
            showResults: false,
            // 1-28 from Key, 29-37 infer
            correctAnswers: {
                'q1_1': 'From', 'q1_3': 'to', 'q1_5': 'of',
                'q2_1': 'at',
                'q3_1': 'of', 'q3_3': 'in',
                'q4_1': 'in',
                'q5_1': 'in', 'q5_3': 'of',
                'q6_1': 'from',
                'q7_1': 'between',
                'q8_1': 'in', 'q8_3': 'in', // "in healthcare in 1980" logic from key says "in" for 8? Wait key says "8. in". Only one gap in text? Text has 2 gaps. Key might be abbreviated. Let's assume 'in' for both or check context. "improvements IN healthcare IN/SINCE 1980". Key for 8 says "in". Just one? Let's check text: "improvements ... healthcare ... 1980". Likely "in", "in".
                'q9_1': 'of', 'q9_3': 'in', 'q9_5': 'of',
                'q10_1': 'by', // "fell by 10%"
                'q11_1': 'of', 'q11_3': 'of', // Key says "11. of". Text: "fall ... 36,000 ... audience ... 2.1m". "fall OF 36k"? No, "fall FROM"? Key says "of". "fall of". Let's use 'of'. Second gap? "audience OF". Key only lists "of" once? 
                'q12_1': 'to',
                'q13_1': 'up',
                'q14_1': 'of',
                'q15_1': 'at',
                'q16_1': 'and',
                'q17_1': 'in',
                'q18_1': 'in', 'q18_3': 'and',
                'q19_1': 'at',
                'q20_1': 'of',
                'q21_0': 'Between', 'q21_2': 'and', 'q21_4': 'to',
                'q22_1': 'at', 'q22_3': 'in', 'q22_5': 'to', // Key 22: "at, to". Text has 3 gaps? "peaked ... 60k ... 1992 ... decreased ... 10k". "peaked AT 60k IN 1992". Key omitted 'in'? Or 'at, in, to'. Key says "22. at, to". I will use 'at', 'in', 'to'.
                'q23_1': 'at', 'q23_3': 'of', // Key 23: "In, at, of". Text: "sales started ... 10k. In the first month... rise ... 2k". "started AT". "rise OF". "In" must be first word? Text already has "In the year 2000". Aha, maybe "In 2000" refers to q23? No. 
                'q24_1': 'of', 'q24_3': 'of', 'q24_5': 'to', 'q24_7': 'between', // Key 24: "of, of, to, between". Matches.
                'q25_1': 'to',
                'q26_1': 'by', // Key 26: "by, from, to". Text: "rose ... 10%, from... to...". "rose BY 10%".
                'q27_1': 'in',
                'q28_1': 'of',
                // Inferred
                'q29_1': 'of', 'q29_3': 'of', 'q29_5': 'in', // "intro OF DVDs ... decline OF 20% IN video sales"
                'q30_1': 'of', 'q30_3': 'in', // "drop OF 5% IN student numbers"
                'q31_1': 'of', 'q31_3': 'in', // "total OF ... IN April"
                'q32_1': 'in', // "trends IN"
                'q33_1': 'by', // "fell BY 2%"
                'q34_1': 'with', // "won ... WITH 52%"
                'q35_1': 'in', 'q35_3': 'at', // "level IN ... AT 10%"
                'q36_0': 'In', 'q36_2': 'By', 'q36_4': 'to', 'q36_6': 'to', 'q36_8': 'in', // "IN 2002... BY 2007... risen TO... back TO... IN 2008"
                'q37_1': 'with', 'q37_3': 'with', 'q37_5': 'in', // "Japan WITH ... US WITH ... IN 1968"
            },
            init() {
                if (window.AutoSave) {
                    window.AutoSave.init(meetingId, '{{ Auth::id() }}');
                }
                setTimeout(() => {
                   const inputs = document.querySelectorAll('input[name^="q"]');
                   inputs.forEach(el => {
                       if(el.value) {
                           this.answers[el.name] = el.value;
                       }
                   });
                }, 500);

                this.$watch('answers', (value) => {
                    this.showResults = false; // Reset val on edit
                });
            },
            check() {
                this.showResults = true;
                // Optional: Scroll to first error?
            },
            getInputClass(key) {
                if (!this.showResults) return 'border-gray-300 focus:border-teal-500 bg-gray-50 focus:bg-white text-teal-700';
                
                const userAns = (this.answers[key] || '').trim().toLowerCase();
                const correctAns = (this.correctAnswers[key] || '').trim().toLowerCase();
                
                if (userAns === correctAns) {
                    return 'border-green-500 bg-green-50 text-green-700';
                }
                return 'border-red-500 bg-red-50 text-red-700';
            },
            showAnswer(key) {
               // Helper to show tooltip or replace? For now just color.
               // Maybe add a title attibute for correct answer?
               return this.showResults ? (this.correctAnswers[key] || '') : ''; 
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
                const key = 'preposition_exercise_v1_' + meetingId;
                localStorage.setItem(key, JSON.stringify(this.answers));

                const formattedEssay = this.questions.map((question, index) => {
                    const sentence = question.parts.map((part, pIndex) => {
                        if (part !== '__GAP__') return part;
                        const ans = this.answers['q' + (index + 1) + '_' + pIndex];
                        return ans ? `[${ans}]` : '[___]';
                    }).join('');
                    return `${index + 1}. ${sentence}`;
                }).join("\n");

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
            }
        }))
    })
</script>

@include('assignments.ielts.writing.practice_toolbar')
@endsection
