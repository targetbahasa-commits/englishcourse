@extends('layouts.admin')

@section('header')
<div class="flex items-center justify-between">
    <div>
        <div class="flex items-center gap-3 text-sm text-gray-500 mb-2">
            <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <a href="{{ route('students.show', $student) }}" class="hover:text-blue-600 transition-colors">{{ $student->name }}</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-gray-900 font-medium">Current Assignment</span>
        </div>
        <div class="flex items-center gap-3">
            <h2 class="font-bold text-2xl text-gray-800">Live Assignment Snapshot</h2>
            <span id="auto-refresh-badge" class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                <span id="last-updated-text">Just now</span>
            </span>
        </div>
    </div>

    <div class="flex items-center gap-3">
        <a href="{{ route('students.index') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-50 shadow-sm transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back
        </a>
        <a href="{{ route('students.show', $student) }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-50 shadow-sm transition">
            Back to Student
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="p-8 max-w-5xl mx-auto space-y-6">
    <div class="flex items-center gap-3">
        <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('students.show', $student) }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-50 shadow-sm transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back
        </a>
        <a href="{{ route('students.show', $student) }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-50 shadow-sm transition">
            Back to Student
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Student</p>
                <p class="text-lg font-semibold text-gray-800">{{ $student->name }}</p>
                <p class="text-sm text-gray-500">{{ $student->email }}</p>
            </div>
            <div>
                <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Detected Program</p>
                <p id="program-name" class="text-lg font-semibold text-blue-700">{{ $programName }}</p>
                <p id="last-activity" class="text-sm text-gray-500">
                    Last activity:
                    @if($lastActivityAt)
                        <span id="last-activity-human">{{ $lastActivityAt->diffForHumans() }}</span>
                    @else
                        <span id="last-activity-human">N/A</span>
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <p class="text-xs uppercase tracking-wide text-gray-500 mb-2">Current Page URL</p>
        @if($activityUrl)
            <a id="activity-url" href="{{ $activityUrl }}" target="_blank" rel="noopener" class="text-sm font-medium text-blue-600 hover:text-blue-700 break-all">
                {{ $activityUrl }}
            </a>
        @else
            <p id="activity-url" class="text-sm text-gray-500">No active assignment URL detected from current session.</p>
        @endif
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="flex items-center justify-between mb-3">
            <p class="text-xs uppercase tracking-wide text-gray-500">Live Student View (Same Layout)</p>
            <div class="flex items-center gap-2">
                <button id="btn-toggle-coret" onclick="toggleCoret()" class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition-colors border border-indigo-700 shadow-sm" title="Toggle Coret-Coret Mode">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    Mode Coret-Coret
                </button>
                <button onclick="
                let frame = document.getElementById('student-live-frame');
                let url = new URL(frame.src);
                url.searchParams.set('live_preview_tick', Date.now());
                frame.src = url.toString();
                refreshSnapshot();
            " class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 hover:text-gray-900 rounded-lg transition-colors border border-gray-200 shadow-sm" title="Reload iframe and fetch latest data">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                Refresh
            </button>
            </div>
        </div>

        @if($activityUrl)
            <iframe
                id="student-live-frame"
                src="{{ $activityUrl }}{{ str_contains($activityUrl, '?') ? '&' : '?' }}live_preview_for={{ $student->id }}"
                class="w-full h-[760px] rounded-xl border border-gray-200 bg-white"
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
                title="Live student assignment page preview"
            ></iframe>
            <p class="text-xs text-gray-500 mt-3">Preview auto-reloads every 5 seconds to follow current student page.</p>
        @else
            <div class="rounded-xl border border-dashed border-gray-300 bg-gray-50 px-4 py-8 text-sm text-gray-500 text-center">
                Live preview is unavailable because current assignment URL is not detected yet.
            </div>
        @endif
    </div>

    <div id="snapshot-container" class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 space-y-4">
        <div>
            <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Source</p>
            <p id="snapshot-source" class="text-sm font-medium text-gray-700">{{ $snapshot['source'] ?? 'N/A' }}</p>
        </div>

        <div>
            <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Question</p>
            <div id="question-container" class="rounded-xl border border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-800 whitespace-pre-wrap">
                {{ $snapshot['question'] ?: 'Question data not available yet.' }}
            </div>
        </div>

        <div>
            <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Student Answer</p>
            <div id="answer-container" class="rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm text-gray-800 whitespace-pre-wrap">
                {{ $snapshot['answer'] ?: 'Answer not found yet (student may still be working or has not submitted).' }}
            </div>
        </div>

        <div id="live-items-wrapper" class="{{ !empty($snapshot['live_items']) ? '' : 'hidden' }}">
            <p class="text-xs uppercase tracking-wide text-gray-500 mb-2">Realtime Answer List</p>
            <div id="live-items-container" class="space-y-3">
                @foreach(($snapshot['live_items'] ?? []) as $item)
                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-3">
                        <p class="text-sm font-semibold text-gray-800 mb-1">
                            {{ !empty($item['question_number']) ? 'Q' . $item['question_number'] . '.' : '' }} {{ $item['question_text'] ?? 'Question' }}
                        </p>
                        @if(!empty($item['tense_answer']))
                            <p class="text-xs text-gray-600"><span class="font-semibold">Tense:</span> {{ $item['tense_answer'] }}</p>
                        @endif
                        @if(!empty($item['translation_answer']))
                            <p class="text-xs text-gray-600"><span class="font-semibold">Translation:</span> {{ $item['translation_answer'] }}</p>
                        @endif
                        @if(!empty($item['answer']))
                            <p class="text-xs text-gray-600"><span class="font-semibold">Answer:</span> {{ $item['answer'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <div id="paragraph-wrapper" class="{{ !empty($snapshot['paragraph_answer']) ? '' : 'hidden' }}">
            <p class="text-xs uppercase tracking-wide text-gray-500 mb-1">Paragraph Draft</p>
            <div id="paragraph-answer-container" class="rounded-xl border border-indigo-200 bg-indigo-50 px-4 py-3 text-sm text-gray-800 whitespace-pre-wrap">
                {{ $snapshot['paragraph_answer'] ?? '' }}
            </div>
        </div>

        @if(!empty($snapshot['submitted_at']))
            <p id="submitted-at" class="text-xs text-gray-500">Submitted at: {{ \Illuminate\Support\Carbon::parse($snapshot['submitted_at'])->format('d M Y H:i') }}</p>
        @else
            <p id="submitted-at" class="text-xs text-gray-500 hidden">Submitted at: —</p>
        @endif
    </div>
</div>

<script>
    const studentId = {{ $student->id }};
    const jsonEndpoint = `/admin/students/${studentId}/current-assignment-json`;
    let secondsSinceUpdate = 0;
    let updateInterval;
    let timerInterval;
    let iframeRefreshTick = 0;

    // Format time difference
    function formatTimeDifference(seconds) {
        if (seconds < 5) return 'Just now';
        if (seconds < 60) return `${seconds} second${seconds !== 1 ? 's' : ''} ago`;
        const minutes = Math.floor(seconds / 60);
        if (minutes < 60) return `${minutes} minute${minutes !== 1 ? 's' : ''} ago`;
        const hours = Math.floor(minutes / 60);
        return `${hours} hour${hours !== 1 ? 's' : ''} ago`;
    }

    // Update timer display
    function updateTimerDisplay() {
        secondsSinceUpdate++;
        document.getElementById('last-updated-text').textContent = formatTimeDifference(secondsSinceUpdate);
    }

    function escapeHtml(value) {
        return String(value ?? '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }

    function renderLiveItems(snapshot) {
        const wrapper = document.getElementById('live-items-wrapper');
        const container = document.getElementById('live-items-container');
        const paragraphWrapper = document.getElementById('paragraph-wrapper');
        const paragraphContainer = document.getElementById('paragraph-answer-container');

        if (!wrapper || !container || !paragraphWrapper || !paragraphContainer) {
            return;
        }

        const items = Array.isArray(snapshot.live_items) ? snapshot.live_items : [];

        if (items.length === 0) {
            wrapper.classList.add('hidden');
            container.innerHTML = '';
        } else {
            wrapper.classList.remove('hidden');
            container.innerHTML = items.map((item) => {
                const qNo = item.question_number ? `Q${escapeHtml(item.question_number)}. ` : '';
                const question = escapeHtml(item.question_text || 'Question');
                const tenseLine = item.tense_answer ? `<p class="text-xs text-gray-600"><span class="font-semibold">Tense:</span> ${escapeHtml(item.tense_answer)}</p>` : '';
                const translationLine = item.translation_answer ? `<p class="text-xs text-gray-600"><span class="font-semibold">Translation:</span> ${escapeHtml(item.translation_answer)}</p>` : '';
                const answerLine = item.answer ? `<p class="text-xs text-gray-600"><span class="font-semibold">Answer:</span> ${escapeHtml(item.answer)}</p>` : '';

                return `<div class="rounded-xl border border-gray-200 bg-gray-50 p-3"><p class="text-sm font-semibold text-gray-800 mb-1">${qNo}${question}</p>${tenseLine}${translationLine}${answerLine}</div>`;
            }).join('');
        }

        if (snapshot.paragraph_answer) {
            paragraphWrapper.classList.remove('hidden');
            paragraphContainer.textContent = snapshot.paragraph_answer;
        } else {
            paragraphWrapper.classList.add('hidden');
            paragraphContainer.textContent = '';
        }
    }

    // Fetch and update snapshot data
    async function refreshSnapshot() {
        try {
            const response = await fetch(jsonEndpoint);
            if (!response.ok) {
                console.error('Failed to refresh snapshot:', response.status);
                return;
            }

            const data = await response.json();
            
            // Update program name
            if (data.program_name) {
                document.getElementById('program-name').textContent = data.program_name;
            }

            // Update last activity
            if (data.last_activity_human) {
                document.getElementById('last-activity-human').textContent = data.last_activity_human;
            }

            // Update activity URL
            if (data.activity_url) {
                const urlElement = document.getElementById('activity-url');
                urlElement.href = data.activity_url;
                urlElement.textContent = data.activity_url;
                urlElement.className = 'text-sm font-medium text-blue-600 hover:text-blue-700 break-all';

                const openLiveView = document.getElementById('open-live-view');
                if (openLiveView) {
                    openLiveView.href = data.activity_url;
                }

                const liveFrame = document.getElementById('student-live-frame');
                if (liveFrame) {
                    const currentBaseUrl = liveFrame.src.split('?')[0];
                    const newBaseUrl = data.activity_url.split('?')[0];
                    const separator = data.activity_url.includes('?') ? '&' : '?';
                    
                    // Only reload iframe if the base URL actually changed (e.g. student moved to a new page)
                    if (currentBaseUrl !== newBaseUrl || liveFrame.src === '') {
                        liveFrame.src = `${data.activity_url}${separator}live_preview_tick=${Date.now()}&live_preview_for={{ $student->id }}`;
                    }
                }
            }

            // Update snapshot data
            if (data.snapshot) {
                const snapshot = data.snapshot;
                
                // Inject answers into iframe
                const liveFrame = document.getElementById('student-live-frame');
                if (liveFrame && liveFrame.contentWindow && snapshot.live_items) {
                    try {
                        const iframeDoc = liveFrame.contentDocument || liveFrame.contentWindow.document;
                        if (iframeDoc) {
                            snapshot.live_items.forEach(item => {
                                if (item.question_number) {
                                    const tenseInput = iframeDoc.querySelector(`input[name="userAnswers[${item.question_number}][tense]"]`);
                                    if (tenseInput && item.tense_answer) {
                                        tenseInput.value = item.tense_answer;
                                    }
                                    const transInput = iframeDoc.querySelector(`input[name="userAnswers[${item.question_number}][trans]"]`);
                                    if (transInput && item.translation_answer) {
                                        transInput.value = item.translation_answer;
                                    }
                                    const answerInput = iframeDoc.querySelector(`input[name="userAnswers[${item.question_number}]"]`);
                                    if (answerInput && item.answer) {
                                        answerInput.value = item.answer;
                                    }
                                    const radioInput = iframeDoc.querySelector(`input[name="userAnswers[${item.question_number}]"][value="${item.answer}"]`);
                                    if (radioInput) {
                                        radioInput.checked = true;
                                    }
                                }
                            });
                            
                            if (snapshot.paragraph_answer) {
                                const paragraphInput = iframeDoc.querySelector(`textarea[name="userParagraphAnswer"]`);
                                if (paragraphInput) {
                                    paragraphInput.value = snapshot.paragraph_answer;
                                }
                            }
                        }
                    } catch (e) {
                        console.log("Could not inject answers into iframe", e);
                    }
                }
                
                if (snapshot.source) {
                    document.getElementById('snapshot-source').textContent = snapshot.source;
                }

                document.getElementById('question-container').textContent = snapshot.question || 'Question data not available yet.';

                document.getElementById('answer-container').textContent = snapshot.answer || 'Answer not found yet (student may still be working or has not submitted).';

                if (snapshot.submitted_at) {
                    const submittedAtElement = document.getElementById('submitted-at');
                    submittedAtElement.textContent = `Submitted at: ${new Date(snapshot.submitted_at).toLocaleString()}`;
                    submittedAtElement.classList.remove('hidden');
                } else {
                    const submittedAtElement = document.getElementById('submitted-at');
                    submittedAtElement.classList.add('hidden');
                }

                renderLiveItems(snapshot);
            }

            // Reset timer since we got fresh data
            secondsSinceUpdate = 0;
            document.getElementById('last-updated-text').textContent = 'Just now';

        } catch (error) {
            console.error('Error refreshing snapshot:', error);
        }
    }

    // Initialize auto-refresh
    function initAutoRefresh() {
        // Initial fetch
        refreshSnapshot();

        // Update every 5 seconds
        updateInterval = setInterval(refreshSnapshot, 5000);

        // Update timer display every second
        timerInterval = setInterval(updateTimerDisplay, 1000);
    }

    // Cleanup on page unload
    window.addEventListener('beforeunload', () => {
        if (updateInterval) clearInterval(updateInterval);
        if (timerInterval) clearInterval(timerInterval);
    });

    // Start auto-refresh when page loads
    document.addEventListener('DOMContentLoaded', initAutoRefresh);

    // Mode Coret-Coret Toggler
    let coretActive = false;
    function toggleCoret() {
        let frame = document.getElementById('student-live-frame');
        if (!frame) return;
        
        // Send message to iframe
        if (frame.contentWindow) {
            frame.contentWindow.postMessage({ type: 'TOGGLE_CORET' }, '*');
        }

        // Toggle state locally
        coretActive = !coretActive;
        let btn = document.getElementById('btn-toggle-coret');
        
        // Update button UI
        if (coretActive) {
            btn.classList.replace('bg-indigo-600', 'bg-rose-500');
            btn.classList.replace('hover:bg-indigo-700', 'hover:bg-rose-600');
            btn.classList.replace('border-indigo-700', 'border-rose-600');
            btn.innerHTML = `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg> Tutup Coret-Coret`;
        } else {
            btn.classList.replace('bg-rose-500', 'bg-indigo-600');
            btn.classList.replace('hover:bg-rose-600', 'hover:bg-indigo-700');
            btn.classList.replace('border-rose-600', 'border-indigo-700');
            btn.innerHTML = `<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg> Mode Coret-Coret`;
        }
    }
</script>
@endsection
