{{--
  PTE Practice Index Tracker Component
  Fetches stats for all topics in a module and injects badges into the DOM.
  Usage: @include('components.pte-practice-index-tracker', ['module' => 'mcsa'])
--}}

<script>
document.addEventListener('DOMContentLoaded', async function () {
    const module = '{{ $module ?? "" }}';
    if (!module) return;

    try {
        const res = await fetch(`/pte/practice/stats/${module}`, {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        if (!res.ok) return;
        
        const data = await res.json();
        const stats = data.stats || {};
        const bookmarks = data.bookmarks || [];

        // Loop through all elements that represent a topic card
        document.querySelectorAll('[data-topic-id]').forEach(card => {
            const topicId = parseInt(card.getAttribute('data-topic-id'));
            const stat = stats[topicId];
            const isBookmarked = bookmarks.includes(topicId);
            
            // Find badge container
            const badgeContainer = card.querySelector('.pte-badges');
            if (!badgeContainer) return;

            let html = '';
            
            if (isBookmarked) {
                html += `<span title="Bookmarked" class="flex-shrink-0 text-yellow-400"><svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/></svg></span>`;
            }

            if (stat && stat.attempt_count > 0) {
                html += `<span class="bg-blue-100 text-blue-700 text-[10px] font-bold px-2 py-0.5 rounded-full whitespace-nowrap">Practiced (${stat.attempt_count})</span>`;
                html += `<span class="bg-emerald-100 text-emerald-700 text-[10px] font-bold px-2 py-0.5 rounded-full whitespace-nowrap">Avg ${stat.avg_score}</span>`;
                
                // Change arrow to checkmark
                const iconContainer = card.querySelector('.w-8.h-8.rounded-full');
                if (iconContainer) {
                    iconContainer.className = "w-8 h-8 rounded-full flex items-center justify-center transition-all duration-300 bg-emerald-100 text-emerald-600 group-hover:bg-emerald-500 group-hover:text-white shadow-sm";
                    iconContainer.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>';
                }
            } else {
                html += `<span class="bg-gray-100 text-gray-500 text-[10px] font-bold px-2 py-0.5 rounded-full whitespace-nowrap">New</span>`;
            }

            badgeContainer.innerHTML = html;
        });

    } catch (e) {
        console.warn('PTE Index Tracker: Could not load stats', e);
    }
});
</script>
