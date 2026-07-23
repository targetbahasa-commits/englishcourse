{{-- View Post Modal --}}
<div x-show="showView" x-transition.opacity style="display:none"
     class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] flex items-start justify-center p-4 overflow-y-auto">
    <div @click.stop x-show="showView" x-transition
         class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl my-8">

        <template x-if="viewingPost">
            <div>
                {{-- Header --}}
                <div class="flex items-start justify-between px-6 py-5 border-b border-gray-100">
                    <div class="flex-1 min-w-0 pr-4">
                        <h3 class="text-lg font-bold text-gray-900 truncate" x-text="viewingPost.title"></h3>
                        <div class="flex items-center gap-2 mt-1 flex-wrap">
                            <span class="text-xs font-medium text-gray-500" x-text="viewingPost.content_type"></span>
                            <span class="text-gray-300">•</span>
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold"
                                :class="{
                                    'status-draft': viewingPost.status === 'draft',
                                    'status-scheduled': viewingPost.status === 'scheduled',
                                    'status-published': viewingPost.status === 'published',
                                    'status-cancelled': viewingPost.status === 'cancelled',
                                }"
                                x-text="viewingPost.status.charAt(0).toUpperCase() + viewingPost.status.slice(1)"></span>
                        </div>
                    </div>
                    <button @click="showView = false" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="p-6 space-y-5">
                    {{-- Platforms --}}
                    <div>
                        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">Platforms</div>
                        <div class="flex flex-wrap gap-2">
                            <template x-for="p in (viewingPost.platforms || [])" :key="p">
                                <span class="platform-badge bg-indigo-100 text-indigo-700" x-text="p"></span>
                            </template>
                        </div>
                    </div>

                    {{-- Caption --}}
                    <template x-if="viewingPost.caption">
                        <div>
                            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">Caption</div>
                            <div class="bg-gray-50 rounded-xl p-4 text-sm text-gray-700 whitespace-pre-wrap leading-relaxed" x-text="viewingPost.caption"></div>
                        </div>
                    </template>

                    {{-- CTA + Hashtags --}}
                    <div class="grid grid-cols-2 gap-4">
                        <template x-if="viewingPost.cta">
                            <div>
                                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">CTA</div>
                                <p class="text-sm text-gray-700" x-text="viewingPost.cta"></p>
                            </div>
                        </template>
                        <template x-if="viewingPost.hashtags">
                            <div>
                                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Hashtags</div>
                                <p class="text-sm text-indigo-600 font-mono" x-text="viewingPost.hashtags"></p>
                            </div>
                        </template>
                    </div>

                    {{-- Schedule + People --}}
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        <div>
                            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Publish Date</div>
                            <p class="text-sm text-gray-700" x-text="viewingPost.publish_date ? new Date(viewingPost.publish_date).toLocaleDateString('id-ID',{day:'numeric',month:'short',year:'numeric'}) : '—'"></p>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Publish Time</div>
                            <p class="text-sm text-gray-700" x-text="viewingPost.publish_time || '—'"></p>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Assigned To</div>
                            <p class="text-sm text-gray-700" x-text="viewingPost.assigned_to || '—'"></p>
                        </div>
                        <div>
                            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Reviewer</div>
                            <p class="text-sm text-gray-700" x-text="viewingPost.reviewer || '—'"></p>
                        </div>
                    </div>

                    {{-- Checklist --}}
                    <div>
                        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">Checklist</div>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                            <template x-for="[key, label] in [['checklist_caption','Caption Finished'],['checklist_design','Design Finished'],['checklist_video','Video Finished'],['checklist_review','Reviewed'],['checklist_publish','Published']]" :key="key">
                                <div class="flex items-center gap-2 p-2 rounded-lg"
                                    :class="viewingPost[key] ? 'bg-green-50' : 'bg-gray-50'">
                                    <svg class="w-4 h-4 flex-shrink-0" :class="viewingPost[key] ? 'text-green-500' : 'text-gray-300'" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-xs text-gray-600" x-text="label"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Reference Links --}}
                    <template x-if="viewingPost.links && viewingPost.links.length > 0">
                        <div>
                            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">Reference Links</div>
                            <div class="space-y-2">
                                <template x-for="link in viewingPost.links" :key="link.id">
                                    <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl">
                                        <span class="px-2 py-0.5 bg-white border border-gray-200 rounded text-xs font-medium text-gray-600 shrink-0" x-text="link.type"></span>
                                        <a :href="link.url" target="_blank" class="text-xs text-indigo-600 hover:underline truncate flex-1" x-text="link.url"></a>
                                        <span class="text-xs text-gray-400" x-text="link.description"></span>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </template>

                    {{-- Stats --}}
                    <div>
                        <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-2">Statistics (Manual)</div>
                        <div class="grid grid-cols-4 sm:grid-cols-7 gap-2">
                            <template x-for="[key, label] in [['stat_views','Views'],['stat_likes','Likes'],['stat_comments','Comments'],['stat_shares','Shares'],['stat_clicks','Clicks'],['stat_leads','Leads'],['stat_registrations','Regs']]" :key="key">
                                <div class="text-center p-2 bg-gray-50 rounded-lg">
                                    <div class="text-base font-bold text-gray-800" x-text="viewingPost[key] || 0"></div>
                                    <div class="text-xs text-gray-400" x-text="label"></div>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Notes --}}
                    <template x-if="viewingPost.notes">
                        <div>
                            <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-1">Notes</div>
                            <p class="text-sm text-gray-600 bg-yellow-50 rounded-xl p-3" x-text="viewingPost.notes"></p>
                        </div>
                    </template>
                </div>

                <div class="flex items-center justify-end gap-3 px-6 py-4 border-t border-gray-100">
                    <button type="button" @click="showView = false; editPost(viewingPost.id)"
                        class="px-5 py-2.5 text-sm font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                        Edit Post
                    </button>
                    <button type="button" @click="showView = false"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        Close
                    </button>
                </div>
            </div>
        </template>
    </div>
</div>
