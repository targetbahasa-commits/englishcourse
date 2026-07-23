@extends('layouts.admin')

@section('content')
<div class="p-6 md:p-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
    <h1 class="text-3xl font-bold font-serif text-gray-900">
        {{ __('Camp Management Dashboard') }}
    </h1>
</div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- Navigation Tabs -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex gap-4">
            <a href="{{ route('admin.camp-management.index') }}" class="px-4 py-2 bg-blue-50 text-blue-700 font-semibold rounded-lg">Dashboard</a>
            <a href="{{ route('admin.camps.index') }}" class="px-4 py-2 text-gray-600 hover:bg-gray-50 font-medium rounded-lg transition">Master Camps</a>
            <a href="{{ route('admin.camp-reviews.index') }}" class="px-4 py-2 text-gray-600 hover:bg-gray-50 font-medium rounded-lg transition">Camp Reviews</a>
        </div>

        <!-- Primary Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm font-medium text-gray-500 mb-1">Total Camps</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalCamps }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm font-medium text-gray-500 mb-1">Total Kamar</p>
                <p class="text-3xl font-bold text-gray-900">{{ $totalRooms }}</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm font-medium text-gray-500 mb-1">Total Penghuni</p>
                <p class="text-3xl font-bold text-blue-600">{{ $totalPenghuni }} <span class="text-sm font-normal text-gray-400">/ {{ $totalKapasitas }}</span></p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                <p class="text-sm font-medium text-gray-500 mb-1">Potensi Sisa Kuota</p>
                <p class="text-xl font-bold text-green-600">Rp {{ number_format($potensiPendapatan, 0, ',', '.') }}</p>
                <p class="text-xs text-gray-400 mt-1">Dari {{ $sisaKuota }} sisa kapasitas</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Top Camps -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-4">
                    <h3 class="text-white font-bold text-lg">Top Camps (Overall Rating)</h3>
                </div>
                <div class="p-6">
                    @if($campsWithReviews->isEmpty())
                        <p class="text-gray-500 text-center py-4">Belum ada ulasan untuk menampilkan top camps.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($campsWithReviews as $index => $camp)
                                <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-100">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold {{ $index === 0 ? 'bg-yellow-100 text-yellow-600' : ($index === 1 ? 'bg-gray-200 text-gray-600' : ($index === 2 ? 'bg-amber-100 text-amber-600' : 'bg-blue-100 text-blue-600')) }}">
                                            #{{ $index + 1 }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $camp->nama_camp }}</p>
                                            <div class="flex items-center gap-2 text-xs text-gray-500 mt-0.5">
                                                <span>Brs: {{ number_format($camp->avg_kebersihan, 1) }}</span>
                                                <span>•</span>
                                                <span>Fas: {{ number_format($camp->avg_fasilitas, 1) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="flex items-center gap-1 text-amber-500 font-bold justify-end">
                                            <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            {{ number_format($camp->composite_score, 1) }}
                                        </div>
                                        <p class="text-xs text-gray-500 mt-1">Composite Score</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Camps Kosong -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-red-500 to-rose-600 px-6 py-4">
                    <h3 class="text-white font-bold text-lg">Camps Kosong (0 Penghuni)</h3>
                </div>
                <div class="p-6">
                    @if($campsKosong->isEmpty())
                        <div class="text-center py-8">
                            <div class="w-16 h-16 bg-green-50 text-green-500 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <p class="text-gray-500">Semua camp aktif saat ini memiliki setidaknya 1 penghuni.</p>
                        </div>
                    @else
                        <div class="space-y-4">
                            @foreach($campsKosong as $camp)
                                <div class="flex items-center justify-between p-4 bg-rose-50/50 rounded-lg border border-rose-100">
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $camp->nama_camp }}</p>
                                        <p class="text-xs text-gray-500">{{ $camp->rooms->count() }} Kamar tersedia</p>
                                    </div>
                                    <div class="text-right">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Kapasitas: {{ $camp->total_kapasitas }}
                                        </span>
                                        <p class="text-xs text-gray-500 mt-1"><a href="{{ route('admin.camps.show', $camp) }}" class="text-blue-600 hover:underline">Kelola Camp &rarr;</a></p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
