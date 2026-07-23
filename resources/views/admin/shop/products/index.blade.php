@extends('layouts.admin')

@section('title', 'Kelola Produk')

@section('content')
<div class="p-8 pb-24 max-w-7xl mx-auto">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-400 mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                <span class="font-medium text-gray-700">E-Commerce</span>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 flex items-center gap-3">
                <span class="p-2 bg-orange-100 text-orange-600 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </span>
                Kelola Produk
            </h1>
            <p class="text-sm text-gray-500 mt-1">Buku, PDF, Voucher Kelas, Video & Mock Test yang dijual di berbagai platform.</p>
        </div>
        <a href="{{ route('admin.shop.products.create') }}"
           class="inline-flex items-center gap-2 px-5 py-2.5 bg-orange-500 text-white text-sm font-semibold rounded-xl hover:bg-orange-600 transition shadow-sm whitespace-nowrap">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Produk
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div class="mb-5 flex items-center gap-3 px-4 py-3 bg-green-50 border border-green-200 text-green-800 rounded-xl text-sm font-medium">
        <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
    @endif

    {{-- Stats Bar --}}
    @php
        $total   = \App\Models\ShopProduct::count();
        $active  = \App\Models\ShopProduct::where('is_active', true)->count();
        $digital = \App\Models\ShopProduct::whereIn('type', ['book_digital','video_class','mock_test','mock_test_pte','class_voucher'])->count();
        $physical= \App\Models\ShopProduct::where('type', 'book_physical')->count();
    @endphp
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        @foreach([
            ['label'=>'Total Produk',   'value'=> $total,   'color'=>'blue',    'icon'=>'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'],
            ['label'=>'Aktif',          'value'=> $active,  'color'=>'emerald', 'icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
            ['label'=>'Produk Digital', 'value'=> $digital, 'color'=>'violet',  'icon'=>'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
            ['label'=>'Buku Fisik',     'value'=> $physical,'color'=>'amber',   'icon'=>'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
        ] as $stat)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-{{ $stat['color'] }}-50 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-{{ $stat['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $stat['icon'] }}"/>
                </svg>
            </div>
            <div>
                <p class="text-2xl font-bold text-gray-900">{{ $stat['value'] }}</p>
                <p class="text-xs text-gray-500 font-medium">{{ $stat['label'] }}</p>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Filters --}}
    <form action="{{ route('admin.shop.products.index') }}" method="GET"
          class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 mb-6 flex flex-wrap gap-3 items-end">
        <div class="flex-1 min-w-[180px]">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Cari Produk</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama produk..."
                   class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400 outline-none">
        </div>
        <div class="min-w-[160px]">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Tipe Produk</label>
            <select name="type" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400 outline-none bg-white">
                <option value="">Semua Tipe</option>
                @foreach($types as $key => $type)
                <option value="{{ $key }}" {{ request('type') === $key ? 'selected' : '' }}>{{ $type['icon'] }} {{ $type['label'] }}</option>
                @endforeach
            </select>
        </div>
        <div class="min-w-[140px]">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Status</label>
            <select name="status" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400 outline-none bg-white">
                <option value="">Semua Status</option>
                <option value="active"   {{ request('status') === 'active'   ? 'selected' : '' }}>✅ Aktif</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>⛔ Non-aktif</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-gray-700 transition">Filter</button>
            @if(request()->anyFilled(['search','type','status']))
            <a href="{{ route('admin.shop.products.index') }}" class="px-4 py-2 text-sm text-gray-500 hover:text-gray-700 font-medium transition flex items-center">Reset</a>
            @endif
        </div>
    </form>

    {{-- Product Grid --}}
    @if($products->isEmpty())
    <div class="bg-white rounded-2xl border border-dashed border-gray-200 py-16 text-center">
        <div class="text-5xl mb-3">🛒</div>
        <p class="text-lg font-bold text-gray-900">Belum ada produk</p>
        <p class="text-sm text-gray-500 mb-5">Mulai tambahkan produk pertamamu!</p>
        <a href="{{ route('admin.shop.products.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-orange-500 text-white text-sm font-semibold rounded-xl hover:bg-orange-600 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Tambah Produk Pertama
        </a>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @foreach($products as $product)
        @php $typeMeta = $product->getTypeMeta(); @endphp
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden flex flex-col group hover:shadow-md transition">
            {{-- Cover Image --}}
            <div class="relative h-44 bg-gradient-to-br from-gray-50 to-gray-100 overflow-hidden">
                @if($product->cover_image)
                    <img src="{{ $product->cover_url }}" alt="{{ $product->name }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                @else
                    <div class="flex items-center justify-center h-full text-5xl">{{ $typeMeta['icon'] }}</div>
                @endif

                {{-- Status badge --}}
                @if(!$product->is_active)
                <div class="absolute inset-0 bg-gray-900/40 flex items-center justify-center">
                    <span class="bg-gray-800 text-white text-xs font-bold px-3 py-1 rounded-full">NON-AKTIF</span>
                </div>
                @endif

                {{-- Type badge --}}
                <span class="absolute top-3 left-3 text-xs font-bold px-2.5 py-1 rounded-full bg-{{ $typeMeta['color'] }}-100 text-{{ $typeMeta['color'] }}-700 shadow-sm">
                    {{ $typeMeta['icon'] }} {{ $typeMeta['label'] }}
                </span>

                {{-- Platform badges --}}
                @if($product->platform_links && count($product->platform_links))
                <div class="absolute bottom-2 left-2 flex gap-1 flex-wrap">
                    @foreach(array_keys($product->platform_links ?? []) as $platform)
                    <span class="text-[10px] font-semibold bg-white/90 text-gray-700 px-1.5 py-0.5 rounded capitalize shadow-sm">{{ $platform }}</span>
                    @endforeach
                </div>
                @endif
            </div>

            {{-- Info --}}
            <div class="p-4 flex-1 flex flex-col">
                <h3 class="font-bold text-gray-900 text-sm leading-tight mb-1 line-clamp-2">{{ $product->name }}</h3>

                {{-- Price --}}
                <div class="flex items-center gap-2 mb-3">
                    @if($product->price_discounted)
                    <span class="text-orange-600 font-bold text-base">Rp {{ number_format($product->price_discounted, 0, ',', '.') }}</span>
                    <span class="text-gray-400 line-through text-xs">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    @else
                    <span class="text-gray-900 font-bold text-base">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    @endif
                </div>

                {{-- Stock & Sold --}}
                <div class="flex items-center gap-3 text-xs text-gray-500 mb-4">
                    <span>
                        📦 Stok:
                        @if($product->stock === null)
                            <span class="text-blue-600 font-semibold">Unlimited</span>
                        @else
                            <span class="font-semibold">{{ $product->stock }}</span>
                        @endif
                    </span>
                    <span>✅ Terjual: <span class="font-semibold">{{ $product->sold_count }}</span></span>
                </div>

                {{-- Actions --}}
                <div class="flex gap-2 mt-auto">
                    <a href="{{ route('admin.shop.products.edit', $product) }}"
                       class="flex-1 text-center py-2 text-sm font-semibold bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition">
                        ✏️ Edit
                    </a>

                    <form method="POST" action="{{ route('admin.shop.products.toggle-active', $product) }}" class="flex-1">
                        @csrf @method('PATCH')
                        <button type="submit" class="w-full py-2 text-sm font-semibold rounded-xl transition
                            {{ $product->is_active ? 'bg-amber-50 text-amber-700 hover:bg-amber-100' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100' }}">
                            {{ $product->is_active ? '⛔ Nonaktifkan' : '✅ Aktifkan' }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.shop.products.destroy', $product) }}"
                          onsubmit="return confirm('Hapus produk ini?')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="px-3 py-2 text-sm font-semibold bg-red-50 text-red-600 rounded-xl hover:bg-red-100 transition">
                            🗑️
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Pagination --}}
    @if($products->hasPages())
    <div class="mt-8">{{ $products->links() }}</div>
    @endif
    @endif

</div>
@endsection
