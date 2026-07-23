@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
<div class="p-8 pb-24 max-w-4xl mx-auto">

    {{-- Header --}}
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.shop.products.index') }}"
           class="p-2 bg-gray-100 hover:bg-gray-200 rounded-xl transition">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Produk</h1>
            <p class="text-sm text-gray-500">{{ $product->name }}</p>
        </div>
    </div>

    @if($errors->any())
    <div class="mb-5 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700">
        <p class="font-semibold mb-1">Ada kesalahan pada form:</p>
        <ul class="list-disc list-inside space-y-0.5">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.shop.products.update', $product) }}" method="POST" enctype="multipart/form-data" x-data="productForm()">
        @csrf @method('PUT')
        <div class="space-y-6">

            {{-- ── Informasi Dasar ─────────────────────────────── --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 bg-orange-500 text-white text-xs font-bold rounded-full flex items-center justify-center">1</span>
                    Informasi Dasar
                </h2>
                <div class="space-y-4">

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Nama Produk <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400 outline-none">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Tipe Produk <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                            @foreach($types as $key => $type)
                            <label class="relative flex items-center gap-2.5 p-3 border-2 rounded-xl cursor-pointer transition
                                          has-[:checked]:border-orange-400 has-[:checked]:bg-orange-50 border-gray-200 hover:border-gray-300">
                                <input type="radio" name="type" value="{{ $key }}" class="sr-only"
                                       {{ old('type', $product->type) === $key ? 'checked' : '' }}>
                                <span class="text-xl">{{ $type['icon'] }}</span>
                                <span class="text-xs font-semibold text-gray-700 leading-tight">{{ $type['label'] }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Deskripsi</label>
                        <textarea name="description" rows="4"
                                  class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400 outline-none resize-none"
                                  placeholder="Isi detail produk...">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Program Terkait</label>
                        <select name="program_id" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400 outline-none bg-white">
                            <option value="">Tidak terkait program khusus</option>
                            @foreach($programs as $program)
                            <option value="{{ $program->id }}" {{ old('program_id', $product->program_id) == $program->id ? 'selected' : '' }}>{{ $program->name }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>

            {{-- ── Gambar Cover ────────────────────────────────── --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 bg-orange-500 text-white text-xs font-bold rounded-full flex items-center justify-center">2</span>
                    Gambar Cover
                </h2>
                @if($product->cover_image)
                <div class="mb-4">
                    <p class="text-xs text-gray-500 mb-2 font-medium">Gambar saat ini:</p>
                    <img src="{{ $product->cover_url }}" alt="{{ $product->name }}" class="h-32 object-contain rounded-xl border border-gray-100">
                </div>
                @endif
                <div class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-orange-300 transition"
                     x-on:dragover.prevent x-on:drop.prevent="handleDrop($event)">
                    <input type="file" name="cover_image" accept="image/*" id="cover_image"
                           class="hidden" x-on:change="previewImage($event)">
                    <div x-show="!imagePreview" class="space-y-2">
                        <svg class="w-10 h-10 text-gray-300 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <p class="text-sm text-gray-500">
                            {{ $product->cover_image ? 'Drag & drop atau ' : 'Drag & drop atau ' }}
                            <button type="button" onclick="document.getElementById('cover_image').click()" class="text-orange-500 font-semibold hover:underline">
                                {{ $product->cover_image ? 'ganti gambar' : 'pilih gambar' }}
                            </button>
                        </p>
                        <p class="text-xs text-gray-400">JPG, PNG, max 2MB</p>
                    </div>
                    <div x-show="imagePreview" class="space-y-2">
                        <img :src="imagePreview" class="h-40 object-contain mx-auto rounded-lg" alt="Preview">
                        <button type="button" onclick="document.getElementById('cover_image').click()" class="text-xs text-orange-500 font-semibold hover:underline">Ganti gambar</button>
                    </div>
                </div>
            </div>

            {{-- ── Harga & Stok ────────────────────────────────── --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 bg-orange-500 text-white text-xs font-bold rounded-full flex items-center justify-center">3</span>
                    Harga & Stok
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Harga Normal (Rp) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium">Rp</span>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" min="0" required
                                   class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400 outline-none">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Harga Diskon (Rp)</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm font-medium">Rp</span>
                            <input type="number" name="price_discounted" value="{{ old('price_discounted', $product->price_discounted) }}" min="0"
                                   class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400 outline-none"
                                   placeholder="Kosongkan jika tidak ada diskon">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Stok</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400 outline-none"
                               x-bind:disabled="unlimitedStock">
                        <label class="flex items-center gap-2 mt-2 cursor-pointer">
                            <input type="checkbox" name="unlimited_stock" value="1" x-model="unlimitedStock"
                                   {{ old('unlimited_stock', is_null($product->stock)) ? 'checked' : '' }}
                                   class="w-4 h-4 rounded accent-orange-500">
                            <span class="text-xs text-gray-600 font-medium">Stok Unlimited (untuk produk digital)</span>
                        </label>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Berat (gram)</label>
                        <input type="number" name="weight_gram" value="{{ old('weight_gram', $product->weight_gram) }}" min="0"
                               class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400 outline-none"
                               placeholder="Khusus buku fisik...">
                    </div>
                </div>
            </div>

            {{-- ── Link Digital ─────────────────────────────────── --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 bg-orange-500 text-white text-xs font-bold rounded-full flex items-center justify-center">4</span>
                    Link File / Video Digital
                </h2>
                <input type="url" name="file_url" value="{{ old('file_url', $product->file_url) }}"
                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400 outline-none"
                       placeholder="https://drive.google.com/... atau link video">
            </div>

            {{-- ── Platform Links ───────────────────────────────── --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h2 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <span class="w-6 h-6 bg-orange-500 text-white text-xs font-bold rounded-full flex items-center justify-center">5</span>
                    Link Platform Penjualan
                </h2>
                <div class="space-y-3">
                    @foreach([
                        ['name' => 'platform_shopee',    'label' => 'Shopee',     'icon' => '🛒', 'key' => 'shopee',    'type' => 'url'],
                        ['name' => 'platform_tokopedia', 'label' => 'Tokopedia',  'icon' => '🟢', 'key' => 'tokopedia', 'type' => 'url'],
                        ['name' => 'platform_tiktok',    'label' => 'TikTok Shop','icon' => '🎵', 'key' => 'tiktok',    'type' => 'url'],
                        ['name' => 'platform_whatsapp',  'label' => 'WhatsApp',   'icon' => '💬', 'key' => 'whatsapp',  'type' => 'text'],
                        ['name' => 'platform_instagram', 'label' => 'Instagram',  'icon' => '📸', 'key' => 'instagram', 'type' => 'url'],
                    ] as $p)
                    <div class="flex items-center gap-3">
                        <div class="w-28 flex items-center gap-2 flex-shrink-0">
                            <span>{{ $p['icon'] }}</span>
                            <span class="text-sm font-semibold text-gray-700">{{ $p['label'] }}</span>
                        </div>
                        <input type="{{ $p['type'] }}" name="{{ $p['name'] }}"
                               value="{{ old($p['name'], $product->platform_links[$p['key']] ?? '') }}"
                               class="flex-1 border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-orange-300 focus:border-orange-400 outline-none">
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- ── Status & Submit ─────────────────────────────── --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <div class="relative inline-flex">
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" {{ $product->is_active ? 'checked' : '' }}
                                   class="peer sr-only">
                            <div class="w-11 h-6 rounded-full bg-gray-200 peer-checked:bg-orange-500 transition-colors"></div>
                            <div class="absolute top-0.5 left-0.5 w-5 h-5 bg-white rounded-full shadow transition-transform peer-checked:translate-x-5"></div>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Aktifkan Produk</p>
                            <p class="text-xs text-gray-400">Produk aktif akan tercatat sebagai tersedia</p>
                        </div>
                    </label>
                    <div class="flex gap-3">
                        <a href="{{ route('admin.shop.products.index') }}"
                           class="px-5 py-2.5 text-sm font-semibold text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition">
                            Batal
                        </a>
                        <button type="submit"
                                class="px-6 py-2.5 text-sm font-semibold text-white bg-orange-500 rounded-xl hover:bg-orange-600 transition shadow-sm">
                            💾 Simpan Perubahan
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
function productForm() {
    return {
        imagePreview: null,
        unlimitedStock: {{ is_null($product->stock) ? 'true' : 'false' }},
        previewImage(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => { this.imagePreview = e.target.result; };
                reader.readAsDataURL(file);
            }
        },
        handleDrop(event) {
            const file = event.dataTransfer.files[0];
            if (file && file.type.startsWith('image/')) {
                const dt = new DataTransfer();
                dt.items.add(file);
                document.getElementById('cover_image').files = dt.files;
                const reader = new FileReader();
                reader.onload = (e) => { this.imagePreview = e.target.result; };
                reader.readAsDataURL(file);
            }
        },
    }
}
</script>
@endsection
