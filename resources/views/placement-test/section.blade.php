@extends('layouts.dashboard')

@php
    $steps = ['reading' => 'Reading', 'listening' => 'Listening', 'writing' => 'Writing', 'speaking' => 'Speaking'];
    $stepKeys = array_keys($steps);
    $currentIndex = array_search($section, $stepKeys);
@endphp

@section('content')
<div class="py-10">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

        <!-- Progress -->
        <div class="flex items-center justify-between mb-8">
            @foreach ($steps as $key => $label)
                <div class="flex-1 flex items-center">
                    <div class="flex flex-col items-center">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold
                            {{ $loop->index < $currentIndex ? 'bg-green-500 text-white' : ($loop->index === $currentIndex ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-500') }}">
                            {{ $loop->index + 1 }}
                        </div>
                        <span class="text-xs mt-1 font-medium {{ $loop->index === $currentIndex ? 'text-blue-600' : 'text-gray-400' }}">{{ $label }}</span>
                    </div>
                    @if (!$loop->last)
                        <div class="flex-1 h-0.5 mx-2 {{ $loop->index < $currentIndex ? 'bg-green-500' : 'bg-gray-200' }}"></div>
                    @endif
                </div>
            @endforeach
        </div>

        @if ($errors->any())
            <div class="bg-red-50 text-red-600 rounded-xl p-4 text-sm font-medium border border-red-100 mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
            @if ($section === 'reading')
                <h2 class="text-xl font-bold text-gray-900 mb-1">Reading</h2>
                <p class="text-sm text-gray-500 mb-6">Baca teks berikut lalu jawab pertanyaannya.</p>

                <form method="POST" action="{{ route('placement-test.section.submit', ['section' => 'reading']) }}" class="space-y-8">
                    @csrf
                    @foreach ($passages as $passage)
                        <div>
                            <div class="bg-gray-50 rounded-xl p-4 mb-4 text-sm text-gray-800 whitespace-pre-line">{{ $passage->passage_text }}</div>
                            @foreach ($passage->questions as $question)
                                <div class="mb-5">
                                    <p class="font-medium text-gray-900 mb-2">{{ $loop->parent->index + 1 }}.{{ $loop->iteration }}. {{ $question->question_text }}</p>
                                    <div class="space-y-2">
                                        @foreach (['A','B','C','D'] as $i => $letter)
                                            <label class="flex items-center gap-2 text-sm text-gray-700 border border-gray-200 rounded-lg px-3 py-2 cursor-pointer hover:bg-gray-50">
                                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $letter }}" required class="text-blue-600 focus:ring-blue-500">
                                                <span>{{ $letter }}. {{ $question->options[$i] ?? '' }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                    <button type="submit" class="w-full py-3 px-4 bg-blue-600 text-white rounded-xl font-bold text-sm hover:bg-blue-700">Lanjut ke Listening &rarr;</button>
                </form>

            @elseif ($section === 'listening')
                <h2 class="text-xl font-bold text-gray-900 mb-1">Listening</h2>
                <p class="text-sm text-gray-500 mb-6">Dengarkan audio berikut lalu jawab pertanyaannya.</p>

                <form method="POST" action="{{ route('placement-test.section.submit', ['section' => 'listening']) }}" class="space-y-8">
                    @csrf
                    @foreach ($banks as $bank)
                        <div>
                            @if($bank->audio_url)
                                <audio controls src="{{ $bank->audio_url }}" class="w-full mb-4"></audio>
                            @endif
                            @foreach ($bank->questions as $question)
                                <div class="mb-5">
                                    <p class="font-medium text-gray-900 mb-2">{{ $loop->parent->index + 1 }}.{{ $loop->iteration }}. {{ $question->question_text }}</p>
                                    <div class="space-y-2">
                                        @foreach (['A','B','C','D'] as $i => $letter)
                                            <label class="flex items-center gap-2 text-sm text-gray-700 border border-gray-200 rounded-lg px-3 py-2 cursor-pointer hover:bg-gray-50">
                                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $letter }}" required class="text-blue-600 focus:ring-blue-500">
                                                <span>{{ $letter }}. {{ $question->options[$i] ?? '' }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                    <button type="submit" class="w-full py-3 px-4 bg-blue-600 text-white rounded-xl font-bold text-sm hover:bg-blue-700">Lanjut ke Writing &rarr;</button>
                </form>

            @elseif ($section === 'writing')
                <h2 class="text-xl font-bold text-gray-900 mb-1">Writing</h2>
                <p class="text-sm text-gray-500 mb-6">Tulis esai singkat sesuai prompt di bawah (min. {{ $prompt->min_words }} kata).</p>

                <div class="bg-gray-50 rounded-xl p-4 mb-4 text-sm text-gray-800">{{ $prompt->prompt_text }}</div>

                <form method="POST" action="{{ route('placement-test.section.submit', ['section' => 'writing']) }}" x-data="{ text: '' }">
                    @csrf
                    <input type="hidden" name="prompt_id" value="{{ $prompt->id }}">
                    <textarea name="essay" x-model="text" rows="10" required minlength="10" class="w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-xl shadow-sm" placeholder="Tulis jawabanmu di sini..."></textarea>
                    <p class="text-xs text-gray-400 mt-1" x-text="text.trim() === '' ? '0 kata' : text.trim().split(/\s+/).length + ' kata'"></p>
                    <button type="submit" class="w-full mt-4 py-3 px-4 bg-blue-600 text-white rounded-xl font-bold text-sm hover:bg-blue-700">Lanjut ke Speaking &rarr;</button>
                </form>

            @elseif ($section === 'speaking')
                <h2 class="text-xl font-bold text-gray-900 mb-1">Speaking</h2>
                <p class="text-sm text-gray-500 mb-6">Rekam jawaban lisanmu untuk prompt di bawah ini.</p>

                <div class="bg-gray-50 rounded-xl p-4 mb-4 text-sm text-gray-800">{{ $prompt->prompt_text }}</div>

                <div x-data="speakingRecorder()" x-init="init()">
                    <form method="POST" action="{{ route('placement-test.section.submit', ['section' => 'speaking']) }}" enctype="multipart/form-data" x-ref="form" @submit="if (!recordedBlob) { $event.preventDefault(); alert('Rekam jawabanmu dulu sebelum submit.'); }">
                        @csrf
                        <input type="hidden" name="prompt_id" value="{{ $prompt->id }}">
                        <input type="file" name="audio" x-ref="fileInput" class="hidden">

                        <div class="flex flex-col items-center gap-4 py-6">
                            <button type="button" @click="toggleRecording()" class="w-20 h-20 rounded-full flex items-center justify-center text-white text-2xl shadow-lg transition-colors" :class="isRecording ? 'bg-red-600 animate-pulse' : 'bg-blue-600 hover:bg-blue-700'">
                                <span x-show="!isRecording">&#127908;</span>
                                <span x-show="isRecording">&#9632;</span>
                            </button>
                            <p class="text-sm text-gray-500" x-text="statusText"></p>
                            <audio x-show="audioUrl" :src="audioUrl" controls class="w-full"></audio>
                        </div>

                        <button type="submit" class="w-full py-3 px-4 bg-blue-600 text-white rounded-xl font-bold text-sm hover:bg-blue-700" :disabled="!recordedBlob" :class="!recordedBlob ? 'opacity-50 cursor-not-allowed' : ''">Selesai & Lihat Hasil</button>
                    </form>
                </div>

                <script>
                    function speakingRecorder() {
                        return {
                            isRecording: false,
                            mediaRecorder: null,
                            chunks: [],
                            recordedBlob: null,
                            audioUrl: null,
                            statusText: 'Tekan tombol mikrofon untuk mulai merekam.',
                            init() {},
                            async toggleRecording() {
                                if (this.isRecording) {
                                    this.mediaRecorder.stop();
                                    this.isRecording = false;
                                    return;
                                }
                                try {
                                    const stream = await navigator.mediaDevices.getUserMedia({ audio: true });
                                    this.chunks = [];
                                    this.mediaRecorder = new MediaRecorder(stream);
                                    this.mediaRecorder.ondataavailable = (e) => this.chunks.push(e.data);
                                    this.mediaRecorder.onstop = () => {
                                        this.recordedBlob = new Blob(this.chunks, { type: 'audio/webm' });
                                        this.audioUrl = URL.createObjectURL(this.recordedBlob);
                                        this.statusText = 'Rekaman selesai. Anda bisa memutar ulang atau langsung submit.';

                                        const file = new File([this.recordedBlob], 'recording.webm', { type: 'audio/webm' });
                                        const dt = new DataTransfer();
                                        dt.items.add(file);
                                        this.$refs.fileInput.files = dt.files;

                                        stream.getTracks().forEach(track => track.stop());
                                    };
                                    this.mediaRecorder.start();
                                    this.isRecording = true;
                                    this.statusText = 'Sedang merekam...';
                                } catch (e) {
                                    this.statusText = 'Gagal mengakses mikrofon. Pastikan izin mikrofon diaktifkan.';
                                }
                            }
                        };
                    }
                </script>
            @endif
        </div>
    </div>
</div>
@endsection
