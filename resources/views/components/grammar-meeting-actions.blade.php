@props([
    'meetingNumber' => 1,
    'track' => 'fast-track', // fast-track, introductory, complexity, proficiency
    'resetRoute' => null,
    'aiRoute' => null,
    'switchRoute' => null,
    'isAiVariation' => false,
    'aiAttempt' => 1,
    'backRoute' => null,
])

@php
    $currentUser = auth()->user();
    $isTeacherUser = $currentUser?->isTeacher() ?? false;
    $isAdminUser = $currentUser?->isAdmin() ?? false;

    // Resolve Default Routes if not explicitly provided
    if (!$resetRoute) {
        if ($track === 'introductory') {
            $resetRoute = route('assignments.grammar-writing.introductory.meeting.reset', $meetingNumber);
        } elseif ($track === 'complexity') {
            $resetRoute = route('assignments.grammar-writing.complexity.meeting.reset', $meetingNumber);
        } elseif ($track === 'proficiency') {
            $resetRoute = route('assignments.grammar-writing.proficiency.meeting.reset', $meetingNumber);
        } else {
            // Fast-Track
            if (\Illuminate\Support\Facades\Route::has('assignments.grammar-writing.meeting' . $meetingNumber . '.reset')) {
                $resetRoute = route('assignments.grammar-writing.meeting' . $meetingNumber . '.reset');
            } else {
                $resetRoute = url('/assignments/grammar-writing/fast-track/meeting' . $meetingNumber . '/reset');
            }
        }
    }

    if (!$aiRoute) {
        $aiRoute = route('assignments.grammar-writing.ai-variation');
    }

    if (!$switchRoute) {
        $switchRoute = route('assignments.grammar-writing.switch-mode');
    }

    // Check session for AI variation status if not explicitly passed
    if (!$isAiVariation) {
        $isAiVariation = session("grammar_use_ai_{$track}_{$meetingNumber}", false) 
            || session("meeting{$meetingNumber}_use_ai_variation", false);
        $aiAttempt = session("grammar_ai_attempt_{$track}_{$meetingNumber}", 1) 
            ?? session("meeting{$meetingNumber}_ai_attempt", 1);
    }
@endphp

<div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-8">
    <a href="{{ $backRoute ?? ($track !== 'fast-track' ? route('assignments.grammar-writing.track', $track) : route('assignments.grammar-writing')) }}" 
       class="inline-flex items-center gap-2 px-4 py-2 bg-white text-gray-700 rounded-xl hover:bg-gray-50 border border-gray-200 transition-all font-medium text-sm shadow-sm group">
        <svg class="w-4 h-4 text-gray-400 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
        </svg>
        Back
    </a>

    <!-- Mode Switcher & Actions -->
    <div class="flex flex-wrap items-center gap-2.5">
        <!-- Repeat Button: functional for admin, teacher, and student alike -->
        <button type="button"
                onclick="confirmRepeatExercise()"
                class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-white hover:bg-amber-50 text-gray-700 hover:text-amber-800 border border-gray-300 hover:border-amber-200 rounded-xl text-xs sm:text-sm font-semibold shadow-xs transition active:scale-95 group"
                title="Kosongkan jawaban & kerjakan ulang soal yang sama dari awal">
            <svg class="w-4 h-4 text-gray-500 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            <span>Ulangi Soal Ini</span>
        </button>

        <!-- Mode Switcher & AI Actions (Hidden for Teacher, Display Only / Non-Functional for Admin) -->
        @if(!$isTeacherUser)
            @if($isAdminUser)
                <!-- Admin Preview: AI Variation Button (Non-functional) -->
                <button type="button"
                        onclick="showAdminMockToast('Latihan Variasi Baru (AI)')"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white rounded-xl text-xs sm:text-sm font-bold shadow-md hover:shadow-lg transition cursor-pointer"
                        title="Mode Admin: Tampilan tombol Variasi AI">
                    <span>✨ Latihan Variasi Baru (AI)</span>
                    <span class="bg-white/20 px-1.5 py-0.5 rounded text-[10px] uppercase tracking-wider">New Vocab</span>
                </button>
            @else
                @if(!empty($isAiVariation))
                    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-purple-50 text-purple-700 border border-purple-200 rounded-xl text-xs font-bold shadow-xs">
                        <span>✨ Soal AI (Attempt #{{ $aiAttempt ?? 1 }})</span>
                    </div>
                    <form method="POST" action="{{ parse_url($switchRoute, PHP_URL_PATH) }}" class="inline">
                        @csrf
                        <input type="hidden" name="track" value="{{ $track }}">
                        <input type="hidden" name="meeting_number" value="{{ $meetingNumber }}">
                        <input type="hidden" name="mode" value="default">
                        <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-50 hover:bg-blue-100 text-blue-700 border border-blue-200 rounded-xl text-xs sm:text-sm font-bold shadow-xs transition group cursor-pointer" title="Tampilkan kembali bank soal asli saat ini (bukan buatan AI)">
                            <svg class="w-4 h-4 text-blue-600 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                            <span>Soal Asli</span>
                        </button>
                    </form>
                    <form method="POST" action="{{ parse_url($aiRoute, PHP_URL_PATH) }}" onsubmit="showAiLoadingModal()" class="inline">
                        @csrf
                        <input type="hidden" name="track" value="{{ $track }}">
                        <input type="hidden" name="meeting_number" value="{{ $meetingNumber }}">
                        <button type="submit" class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-gradient-to-r from-purple-600 to-indigo-600 hover:from-purple-700 hover:to-indigo-700 text-white rounded-xl text-xs sm:text-sm font-bold shadow-sm transition">
                            <span>✨ Variasi Baru Lagi</span>
                        </button>
                    </form>
                @else
                    <form method="POST" action="{{ parse_url($aiRoute, PHP_URL_PATH) }}" onsubmit="showAiLoadingModal()" class="inline">
                        @csrf
                        <input type="hidden" name="track" value="{{ $track }}">
                        <input type="hidden" name="meeting_number" value="{{ $meetingNumber }}">
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 hover:opacity-95 text-white rounded-xl text-xs sm:text-sm font-bold shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">
                            <span>✨ Latihan Variasi Baru (AI)</span>
                            <span class="bg-white/20 px-1.5 py-0.5 rounded text-[10px] uppercase tracking-wider">New Vocab</span>
                        </button>
                    </form>
                @endif
            @endif
        @endif
    </div>
</div>

@if(!empty($isAiVariation) && !$isTeacherUser)
    <div class="mb-6 bg-gradient-to-r from-purple-50 via-indigo-50 to-blue-50 border border-purple-200 p-4 rounded-2xl flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 shadow-xs">
        <div class="flex items-center gap-3">
            <span class="w-9 h-9 rounded-xl bg-purple-600 text-white flex items-center justify-center text-lg font-bold shadow-xs">✨</span>
            <div>
                <p class="text-sm font-bold text-purple-900">Mode Latihan: Soal Variasi Baru AI (Attempt #{{ $aiAttempt ?? 1 }})</p>
                <p class="text-xs text-purple-700">Soal-soal di bawah ini adalah variasi kosakata baru dari AI. Ingin kembali ke bank soal kurikulum?</p>
            </div>
        </div>
        <form method="POST" action="{{ parse_url($switchRoute, PHP_URL_PATH) }}" class="inline shrink-0">
            @csrf
            <input type="hidden" name="track" value="{{ $track }}">
            <input type="hidden" name="meeting_number" value="{{ $meetingNumber }}">
            <input type="hidden" name="mode" value="default">
            <button type="submit" class="inline-flex items-center gap-1.5 px-4 py-2 bg-white hover:bg-blue-50 text-blue-700 border border-blue-200 rounded-xl text-xs sm:text-sm font-bold shadow-xs transition">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                <span>Soal Asli</span>
            </button>
        </form>
    </div>
@endif

<!-- Repeat Confirmation Modal -->
<div id="repeatConfirmModal" class="fixed inset-0 z-[100000] bg-black/60 backdrop-blur-sm flex items-center justify-center p-4" style="display: none;">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 sm:p-7 text-center border border-gray-100 animate-in fade-in zoom-in-95">
        <div class="mx-auto flex items-center justify-center w-14 h-14 rounded-full bg-amber-50 border-4 border-amber-100 mb-4 text-amber-600">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Ulangi Latihan Soal Ini?</h3>
        <p class="text-gray-600 text-sm leading-relaxed mb-6">
            Jawaban pada halaman ini akan dikosongkan agar kamu bisa mengerjakan ulang <strong>soal yang sama</strong> dari lembar bersih.
        </p>
        <form id="repeatMeetingForm" method="POST" action="{{ parse_url($resetRoute, PHP_URL_PATH) }}">
            @csrf
            <div class="flex flex-col sm:flex-row gap-3">
                <button type="button" onclick="closeRepeatExerciseModal()" class="w-full sm:w-1/2 py-2.5 px-4 rounded-xl border border-gray-300 text-gray-700 font-semibold text-sm hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit" id="btnExecuteRepeat" class="w-full sm:w-1/2 py-2.5 px-4 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-bold text-sm shadow-md transition">
                    Ya, Ulangi Soal Ini
                </button>
            </div>
        </form>
    </div>
</div>

<!-- AI Generating Modal -->
<div id="aiLoadingModal" class="fixed inset-0 z-[100000] bg-black/70 backdrop-blur-md flex items-center justify-center p-4" style="display: none;">
    <div class="bg-white rounded-3xl p-8 max-w-sm w-full text-center shadow-2xl border border-purple-100 animate-in fade-in zoom-in-95">
        <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-purple-600 to-indigo-600 text-white flex items-center justify-center mx-auto mb-5 shadow-lg animate-bounce">
            <span class="text-2xl">✨</span>
        </div>
        <h3 class="text-xl font-bold text-gray-900 mb-2">Menyusun Soal Baru...</h3>
        <p class="text-sm text-gray-500 mb-6 leading-relaxed">AI sedang membuat variasi kalimat dan kosakata baru dengan rumus tata bahasa yang sama persis.</p>
        <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 h-full rounded-full animate-pulse w-full"></div>
        </div>
    </div>
</div>

<!-- Admin Mock Toast -->
<div id="adminMockToast" class="fixed top-5 right-5 z-[100000] bg-slate-900/95 backdrop-blur-md text-white px-5 py-3 rounded-2xl shadow-2xl border border-slate-700 flex items-center gap-3 transition-all duration-300 transform translate-y-[-100px] opacity-0 pointer-events-none">
    <span class="text-xl">ℹ️</span>
    <div>
        <p class="text-xs font-bold text-indigo-300">Mode Admin (Tampilan Sahaja)</p>
        <p class="text-xs text-gray-300" id="adminMockToastText">Tombol ini hanya aktif untuk akun student saat mengerjakan latihan.</p>
    </div>
</div>

<script>
if (typeof window.showAdminMockToast !== 'function') {
    window.showAdminMockToast = function(name) {
        const toast = document.getElementById('adminMockToast');
        const text = document.getElementById('adminMockToastText');
        if (toast && text) {
            text.innerText = `Tombol "${name}" hanya aktif untuk akun student saat mengerjakan latihan.`;
            toast.classList.remove('translate-y-[-100px]', 'opacity-0', 'pointer-events-none');
            toast.classList.add('translate-y-0', 'opacity-100');
            setTimeout(() => {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-[-100px]', 'opacity-0', 'pointer-events-none');
            }, 3000);
        }
    };
}

if (typeof window.showAiLoadingModal !== 'function') {
    window.showAiLoadingModal = function() {
        const modal = document.getElementById('aiLoadingModal');
        if (modal) modal.style.display = 'flex';
    };
}

if (typeof window.confirmRepeatExercise !== 'function') {
    window.confirmRepeatExercise = function() {
        const modal = document.getElementById('repeatConfirmModal');
        if (modal) modal.style.display = 'flex';
    };
}

if (typeof window.closeRepeatExerciseModal !== 'function') {
    window.closeRepeatExerciseModal = function() {
        const modal = document.getElementById('repeatConfirmModal');
        if (modal) modal.style.display = 'none';
    };
}

document.getElementById('repeatMeetingForm')?.addEventListener('submit', function() {
    // grammar-writing-{track}-meeting.blade.php pages (e.g. meeting2's "Translate
    // Kalimat") run their own inline autosave with a beforeunload listener that
    // re-saves the CURRENT (still-stale) form values to localStorage/server the
    // instant this reset form's navigation starts unloading the page - racing
    // and undoing the reset. syncGrammarDraft()/queueGrammarDraftSync() on that
    // page both check this flag and no-op while it's set.
    window.__grammarResetInProgress = true;
    if (window.AutoSave && typeof window.AutoSave.clearSaved === 'function') {
        try { window.AutoSave.clearSaved(); } catch(e) {}
    }
    try { localStorage.removeItem('{{ 'tb_gw_draft_' . $track . '_m' . $meetingNumber . '_' . (auth()->id() ?? 'guest') }}'); } catch(e) {}
    const btn = document.getElementById('btnExecuteRepeat');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = 'Mereset...';
    }
});
</script>