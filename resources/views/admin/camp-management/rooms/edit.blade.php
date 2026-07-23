@extends('layouts.admin')

@section('content')
<div class="p-6 md:p-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
    <h1 class="text-3xl font-bold font-serif text-gray-900">
        {{ __('Edit Kamar - ') }} {{ $camp->nama_camp }}
    </h1>
    <a href="{{ route('admin.camps.show', $camp) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali
    </a>
</div>
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6">
                <form action="{{ route('admin.rooms.update', $campRoom) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="nama_kamar" class="block text-sm font-medium text-gray-700 mb-1">Nama Kamar <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_kamar" id="nama_kamar" value="{{ old('nama_kamar', $campRoom->nama_kamar) }}" required class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('nama_kamar')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="kapasitas_per_kamar" class="block text-sm font-medium text-gray-700 mb-1">Kapasitas (Orang) <span class="text-red-500">*</span></label>
                            <input type="number" name="kapasitas_per_kamar" id="kapasitas_per_kamar" value="{{ old('kapasitas_per_kamar', $campRoom->kapasitas_per_kamar) }}" min="1" required class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('kapasitas_per_kamar')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="harga_per_orang" class="block text-sm font-medium text-gray-700 mb-1">Harga Per Orang (Rp) <span class="text-red-500">*</span></label>
                            <input type="number" name="harga_per_orang" id="harga_per_orang" value="{{ old('harga_per_orang', (int)$campRoom->harga_per_orang) }}" min="0" step="1" required class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('harga_per_orang')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status <span class="text-red-500">*</span></label>
                        <select name="status" id="status" required class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="Tersedia" {{ old('status', $campRoom->status) == 'Tersedia' ? 'selected' : '' }}>Tersedia</option>
                            <option value="Penuh" {{ old('status', $campRoom->status) == 'Penuh' ? 'selected' : '' }}>Penuh</option>
                        </select>
                        @error('status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm font-medium shadow-sm transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
