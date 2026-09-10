<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Meeting 9</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-[#F3F4FF] p-8">
    @include('components.impersonation-banner')
    @include('components.program-sidebar')
    <div class="max-w-5xl mx-auto bg-white p-8 rounded-xl shadow-sm border border-gray-100">
        <x-grammar-meeting-actions :meetingNumber="9" track="fast-track" />

        <h1 class="text-3xl font-bold text-center text-indigo-600 mb-8">Translate Paragraf (Pertemuan 9)</h1>
        
        <!-- Tips Box -->
        <div class="bg-indigo-50 border border-indigo-200 text-indigo-900 p-6 rounded-xl mb-8">
            <strong class="block mb-2 text-lg">💡 Tips:</strong>
            <p class="text-sm">Baca seluruh paragraf terlebih dahulu untuk memahami konteks sebelum menerjemahkan!</p>
            <div class="mt-3 text-xs space-y-1">
                <p>• Perhatikan tenses yang digunakan dalam setiap kalimat</p>
                <p>• Gunakan vocabulary bantuan yang disediakan</p>
                <p>• Pastikan terjemahan Anda mengalir dengan baik dalam Bahasa Inggris</p>
            </div>
        </div>

        @if($submitted)
            <div class="bg-indigo-600 text-white p-6 rounded-xl text-center mb-8 shadow-md">
                <h2 class="text-2xl font-bold mb-2">Nilai Kamu: {{ $finalScore }} / 100</h2>
                <p class="text-indigo-100">{{ $finalScore >= 80 ? 'Luar biasa!' : 'Terus berlatih!' }}</p>
            </div>
        @endif

        <form method="POST" action="{{ parse_url(route('assignments.grammar-writing.meeting9.submit'), PHP_URL_PATH) }}">
            @csrf
            
            <!-- Paragraph Translation -->
            <div class="mb-12">
                <div class="flex justify-between items-center mb-6 border-b pb-2">
                    <h3 class="text-2xl font-bold text-gray-800">Translate Paragraf</h3>
                    @if(auth()->check() && auth()->user()->isAdmin())
                    <div class="flex gap-2">
                        <button type="button" 
                            onclick="openMeeting9EditModal(
                                {{ $paragraph['db_id'] ?? 0 }}, 
                                '{{ addslashes($paragraph['id'] ?? '') }}', 
                                '{{ addslashes($paragraph['en'] ?? '') }}', 
                                'paragraph'
                            )"
                            class="w-10 h-10 flex items-center justify-center bg-yellow-100 hover:bg-yellow-200 text-yellow-600 rounded-lg transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </button>
                        @if(isset($paragraph['db_id']))
                        <form action="{{ parse_url(route('admin.grammar.question.destroy', $paragraph['db_id']), PHP_URL_PATH) }}" method="POST" onsubmit="return confirm('Hapus paragraf ini?');" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-10 h-10 flex items-center justify-center bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </form>
                        @endif
                    </div>
                    @endif
                </div>
                
                <div class="bg-gray-50 p-6 rounded-xl border-l-4 border-indigo-500 shadow-sm">
                    <div class="mb-4">
                        <strong class="block text-lg text-gray-800 mb-2">Terjemahkan paragraf berikut ke dalam Bahasa Inggris:</strong>
                        <p class="text-gray-700 leading-relaxed p-4 bg-white rounded border border-gray-200">
                            {{ $fullParagraphId }}
                        </p>
                    </div>

                    <!-- Vocabulary Button -->
                    <div class="mb-4" x-data="{ showVocab: false }">
                        <button 
                            type="button"
                            @click="showVocab = !showVocab"
                            class="w-full px-4 py-3 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded-lg transition-colors flex items-center justify-between">
                            <span>📚 Vocabulary Bantuan</span>
                            <svg 
                                :class="showVocab ? 'rotate-180' : ''" 
                                class="w-5 h-5 transition-transform" 
                                fill="none" 
                                stroke="currentColor" 
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div 
                            x-show="showVocab" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 transform -translate-y-2"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 transform translate-y-0"
                            x-transition:leave-end="opacity-0 transform -translate-y-2"
                            class="mt-3 bg-yellow-50 border border-yellow-200 p-4 rounded-lg">
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                                @foreach($paragraphVocab as $en => $id)
                                    <span class="bg-white px-3 py-1.5 rounded border border-yellow-200 text-xs text-gray-700 shadow-sm">
                                        <strong class="text-indigo-600">{{ $en }}</strong>: {{ $id }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-600 mb-1">Jawaban Anda:</label>
                        <textarea
                            name="userParagraphAnswer"
                            rows="12"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 {{ $submitted ? 'bg-gray-100 cursor-not-allowed' : '' }}"
                            placeholder="Tulis terjemahan paragraf di sini..."
                            {{ $submitted ? 'readonly' : '' }}>{{ old('userParagraphAnswer', $userParagraphAnswer) }}</textarea>
                    </div>

                    @if($submitted)
                        <div class="mt-4">
                            @if($paragraphResult['score'] >= $paragraphResult['max_score'] * 0.8)
                                <div class="text-sm font-bold text-green-600 bg-green-50 p-3 rounded border border-green-100 mb-2">
                                    ✓ Luar Biasa! Skor Paragraf: {{ $paragraphResult['score'] }} / {{ $paragraphResult['max_score'] }}
                                </div>
                            @else
                                <div class="text-sm font-bold text-red-600 bg-red-50 p-3 rounded border border-red-100 mb-2">
                                    Skor Paragraf: {{ $paragraphResult['score'] }} / {{ $paragraphResult['max_score'] }}
                                </div>
                            @endif

                            <div class="bg-white p-4 rounded border border-gray-200 text-sm leading-relaxed">
                                <strong class="block mb-2 text-gray-700">Analisis Perbedaan:</strong>
                                <div class="prose max-w-none">
                                    {!! $paragraphResult['formatted_answer'] !!}
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <strong class="block mb-1 text-gray-700">Jawaban Lengkap:</strong>
                                <p class="text-gray-600 italic">{{ $fullParagraphEn }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <div class="mt-8">
                @if(!$submitted)
                    <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-xl font-bold text-lg hover:bg-indigo-700 transition-colors shadow-lg">
                        Cek Jawaban
                    </button>
                @endif
            </div>
        </form>
        
        @if($submitted)
            <form method="POST" action="{{ parse_url(route('assignments.grammar-writing.meeting9.reset'), PHP_URL_PATH) }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full py-4 bg-gray-500 text-white rounded-xl font-bold text-lg hover:bg-gray-600 transition-colors shadow-lg">
                    Coba Lagi
                </button>
            </form>
        @endif
    </div>

    <style>
        .word-correct { color: #10b981; }
        .word-wrong { color: #ef4444; text-decoration: line-through; }
        .word-missing { color: #3b82f6; font-weight: bold; }
        .word-extra { color: #f59e0b; text-decoration: line-through; }
    </style>

    <!-- Auto-Save Script -->

    <!-- INLINE AUTO-SAVE SCRIPT -->
    <script>
    /**
     * Auto-Save Module for Grammar Writing Assignments
     * Automatically saves student progress to localStorage
     * Supports multiple input naming patterns across different meetings
     */
    const AutoSave = {
        debounceTimer: null,
        debounceDelay: 500, // milliseconds
        userId: null,
        draftSyncTimer: null,

        /**
         * Initialize auto-save for a specific meeting
         * @param {string} meetingNumber - Meeting number (e.g., '1', '2', '10')
         * @param {number} userId - Current user ID
         */
        init(meetingNumber, userId = null) {
            console.log('=== AUTO-SAVE INITIALIZATION START ===');
            console.log('Meeting Number:', meetingNumber);
            console.log('User ID:', userId);
            
            this.meetingNumber = meetingNumber;
            this.userId = userId || window.userId || 'guest';
            this.storageKey = `grammar_writing_meeting${meetingNumber}_user_${this.userId}`;
            
            console.log('Storage Key:', this.storageKey);
            console.log('LocalStorage available:', typeof localStorage !== 'undefined');

            // Check if form was submitted
            this.isSubmitted = this.checkIfSubmitted();
            console.log('Form submitted:', this.isSubmitted);

            if (this.isSubmitted) {
                // Clear localStorage after submission
                this.clearSaved();
                console.log('LocalStorage cleared after submission');
                console.log('=== AUTO-SAVE INITIALIZATION END (SUBMITTED) ===');
                return;
            }

            // Restore saved data on page load
            console.log('Attempting to restore answers...');
            this.restoreAnswers();

            // Set up auto-save listeners
            console.log('Setting up auto-save listeners...');
            this.setupAutoSave();

            console.log(`✓ Auto-save initialized successfully for meeting ${meetingNumber}`);
            console.log('=== AUTO-SAVE INITIALIZATION END ===');
        },

        /**
         * Check if form has been submitted
         */
        checkIfSubmitted() {
            // Check if inputs are readonly (server renders them readonly when submitted)
            // We strictly check for readonly attribute on text inputs to avoid false positives
            const isReadonly = document.querySelector('input[type="text"][readonly]');
            
            return !!isReadonly;
        },

        /**
         * Set up auto-save listeners on all input fields
         */
        setupAutoSave() {
            // Find all input and textarea elements in the form
            const form = document.querySelector('form[action*="/assignments/grammar-writing/meeting"][method="POST"]');
            if (!form) {
                console.log('No form found for auto-save');
                return;
            }

            const inputs = form.querySelectorAll('input[type="text"], textarea');
            console.log(`Found ${inputs.length} input fields`);

            inputs.forEach(input => {
                // Skip if readonly (already submitted)
                if (input.readOnly || input.disabled) {
                    return;
                }

                // Save immediately on every keystroke (input event)
                input.addEventListener('input', () => {
                    this.saveAnswers();
                });

                // Also save on blur (when moving to next field)
                input.addEventListener('blur', () => {
                    this.saveAnswers();
                });

                // Save on keyup as backup
                input.addEventListener('keyup', () => {
                    this.saveAnswers();
                });
            });

            console.log(`Auto-save listeners attached to ${inputs.length} fields`);
        },

        /**
         * Save all answers to localStorage
         */
        saveAnswers() {
            if (this.isSubmitted) {
                console.log('Skipping save - form already submitted');
                return;
            }

            const form = document.querySelector('form[action*="/assignments/grammar-writing/meeting"][method="POST"]');
            if (!form) {
                console.log('No form found');
                return;
            }

            const inputs = form.querySelectorAll('input[type="text"], textarea');
            const answers = {};

            inputs.forEach(input => {
                if (input.name && input.value) {
                    answers[input.name] = input.value;
                }
            });

            try {
                localStorage.setItem(this.storageKey, JSON.stringify(answers));
                this.showSaveIndicator();
            } catch (e) {
                console.error('Failed to save to localStorage:', e);
            }
        },

        queueDraftSync(form) {
            clearTimeout(this.draftSyncTimer);
            this.draftSyncTimer = setTimeout(() => {
                this.syncDraftToServer(form);
            }, this.debounceDelay);
        },

        async syncDraftToServer(form) {
            if (!form) {
                return false;
            }

            const action = form.getAttribute('action') || '';
            const match = action.match(/\/assignments\/grammar-writing\/meeting(\d+)/);
            if (!match) {
                return false;
            }

            const meetingNumber = match[1];
            const draftEndpoint = '/assignments/grammar-writing/fast-track/meeting' + meetingNumber + '/draft';
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

            const payload = {};
            const assignNestedValue = (obj, key, value) => {
                const parts = String(key).replace(/\]/g, '').split('[');
                let ref = obj;

                for (let i = 0; i < parts.length; i++) {
                    const part = parts[i];
                    const isLast = i === parts.length - 1;

                    if (isLast) {
                        ref[part] = value;
                        return;
                    }

                    if (typeof ref[part] !== 'object' || ref[part] === null) {
                        ref[part] = {};
                    }

                    ref = ref[part];
                }
            };

            new FormData(form).forEach((value, key) => {
                if (key === '_token') {
                    return;
                }

                assignNestedValue(payload, key, value);
            });

            try {
                await fetch(draftEndpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify(payload),
                    keepalive: true,
                });
                return true;
            } catch (e) {
                console.error('Failed to sync draft to server:', e);
                return false;
            }
        },

        /**
         * Restore saved answers from localStorage
         */
        restoreAnswers() {
            try {
                const savedData = localStorage.getItem(this.storageKey);
                
                if (!savedData) {
                    console.log('No saved data to restore');
                    return;
                }

                const answers = JSON.parse(savedData);
                let restoredCount = 0;

                Object.keys(answers).forEach(name => {
                    const input = document.querySelector(`input[name="${name}"], textarea[name="${name}"]`);
                    
                    if (input && !input.value && !input.readOnly) {
                        input.value = answers[name];
                        restoredCount++;
                    }
                });

                if (restoredCount > 0) {
                    console.log(`✓ Restored ${restoredCount} saved answers from localStorage`);
                    this.showRestoreIndicator(restoredCount);
                }
            } catch (e) {
                console.error('Failed to restore from localStorage:', e);
            }
        },

        /**
         * Show a brief restore indicator
         */
        showRestoreIndicator(count) {
            const indicator = document.createElement('div');
            indicator.className = 'fixed top-4 right-4 bg-blue-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-sm font-medium';
            indicator.innerHTML = `✓ ${count} jawaban dipulihkan`;
            document.body.appendChild(indicator);

            setTimeout(() => {
                indicator.style.opacity = '0';
                indicator.style.transition = 'opacity 0.3s';
                setTimeout(() => indicator.remove(), 300);
            }, 3000);
        },

        /**
         * Show a brief save indicator
         */
        showSaveIndicator() {
            // Check if indicator already exists
            let indicator = document.getElementById('auto-save-indicator');

            if (!indicator) {
                indicator = document.createElement('div');
                indicator.id = 'auto-save-indicator';
                indicator.className = 'fixed bottom-20 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-sm font-medium';
                indicator.style.transition = 'opacity 0.3s';
                indicator.innerHTML = '✓ Tersimpan otomatis';
                document.body.appendChild(indicator);
            }

            // Show indicator with animation
            indicator.style.opacity = '1';
            indicator.style.backgroundColor = '#10b981'; // green
            
            // Update text to show it's actively saving
            const now = new Date();
            const timeStr = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            indicator.innerHTML = `✓ Tersimpan ${timeStr}`;

            // Keep visible for 3 seconds
            clearTimeout(this.saveIndicatorTimeout);
            this.saveIndicatorTimeout = setTimeout(() => {
                indicator.style.opacity = '0.7'; // Semi-transparent when idle
            }, 3000);
        },

        /**
         * Clear saved data for this meeting
         */
        clearSaved() {
            try {
                localStorage.removeItem(this.storageKey);
                console.log('Cleared saved data');
            } catch (e) {
                console.error('Failed to clear localStorage:', e);
            }
        }
    };

    // Make AutoSave available globally
    window.AutoSave = AutoSave;
    AutoSave.showSaveErrorIndicator = function () {
        const indicator = document.createElement('div');
        indicator.className = 'fixed bottom-20 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 text-sm font-medium';
        indicator.style.transition = 'opacity 0.3s';
        indicator.innerHTML = '✗ Gagal menyimpan, coba lagi';
        document.body.appendChild(indicator);
        setTimeout(() => {
            indicator.style.opacity = '0';
            setTimeout(() => indicator.remove(), 300);
        }, 3000);
    };

    AutoSave.manualSave = async function () {
        const form = document.querySelector('form[action*="/assignments/grammar-writing/meeting"][method="POST"]');
        if (!form) {
            return;
        }

        const btn = document.getElementById('manual-save-btn');
        if (btn) {
            btn.dataset.originalText = btn.dataset.originalText || btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = 'Menyimpan...';
        }

        try {
            const inputs = form.querySelectorAll('input[type="text"], textarea');
            const answers = {};
            inputs.forEach((input) => {
                if (input.name && input.value) {
                    answers[input.name] = input.value;
                }
            });
            localStorage.setItem(this.storageKey, JSON.stringify(answers));
        } catch (e) {
            console.error('[ManualSave] Failed to update localStorage:', e);
        }

        const ok = await this.syncDraftToServer(form);

        if (btn) {
            btn.disabled = false;
            btn.innerHTML = btn.dataset.originalText;
        }

        if (ok) {
            this.showSaveIndicator();
        } else {
            this.showSaveErrorIndicator();
        }
    };


    // Initialize auto-save for meeting 9
    document.addEventListener('DOMContentLoaded', function() {
        const userId = {{ Auth::id() ?? 'null' }};
        if (userId && !window.location.search.includes('live_preview_for')) {
            AutoSave.init('9', userId);
        }
    });
    </script>

    <!-- Global Dispatch Scripts -->
    <script>
        window.openMeeting9EditModal = function(id, question, answer, section) {
            window.dispatchEvent(new CustomEvent('open-edit-modal-m9', { 
                detail: { type: 'edit_question', id, question, answer, section } 
            }));
        };
    </script>

    <!-- Modals -->
    <div x-data="{ 
            mode: '', 
            isOpen: false,
            // Question Fields
            qId: null, qText: '', qAns: '', qSection: ''
         }"
         @open-edit-modal-m9.window="
            isOpen = true;
            mode = $event.detail.type;
            qId = $event.detail.id;
            qText = $event.detail.question;
            qAns = $event.detail.answer;
            qSection = $event.detail.section;
         "
         x-show="isOpen" 
         x-cloak
         class="fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-50 p-4"
    >
        <div class="bg-white rounded-lg shadow-xl w-full max-w-md p-6" @click.outside="isOpen = false">
            
            <!-- ADD/EDIT QUESTION FORM -->
            <form :action="'/admin/assignments/grammar-writing/questions/' + qId" method="POST">
                @csrf
                @method('PUT')
                
                <h3 class="text-lg font-bold mb-4">Edit Paragraph</h3>
                
                <input type="hidden" name="meeting_number" value="9">
                <input type="hidden" name="section" x-model="qSection">
                
                <div class="mb-3">
                    <label class="block text-sm font-bold mb-1">Paragraph (Indonesian)</label>
                    <textarea name="question_text" x-model="qText" class="w-full border rounded p-2" rows="10" required></textarea>
                </div>
                
                <div class="mb-3">
                    <label class="block text-sm font-bold mb-1">Translation (English)</label>
                    <textarea name="correct_answer" x-model="qAns" class="w-full border rounded p-2" rows="10" required></textarea>
                </div>

                <div class="flex justify-end gap-2 mt-4">
                    <button type="button" @click="isOpen = false" class="px-4 py-2 text-gray-600">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Save</button>
                </div>
            </form>
        </div>
    </div>



    <x-live-drawing />
    @include('components.student-broadcaster')

    {{-- Consolidated Floating Helper Buttons (hidden during admin Live
         Preview - these are student-only interactive tools, not relevant
         to the admin's read-only observation view) --}}
    @if(!request()->filled('live_preview_for'))
    <div class="fixed bottom-4 right-8 z-50 flex flex-col gap-2 items-end">
        <x-dictionary-button />
        <x-conjunction-button />
        <x-preposition-button />
        <x-pronouns-button />
        <x-verb-patterns-button />
        <x-modal-button />
        <x-tenses-button />
        <x-irregular-verbs-button />
    </div>
    @endif

    @if(!$submitted)
        <div class="fixed bottom-4 z-50" style="left: 50%; transform: translateX(-50%);">
            <button type="button" id="manual-save-btn" onclick="AutoSave.manualSave()"
                class="inline-flex items-center gap-2 px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-full text-sm font-semibold shadow-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3M8 7V4a1 1 0 011-1h6a1 1 0 011 1v3M8 7h8"></path></svg>
                Save
            </button>
        </div>
    @endif

</body>
</html>