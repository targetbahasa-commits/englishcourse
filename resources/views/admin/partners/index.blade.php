@extends('layouts.admin')

@section('title', 'Kerjasama Instansi')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 font-bold">Kerjasama Instansi</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola instansi/perusahaan partner untuk penyediaan kursus & pelatihan bahasa Inggris.</p>
        </div>
        <div>
            <a href="{{ route('admin.partners.create') }}" class="btn bg-blue-600 hover:bg-blue-700 text-white rounded-lg px-4 py-2 inline-flex items-center transition">
                <svg class="w-4 h-4 fill-current opacity-50 shrink-0 mr-2" viewBox="0 0 16 16">
                    <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z"/>
                </svg>
                Tambah Partner
            </a>
        </div>
    </div>

    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-700 flex justify-between items-center" x-init="setTimeout(() => show = false, 5000)">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="text-green-500 hover:text-green-600 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-700">{{ session('error') }}</div>
    @endif

    <form method="GET" class="mb-6 flex flex-wrap items-center gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama instansi, PIC, atau kode..."
            class="rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm w-64">
        <select name="status" class="rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm">
            <option value="">Semua Status</option>
            <option value="prospecting" {{ request('status') === 'prospecting' ? 'selected' : '' }}>Penjajakan</option>
            <option value="negotiating" {{ request('status') === 'negotiating' ? 'selected' : '' }}>Negosiasi</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Aktif</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Berakhir</option>
        </select>
        <button type="submit" class="px-4 py-2 rounded-xl text-sm font-medium bg-gray-100 hover:bg-gray-200 text-gray-700 transition">Filter</button>
        @if(request('search') || request('status'))
            <a href="{{ route('admin.partners.index') }}" class="text-sm text-gray-500 hover:text-gray-700 underline">Reset</a>
        @endif
    </form>

    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Instansi</th>
                        <th class="px-6 py-4 font-semibold">PIC</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold">Harga Korporat</th>
                        <th class="px-6 py-4 font-semibold text-right">Karyawan</th>
                        <th class="px-6 py-4 font-semibold">Link Aktif</th>
                        <th class="px-6 py-4 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($partners as $partner)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.partners.show', $partner) }}" class="font-semibold text-gray-800 hover:text-blue-600">{{ $partner->name }}</a>
                                @if($partner->industry)
                                    <div class="text-xs text-gray-500">{{ $partner->industry }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-gray-700">{{ $partner->pic_name ?: '—' }}</div>
                                @if($partner->pic_phone)
                                    <div class="text-xs text-gray-500">{{ $partner->pic_phone }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @php
                                    $statusStyles = [
                                        'prospecting' => 'bg-gray-100 text-gray-600',
                                        'negotiating' => 'bg-amber-100 text-amber-700',
                                        'active' => 'bg-green-100 text-green-700',
                                        'inactive' => 'bg-red-100 text-red-600',
                                    ];
                                    $statusLabels = [
                                        'prospecting' => 'Penjajakan',
                                        'negotiating' => 'Negosiasi',
                                        'active' => 'Aktif',
                                        'inactive' => 'Berakhir',
                                    ];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $statusStyles[$partner->status] ?? 'bg-gray-100 text-gray-600' }}">
                                    {{ $statusLabels[$partner->status] ?? ucfirst($partner->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                @if($partner->discount_type)
                                    <span class="text-xs font-medium text-blue-600">{{ $partner->formattedDiscountAttribute() }}</span>
                                @else
                                    <span class="text-xs text-gray-400">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right font-semibold text-gray-700">{{ $partner->employees_count }}</td>
                            <td class="px-6 py-4">
                                @if($partner->is_active)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Aktif</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Nonaktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="{{ route('admin.partners.show', $partner) }}" class="text-blue-600 hover:text-blue-900 mx-1 transition font-medium">Detail</a>
                                <a href="{{ route('admin.partners.edit', $partner) }}" class="text-indigo-600 hover:text-indigo-900 mx-1 transition font-medium">Edit</a>
                                <form action="{{ route('admin.partners.destroy', $partner) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus partner ' + @js($partner->name) + '? Karyawan yang sudah tertaut tidak akan ikut terhapus.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition font-medium">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                <div class="flex flex-col items-center">
                                    <svg class="w-10 h-10 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    Belum ada partner kerjasama. Tambahkan yang pertama!
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($partners->hasPages())
            <div class="px-6 py-4 border-t border-gray-100">{{ $partners->links() }}</div>
        @endif
    </div>

</div>
@endsection
