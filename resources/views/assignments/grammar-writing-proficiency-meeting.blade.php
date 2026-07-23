<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - {{ $trackTitle }} - Meeting {{ $meetingLabel ?? $meetingNumber }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .word-correct { color: #2ecc71; font-weight: 700; }
        .word-extra { color: #3498db; font-weight: 700; text-decoration: line-through; }
        .word-missing { color: #f1c40f; font-weight: 700; }
        .word-wrong { color: #e74c3c; font-weight: 700; text-decoration: underline; }
    </style>
</head>
<body class="font-sans antialiased bg-[#F3F4FF]">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        <main class="flex-1 md:ml-64 p-4 sm:p-6 md:p-8">
            <!-- Topbar -->
            <div class="flex flex-col gap-4 md:flex-row md:justify-between md:items-center mb-6 md:mb-8">
                <div class="relative w-full md:w-96">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" class="w-full py-3 pl-10 pr-4 bg-white rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm" placeholder="Search">
                </div>
                <div class="flex items-center gap-6">
                    @include('components.topbar-action-icons')
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role) }}</p>
                        </div>
                        <div class="w-10 h-10 bg-purple-200 rounded-full overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=random" alt="User" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Header -->
            <div class="flex flex-col gap-4 md:flex-row md:justify-between md:items-center mb-8">
                <div>
                    <h2 class="text-2xl md:text-3xl font-bold text-gray-800">{{ $trackTitle }}</h2>
                    <p class="text-gray-500 text-sm">Meeting {{ $meetingLabel ?? $meetingNumber }} &mdash; {{ $topic }}</p>
                </div>
                <a href="{{ route('assignments.grammar-writing.track', 'proficiency') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-xl hover:bg-gray-50 border border-gray-200 transition-all font-medium text-sm shadow-sm group">
    <svg class="w-4 h-4 text-gray-400 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
    </svg>
    Back
</a>
                        @if(($submitted ?? false) === true)
                            <button type="submit"
                                    formaction="{{ route('assignments.grammar-writing.proficiency.meeting.reset', ['meeting' => $meetingNumber]) }}"
                                    formmethod="POST"
                                    class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-8 py-3 bg-gray-600 text-white rounded-xl font-bold hover:bg-gray-700 transition shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 104.582 9m0 0H9"></path>
                                </svg>
                                Reset Jawaban
                            </button>
                        @else
                            <button type="submit" class="w-full sm:w-auto justify-center inline-flex items-center gap-2 px-8 py-3 bg-orange-500 text-white rounded-xl font-bold hover:bg-orange-600 transition shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Kirim Jawaban
                            </button>
                        @endif
                    </div>
                </form>
            @else
                <!-- Empty State / Placeholder -->
                <div class="flex flex-col items-center justify-center min-h-[60vh]">
                    <div class="bg-white rounded-3xl shadow-sm p-16 text-center max-w-lg w-full">
                        <div class="w-20 h-20 bg-orange-100 rounded-3xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-10 h-10 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-800 mb-2">Meeting {{ $meetingLabel ?? $meetingNumber }}</h3>
                        <p class="text-orange-500 font-semibold text-lg mb-4">{{ $topic }}</p>
                        <p class="text-gray-500 text-sm leading-relaxed">
                            Konten untuk meeting ini sedang disiapkan.<br>
                            Silakan tunggu update berikutnya.
                        </p>
                        <div class="mt-8 pt-6 border-t border-gray-100">
                            <a href="{{ route('assignments.grammar-writing.track', 'proficiency') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-xl hover:bg-gray-50 border border-gray-200 transition-all font-medium text-sm shadow-sm group">
    <svg class="w-4 h-4 text-gray-400 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
    </svg>
    Back
</a>
                        </div>
                    </div>
                </div>
            @endif
        </main>
    </div>

    <form id="intro-question-create-form" method="POST" action="{{ route('admin.grammar.question.store') }}" class="hidden">
        @csrf
        <input type="hidden" name="meeting_number" id="intro-create-meeting-number">
        <input type="hidden" name="question_number" id="intro-create-question-number">
        <input type="hidden" name="section" id="intro-create-section">
        <input type="hidden" name="question_text" id="intro-create-question-text">
        <input type="hidden" name="correct_answer" id="intro-create-correct-answer">
    </form>

    <form id="intro-question-update-form" method="POST" action="" class="hidden">
        @csrf
        @method('PUT')
        <input type="hidden" name="section" id="intro-update-section">
        <input type="hidden" name="question_text" id="intro-update-question-text">
        <input type="hidden" name="correct_answer" id="intro-update-correct-answer">
    </form>

    <form id="intro-question-delete-form" method="POST" action="" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <form id="intro-paragraph-create-form" method="POST" action="{{ route('admin.grammar.question.store') }}" class="hidden">
        @csrf
        <input type="hidden" name="meeting_number" id="intro-paragraph-create-meeting-number">
        <input type="hidden" name="question_number" id="intro-paragraph-create-question-number" value="0">
        <input type="hidden" name="section" id="intro-paragraph-create-section">
        <input type="hidden" name="question_text" id="intro-paragraph-create-id-text">
        <input type="hidden" name="correct_answer" id="intro-paragraph-create-en-text">
    </form>

    <form id="intro-paragraph-update-form" method="POST" action="" class="hidden">
        @csrf
        @method('PUT')
        <input type="hidden" name="section" id="intro-paragraph-update-section">
        <input type="hidden" name="question_text" id="intro-paragraph-update-id-text">
        <input type="hidden" name="correct_answer" id="intro-paragraph-update-en-text">
    </form>

    <form id="intro-paragraph-delete-form" method="POST" action="" class="hidden">
        @csrf
        @method('DELETE')
    </form>

    <div id="intro-question-editor-modal" class="fixed inset-0 z-[100] hidden" aria-hidden="true">
        <div id="intro-question-editor-overlay" class="absolute inset-0 bg-black/50"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="w-full max-w-2xl rounded-2xl bg-white shadow-2xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-800">Editor Soal Proficiency</h3>
                    <button type="button" id="intro-question-editor-close" class="text-gray-500 hover:text-gray-700 text-sm font-semibold">Tutup</button>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <p class="text-xs text-gray-500 mb-1">Nomor Soal</p>
                        <p id="intro-question-editor-number" class="text-sm font-semibold text-gray-700">-</p>
                    </div>
                    <div>
                        <label for="intro-question-editor-text" class="block text-sm font-semibold text-gray-700 mb-1">Teks Soal (Indonesia)</label>
                        <textarea id="intro-question-editor-text" rows="4" class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400"></textarea>
                    </div>
                    <div>
                        <label for="intro-question-editor-answer" class="block text-sm font-semibold text-gray-700 mb-1">Kunci Jawaban (English)</label>
                        <textarea id="intro-question-editor-answer" rows="4" class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400"></textarea>
                    </div>
                </div>
                <div class="px-5 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-end gap-2">
                    <button type="button" id="intro-question-editor-cancel" class="px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm font-semibold hover:bg-gray-50">Batal</button>
                    <button type="button" id="intro-question-editor-save" class="px-4 py-2 rounded-lg bg-orange-500 text-white text-sm font-semibold hover:bg-orange-600">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <div id="intro-paragraph-editor-modal" class="fixed inset-0 z-[100] hidden" aria-hidden="true">
        <div id="intro-paragraph-editor-overlay" class="absolute inset-0 bg-black/50"></div>
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="w-full max-w-3xl rounded-2xl bg-white shadow-2xl border border-gray-200 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-800">Editor Paragraph Proficiency</h3>
                    <button type="button" id="intro-paragraph-editor-close" class="text-gray-500 hover:text-gray-700 text-sm font-semibold">Tutup</button>
                </div>
                <div class="p-5 space-y-4">
                    <div>
                        <label for="intro-paragraph-editor-id" class="block text-sm font-semibold text-gray-700 mb-1">Paragraf (Indonesia)</label>
                        <textarea id="intro-paragraph-editor-id" rows="7" class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>
                    </div>
                    <div>
                        <label for="intro-paragraph-editor-en" class="block text-sm font-semibold text-gray-700 mb-1">Jawaban Referensi (English)</label>
                        <textarea id="intro-paragraph-editor-en" rows="7" class="w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>
                    </div>
                </div>
                <div class="px-5 py-4 border-t border-gray-100 bg-gray-50 flex items-center justify-between gap-2">
                    <button type="button" id="intro-paragraph-editor-delete" class="px-4 py-2 rounded-lg bg-red-50 text-red-700 border border-red-200 text-sm font-semibold hover:bg-red-100 hidden">Hapus Override</button>
                    <div class="flex items-center gap-2">
                        <button type="button" id="intro-paragraph-editor-cancel" class="px-4 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 text-sm font-semibold hover:bg-gray-50">Batal</button>
                        <button type="button" id="intro-paragraph-editor-save" class="px-4 py-2 rounded-lg bg-green-600 text-white text-sm font-semibold hover:bg-green-700">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let currentIntroEditorPayload = null;
        let currentIntroParagraphPayload = null;

        function openIntroQuestionEditor(payload) {
            currentIntroEditorPayload = payload;

            document.getElementById('intro-question-editor-number').textContent = `Meeting ${payload.meetingNumber} - Soal ${payload.questionNumber}`;
            document.getElementById('intro-question-editor-text').value = payload.questionText || '';
            document.getElementById('intro-question-editor-answer').value = payload.correctAnswer || '';

            const modal = document.getElementById('intro-question-editor-modal');
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');

            setTimeout(() => {
                document.getElementById('intro-question-editor-text').focus();
            }, 0);
        }

        function closeIntroQuestionEditor() {
            const modal = document.getElementById('intro-question-editor-modal');
            modal.classList.add('hidden');
            modal.setAttribute('aria-hidden', 'true');
            currentIntroEditorPayload = null;
        }

        function saveIntroQuestionEditor() {
            if (!currentIntroEditorPayload) {
                return;
            }

            const trimmedQuestionText = document.getElementById('intro-question-editor-text').value.trim();
            const trimmedCorrectAnswer = document.getElementById('intro-question-editor-answer').value.trim();

            if (!trimmedQuestionText || !trimmedCorrectAnswer) {
                window.alert('Soal dan kunci jawaban wajib diisi.');
                return;
            }

            if (currentIntroEditorPayload.dbId) {
                const updateForm = document.getElementById('intro-question-update-form');
                updateForm.action = `/admin/assignments/grammar-writing/questions/${currentIntroEditorPayload.dbId}`;
                document.getElementById('intro-update-section').value = `proficiency_${currentIntroEditorPayload.meetingNumber}`;
                document.getElementById('intro-update-question-text').value = trimmedQuestionText;
                document.getElementById('intro-update-correct-answer').value = trimmedCorrectAnswer;
                updateForm.submit();
                return;
            }

            const createForm = document.getElementById('intro-question-create-form');
            document.getElementById('intro-create-meeting-number').value = currentIntroEditorPayload.meetingNumber;
            document.getElementById('intro-create-question-number').value = currentIntroEditorPayload.questionNumber;
            document.getElementById('intro-create-section').value = `proficiency_${currentIntroEditorPayload.meetingNumber}`;
            document.getElementById('intro-create-question-text').value = trimmedQuestionText;
            document.getElementById('intro-create-correct-answer').value = trimmedCorrectAnswer;
            createForm.submit();
        }

        function deleteIntroQuestionOverride(dbId) {
            if (!window.confirm('Hapus override soal ini? Soal akan kembali ke default.')) {
                return;
            }

            const deleteForm = document.getElementById('intro-question-delete-form');
            deleteForm.action = `/admin/assignments/grammar-writing/questions/${dbId}`;
            deleteForm.submit();
        }

        function openIntroParagraphEditor(payload) {
            currentIntroParagraphPayload = payload;

            document.getElementById('intro-paragraph-editor-id').value = payload.paragraphId || '';
            document.getElementById('intro-paragraph-editor-en').value = payload.paragraphEn || '';

            const deleteButton = document.getElementById('intro-paragraph-editor-delete');
            if (payload.dbId) {
                deleteButton.classList.remove('hidden');
            } else {
                deleteButton.classList.add('hidden');
            }

            const modal = document.getElementById('intro-paragraph-editor-modal');
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');

            setTimeout(() => {
                document.getElementById('intro-paragraph-editor-id').focus();
            }, 0);
        }

        function closeIntroParagraphEditor() {
            const modal = document.getElementById('intro-paragraph-editor-modal');
            modal.classList.add('hidden');
            modal.setAttribute('aria-hidden', 'true');
            currentIntroParagraphPayload = null;
        }

        function saveIntroParagraphEditor() {
            if (!currentIntroParagraphPayload) {
                return;
            }

            const paragraphId = document.getElementById('intro-paragraph-editor-id').value.trim();
            const paragraphEn = document.getElementById('intro-paragraph-editor-en').value.trim();

            if (!paragraphId || !paragraphEn) {
                window.alert('Paragraf Indonesia dan jawaban English wajib diisi.');
                return;
            }

            if (currentIntroParagraphPayload.dbId) {
                const updateForm = document.getElementById('intro-paragraph-update-form');
                updateForm.action = `/admin/assignments/grammar-writing/questions/${currentIntroParagraphPayload.dbId}`;
                document.getElementById('intro-paragraph-update-section').value = `proficiency_${currentIntroParagraphPayload.meetingNumber}_paragraph`;
                document.getElementById('intro-paragraph-update-id-text').value = paragraphId;
                document.getElementById('intro-paragraph-update-en-text').value = paragraphEn;
                updateForm.submit();
                return;
            }

            const createForm = document.getElementById('intro-paragraph-create-form');
            document.getElementById('intro-paragraph-create-meeting-number').value = currentIntroParagraphPayload.meetingNumber;
            document.getElementById('intro-paragraph-create-section').value = `proficiency_${currentIntroParagraphPayload.meetingNumber}_paragraph`;
            document.getElementById('intro-paragraph-create-id-text').value = paragraphId;
            document.getElementById('intro-paragraph-create-en-text').value = paragraphEn;
            createForm.submit();
        }

        function deleteIntroParagraphOverride() {
            if (!currentIntroParagraphPayload || !currentIntroParagraphPayload.dbId) {
                return;
            }

            if (!window.confirm('Hapus override paragraf ini? Paragraf akan kembali ke default.')) {
                return;
            }

            const deleteForm = document.getElementById('intro-paragraph-delete-form');
            deleteForm.action = `/admin/assignments/grammar-writing/questions/${currentIntroParagraphPayload.dbId}`;
            deleteForm.submit();
        }

        document.getElementById('intro-question-editor-save')?.addEventListener('click', saveIntroQuestionEditor);
        document.getElementById('intro-question-editor-cancel')?.addEventListener('click', closeIntroQuestionEditor);
        document.getElementById('intro-question-editor-close')?.addEventListener('click', closeIntroQuestionEditor);
        document.getElementById('intro-question-editor-overlay')?.addEventListener('click', closeIntroQuestionEditor);

        document.getElementById('intro-paragraph-editor-save')?.addEventListener('click', saveIntroParagraphEditor);
        document.getElementById('intro-paragraph-editor-cancel')?.addEventListener('click', closeIntroParagraphEditor);
        document.getElementById('intro-paragraph-editor-close')?.addEventListener('click', closeIntroParagraphEditor);
        document.getElementById('intro-paragraph-editor-overlay')?.addEventListener('click', closeIntroParagraphEditor);
        document.getElementById('intro-paragraph-editor-delete')?.addEventListener('click', deleteIntroParagraphOverride);

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                const modal = document.getElementById('intro-question-editor-modal');
                if (modal && !modal.classList.contains('hidden')) {
                    closeIntroQuestionEditor();
                }

                const paragraphModal = document.getElementById('intro-paragraph-editor-modal');
                if (paragraphModal && !paragraphModal.classList.contains('hidden')) {
                    closeIntroParagraphEditor();
                }
            }
        });
    </script>

    <x-irregular-verbs-button />

    @if((int) ($meetingNumber ?? 0) === 10)
        <x-pronouns-button />
    @endif
    @include('components.student-broadcaster')
</body>
</html>
