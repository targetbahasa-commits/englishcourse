@extends('layouts.admin')

@section('title', 'Edit Pesanan')

@section('content')
<div class="p-8 pb-24 max-w-5xl mx-auto" x-data="orderForm()">

    {{-- Header --}}
    <div class="flex items-center justify-between gap-3 mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.shop.orders.index') }}" class="text-gray-400 hover:text-gray-600 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Pesanan #{{ $order->id }}</h1>
                <p class="text-sm text-gray-500 mt-1">Dibuat: {{ $order->order_date->format('d M Y H:i') }}</p>
            </div>
        </div>
        @if($order->user_id)
            <span class="inline-flex items-center rounded-md bg-emerald-50 px-2.5 py-1.5 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">
                <svg class="mr-1.5 h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M16.704 4.153a.75.75 0 01.143 1.052l-8 10.5a.75.75 0 01-1.127.075l-4.5-4.5a.75.75 0 011.06-1.06l3.894 3.893 7.48-9.817a.75.75 0 011.05-.143z" clip-rule="evenodd" /></svg>
                Akun Siswa Dibuat
            </span>
        @endif
    </div>

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.shop.orders.update', $order) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- Kiri: Data Pesanan & Pembeli --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Data Pesanan --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pesanan</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Platform <span class="text-red-500">*</span></label>
                            <select name="platform" required class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm">
                                @foreach($platforms as $key => $label)
                                    <option value="{{ $key }}" {{ old('platform', $order->platform) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pesanan <span class="text-red-500">*</span></label>
                            <input type="datetime-local" name="order_date" required value="{{ old('order_date', $order->order_date->format('Y-m-d\TH:i')) }}" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">ID Pesanan / Resi (Opsional)</label>
                            <input type="text" name="platform_order_id" value="{{ old('platform_order_id', $order->platform_order_id) }}" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                            <select name="status" required class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm {{ $order->status == 'completed' ? 'bg-gray-100' : '' }}" {{ $order->status == 'completed' ? 'readonly' : '' }}>
                                @foreach($statuses as $key => $statusData)
                                    <option value="{{ $key }}" {{ old('status', $order->status) == $key ? 'selected' : '' }}>{{ $statusData['label'] }}</option>
                                @endforeach
                            </select>
                            @if($order->status == 'completed')
                                <p class="text-xs text-gray-500 mt-1">Status tidak bisa diubah karena sudah memotong stok/membuat akun.</p>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Data Pembeli --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pembeli</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                            <input type="text" name="customer_name" required value="{{ old('customer_name', $order->customer_name) }}" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nomor WhatsApp (Opsional)</label>
                            <input type="text" name="customer_whatsapp" value="{{ old('customer_whatsapp', $order->customer_whatsapp) }}" placeholder="Contoh: 08123456789" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm">
                        </div>
                        <div class="sm:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Catatan Tambahan (Opsional)</label>
                            <textarea name="notes" rows="2" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm">{{ old('notes', $order->notes) }}</textarea>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Kanan: Produk & Keranjang --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6 sticky top-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Produk Dibeli</h2>
                        @if($order->status != 'completed')
                            <button type="button" @click="addItem()" class="text-sm font-medium text-amber-600 hover:text-amber-700">+ Tambah</button>
                        @endif
                    </div>

                    <div class="space-y-4 mb-6">
                        <template x-for="(item, index) in items" :key="index">
                            <div class="bg-gray-50 p-4 rounded-xl border border-gray-100 relative">
                                @if($order->status != 'completed')
                                    <button type="button" @click="removeItem(index)" x-show="items.length > 1" class="absolute top-2 right-2 text-gray-400 hover:text-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                    </button>
                                @endif
                                
                                <div class="mb-3 pr-6">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Pilih Produk</label>
                                    <select :name="'product_ids['+index+']'" x-model="item.product_id" @change="updatePrice(index)" required class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-xs py-1.5 {{ $order->status == 'completed' ? 'bg-gray-100 pointer-events-none' : '' }}" {{ $order->status == 'completed' ? 'readonly' : '' }}>
                                        <option value="">- Pilih Produk -</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->price_final_formatted }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Qty</label>
                                        <input type="number" :name="'quantities['+index+']'" x-model="item.qty" min="1" required class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-xs py-1.5 {{ $order->status == 'completed' ? 'bg-gray-100' : '' }}" {{ $order->status == 'completed' ? 'readonly' : '' }}>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Harga (Rp)</label>
                                        <input type="number" :name="'prices['+index+']'" x-model="item.price" min="0" required class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-xs py-1.5 {{ $order->status == 'completed' ? 'bg-gray-100' : '' }}" {{ $order->status == 'completed' ? 'readonly' : '' }}>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    <div class="border-t border-gray-100 pt-4 mb-6">
                        <div class="flex items-center justify-between font-semibold text-lg">
                            <span class="text-gray-700">Total Harga</span>
                            <span class="text-amber-600" x-text="'Rp ' + formatRupiah(totalAmount)">Rp 0</span>
                        </div>
                    </div>

                    <button type="submit" class="w-full inline-flex justify-center rounded-xl bg-gray-900 px-3 py-3 text-sm font-semibold text-white shadow-sm hover:bg-gray-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-900 transition-all">
                        Simpan Perubahan
                    </button>
                    @if($order->status != 'completed')
                        <p class="text-xs text-center text-amber-600 mt-3 bg-amber-50 p-2 rounded-lg border border-amber-200">Ubah status ke "Selesai" untuk otomatis memotong stok produk & membuat akun siswa (jika produk digital).</p>
                    @endif
                </div>
            </div>

        </div>
    </form>
</div>

{{-- Pass products data to JS --}}
<script>
    const productsData = {
        @foreach($products as $p)
            "{{ $p->id }}": {{ $p->price_final }},
        @endforeach
    };
    
    // Initial Items from Backend
    const initialItems = [
        @foreach($order->items as $item)
            { product_id: "{{ $item->shop_product_id }}", qty: {{ $item->quantity }}, price: {{ $item->price_at_order }} },
        @endforeach
    ];
</script>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('orderForm', () => ({
            items: initialItems.length > 0 ? initialItems : [ { product_id: '', qty: 1, price: 0 } ],
            
            addItem() {
                this.items.push({ product_id: '', qty: 1, price: 0 });
            },
            
            removeItem(index) {
                if(this.items.length > 1) {
                    this.items.splice(index, 1);
                }
            },
            
            updatePrice(index) {
                const pid = this.items[index].product_id;
                if(pid && productsData[pid]) {
                    this.items[index].price = productsData[pid];
                } else {
                    this.items[index].price = 0;
                }
            },
            
            get totalAmount() {
                return this.items.reduce((total, item) => {
                    const qty = parseInt(item.qty) || 0;
                    const price = parseInt(item.price) || 0;
                    return total + (qty * price);
                }, 0);
            },
            
            formatRupiah(number) {
                return new Intl.NumberFormat('id-ID').format(number);
            }
        }))
    });
</script>
@endsection
