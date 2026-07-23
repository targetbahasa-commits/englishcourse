@extends('layouts.admin')

@section('content')
<div class="p-6 md:p-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
    <h1 class="text-3xl font-bold font-serif text-gray-900">
        {{ __('Edit Master Camp') }}
    </h1>
    <a href="{{ route('admin.camps.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm font-medium transition">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali
    </a>
</div>
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6">
                <form action="{{ route('admin.camps.update', $camp) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label for="nama_camp" class="block text-sm font-medium text-gray-700 mb-1">Nama Camp <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_camp" id="nama_camp" value="{{ old('nama_camp', $camp->nama_camp) }}" required class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                        @error('nama_camp')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <textarea name="alamat" id="alamat" rows="3" class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ old('alamat', $camp->alamat) }}</textarea>
                        @error('alamat')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="gender_khusus" class="block text-sm font-medium text-gray-700 mb-1">Gender Khusus <span class="text-red-500">*</span></label>
                            <select name="gender_khusus" id="gender_khusus" required class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                <option value="Putra" {{ old('gender_khusus', $camp->gender_khusus) == 'Putra' ? 'selected' : '' }}>Putra</option>
                                <option value="Putri" {{ old('gender_khusus', $camp->gender_khusus) == 'Putri' ? 'selected' : '' }}>Putri</option>
                            </select>
                            @error('gender_khusus')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label for="jumlah_toilet" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Toilet <span class="text-red-500">*</span></label>
                            <input type="number" name="jumlah_toilet" id="jumlah_toilet" value="{{ old('jumlah_toilet', $camp->jumlah_toilet) }}" min="0" required class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            @error('jumlah_toilet')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label for="teacher_id" class="block text-sm font-medium text-gray-700 mb-1">Tutor / Teacher <span class="text-red-500">*</span></label>
                        <select name="teacher_id" id="teacher_id" required class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                            <option value="">-- Pilih Tutor --</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}" {{ old('teacher_id', $camp->teacher_id) == $teacher->id ? 'selected' : '' }}>{{ $teacher->name }} ({{ $teacher->email }})</option>
                            @endforeach
                        </select>
                        @error('teacher_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        <p class="mt-1 text-xs text-gray-500">Tutor yang bertanggung jawab penuh atas camp ini.</p>
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
