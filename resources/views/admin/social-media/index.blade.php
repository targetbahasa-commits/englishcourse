<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Social Media - {{ $programLabel }} | Target Bahasa Admin</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
        .platform-badge { @apply inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium; }
        .status-draft     { @apply bg-gray-100 text-gray-600; }
        .status-scheduled { @apply bg-blue-100 text-blue-700; }
        .status-published { @apply bg-green-100 text-green-700; }
        .status-cancelled { @apply bg-red-100 text-red-600; }
        .cal-day-event { transition: all .15s; }
        .cal-day-event:hover { filter: brightness(0.95); }
    </style>
</head>
<body class="font-sans antialiased bg-gray-100" x-data="socialMediaApp('{{ $program }}', '{{ $programLabel }}', '{{ route('admin.social-media.store', $program) }}', '{{ csrf_token() }}')" x-cloak>
@include('components.impersonation-banner')
<div class="flex min-h-screen">
    @include('components.sidebar-admin')

    <main class="flex-1 md:ml-64 p-6">

        {{-- ===== TOP BAR ===== --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <div class="flex items-center gap-2 text-sm text-gray-500 mb-1">
                    <a href="{{ route('admin.social-media.all') }}" class="hover:text-blue-600 transition">All Programs</a>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    <span class="font-medium text-gray-700">{{ $programLabel }}</span>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Social Media Management</h1>
                <p class="text-sm text-gray-500 mt-0.5">Content planning & scheduling for <span class="font-semibold text-indigo-600">{{ $programLabel }}</span></p>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                {{-- Program switcher --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" @click.away="open = false"
                        class="inline-flex items-center gap-2 px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 shadow-sm transition">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/></svg>
                        Switch Program
                    </button>
                    <div x-show="open" x-transition style="display:none"
                         class="absolute right-0 mt-2 w-52 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50">
                        <a href="{{ route('admin.social-media.all') }}" class="block px-4 py-2 text-sm font-semibold text-indigo-600 hover:bg-indigo-50">🌐 All Programs</a>
                        <div class="border-t border-gray-100 my-1"></div>
                        @foreach(\App\Models\SocialMediaPost::programs() as $slug => $label)
                            <a href="{{ route('admin.social-media.index', $slug) }}"
                               class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 {{ $program === $slug ? 'bg-blue-50 text-blue-700 font-medium' : '' }}">
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>
                <a href="{{ route('admin.social-media.export', $program) }}"
                   class="inline-flex items-center gap-2 px-3 py-2 bg-white border border-gray-200 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    Export CSV
                </a>
                <button @click="openCreateModal()"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-semibold shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    New Post
                </button>
            </div>
        </div>

        {{-- ===== SUMMARY CARDS ===== --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 mb-6">
            @php
                $cards = [
                    ['label'=>'Total Content',    'value'=>$stats['total'],      'color'=>'indigo', 'icon'=>'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
                    ['label'=>'Draft',            'value'=>$stats['draft'],      'color'=>'gray',   'icon'=>'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                    ['label'=>'Scheduled',        'value'=>$stats['scheduled'],  'color'=>'blue',   'icon'=>'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z'],
                    ['label'=>'Published',        'value'=>$stats['published'],  'color'=>'green',  'icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['label'=>"This Month's Posts",'value'=>$stats['this_month'],'color'=>'purple', 'icon'=>'M13 10V3L4 14h7v7l9-11h-7z'],
                ];
            @endphp
            @foreach($cards as $card)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
                <div class="flex items-start justify-between mb-3">
                    <div class="p-2.5 bg-{{ $card['color'] }}-50 rounded-xl">
                        <svg class="w-5 h-5 text-{{ $card['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                        </svg>
                    </div>
                </div>
                <div class="text-2xl font-bold text-gray-900">{{ $card['value'] }}</div>
                <div class="text-xs text-gray-500 mt-0.5">{{ $card['label'] }}</div>
            </div>
            @endforeach
        </div>

        {{-- ===== TABS ===== --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden" x-data="{ tab: 'list' }">
            <div class="border-b border-gray-100 px-6 flex gap-6">
                <button @click="tab='list'" :class="tab==='list' ? 'border-b-2 border-indigo-500 text-indigo-600' : 'text-gray-500 hover:text-gray-700'"
                    class="py-4 text-sm font-semibold transition whitespace-nowrap">
                    📋 Content List
                </button>
                <button @click="tab='calendar'" :class="tab==='calendar' ? 'border-b-2 border-indigo-500 text-indigo-600' : 'text-gray-500 hover:text-gray-700'"
                    class="py-4 text-sm font-semibold transition whitespace-nowrap">
                    📅 Calendar View
                </button>
            </div>

            {{-- ===== LIST TAB ===== --}}
            <div x-show="tab === 'list'" x-transition>

                {{-- Filters --}}
                <form method="GET" class="p-4 border-b border-gray-50 bg-gray-50/50">
                    <div class="flex flex-wrap gap-3 items-end">
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Platform</label>
                            <select name="filter_platform" class="text-sm border-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 py-1.5">
                                <option value="">All Platforms</option>
                                @foreach(['Instagram','TikTok','Facebook','WhatsApp','YouTube','LinkedIn'] as $p)
                                    <option value="{{ $p }}" {{ request('filter_platform') === $p ? 'selected' : '' }}>{{ $p }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                            <select name="filter_status" class="text-sm border-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 py-1.5">
                                <option value="">All Status</option>
                                @foreach(['draft','scheduled','published','cancelled'] as $s)
                                    <option value="{{ $s }}" {{ request('filter_status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Content Type</label>
                            <select name="filter_content_type" class="text-sm border-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 py-1.5">
                                <option value="">All Types</option>
                                @foreach(['Tips','Vocabulary','Grammar','Promotion','Student Story','Testimonial','Quiz','Motivation','FAQ','Announcement'] as $ct)
                                    <option value="{{ $ct }}" {{ request('filter_content_type') === $ct ? 'selected' : '' }}>{{ $ct }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Month</label>
                            <input type="month" name="filter_month" value="{{ request('filter_month') }}" class="text-sm border-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 py-1.5">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-500 mb-1">Assigned To</label>
                            <input type="text" name="filter_assigned" placeholder="Name..." value="{{ request('filter_assigned') }}" class="text-sm border-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 py-1.5 w-32">
                        </div>
                        <div class="flex-1 min-w-[160px]">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Search</label>
                            <input type="text" name="search" placeholder="Title or caption..." value="{{ request('search') }}" class="w-full text-sm border-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 py-1.5">
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition">Filter</button>
                            <a href="{{ route('admin.social-media.index', $program) }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition">Clear</a>
                        </div>
                    </div>
                </form>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-gray-50 text-xs font-semibold text-gray-400 uppercase tracking-wide">
                                <th class="px-4 py-3 text-left">Title</th>
                                <th class="px-4 py-3 text-left">Platform</th>
                                <th class="px-4 py-3 text-left">Type</th>
                                <th class="px-4 py-3 text-left">Publish Date</th>
                                <th class="px-4 py-3 text-left">Assigned To</th>
                                <th class="px-4 py-3 text-left">Checklist</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($posts as $post)
                                <tr class="hover:bg-gray-50/50 transition group">
                                    <td class="px-4 py-3">
                                        <div class="font-semibold text-gray-800 max-w-[200px] truncate">{{ $post->title }}</div>
                                        @if($post->assigned_to)
                                            <div class="text-xs text-gray-400 mt-0.5 truncate max-w-[180px]">{{ $post->cta }}</div>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex flex-wrap gap-1">
                                            @foreach(array_slice($post->platforms ?? [], 0, 3) as $platform)
                                                @php
                                                    $platformColors = ['Instagram'=>'bg-pink-100 text-pink-700','TikTok'=>'bg-gray-900 text-white','Facebook'=>'bg-blue-100 text-blue-700','WhatsApp'=>'bg-green-100 text-green-700','YouTube'=>'bg-red-100 text-red-700','LinkedIn'=>'bg-sky-100 text-sky-700'];
                                                    $pColor = $platformColors[$platform] ?? 'bg-gray-100 text-gray-600';
                                                @endphp
                                                <span class="platform-badge {{ $pColor }}">{{ $platform }}</span>
                                            @endforeach
                                            @if(count($post->platforms ?? []) > 3)
                                                <span class="platform-badge bg-gray-100 text-gray-500">+{{ count($post->platforms) - 3 }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-gray-600">{{ $post->content_type }}</td>
                                    <td class="px-4 py-3">
                                        @if($post->publish_date)
                                            <div class="font-medium text-gray-700">{{ $post->publish_date->format('d M Y') }}</div>
                                            <div class="text-xs text-gray-400">{{ $post->publish_time ? \Carbon\Carbon::parse($post->publish_time)->format('H:i') : '—' }}</div>
                                        @else
                                            <span class="text-gray-300">Not set</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3 text-gray-600 max-w-[120px] truncate">{{ $post->assigned_to ?: '—' }}</td>
                                    <td class="px-4 py-3">
                                        @php $pct = $post->checklist_percentage; @endphp
                                        <div class="flex items-center gap-2">
                                            <div class="w-16 h-1.5 bg-gray-100 rounded-full overflow-hidden">
                                                <div class="h-full rounded-full {{ $pct === 100 ? 'bg-green-500' : ($pct >= 60 ? 'bg-yellow-400' : 'bg-gray-300') }}" style="width: {{ $pct }}%"></div>
                                            </div>
                                            <span class="text-xs text-gray-500">{{ $pct }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold status-{{ $post->status }}">
                                            {{ ucfirst($post->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition">
                                            <button @click="viewPost({{ $post->id }})" title="View"
                                                class="p-1.5 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                            </button>
                                            <button @click="editPost({{ $post->id }})" title="Edit"
                                                class="p-1.5 text-gray-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                            </button>
                                            <button @click="duplicatePost({{ $post->id }})" title="Duplicate"
                                                class="p-1.5 text-gray-400 hover:text-amber-600 hover:bg-amber-50 rounded-lg transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                            </button>
                                            @if($post->status !== 'published')
                                            <button @click="markPublished({{ $post->id }})" title="Mark Published"
                                                class="p-1.5 text-gray-400 hover:text-green-600 hover:bg-green-50 rounded-lg transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                            </button>
                                            @endif
                                            <button @click="deletePost({{ $post->id }}, '{{ addslashes($post->title) }}')" title="Delete"
                                                class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-16 text-center text-gray-400">
                                    <div class="text-4xl mb-3">📭</div>
                                    <div class="font-medium">No posts yet</div>
                                    <div class="text-sm mt-1">Create your first content for {{ $programLabel }}</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                @if($posts->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $posts->withQueryString()->links() }}
                </div>
                @endif
            </div>

            {{-- ===== CALENDAR TAB ===== --}}
            <div x-show="tab === 'calendar'" x-transition>
                @include('admin.social-media.partials.calendar', compact('calendarPosts','calendarYear','calendarMonth','program'))
            </div>
        </div>

    </main>
</div>

{{-- ===== MODALS ===== --}}
@include('admin.social-media.partials.create-edit-modal')
@include('admin.social-media.partials.view-modal')
@include('admin.social-media.partials.delete-modal')

<script>
function socialMediaApp(program, programLabel, storeUrl, csrfToken) {
    return {
        program,
        programLabel,
        storeUrl,
        csrfToken,

        // Modal states
        showCreateEdit: false,
        showView: false,
        showDelete: false,
        isEditing: false,
        editingId: null,
        deletingId: null,
        deletingTitle: '',
        viewingPost: null,

        // Form data
        form: {
            title: '',
            content_type: '',
            platforms: [],
            caption: '',
            cta: '',
            hashtags: '',
            publish_date: '',
            publish_time: '',
            assigned_to: '',
            reviewer: '',
            status: 'draft',
            notes: '',
            checklist_caption: false,
            checklist_design: false,
            checklist_video: false,
            checklist_review: false,
            checklist_publish: false,
            links: [],
        },

        platformOptions: ['Instagram','TikTok','Facebook','WhatsApp','YouTube','LinkedIn'],
        linkTypes: ['Canva','Google Drive','YouTube','Instagram','TikTok','Facebook','Landing Page','Other'],
        contentTypes: ['Tips','Vocabulary','Grammar','Promotion','Student Story','Testimonial','Quiz','Motivation','FAQ','Announcement'],

        toast: { show: false, message: '', type: 'success' },

        openCreateModal() {
            this.isEditing = false;
            this.editingId = null;
            this.resetForm();
            this.showCreateEdit = true;
        },

        async editPost(id) {
            const res = await fetch(`/admin/social-media/${program}/${id}`, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            });
            const post = await res.json();
            this.form = {
                title: post.title,
                content_type: post.content_type,
                platforms: post.platforms || [],
                caption: post.caption || '',
                cta: post.cta || '',
                hashtags: post.hashtags || '',
                publish_date: post.publish_date ? post.publish_date.substring(0, 10) : '',
                publish_time: post.publish_time || '',
                assigned_to: post.assigned_to || '',
                reviewer: post.reviewer || '',
                status: post.status,
                notes: post.notes || '',
                checklist_caption: post.checklist_caption,
                checklist_design: post.checklist_design,
                checklist_video: post.checklist_video,
                checklist_review: post.checklist_review,
                checklist_publish: post.checklist_publish,
                links: post.links || [],
            };
            this.isEditing = true;
            this.editingId = id;
            this.showCreateEdit = true;
        },

        async viewPost(id) {
            const res = await fetch(`/admin/social-media/${program}/${id}`, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            });
            this.viewingPost = await res.json();
            this.showView = true;
        },

        deletePost(id, title) {
            this.deletingId = id;
            this.deletingTitle = title;
            this.showDelete = true;
        },

        async confirmDelete() {
            const res = await fetch(`/admin/social-media/${program}/${this.deletingId}`, {
                method: 'DELETE',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            });
            if (res.ok) {
                this.showDelete = false;
                this.showToast('Post deleted successfully!', 'success');
                setTimeout(() => location.reload(), 800);
            }
        },

        async submitForm() {
            const url = this.isEditing
                ? `/admin/social-media/${program}/${this.editingId}`
                : `/admin/social-media/${program}`;
            const method = this.isEditing ? 'PUT' : 'POST';

            const res = await fetch(url, {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify(this.form)
            });

            if (res.ok) {
                this.showCreateEdit = false;
                this.showToast(this.isEditing ? 'Post updated!' : 'Post created!', 'success');
                setTimeout(() => location.reload(), 800);
            } else {
                const err = await res.json();
                this.showToast(err.message || 'Something went wrong.', 'error');
            }
        },

        async duplicatePost(id) {
            const res = await fetch(`/admin/social-media/${program}/${id}/duplicate`, {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            });
            if (res.ok) {
                this.showToast('Post duplicated!', 'success');
                setTimeout(() => location.reload(), 800);
            }
        },

        async markPublished(id) {
            const res = await fetch(`/admin/social-media/${program}/${id}/mark-published`, {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            });
            if (res.ok) {
                this.showToast('Marked as Published!', 'success');
                setTimeout(() => location.reload(), 600);
            }
        },

        addLink() {
            this.form.links.push({ type: 'Canva', url: '', description: '' });
        },

        removeLink(index) {
            this.form.links.splice(index, 1);
        },

        togglePlatform(p) {
            const i = this.form.platforms.indexOf(p);
            if (i === -1) this.form.platforms.push(p);
            else this.form.platforms.splice(i, 1);
        },

        resetForm() {
            this.form = {
                title: '', content_type: '', platforms: [],
                caption: '', cta: '', hashtags: '',
                publish_date: '', publish_time: '',
                assigned_to: '', reviewer: '', status: 'draft', notes: '',
                checklist_caption: false, checklist_design: false,
                checklist_video: false, checklist_review: false, checklist_publish: false,
                links: [],
            };
        },

        showToast(message, type = 'success') {
            this.toast = { show: true, message, type };
            setTimeout(() => { this.toast.show = false; }, 3500);
        },

        get checklistPct() {
            const items = [this.form.checklist_caption, this.form.checklist_design,
                this.form.checklist_video, this.form.checklist_review, this.form.checklist_publish];
            return Math.round(items.filter(Boolean).length / 5 * 100);
        }
    };
}
</script>

{{-- Toast --}}
<div x-data="{ toast: false }" class="fixed bottom-6 right-6 z-[9999]">
    <template x-if="$store && false"></template>
</div>
</body>
</html>
