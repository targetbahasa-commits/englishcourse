<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Listening Bank — {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50">
@include('components.impersonation-banner')
<div class="flex min-h-screen">
    @include('components.sidebar-admin')

    <main class="flex-1 md:ml-64">

        {{-- ── Header ── --}}
        <div class="bg-white border-b border-gray-200 px-8 py-6">
            <div class="max-w-7xl mx-auto flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                        <span class="w-10 h-10 rounded-xl bg-violet-100 flex items-center justify-center">
                            <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                            </svg>
                        </span>
                        Listening Bank
                    </h1>
                    <p class="mt-1 text-sm text-gray-500">AI-powered IELTS/TOEFL listening material generator</p>
                </div>
                <a href="{{ route('admin.listening-machine.create', ['new' => 1]) }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 bg-violet-600 hover:bg-violet-700 text-white text-sm font-semibold rounded-xl transition shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create New Material
                </a>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-8 py-8 space-y-8">

            {{-- ── Flash message ── --}}
            @if(session('success'))
            <div class="flex items-center gap-3 p-4 bg-green-50 border border-green-200 rounded-xl text-green-800 text-sm font-medium">
                <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
            @endif

            {{-- ── Stats ── --}}
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                @php
                    $statCards = [
                        ['label' => 'Total Banks',  'value' => $stats['total'],      'color' => 'violet', 'icon' => 'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3'],
                        ['label' => 'Ready',        'value' => $stats['ready'],      'color' => 'green',  'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['label' => 'Processing',   'value' => $stats['processing'], 'color' => 'amber',  'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z'],
                        ['label' => 'Draft',        'value' => $stats['draft'],      'color' => 'gray',   'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                    ];
                @endphp
                @foreach($statCards as $card)
                <div class="bg-white rounded-xl border border-gray-200 p-5 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-{{ $card['color'] }}-100 flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-{{ $card['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-2xl font-bold text-gray-900">{{ $card['value'] }}</p>
                        <p class="text-xs text-gray-500 font-medium">{{ $card['label'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- ── Filters ── --}}
            <form method="GET" class="flex flex-wrap gap-3 items-center">
                <div class="relative flex-1 min-w-[200px]">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search title or topic…"
                           class="w-full pl-10 pr-4 py-2.5 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-violet-500 focus:border-transparent">
                </div>
                <select name="status" class="py-2.5 px-4 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-violet-500">
                    <option value="">All Statuses</option>
                    @foreach(['draft','processing','ready','failed'] as $s)
                    <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <select name="level" class="py-2.5 px-4 text-sm border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-violet-500">
                    <option value="">All Levels</option>
                    @foreach(['Band 4','Band 5','Band 6','Band 7','Band 8','Band 9','TOEFL 400','TOEFL 500','TOEFL 600'] as $l)
                    <option value="{{ $l }}" @selected(request('level') === $l)>{{ $l }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-5 py-2.5 bg-gray-800 text-white text-sm font-semibold rounded-xl hover:bg-gray-900 transition">
                    Filter
                </button>
                @if(request()->hasAny(['search','status','level']))
                <a href="{{ route('admin.listening-machine.index') }}" class="px-4 py-2.5 text-sm text-gray-600 hover:text-gray-900 transition">Clear</a>
                @endif
            </form>

            {{-- ── Table ── --}}
            <div class="bg-white rounded-2xl border border-gray-200 overflow-hidden shadow-sm" x-data="draftManager()">
                
                {{-- Empty State --}}
                <div x-show="!hasDraft && {{ $banks->isEmpty() ? 'true' : 'false' }}" x-cloak class="flex flex-col items-center justify-center py-24 text-gray-400">
                    <svg class="w-16 h-16 mb-4 text-violet-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"/>
                    </svg>
                    <p class="text-lg font-semibold text-gray-600">No materials yet</p>
                    <p class="text-sm mt-1">Create your first AI-generated listening material.</p>
                    <a href="{{ route('admin.listening-machine.create', ['new' => 1]) }}" class="mt-4 px-5 py-2 bg-violet-600 text-white text-sm font-semibold rounded-xl hover:bg-violet-700 transition">
                        + Create Now
                    </a>
                </div>

                <div x-show="hasDraft || {{ $banks->isNotEmpty() ? 'true' : 'false' }}" x-cloak class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="text-left px-6 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Material</th>
                                <th class="text-left px-4 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Level</th>
                                <th class="text-left px-4 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Voice</th>
                                <th class="text-left px-4 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Questions</th>
                                <th class="text-left px-4 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Duration</th>
                                <th class="text-left px-4 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Status</th>
                                <th class="text-left px-4 py-3.5 font-semibold text-gray-600 text-xs uppercase tracking-wide">Audio</th>
                                <th class="px-4 py-3.5"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            {{-- DRAFT ROW --}}
                            <tr x-show="hasDraft" class="bg-amber-50/40 hover:bg-amber-50 transition border-l-4 border-l-amber-400">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="bg-amber-100 text-amber-800 text-[10px] font-bold px-2 py-0.5 rounded uppercase tracking-wider">Unsaved Draft</span>
                                        <span class="text-xs text-amber-600 font-medium" x-text="'Step ' + draftData.step"></span>
                                    </div>
                                    <p class="font-semibold text-gray-900" x-text="draftData.title || '(Untitled)'"></p>
                                    <p class="text-xs text-gray-500 mt-0.5" x-text="(draftData.topic || '—') + ' · ' + (draftData.accent || '—')"></p>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-700 text-xs font-semibold" x-text="draftData.level || '—'"></span>
                                </td>
                                <td class="px-4 py-4 text-gray-600 text-xs" x-text="draftData.voice || '—'"></td>
                                <td class="px-4 py-4">
                                    <span class="font-semibold text-gray-800" x-text="draftData.questionsCount || 0"></span>
                                    <span class="text-gray-400 text-xs"> Qs</span>
                                </td>
                                <td class="px-4 py-4 text-gray-600 font-mono text-xs" x-text="draftData.duration ? Math.floor(draftData.duration/60) + ':' + String(draftData.duration%60).padStart(2,'0') : '—'"></td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                        Local Draft
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="text-gray-400 text-xs italic">Not saved yet</span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.listening-machine.create') }}" class="px-3 py-1.5 bg-amber-100 text-amber-800 hover:bg-amber-200 text-xs font-bold rounded-lg transition whitespace-nowrap">Continue Work →</a>
                                        <button @click="clearDraft()" class="p-2 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Delete Draft">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>

                            @foreach($banks as $bank)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-900">{{ $bank->title }}</p>
                                    <p class="text-xs text-gray-400 mt-0.5">{{ $bank->topic ?? '—' }} · {{ $bank->accent }}</p>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-700 text-xs font-semibold">
                                        {{ $bank->level }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-gray-600 text-xs">{{ $bank->voice }}</td>
                                <td class="px-4 py-4">
                                    <span class="font-semibold text-gray-800">{{ $bank->questions_count }}</span>
                                    <span class="text-gray-400 text-xs"> Qs</span>
                                </td>
                                <td class="px-4 py-4 text-gray-600 font-mono text-xs">{{ $bank->duration_formatted }}</td>
                                <td class="px-4 py-4">
                                    @php
                                        $statusMap = [
                                            'ready'      => 'bg-green-100 text-green-700',
                                            'processing' => 'bg-amber-100 text-amber-700',
                                            'draft'      => 'bg-gray-100 text-gray-600',
                                            'failed'     => 'bg-red-100 text-red-700',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $statusMap[$bank->status] ?? 'bg-gray-100 text-gray-600' }}">
                                        {{ ucfirst($bank->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-4">
                                    @if($bank->audio_url)
                                    <audio controls class="h-8 w-44 rounded-lg" style="accent-color: #7c3aed;">
                                        <source src="{{ $bank->audio_url }}" type="audio/mpeg">
                                    </audio>
                                    @else
                                    <span class="text-gray-400 text-xs italic">No audio</span>
                                    @endif
                                </td>
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('admin.listening-machine.show', $bank) }}"
                                           class="p-2 text-gray-500 hover:text-violet-600 hover:bg-violet-50 rounded-lg transition" title="View">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.listening-machine.destroy', $bank) }}" method="POST"
                                              onsubmit="return confirm('Delete this listening bank?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 text-gray-500 hover:text-red-600 hover:bg-red-50 rounded-lg transition" title="Delete">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @if($banks->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $banks->links() }}
                </div>
                @endif
            </div>

        </div>{{-- /max-w --}}
    </main>
</div>
<script>
function draftManager() {
    return {
        hasDraft: false,
        draftData: {},
        init() {
            const raw = localStorage.getItem('listening_wizard_draft');
            if (raw) {
                try {
                    const parsed = JSON.parse(raw);
                    // Check if there is anything substantial
                    if (parsed.form && (parsed.form.title || parsed.form.rawTranscript)) {
                        this.hasDraft = true;
                        this.draftData = {
                            title: parsed.form.title,
                            topic: parsed.form.topic,
                            accent: parsed.form.accent,
                            level: parsed.form.level,
                            voice: parsed.form.voice,
                            questionsCount: parsed.questions ? parsed.questions.length : 0,
                            duration: parsed.form.duration,
                            step: parsed.currentStep || 1
                        };
                    }
                } catch(e) {}
            }
        },
        clearDraft() {
            if (confirm('Are you sure you want to delete your unsaved draft?')) {
                localStorage.removeItem('listening_wizard_draft');
                this.hasDraft = false;
            }
        }
    }
}
</script>
</body>
</html>
