@extends('layouts.admin')

@section('title', 'Registration Leads')

@section('content')
<div class="p-8 pb-24 max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 flex items-center gap-3">
                <span class="p-2 bg-blue-100 text-blue-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                </span>
                Registration Leads
            </h2>
            <p class="text-sm text-gray-500 mt-1">Data calon peserta yang mengisi formulir pendaftaran.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.registration-leads.export', array_merge(request()->query(), ['export_preset' => 'registration_leads_filtered'])) }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white text-sm font-semibold rounded-xl hover:bg-emerald-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m0 0l-5-5m5 5l5-5M5 19h14"/></svg>
                Export CSV
            </a>
            <a href="{{ route('class-periods.index') }}"
               class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-50 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                Kelola Batch
            </a>
            <a href="{{ route('registration.show') }}" target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Lihat Form Publik
            </a>
        </div>
    </div>

    {{-- Top Metrics Row --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-5 mb-6">
        @foreach([
            ['label'=>'Total Leads',      'value'=>$metrics['total'],           'color'=>'blue'],
            ['label'=>'Leads Baru',       'value'=>$metrics['new'],             'color'=>'indigo'],
            ['label'=>'Converted',        'value'=>$metrics['converted'],       'color'=>'emerald'],
            ['label'=>'Hasil Filter',     'value'=>$attributionInsights['filtered_total'] ?? 0,'color'=>'slate'],
        ] as $m)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] p-5 flex flex-col justify-between relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-16 h-16 rounded-full bg-{{ $m['color'] }}-50 transition-transform group-hover:scale-110"></div>
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest relative z-10">{{ $m['label'] }}</p>
            <p class="text-3xl font-extrabold text-gray-900 mt-2 relative z-10">{{ $m['value'] }}</p>
        </div>
        @endforeach
    </div>

    {{-- Quick Access Tags --}}
    <div class="flex flex-wrap gap-2 mb-6 items-center">
        <span class="text-xs font-bold text-gray-400 uppercase tracking-wide mr-2 flex items-center gap-1">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            Quick Filter:
        </span>
        <a href="{{ route('admin.registration-leads.index', array_merge(request()->except(['hot','converted_today','page']), ['hot' => 1])) }}"
           class="px-3 py-1 rounded-full text-xs font-bold tracking-wide transition {{ request()->boolean('hot') ? 'bg-red-100 text-red-700 border border-red-200' : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50' }}">
            🔥 Hot 24 Jam ({{ $metrics['hot'] }})
        </a>
        <a href="{{ route('admin.registration-leads.index', array_merge(request()->except(['hot','converted_today','page']), ['converted_today' => 1])) }}"
           class="px-3 py-1 rounded-full text-xs font-bold tracking-wide transition {{ request()->boolean('converted_today') ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50' }}">
            ✅ Converted Hari Ini ({{ $metrics['converted_today'] }})
        </a>
        @foreach([7, 14, 30] as $window)
            <a href="{{ route('admin.registration-leads.index', array_merge(request()->except(['date_window','date_from','date_to','page']), ['date_window' => $window])) }}"
               class="px-3 py-1 rounded-full text-xs font-bold tracking-wide transition {{ (int) ($activeDateWindow ?? 0) === $window ? 'bg-blue-100 text-blue-700 border border-blue-200' : 'bg-white text-gray-500 border border-gray-200 hover:bg-gray-50' }}">
                {{ $window }} Hari
            </a>
        @endforeach
        @if(request()->hasAny(['hot','converted_today','converted_only','date_window','date_from','date_to']))
            <a href="{{ route('admin.registration-leads.index', request()->except(['hot','converted_today','converted_only','date_window','date_from','date_to','page'])) }}"
               class="px-2 py-1 rounded-md text-[11px] font-bold bg-gray-100 text-gray-500 hover:bg-gray-200 transition ml-auto">
                TAMPILKAN SEMUA
            </a>
        @endif
    </div>

    {{-- Main Filter Box --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] p-5 mb-8" x-data="{ showAdvanced: {{ request()->hasAny(['utm_source','utm_campaign','acquisition_source_page','acquisition_last_cta','date_from','date_to','program_id','class_period_id','mode']) ? 'true' : 'false' }} }">
        <form method="GET" action="{{ route('admin.registration-leads.index') }}">
            <div class="flex flex-col md:flex-row gap-4 items-end">
                <div class="flex-1 w-full">
                    <label class="block text-xs font-bold text-gray-500 mb-1.5 uppercase tracking-wide">Pencarian</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, WA, email, kota..."
                               class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none transition bg-gray-50 focus:bg-white">
                    </div>
                </div>
                <div class="w-full md:w-48">
                    <label class="block text-xs font-bold text-gray-500 mb-1.5 uppercase tracking-wide">Status</label>
                    <select name="status" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-gray-50 focus:bg-white cursor-pointer appearance-none transition">
                        <option value="">Semua Status</option>
                        <option value="new"       {{ request('status')==='new'       ? 'selected' : '' }}>Baru</option>
                        <option value="contacted" {{ request('status')==='contacted' ? 'selected' : '' }}>Dihubungi</option>
                        <option value="converted" {{ request('status')==='converted' ? 'selected' : '' }}>Converted</option>
                        <option value="cancelled" {{ request('status')==='cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div class="flex items-center gap-2 w-full md:w-auto">
                    <button type="submit" class="flex-1 md:flex-none px-6 py-2.5 bg-slate-800 text-white text-sm font-bold rounded-xl hover:bg-slate-900 transition shadow-md shadow-slate-200 whitespace-nowrap">
                        Cari & Filter
                    </button>
                    <button type="button" @click="showAdvanced = !showAdvanced" class="p-2.5 border border-gray-200 text-gray-500 rounded-xl hover:bg-gray-50 transition bg-white" title="Advanced Filters">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                    </button>
                    @if(request()->hasAny(['search','status','mode','program_id','class_period_id','utm_source','utm_campaign','acquisition_source_page','acquisition_last_cta','date_window','date_from','date_to','sort_by','sort_dir','hot','converted_today','converted_only']))
                        <a href="{{ route('admin.registration-leads.index') }}" class="p-2.5 border border-red-100 text-red-500 bg-red-50 rounded-xl hover:bg-red-100 hover:text-red-600 transition" title="Reset Filters">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </a>
                    @endif
                </div>
            </div>
            
            <div x-show="showAdvanced" x-collapse class="mt-5 pt-5 border-t border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Program</label>
                        <select name="program_id" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-blue-500 outline-none bg-white">
                            <option value="">Semua Program</option>
                            @foreach($programs as $prog)
                                <option value="{{ $prog->id }}" {{ request('program_id')==$prog->id ? 'selected' : '' }}>{{ $prog->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Batch Kelas</label>
                        <select name="class_period_id" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-blue-500 outline-none bg-white">
                            <option value="">Semua Batch</option>
                            @foreach($classPeriods as $period)
                                <option value="{{ $period->id }}" {{ request('class_period_id')==$period->id ? 'selected' : '' }}>
                                    {{ $period->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Mode</label>
                        <select name="mode" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-blue-500 outline-none bg-white">
                            <option value="">Semua Mode</option>
                            <option value="online"   {{ request('mode')==='online'   ? 'selected' : '' }}>Online</option>
                            <option value="offline"  {{ request('mode')==='offline'  ? 'selected' : '' }}>Offline</option>
                            <option value="flexible" {{ request('mode')==='flexible' ? 'selected' : '' }}>Fleksibel</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Source Page (Attribution)</label>
                        <input type="text" name="acquisition_source_page" value="{{ request('acquisition_source_page') }}" placeholder="Ex: whv-application"
                               class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-blue-500 outline-none bg-white">
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Success flash --}}
    @if(session('success'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100 bg-gray-50">
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Lead</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Program</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Batch</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Mode</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Jadwal</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Attribution</th>
                        <th class="text-left px-4 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wide">Daftar</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($leads as $lead)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3">
                            <div class="font-semibold text-gray-800">{{ $lead->full_name }}</div>
                            <div class="text-xs text-gray-400">{{ $lead->city }} · {{ $lead->whatsapp }}</div>
                            <div class="mt-1 flex flex-wrap gap-1">
                                @if($lead->status === 'new' && $lead->created_at && $lead->created_at->gte(now()->subDay()))
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-700">HOT</span>
                                @endif
                                @if($lead->converted_at && $lead->converted_at->isToday())
                                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700">CONVERTED TODAY</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            @if($lead->program)
                                <span class="text-xs font-medium text-gray-700">{{ $lead->program->name }}</span>
                            @elseif($lead->program_interest)
                                <span class="text-xs text-gray-400 italic">{{ $lead->program_interest }}</span>
                            @else
                                <span class="text-xs text-gray-300">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @if($lead->classPeriod)
                                <div class="text-xs font-medium text-gray-700">{{ $lead->classPeriod->name }}</div>
                                <div class="text-[11px] text-gray-400">{{ $lead->classPeriod->start_date?->format('d M Y') ?? '-' }}</div>
                            @else
                                <span class="text-xs text-gray-300">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $modeColor = match($lead->mode) {
                                    'online'   => 'bg-purple-100 text-purple-700',
                                    'offline'  => 'bg-orange-100 text-orange-700',
                                    'flexible' => 'bg-teal-100 text-teal-700',
                                    default    => 'bg-gray-100 text-gray-600',
                                };
                            @endphp
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $modeColor }}">
                                {{ ucfirst($lead->mode) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-500">
                            {{ ucfirst($lead->schedule_preference) }} / {{ ucfirst($lead->preferred_time) }}
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $statusColor = match($lead->status) {
                                    'new'       => 'bg-blue-100 text-blue-700',
                                    'contacted' => 'bg-yellow-100 text-yellow-700',
                                    'converted' => 'bg-green-100 text-green-700',
                                    'cancelled' => 'bg-red-100 text-red-700',
                                    default     => 'bg-gray-100 text-gray-600',
                                };
                            @endphp
                            <span class="px-2 py-0.5 rounded-full text-xs font-semibold {{ $statusColor }}">
                                {{ ucfirst($lead->status) }}
                            </span>
                            @if($lead->convertedUser)
                                <div class="mt-1">
                                    <a href="{{ route('students.show', $lead->convertedUser) }}" class="text-[11px] font-medium text-emerald-600 hover:text-emerald-800 transition">
                                        Student #{{ $lead->convertedUser->id }}
                                    </a>
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-500">
                            <div>{{ $lead->acquisition_source_page ?: '—' }}</div>
                            <div class="text-[11px] text-gray-400">{{ $lead->utm_campaign ?: ($lead->utm_source ?: 'No UTM') }}</div>
                            @if($lead->acquisition_last_cta)
                                <div class="mt-1 inline-flex px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 text-[10px] font-semibold">
                                    {{ $lead->acquisition_last_cta }}
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-400">
                            {{ $lead->created_at ? $lead->created_at->format('d M Y') : '-' }}
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.registration-leads.show', $lead) }}"
                               class="text-xs font-semibold text-blue-600 hover:text-blue-800 transition">
                                Detail →
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-16 text-gray-400 text-sm">
                            <svg class="w-12 h-12 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Belum ada data lead.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($leads->hasPages())
            <div class="px-4 py-3 border-t border-gray-100">
                {{ $leads->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
