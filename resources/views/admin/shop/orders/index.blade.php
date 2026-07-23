@extends('layouts.admin')

@section('title', 'Pesanan Masuk')

@section('content')
<div class="p-8 pb-24 max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Pesanan Masuk</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola penjualan dari Shopee, TikTok, dan platform lainnya.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.shop.orders.create') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-gray-900 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-gray-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-900 transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 5v14M5 12h14"/></svg>
                Tambah Pesanan
            </a>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-4 mb-6">
        <form action="{{ route('admin.shop.orders.index') }}" method="GET" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <div class="relative">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama, WA, atau No Pesanan..." class="block w-full rounded-xl border-0 py-2 pl-9 pr-3 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-amber-600 sm:text-sm sm:leading-6">
                </div>
            </div>
            <div class="sm:w-48">
                <select name="platform" class="block w-full rounded-xl border-0 py-2 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-amber-600 sm:text-sm sm:leading-6" onchange="this.form.submit()">
                    <option value="">Semua Platform</option>
                    @foreach($platforms as $key => $label)
                        <option value="{{ $key }}" {{ request('platform') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="sm:w-48">
                <select name="status" class="block w-full rounded-xl border-0 py-2 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-amber-600 sm:text-sm sm:leading-6" onchange="this.form.submit()">
                    <option value="">Semua Status</option>
                    @foreach($statuses as $key => $statusData)
                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $statusData['label'] }}</option>
                    @endforeach
                </select>
            </div>
            @if(request()->hasAny(['search', 'platform', 'status']))
                <div>
                    <a href="{{ route('admin.shop.orders.index') }}" class="inline-flex items-center justify-center rounded-xl bg-gray-50 px-4 py-2 text-sm font-medium text-gray-600 ring-1 ring-inset ring-gray-300 hover:bg-gray-100 transition-colors h-full">Reset</a>
                </div>
            @endif
        </form>
    </div>

    {{-- Orders Table --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50/50">
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tanggal & Pesanan</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pembeli</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Platform</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                        <th scope="col" class="px-3 py-3.5 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                            <span class="sr-only">Aksi</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="whitespace-nowrap py-4 pl-4 pr-3">
                                <div class="text-sm font-medium text-gray-900">{{ $order->order_date->format('d M Y') }}</div>
                                <div class="text-xs text-gray-500 mt-1">
                                    {{ $order->items->count() }} item(s)
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $order->customer_name }}</div>
                                @if($order->customer_whatsapp)
                                    <div class="text-sm text-gray-500 flex items-center gap-1 mt-0.5">
                                        <svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413Z"/></svg>
                                        {{ $order->customer_whatsapp }}
                                    </div>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-3 py-4">
                                <div class="text-sm font-medium text-gray-900">{{ $order->platform_label }}</div>
                                @if($order->platform_order_id)
                                    <div class="text-xs text-gray-500 mt-1 font-mono bg-gray-100 inline-block px-1.5 py-0.5 rounded">
                                        {{ $order->platform_order_id }}
                                    </div>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-3 py-4">
                                <div class="text-sm font-semibold text-gray-900">{{ $order->formatted_total }}</div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4">
                                @php $meta = $order->status_meta @endphp
                                <span class="inline-flex items-center rounded-md bg-{{ $meta['color'] }}-50 px-2 py-1 text-xs font-medium text-{{ $meta['color'] }}-700 ring-1 ring-inset ring-{{ $meta['color'] }}-600/20">
                                    {{ $meta['label'] }}
                                </span>
                            </td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                <div class="flex items-center justify-end gap-3">
                                    <a href="{{ route('admin.shop.orders.edit', $order) }}" class="text-gray-400 hover:text-amber-600 transition-colors" title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                    </a>
                                    <form action="{{ route('admin.shop.orders.destroy', $order) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus pesanan ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                                    </svg>
                                    <p class="text-base font-medium text-gray-900">Belum ada pesanan</p>
                                    <p class="text-sm text-gray-500 mt-1">Data pesanan dari berbagai platform akan muncul di sini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($orders->hasPages())
            <div class="border-t border-gray-200 px-4 py-3 sm:px-6">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
