/**
 * PTE Academic Practice Tracking System
 * Loads and displays completion badges for practice topics
 */
(function () {
    function initPteTracking(moduleName) {
        if (!moduleName) {
            console.warn('PTE Tracking: Module name not provided');
            return;
        }

        const endpoint = `/pte/practice/stats/${moduleName}`;

        fetch(endpoint, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
            .then(res => res.ok ? res.json() : null)
            .then(data => {
                if (!data || !data.stats) return;

                Object.keys(data.stats).forEach(topicId => {
                    const stat = data.stats[topicId];
                    const card = document.querySelector(`[data-topic-card="${topicId}"]`);

                    if (!card) return;

                    const badge = card.querySelector('.topic-done-badge');
                    const scoreEl = card.querySelector('.topic-done-score');

                    if (badge && stat.attempt_count > 0) {
                        badge.classList.remove('hidden');
                        badge.classList.add('flex');

                        if (scoreEl && stat.avg_score != null) {
                            scoreEl.textContent = stat.avg_score;
                        }
                    }
                });
            })
            .catch(e => console.warn('Could not load practice stats', e));
    }

    // Export for use in templates
    window.pteTracking = {
        init: initPteTracking
    };
})();
