@extends('layouts.admin')

@section('title', 'Hasil Tes Penempatan Grammar')

@section('content')
<div class="p-6 sm:p-8">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <a href="{{ route('admin.grammar-placement.packages.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1 mb-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar Paket
            </a>
            <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">Hasil Tes Penempatan Grammar</h1>
            <p class="text-sm text-gray-500 mt-1">
                Riwayat peserta yang sudah mengerjakan tes penempatan grammar.
                @if(request('package_id'))
                    <a href="{{ route('admin.grammar-placement.results.index') }}" class="text-blue-600 hover:underline">(hapus filter paket)</a>
                @endif
            </p>
        </div>
    </div>

    <div class="bg-white shadow-sm overflow-hidden border border-gray-200 rounded-xl">
        @if($results->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                <h3 class="text-base font-bold text-gray-900">Belum ada hasil tes.</h3>
                <p class="text-xs text-gray-500 mt-1">Hasil akan muncul di sini setelah tes penempatan grammar dijalankan.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs uppercase tracking-wider text-gray-400 font-semibold">Peserta</th>
                            <th class="px-5 py-3 text-left text-xs uppercase tracking-wider text-gray-400 font-semibold">Paket</th>
                            <th class="px-5 py-3 text-left text-xs uppercase tracking-wider text-gray-400 font-semibold">Skor</th>
                            <th class="px-5 py-3 text-left text-xs uppercase tracking-wider text-gray-400 font-semibold">CEFR</th>
                            <th class="px-5 py-3 text-left text-xs uppercase tracking-wider text-gray-400 font-semibold">Rekomendasi Kelas</th>
                            <th class="px-5 py-3 text-left text-xs uppercase tracking-wider text-gray-400 font-semibold">Tanggal</th>
                            <th class="px-5 py-3 text-right text-xs uppercase tracking-wider text-gray-400 font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($results as $r)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-4">
                                    <div class="font-medium text-gray-800">{{ $r->student_name }}</div>
                                    @if($r->student_phone)
                                        <div class="text-xs text-gray-400">{{ $r->student_phone }}</div>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-sm text-gray-600">{{ $r->package->title ?? '—' }}</td>
                                <td class="px-5 py-4 text-sm text-gray-600">{{ $r->correct_count }}/{{ $r->total_count }} ({{ $r->percentage }}%)</td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800">{{ $r->cefr_level }}</span>
                                </td>
                                <td class="px-5 py-4 text-sm text-gray-700">{{ $r->recommendedProgram->name ?? '—' }}</td>
                                <td class="px-5 py-4 text-xs text-gray-400">{{ $r->created_at->format('d M Y H:i') }}</td>
                                <td class="px-5 py-4 text-right">
                                    <a href="{{ route('admin.grammar-placement.results.show', $r) }}" class="text-blue-600 hover:text-blue-800 text-sm font-semibold">Lihat</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-5 py-4 border-t border-gray-100">
                {{ $results->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
