@extends('layouts.admin')

@section('content')
<div class="p-6 md:p-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
    <h1 class="text-3xl font-bold font-serif text-gray-900">
        {{ __('Detail Camp: ') }} {{ $camp->nama_camp }}
    </h1>
    <div class="flex gap-2">
        <a href="{{ route('admin.camps.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
        <a href="{{ route('admin.camps.edit', $camp) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-amber-500 text-white rounded-lg hover:bg-amber-600 text-sm font-medium transition">
            Edit Camp
        </a>
    </div>
</div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-4 rounded-lg">
                <p class="text-green-700">{{ session('success') }}</p>
            </div>
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Camp Detail Card -->
            <div class="col-span-1">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                        <h3 class="font-semibold text-gray-900">Informasi Camp</h3>
                    </div>
                    <div class="p-6 space-y-4">
                        <div>
                            <p class="text-sm text-gray-500">Nama Camp</p>
                            <p class="font-medium text-gray-900">{{ $camp->nama_camp }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Alamat</p>
                            <p class="text-gray-900">{{ $camp->alamat ?: '-' }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Gender Khusus</p>
                            <p class="text-gray-900">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $camp->gender_khusus == 'Putra' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800' }}">
                                    {{ $camp->gender_khusus }}
                                </span>
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Jumlah Toilet</p>
                            <p class="text-gray-900">{{ $camp->jumlah_toilet }}</p>
                        </div>
                        <div class="pt-4 border-t border-gray-100">
                            <p class="text-sm text-gray-500 mb-1">Tutor / Teacher</p>
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold">
                                    {{ substr($camp->teacher->name ?? '?', 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">{{ $camp->teacher->name ?? 'N/A' }}</p>
                                    <p class="text-xs text-gray-500">{{ $camp->teacher->email ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rooms List -->
            <div class="col-span-1 md:col-span-2">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                        <h3 class="font-semibold text-gray-900">Daftar Kamar ({{ $camp->rooms->count() }})</h3>
                        <a href="{{ route('admin.camps.rooms.create', $camp) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 text-white rounded text-sm font-medium hover:bg-blue-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Tambah Kamar
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 border-b border-gray-200 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <tr>
                                    <th class="px-6 py-3">Nama Kamar</th>
                                    <th class="px-6 py-3">Kapasitas</th>
                                    <th class="px-6 py-3">Terisi</th>
                                    <th class="px-6 py-3">Harga/Orang</th>
                                    <th class="px-6 py-3">Status</th>
                                    <th class="px-6 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($camp->rooms as $room)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $room->nama_kamar }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $room->kapasitas_per_kamar }} Orang
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $room->jumlah_penghuni }} Orang
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            Rp {{ number_format($room->harga_per_orang, 0, ',', '.') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $room->status == 'Tersedia' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $room->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('admin.rooms.edit', $room) }}" class="text-amber-600 hover:text-amber-900 mr-3 transition">Edit</a>
                                            <form action="{{ route('admin.rooms.destroy', $room) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus kamar ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900 transition">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                            <p class="text-sm">Belum ada kamar di camp ini.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
