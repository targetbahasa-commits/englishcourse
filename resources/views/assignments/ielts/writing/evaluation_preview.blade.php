@php
    $score = floatval($aiFeedback['overall_band_score'] ?? 0);
    $messageTitle = '';
    $messageDesc = '';
    $practicalTips = [];
    
    $skillName = $type === 'speaking' ? 'berbicara' : 'menulis';
    $outputName = $type === 'speaking' ? 'ucapan' : 'tulisan';

    if ($score > 0 && $score <= 2) {
        $messageTitle = '🌱 Terima kasih telah menyelesaikan evaluasi!';
        $messageDesc = 'Perjalanan menuju skor IELTS yang tinggi dimulai dari langkah pertama. Teruslah belajar dan berlatih secara konsisten, karena setiap latihan akan membawa Anda lebih dekat ke target yang diinginkan.';
        $practicalTips = [
            $type === 'speaking' 
                ? 'Mulai berlatih merangkai kalimat sederhana saat berbicara dengan pelafalan yang jelas.' 
                : 'Mulai berlatih merangkai kalimat sederhana (Subjek + Predikat + Objek) dengan struktur yang benar.',
            'Perbanyak ' . ($type === 'speaking' ? 'mendengarkan' : 'membaca') . ' teks bahasa Inggris pendek dan hafalkan kosakata dasar sehari-hari.'
        ];
    } elseif ($score >= 2.5 && $score <= 3.5) {
        $messageTitle = '📚 Selamat telah menyelesaikan evaluasi!';
        $messageDesc = "Anda telah menunjukkan dasar kemampuan yang baik. Dengan memperkaya kosakata, memperbaiki tata bahasa, dan lebih banyak berlatih $skillName, skor yang lebih tinggi sangat mungkin Anda capai.";
        $practicalTips = [
            'Coba hubungkan kalimat-kalimat pendek menjadi kalimat majemuk menggunakan kata hubung dasar (and, but, because).',
            'Perhatikan penggunaan waktu dasar (tenses) seperti Present Tense dan Past Tense agar lebih akurat.'
        ];
    } elseif ($score >= 4 && $score <= 4.5) {
        $messageTitle = '👏 Selamat! Anda sudah berada pada tahap yang baik.';
        $messageDesc = 'Ide yang disampaikan sudah dapat dipahami, namun masih ada beberapa aspek yang dapat ditingkatkan, seperti pengembangan argumen, variasi kosakata, dan struktur kalimat. Teruslah berlatih!';
        $practicalTips = [
            'Kembangkan setiap ide utama Anda dengan memberikan alasan atau contoh spesifik yang relevan.',
            'Hindari pengulangan kata yang sama berulang kali; mulailah gunakan sinonim dasar untuk menunjukkan variasi kosakata.',
            $type === 'speaking' 
                ? 'Berlatihlah berbicara dengan alur yang jelas, menghindari jeda panjang (uhm, ah).' 
                : 'Berlatihlah menulis dalam paragraf dengan struktur yang jelas (pendahuluan, isi, penutup).'
        ];
    } elseif ($score >= 5 && $score <= 5.5) {
        $messageTitle = '⭐ Kerja yang baik!';
        $messageDesc = "Kemampuan $skillName Anda sudah cukup baik dan menunjukkan perkembangan yang positif. Dengan meningkatkan akurasi tata bahasa, kohesi, dan penggunaan kosakata yang lebih beragam, Anda dapat mencapai band yang lebih tinggi.";
        $practicalTips = [
            'Gunakan struktur kalimat majemuk bertingkat (complex sentences) lebih sering untuk menunjukkan kemampuan gramatikal Anda.',
            $type === 'speaking' 
                ? 'Pastikan ide utama yang Anda ucapkan sangat jelas dan selalu menjawab pertanyaan dari penguji.' 
                : 'Pastikan kalimat utama (topic sentence) di setiap paragraf sangat jelas dan selalu menjawab pertanyaan dari prompt.',
            $type === 'speaking'
                ? 'Perhatikan intonasi dan kejelasan pengucapan untuk meminimalkan kesalahan yang dapat mengganggu pendengar.'
                : 'Periksa kembali tulisan Anda untuk meminimalkan kesalahan gramatikal minor yang dapat mengganggu alur membaca.'
        ];
    } elseif ($score >= 6 && $score <= 6.5) {
        $messageTitle = '🎉 Selamat atas pencapaian Anda!';
        $messageDesc = "Anda telah menunjukkan kemampuan $skillName yang baik. Fokus pada ketepatan bahasa, variasi ekspresi, dan pengembangan ide akan membantu Anda mencapai level yang lebih tinggi.";
        $practicalTips = [
            'Fokus pada *Cohesion*: gunakan perangkat kohesi (linking words) secara bervariasi dan tidak mekanis/kaku.',
            'Gunakan kosa kata tingkat lanjut (*less common vocabulary*) yang relevan dengan topik, tapi pastikan penggunaannya natural.',
            $type === 'speaking'
                ? 'Berikan elaborasi yang kuat dan komprehensif atas jawaban Anda.'
                : 'Buat paragraf kesimpulan yang kuat, yang mampu merangkum seluruh argumen esensial yang telah Anda bahas.'
        ];
    } elseif ($score >= 7 && $score <= 7.5) {
        $messageTitle = '🏆 Luar biasa!';
        $messageDesc = "Kemampuan $skillName Anda sudah berada pada tingkat yang sangat baik. Terus pertahankan konsistensi dan perhatikan detail kecil agar dapat mencapai skor yang lebih tinggi lagi.";
        $practicalTips = [
            $type === 'speaking'
                ? 'Pastikan semua pertanyaan penguji terjawab dengan elaborasi yang proporsional.'
                : 'Pastikan semua poin dan instruksi spesifik dari *task prompt* terjawab sepenuhnya dan dengan porsi yang seimbang.',
            "Gunakan kolokasi kata yang sangat presisi agar $outputName Anda " . ($type === 'speaking' ? 'terdengar' : 'terbaca') . " natural layaknya penutur asli.",
            'Tunjukkan fleksibilitas penuh dalam menggunakan ragam tata bahasa kompleks dengan akurasi tinggi.'
        ];
    } elseif ($score >= 8 && $score <= 8.5) {
        $messageTitle = '🌟 Prestasi yang sangat membanggakan!';
        $messageDesc = ucfirst($outputName) . ' Anda menunjukkan kemampuan akademik yang kuat dengan komunikasi yang efektif. Sedikit penyempurnaan pada aspek minor dapat membawa Anda menuju skor terbaik.';
        $practicalTips = [
            'Pastikan penyampaian argumen mengalir sangat mulus tanpa ada elemen kohesi yang terkesan dipaksakan.',
            'Gunakan idiom atau kosakata akademis yang sangat spesifik dengan kepresisian penuh.',
            'Kurangi hingga hampir tidak ada *slip* kesalahan gramatikal sama sekali.'
        ];
    } elseif ($score == 9) {
        $messageTitle = '🥇 Selamat! Anda mencapai Band 9!';
        $messageDesc = 'Ini adalah tingkat penguasaan bahasa Inggris yang luar biasa. Kemampuan Anda menunjukkan penggunaan bahasa yang akurat, efektif, dan hampir tanpa kesalahan. Pertahankan pencapaian yang luar biasa ini!';
        $practicalTips = [
            "Teruslah " . ($type === 'speaking' ? 'mendengarkan podcast/diskusi' : 'membaca literatur/jurnal') . " berbahasa Inggris tingkat lanjut untuk menjaga insting berbahasa Anda.",
            'Anda sudah berada di level yang sangat prestisius. Pertahankan dan bagikan ilmu Anda!'
        ];
    }
    
    $eligibleScholarships = \App\Models\Scholarship::where('is_active', true)
        ->where(function($query) use ($score) {
            $query->whereNull('min_ielts')
                  ->orWhere('min_ielts', '<=', $score);
        })
        ->orderBy('deadline', 'asc')
        ->limit(3)
        ->get();
@endphp
@extends('layouts.admin')
@section('content')
<div class="fixed inset-0 z-50 bg-gray-50 flex overflow-hidden">
    <!-- Main Content -->
    <div class="flex-1 flex flex-col h-full bg-cover bg-center bg-fixed custom-scrollbar overflow-y-auto" style="background-image: url('{{ asset('images/background-container/background-kelas.png') }}');">
        <!-- Top Navigation -->
        <div class="bg-transparent px-4 md:px-6 py-4 flex flex-col xl:flex-row xl:items-center justify-between gap-4 sticky top-0 z-10">
            <div class="flex items-start md:items-center gap-4">
                <a href="{{ route('promo.test.show', ['type' => $type, 'id' => $id]) }}" class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 text-gray-600 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-red-600">Your Evaluation Results</h2>
                    <div class="flex flex-wrap items-center gap-2 mt-1">
                        <span class="text-gray-500 text-sm">Overall Band Score:</span>
                        <span class="px-3 py-0.5 bg-blue-100 text-red-700 font-bold rounded-full text-lg">{{ $aiFeedback['overall_band_score'] ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
            
            <!-- WhatsApp Summary Compact -->
            <div class="flex items-center w-full xl:w-auto xl:mx-4 gap-3" x-data="{ 
                waNumber: '', 
                loading: false, 
                sent: false, 
                errorMsg: '',
                sendWa() {
                    if(!this.waNumber) return;
                    this.loading = true;
                    this.errorMsg = '';
                    fetch('{{ route('promo.test.send-wa-result', ['type' => $type, 'id' => $id, 'submission_id' => $submission_id ?? $submission->id]) }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ whatsapp: this.waNumber })
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.loading = false;
                        if(data.success) {
                            this.sent = true;
                        } else {
                            this.errorMsg = data.message;
                        }
                    })
                    .catch(err => {
                        this.loading = false;
                        this.errorMsg = 'Error.';
                    });
                }
            }">
                <template x-if="!sent">
                    <div class="flex items-center gap-2 bg-blue-50 px-3 py-1.5 rounded-lg border border-blue-100">
                        <svg class="w-5 h-5 text-green-500 hidden xl:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                        <div class="mr-2 hidden md:block">
                            <span class="text-xs font-bold text-blue-900 block leading-tight">Ingin mengirim hasil evaluasi ini ke Whatsapp?</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <input type="text" x-model="waNumber" placeholder="Contoh: 08123456789" class="px-2 py-1 border border-blue-200 rounded text-sm focus:ring-blue-500 focus:border-blue-500 w-48" :disabled="loading">
                            <button @click="sendWa" :disabled="loading || !waNumber" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm font-bold flex items-center gap-1 disabled:opacity-50 transition-colors whitespace-nowrap">
                                <span x-show="!loading">Kirim</span>
                                <span x-show="loading">...</span>
                            </button>
                        </div>
                        <p x-show="errorMsg" x-text="errorMsg" class="text-red-500 text-[10px] font-bold absolute -bottom-4 right-0"></p>
                    </div>
                </template>
                <template x-if="sent">
                    <div class="bg-green-100 text-green-700 px-4 py-1.5 rounded-lg text-sm font-bold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Berhasil Terkirim!
                    </div>
                </template>
            </div>

            <!-- Score Summary Cards -->
            <div class="flex gap-4">
                 <div class="flex flex-col items-center p-3 bg-white border border-gray-100 rounded-lg shadow-sm min-w-[100px]">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">{{ $type === 'speaking' ? 'Pronunciation' : 'Task' }}</span>
                    <span class="text-xl font-bold text-red-700">{{ $aiFeedback['pronunciation_score'] ?? $aiFeedback['task_response_score'] ?? $aiFeedback['task_achievement_score'] ?? '-' }}</span>
                </div>
                 <div class="flex flex-col items-center p-3 bg-white border border-gray-100 rounded-lg shadow-sm min-w-[100px]">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">{{ $type === 'speaking' ? 'Fluency' : 'Coherence' }}</span>
                    <span class="text-xl font-bold text-red-700">{{ $aiFeedback['fluency_and_coherence_score'] ?? $aiFeedback['coherence_cohesion_score'] ?? '-' }}</span>
                </div>
                 <div class="flex flex-col items-center p-3 bg-white border border-gray-100 rounded-lg shadow-sm min-w-[100px]">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Lexical</span>
                    <span class="text-xl font-bold text-red-700">{{ $aiFeedback['lexical_resource_score'] ?? '-' }}</span>
                </div>
                 <div class="flex flex-col items-center p-3 bg-white border border-gray-100 rounded-lg shadow-sm min-w-[100px]">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wide">Grammar</span>
                    <span class="text-xl font-bold text-red-700">{{ $aiFeedback['grammatical_range_score'] ?? '-' }}</span>
                </div>
            </div>
        </div>

        <div class="p-6 flex-1 min-h-0 flex flex-col gap-6" x-data="{ tab: 'feedback', result: {{ json_encode($aiFeedback) }} }">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 flex-1 min-h-0">
                <!-- Left Column: Topic & Detailed Analysis -->
                <div class="flex flex-col gap-4 min-h-0 h-full lg:col-span-1">
                    @if($type === 'speaking')
                    <!-- Speaking Analysis: Question and Audio -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col flex-1 min-h-0">
                        <div class="p-4 border-b border-gray-100 bg-gray-50 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z"></path></svg>
                            <h3 class="font-bold text-gray-700">Transkrip & Analisis Detail</h3>
                        </div>
                        <div class="p-6 overflow-y-auto flex-1 flex flex-col gap-6">
                            @if(isset($aiFeedback['recordings']) && is_array($aiFeedback['recordings']))
                                @foreach($aiFeedback['recordings'] as $index => $rec)
                                    <div class="flex flex-col gap-2">
                                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wide">PERTANYAAN {{ $index + 1 }}</div>
                                        <div class="text-gray-800 font-medium">{{ $rec['question'] }}</div>
                                        <div class="bg-gray-50 rounded-xl p-4 mt-1 border border-gray-100">
                                            @if(!empty($rec['audio_url']))
                                                <audio controls src="{{ $rec['audio_url'] }}" class="w-full h-10 outline-none"></audio>
                                            @else
                                                <div class="text-center italic text-gray-500 text-sm">"(No answer recorded)"</div>
                                                <audio controls class="w-full h-10 outline-none opacity-50 mt-2" disabled></audio>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="text-gray-500 text-sm italic">Rekaman tidak tersedia.</div>
                            @endif
                        </div>
                    </div>
                    @else
                    <!-- Topic Card -->
                    <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 flex-shrink-0">
                        <h5 class="font-bold text-gray-800 mb-2">Topic</h5>
                        <p class="text-gray-600 text-sm leading-relaxed">{{ $prompt }}</p>
                    </div>

                    <!-- Analysis Card -->
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden flex flex-col flex-1 min-h-0">
                        <div class="p-4 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
                            <h3 class="font-bold text-gray-700">Detailed Text Analysis</h3>
                            <div class="flex items-center gap-3 text-xs font-medium">
                                <span class="bg-red-100 text-red-600 px-1 rounded">Error</span>
                                <span class="bg-yellow-200 text-gray-800 px-2 py-0.5 rounded">Improvement</span>
                            </div>
                        </div>
                        <style>
                            .detailed-analysis del { text-decoration: none; background-color: #fee2e2; color: #dc2626; padding: 0 2px; border-radius: 2px; word-break: break-word; }
                            .detailed-analysis ins { text-decoration: none; background-color: #fef08a; color: #854d0e; padding: 0 4px; border-radius: 2px; font-weight: 600; margin-left: 2px; word-break: break-word; }
                        </style>
                        <div class="detailed-analysis p-4 md:p-6 overflow-y-auto overflow-x-hidden flex-1 prose prose-sm md:prose-lg max-w-none leading-loose text-base md:text-lg text-gray-800 break-words w-full selection:bg-blue-100">
                            <div class="break-words" x-html="(() => {
                                try {
                                    const html = result?.correction_html;
                                    let isBad = false;
                                    
                                    if (!html) isBad = true;
                                    if (html === 'undefined') isBad = true;
                                    if (typeof html === 'string' && html.indexOf('undefined') !== -1) isBad = true;
                                    if (html && html.length < 15) isBad = true;

                                    if (isBad) {
                                        return '<div class=\'bg-red-50 border-2 border-red-500 p-4 rounded\'><strong>FALLBACK TRIGGERED:</strong><br>The detailed analysis HTML could not be generated. Please rely on the general feedback.</div>';
                                    }
                                    return html;
                                } catch (e) { return 'JS ERROR'; }
                            })()"></div>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Right Column: Improvements & Feedback -->
                <div class="bg-gray-50 rounded-2xl border border-gray-100 overflow-hidden flex flex-col h-full min-h-0 lg:col-span-2">
                    <!-- Tabs -->
                    <div class="flex border-b border-gray-200 bg-white overflow-x-auto no-scrollbar">
                        <button @click="tab = 'feedback'" :class="{ 'border-b-2 border-blue-500 text-blue-600': tab === 'feedback' }" class="px-4 py-3 font-semibold text-gray-500 hover:text-blue-500 transition-colors whitespace-nowrap flex-shrink-0">Examiner Feedback</button>
                        <button @click="tab = 'task_response'" :class="{ 'border-b-2 border-blue-500 text-blue-600': tab === 'task_response' }" class="px-4 py-3 font-semibold text-gray-500 hover:text-blue-500 transition-colors whitespace-nowrap flex-shrink-0">{{ $type === 'speaking' ? 'Pronunciation' : 'Task Response' }}</button>
                        <button @click="tab = 'coherence'" :class="{ 'border-b-2 border-blue-500 text-blue-600': tab === 'coherence' }" class="px-4 py-3 font-semibold text-gray-500 hover:text-blue-500 transition-colors whitespace-nowrap flex-shrink-0">{{ $type === 'speaking' ? 'Fluency & Coherence' : 'Coherence & Cohesion' }}</button>
                        <button @click="tab = 'lexical'" :class="{ 'border-b-2 border-blue-500 text-blue-600': tab === 'lexical' }" class="px-4 py-3 font-semibold text-gray-500 hover:text-blue-500 transition-colors whitespace-nowrap flex-shrink-0">Lexical</button>
                        <button @click="tab = 'grammar'" :class="{ 'border-b-2 border-blue-500 text-blue-600': tab === 'grammar' }" class="px-4 py-3 font-semibold text-gray-500 hover:text-blue-500 transition-colors whitespace-nowrap flex-shrink-0">Grammar</button>
                        <button @click="tab = 'band_9'" :class="{ 'border-b-2 border-blue-500 text-blue-600': tab === 'band_9' }" class="px-4 py-3 font-semibold text-gray-500 hover:text-blue-500 transition-colors whitespace-nowrap flex-shrink-0">Band 9 Version</button>
                    </div>

                    <div class="flex-1 overflow-y-auto flex flex-col">
                        <div class="p-6">
                        <!-- Tab 1: General Feedback -->
                        <div x-show="tab === 'feedback'" class="space-y-4">
                            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                                <h5 class="font-bold text-gray-800 mb-2">General Comments</h5>
                                <div class="text-gray-600 leading-relaxed" x-html="result?.feedback || result?.overall_comment || 'No general feedback available.'"></div>
                            </div>
                        </div>

                        <!-- Tab 2: Task Response / Pronunciation -->
                        <div x-show="tab === 'task_response'" class="space-y-4">
                            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                                <h5 class="font-bold text-gray-800 mb-1 text-sm uppercase tracking-wider">{{ $type === 'speaking' ? 'Pronunciation Detailed Feedback' : 'Task Response Detailed Feedback' }}</h5>
                                <div class="text-gray-600 text-sm prose max-w-none overflow-x-auto custom-scrollbar" x-html="result?.pronunciation || result?.task_response || result?.task_achievement || 'No specific feedback.'"></div>
                            </div>
                        </div>

                        <!-- Tab 3: Coherence / Fluency -->
                        <div x-show="tab === 'coherence'" class="space-y-4">
                            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                                <h5 class="font-bold text-gray-800 mb-1 text-sm uppercase tracking-wider">{{ $type === 'speaking' ? 'Fluency & Coherence Detailed Feedback' : 'Coherence Detailed Feedback' }}</h5>
                                <div class="text-gray-600 text-sm prose max-w-none overflow-x-auto custom-scrollbar" x-html="result?.fluency_and_coherence || result?.coherence_and_cohesion || result?.coherence_cohesion || 'No specific feedback.'"></div>
                            </div>
                        </div>
                        
                        <!-- Tab 4: Lexical -->
                        <div x-show="tab === 'lexical'" class="space-y-4">
                            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                                <h5 class="font-bold text-gray-800 mb-1 text-sm uppercase tracking-wider">Lexical Detailed Feedback</h5>
                                <div class="text-gray-600 text-sm prose max-w-none overflow-x-auto custom-scrollbar" x-html="result?.lexical_resource || 'No specific feedback.'"></div>
                            </div>
                        </div>
                        
                        <!-- Tab 5: Grammar -->
                        <div x-show="tab === 'grammar'" class="space-y-4">
                            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                                <h5 class="font-bold text-gray-800 mb-1 text-sm uppercase tracking-wider">Grammar Detailed Feedback</h5>
                                <div class="text-gray-600 text-sm prose max-w-none overflow-x-auto custom-scrollbar" x-html="result?.grammatical_range_and_accuracy || result?.grammatical_range || 'No specific feedback.'"></div>
                            </div>
                        </div>

                        <!-- Tab 6: Band 9 Version -->
                        <div x-show="tab === 'band_9'" class="space-y-4">
                            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100">
                                <h5 class="font-bold text-gray-800 mb-1 text-sm uppercase tracking-wider">Band 9 Reference Answer</h5>
                                <div class="text-gray-600 text-base prose max-w-none overflow-x-auto custom-scrollbar" x-html="result?.band_9_version || 'The Band 9 version is not available for this submission. Please submit again.'"></div>
                            </div>
                        </div>
                        </div>
                        
                        <div class="mt-4 flex flex-col">

                    <div class="flex flex-col gap-4 p-5 shrink-0 border-t border-gray-200">
                        @if(isset($messageTitle))
                        <div class="bg-blue-50 p-5 rounded-2xl border border-blue-200 flex flex-col h-full">
                            <div class="flex-1">
                                <h5 class="text-lg font-extrabold text-blue-900 mb-2">{{ $messageTitle }}</h5>
                                <p class="text-sm text-blue-800 leading-relaxed mb-3">{{ $messageDesc }}</p>
                                
                                @if(!empty($practicalTips))
                                <div class="bg-white/60 rounded-xl p-4 border border-blue-100">
                                    <h6 class="text-xs font-bold text-blue-900 uppercase tracking-wider mb-2 flex items-center gap-1.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                        Practical Tips to Improve
                                    </h6>
                                    <ul class="space-y-1.5">
                                        @foreach($practicalTips as $tip)
                                        <li class="text-sm text-blue-800 flex items-start gap-2">
                                            <span class="text-blue-500 mt-1">&bull;</span>
                                            <span class="leading-relaxed">{{ $tip }}</span>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endif

                        <!-- Scholarship Recommendations -->
                        @if(isset($eligibleScholarships) && $eligibleScholarships->isNotEmpty())
                        <div class="bg-gradient-to-br from-yellow-50 to-orange-50 p-5 rounded-2xl border border-yellow-200 flex flex-col h-full">
                            <div class="flex items-center justify-between mb-4">
                                <h3 class="text-sm font-bold text-yellow-800 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0v6"></path></svg>
                                    Peluang Beasiswa (Band {{ $score }})
                                </h3>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-3">
                            @foreach($eligibleScholarships as $scholarship)
                            <a href="{{ route('scholarships.search.show', $scholarship->id) }}" class="group block border border-yellow-200/80 rounded-xl p-4 hover:shadow-lg hover:border-yellow-400 transition-all bg-white relative overflow-hidden h-full flex flex-col">
                                <div class="absolute -right-4 -top-4 w-24 h-24 bg-yellow-100 rounded-full z-0 opacity-50 group-hover:scale-150 transition-transform duration-500"></div>
                                
                                <div class="relative z-10 flex-1 flex flex-col">
                                    <h4 class="font-extrabold text-gray-800 text-sm mb-1 group-hover:text-yellow-700 transition-colors">{{ $scholarship->title }}</h4>
                                    <p class="text-[11px] text-gray-500 mb-3 flex-1">{{ $scholarship->provider ?? 'Universitas / Institusi' }} &bull; {{ $scholarship->country ?? $scholarship->location }}</p>
                                    
                                    <div class="flex flex-col gap-2 mt-auto">
                                        <div class="flex flex-wrap items-center gap-1.5 text-[10px] font-bold">
                                            <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded-md border border-blue-200">IELTS: {{ $scholarship->min_ielts ?? 'Tanpa Minimum' }}</span>
                                            <span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded-md border border-gray-200">{{ $scholarship->level_of_study }}</span>
                                        </div>
                                        <div class="text-[11px] text-gray-500 flex items-center gap-1 pt-2 border-t border-gray-100 mt-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            Deadline: <strong class="{{ $scholarship->deadline && $scholarship->deadline->isPast() ? 'text-red-500' : 'text-green-600' }}">{{ $scholarship->deadline ? $scholarship->deadline->format('d M y') : 'TBA' }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                            </div>
                            
                            <a href="{{ route('scholarships.search.index') }}" class="mt-auto block text-center w-full py-2 bg-yellow-100 hover:bg-yellow-200 text-yellow-800 text-xs font-bold rounded-lg transition-colors border border-yellow-300">
                                Informasi beasiswa lainnya &rarr;
                            </a>
                        </div>
                        @endif
                    </div>

                    <!-- Promotional Banner -->
                    <div class="bg-gradient-to-r from-indigo-600 to-blue-500 p-5 shadow-inner text-white flex flex-col xl:flex-row items-center justify-between gap-4 shrink-0 border-t border-indigo-400">
                         <div class="flex-1">
                             <div class="flex items-center gap-2 mb-1">
                                 <span class="bg-yellow-400 text-yellow-900 text-[10px] font-extrabold px-2 py-0.5 rounded uppercase tracking-wider">Info Kelas</span>
                                 <h3 class="text-base font-bold">Ingin mengerjakan soal writing lainnya?</h3>
                             </div>
                             <p class="text-blue-50 text-xs leading-relaxed">
                                Tunggu soal gratis lainnya yang diberikan setiap hari di Tiktok, Instagram, dan WhatsApp group. <strong class="text-yellow-300">ATAU</strong> kalian bisa mendaftar kelas IELTS dan dapatkan ratusan soal dengan hasil evaluasi yang lebih mendalam.
                             </p>
                         </div>
                         <a href="{{ url('/brochure/' . (request('b') ?: 'offline')) }}" target="_blank" class="shrink-0 bg-white text-indigo-700 text-sm font-extrabold py-2 px-4 rounded-lg shadow hover:bg-gray-50 hover:scale-105 transition-all whitespace-nowrap text-center">
                             Lihat Brosur<br>Kelas
                         </a>
                    </div>
                        </div>
                    </div>
                </div> <!-- Closes Right Column -->
            </div> <!-- Closes Grid -->
        </div> <!-- Closes Main Content p-6 -->
    </div> <!-- Closes flex-1 Main Area -->
</div> <!-- Closes Fixed Inset -->
@endsection
