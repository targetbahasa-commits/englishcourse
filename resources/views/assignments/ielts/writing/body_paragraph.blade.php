@extends('layouts.admin')

@section('title', ($meeting->title ?? 'Body Paragraph') . ' - IELTS Writing Task ' . ($task ?? 1))

@section('head')
    <script src="{{ asset('js/auto-save.js') }}?v={{ time() }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
<div class="w-full max-w-[1920px] mx-auto px-6 py-8 flex flex-col min-h-screen" x-data="writingBody({{ $meeting->id }}, {{ Js::from($savedAnswers ?? []) }})">
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
        <button type="button" @click.prevent="submit()" :disabled="loading" class="px-6 py-2 bg-orange-600 text-white font-bold rounded-lg shadow-md hover:bg-orange-700 transition-colors flex items-center gap-2">
            <span x-show="!loading">Submit Answers</span>
            <span x-show="loading">Saving...</span>
        </button>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 items-start pb-32 w-full">
        <!-- Left Column: Reference (Sticky) -->
        <div class="lg:col-span-5 sticky top-6 self-start space-y-6 max-h-[calc(100vh-2rem)] overflow-y-auto pr-2 custom-scrollbar">
            <!-- Theory Box -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-indigo-50 px-6 py-4 border-b border-indigo-100">
                    <h2 class="text-lg font-bold text-indigo-900">How to Write Body Paragraphs</h2>
                </div>
                <div class="p-6 text-gray-700 space-y-4 text-sm leading-relaxed">
                    <p>
                        The body paragraphs are where you describe the data in detail. You should usually write <strong>two body paragraphs</strong>.
                    </p>
                    <p>
                        <strong>Step 1: Group the Data</strong><br>
                        Don't just list everything. Group similar items together.
                        <ul class="list-disc pl-5 mt-1 space-y-1">
                            <li><strong>By Trend:</strong> Increasing lines vs. Decreasing lines.</li>
                            <li><strong>By Magnitude:</strong> Highest values vs. Lowest values.</li>
                            <li><strong>By Category:</strong> Similar items vs. Different items.</li>
                        </ul>
                    </p>
                    <p>
                        <strong>Step 2: Structure</strong><br>
                        Start each paragraph with a <strong>Topic Sentence</strong> that introduces what the paragraph is about (e.g., "Regarding the food consumption..."). Then provide specific data to support your description.
                    </p>

                    <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-100 mt-4">
                        <h4 class="font-bold text-yellow-800 mb-2">Tips for High Score:</h4>
                        <ul class="list-disc pl-5 space-y-1 text-yellow-900">
                            <li>Don't describe every single number. Select key features.</li>
                            <li>Use connecting words (In contrast, However, Similarly).</li>
                            <li>Vary your vocabulary for "increase" (rise, climb, grow) and "decrease" (fall, drop, decline).</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Practice -->
        <div class="lg:col-span-7 space-y-8 sticky top-6 self-start max-h-[calc(100vh-2rem)] overflow-y-auto pr-2 custom-scrollbar">
            
            <!-- Exercise 1 -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-blue-50 px-6 py-4 border-b border-blue-100">
                    <h3 class="text-lg font-bold text-blue-800">Exercise 1: Grouping by Trend</h3>
                    <p class="text-sm text-blue-600 mt-1">Topic: Fast food consumption. Write a body paragraph describing the items that <strong>increased</strong> (Pizza & Hamburgers).</p>
                </div>
                <div class="py-6 px-2 border-b border-gray-100">
                     <div class="w-full relative h-[500px] min-h-[500px]">
                         <canvas id="fastFoodChart"></canvas>
                    </div>
                </div>
                <div class="p-6">
                    <label class="block text-gray-700 font-medium mb-2">Write Body Paragraph 1 (Increasing Trends):</label>
                    <textarea name="body1" x-model="answers.body1" rows="5" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 transition-all text-sm placeholder-gray-400" placeholder="Regarding the increasing trends..."></textarea>
                </div>
            </div>



        </div>
    </div>

</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    // 1. Line Chart (Fast Food) - Reusing logic
    const ctx1 = document.getElementById('fastFoodChart').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['1975', '1980', '1985', '1990', '1995', '2000'],
            datasets: [
                { label: 'Fish and Chips', data: [100, 85, 60, 50, 45, 39], borderColor: 'rgb(59, 130, 246)', backgroundColor: 'rgba(59, 130, 246, 0.1)', borderWidth: 3, tension: 0.4 },
                { label: 'Pizza', data: [10, 20, 35, 55, 70, 85], borderColor: 'rgb(239, 68, 68)', backgroundColor: 'rgba(239, 68, 68, 0.1)', borderWidth: 3, tension: 0.4 },
                { label: 'Hamburgers', data: [15, 25, 40, 50, 65, 75], borderColor: 'rgb(234, 179, 8)', backgroundColor: 'rgba(234, 179, 8, 0.1)', borderWidth: 3, tension: 0.4 }
            ]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' }, title: { display: true, text: 'Fast Food Consumption' } } }
    });


});

document.addEventListener('alpine:init', () => {
    Alpine.data('writingBody', (meetingId, savedAnswers = {}) => ({
        // Seeded from the student's last autosaved draft (see
        // IeltsWritingController::showMeeting()) - previously this always
        // started empty, so a normal page refresh looked like it had
        // wiped the student's answers even though they were already
        // safely saved server-side the whole time.
        answers: {
            body1: '',
            body2: '',
            ...(savedAnswers || {})
        },
        loading: false,
        init() {
            if (window.AutoSave) {
                window.AutoSave.init(meetingId, '{{ Auth::id() }}');
            }
            setTimeout(() => {
                const textareas = document.querySelectorAll('textarea[name^="body"]');
                textareas.forEach(el => {
                    if (el.value) {
                         this.answers[el.name] = el.value;
                    }
                });
            }, 500);

            this.$watch('answers', (val) => {
                // AutoSave handles verification
            });

            this.$root.addEventListener('input', (e) => {
                if (e.target.matches('textarea[name^="body"]')) {
                    this.queueDraftSync();
                }
            });
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
            const formattedEssay = Object.entries(this.answers)
                .filter(([, value]) => value)
                .map(([name, value]) => `${name}: ${value}`)
                .join("\n\n") || 'No answers provided';

            try {
                const response = await fetch('/assignments/ielts-academic/writing/evaluate', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content
                    },
                    body: JSON.stringify({ essay: formattedEssay, task_type: '1', meeting_id: meetingId })
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
    }));
});
</script>
@endpush
@include('assignments.ielts.writing.practice_toolbar')
@endsection
