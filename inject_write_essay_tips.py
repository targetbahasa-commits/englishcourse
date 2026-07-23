import sys
import re

content = """
            {{-- Floating Tips Button --}}
            <div x-data="{ 
                showTips: false,
                isDragged: false,
                dragging: false,
                x: window.innerWidth / 2 - 50,
                y: window.innerHeight - 100,
                startX: 0,
                startY: 0,
                start(e) {
                    this.dragging = true;
                    this.isDragged = false;
                    let clientX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
                    let clientY = e.type.includes('mouse') ? e.clientY : e.touches[0].clientY;
                    this.startX = clientX - this.x;
                    this.startY = clientY - this.y;
                },
                move(e) {
                    if (!this.dragging) return;
                    e.preventDefault();
                    this.isDragged = true;
                    let clientX = e.type.includes('mouse') ? e.clientX : e.touches[0].clientX;
                    let clientY = e.type.includes('mouse') ? e.clientY : e.touches[0].clientY;
                    this.x = clientX - this.startX;
                    this.y = clientY - this.startY;
                    
                    // Keep within screen bounds
                    this.x = Math.max(0, Math.min(this.x, window.innerWidth - 60));
                    this.y = Math.max(0, Math.min(this.y, window.innerHeight - 60));
                },
                end() {
                    this.dragging = false;
                    // Reset position if dragged out of bounds
                    if (this.x < 0) this.x = 0;
                    if (this.y < 0) this.y = 0;
                    if (this.x > window.innerWidth - 60) this.x = window.innerWidth - 60;
                    if (this.y > window.innerHeight - 60) this.y = window.innerHeight - 60;
                }
            }" 
            @mousemove.window="move" @mouseup.window="end" @touchmove.window="move" @touchend.window="end">
                <button @click.prevent="if(!isDragged) showTips = true" 
                        @mousedown="start" @touchstart="start"
                        class="fixed z-50 text-white p-4 rounded-full shadow-2xl flex items-center gap-2 select-none"
                        :style="`left: ${x}px; top: ${y}px; background-color: #eab308; touch-action: none;`"
                        :class="dragging ? 'cursor-grabbing scale-105' : 'cursor-grab hover:scale-105 transition-transform'"
                        title="Tips & Strategi">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-bold hidden md:inline text-white">Tips</span>
                </button>

                {{-- Tips Modal --}}
                <template x-teleport="body">
                    <div x-show="showTips" style="display: none;" class="fixed inset-0 bg-transparent z-[100] flex items-center justify-center p-4">
                        <div @click.away="showTips = false" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform scale-95" x-transition:enter-end="opacity-100 transform scale-100" class="bg-white rounded-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden flex flex-col shadow-2xl border border-gray-200">
                            <div class="flex items-center justify-between p-6 border-b border-blue-100 bg-blue-50 shrink-0">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-xl font-bold text-blue-900">Tips Write Essay</h2>
                                        <p class="text-blue-600 text-sm">Panduan dan format jawaban Anda.</p>
                                    </div>
                                </div>
                                <button @click="showTips = false" class="text-blue-400 hover:text-blue-600 hover:bg-blue-100 p-2 rounded-full transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                            <div class="p-6 overflow-y-auto bg-gray-50 flex-1">

                                <div class="bg-white rounded-xl border border-blue-100 shadow-sm overflow-hidden mb-6">
                                    <div class="bg-blue-50 px-4 py-3 border-b border-blue-100">
                                        <h4 class="font-bold text-blue-900">Struktur Umum</h4>
                                    </div>
                                    <div class="p-4 text-blue-800 leading-relaxed text-sm sm:text-base space-y-4">
                                        <div>
                                            <h5 class="font-bold text-lg mb-1">AWALAN</h5>
                                            <p>These days, <span class="text-amber-600 font-bold">[pernyataan esai, parafrasekan soal esai atau sebutkan secara singkat apa yang akan Anda tulis di BP1 & BP2]</span>. In this essay, the discussion will shed light on the <span class="text-amber-600 font-bold">(pilih salah satu: aspek-aspek / sebab dan akibat / masalah dan solusi / keuntungan dan kerugian)</span> of <span class="text-amber-600 font-bold">[nama topik esai]</span> to provide a balanced and well-reasoned perspective.</p>
                                        </div>
                                        <div>
                                            <h5 class="font-bold text-lg mb-1">PERSPEKTIF</h5>
                                            <p>To begin with, there are numerous <span class="text-amber-600 font-bold">(pilih salah satu: aspek-aspek / keuntungan / kekurangan)</span> of <span class="text-amber-600 font-bold">[nama topik]</span>, such as <span class="text-amber-600 font-bold">[contoh: poin 1-bisa berupa keuntungan atau kekurangan]</span>. This is evident because <span class="text-amber-600 font-bold">[poin-poin pendukung atau alasan untuk memperkuat pernyataan di kalimat sebelumnya]</span>. For example, studies have shown that <span class="text-amber-600 font-bold">[contoh nyata atau data statistik yang berkaitan dengan poin yang disebutkan]</span>. Moreover, <span class="text-amber-600 font-bold">[poin pendukung tambahan keempat]</span>. To conclude, the aspects discussed above clearly support my viewpoint.</p>
                                        </div>
                                        <div>
                                            <h5 class="font-bold text-lg mb-1">SUDUT PANDANG KALIAN</h5>
                                            <p><span class="text-amber-600 font-bold">Besides, another significant point is that (Gunakan jika mendukung BP1) / On the other hand, one significant (pilih salah satu: poin / aspek / faktor / sebab / akibat / manfaat / kekurangan / tantangan) is that</span> <span class="text-amber-600 font-bold">[perkenalkan ide atau argumen kedua Anda]</span>. This means that <span class="text-amber-600 font-bold">[berikan ide pendukung atau penjelasan dari argumen kedua]</span>. For instance, <span class="text-amber-600 font-bold">[berikan contoh yang relevan dengan argumen kedua]</span>. Overall, these factors demonstrate that <span class="text-amber-600 font-bold">(nama topik)</span> significantly influences perspectives regarding <span class="text-amber-600 font-bold">(ide utama atau kesimpulan dari paragraf badan esai ini)</span>.</p>
                                        </div>
                                        <div>
                                            <h5 class="font-bold text-lg mb-1">KESIMPULAN</h5>
                                            <p>In conclusion, this topic involves various <span class="text-amber-600 font-bold">(pilih salah satu: aspek / sebab / akibat / tantangan dan solusi)</span> that deserve attention. From my perspective, <span class="text-amber-600 font-bold">[tulis ulang/parafrasekan posisi atau opini Anda terhadap topik ini]</span>. Addressing its use in a way that benefits individuals and communities, while mitigating its misuse, can ensure balanced and constructive outcomes for society.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="bg-white rounded-xl border border-blue-100 shadow-sm overflow-hidden mb-6">
                                    <div class="bg-blue-50 px-4 py-3 border-b border-blue-100">
                                        <h4 class="font-bold text-blue-900">Contoh Pemakaian Struktur</h4>
                                    </div>
                                    <div class="p-4 text-blue-800 leading-relaxed text-sm sm:text-base space-y-4">
                                        <p>“These days, <span class="text-amber-600 font-bold">[the integration of technological tools like Artificial Intelligence in educational settings has become a highly debated topic]</span>. In this essay, the discussion will shed light on the <span class="text-amber-600 font-bold">[advantages and disadvantages of Artificial Intelligence in the teaching field]</span> to provide a balanced and well-reasoned perspective.</p>
                                        <p>To begin with, there are numerous <span class="text-amber-600 font-bold">[advantages of AI]</span>, such as <span class="text-amber-600 font-bold">[automating administrative tasks for educators]</span>. This is evident because <span class="text-amber-600 font-bold">[AI tools can grade quizzes and manage student tracking efficiently.]</span> For example, studies have shown that <span class="text-amber-600 font-bold">[using AI for grading saves teachers time.]</span> Moreover, <span class="text-amber-600 font-bold">[these tools offer personalized learning paths based on student data.]</span> To conclude, the aspects discussed above clearly support my viewpoint.</p>
                                        <p>On the other hand, one significant <span class="text-amber-600 font-bold">[drawback]</span> is that <span class="text-amber-600 font-bold">[excessive reliance on AI may reduce human interaction.]</span> This means that <span class="text-amber-600 font-bold">[students might develop dependence on the technology rather than problem-solving autonomously.]</span> For instance, <span class="text-amber-600 font-bold">[lack of direct human feedback can hinder the development of soft skills.]</span> Overall, these factors demonstrate that <span class="text-amber-600 font-bold">[AI in teaching]</span> significantly influences perspectives regarding <span class="text-amber-600 font-bold">[the future role of human educators.]</span></p>
                                        <p>In conclusion, this topic involves various <span class="text-amber-600 font-bold">[advantages and drawbacks]</span> that deserve attention. From my perspective, <span class="text-amber-600 font-bold">[AI is indeed a powerful supplement to teaching, but it must be applied judiciously.]</span> Addressing its use in a way that benefits individuals and communities, while mitigating its misuse, can ensure balanced and constructive outcomes for society.”</p>
                                    </div>
                                </div>

                                <div class="bg-white rounded-xl border border-blue-100 shadow-sm overflow-hidden mb-6">
                                    <div class="bg-blue-50 px-4 py-3 border-b border-blue-100">
                                        <h4 class="font-bold text-blue-900">1. Paragraf Pengantar (Introduction)</h4>
                                    </div>
                                    <ul class="p-4 text-blue-800 leading-relaxed text-sm sm:text-base space-y-4 list-disc ml-4">
                                        <li>
                                            <strong>Kalimat 1 (Pernyataan Topik & Pendahuluan):</strong><br>
                                            <span class="inline-block mt-1"><strong>Isi:</strong> <span class="text-amber-600 font-bold">[essay statement, paraphrase the statement or mention a brief of what you are writing in BP1 & BP2]</span></span><br>
                                            <span class="inline-block mt-1"><strong>Cara Mengisi:</strong> Mulailah dengan pernyataan umum tentang topik tersebut. Parafrasekan soal esai yang diberikan, atau sebutkan secara singkat poin-poin utama yang akan Anda bahas di Paragraf Badan 1 (BP1) dan Paragraf Badan 2 (BP2).</span>
                                        </li>
                                        <li>
                                            <strong>Kalimat 2 (Tujuan Esai):</strong><br>
                                            <span class="inline-block mt-1"><strong>Isi:</strong> In this essay, the discussion will shed light on the (aspects, causes and effects, or issues and solutions, advantages and disadvantages) of <span class="text-amber-600 font-bold">[essay topic name]</span> to provide a balanced and well-reasoned perspective.</span><br>
                                            <span class="inline-block mt-1"><strong>Cara Mengisi:</strong> Pilih salah satu opsi yang paling sesuai dengan jenis esai (misalnya, pilih advantages and disadvantages jika esai meminta pandangan yang seimbang). Ganti [essay topic name] dengan nama topik utama esai Anda.</span>
                                        </li>
                                    </ul>
                                </div>

                                <div class="bg-white rounded-xl border border-blue-100 shadow-sm overflow-hidden mb-6">
                                    <div class="bg-blue-50 px-4 py-3 border-b border-blue-100">
                                        <h4 class="font-bold text-blue-900">2. Paragraf Badan 1 (BP1)</h4>
                                        <p class="text-xs text-blue-600 mt-1 italic">Wajib 4 kalimat diisi, tidak termasuk kalimat penutup</p>
                                    </div>
                                    <ul class="p-4 text-blue-800 leading-relaxed text-sm sm:text-base space-y-4 list-disc ml-4">
                                        <li>
                                            <strong>Kalimat 1 (Topik & Poin Utama 1):</strong><br>
                                            <span class="inline-block mt-1"><strong>Isi:</strong> To begin with, there are numerous (aspects/advantages/drawbacks) of (Topic name), such as <span class="text-amber-600 font-bold">[example: point 1- could be advantage or disadvantage]</span>.</span><br>
                                            <span class="inline-block mt-1"><strong>Cara Mengisi:</strong> Pilih salah satu kata transisi (aspects/advantages/drawbacks) dan masukkan nama topik. Sertakan Poin Utama 1 yang ingin Anda bahas di BP1.</span>
                                        </li>
                                        <li>
                                            <strong>Kalimat 2 (Pendukung):</strong><br>
                                            <span class="inline-block mt-1"><strong>Isi:</strong> This is evident because <span class="text-amber-600 font-bold">[supporting points for previous statement]</span>.</span><br>
                                            <span class="inline-block mt-1"><strong>Cara Mengisi:</strong> Jelaskan atau berikan alasan pendukung untuk Poin Utama 1 dari kalimat sebelumnya.</span>
                                        </li>
                                        <li>
                                            <strong>Kalimat 3 (Contoh Spesifik):</strong><br>
                                            <span class="inline-block mt-1"><strong>Isi:</strong> For example, studies have shown that <span class="text-amber-600 font-bold">[example related to the point mentioned]</span>.</span><br>
                                            <span class="inline-block mt-1"><strong>Cara Mengisi:</strong> Masukkan contoh konkret, data, atau hasil studi fiktif yang relevan untuk memperkuat argumen Anda.</span>
                                        </li>
                                        <li>
                                            <strong>Kalimat 4 (Pendukung Tambahan):</strong><br>
                                            <span class="inline-block mt-1"><strong>Isi:</strong> Moreover, <span class="text-amber-600 font-bold">[supporting point 4]</span>.</span><br>
                                            <span class="inline-block mt-1"><strong>Cara Mengisi:</strong> Tambahkan poin pendukung keempat (bisa berupa implikasi, dampak, atau elaborasi lain) untuk memastikan tercapai batas minimal 4 kalimat.</span>
                                        </li>
                                        <li>
                                            <strong>Kalimat Penutup BP1:</strong><br>
                                            <span class="inline-block mt-1"><strong>Isi:</strong> To conclude, the aspects discussed above clearly support my viewpoint.</span><br>
                                            <span class="inline-block mt-1"><strong>Cara Mengisi:</strong> Ini adalah kesimpulan mini untuk BP1, biarkan seperti apa adanya.</span>
                                        </li>
                                    </ul>
                                </div>

                                <div class="bg-white rounded-xl border border-blue-100 shadow-sm overflow-hidden mb-6">
                                    <div class="bg-blue-50 px-4 py-3 border-b border-blue-100">
                                        <h4 class="font-bold text-blue-900">3. Paragraf Badan 2 (BP2)</h4>
                                        <p class="text-xs text-blue-600 mt-1 italic">Wajib 3 kalimat diisi, tidak termasuk kalimat penutup</p>
                                    </div>
                                    <ul class="p-4 text-blue-800 leading-relaxed text-sm sm:text-base space-y-4 list-disc ml-4">
                                        <li>
                                            <strong>Kalimat 1 (Transisi & Poin Utama 2):</strong><br>
                                            <span class="inline-block mt-1"><strong>Isi:</strong> Besides, another significant point is that / On the other hand, one significant (point/aspect/ factor/ cause / effect/benefit/drawback / challenge) is that <span class="text-amber-600 font-bold">[introduce the idea/ point]</span>.</span><br>
                                            <span class="inline-block mt-1"><strong>Cara Mengisi:</strong> Gunakan Besides jika poin ini mendukung pandangan yang sama dengan BP1. Gunakan On the other hand jika poin ini menyajikan pandangan yang berlawanan (untuk esai seimbang). Pilih salah satu opsi dalam kurung dan masukkan Poin Utama 2.</span>
                                        </li>
                                        <li>
                                            <strong>Kalimat 2 (Penjelasan/Pendukung):</strong><br>
                                            <span class="inline-block mt-1"><strong>Isi:</strong> This means that <span class="text-amber-600 font-bold">[give a supporting idea]</span>.</span><br>
                                            <span class="inline-block mt-1"><strong>Cara Mengisi:</strong> Berikan penjelasan lebih lanjut atau ide pendukung untuk Poin Utama 2.</span>
                                        </li>
                                        <li>
                                            <strong>Kalimat 3 (Contoh Spesifik):</strong><br>
                                            <span class="inline-block mt-1"><strong>Isi:</strong> For instance, <span class="text-amber-600 font-bold">[relevant example]</span>.</span><br>
                                            <span class="inline-block mt-1"><strong>Cara Mengisi:</strong> Berikan contoh yang relevan. Perhatikan bahwa ini adalah singkatan dari For instance.</span>
                                        </li>
                                        <li>
                                            <strong>Kalimat Penutup BP2:</strong><br>
                                            <span class="inline-block mt-1"><strong>Isi:</strong> Overall, these factors demonstrate that (topic name) significantly influences perspectives regarding(main idea of essay).</span><br>
                                            <span class="inline-block mt-1"><strong>Cara Mengisi:</strong> Ini adalah kesimpulan mini untuk BP2, biarkan seperti apa adanya.</span>
                                        </li>
                                    </ul>
                                </div>

                                <div class="bg-white rounded-xl border border-blue-100 shadow-sm overflow-hidden mb-6">
                                    <div class="bg-blue-50 px-4 py-3 border-b border-blue-100">
                                        <h4 class="font-bold text-blue-900">4. Kesimpulan (Conclusion)</h4>
                                        <p class="text-xs text-blue-600 mt-1 italic">Tujuan bagian ini adalah untuk merangkum esai tanpa memperkenalkan ide baru.</p>
                                    </div>
                                    <ul class="p-4 text-blue-800 leading-relaxed text-sm sm:text-base space-y-4 list-disc ml-4">
                                        <li>
                                            <strong>Kalimat 1 (Ringkasan):</strong><br>
                                            <span class="inline-block mt-1"><strong>Isi:</strong> In conclusion, this topic involves various (aspects / causes / effects / challenge solutions) that deserve attention.</span><br>
                                            <span class="inline-block mt-1"><strong>Cara Mengisi:</strong> Pilih opsi yang relevan (sesuai dengan yang dipilih di Kalimat 2 Pendahuluan) untuk merangkum isu yang dibahas.</span>
                                        </li>
                                        <li>
                                            <strong>Kalimat 2 (Pernyataan Ulang Pandangan):</strong><br>
                                            <span class="inline-block mt-1"><strong>Isi:</strong> From my perspective, <span class="text-amber-600 font-bold">(paraphrase topic statement)</span>.</span><br>
                                            <span class="inline-block mt-1"><strong>Cara Mengisi:</strong> Nyatakan kembali pandangan Anda mengenai topik esai dalam kalimat yang berbeda (parafrase).</span>
                                        </li>
                                        <li>
                                            <strong>Kalimat 3 (Harapan/Rekomendasi Akhir):</strong><br>
                                            <span class="inline-block mt-1"><strong>Isi:</strong> Addressing its use in a way that benefits individuals and communities, while mitigating its misuse, can ensure balanced and constructive outcomes for society.</span><br>
                                            <span class="inline-block mt-1"><strong>Cara Mengisi:</strong> Ini berfungsi sebagai pernyataan akhir yang menekankan perlunya tindakan seimbang.</span>
                                        </li>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </template>
            </div>
"""

def insert_before_main(filepath):
    with open(filepath, 'r') as f:
        file_content = f.read()

    new_content = re.sub(r'(\s*</main>)', content + r'\1', file_content)

    with open(filepath, 'w') as f:
        f.write(new_content)

insert_before_main('resources/views/assignments/pte-academic/write-essay/index.blade.php')
insert_before_main('resources/views/assignments/pte-academic/write-essay/practice.blade.php')
print('Injected tips successfully.')
