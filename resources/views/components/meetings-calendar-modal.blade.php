<div
    x-data="{
        isOpen: false,
        meetings: [],
        batchName: '',
        loading: false,
        edits: {},
        open(id, name) {
            this.isOpen = true;
            this.batchName = name || '';
            this.meetings = [];
            this.edits = {};
            this.loading = true;
            fetch('/class-periods/' + id + '/meetings')
                .then(res => res.json())
                .then(data => {
                    this.meetings = data || [];
                    (this.meetings || []).forEach(m => {
                        this.edits[m.id] = m.meeting_date ? m.meeting_date.substring(0, 10) : '';
                    });
                })
                .catch(err => {
                    console.error(err);
                    this.meetings = [];
                })
                .finally(() => { this.loading = false; });
        },
        async save(meeting) {
            const dateVal = this.edits[meeting.id];
            if (!dateVal) {
                alert('Please select a date before saving.');
                return;
            }

            try {
                const res = await fetch('/class-meetings/' + meeting.id, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content')
                    },
                    body: JSON.stringify({ meeting_date: dateVal })
                });

                if (!res.ok) {
                    const payload = await res.json().catch(() => ({}));
                    throw new Error(payload.message || 'Unable to save meeting date.');
                }

                const payload = await res.json();
                const idx = this.meetings.findIndex(m => m.id === meeting.id);
                if (idx !== -1) {
                    this.meetings[idx] = payload.meeting || this.meetings[idx];
                    this.edits[meeting.id] = this.meetings[idx].meeting_date ? this.meetings[idx].meeting_date.substring(0, 10) : '';
                }
                alert('Meeting date updated successfully.');
            } catch (err) {
                console.error(err);
                alert(err.message || 'Failed to save meeting date.');
            }
        },
        init() {
            window.addEventListener('open-batch-calendar', (e) => {
                this.open(e.detail.classPeriodId, e.detail.batchName);
            });
        }
    }"
    x-show="isOpen"
    class="fixed inset-0 z-50 overflow-y-auto"
    style="display:none;"
    role="dialog" aria-modal="true"
>
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="isOpen" x-transition.opacity class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="isOpen = false"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>

        <div x-show="isOpen" x-transition.duration.300ms.scale.95 class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full">
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-bold text-gray-900">Meetings — <span x-text="batchName"></span></h3>
                    <p class="text-sm text-gray-500 mt-0.5">Shows scheduled meeting dates for this class batch.</p>
                </div>
                <button @click="isOpen = false" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
            <div class="px-6 py-5">
                <div x-show="loading" class="text-center py-8">
                    <svg class="animate-spin mx-auto h-6 w-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    <p class="text-sm text-gray-500 mt-3">Loading meetings...</p>
                </div>

                <template x-if="!loading">
                    <div>
                        <template x-if="meetings && meetings.length > 0">
                            <ul class="space-y-3">
                                <template x-for="m in meetings" :key="m.id">
                                    <li class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-3 bg-white border border-gray-100 rounded-xl">
                                        <div>
                                            <div class="text-sm font-medium text-gray-900" x-text="m.topic || ('Meeting ' + (m.meeting_number ?? ''))"></div>
                                            <div class="text-xs text-gray-500 mt-0.5" x-text="m.meeting_date ? (new Date(m.meeting_date)).toLocaleDateString() : (m.start_time ? new Date(m.start_time).toLocaleString() : '')"></div>
                                        </div>
                                        <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                                            <div class="text-xs text-gray-400">#<span x-text="m.meeting_number"></span></div>
                                            <template x-if="m.can_edit">
                                                <div class="flex items-center gap-2">
                                                    <input type="date" :id="'meeting-input-' + m.id" x-model="edits[m.id]" class="text-sm border rounded px-2 py-1" />
                                                    <button @click.prevent="save(m)" class="px-3 py-1.5 bg-green-600 text-white text-sm rounded">Save</button>
                                                </div>
                                            </template>
                                        </div>
                                    </li>
                                </template>
                            </ul>
                        </template>

                        <template x-if="!meetings || meetings.length === 0">
                            <div class="text-sm text-gray-500 italic p-6 text-center bg-gray-50 rounded-xl border border-dashed border-gray-200">No meetings scheduled for this batch.</div>
                        </template>
                    </div>
                </template>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-end">
                <button @click="isOpen = false" class="px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50">Close</button>
            </div>
        </div>
    </div>
</div>
