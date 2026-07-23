{{--
  PTE Practice Tracker Component
  Provides: bookmark toggle, auto-save results, stats badges
  Usage: @include('components.pte-practice-tracker', ['module' => 'mcsa', 'topicId' => $topicId])
--}}

<script>
window.PTETracker = (function () {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
    const module    = '{{ $module ?? "" }}';
    const topicId   = {{ $topicId ?? 0 }};

    let _stats = null;

    /* ── Load stats for this topic on page load ── */
    async function loadStats() {
        if (!module || !topicId) return;
        try {
            const res  = await fetch(`/pte/practice/stats/${module}/${topicId}`, { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
            if (!res.ok) return;
            _stats = await res.json();
            _applyStatsToUI(_stats);
        } catch (e) { console.warn('PTETracker: could not load stats', e); }
    }

    function _applyStatsToUI(stats) {
        // Attempt badge
        const badge = document.getElementById('pteAttemptBadge');
        if (badge && stats.attempt_count > 0) {
            badge.textContent = `Practiced (${stats.attempt_count})`;
            badge.classList.remove('hidden', 'bg-gray-200', 'text-gray-500');
            badge.classList.add('bg-blue-100', 'text-blue-700');
        } else if (badge) {
            badge.textContent = 'Not yet practiced';
            badge.classList.remove('hidden');
            badge.classList.add('bg-gray-100', 'text-gray-500');
        }

        // Avg score badge
        const avgBadge = document.getElementById('pteAvgScoreBadge');
        if (avgBadge && stats.avg_score != null) {
            avgBadge.textContent = `Avg ${stats.avg_score}`;
            avgBadge.classList.remove('hidden');
        }

        // Bookmark button
        const bookmarkBtn = document.getElementById('pteBookmarkBtn');
        if (bookmarkBtn) {
            _setBookmarkUI(bookmarkBtn, stats.bookmarked);
        }
    }

    function _setBookmarkUI(btn, bookmarked) {
        if (bookmarked) {
            btn.classList.add('text-yellow-400');
            btn.classList.remove('text-gray-400');
            btn.title = 'Remove Bookmark';
        } else {
            btn.classList.add('text-gray-400');
            btn.classList.remove('text-yellow-400');
            btn.title = 'Bookmark this question';
        }
        btn.dataset.bookmarked = bookmarked ? '1' : '0';
    }

    /* ── Save a practice result ── */
    async function saveResult({ score, maxScore, durationSeconds = 0, detail = {} }) {
        if (!module || !topicId) return;
        try {
            await fetch('/pte/practice/submit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ module, topic_id: topicId, score, max_score: maxScore, duration_seconds: durationSeconds, detail }),
            });
        } catch (e) { console.warn('PTETracker: could not save result', e); }
    }

    /* ── Toggle bookmark ── */
    async function toggleBookmark() {
        try {
            const res  = await fetch('/pte/practice/bookmark', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'X-Requested-With': 'XMLHttpRequest' },
                body: JSON.stringify({ module, topic_id: topicId }),
            });
            const data = await res.json();
            const btn  = document.getElementById('pteBookmarkBtn');
            if (btn) _setBookmarkUI(btn, data.bookmarked);
            return data.bookmarked;
        } catch (e) { console.warn('PTETracker: could not toggle bookmark', e); return false; }
    }

    /* ── Auto-init: wire bookmark button click ── */
    document.addEventListener('DOMContentLoaded', function () {
        loadStats();
        const bookmarkBtn = document.getElementById('pteBookmarkBtn');
        if (bookmarkBtn) {
            bookmarkBtn.addEventListener('click', function (e) {
                e.preventDefault();
                toggleBookmark();
            });
        }
    });

    return { saveResult, toggleBookmark, loadStats };
})();
</script>
