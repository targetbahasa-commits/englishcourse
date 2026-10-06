@extends('layouts.admin')

@section('title', 'Booking Class')

@section('content')
<div class="p-8" x-data="{
    selected: [],
    pageIds: {{ Js::from($bookings->pluck('id')->all()) }},
    allSelected() {
        return this.pageIds.length > 0 && this.pageIds.every(id => this.selected.includes(id));
    },
    toggleAll() {
        if (this.allSelected()) {
            this.selected = this.selected.filter(id => !this.pageIds.includes(id));
        } else {
            this.pageIds.forEach(id => { if (!this.selected.includes(id)) this.selected.push(id); });
        }
    },
    toggleOne(id) {
        const idx = this.selected.indexOf(id);
        if (idx === -1) { this.selected.push(id); } else { this.selected.splice(idx, 1); }
    },
    exportUrl() {
        return '{{ route('admin.bookings.export') }}?' + this.selected.map(id => 'enrollment_ids[]=' + id).join('&');
    }
}">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">Booking Class</h2>
            <p class="text-sm text-gray-500 mt-1">Semua student yang booking batch kelas sendiri lewat menu Booking Class.</p>
        </div>
        <div class="flex items-center gap-3 flex-wrap">
            <a :href="selected.length ? exportUrl() : null"
               :class="selected.length ? 'bg-emerald-600 hover:bg-emerald-700 text-white cursor-pointer' : 'bg-gray-100 text-gray-400 cursor-not-allowed pointer-events-none'"
               class="inline-flex items-center px-4 py-2 rounded-lg font-semibold text-sm transition ease-in-out duration-150 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                <span x-text="selected.length ? 'Download Data (' + selected.length + ')' : 'Download Data'"></span>
            </a>
            <div x-data="{ 
                copied: false, 
                link: 'https://targetbahasa.com/booking-class',
                copyLink() {
                    (window.copyToClipboard ? window.copyToClipboard(this.link) : Promise.reject())
                    .then(() => {
                        this.copied = true;
                        setTimeout(() => this.copied = false, 2500);
                    }).catch(() => {
                        alert('Gagal menyalin link. Silakan salin manual:\n' + this.link);
                    });
                }
            }">
                <button type="button" 
                        @click="copyLink()" 
                        class="inline-flex items-center px-4 py-2 bg-white border border-blue-200 text-blue-700 hover:bg-blue-50 rounded-lg font-semibold text-sm transition ease-in-out duration-150 shadow-sm cursor-pointer">
                    <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                    </svg>
                    <span x-text="copied ? '✓ Link Disalin!' : 'Salin Link Booking'">Salin Link Booking</span>
                </button>
            </div>
            <a href="https://targetbahasa.com/booking-class" target="_blank" rel="noopener" class="inline-flex items-center px-4 py-2 bg-white border border-emerald-200 text-emerald-700 hover:bg-emerald-50 rounded-lg font-semibold text-sm transition ease-in-out duration-150 shadow-sm">
                <svg class="w-4 h-4 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
                Lihat Tampilan Student
            </a>
            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'preview-booking-form')" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                Preview Booking Form
            </button>
            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-booking')" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Daftarkan Booking
            </button>
        </div>
    </div>

    {{-- Ringkasan Jumlah Pendaftar --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-5">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Booking Terdaftar</p>
            <p class="text-3xl font-bold text-gray-900 mt-1">{{ $totalBookings }}</p>
            <p class="text-xs text-gray-400 mt-1">Seluruh student yang sudah booking batch (mandiri + didaftarkan admin).</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-5">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Program Terpopuler</p>
            @php
                $topProgramId = $programBookingCounts->keys()->sortByDesc(fn($id) => $programBookingCounts[$id])->first();
                $topProgram = $topProgramId ? $programs->firstWhere('id', $topProgramId) : null;
            @endphp
            <p class="text-xl font-bold text-gray-900 mt-1 truncate">{{ $topProgram->name ?? '-' }}</p>
            <p class="text-xs text-gray-400 mt-1">{{ $topProgram ? ($programBookingCounts[$topProgramId] . ' student booking') : 'Belum ada booking' }}</p>
        </div>
        <div class="bg-white border border-gray-100 rounded-xl shadow-sm p-5">
            <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Batch Hampir Penuh</p>
            @php
                $nearFullPeriod = $bookablePeriods->filter(fn($p) => $p->max_capacity)->sortByDesc(fn($p) => $p->occupied_count / max($p->max_capacity, 1))->first();
            @endphp
            @if($nearFullPeriod)
                <p class="text-sm font-bold text-gray-900 mt-1 truncate">{{ $nearFullPeriod->name }}</p>
                <p class="text-xs {{ $nearFullPeriod->occupied_count >= $nearFullPeriod->max_capacity ? 'text-red-500 font-semibold' : 'text-gray-400' }} mt-1">
                    {{ $nearFullPeriod->occupied_count }}/{{ $nearFullPeriod->max_capacity }} terisi
                </p>
            @else
                <p class="text-sm text-gray-400 mt-1">Belum ada data batch.</p>
            @endif
        </div>
    </div>

    <form method="GET" action="{{ route('admin.bookings.index') }}" class="flex flex-wrap gap-4 mb-6">
        <select name="program_id" onchange="this.form.submit()" class="rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 shadow-sm">
            <option value="">Semua Program</option>
            @foreach ($programs as $program)
                <option value="{{ $program->id }}" {{ request('program_id') == $program->id ? 'selected' : '' }}>
                    {{ $program->name }} ({{ $programBookingCounts[$program->id] ?? 0 }})
                </option>
            @endforeach
        </select>
        <select name="batch_type" onchange="this.form.submit()" class="rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 shadow-sm">
            <option value="">Semua Tipe Batch</option>
            <option value="regular" {{ request('batch_type') === 'regular' ? 'selected' : '' }}>Reguler</option>
            <option value="semi_private" {{ request('batch_type') === 'semi_private' ? 'selected' : '' }}>Semi-Private</option>
            <option value="private" {{ request('batch_type') === 'private' ? 'selected' : '' }}>Private</option>
        </select>
        @if(request('program_id') || request('batch_type'))
            <a href="{{ route('admin.bookings.index') }}" class="inline-flex items-center px-3 py-2 text-sm text-gray-500 hover:text-gray-700">Reset filter</a>
        @endif
    </form>

    {{-- Konfirmasi Kuota Kelas: batch yang sudah mencapai kuota minimum, menunggu keputusan admin --}}
    @if($pendingQuotaDecisions->isNotEmpty())
    <div class="bg-white border border-amber-200 rounded-xl shadow-sm mb-6 overflow-hidden">
        <div class="px-6 py-4 border-b border-amber-100 bg-amber-50">
            <h3 class="font-bold text-amber-900 text-sm">Konfirmasi Kuota Kelas</h3>
            <p class="text-xs text-amber-700 mt-0.5">Batch berikut sudah mencapai jumlah peserta minimum. Konfirmasi ke student jika kelas dipastikan berjalan (misal tutor sudah tersedia), atau tolak jika belum.</p>
        </div>
        <div class="divide-y divide-gray-100">
            @foreach ($pendingQuotaDecisions as $period)
                <div class="px-6 py-3 flex items-center gap-4">
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $period->program->name ?? '-' }} &mdash; {{ $period->name }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">
                            {{ $period->occupied_count }}/{{ $period->min_capacity ?? '-' }} peserta (kuota minimum)
                            @if($period->quota_met_decision === 'rejected')
                                <span class="ml-2 inline-block px-2 py-0.5 rounded-full bg-red-50 text-red-600 font-semibold text-[10px] uppercase">Ditolak &middot; {{ $period->quota_met_decided_at?->diffForHumans() }}</span>
                            @else
                                <span class="ml-2 inline-block px-2 py-0.5 rounded-full bg-amber-50 text-amber-600 font-semibold text-[10px] uppercase">Menunggu Keputusan</span>
                            @endif
                        </p>
                    </div>
                    <div class="shrink-0 flex items-center gap-2">
                        <form method="POST" action="{{ route('admin.bookings.quota.send', $period) }}">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-emerald-50 border border-emerald-200 rounded-md font-semibold text-xs text-emerald-700 hover:bg-emerald-100 transition ease-in-out duration-150 shadow-sm">
                                Kirim ke Siswa
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.bookings.quota.reject', $period) }}" onsubmit="return confirm('Tolak konfirmasi batch ini ke student? Anda tetap bisa mengirim nanti kapan saja.');">
                            @csrf
                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-50 border border-red-200 rounded-md font-semibold text-xs text-red-700 hover:bg-red-100 transition ease-in-out duration-150 shadow-sm">
                                Tolak
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Ringkasan Kapasitas per Batch --}}
    @if($bookablePeriods->isNotEmpty())
    <div class="bg-white border border-gray-100 rounded-xl shadow-sm mb-6 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100">
            <h3 class="font-bold text-gray-800 text-sm">Jumlah Pendaftar per Batch</h3>
            <p class="text-xs text-gray-400 mt-0.5">Kuota terisi untuk setiap batch kelas yang sedang aktif/akan datang.</p>
        </div>
        <div class="divide-y divide-gray-100 max-h-80 overflow-y-auto">
            @foreach ($bookablePeriods as $period)
                @php
                    $max = $period->max_capacity;
                    $pct = $max ? min(100, round(($period->occupied_count / $max) * 100)) : 0;
                    $isFull = $max && $period->occupied_count >= $max;
                @endphp
                <div class="px-6 py-3 flex items-center gap-4">
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $period->program->name ?? '-' }} &mdash; {{ $period->name }}</p>
                        <div class="w-full bg-gray-100 rounded-full h-1.5 mt-1.5">
                            <div class="h-1.5 rounded-full {{ $isFull ? 'bg-red-500' : 'bg-blue-500' }}" style="width: {{ $max ? $pct : 8 }}%"></div>
                        </div>
                    </div>
                    <div class="shrink-0 text-right">
                        <span class="text-sm font-bold {{ $isFull ? 'text-red-600' : 'text-gray-700' }}">{{ $period->occupied_count }}{{ $max ? '/' . $max : '' }}</span>
                        @if($isFull)
                            <span class="block text-[10px] font-bold text-red-500 uppercase">Penuh</span>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
        @if($bookings->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                <div class="bg-gray-50 p-4 rounded-full mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900">Belum ada booking</h3>
                <p class="text-gray-500 mt-1 max-w-sm">Belum ada student yang booking batch kelas secara mandiri.</p>
            </div>
        @else
            @php
                $batchTypeLabels = ['regular' => 'Reguler', 'semi_private' => 'Semi-Private', 'private' => 'Private'];
                $batchTypeColors = ['regular' => 'bg-blue-100 text-blue-800', 'semi_private' => 'bg-purple-100 text-purple-800', 'private' => 'bg-amber-100 text-amber-800'];
            @endphp
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-4 text-left">
                                <input type="checkbox" :checked="allSelected()" @change="toggleAll()" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Student</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Program</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Batch</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tipe</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Waktu Booking</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($bookings as $booking)
                            @php
                                $contactEmail = $booking->user->email ?? null;
                                $contactPhoneRaw = $booking->user->phone_number ?? null;
                                $contactPhoneDigits = $contactPhoneRaw ? preg_replace('/\D/', '', $contactPhoneRaw) : null;
                                $waNumber = null;
                                if ($contactPhoneDigits) {
                                    $waNumber = str_starts_with($contactPhoneDigits, '0')
                                        ? '62' . substr($contactPhoneDigits, 1)
                                        : $contactPhoneDigits;
                                }
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox" :checked="selected.includes({{ $booking->id }})" @change="toggleOne({{ $booking->id }})" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500 cursor-pointer">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $booking->user->name ?? '-' }}</div>

                                    @if($contactEmail)
                                        <div class="flex items-center gap-1 mt-0.5" x-data="{ copied: false }">
                                            <svg class="w-3 h-3 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                                            <a href="mailto:{{ $contactEmail }}" class="text-xs text-gray-500 hover:text-blue-600 hover:underline" title="Kirim email ke {{ $contactEmail }}">{{ $contactEmail }}</a>
                                            <button type="button"
                                                    @click="window.copyToClipboard('{{ $contactEmail }}').then(() => { copied = true; setTimeout(() => copied = false, 1500); })"
                                                    class="text-gray-300 hover:text-gray-600 shrink-0" title="Salin email">
                                                <svg x-show="!copied" class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                                                <svg x-show="copied" x-cloak class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                            </button>
                                        </div>
                                    @endif

                                    @if($waNumber)
                                        <div class="flex items-center gap-1 mt-0.5" x-data="{ copied: false }">
                                            <svg class="w-3 h-3 text-green-500 shrink-0" fill="currentColor" viewBox="0 0 24 24"><path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38a9.9 9.9 0 004.74 1.21h.01c5.46 0 9.9-4.45 9.9-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0012.04 2zm0 18.15a8.2 8.2 0 01-4.18-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.22 8.22 0 01-1.26-4.38c0-4.54 3.7-8.24 8.24-8.24 2.2 0 4.27.86 5.82 2.42a8.18 8.18 0 012.41 5.83c0 4.54-3.7 8.23-8.24 8.23zm4.52-6.17c-.25-.12-1.47-.72-1.7-.81-.23-.08-.39-.12-.56.13-.17.24-.64.8-.78.97-.14.17-.29.19-.53.06-.25-.12-1.05-.39-2-1.23-.74-.66-1.24-1.47-1.39-1.72-.14-.25-.02-.38.11-.51.11-.11.25-.29.37-.43.12-.15.16-.25.24-.41.08-.17.04-.31-.02-.44-.06-.12-.56-1.35-.77-1.85-.2-.48-.41-.42-.56-.43-.15-.01-.31-.01-.48-.01-.17 0-.44.06-.67.31-.23.25-.87.85-.87 2.08 0 1.22.89 2.4 1.01 2.57.12.17 1.76 2.68 4.26 3.76.6.26 1.06.41 1.43.53.6.19 1.14.16 1.57.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.07.14-1.18-.06-.1-.22-.16-.47-.28z"/></svg>
                                            <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener" class="text-xs text-gray-500 hover:text-green-600 hover:underline" title="Chat WhatsApp {{ $contactPhoneRaw }}">{{ $contactPhoneRaw }}</a>
                                            <button type="button"
                                                    @click="window.copyToClipboard('{{ $contactPhoneRaw }}').then(() => { copied = true; setTimeout(() => copied = false, 1500); })"
                                                    class="text-gray-300 hover:text-gray-600 shrink-0" title="Salin nomor WhatsApp">
                                                <svg x-show="!copied" class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                                                <svg x-show="copied" x-cloak class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                            </button>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $booking->program->name ?? '-' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                                    {{ $booking->classPeriod->name ?? '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php $bt = $booking->classPeriod->batch_type ?? null; @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $batchTypeColors[$bt] ?? 'bg-gray-100 text-gray-600' }}">
                                        {{ $batchTypeLabels[$bt] ?? ucfirst($bt ?? '-') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $booking->class_period_booked_at->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <div class="flex items-center gap-1" x-data="{ copied: false }">
                                            <button type="button"
                                                    x-on:click="$dispatch('open-register-lead', {
                                                        enrollmentId: {{ $booking->id }},
                                                        studentName: @js($booking->user->name ?? '-'),
                                                        studentEmail: @js($booking->user->email ?? '-'),
                                                        studentPhone: @js($booking->user->phone_number ?? '-'),
                                                        programId: {{ $booking->program_id ?? 'null' }},
                                                        programName: @js($booking->program->name ?? '-'),
                                                        periodId: {{ $booking->class_period_id ?? 'null' }},
                                                        batchName: @js($booking->classPeriod->name ?? '-'),
                                                    })"
                                                    class="inline-flex items-center px-3 py-1.5 bg-emerald-50 border border-emerald-200 rounded-md font-semibold text-xs text-emerald-700 hover:bg-emerald-100 transition ease-in-out duration-150 shadow-sm"
                                                    title="Daftarkan langsung sebagai student dari sini">
                                                Registrasi
                                            </button>
                                            <button type="button"
                                                    @click="window.copyToClipboard('{{ $booking->registration_link }}').then(() => { copied = true; setTimeout(() => copied = false, 1500); })"
                                                    class="text-gray-300 hover:text-gray-600 shrink-0" title="Salin link registrasi mandiri (kirim via WhatsApp, siswa yang isi sendiri)">
                                                <svg x-show="!copied" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                                                <svg x-show="copied" x-cloak class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                            </button>
                                        </div>
                                        <button type="button" x-data="" x-on:click="
                                            $dispatch('edit-booking-selected', {
                                                id: {{ $booking->id }},
                                                studentName: @js($booking->user->name ?? '-'),
                                                studentEmail: @js($booking->user->email ?? ''),
                                                programName: @js($booking->program->name ?? '-'),
                                                programId: {{ $booking->program_id ?? 'null' }},
                                                currentPeriodId: {{ $booking->class_period_id ?? 'null' }},
                                                currentPeriodName: @js($booking->classPeriod->name ?? '-'),
                                            });
                                            $dispatch('open-modal', 'edit-booking');
                                        " class="inline-flex items-center px-3 py-1.5 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 hover:bg-gray-50 transition ease-in-out duration-150 shadow-sm">
                                            Edit
                                        </button>
                                        <form method="POST" action="{{ route('admin.bookings.destroy', $booking) }}" onsubmit="return confirm('Hapus booking ' + @js($booking->user->name ?? 'student ini') + ' untuk batch \'' + @js($booking->classPeriod->name ?? '-') + '\'?\n\nStudent tetap terdaftar di program, hanya booking batch-nya yang dihapus.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-white border border-red-200 rounded-md font-semibold text-xs text-red-600 hover:bg-red-50 transition ease-in-out duration-150 shadow-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-100">
                {{ $bookings->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@section('modals')
    <!-- Modal: Register a booking on a student's behalf -->
    <x-modal name="create-booking" focusable>
        <div class="p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-1">Daftarkan Booking</h2>
            <p class="text-sm text-gray-500 mb-4">Booking-kan student ke sebuah batch kelas (misalnya untuk pendaftaran via telepon/WhatsApp).</p>

            <form method="POST" action="{{ route('admin.bookings.store') }}" class="space-y-4">
                @csrf

                <div>
                    <x-input-label for="booking_user_id" value="Student" />
                    <select name="user_id" id="booking_user_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                        <option value="">-- Pilih Student --</option>
                        @foreach ($students as $student)
                            <option value="{{ $student->id }}" {{ old('user_id') == $student->id ? 'selected' : '' }}>
                                {{ $student->name }} ({{ $student->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <x-input-label for="booking_class_period_id" value="Batch" />
                    <select name="class_period_id" id="booking_class_period_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                        <option value="">-- Pilih Batch --</option>
                        @foreach ($bookablePeriods as $period)
                            @php
                                $isFull = $period->max_capacity && $period->occupied_count >= $period->max_capacity;
                                $label = ($period->program->name ?? '-') . ' — ' . $period->name
                                    . ' (' . ($batchTypeLabels[$period->batch_type] ?? ucfirst($period->batch_type)) . ', '
                                    . $period->occupied_count . ($period->max_capacity ? '/' . $period->max_capacity : '') . ')'
                                    . ($isFull ? ' - PENUH' : '');
                            @endphp
                            <option value="{{ $period->id }}" {{ old('class_period_id') == $period->id ? 'selected' : '' }} {{ $isFull ? 'disabled' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Student harus terdaftar aktif di program yang sesuai dengan batch ini.</p>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Cancel
                    </button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Daftarkan
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Modal: Edit an existing booking's batch -->
    @php
        $editBatchTypeLabels = ['regular' => 'Reguler', 'semi_private' => 'Semi-Private', 'private' => 'Private'];
        $editablePeriodsJson = $bookablePeriods->map(function ($period) use ($editBatchTypeLabels) {
            $isFull = $period->max_capacity && $period->occupied_count >= $period->max_capacity;
            return [
                'id' => $period->id,
                'programId' => $period->program_id,
                'label' => $period->name . ' (' . ($editBatchTypeLabels[$period->batch_type] ?? ucfirst($period->batch_type))
                    . ', ' . $period->occupied_count . ($period->max_capacity ? '/' . $period->max_capacity : '') . ')'
                    . ($isFull ? ' - PENUH' : ''),
                'isFull' => $isFull,
            ];
        })->values();
    @endphp
    <x-modal name="edit-booking" focusable>
        <div class="p-6"
             x-data="{
                booking: { id: null, studentName: '', studentEmail: '', programName: '', programId: null, currentPeriodId: null, currentPeriodName: '' },
                selectedProgramId: '',
                selectedPeriodId: '',
                allPrograms: {{ Js::from($programs->map(fn ($p) => ['id' => $p->id, 'name' => $p->name])->values()) }},
                allPeriods: {{ Js::from($editablePeriodsJson) }},
                get periodsForProgram() {
                    return this.allPeriods.filter(p => p.programId == this.selectedProgramId);
                },
                onProgramChange() {
                    // Switching kelas/program invalidates the previously selected
                    // batch, since batches belong to exactly one program.
                    selectedPeriodId = (this.selectedProgramId == this.booking.programId) ? this.booking.currentPeriodId : '';
                }
             }"
             x-on:edit-booking-selected.window="
                booking = $event.detail;
                selectedProgramId = booking.programId;
                selectedPeriodId = booking.currentPeriodId;
             ">
            <h2 class="text-lg font-bold text-gray-900 mb-1">Edit Booking</h2>
            <p class="text-sm text-gray-500 mb-4">
                Tentukan kelas (program) dan batch untuk <span class="font-semibold" x-text="booking.studentName"></span>.
                Saat ini: <span class="font-semibold" x-text="booking.programName"></span> &mdash; <span class="font-semibold" x-text="booking.currentPeriodName"></span>.
            </p>

            <form method="POST" :action="'{{ url('/admin/bookings') }}/' + booking.id" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <x-input-label for="edit_booking_program_id" value="Kelas (Program)" />
                    <select name="program_id" id="edit_booking_program_id" x-model="selectedProgramId" x-on:change="onProgramChange()" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                        <template x-for="program in allPrograms" :key="program.id">
                            <option :value="program.id" x-text="program.name"></option>
                        </template>
                    </select>
                </div>

                <div>
                    <x-input-label for="edit_booking_class_period_id" value="Batch" />
                    <select name="class_period_id" id="edit_booking_class_period_id" x-model="selectedPeriodId" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                        <option value="" disabled>-- Pilih Batch --</option>
                        <template x-for="period in periodsForProgram" :key="period.id">
                            <option :value="period.id" :disabled="period.isFull && period.id != booking.currentPeriodId" x-text="period.label"></option>
                        </template>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Hanya menampilkan batch dari kelas/program yang dipilih di atas.</p>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Cancel
                    </button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    <!-- Modal: Admin registers a booking lead as a student directly, no public /daftar page involved -->
    <x-modal name="register-lead" focusable>
        <div class="p-6"
             x-data="{
                step: 'form',
                saving: false,
                errorMsg: '',
                passwordCopied: false,
                enrollmentId: null,
                studentName: '',
                studentEmail: '',
                studentPhone: '',
                originalProgramId: null,
                originalPeriodId: null,
                selectedProgramId: '',
                selectedPeriodId: '',
                paymentChannel: 'bank_transfer',
                paymentAmount: '',
                resultPassword: '',
                resultAmount: null,
                allPrograms: {{ Js::from($programs->map(fn ($p) => ['id' => $p->id, 'name' => $p->name])->values()) }},
                allPeriods: {{ Js::from($editablePeriodsJson) }},
                get periodsForProgram() {
                    return this.allPeriods.filter(p => p.programId == this.selectedProgramId);
                },
                onProgramChange() {
                    // Switching kelas/program invalidates the previously selected
                    // batch, since batches belong to exactly one program.
                    this.selectedPeriodId = (this.selectedProgramId == this.originalProgramId) ? this.originalPeriodId : '';
                }
             }"
             x-on:open-register-lead.window="
                step = 'form';
                errorMsg = '';
                saving = false;
                enrollmentId = $event.detail.enrollmentId;
                studentName = $event.detail.studentName;
                studentEmail = $event.detail.studentEmail;
                studentPhone = $event.detail.studentPhone;
                originalProgramId = $event.detail.programId;
                originalPeriodId = $event.detail.periodId;
                selectedProgramId = $event.detail.programId;
                selectedPeriodId = $event.detail.periodId;
                paymentChannel = 'bank_transfer';
                paymentAmount = '';
                $dispatch('open-modal', 'register-lead');
             "
             x-on:close="step = 'form'"
        >
            <template x-if="step === 'form'">
                <div>
                    <h2 class="text-lg font-bold text-gray-900 mb-1">Daftarkan sebagai Student</h2>
                    <p class="text-sm text-gray-500 mb-4">Konfirmasi data booking lalu daftarkan langsung di sini - tidak perlu buka halaman registrasi terpisah.</p>

                    <div class="space-y-3 mb-4">
                        <div>
                            <x-input-label for="register_name" value="Nama" />
                            <x-text-input id="register_name" type="text" x-model="studentName" class="mt-1 block w-full" />
                        </div>
                        <div>
                            <x-input-label for="register_email" value="Email" />
                            <x-text-input id="register_email" type="email" x-model="studentEmail" class="mt-1 block w-full" />
                        </div>
                        <div>
                            <x-input-label for="register_phone" value="WhatsApp" />
                            <x-text-input id="register_phone" type="text" x-model="studentPhone" class="mt-1 block w-full" />
                        </div>
                        <div>
                            <x-input-label for="register_program_id" value="Kelas (Program)" />
                            <select id="register_program_id" x-model="selectedProgramId" x-on:change="onProgramChange()" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                                <template x-for="program in allPrograms" :key="program.id">
                                    <option :value="program.id" x-text="program.name"></option>
                                </template>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="register_class_period_id" value="Batch" />
                            <select id="register_class_period_id" x-model="selectedPeriodId" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                                <option value="" disabled>-- Pilih Batch --</option>
                                <template x-for="period in periodsForProgram" :key="period.id">
                                    <option :value="period.id" :disabled="period.isFull && period.id != originalPeriodId" x-text="period.label"></option>
                                </template>
                            </select>
                            <p class="text-xs text-gray-500 mt-1">Hanya menampilkan batch dari kelas/program yang dipilih di atas.</p>
                        </div>
                    </div>

                    <div>
                        <x-input-label for="register_payment_channel" value="Metode Pembayaran" />
                        <select id="register_payment_channel" x-model="paymentChannel" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                            <option value="bank_transfer">Transfer Bank</option>
                            <option value="qris">QRIS</option>
                            <option value="cash">Tunai</option>
                        </select>
                        <p class="text-xs text-gray-500 mt-1">Invoice akan dibuat dan masuk ke Payment Queue untuk diverifikasi, sama seperti pendaftaran mandiri.</p>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="register_amount" value="Jumlah Pembayaran (Rp)" />
                        <x-text-input id="register_amount" type="number" min="0" step="1" x-model="paymentAmount" placeholder="Kosongkan untuk pakai harga program otomatis" class="mt-1 block w-full" />
                        <p class="text-xs text-gray-500 mt-1">Isi manual kalau harga nego/offline atau harga program belum diatur. Kosongkan untuk pakai harga program apa adanya.</p>
                    </div>

                    <p x-show="errorMsg" x-cloak class="mt-3 text-sm text-red-600" x-text="errorMsg"></p>

                    <div class="mt-6 flex justify-end gap-3">
                        <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Batal
                        </button>
                        <button type="button"
                                :disabled="saving"
                                :class="saving ? 'opacity-60 cursor-not-allowed' : ''"
                                x-on:click="
                                    saving = true;
                                    errorMsg = '';
                                    fetch('{{ url('/admin/bookings') }}/' + enrollmentId + '/register', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                                            'Accept': 'application/json',
                                        },
                                        body: JSON.stringify({
                                            payment_channel: paymentChannel,
                                            name: studentName,
                                            email: studentEmail,
                                            phone_number: studentPhone,
                                            program_id: selectedProgramId,
                                            class_period_id: selectedPeriodId,
                                            amount: paymentAmount === '' ? null : paymentAmount,
                                        }),
                                    })
                                    .then(async (r) => ({ ok: r.ok, data: await r.json() }))
                                    .then(({ ok, data }) => {
                                        saving = false;
                                        if (!ok || !data.success) {
                                            errorMsg = data.errors ? Object.values(data.errors)[0][0] : (data.message || 'Gagal mendaftarkan student. Silakan coba lagi.');
                                            return;
                                        }
                                        resultPassword = data.password;
                                        resultAmount = data.invoice_amount;
                                        step = 'success';
                                    })
                                    .catch(() => {
                                        saving = false;
                                        errorMsg = 'Gagal menghubungi server. Periksa koneksi lalu coba lagi.';
                                    });
                                "
                                class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <span x-show="!saving">Daftarkan sebagai Student</span>
                            <span x-show="saving" x-cloak>Mendaftarkan...</span>
                        </button>
                    </div>
                </div>
            </template>

            <template x-if="step === 'success'">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                        <h2 class="text-lg font-bold text-gray-900">Berhasil Didaftarkan</h2>
                    </div>
                    <p class="text-sm text-gray-500 mb-4">
                        <span class="font-semibold" x-text="studentName"></span> sudah menjadi student. Bagikan password sementara ini ke mereka (lewat WhatsApp) supaya bisa login.
                    </p>

                    <div class="bg-gray-50 rounded-lg p-4 space-y-1.5 mb-4 text-sm">
                        <div class="flex justify-between gap-4"><span class="text-gray-500 shrink-0">Email Login</span><span class="font-semibold text-gray-800 text-right" x-text="studentEmail"></span></div>
                        <div class="flex justify-between gap-4 items-center">
                            <span class="text-gray-500 shrink-0">Password</span>
                            <div class="flex items-center gap-1.5">
                                <span class="font-mono font-semibold text-gray-800" x-text="resultPassword"></span>
                                <button type="button"
                                        @click="window.copyToClipboard(resultPassword).then(() => { passwordCopied = true; setTimeout(() => passwordCopied = false, 1500); })"
                                        class="text-gray-300 hover:text-gray-600 shrink-0" title="Salin password">
                                    <svg x-show="!passwordCopied" class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                                    <svg x-show="passwordCopied" x-cloak class="w-3.5 h-3.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                                </button>
                            </div>
                        </div>
                        <div x-show="resultAmount !== null" class="flex justify-between gap-4"><span class="text-gray-500 shrink-0">Jumlah Invoice</span><span class="font-semibold text-gray-800 text-right" x-text="'Rp ' + (resultAmount !== null ? Number(resultAmount).toLocaleString('id-ID') : '')"></span></div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <button type="button" x-on:click="$dispatch('close'); window.location.reload();" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Selesai
                        </button>
                    </div>
                </div>
            </template>
        </div>
    </x-modal>

<!-- Modal: Preview Booking Form (Student View Simulation) -->
    <x-modal name="preview-booking-form" maxWidth="4xl">
        @php
            $adminProgramsJson = $programs->map(function($p) {
                $slug = strtolower($p->slug ?? '');
                $name = strtolower($p->name ?? '');
                $category = 'Kursus';
                $badgeClass = 'bg-blue-50 text-blue-700 border-blue-200';
                
                if (str_contains($slug, 'ielts') || str_contains($name, 'ielts')) {
                    $category = 'IELTS';
                    $badgeClass = 'bg-rose-50 text-rose-700 border-rose-200';
                } elseif (str_contains($slug, 'toefl') || str_contains($name, 'toefl')) {
                    $category = 'TOEFL';
                    $badgeClass = 'bg-blue-50 text-blue-700 border-blue-200';
                } elseif (str_contains($slug, 'speaking') || str_contains($name, 'speaking')) {
                    $category = 'Speaking';
                    $badgeClass = 'bg-amber-50 text-amber-800 border-amber-200';
                } elseif (str_contains($slug, 'grammar') || str_contains($name, 'grammar') || str_contains($slug, 'writing') || str_contains($name, 'writing')) {
                    $category = 'Grammar & Writing';
                    $badgeClass = 'bg-indigo-50 text-indigo-700 border-indigo-200';
                } elseif (str_contains($slug, 'pte') || str_contains($name, 'pte')) {
                    $category = 'PTE Academic';
                    $badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                } elseif (str_contains($slug, 'jepang') || str_contains($name, 'jepang') || str_contains($slug, 'japanese') || str_contains($name, 'japanese')) {
                    $category = 'Bahasa Asing';
                    $badgeClass = 'bg-pink-50 text-pink-700 border-pink-200';
                } elseif (str_contains($slug, 'korea') || str_contains($name, 'korea') || str_contains($slug, 'korean') || str_contains($name, 'korean')) {
                    $category = 'Bahasa Asing';
                    $badgeClass = 'bg-purple-50 text-purple-700 border-purple-200';
                } elseif (str_contains($slug, 'jerman') || str_contains($name, 'jerman') || str_contains($slug, 'german') || str_contains($name, 'german')) {
                    $category = 'Bahasa Asing';
                    $badgeClass = 'bg-amber-50 text-amber-700 border-amber-200';
                } elseif (str_contains($slug, 'prancis') || str_contains($name, 'prancis') || str_contains($slug, 'french') || str_contains($name, 'french')) {
                    $category = 'Bahasa Asing';
                    $badgeClass = 'bg-cyan-50 text-cyan-700 border-cyan-200';
                } elseif (str_contains($slug, 'arab') || str_contains($name, 'arab') || str_contains($slug, 'arabic') || str_contains($name, 'arabic')) {
                    $category = 'Bahasa Asing';
                    $badgeClass = 'bg-emerald-50 text-emerald-700 border-emerald-200';
                } elseif (str_contains($slug, 'mandarin') || str_contains($name, 'mandarin')) {
                    $category = 'Bahasa Asing';
                    $badgeClass = 'bg-red-50 text-red-700 border-red-200';
                }

                return [
                    'id' => (string) $p->id,
                    'name' => $p->name,
                    'category' => $category,
                    'badgeClass' => $badgeClass,
                ];
            })->values();
        @endphp
        <div class="p-6 sm:p-8 bg-[#F0F6FF]" x-data="{
            student: {
                id: 'TB-2026-0819',
                name: 'Budi Pratama',
                email: 'budi.pratama@example.com',
                whatsapp: '081234567890',
                isActive: true
            },
            programsList: {{ json_encode($adminProgramsJson) }},
            selectedProgramId: '{{ $programs->first()->id ?? '' }}',
            selectedBatchType: 'regular',
            selectedMode: 'online',
            selectedMonth: 'Maret 2026',
            selectedWeek: 'Minggu 1',
            searchProgram: '',
            selectedCategory: 'all',
            openMonthDropdown: false,
            monthsList: ['Maret 2026', 'April 2026', 'Mei 2026', 'Juni 2026', 'Juli 2026', 'Agustus 2026', 'September 2026', 'Oktober 2026', 'November 2026', 'Desember 2026', 'Januari 2027', 'Februari 2027'],
            notes: '',
            agreeTerms: true,
            bookingSuccess: false,

            get selectedProgram() {
                return this.programsList.find(p => p.id == this.selectedProgramId) || this.programsList[0] || { name: 'Pilih Program Kursus', category: 'Semua', badgeClass: 'bg-blue-50 text-blue-700 border-blue-200' };
            },

            get filteredPrograms() {
                return this.programsList.filter(p => {
                    const query = this.searchProgram.trim().toLowerCase();
                    const matchesSearch = query === '' || 
                        p.name.toLowerCase().includes(query) || 
                        p.category.toLowerCase().includes(query);
                    const matchesCategory = this.selectedCategory === 'all' || p.category === this.selectedCategory;
                    return matchesSearch && matchesCategory;
                });
            },

            confirmBooking() {
                if (!this.selectedProgramId) {
                    alert('Silakan pilih salah satu program kursus terlebih dahulu.');
                    return;
                }
                if (!this.selectedMonth || !this.selectedWeek) {
                    alert('Silakan tentukan bulan dan minggu belajar terlebih dahulu.');
                    return;
                }
                if (!this.agreeTerms) {
                    alert('Silakan centang persetujuan konfirmasi booking terlebih dahulu.');
                    return;
                }
                this.bookingSuccess = true;
            }
        }">
            {{-- Header --}}
            <div class="flex items-center justify-between pb-4 mb-5 border-b border-blue-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-blue-500 text-white flex items-center justify-center font-bold text-sm shadow-md shadow-blue-500/20 shrink-0">
                        TB
                    </div>
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <h2 class="text-base sm:text-lg font-black text-slate-900">Formulir Booking Kelas Mandiri</h2>
                            <span class="inline-flex items-center px-3 py-0.5 rounded-full text-[11px] font-bold bg-blue-100 text-blue-700">
                                Simulasi Portal Siswa
                            </span>
                        </div>
                        <p class="text-xs sm:text-sm text-slate-500">
                            Simulasi formulir booking periode belajar siswa.
                        </p>
                    </div>
                </div>
                <button type="button" x-on:click="$dispatch('close')" class="text-slate-400 hover:text-slate-600 transition-colors p-2 rounded-full hover:bg-white cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- Form Container --}}
            <div class="max-h-[65vh] overflow-y-auto pr-1 space-y-5">

                {{-- Success Banner on Booking Simulation --}}
                <div x-show="bookingSuccess" 
                     x-transition 
                     style="display: none;" 
                     class="p-5 bg-emerald-50 border-2 border-emerald-400 rounded-3xl text-emerald-900 flex items-start justify-between gap-3 text-sm shadow-xs">
                    <div>
                        <h4 class="font-black text-base text-emerald-900 mb-0.5">✓ Simulasi Booking Berhasil</h4>
                        <p class="text-emerald-800">
                            Siswa <strong x-text="student.name"></strong> berhasil disimulasikan mendaftar program <strong x-text="selectedProgram.name"></strong> periode <strong x-text="selectedMonth + ' (' + selectedWeek + ')'"></strong>.
                        </p>
                    </div>
                    <button @click="bookingSuccess = false" class="text-emerald-600 hover:text-emerald-800 font-bold text-base cursor-pointer">&times;</button>
                </div>

                {{-- BAGIAN 1: DATA DIRI SISWA --}}
                <div class="bg-white border border-blue-100 rounded-3xl p-5 sm:p-6 shadow-sm">
                    <div class="flex items-center justify-between mb-4 pb-3 border-b border-blue-50">
                        <div class="flex items-center gap-2.5">
                            <div class="w-8 h-8 rounded-full border-2 border-blue-500 text-blue-600 font-black text-sm flex items-center justify-center">
                                1
                            </div>
                            <h3 class="font-black text-slate-900 text-sm sm:text-base">Data Diri Siswa</h3>
                        </div>
                        <span class="text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-3 py-1 rounded-full">
                            Terverifikasi
                        </span>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-sm">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1.5 text-xs sm:text-sm">Nama Lengkap</label>
                            <input type="text" x-model="student.name" class="w-full rounded-2xl border-blue-100 bg-blue-50/20 text-sm py-2.5 px-3.5 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 font-medium transition">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1.5 text-xs sm:text-sm">Email</label>
                            <input type="email" x-model="student.email" class="w-full rounded-2xl border-blue-100 bg-blue-50/20 text-sm py-2.5 px-3.5 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 font-medium transition">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1.5 text-xs sm:text-sm">WhatsApp</label>
                            <input type="text" x-model="student.whatsapp" class="w-full rounded-2xl border-blue-100 bg-blue-50/20 text-sm py-2.5 px-3.5 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 font-medium transition">
                        </div>
                    </div>
                </div>

                {{-- BAGIAN 2: PILIHAN PROGRAM & MODA BELAJAR --}}
                <div class="bg-white border border-blue-100 rounded-3xl p-5 sm:p-6 shadow-sm space-y-6">
                    
                    {{-- 2A. Category Circular Icons --}}
                    <div>
                        <div class="flex items-center gap-2.5 mb-4 pb-3 border-b border-blue-50">
                            <div class="w-8 h-8 rounded-full border-2 border-blue-500 text-blue-600 font-black text-sm flex items-center justify-center">
                                2
                            </div>
                            <h3 class="font-black text-slate-900 text-sm sm:text-base">Pilihan Kategori Program Kursus</h3>
                        </div>

                        {{-- Circular Category Buttons Grid --}}
                        <div class="grid grid-cols-4 sm:grid-cols-7 gap-2.5 justify-items-center mb-4">
                            
                            {{-- Semua --}}
                            <button type="button" @click="selectedCategory = 'all'" class="flex flex-col items-center gap-1.5 group cursor-pointer focus:outline-none">
                                <div :class="selectedCategory === 'all' ? 'bg-blue-500 text-white shadow-md shadow-blue-500/25 ring-2 ring-blue-100' : 'bg-blue-50/80 text-blue-600 hover:bg-blue-100 border border-blue-100'"
                                     class="w-12 h-12 rounded-full flex items-center justify-center transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                </div>
                                <span :class="selectedCategory === 'all' ? 'text-blue-600 font-bold' : 'text-slate-600'" class="text-xs text-center">Semua</span>
                            </button>

                            {{-- IELTS --}}
                            <button type="button" @click="selectedCategory = 'IELTS'" class="flex flex-col items-center gap-1.5 group cursor-pointer focus:outline-none">
                                <div :class="selectedCategory === 'IELTS' ? 'bg-blue-500 text-white shadow-md shadow-blue-500/25 ring-2 ring-blue-100' : 'bg-blue-50/80 text-blue-600 hover:bg-blue-100 border border-blue-100'"
                                     class="w-12 h-12 rounded-full flex items-center justify-center transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                                </div>
                                <span :class="selectedCategory === 'IELTS' ? 'text-blue-600 font-bold' : 'text-slate-600'" class="text-xs text-center">IELTS</span>
                            </button>

                            {{-- TOEFL --}}
                            <button type="button" @click="selectedCategory = 'TOEFL'" class="flex flex-col items-center gap-1.5 group cursor-pointer focus:outline-none">
                                <div :class="selectedCategory === 'TOEFL' ? 'bg-blue-500 text-white shadow-md shadow-blue-500/25 ring-2 ring-blue-100' : 'bg-blue-50/80 text-blue-600 hover:bg-blue-100 border border-blue-100'"
                                     class="w-12 h-12 rounded-full flex items-center justify-center transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                                </div>
                                <span :class="selectedCategory === 'TOEFL' ? 'text-blue-600 font-bold' : 'text-slate-600'" class="text-xs text-center">TOEFL</span>
                            </button>

                            {{-- Speaking --}}
                            <button type="button" @click="selectedCategory = 'Speaking'" class="flex flex-col items-center gap-1.5 group cursor-pointer focus:outline-none">
                                <div :class="selectedCategory === 'Speaking' ? 'bg-blue-500 text-white shadow-md shadow-blue-500/25 ring-2 ring-blue-100' : 'bg-blue-50/80 text-blue-600 hover:bg-blue-100 border border-blue-100'"
                                     class="w-12 h-12 rounded-full flex items-center justify-center transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                </div>
                                <span :class="selectedCategory === 'Speaking' ? 'text-blue-600 font-bold' : 'text-slate-600'" class="text-xs text-center">Speaking</span>
                            </button>

                            {{-- Grammar --}}
                            <button type="button" @click="selectedCategory = 'Grammar & Writing'" class="flex flex-col items-center gap-1.5 group cursor-pointer focus:outline-none">
                                <div :class="selectedCategory === 'Grammar & Writing' ? 'bg-blue-500 text-white shadow-md shadow-blue-500/25 ring-2 ring-blue-100' : 'bg-blue-50/80 text-blue-600 hover:bg-blue-100 border border-blue-100'"
                                     class="w-12 h-12 rounded-full flex items-center justify-center transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                                </div>
                                <span :class="selectedCategory === 'Grammar & Writing' ? 'text-blue-600 font-bold' : 'text-slate-600'" class="text-xs text-center">Grammar</span>
                            </button>

                            {{-- PTE --}}
                            <button type="button" @click="selectedCategory = 'PTE Academic'" class="flex flex-col items-center gap-1.5 group cursor-pointer focus:outline-none">
                                <div :class="selectedCategory === 'PTE Academic' ? 'bg-blue-500 text-white shadow-md shadow-blue-500/25 ring-2 ring-blue-100' : 'bg-blue-50/80 text-blue-600 hover:bg-blue-100 border border-blue-100'"
                                     class="w-12 h-12 rounded-full flex items-center justify-center transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/></svg>
                                </div>
                                <span :class="selectedCategory === 'PTE Academic' ? 'text-blue-600 font-bold' : 'text-slate-600'" class="text-xs text-center">PTE</span>
                            </button>

                            {{-- Bahasa Asing --}}
                            <button type="button" @click="selectedCategory = 'Bahasa Asing'" class="flex flex-col items-center gap-1.5 group cursor-pointer focus:outline-none">
                                <div :class="selectedCategory === 'Bahasa Asing' ? 'bg-blue-500 text-white shadow-md shadow-blue-500/25 ring-2 ring-blue-100' : 'bg-blue-50/80 text-blue-600 hover:bg-blue-100 border border-blue-100'"
                                     class="w-12 h-12 rounded-full flex items-center justify-center transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/></svg>
                                </div>
                                <span :class="selectedCategory === 'Bahasa Asing' ? 'text-blue-600 font-bold' : 'text-slate-600'" class="text-xs text-center">Asing</span>
                            </button>
                        </div>

                        {{-- 2B. Subcategory Program Pills --}}
                        <div class="pt-4 border-t border-blue-50">
                            <div class="flex flex-wrap items-center justify-center gap-2">
                                <template x-for="p in filteredPrograms" :key="p.id">
                                    <button type="button" 
                                            @click="selectedProgramId = p.id"
                                            :class="selectedProgramId == p.id ? 'bg-blue-500 text-white font-bold shadow-sm' : 'bg-blue-50/80 text-blue-700 hover:bg-blue-100 border border-blue-100 font-semibold'"
                                            class="px-4 py-2 rounded-full text-xs sm:text-sm transition flex items-center gap-1.5 cursor-pointer">
                                        <span x-text="p.name"></span>
                                        <span x-show="selectedProgramId == p.id">✓</span>
                                    </button>
                                </template>
                            </div>
                        </div>
                    </div>

                    {{-- 2C. Segmented Capsule Toggles --}}
                    <div class="pt-4 border-t border-blue-50 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                        {{-- Tipe Kelas --}}
                        <div>
                            <label class="block font-bold text-slate-800 text-xs sm:text-sm mb-1.5">Tipe Kelas <span class="text-red-500">*</span></label>
                            <div class="p-1 bg-blue-50/80 rounded-full border border-blue-100 inline-flex w-full">
                                <button type="button" 
                                        @click="selectedBatchType = 'regular'"
                                        :class="selectedBatchType === 'regular' ? 'bg-blue-500 text-white font-bold shadow-sm' : 'text-blue-700 font-semibold'"
                                        class="flex-1 py-2.5 px-3 text-xs sm:text-sm rounded-full transition text-center cursor-pointer">
                                    Reguler
                                </button>
                                <button type="button" 
                                        @click="selectedBatchType = 'private'"
                                        :class="selectedBatchType === 'private' ? 'bg-blue-500 text-white font-bold shadow-sm' : 'text-blue-700 font-semibold'"
                                        class="flex-1 py-2.5 px-3 text-xs sm:text-sm rounded-full transition text-center cursor-pointer">
                                    Private 1-on-1
                                </button>
                            </div>
                        </div>

                        {{-- Moda Belajar --}}
                        <div>
                            <label class="block font-bold text-slate-800 text-xs sm:text-sm mb-1.5">Moda Belajar <span class="text-red-500">*</span></label>
                            <div class="p-1 bg-blue-50/80 rounded-full border border-blue-100 inline-flex w-full">
                                <button type="button" 
                                        @click="selectedMode = 'online'"
                                        :class="selectedMode === 'online' ? 'bg-blue-500 text-white font-bold shadow-sm' : 'text-blue-700 font-semibold'"
                                        class="flex-1 py-2.5 px-3 text-xs sm:text-sm rounded-full transition text-center cursor-pointer">
                                    Online (Zoom)
                                </button>
                                <button type="button" 
                                        @click="selectedMode = 'offline'"
                                        :class="selectedMode === 'offline' ? 'bg-blue-500 text-white font-bold shadow-sm' : 'text-blue-700 font-semibold'"
                                        class="flex-1 py-2.5 px-3 text-xs sm:text-sm rounded-full transition text-center cursor-pointer">
                                    Offline
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BAGIAN 3: PILIHAN BULAN & MINGGU BELAJAR (CLEAN & SPACIOUS) --}}
                <div class="bg-white border border-blue-100 rounded-3xl p-5 sm:p-6 shadow-sm space-y-5">
                    <div class="flex items-center gap-2.5 pb-3 border-b border-blue-50">
                        <div class="w-8 h-8 rounded-full border-2 border-blue-500 text-blue-600 font-black text-sm flex items-center justify-center">
                            3
                        </div>
                        <h3 class="font-black text-slate-900 text-sm sm:text-base">Pilihan Waktu & Periode Belajar</h3>
                    </div>

                    {{-- Month Selection --}}
                    <div>
                        <label class="block font-bold text-slate-700 text-xs sm:text-sm mb-1.5">Bulan Mulai Belajar <span class="text-red-500">*</span></label>
                        <div class="relative" @click.outside="openMonthDropdown = false">
                            <button type="button" 
                                    @click="openMonthDropdown = !openMonthDropdown"
                                    class="w-full rounded-2xl border border-blue-100 bg-blue-50/20 p-3 text-left transition flex items-center justify-between gap-2 cursor-pointer">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <div>
                                        <span class="text-sm font-bold text-slate-900 block" x-text="selectedMonth"></span>
                                        <span class="text-xs text-emerald-600 font-medium">Pendaftaran Terbuka</span>
                                    </div>
                                </div>
                                <span class="text-xs font-bold text-blue-600 bg-blue-50 border border-blue-200 px-3 py-1 rounded-full">Pilih Bulan ▾</span>
                            </button>

                            <div x-show="openMonthDropdown" 
                                 x-transition 
                                 style="display: none;"
                                 class="absolute left-0 right-0 top-full mt-1 z-50 bg-white border border-blue-200 rounded-2xl shadow-xl overflow-hidden divide-y divide-slate-100">
                                <div class="p-2.5 bg-blue-50 text-xs font-bold text-blue-900">Periode 12 Bulan</div>
                                <div class="max-h-48 overflow-y-auto p-1 space-y-0.5">
                                    <template x-for="m in monthsList" :key="m">
                                        <button type="button" 
                                                @click="selectedMonth = m; openMonthDropdown = false"
                                                :class="selectedMonth === m ? 'bg-blue-50 text-blue-900 font-bold' : 'hover:bg-slate-50 text-slate-700'"
                                                class="w-full p-2.5 rounded-xl text-left transition flex items-center justify-between text-xs sm:text-sm cursor-pointer">
                                            <span x-text="m"></span>
                                            <span x-show="selectedMonth === m" class="text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full text-xs font-bold">Terpilih ✓</span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Week Selection --}}
                    <div>
                        <label class="block font-bold text-slate-700 text-xs sm:text-sm mb-2">Minggu Mulai Belajar <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-2.5">
                            <button type="button" 
                                    @click="selectedWeek = 'Minggu 1'"
                                    :class="selectedWeek === 'Minggu 1' ? 'bg-blue-500 text-white font-bold shadow-sm' : 'bg-blue-50/70 text-slate-800 hover:bg-blue-100 border border-blue-100 font-semibold'"
                                    class="p-3 rounded-2xl text-left transition text-xs sm:text-sm cursor-pointer flex flex-col justify-between">
                                <span class="font-bold text-sm">Minggu 1</span>
                                <span :class="selectedWeek === 'Minggu 1' ? 'text-blue-100' : 'text-slate-500'" class="text-xs">1 – 7 Bulan</span>
                            </button>

                            <button type="button" 
                                    @click="selectedWeek = 'Minggu 2'"
                                    :class="selectedWeek === 'Minggu 2' ? 'bg-blue-500 text-white font-bold shadow-sm' : 'bg-blue-50/70 text-slate-800 hover:bg-blue-100 border border-blue-100 font-semibold'"
                                    class="p-3 rounded-2xl text-left transition text-xs sm:text-sm cursor-pointer flex flex-col justify-between">
                                <span class="font-bold text-sm">Minggu 2</span>
                                <span :class="selectedWeek === 'Minggu 2' ? 'text-blue-100' : 'text-slate-500'" class="text-xs">8 – 14 Bulan</span>
                            </button>

                            <button type="button" 
                                    @click="selectedWeek = 'Minggu 3'"
                                    :class="selectedWeek === 'Minggu 3' ? 'bg-blue-500 text-white font-bold shadow-sm' : 'bg-blue-50/70 text-slate-800 hover:bg-blue-100 border border-blue-100 font-semibold'"
                                    class="p-3 rounded-2xl text-left transition text-xs sm:text-sm cursor-pointer flex flex-col justify-between">
                                <span class="font-bold text-sm">Minggu 3</span>
                                <span :class="selectedWeek === 'Minggu 3' ? 'text-blue-100' : 'text-slate-500'" class="text-xs">15 – 21 Bulan</span>
                            </button>

                            <button type="button" 
                                    @click="selectedWeek = 'Minggu 4'"
                                    :class="selectedWeek === 'Minggu 4' ? 'bg-blue-500 text-white font-bold shadow-sm' : 'bg-blue-50/70 text-slate-800 hover:bg-blue-100 border border-blue-100 font-semibold'"
                                    class="p-3 rounded-2xl text-left transition text-xs sm:text-sm cursor-pointer flex flex-col justify-between">
                                <span class="font-bold text-sm">Minggu 4</span>
                                <span :class="selectedWeek === 'Minggu 4' ? 'text-blue-100' : 'text-slate-500'" class="text-xs">22 – Akhir Bulan</span>
                            </button>
                        </div>
                    </div>

                    {{-- Summary Pill --}}
                    <div class="p-3.5 bg-gradient-to-r from-blue-50 via-indigo-50/60 to-blue-50 border border-blue-100 rounded-2xl flex flex-col sm:flex-row sm:items-center justify-between gap-2 text-xs sm:text-sm">
                        <div>
                            <span class="text-[11px] font-bold text-blue-600 uppercase tracking-wider block">Jadwal Belajar Dipilih:</span>
                            <span class="font-bold text-slate-900 text-sm" x-text="selectedMonth + ' • ' + selectedWeek"></span>
                            <span class="text-slate-500 text-xs block mt-0.5">
                                Tipe: <strong class="text-blue-600" x-text="selectedBatchType === 'private' ? 'Private 1-on-1' : 'Reguler'"></strong> &bull; Moda: <strong class="text-indigo-600" x-text="selectedMode === 'offline' ? 'Offline' : 'Online (Zoom)'"></strong>
                            </span>
                        </div>
                        <span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full font-bold text-xs self-start sm:self-center border border-emerald-300">
                            Pendaftaran Terbuka
                        </span>
                    </div>
                </div>

                {{-- BAGIAN 4: CATATAN & KONFIRMASI --}}
                <div class="bg-white border border-blue-100 rounded-3xl p-5 sm:p-6 shadow-sm space-y-4 text-xs sm:text-sm">
                    <div class="flex items-center gap-2.5 pb-2 border-b border-blue-50">
                        <div class="w-8 h-8 rounded-full border-2 border-blue-500 text-blue-600 font-black text-sm flex items-center justify-center">
                            4
                        </div>
                        <h3 class="font-black text-slate-900 text-sm sm:text-base">Catatan & Konfirmasi</h3>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1.5 text-xs sm:text-sm">Catatan Tambahan (Opsional)</label>
                        <textarea x-model="notes" rows="2" class="w-full rounded-2xl border-blue-100 bg-blue-50/20 text-sm p-3.5 focus:bg-white focus:border-blue-500 focus:ring-2 focus:ring-blue-100 font-medium" placeholder="Contoh: Target tes, materi prioritas, atau preferensi jam..."></textarea>
                    </div>

                    <div class="p-3.5 bg-blue-50/60 rounded-2xl border border-blue-100 flex items-start gap-3">
                        <input type="checkbox" x-model="agreeTerms" id="agree-terms-preview" class="mt-0.5 h-4 w-4 text-blue-500 rounded border-blue-300 focus:ring-blue-400">
                        <label for="agree-terms-preview" class="text-xs sm:text-sm text-slate-700 leading-relaxed cursor-pointer font-medium">
                            Saya telah memeriksa data diri, pilihan program, serta jadwal periode belajar dengan benar.
                        </label>
                    </div>

                    <div class="pt-2 flex flex-col sm:flex-row items-center justify-end gap-3">
                        <button type="button" 
                                @click="confirmBooking" 
                                class="w-full sm:w-auto px-7 py-3 bg-blue-500 hover:bg-blue-600 text-white font-bold text-xs sm:text-sm rounded-full shadow-md shadow-blue-500/20 transition flex items-center justify-center gap-1.5 cursor-pointer">
                            <span>Simulasikan Konfirmasi Booking</span>
                        </button>
                    </div>
                </div>

            </div>
            
            {{-- Footer --}}
            <div class="mt-5 pt-3 border-t border-blue-100 flex items-center justify-end gap-2.5">
                <button type="button" x-on:click="$dispatch('close')" class="px-5 py-2.5 bg-white border border-blue-100 rounded-full font-semibold text-xs sm:text-sm text-slate-700 hover:bg-slate-50 transition shadow-2xs cursor-pointer">
                    Tutup Preview
                </button>
                <button type="button" x-on:click="$dispatch('close'); setTimeout(() => $dispatch('open-modal', 'create-booking'), 200)" class="inline-flex items-center px-6 py-2.5 bg-blue-500 border border-transparent rounded-full font-bold text-xs sm:text-sm text-white hover:bg-blue-600 transition shadow-xs cursor-pointer">
                    Daftarkan Student Manual
                </button>
            </div>
        </div>
    </x-modal>
@endsection
