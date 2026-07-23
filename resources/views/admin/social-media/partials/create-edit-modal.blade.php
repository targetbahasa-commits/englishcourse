{{-- Create / Edit Modal --}}
<div x-show="showCreateEdit" x-transition.opacity style="display:none"
     class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[100] flex items-start justify-center p-4 overflow-y-auto">
    <div @click.stop x-show="showCreateEdit" x-transition
         class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl my-8">

        {{-- Header --}}
        <div class="flex items-center justify-between px-6 py-5 border-b border-gray-100">
            <div>
                <h3 class="text-lg font-bold text-gray-900" x-text="isEditing ? 'Edit Post' : 'Create New Post'"></h3>
                <p class="text-sm text-gray-500 mt-0.5" x-text="programLabel + ' — Social Media Planning'"></p>
            </div>
            <button @click="showCreateEdit = false" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>

        <form @submit.prevent="submitForm" class="p-6 space-y-6">
            {{-- Row 1: Title + Content Type --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Title <span class="text-red-500">*</span></label>
                    <input type="text" x-model="form.title" required placeholder="Post title..."
                           class="w-full border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Content Type <span class="text-red-500">*</span></label>
                    <select x-model="form.content_type" required class="w-full border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Select type...</option>
                        <template x-for="ct in contentTypes" :key="ct">
                            <option :value="ct" x-text="ct" :selected="form.content_type === ct"></option>
                        </template>
                    </select>
                </div>
            </div>

            {{-- Platform Multi-select --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Platforms <span class="text-red-500">*</span></label>
                <div class="flex flex-wrap gap-2">
                    <template x-for="p in platformOptions" :key="p">
                        <button type="button" @click="togglePlatform(p)"
                            :class="form.platforms.includes(p) ? 'bg-indigo-600 text-white border-indigo-600' : 'bg-white text-gray-600 border-gray-200 hover:border-indigo-300'"
                            class="px-3 py-1.5 rounded-lg text-sm font-medium border transition" x-text="p">
                        </button>
                    </template>
                </div>
                <p class="text-xs text-gray-400 mt-1" x-text="form.platforms.length + ' platform(s) selected'"></p>
            </div>

            {{-- Caption --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Caption</label>
                <textarea x-model="form.caption" rows="4" placeholder="Write your social media caption here..."
                    class="w-full border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 resize-none"></textarea>
            </div>

            {{-- Row: CTA + Hashtags --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">CTA (Call to Action)</label>
                    <input type="text" x-model="form.cta" placeholder="e.g. DM us to register!"
                           class="w-full border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Hashtags</label>
                    <textarea x-model="form.hashtags" rows="2" placeholder="#targetbahasa #ielts #toefl"
                        class="w-full border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 resize-none"></textarea>
                </div>
            </div>

            {{-- Row: Date + Time + Assigned + Reviewer --}}
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Publish Date</label>
                    <input type="date" x-model="form.publish_date"
                           class="w-full border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Publish Time</label>
                    <input type="time" x-model="form.publish_time"
                           class="w-full border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Assigned To</label>
                    <input type="text" x-model="form.assigned_to" placeholder="Team member name"
                           class="w-full border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">Reviewer</label>
                    <input type="text" x-model="form.reviewer" placeholder="Reviewer name"
                           class="w-full border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500">
                </div>
            </div>

            {{-- Status --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                <div class="flex flex-wrap gap-3">
                    @foreach(['draft'=>['gray','Draft'],'scheduled'=>['blue','Scheduled'],'published'=>['green','Published'],'cancelled'=>['red','Cancelled']] as $s => [$color, $label])
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="radio" x-model="form.status" value="{{ $s }}" class="text-indigo-600">
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold status-{{ $s }}">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Notes --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Notes</label>
                <textarea x-model="form.notes" rows="2" placeholder="Internal notes..."
                    class="w-full border-gray-200 rounded-lg text-sm focus:ring-indigo-500 focus:border-indigo-500 resize-none"></textarea>
            </div>

            {{-- Reference Links --}}
            <div>
                <div class="flex items-center justify-between mb-3">
                    <label class="text-sm font-semibold text-gray-700">📎 Reference Links</label>
                    <button type="button" @click="addLink()"
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Add Link
                    </button>
                </div>
                <div class="space-y-2">
                    <template x-if="form.links.length === 0">
                        <p class="text-xs text-gray-400 italic">No links yet. Click "Add Link" to add Canva, Google Drive, YouTube links, etc.</p>
                    </template>
                    <template x-for="(link, idx) in form.links" :key="idx">
                        <div class="flex gap-2 items-start p-3 bg-gray-50 rounded-xl">
                            <select x-model="link.type" class="border-gray-200 rounded-lg text-xs focus:ring-indigo-500 focus:border-indigo-500 py-1.5 shrink-0">
                                <template x-for="lt in linkTypes" :key="lt">
                                    <option :value="lt" x-text="lt"></option>
                                </template>
                            </select>
                            <input type="url" x-model="link.url" placeholder="https://..." class="flex-1 border-gray-200 rounded-lg text-xs focus:ring-indigo-500 focus:border-indigo-500 py-1.5">
                            <input type="text" x-model="link.description" placeholder="Description" class="w-32 border-gray-200 rounded-lg text-xs focus:ring-indigo-500 focus:border-indigo-500 py-1.5">
                            <button type="button" @click="removeLink(idx)" class="p-1.5 text-red-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Checklist --}}
            <div>
                <div class="flex items-center justify-between mb-3">
                    <label class="text-sm font-semibold text-gray-700">✅ Checklist</label>
                    <div class="flex items-center gap-2">
                        <div class="w-20 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-indigo-500 rounded-full transition-all" :style="`width: ${checklistPct}%`"></div>
                        </div>
                        <span class="text-xs font-semibold text-indigo-600" x-text="checklistPct + '%'"></span>
                    </div>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                    @foreach(['checklist_caption'=>'Caption Finished','checklist_design'=>'Design Finished','checklist_video'=>'Video Finished','checklist_review'=>'Reviewed','checklist_publish'=>'Published'] as $field => $label)
                    <label class="flex items-center gap-2 cursor-pointer p-2.5 rounded-xl hover:bg-gray-50 transition">
                        <input type="checkbox" x-model="form.{{ $field }}" class="rounded text-indigo-600 focus:ring-indigo-500">
                        <span class="text-sm text-gray-700">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex items-center justify-end gap-3 pt-2 border-t border-gray-100">
                <button type="button" @click="showCreateEdit = false"
                    class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                    Cancel
                </button>
                <button type="submit"
                    class="px-6 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg transition shadow-sm"
                    x-text="isEditing ? 'Save Changes' : 'Create Post'">
                </button>
            </div>
        </form>
    </div>
</div>
