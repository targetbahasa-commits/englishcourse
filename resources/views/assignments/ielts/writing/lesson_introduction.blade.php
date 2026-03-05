@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 h-screen flex flex-col">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('assignments.ielts-academic.writing.index', ['task' => $task]) }}" class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                 <span class="text-sm font-semibold text-orange-600 tracking-wider uppercase">IELTS Writing Task {{ $task }}</span>
                <h1 class="text-2xl font-bold text-gray-800">{{ $meeting->title }}</h1>
            </div>
        </div>
    </div>

    <!-- Content Wrapper -->
    <div class="flex-1 overflow-y-auto pb-8" x-data="lessonIntroApp({{ $meeting->id }})">
        <div class="max-w-4xl mx-auto w-full space-y-8">
            
            <!-- Card 1: Explanation -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Cara Membuat Introduction Paragraph</h2>
                
                <div class="prose prose-lg max-w-none text-gray-600 space-y-6">
                    <p class="text-xl leading-relaxed">
                        Introduction paragraph pada dasarnya adalah memperkenalkan topik yang sedang dibahas kepada pembaca. 
                        Anda hanya perlu untuk <span class="font-bold text-orange-600 bg-orange-50 px-2 py-1 rounded">MEM-PARAPHRASE</span> soal yang diberikan.
                    </p>

                    <div class="bg-blue-50 p-6 rounded-xl border border-blue-100 my-8">
                        <h3 class="text-blue-900 font-bold text-lg mb-3">Metode Paraphrasing</h3>
                        <p class="mb-4">Ada beberapa cara yang bisa Anda gunakan untuk membuat paraphrase:</p>
                        <ul class="list-disc pl-5 space-y-2 text-blue-800">
                            <li>Mengubah <span class="font-semibold">aktif sentence</span> menjadi <span class="font-semibold">pasif sentence</span>.</li>
                            <li>Menjadikan <span class="font-semibold">verb</span> dari soal menjadi <span class="font-semibold">gerund as subject</span> di kalimat.</li>
                            <li>Mengubah <span class="font-semibold">keyword</span> ke <span class="font-semibold">sinonimnya</span>.</li>
                            <li><span class="font-semibold">Mixed</span> dari 3 metode di atas.</li>
                        </ul>
                    </div>

                    <!-- Soal Asli -->
                    <div class="mb-10">
                        <h3 class="text-gray-800 font-bold mb-3 uppercase tracking-wide text-sm">Soal Asli:</h3>
                        <div class="bg-gray-800 text-white p-6 rounded-xl shadow-lg">
                            "Some people believe that university education should focus on job skills, while others think it should provide knowledge for its own sake."
                        </div>
                    </div>

                    <!-- Example 1 -->
                    <div class="mb-10 p-6 rounded-xl border border-gray-200 hover:border-orange-300 transition-colors">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="w-8 h-8 flex items-center justify-center bg-orange-100 text-orange-600 font-bold rounded-full">1</span>
                            <h3 class="text-xl font-bold text-gray-900">Aktif → Pasif</h3>
                        </div>
                        <div class="pl-11">
                            <div class="italic text-gray-800 font-medium mb-2 border-l-4 border-orange-500 pl-4 py-1 bg-gray-50 rounded-r">
                                "It is believed by some people that university education ought to be directed towards developing job skills, whereas others argue that it should be aimed at gaining knowledge for personal growth."
                            </div>
                             <p class="text-sm text-gray-500">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Mengubah “Some people believe…” jadi “It is believed by some people…”
                            </p>
                        </div>
                    </div>

                    <!-- Example 2 -->
                     <div class="mb-10 p-6 rounded-xl border border-gray-200 hover:border-teal-300 transition-colors">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="w-8 h-8 flex items-center justify-center bg-teal-100 text-teal-600 font-bold rounded-full">2</span>
                            <h3 class="text-xl font-bold text-gray-900">Verb → Gerund</h3>
                        </div>
                        <div class="pl-11">
                            <div class="italic text-gray-800 font-medium mb-2 border-l-4 border-teal-500 pl-4 py-1 bg-gray-50 rounded-r">
                                "Focusing university education on practical job skills is considered important by some people, while others think providing general knowledge is more valuable."
                            </div>
                             <p class="text-sm text-gray-500">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                “Believe that university education should focus…” → “Focusing university education…” (gerund as subject)
                            </p>
                        </div>
                    </div>

                    <!-- Example 3 -->
                     <div class="mb-10 p-6 rounded-xl border border-gray-200 hover:border-purple-300 transition-colors">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="w-8 h-8 flex items-center justify-center bg-purple-100 text-purple-600 font-bold rounded-full">3</span>
                            <h3 class="text-xl font-bold text-gray-900">Keyword → Sinonim</h3>
                        </div>
                        <div class="pl-11">
                            <div class="italic text-gray-800 font-medium mb-2 border-l-4 border-purple-500 pl-4 py-1 bg-gray-50 rounded-r">
                                "Some individuals argue that higher education ought to emphasize professional abilities, whereas others claim it should concentrate on intellectual development."
                            </div>
                            <ul class="text-sm text-gray-500 space-y-1 mt-3">
                                <li>• “University education” → “Higher education”</li>
                                <li>• “Job skills” → “Professional abilities”</li>
                                <li>• “Knowledge for its own sake” → “Intellectual development”</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Example 4 -->
                     <div class="mb-10 p-6 rounded-xl border border-gray-200 hover:border-pink-300 transition-colors bg-pink-50/30">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="w-8 h-8 flex items-center justify-center bg-pink-100 text-pink-600 font-bold rounded-full">4</span>
                            <h3 class="text-xl font-bold text-gray-900">Mixed Methods</h3>
                        </div>
                        <div class="pl-11">
                            <div class="italic text-gray-800 font-medium mb-2 border-l-4 border-pink-500 pl-4 py-1 bg-white rounded-r">
                                "It is often argued that higher education should be oriented toward enhancing employability, while others maintain that broad intellectual learning is equally essential."
                            </div>
                             <p class="text-sm text-gray-500">
                                <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Menggunakan pasif (“It is often argued”) + sinonim (“employability”) + perubahan struktur kalimat.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card 2: Exercises -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-8">Latihan (Exercises)</h2>
                
                <div class="space-y-12">

                <!-- Latihan 1 -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Latihan 1 — Pendidikan</h3>
                    <div class="mb-4 text-sm text-gray-600 bg-white p-4 rounded border border-gray-100">
                        <strong class="block text-gray-800 mb-1">Question:</strong>
                        Some people believe that universities should focus more on practical skills rather than theoretical knowledge. To what extent do you agree or disagree?
                    </div>
                    <p class="text-sm font-semibold text-orange-600 mb-2">Tugas:</p>
                    <p class="text-sm text-gray-600 mb-3">Tulis satu paragraf yang menjelaskan mengapa keterampilan praktis lebih penting (atau sebaliknya). Gunakan struktur 4 kalimat.</p>
                    <textarea x-model="answers.ex1" class="w-full p-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-200 focus:border-orange-400 focus:outline-none transition-all resize-y font-serif" rows="4" placeholder="Write your paragraph here..."></textarea>
                </div>

                <!-- Latihan 2 -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Latihan 2 — Teknologi dan Pekerjaan</h3>
                    <div class="mb-4 text-sm text-gray-600 bg-white p-4 rounded border border-gray-100">
                        <strong class="block text-gray-800 mb-1">Question:</strong>
                        Many people think that technology makes life easier, while others believe it makes life more complicated. Discuss both views and give your opinion.
                    </div>
                    <p class="text-sm font-semibold text-orange-600 mb-2">Tugas:</p>
                    <p class="text-sm text-gray-600 mb-3">Tulis satu paragraf yang mendukung pandangan bahwa teknologi membuat hidup lebih mudah.</p>
                    <textarea x-model="answers.ex2" class="w-full p-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-200 focus:border-orange-400 focus:outline-none transition-all resize-y font-serif" rows="4" placeholder="Write your paragraph here..."></textarea>
                </div>

                <!-- Latihan 3 -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Latihan 3 — Lingkungan</h3>
                    <div class="mb-4 text-sm text-gray-600 bg-white p-4 rounded border border-gray-100">
                        <strong class="block text-gray-800 mb-1">Question:</strong>
                        Some people say that individuals can do little to improve the environment, while others believe that individuals can make a big difference. Discuss both views and give your opinion.
                    </div>
                    <p class="text-sm font-semibold text-orange-600 mb-2">Tugas:</p>
                    <p class="text-sm text-gray-600 mb-3">Tulis satu paragraf yang menjelaskan peran individu dalam menjaga lingkungan.</p>
                    <textarea x-model="answers.ex3" class="w-full p-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-200 focus:border-orange-400 focus:outline-none transition-all resize-y font-serif" rows="4" placeholder="Write your paragraph here..."></textarea>
                </div>

                <!-- Latihan 4 -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Latihan 4 — Gaya Hidup</h3>
                    <div class="mb-4 text-sm text-gray-600 bg-white p-4 rounded border border-gray-100">
                        <strong class="block text-gray-800 mb-1">Question:</strong>
                        Nowadays, many people prefer living alone, especially in large cities. Is this a positive or negative development?
                    </div>
                    <p class="text-sm font-semibold text-orange-600 mb-2">Tugas:</p>
                    <p class="text-sm text-gray-600 mb-3">Tulis paragraf yang menjelaskan sisi negatif hidup sendirian di kota besar.</p>
                    <textarea x-model="answers.ex4" class="w-full p-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-200 focus:border-orange-400 focus:outline-none transition-all resize-y font-serif" rows="4" placeholder="Write your paragraph here..."></textarea>
                </div>

                <!-- Latihan 5 -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Latihan 5 — Media Sosial</h3>
                    <div class="mb-4 text-sm text-gray-600 bg-white p-4 rounded border border-gray-100">
                        <strong class="block text-gray-800 mb-1">Question:</strong>
                        Some people think that social media platforms have more negative effects than positive ones on society. Do you agree or disagree?
                    </div>
                    <p class="text-sm font-semibold text-orange-600 mb-2">Tugas:</p>
                    <p class="text-sm text-gray-600 mb-3">Tulis satu paragraf yang menjelaskan dampak negatif media sosial terhadap remaja.</p>
                    <textarea x-model="answers.ex5" class="w-full p-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-200 focus:border-orange-400 focus:outline-none transition-all resize-y font-serif" rows="4" placeholder="Write your paragraph here..."></textarea>
                </div>

                <!-- Latihan 6 -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Latihan 6 — Pendidikan Anak</h3>
                    <div class="mb-4 text-sm text-gray-600 bg-white p-4 rounded border border-gray-100">
                        <strong class="block text-gray-800 mb-1">Question:</strong>
                        Some people believe that children should be taught how to manage money at school. Do you agree or disagree?
                    </div>
                    <p class="text-sm font-semibold text-orange-600 mb-2">Tugas:</p>
                    <p class="text-sm text-gray-600 mb-3">Tulis satu paragraf mendukung pentingnya pelajaran keuangan untuk anak-anak.</p>
                    <textarea x-model="answers.ex6" class="w-full p-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-200 focus:border-orange-400 focus:outline-none transition-all resize-y font-serif" rows="4" placeholder="Write your paragraph here..."></textarea>
                </div>

                <!-- Latihan 7 -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Latihan 7 — Dunia Kerja</h3>
                    <div class="mb-4 text-sm text-gray-600 bg-white p-4 rounded border border-gray-100">
                        <strong class="block text-gray-800 mb-1">Question:</strong>
                        In many countries, people prefer to start their own business instead of working for a company. Why might this be the case? What are the advantages and disadvantages?
                    </div>
                    <p class="text-sm font-semibold text-orange-600 mb-2">Tugas:</p>
                    <p class="text-sm text-gray-600 mb-3">Tulis satu paragraf yang menjelaskan alasan orang lebih suka membuka bisnis sendiri.</p>
                    <textarea x-model="answers.ex7" class="w-full p-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-200 focus:border-orange-400 focus:outline-none transition-all resize-y font-serif" rows="4" placeholder="Write your paragraph here..."></textarea>
                </div>

                <!-- Latihan 8 -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Latihan 8 — Globalisasi</h3>
                    <div class="mb-4 text-sm text-gray-600 bg-white p-4 rounded border border-gray-100">
                        <strong class="block text-gray-800 mb-1">Question:</strong>
                        Some people think that globalization has brought people together, while others believe it has made cultures more similar and less unique. Discuss both views and give your opinion.
                    </div>
                    <p class="text-sm font-semibold text-orange-600 mb-2">Tugas:</p>
                    <p class="text-sm text-gray-600 mb-3">Tulis paragraf yang menjelaskan dampak negatif globalisasi terhadap budaya lokal.</p>
                    <textarea x-model="answers.ex8" class="w-full p-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-200 focus:border-orange-400 focus:outline-none transition-all resize-y font-serif" rows="4" placeholder="Write your paragraph here..."></textarea>
                </div>

                <!-- Latihan 9 -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Latihan 9 — Bahasa dan Pendidikan</h3>
                    <div class="mb-4 text-sm text-gray-600 bg-white p-4 rounded border border-gray-100">
                        <strong class="block text-gray-800 mb-1">Question:</strong>
                        Some people believe that learning a foreign language should start at primary school rather than secondary school. Do the advantages outweigh the disadvantages?
                    </div>
                    <p class="text-sm font-semibold text-orange-600 mb-2">Tugas:</p>
                    <p class="text-sm text-gray-600 mb-3">Tulis satu paragraf yang menjelaskan keuntungan belajar bahasa asing sejak SD.</p>
                    <textarea x-model="answers.ex9" class="w-full p-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-200 focus:border-orange-400 focus:outline-none transition-all resize-y font-serif" rows="4" placeholder="Write your paragraph here..."></textarea>
                </div>

                <!-- Latihan 10 -->
                <div class="bg-gray-50 rounded-xl p-6 border border-gray-200 mb-12">
                    <h3 class="font-bold text-lg text-gray-800 mb-2">Latihan 10 — Transportasi</h3>
                    <div class="mb-4 text-sm text-gray-600 bg-white p-4 rounded border border-gray-100">
                        <strong class="block text-gray-800 mb-1">Question:</strong>
                        Many cities are building more public transport systems to reduce traffic congestion. Do you think this is the best solution?
                    </div>
                    <p class="text-sm font-semibold text-orange-600 mb-2">Tugas:</p>
                    <p class="text-sm text-gray-600 mb-3">Tulis satu paragraf yang menjelaskan bagaimana transportasi umum bisa mengurangi kemacetan.</p>
                    <textarea x-model="answers.ex10" class="w-full p-4 rounded-lg border border-gray-300 focus:ring-2 focus:ring-orange-200 focus:border-orange-400 focus:outline-none transition-all resize-y font-serif" rows="4" placeholder="Write your paragraph here..."></textarea>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<x-dictionary-button />
<x-irregular-verbs-button />

<x-collocation-button />
@endsection
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('lessonIntroApp', (meetingId) => ({
            answers: {},
            init() {
                const key = 'ielts_task2_intro_autosave_' + meetingId;
                const saved = localStorage.getItem(key);
                if (saved) {
                    try { this.answers = JSON.parse(saved); } catch(e){}
                }
                this.$watch('answers', (val) => {
                    localStorage.setItem(key, JSON.stringify(val));
                });
            }
        }));
    });
</script>
