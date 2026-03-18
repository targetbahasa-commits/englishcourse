<div id="remote-share-tab-control"
    data-page-key="{{ request()->url() }}"
    class="fixed left-0 right-0 top-0 z-[95] md:left-64">
    <div id="remote-share-tab-indicator-inner"
        class="mx-2 mt-2 rounded-2xl border border-amber-200 bg-amber-50/95 px-4 py-3 shadow-lg backdrop-blur md:mx-6">
        <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
            <div class="min-w-0">
                <div class="flex items-center gap-2">
                    <span id="remote-share-tab-indicator-dot" class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>
                    <span id="remote-share-tab-indicator-text" class="text-sm font-bold text-amber-800">Tab Share Inactive</span>
                </div>
                <p id="remote-share-tab-status" class="mt-1 text-xs leading-5 text-slate-700">
                    Activate this tab if this is the course page that may be shared remotely.
                </p>
            </div>
            <button id="remote-share-tab-toggle"
                type="button"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-emerald-600 px-3.5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-500 md:w-auto">
                Activate Tab Share
            </button>
        </div>
    </div>
</div>

<script>
    (() => {
        const root = document.getElementById('remote-share-tab-control');
        if (!root) {
            return;
        }

        const bodyOffsetClass = 'remote-share-bar-offset';
        if (!document.getElementById('remote-share-tab-control-style')) {
            const style = document.createElement('style');
            style.id = 'remote-share-tab-control-style';
            style.textContent = `
                body.${bodyOffsetClass} {
                    padding-top: 5.5rem;
                }

                @media (max-width: 767px) {
                    body.${bodyOffsetClass} {
                        padding-top: 6.5rem;
                    }
                }
            `;
            document.head.appendChild(style);
        }

        document.body.classList.add(bodyOffsetClass);

        const activeTabStorageKey = 'remote-share-active-tab-id';
        const activePageStorageKey = 'remote-share-active-page-key';
        const activeHeartbeatStorageKey = 'remote-share-active-tab-heartbeat';
        const lastCourseUrlStorageKey = 'remote-share-last-course-url';
        const lastCourseTitleStorageKey = 'remote-share-last-course-title';
        const tabIdStorageKey = 'remote-share-tab-id';
        let heartbeatTimer = null;
        const tabId = sessionStorage.getItem(tabIdStorageKey) || `remote-share-tab-${Date.now()}-${Math.random().toString(36).slice(2)}`;
        const pageKey = root.dataset.pageKey;
        const button = document.getElementById('remote-share-tab-toggle');
        const status = document.getElementById('remote-share-tab-status');
        const indicator = document.getElementById('remote-share-tab-indicator-inner');
        const indicatorText = document.getElementById('remote-share-tab-indicator-text');
        const indicatorDot = document.getElementById('remote-share-tab-indicator-dot');

        sessionStorage.setItem(tabIdStorageKey, tabId);
        localStorage.setItem(lastCourseUrlStorageKey, pageKey);
        localStorage.setItem(lastCourseTitleStorageKey, document.title || 'Last course page');
        window.remoteShareConfig = {
            enabled: true,
            pageKey,
            tabId,
        };

        const sync = () => {
            const isActive = localStorage.getItem(activeTabStorageKey) === tabId
                && localStorage.getItem(activePageStorageKey) === pageKey;

            status.textContent = isActive
                ? 'This course tab is active for remote sharing. Requests sent to your account will be handled from this tab only.'
                : 'Activate this tab if this is the course page that may be shared remotely.';

            indicator.className = isActive
                ? 'mx-2 mt-2 rounded-2xl border border-emerald-200 bg-emerald-50/95 px-4 py-3 shadow-lg backdrop-blur md:mx-6'
                : 'mx-2 mt-2 rounded-2xl border border-amber-200 bg-amber-50/95 px-4 py-3 shadow-lg backdrop-blur md:mx-6';
            indicatorText.textContent = isActive ? 'Tab Share Active' : 'Tab Share Inactive';
            indicatorDot.className = isActive
                ? 'mr-2 mt-1 h-2.5 w-2.5 rounded-full bg-emerald-500'
                : 'mr-2 mt-1 h-2.5 w-2.5 rounded-full bg-amber-500';

            button.textContent = isActive ? 'Deactivate Tab Share' : 'Activate Tab Share';
            button.className = isActive
                ? 'mt-3 inline-flex items-center gap-2 rounded-xl bg-slate-700 px-3.5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-600'
                : 'mt-3 inline-flex items-center gap-2 rounded-xl bg-emerald-600 px-3.5 py-2 text-sm font-semibold text-white shadow-sm transition hover:bg-emerald-500';

            if (isActive) {
                localStorage.setItem(activeHeartbeatStorageKey, String(Date.now()));
                if (!heartbeatTimer) {
                    heartbeatTimer = setInterval(() => {
                        localStorage.setItem(activeHeartbeatStorageKey, String(Date.now()));
                    }, 2500);
                }
            } else {
                if (heartbeatTimer) {
                    clearInterval(heartbeatTimer);
                    heartbeatTimer = null;
                }
                if (localStorage.getItem(activeTabStorageKey) !== tabId) {
                    localStorage.removeItem(activeHeartbeatStorageKey);
                }
            }

            window.dispatchEvent(new CustomEvent('remote-share-tab-state-change', {
                detail: {
                    isActive,
                    pageKey,
                    tabId,
                }
            }));
        };

        button.addEventListener('click', () => {
            const isActive = localStorage.getItem(activeTabStorageKey) === tabId
                && localStorage.getItem(activePageStorageKey) === pageKey;

            if (isActive) {
                localStorage.removeItem(activeTabStorageKey);
                localStorage.removeItem(activePageStorageKey);
            } else {
                localStorage.setItem(activeTabStorageKey, tabId);
                localStorage.setItem(activePageStorageKey, pageKey);
            }

            sync();
        });

        window.addEventListener('storage', sync);
        window.addEventListener('beforeunload', () => {
            const isActive = localStorage.getItem(activeTabStorageKey) === tabId
                && localStorage.getItem(activePageStorageKey) === pageKey;
            if (isActive) {
                localStorage.removeItem(activeTabStorageKey);
                localStorage.removeItem(activePageStorageKey);
                localStorage.removeItem(activeHeartbeatStorageKey);
            }
            if (heartbeatTimer) {
                clearInterval(heartbeatTimer);
                heartbeatTimer = null;
            }
            document.body.classList.remove(bodyOffsetClass);
        });
        sync();
    })();
</script>
