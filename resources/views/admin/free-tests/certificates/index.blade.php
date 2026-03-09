@extends('layouts.admin')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <!-- Page Header -->
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-slate-800 font-bold">Free Test Certificates 🎓</h1>
            <p class="text-sm text-slate-500 mt-1">Kelola template sertifikat untuk setiap jenis Free Test.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    
    @if($errors->any())
        <div class="mb-6 p-4 bg-rose-50 text-rose-600 border border-rose-200 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($certificates as $cert)
        <div class="bg-white shadow-lg rounded-sm border border-slate-200 p-5">
            <h2 class="text-lg font-semibold text-slate-800 mb-4 capitalize">{{ str_replace('_', ' ', $cert->test_type) }}</h2>
            
            <form action="{{ route('admin.free-tests.certificates.update', $cert->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="space-y-4">
                    <!-- Background Image Preview -->
                    <div>
                        <p class="text-sm font-medium text-slate-700 mb-2">Background Saat Ini</p>
                        @if($cert->background_image)
                            <div class="rounded overflow-hidden border border-slate-200 mb-2 h-32 bg-slate-50">
                                <img src="{{ asset('storage/' . $cert->background_image) }}" alt="Certificate Background" class="w-full h-full object-contain">
                            </div>
                        @else
                            <div class="rounded border border-dashed border-slate-300 mb-2 h-32 flex items-center justify-center bg-slate-50">
                                <span class="text-sm text-slate-400">Belum ada template background</span>
                            </div>
                        @endif
                        
                        <input type="file" name="background_image" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100">
                        <p class="text-xs text-slate-500 mt-1">Gunakan gambar resolusi tinggi landscape (misal A4 landscape).</p>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Deskripsi Tambahan (Opsional)</label>
                        <input type="text" name="description" value="{{ $cert->description }}" class="form-input w-full rounded-md border-slate-300">
                    </div>

                    <!-- Text Color -->
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Warna Teks Utama</label>
                        <div class="flex items-center gap-2">
                            <input type="color" name="text_color" value="{{ $cert->text_color }}" class="h-10 w-10 p-1 border border-slate-300 rounded cursor-pointer">
                            <input type="text" value="{{ $cert->text_color }}" class="form-input rounded-md border-slate-300 w-32 text-sm" readonly>
                        </div>
                    </div>

                    <!-- Is Active -->
                    <div class="flex items-center">
                        <input type="checkbox" name="is_active" id="active_{{ $cert->id }}" value="1" {{ $cert->is_active ? 'checked' : '' }} class="rounded border-slate-300 text-indigo-500 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <label for="active_{{ $cert->id }}" class="ml-2 text-sm font-medium text-slate-700">Aktifkan Sertifikat untuk Siswa</label>
                    </div>

                    <div class="pt-4 border-t border-slate-200">
                        <button type="submit" class="btn bg-indigo-500 hover:bg-indigo-600 text-white w-full rounded py-2">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
        @endforeach
    </div>

</div>
@endsection
