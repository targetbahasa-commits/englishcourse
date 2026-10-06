<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Live Preview - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-100">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('components.sidebar-admin')

        <!-- Main Content -->
        <main class="flex-1 md:ml-64 p-8">
            <!-- Topbar -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Live Preview</h1>
                    <p class="text-gray-500">Pantau siswa &amp; guru yang sedang online secara realtime, dari halaman admin manapun.</p>
                </div>
            </div>

            <!-- Realtime Monitoring -->
            <div class="mb-8" x-data="{
                loading: false,
                lastRefreshed: null,
                search: '',
                selectedProgram: '',
                filterOnline: false,
                activeWindowHours: 24,
                viewMode: 'table',
                programOptions: ['IELTS Academic', 'IELTS General', 'PTE', 'Grammar for Writing'],
                students: {{ Js::from(array_values(array_map(function($s) {
                    $s = is_object($s) ? $s : (object)$s;
                    return [
                        'id'           => (int)($s->id ?? 0),
                        'name'         => $s->name ?? '',
                        'role'         => $s->role ?? 'student',
                        'program_name' => (($s->role ?? '') === 'guest') ? 'Free Test' : ($s->program_name ?? 'No Program'),
                        'last_activity'=> (int)($s->last_activity ?? 0),
                        'activity_url' => $s->activity_url ?? null,
                    ];
                }, $activeStudents ?? []))) }},

                async pollStudents() {
                    this.loading = true;
                    try {
                        const res = await fetch('{{ route('admin.api.active-students') }}?hours=' + this.activeWindowHours, {
                            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                        });
                        const data = await res.json();
                        this.students = data.students || [];
                        this.lastRefreshed = data.server_time || Math.floor(Date.now()/1000);
                    } catch (e) { console.warn('Poll failed', e); }
                    this.loading = false;
                },

                normalizeProgram(p) {
                    const v = (p || '').toLowerCase();
                    if (v.includes('grammar')) return 'Grammar for Writing';
                    if (v.includes('ielts general')) return 'IELTS General';
                    if (v.includes('ielts')) return 'IELTS Academic';
                    if (v.includes('pte')) return 'PTE';
                    return '';
                },

                get filteredStudents() {
                    return this.students.filter(s => {
                        const q = this.search.toLowerCase();
                        const ok = s.name.toLowerCase().includes(q) || (s.program_name||'').toLowerCase().includes(q);
                        const mp = !this.selectedProgram || this.normalizeProgram(s.program_name) === this.selectedProgram;
                        const mo = !this.filterOnline || this.isOnline(s.last_activity);
                        return ok && mp && mo;
                    }).sort((a,b) => b.last_activity - a.last_activity);
                },

                get onlineCount() {
                    return this.students.filter(s => this.isOnline(s.last_activity)).length;
                },

                // Grid mode only ever shows tiles for students who are
                // online right now - an offline tile has no live page to
                // mirror. Capped as a forward-looking safety valve; today's
                // realistic concurrency is nowhere near this limit.
                get onlineStudentsForGrid() {
                    return this.filteredStudents
                        .filter(s => s.role === 'student' && this.isOnline(s.last_activity))
                        .slice(0, 12);
                },

                get onlineStudentsOverflowCount() {
                    const total = this.filteredStudents.filter(s => s.role === 'student' && this.isOnline(s.last_activity)).length;
                    return Math.max(0, total - 12);
                },

                // Reuses the same live_preview_for convention the single-
                // student view already relies on to suppress that role's
                // sidebar/nav chrome when embedded in an iframe.
                tileSrc(s) {
                    if (!s.activity_url) return '';
                    const sep = s.activity_url.includes('?') ? '&' : '?';
                    return `${s.activity_url}${sep}live_preview_for=${s.id}`;
                },

                isOnline(ts) { return (Math.floor(Date.now()/1000) - ts) < 300; },

                formatTime(ts) {
                    if (!ts) return '—';
                    const d = Math.floor(Date.now()/1000) - ts;
                    if (d < 60) return 'Just now';
                    if (d < 3600) return Math.floor(d/60) + 'm ago';
                    if (d < 86400) return Math.floor(d/3600) + 'h ago';
                    return Math.floor(d/86400) + 'd ago';
                },

                formatClock(ts) {
                    if (!ts) return '';
                    return new Date(ts*1000).toLocaleTimeString('id-ID', {hour:'2-digit',minute:'2-digit',second:'2-digit'});
                }
            }" x-init="lastRefreshed = Math.floor(Date.now()/1000); setInterval(() => pollStudents(), 30000)">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">

                    <!-- Header -->
                    <div class="flex flex-wrap justify-between items-center gap-4 mb-5">
                        <div class="flex items-center gap-3">
                            <h3 class="text-xl font-bold text-gray-800">Recently Active Students</h3>
                            <!-- Online badge -->
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold"
                                  :class="onlineCount > 0 ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500'">
                                <span class="relative flex h-2 w-2">
                                    <span x-show="onlineCount > 0" class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2"
                                          :class="onlineCount > 0 ? 'bg-green-500' : 'bg-gray-400'"></span>
                                </span>
                                <span x-text="onlineCount > 0 ? onlineCount + ' Online' : 'Tidak ada yang online'"></span>
                            </span>
                            <!-- Spinner -->
                            <svg x-show="loading" class="w-4 h-4 animate-spin text-blue-400" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                        </div>
                        <div class="flex items-center gap-3 flex-wrap">
                            <span class="text-xs text-gray-400" x-show="lastRefreshed">
                                Diperbarui: <span x-text="formatClock(lastRefreshed)"></span>
                                &nbsp;·&nbsp;
                                <button @click="pollStudents()" class="text-blue-500 hover:text-blue-700 font-medium underline-offset-2 hover:underline">Refresh</button>
                            </span>

                            <!-- Toggle Online Saja -->
                            <button @click="filterOnline = !filterOnline"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-sm font-medium border transition-colors focus:outline-none"
                                    :class="filterOnline ? 'bg-green-50 text-green-700 border-green-200' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50'">
                                <span class="relative flex h-2 w-2">
                                    <span x-show="filterOnline" class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75" style="display: none;"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2"
                                          :class="filterOnline ? 'bg-green-500' : 'bg-gray-400'"></span>
                                </span>
                                <span x-text="filterOnline ? 'Online Saja' : ('Semua (' + activeWindowHours + ' Jam)')"></span>
                            </button>

                            <!-- View mode: Tabel / Grid -->
                            <div class="inline-flex items-center rounded-xl border border-gray-200 bg-gray-50 p-0.5 text-sm font-medium">
                                <button @click="viewMode = 'table'"
                                        class="px-3 py-1 rounded-lg transition-colors"
                                        :class="viewMode === 'table' ? 'bg-white text-gray-800 shadow-sm' : 'text-gray-500 hover:text-gray-700'">
                                    Tabel
                                </button>
                                <button @click="viewMode = 'grid'"
                                        class="px-3 py-1 rounded-lg transition-colors"
                                        :class="viewMode === 'grid' ? 'bg-white text-gray-800 shadow-sm' : 'text-gray-500 hover:text-gray-700'">
                                    Grid
                                </button>
                            </div>

                            <!-- Active window: how far back "recently active" looks.
                                 Changing this re-polls with ?hours=24|48 (see
                                 AdminController::resolveActiveWindowHours()). -->
                            <select x-model.number="activeWindowHours" @change="pollStudents()"
                                    class="form-control rounded-xl text-sm border-gray-200">
                                <option value="24">24 Jam Terakhir</option>
                                <option value="48">48 Jam Terakhir</option>
                            </select>

                            <select x-model="selectedProgram" class="form-control rounded-xl text-sm border-gray-200 min-w-[170px]">
                                <option value="">Semua Program</option>
                                <template x-for="p in programOptions" :key="p">
                                    <option :value="p" x-text="p"></option>
                                </template>
                            </select>
                            <input type="text" x-model="search" placeholder="Cari siswa..." class="form-control rounded-xl text-sm border-gray-200 w-40">
                        </div>
                    </div>

                    <!-- Hint banner -->
                    <div class="flex items-start gap-2 bg-blue-50 border border-blue-100 text-blue-700 text-xs px-3 py-2 rounded-lg mb-4">
                        <svg class="w-3.5 h-3.5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span x-show="viewMode === 'table'">Klik nama siswa yang <strong>Online</strong> untuk membuka tab baru berisi halaman yang sedang dikerjakan secara <em>realtime</em>. Data diperbarui otomatis setiap 30 detik.</span>
                        <span x-show="viewMode === 'grid'">Menampilkan siswa yang sedang <strong>Online</strong> sebagai ubin langsung dari halaman yang sedang mereka kerjakan. Klik ubin mana pun untuk membuka tampilan penuh di tab baru. Data diperbarui otomatis setiap 30 detik.</span>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto" x-show="viewMode === 'table'">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-gray-400 text-xs uppercase tracking-wide border-b border-gray-100">
                                    <th class="pb-3 font-semibold">Student Name</th>
                                    <th class="pb-3 font-semibold">Status</th>
                                    <th class="pb-3 font-semibold">Role</th>
                                    <th class="pb-3 font-semibold">Program / Halaman</th>
                                    <th class="pb-3 font-semibold">Last Seen</th>
                                    <th class="pb-3 font-semibold text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="s in filteredStudents" :key="s.id">
                                    <tr class="border-b border-gray-50 transition group"
                                        :class="{
                                            'hover:bg-green-50 cursor-pointer': isOnline(s.last_activity) && s.role === 'student',
                                            'hover:bg-gray-50 cursor-pointer opacity-70': !isOnline(s.last_activity) && s.role === 'student',
                                            'opacity-60': s.role !== 'student'
                                        }"
                                        @click="if (s.role === 'student') window.open(`/admin/students/${s.id}/current-assignment`, '_blank', 'noopener')">

                                        <!-- Name + avatar -->
                                        <td class="py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="relative shrink-0">
                                                    <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-sm"
                                                         :class="isOnline(s.last_activity) ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500'"
                                                         x-text="s.name ? s.name.charAt(0).toUpperCase() : '?'"></div>
                                                    <span x-show="isOnline(s.last_activity)"
                                                          class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full"></span>
                                                </div>
                                                <div>
                                                    <span class="font-semibold text-gray-800 block transition-colors"
                                                          :class="isOnline(s.last_activity) && s.role === 'student' ? 'group-hover:text-green-700' : ''"
                                                          x-text="s.name"></span>
                                                    <span x-show="isOnline(s.last_activity) && s.role === 'student'"
                                                          class="text-xs text-green-600 font-medium">Klik → lihat layar realtime</span>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Status -->
                                        <td class="py-4">
                                            <template x-if="isOnline(s.last_activity)">
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                                    Online
                                                </span>
                                            </template>
                                            <template x-if="!isOnline(s.last_activity)">
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                                    Offline
                                                </span>
                                            </template>
                                        </td>

                                        <!-- Role -->
                                        <td class="py-4">
                                            <span class="text-xs font-medium capitalize text-gray-600" x-text="s.role"></span>
                                        </td>

                                        <!-- Program -->
                                        <td class="py-4">
                                            <span class="text-xs font-medium"
                                                  :class="isOnline(s.last_activity) ? 'text-blue-600' : 'text-gray-500'"
                                                  x-text="s.program_name || '—'"></span>
                                        </td>

                                        <!-- Last seen -->
                                        <td class="py-4">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium border"
                                                  :class="isOnline(s.last_activity) ? 'bg-green-50 text-green-700 border-green-100' : 'bg-gray-50 text-gray-500 border-gray-100'"
                                                  x-text="formatTime(s.last_activity)"></span>
                                        </td>

                                        <!-- Action -->
                                        <td class="py-4 text-right" @click.stop>
                                            <template x-if="s.role === 'student'">
                                                <div class="inline-flex flex-col gap-1 items-end">
                                                    <a :href="`/admin/students/${s.id}/current-assignment`"
                                                       target="_blank" rel="noopener"
                                                       class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold rounded-lg transition"
                                                       :class="isOnline(s.last_activity) ? 'bg-green-600 hover:bg-green-700 text-white shadow-sm' : 'bg-blue-50 hover:bg-blue-100 text-blue-700'">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                        <span x-text="isOnline(s.last_activity) ? 'Live View' : 'View Details'"></span>
                                                    </a>
                                                    <a :href="`/admin/students/${s.id}`"
                                                       class="text-xs text-gray-400 hover:text-gray-600 transition">Profile →</a>
                                                </div>
                                            </template>
                                            <template x-if="s.role === 'guest'">
                                                <a :href="`/admin/users/${s.id}`"
                                                   class="px-3 py-1.5 text-xs font-medium text-purple-600 bg-purple-50 hover:bg-purple-100 rounded-lg transition inline-block">
                                                    Manage Guest
                                                </a>
                                            </template>
                                        </td>
                                    </tr>
                                </template>

                                <!-- Empty state -->
                                <tr x-show="filteredStudents.length === 0">
                                    <td colspan="6" class="py-10 text-center text-gray-400">
                                        <svg class="w-10 h-10 mx-auto mb-2 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span x-text="filterOnline ? 'Tidak ada siswa yang sedang online saat ini.' : ('Tidak ada siswa aktif dalam ' + activeWindowHours + ' jam terakhir.')"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Grid -->
                    <div x-show="viewMode === 'grid'">
                        <div x-show="onlineStudentsForGrid.length === 0" class="py-10 text-center text-gray-400">
                            <svg class="w-10 h-10 mx-auto mb-2 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span>Tidak ada siswa yang sedang online saat ini.</span>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                            <template x-for="s in onlineStudentsForGrid" :key="s.id">
                                <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden hover:shadow-md transition-shadow relative">
                                    <!-- Tile header -->
                                    <div class="flex items-center gap-2.5 px-3 py-2.5 border-b border-gray-50">
                                        <div class="relative shrink-0">
                                            <div class="w-8 h-8 rounded-full bg-green-100 text-green-700 flex items-center justify-center font-bold text-xs"
                                                 x-text="s.name ? s.name.charAt(0).toUpperCase() : '?'"></div>
                                            <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full"></span>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm font-semibold text-gray-800 truncate" x-text="s.name"></p>
                                            <p class="text-[11px] text-gray-400 truncate" x-text="s.program_name || '—'"></p>
                                        </div>
                                        <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded-full text-[10px] font-bold bg-green-100 text-green-700 shrink-0">
                                            <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                            LIVE
                                        </span>
                                    </div>

                                    <!-- Tile body: mini live iframe, click-to-expand -->
                                    <div class="relative bg-gray-50" style="height: 220px;">
                                        <template x-if="s.activity_url">
                                            <iframe :src="tileSrc(s)"
                                                    loading="lazy"
                                                    class="w-full h-full border-0 pointer-events-none"
                                                    tabindex="-1"
                                                    title="Live preview"></iframe>
                                        </template>
                                        <template x-if="!s.activity_url">
                                            <div class="w-full h-full flex items-center justify-center text-xs text-gray-400 px-4 text-center">
                                                Halaman belum terdeteksi
                                            </div>
                                        </template>
                                        <!-- Transparent click-catcher: opens the full single-student live view, same as the table's row/action click -->
                                        <div class="absolute inset-0 cursor-pointer"
                                             @click="window.open(`/admin/students/${s.id}/current-assignment`, '_blank', 'noopener')"
                                             title="Buka tampilan penuh"></div>
                                    </div>

                                    <!-- Tile footer -->
                                    <div class="px-3 py-2 flex items-center justify-between text-[11px] text-gray-400 border-t border-gray-50">
                                        <span x-text="formatTime(s.last_activity)"></span>
                                        <span class="text-green-600 font-medium">Klik → lihat layar penuh</span>
                                    </div>
                                </div>
                            </template>
                        </div>

                        <p x-show="onlineStudentsOverflowCount > 0" class="text-xs text-gray-400 text-center mt-4">
                            +<span x-text="onlineStudentsOverflowCount"></span> siswa online lainnya — gunakan mode Tabel untuk melihat semua.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Realtime Monitoring -->
            <div class="mb-8" x-data="{
                loading: false,
                lastRefreshed: null,
                search: '',
                selectedProgram: '',
                filterOnline: false,
                activeWindowHours: 24,
                programOptions: ['IELTS Academic', 'IELTS General', 'PTE', 'Grammar for Writing'],
                teachers: {{ Js::from(array_values(array_map(function($s) {
                    $s = is_object($s) ? $s : (object)$s;
                    return [
                        'id'           => (int)($s->id ?? 0),
                        'name'         => $s->name ?? '',
                        'role'         => $s->role ?? 'teacher',
                        'program_name' => (($s->role ?? '') === 'guest') ? 'Free Test' : ($s->program_name ?? 'No Program'),
                        'last_activity'=> (int)($s->last_activity ?? 0),
                    ];
                }, $activeTeachers ?? []))) }},

                async pollTeachers() {
                    this.loading = true;
                    try {
                        const res = await fetch('{{ route('admin.api.active-teachers') }}?hours=' + this.activeWindowHours, {
                            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                        });
                        const data = await res.json();
                        this.teachers = data.teachers || [];
                        this.lastRefreshed = data.server_time || Math.floor(Date.now()/1000);
                    } catch (e) { console.warn('Poll failed', e); }
                    this.loading = false;
                },

                normalizeProgram(p) {
                    const v = (p || '').toLowerCase();
                    if (v.includes('grammar')) return 'Grammar for Writing';
                    if (v.includes('ielts general')) return 'IELTS General';
                    if (v.includes('ielts')) return 'IELTS Academic';
                    if (v.includes('pte')) return 'PTE';
                    return '';
                },

                get filteredTeachers() {
                    return this.teachers.filter(s => {
                        const q = this.search.toLowerCase();
                        const ok = s.name.toLowerCase().includes(q) || (s.program_name||'').toLowerCase().includes(q);
                        const mp = !this.selectedProgram || this.normalizeProgram(s.program_name) === this.selectedProgram;
                        const mo = !this.filterOnline || this.isOnline(s.last_activity);
                        return ok && mp && mo;
                    }).sort((a,b) => b.last_activity - a.last_activity);
                },

                get onlineCount() {
                    return this.teachers.filter(s => this.isOnline(s.last_activity)).length;
                },

                isOnline(ts) { return (Math.floor(Date.now()/1000) - ts) < 300; },

                formatTime(ts) {
                    if (!ts) return '—';
                    const d = Math.floor(Date.now()/1000) - ts;
                    if (d < 60) return 'Just now';
                    if (d < 3600) return Math.floor(d/60) + 'm ago';
                    if (d < 86400) return Math.floor(d/3600) + 'h ago';
                    return Math.floor(d/86400) + 'd ago';
                },

                formatClock(ts) {
                    if (!ts) return '';
                    return new Date(ts*1000).toLocaleTimeString('id-ID', {hour:'2-digit',minute:'2-digit',second:'2-digit'});
                }
            }" x-init="lastRefreshed = Math.floor(Date.now()/1000); setInterval(() => pollTeachers(), 30000)">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">

                    <!-- Header -->
                    <div class="flex flex-wrap justify-between items-center gap-4 mb-5">
                        <div class="flex items-center gap-3">
                            <h3 class="text-xl font-bold text-gray-800">Recently Active Teachers</h3>
                            <!-- Online badge -->
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold"
                                  :class="onlineCount > 0 ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500'">
                                <span class="relative flex h-2 w-2">
                                    <span x-show="onlineCount > 0" class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2"
                                          :class="onlineCount > 0 ? 'bg-green-500' : 'bg-gray-400'"></span>
                                </span>
                                <span x-text="onlineCount > 0 ? onlineCount + ' Online' : 'Tidak ada yang online'"></span>
                            </span>
                            <!-- Spinner -->
                            <svg x-show="loading" class="w-4 h-4 animate-spin text-blue-400" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                            </svg>
                        </div>
                        <div class="flex items-center gap-3 flex-wrap">
                            <span class="text-xs text-gray-400" x-show="lastRefreshed">
                                Diperbarui: <span x-text="formatClock(lastRefreshed)"></span>
                                &nbsp;·&nbsp;
                                <button @click="pollTeachers()" class="text-blue-500 hover:text-blue-700 font-medium underline-offset-2 hover:underline">Refresh</button>
                            </span>

                            <!-- Toggle Online Saja -->
                            <button @click="filterOnline = !filterOnline"
                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-sm font-medium border transition-colors focus:outline-none"
                                    :class="filterOnline ? 'bg-green-50 text-green-700 border-green-200' : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50'">
                                <span class="relative flex h-2 w-2">
                                    <span x-show="filterOnline" class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75" style="display: none;"></span>
                                    <span class="relative inline-flex rounded-full h-2 w-2"
                                          :class="filterOnline ? 'bg-green-500' : 'bg-gray-400'"></span>
                                </span>
                                <span x-text="filterOnline ? 'Online Saja' : ('Semua (' + activeWindowHours + ' Jam)')"></span>
                            </button>

                            <!-- Active window: how far back "recently active" looks.
                                 Changing this re-polls with ?hours=24|48 (see
                                 AdminController::resolveActiveWindowHours()). -->
                            <select x-model.number="activeWindowHours" @change="pollTeachers()"
                                    class="form-control rounded-xl text-sm border-gray-200">
                                <option value="24">24 Jam Terakhir</option>
                                <option value="48">48 Jam Terakhir</option>
                            </select>

                            <select x-model="selectedProgram" class="form-control rounded-xl text-sm border-gray-200 min-w-[170px]">
                                <option value="">Semua Program</option>
                                <template x-for="p in programOptions" :key="p">
                                    <option :value="p" x-text="p"></option>
                                </template>
                            </select>
                            <input type="text" x-model="search" placeholder="Cari guru..." class="form-control rounded-xl text-sm border-gray-200 w-40">
                        </div>
                    </div>

                    <!-- Hint banner -->
                    <div class="flex items-start gap-2 bg-blue-50 border border-blue-100 text-blue-700 text-xs px-3 py-2 rounded-lg mb-4">
                        <svg class="w-3.5 h-3.5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Klik nama guru yang <strong>Online</strong> untuk membuka tab baru berisi halaman yang sedang dikerjakan secara <em>realtime</em>. Data diperbarui otomatis setiap 30 detik.</span>
                    </div>

                    <!-- Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-gray-400 text-xs uppercase tracking-wide border-b border-gray-100">
                                    <th class="pb-3 font-semibold">Teacher Name</th>
                                    <th class="pb-3 font-semibold">Status</th>
                                    <th class="pb-3 font-semibold">Role</th>
                                    <th class="pb-3 font-semibold">Program / Halaman</th>
                                    <th class="pb-3 font-semibold">Last Seen</th>
                                    <th class="pb-3 font-semibold text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <template x-for="s in filteredTeachers" :key="s.id">
                                    <tr class="border-b border-gray-50 transition group"
                                        :class="{
                                            'hover:bg-green-50 cursor-pointer': isOnline(s.last_activity) && s.role === 'teacher',
                                            'hover:bg-gray-50 cursor-pointer opacity-70': !isOnline(s.last_activity) && s.role === 'teacher',
                                            'opacity-60': s.role !== 'teacher'
                                        }"
                                        @click="if (s.role === 'teacher') window.open(`/admin/teachers/${s.id}/current-assignment`, '_blank', 'noopener')">

                                        <!-- Name + avatar -->
                                        <td class="py-4">
                                            <div class="flex items-center gap-3">
                                                <div class="relative shrink-0">
                                                    <div class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-sm"
                                                         :class="isOnline(s.last_activity) ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500'"
                                                         x-text="s.name ? s.name.charAt(0).toUpperCase() : '?'"></div>
                                                    <span x-show="isOnline(s.last_activity)"
                                                          class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-green-500 border-2 border-white rounded-full"></span>
                                                </div>
                                                <div>
                                                    <span class="font-semibold text-gray-800 block transition-colors"
                                                          :class="isOnline(s.last_activity) && s.role === 'teacher' ? 'group-hover:text-green-700' : ''"
                                                          x-text="s.name"></span>
                                                    <span x-show="isOnline(s.last_activity) && s.role === 'teacher'"
                                                          class="text-xs text-green-600 font-medium">Klik → lihat layar realtime</span>
                                                </div>
                                            </div>
                                        </td>

                                        <!-- Status -->
                                        <td class="py-4">
                                            <template x-if="isOnline(s.last_activity)">
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                                                    Online
                                                </span>
                                            </template>
                                            <template x-if="!isOnline(s.last_activity)">
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span>
                                                    Offline
                                                </span>
                                            </template>
                                        </td>

                                        <!-- Role -->
                                        <td class="py-4">
                                            <span class="text-xs font-medium capitalize text-gray-600" x-text="s.role"></span>
                                        </td>

                                        <!-- Program -->
                                        <td class="py-4">
                                            <span class="text-xs font-medium"
                                                  :class="isOnline(s.last_activity) ? 'text-blue-600' : 'text-gray-500'"
                                                  x-text="s.program_name || '—'"></span>
                                        </td>

                                        <!-- Last seen -->
                                        <td class="py-4">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium border"
                                                  :class="isOnline(s.last_activity) ? 'bg-green-50 text-green-700 border-green-100' : 'bg-gray-50 text-gray-500 border-gray-100'"
                                                  x-text="formatTime(s.last_activity)"></span>
                                        </td>

                                        <!-- Action -->
                                        <td class="py-4 text-right" @click.stop>
                                            <template x-if="s.role === 'teacher'">
                                                <div class="inline-flex flex-col gap-1 items-end">
                                                    <a :href="`/admin/teachers/${s.id}/current-assignment`"
                                                       target="_blank" rel="noopener"
                                                       class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold rounded-lg transition"
                                                       :class="isOnline(s.last_activity) ? 'bg-green-600 hover:bg-green-700 text-white shadow-sm' : 'bg-blue-50 hover:bg-blue-100 text-blue-700'">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                        <span x-text="isOnline(s.last_activity) ? 'Live View' : 'View Details'"></span>
                                                    </a>
                                                    <a :href="`/admin/teachers/${s.id}`"
                                                       class="text-xs text-gray-400 hover:text-gray-600 transition">Profile →</a>
                                                </div>
                                            </template>
                                            <template x-if="s.role === 'guest'">
                                                <a :href="`/admin/users/${s.id}`"
                                                   class="px-3 py-1.5 text-xs font-medium text-purple-600 bg-purple-50 hover:bg-purple-100 rounded-lg transition inline-block">
                                                    Manage Guest
                                                </a>
                                            </template>
                                        </td>
                                    </tr>
                                </template>

                                <!-- Empty state -->
                                <tr x-show="filteredTeachers.length === 0">
                                    <td colspan="6" class="py-10 text-center text-gray-400">
                                        <svg class="w-10 h-10 mx-auto mb-2 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                        <span x-text="filterOnline ? 'Tidak ada guru yang sedang online saat ini.' : ('Tidak ada guru aktif dalam ' + activeWindowHours + ' jam terakhir.')"></span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
