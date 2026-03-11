@extends('layouts.admin')

@section('title', 'Add Scholarship News')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Add News Article</h1>
            <p class="text-sm text-gray-500 mt-1">This news will appear on the Scholarship Search page sidebar.</p>
        </div>
        <a href="{{ route('admin.scholarship-news.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-1 font-medium text-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to List
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <form action="{{ route('admin.scholarship-news.store') }}" method="POST" class="p-6 sm:p-8">
            @csrf
            <div class="space-y-6">

                {{-- Title --}}
                <div>
                    <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Title <span class="text-red-500">*</span></label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                        placeholder="e.g., LPDP 2026 Registration Now Open">
                    @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Summary --}}
                <div>
                    <label for="summary" class="block text-sm font-semibold text-gray-700 mb-1">Summary <span class="text-gray-400 font-normal">(optional)</span></label>
                    <textarea name="summary" id="summary" rows="3"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                        placeholder="Optional short description of this news...">{{ old('summary') }}</textarea>
                    @error('summary')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- URL --}}
                <div>
                    <label for="url" class="block text-sm font-semibold text-gray-700 mb-1">Link URL <span class="text-gray-400 font-normal">(optional)</span></label>
                    <input type="url" name="url" id="url" value="{{ old('url') }}"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                        placeholder="https://example.com/news-article">
                    @error('url')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Published At --}}
                <div>
                    <label for="published_at" class="block text-sm font-semibold text-gray-700 mb-1">Published At <span class="text-red-500">*</span></label>
                    <input type="datetime-local" name="published_at" id="published_at"
                        value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}" required
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
                    @error('published_at')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Active --}}
                <div class="flex items-center pt-2">
                    <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                        class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
                    <div class="ml-3">
                        <label for="is_active" class="text-sm font-medium text-gray-800 cursor-pointer">Publish & Make Active</label>
                        <p class="text-xs text-gray-500">Uncheck to save as inactive/hidden.</p>
                    </div>
                </div>

            </div>

            <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                <a href="{{ route('admin.scholarship-news.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">Cancel</a>
                <button type="submit" class="inline-flex items-center px-6 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors">Save News Article</button>
            </div>
        </form>
    </div>
</div>
@endsection
