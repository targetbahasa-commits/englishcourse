@extends('layouts.admin')

@section('title', 'Edit Partner Kerjasama')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-4xl mx-auto">

    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl md:text-3xl text-gray-800 font-bold">Edit Partner: {{ $partner->name }}</h1>
            <p class="text-sm text-gray-500 mt-1">Perbarui data kerjasama instansi ini.</p>
        </div>
        <a href="{{ route('admin.partners.show', $partner) }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-1 font-medium text-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <form action="{{ route('admin.partners.update', $partner) }}" method="POST" class="p-6 sm:p-8">
            @csrf
            @method('PUT')

            @include('admin.partners._form')

            <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.partners.show', $partner) }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">Batal</a>
                <button type="submit" class="inline-flex items-center px-6 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors">Simpan Perubahan</button>
            </div>
        </form>
    </div>

</div>
@endsection
