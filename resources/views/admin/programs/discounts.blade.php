@extends('layouts.admin')

@section('title', 'Diskon Program: ' . $program->name)

@section('content')
<div class="p-6 md:p-8 space-y-8 pb-32">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <a href="{{ route('programs.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1 mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Programs
            </a>
            <h1 class="text-3xl font-bold font-serif text-gray-900">Pengaturan Diskon</h1>
            <p class="text-gray-500 mt-1">
                Program: <span class="font-semibold text-gray-700">{{ $program->name }}</span>
                @if($program->price && $program->price > 0)
                    &mdash; Harga Dasar: <span class="font-semibold text-green-700">Rp {{ number_format($program->price, 0, ',', '.') }}</span>
                @endif
            </p>
        </div>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl">{{ session('success') }}</div>
    @endif
    @if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl">
        <ul class="list-disc list-inside text-sm">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

        {{-- Existing Discounts List --}}
        <div class="lg:col-span-2 space-y-4">
            <h2 class="text-lg font-bold text-gray-800">Daftar Diskon yang Aktif</h2>

            @if($discounts->isEmpty())
            <div class="bg-white rounded-2xl border border-dashed border-gray-200 p-10 text-center text-gray-400">
                <svg class="w-12 h-12 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M17 17h.01M7 17a5 5 0 000-10m10 10a5 5 0 000-10M12 12h.01"/></svg>
                <p class="font-medium">Belum ada diskon untuk program ini.</p>
                <p class="text-sm mt-1">Tambahkan diskon pertama menggunakan form di samping.</p>
            </div>
            @else

            @php
            $typeColors = [
                'guest'    => 'bg-blue-50 text-blue-700 border-blue-200',
                'new_user' => 'bg-purple-50 text-purple-700 border-purple-200',
                'student'  => 'bg-green-50 text-green-700 border-green-200',
                'referral' => 'bg-yellow-50 text-yellow-700 border-yellow-200',
                'holiday'  => 'bg-pink-50 text-pink-700 border-pink-200',
                'region'   => 'bg-indigo-50 text-indigo-700 border-indigo-200',
            ];
            $typeLabels = [
                'guest'    => '👤 Guest',
                'new_user' => '🆕 New User',
                'student'  => '🎓 Student',
                'referral' => '🤝 Referral Teman',
                'holiday'  => '🎉 Hari Libur',
                'region'   => '📍 Daerah Khusus',
            ];
            @endphp

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs uppercase tracking-wider text-gray-400 font-semibold">Tipe / Label</th>
                            <th class="px-5 py-3 text-left text-xs uppercase tracking-wider text-gray-400 font-semibold">Diskon</th>
                            <th class="px-5 py-3 text-left text-xs uppercase tracking-wider text-gray-400 font-semibold">Kondisi</th>
                            <th class="px-5 py-3 text-left text-xs uppercase tracking-wider text-gray-400 font-semibold">Status</th>
                            <th class="px-5 py-3 text-right text-xs uppercase tracking-wider text-gray-400 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($discounts as $d)
                        <tr class="{{ $d->is_active ? '' : 'opacity-50' }} hover:bg-gray-50 transition-colors">
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold border {{ $typeColors[$d->type] ?? 'bg-gray-100 text-gray-700 border-gray-200' }}">
                                    {{ $typeLabels[$d->type] ?? ucfirst($d->type) }}
                                </span>
                                <div class="font-medium text-gray-800 mt-1">{{ $d->label }}</div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="font-bold text-orange-600 text-base">
                                    @if($d->discount_type === 'percentage')
                                        {{ $d->discount_value }}%
                                    @else
                                        Rp {{ number_format($d->discount_value, 0, ',', '.') }}
                                    @endif
                                </span>
                                <div class="text-xs text-gray-400 mt-0.5">{{ $d->discount_type === 'percentage' ? 'Persentase' : 'Nominal Tetap' }}</div>
                            </td>
                            <td class="px-5 py-4 text-xs text-gray-500">
                                @if($d->type === 'holiday' && $d->conditions)
                                    📅 {{ $d->conditions['start_date'] ?? '' }}
                                    @if(!empty($d->conditions['end_date'])) s/d {{ $d->conditions['end_date'] }} @endif
                                @elseif($d->type === 'region' && $d->conditions)
                                    📍 {{ implode(', ', $d->conditions['regions'] ?? []) }}
                                @else
                                    <span class="text-gray-300 italic">—</span>
                                @endif
                            </td>
                            <td class="px-5 py-4">
                                <form method="POST" action="{{ route('programs.discounts.update', [$program->id, $d->id]) }}">
                                    @csrf @method('PUT')
                                    <input type="hidden" name="toggle_active" value="1">
                                    <button type="submit" class="relative inline-flex items-center cursor-pointer">
                                        <div class="w-9 h-5 {{ $d->is_active ? 'bg-emerald-500' : 'bg-gray-300' }} rounded-full transition-colors"></div>
                                        <div class="absolute {{ $d->is_active ? 'left-4' : 'left-0.5' }} w-4 h-4 bg-white rounded-full shadow transition-all m-0.5"></div>
                                    </button>
                                </form>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <form method="POST" action="{{ route('programs.discounts.destroy', [$program->id, $d->id]) }}" onsubmit="return confirm('Hapus diskon ini?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Hapus">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>

        {{-- Add New Discount Form --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6">
                <h2 class="text-lg font-bold text-gray-800 mb-4">➕ Tambah Diskon Baru</h2>

                <form method="POST" action="{{ route('programs.discounts.store', $program->id) }}" class="space-y-4" x-data="{ dtype: 'guest' }">
                    @csrf

                    {{-- Type --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Tipe Diskon <span class="text-red-500">*</span></label>
                        <select name="type" x-model="dtype" required
                            class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-orange-400 focus:border-orange-400 sm:text-sm bg-white">
                            <option value="guest">👤 Guest (Tamu)</option>
                            <option value="new_user">🆕 New User (Pengguna Baru)</option>
                            <option value="student">🎓 Student (Siswa Aktif)</option>
                            <option value="referral">🤝 Referral Teman</option>
                            <option value="holiday">🎉 Hari Libur Khusus</option>
                            <option value="region">📍 Daerah Khusus</option>
                        </select>
                    </div>

                    {{-- Label --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1">Label Diskon <span class="text-red-500">*</span></label>
                        <input type="text" name="label" required
                            class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-orange-400 focus:border-orange-400 sm:text-sm"
                            placeholder="e.g., Diskon Lebaran 2025">
                    </div>

                    {{-- Discount type + value --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Jenis</label>
                            <select name="discount_type" required
                                class="block w-full border border-gray-300 rounded-xl px-3 py-2.5 focus:ring-orange-400 focus:border-orange-400 sm:text-sm bg-white">
                                <option value="percentage">% Persentase</option>
                                <option value="fixed_idr">Rp Nominal</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Nilai <span class="text-red-500">*</span></label>
                            <input type="number" name="discount_value" min="1" required
                                class="block w-full border border-gray-300 rounded-xl px-3 py-2.5 focus:ring-orange-400 focus:border-orange-400 sm:text-sm"
                                placeholder="e.g., 20">
                        </div>
                    </div>

                    {{-- Holiday conditions --}}
                    <div x-show="dtype === 'holiday'" class="space-y-3 p-3 bg-pink-50 rounded-xl border border-pink-100">
                        <p class="text-xs font-semibold text-pink-700 uppercase tracking-wide">Rentang Tanggal Libur</p>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Mulai</label>
                                <input type="date" name="start_date" class="block w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-orange-400 focus:border-orange-400">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">Selesai</label>
                                <input type="date" name="end_date" class="block w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-orange-400 focus:border-orange-400">
                            </div>
                        </div>
                    </div>

                    {{-- Region conditions --}}
                    <div x-show="dtype === 'region'" class="p-3 bg-indigo-50 rounded-xl border border-indigo-100">
                        <label class="block text-xs font-semibold text-indigo-700 uppercase tracking-wide mb-1">Daerah (pisahkan koma)</label>
                        <input type="text" name="regions"
                            class="block w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-orange-400 focus:border-orange-400"
                            placeholder="e.g., Jakarta, Bandung, Surabaya">
                    </div>

                    {{-- Active toggle --}}
                    <div class="flex items-center justify-between pt-2 border-t border-gray-100">
                        <label class="text-sm font-semibold text-gray-700">Aktifkan sekarang</label>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_active" value="1" checked class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                        </label>
                    </div>

                    <button type="submit"
                        class="w-full py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-xl transition-colors shadow-sm">
                        Simpan Diskon
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
