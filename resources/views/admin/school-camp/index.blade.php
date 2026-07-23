@extends('layouts.admin')

@section('title', 'School English Camp Leads')

@section('content')
<div class="p-8 pb-24 max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 flex items-center gap-3">
                <span class="p-2 bg-amber-100 text-amber-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-2 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </span>
                School English Camp Leads
            </h2>
            <p class="text-sm text-gray-500 mt-1">Data pihak sekolah/guru yang mengirimkan inquiry program camp.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('school-program') }}" target="_blank"
               class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                Lihat Landing Page
            </a>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] mb-6 flex flex-wrap gap-4 items-center">
        <form action="{{ route('admin.school-camp.index') }}" method="GET" class="w-full flex gap-3">
            <select name="status" class="bg-gray-50 border border-gray-200 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-2.5">
                <option value="">Semua Status</option>
                <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>New</option>
                <option value="contacted" {{ request('status') === 'contacted' ? 'selected' : '' }}>Contacted</option>
                <option value="converted" {{ request('status') === 'converted' ? 'selected' : '' }}>Converted</option>
                <option value="lost" {{ request('status') === 'lost' ? 'selected' : '' }}>Lost</option>
            </select>
            <button type="submit" class="bg-gray-800 text-white px-4 py-2.5 rounded-xl text-sm font-semibold hover:bg-gray-700 transition">
                Filter
            </button>
            @if(request()->anyFilled(['status']))
                <a href="{{ route('admin.school-camp.index') }}" class="text-gray-500 hover:text-gray-700 px-4 py-2.5 text-sm font-medium transition flex items-center">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- Data Table --}}
    <div class="bg-white border border-gray-100 rounded-2xl shadow-[0_2px_10px_-3px_rgba(6,81,237,0.05)] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left whitespace-nowrap">
                <thead class="text-xs text-gray-500 uppercase bg-gray-50/50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Tgl Masuk</th>
                        <th class="px-6 py-4 font-semibold">Kontak Utama (PIC)</th>
                        <th class="px-6 py-4 font-semibold">Detail Kebutuhan</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($leads as $lead)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4">
                            <div class="text-gray-900 font-medium">{{ $lead->created_at->format('d M Y') }}</div>
                            <div class="text-gray-500 text-xs mt-0.5">{{ $lead->created_at->format('H:i') }}</div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-gray-900">{{ $lead->full_name }}</div>
                            <div class="flex items-center gap-2 mt-1">
                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lead->whatsapp) }}" target="_blank" class="text-green-600 hover:text-green-800 flex items-center gap-1 text-xs bg-green-50 px-2 py-0.5 rounded-md font-medium">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    {{ $lead->whatsapp }}
                                </a>
                            </div>
                            @if($lead->email)
                            <div class="text-gray-500 text-xs mt-1">{{ $lead->email }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="max-w-md text-gray-600 whitespace-normal text-xs" title="{{ $lead->notes }}">
                                {{ $lead->notes }}
                            </div>
                            <div class="text-gray-500 text-xs flex items-center gap-1 mt-2 font-medium">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                {{ $lead->city ?? '-' }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = [
                                    'new'       => 'bg-blue-100 text-blue-800',
                                    'contacted' => 'bg-amber-100 text-amber-800',
                                    'converted' => 'bg-emerald-100 text-emerald-800',
                                    'lost'      => 'bg-red-100 text-red-800',
                                ];
                                $statusClass = $statusColors[$lead->status] ?? 'bg-gray-100 text-gray-800';
                            @endphp
                            <span class="px-2.5 py-1 rounded-md text-xs font-semibold {{ $statusClass }} uppercase tracking-wider">
                                {{ $lead->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.registration-leads.show', $lead) }}" class="inline-flex items-center gap-1 text-blue-600 hover:text-blue-800 font-medium text-sm transition">
                                <span>Detail</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                            <div class="flex flex-col items-center">
                                <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <p class="text-base font-medium text-gray-900">Belum ada leads</p>
                                <p class="text-sm">Belum ada pihak sekolah yang mendaftar program ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($leads->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/30">
            {{ $leads->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
