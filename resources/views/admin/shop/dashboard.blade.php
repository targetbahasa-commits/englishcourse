@extends('layouts.admin')

@section('title', 'Laporan Penjualan (E-Commerce)')

@section('content')
<div class="p-8 pb-24 max-w-7xl mx-auto" x-data="{ filterType: '{{ $filter }}' }">

    {{-- Header & Filters --}}
    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Laporan Penjualan</h1>
            <p class="text-sm text-gray-500 mt-1">Ringkasan performa penjualan produk E-Commerce.</p>
        </div>
        
        <form action="{{ route('admin.shop.dashboard') }}" method="GET" class="flex flex-col sm:flex-row items-end gap-3 bg-white p-3 rounded-2xl shadow-sm border border-gray-200/60">
            <div>
                <label class="block text-xs font-medium text-gray-700 mb-1">Pilih Rentang Waktu</label>
                <select name="filter" x-model="filterType" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-2">
                    <option value="today">Hari Ini</option>
                    <option value="last_7_days">7 Hari Terakhir</option>
                    <option value="this_month">Bulan Ini</option>
                    <option value="this_year">Tahun Ini</option>
                    <option value="all_time">Semua Waktu</option>
                    <option value="custom">Kustom Tanggal</option>
                </select>
            </div>
            
            <div x-show="filterType === 'custom'" class="flex items-center gap-2" x-cloak>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Mulai</label>
                    <input type="date" name="start_date" value="{{ request('start_date', $startDate ? $startDate->format('Y-m-d') : '') }}" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-2">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-700 mb-1">Sampai</label>
                    <input type="date" name="end_date" value="{{ request('end_date', $endDate ? $endDate->format('Y-m-d') : '') }}" class="block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 sm:text-sm py-2">
                </div>
            </div>

            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-gray-900 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-gray-800 transition-colors h-[38px]">
                Terapkan
            </button>
        </form>
    </div>

    {{-- Scorecards --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6 flex items-center gap-4 relative overflow-hidden">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Pendapatan</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
        </div>
        
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6 flex items-center gap-4 relative overflow-hidden">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Pesanan Masuk</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalOrders, 0, ',', '.') }}</p>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6 flex items-center gap-4 relative overflow-hidden">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Barang Terjual</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($totalItemsSold, 0, ',', '.') }}</p>
            </div>
            <div class="absolute -right-4 -bottom-4 opacity-5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-32 w-32" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" /></svg>
            </div>
        </div>
    </div>

    {{-- Charts --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Trend Chart --}}
        <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Tren Penjualan</h2>
            <div class="relative h-64 w-full">
                <canvas id="trendChart"></canvas>
            </div>
        </div>

        {{-- Platform Pie Chart --}}
        <div class="lg:col-span-1 bg-white rounded-2xl shadow-sm border border-gray-200/60 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Penjualan by Platform</h2>
            <div class="relative h-64 w-full flex justify-center">
                <canvas id="platformChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Tables: Top Products & Recent Orders --}}
    <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
        
        {{-- Top Products --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-0 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Produk Terlaris</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th scope="col" class="py-3 pl-6 pr-3 text-left text-xs font-semibold text-gray-500 uppercase">Produk</th>
                            <th scope="col" class="px-3 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Terjual (Qty)</th>
                            <th scope="col" class="px-3 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Omzet</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($topProducts as $product)
                            <tr>
                                <td class="whitespace-nowrap py-4 pl-6 pr-3">
                                    <div class="flex items-center gap-3">
                                        @if($product->cover_image)
                                            <img src="{{ Storage::url($product->cover_image) }}" class="w-10 h-10 rounded-lg object-cover bg-gray-100">
                                        @else
                                            <div class="w-10 h-10 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 font-bold">{{ substr($product->name, 0, 1) }}</div>
                                        @endif
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $product->type_label }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-right">
                                    <span class="text-sm font-semibold text-gray-900">{{ $product->total_qty ?? 0 }}</span>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-right">
                                    <span class="text-sm font-medium text-gray-900">Rp {{ number_format($product->total_revenue ?? 0, 0, ',', '.') }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-6 py-8 text-center text-gray-500 text-sm">Belum ada data penjualan produk</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Recent Orders --}}
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200/60 p-0 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900">Pesanan Masuk Terbaru</h2>
                <a href="{{ route('admin.shop.orders.index') }}" class="text-sm font-medium text-amber-600 hover:text-amber-700">Lihat Semua &rarr;</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50/50">
                        <tr>
                            <th scope="col" class="py-3 pl-6 pr-3 text-left text-xs font-semibold text-gray-500 uppercase">Pembeli</th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Total</th>
                            <th scope="col" class="px-3 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($recentOrders as $order)
                            <tr>
                                <td class="whitespace-nowrap py-3 pl-6 pr-3">
                                    <div class="text-sm font-medium text-gray-900">{{ $order->customer_name }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5">{{ $order->order_date->diffForHumans() }} &bull; {{ $order->platform_label }}</div>
                                </td>
                                <td class="whitespace-nowrap px-3 py-3 text-sm font-medium text-gray-900">
                                    {{ $order->formatted_total }}
                                </td>
                                <td class="whitespace-nowrap px-3 py-3">
                                    @php $meta = $order->status_meta @endphp
                                    <span class="inline-flex items-center rounded-md bg-{{ $meta['color'] }}-50 px-2 py-1 text-[10px] font-medium text-{{ $meta['color'] }}-700 ring-1 ring-inset ring-{{ $meta['color'] }}-600/20">
                                        {{ $meta['label'] }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="px-6 py-8 text-center text-gray-500 text-sm">Belum ada pesanan terbaru</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</div>

{{-- Chart.js integration --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        
        // --- Trend Chart ---
        const ctxTrend = document.getElementById('trendChart').getContext('2d');
        const trendLabels = {!! json_encode($trendLabels) !!};
        const trendData = {!! json_encode($trendRevenues) !!};
        
        // Create gradient for line chart
        let gradient = ctxTrend.createLinearGradient(0, 0, 0, 300);
        gradient.addColorStop(0, 'rgba(217, 119, 6, 0.4)'); // amber-600
        gradient.addColorStop(1, 'rgba(217, 119, 6, 0)');

        new Chart(ctxTrend, {
            type: 'line',
            data: {
                labels: trendLabels,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: trendData,
                    borderColor: '#D97706', // amber-600
                    backgroundColor: gradient,
                    borderWidth: 2,
                    pointBackgroundColor: '#fff',
                    pointBorderColor: '#D97706',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) { label += ': '; }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(context.parsed.y);
                                }
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value, index, values) {
                                if (value >= 1000000) return (value / 1000000) + ' Jt';
                                if (value >= 1000) return (value / 1000) + ' Rb';
                                return value;
                            }
                        },
                        grid: { borderDash: [2, 4], color: '#f3f4f6', drawBorder: false }
                    },
                    x: {
                        grid: { display: false, drawBorder: false }
                    }
                }
            }
        });

        // --- Platform Chart (Doughnut) ---
        const ctxPlatform = document.getElementById('platformChart').getContext('2d');
        const platformLabels = {!! json_encode($platformLabels) !!};
        const platformData = {!! json_encode($platformRevenues) !!};
        const bgColors = {!! json_encode($bgColors) !!};

        if(platformData.length > 0 && Math.max(...platformData) > 0) {
            new Chart(ctxPlatform, {
                type: 'doughnut',
                data: {
                    labels: platformLabels,
                    datasets: [{
                        data: platformData,
                        backgroundColor: bgColors,
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '65%',
                    plugins: {
                        legend: { position: 'bottom', labels: { boxWidth: 12, padding: 15, font: {size: 11} } },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return context.label + ': ' + new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(context.raw);
                                }
                            }
                        }
                    }
                }
            });
        } else {
            // Draw empty state manually or hide chart
            ctxPlatform.font = "14px Inter, sans-serif";
            ctxPlatform.fillStyle = "#9ca3af";
            ctxPlatform.textAlign = "center";
            ctxPlatform.fillText("Belum ada data penjualan", 150, 120);
        }
    });
</script>
<style>
    [x-cloak] { display: none !important; }
</style>
@endsection
