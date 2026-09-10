@extends('layouts.admin')

@section('title', 'Tes Kompetensi - Listening')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">{{ __('Tes Kompetensi') }}</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola bank soal Listening untuk paket <strong>{{ $package->title }}</strong></p>
        </div>
        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-listening-bank')" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-blue-700 shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Bank Baru
        </button>
    </div>

    @include('admin.placement-test._tabs', ['active' => 'listening'])

    <div class="mt-6">
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r shadow-sm">{{ session('success') }}</div>
        @endif

        <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
            @if($banks->isEmpty())
                <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                    <h3 class="text-lg font-medium text-gray-900">Belum ada bank Listening</h3>
                    <p class="text-gray-500 mt-1 mb-6 max-w-sm">Tambahkan audio beserta soal pilihan gandanya.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Level</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Audio</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Questions</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($banks as $bank)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4"><div class="text-sm font-bold text-gray-900">{{ $bank->title }}</div></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-800">{{ $bank->level ?? '—' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($bank->audio_url)
                                            <audio controls src="{{ $bank->audio_url }}" class="h-8 max-w-[200px]"></audio>
                                        @else
                                            <span class="text-gray-400 italic text-xs">Belum ada audio</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">{{ $bank->questions_count }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $bank->status === 'ready' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-600' }}">
                                            {{ ucfirst($bank->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                        <a href="{{ route('admin.placement-test.listening.show', $bank) }}" class="inline-flex items-center px-3 py-1.5 border border-indigo-600 rounded-md text-indigo-600 hover:bg-indigo-50 font-medium text-xs">Manage</a>
                                        <form action="{{ route('admin.placement-test.listening.destroy', $bank) }}" method="POST" class="inline" onsubmit="return confirm('Hapus bank ini beserta semua soalnya?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-red-300 rounded-md text-red-600 hover:bg-red-50 font-medium text-xs">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('modals')
    <x-modal name="create-listening-bank" focusable>
        <div class="p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Listening Bank Baru</h2>
            <form method="POST" action="{{ route('admin.placement-test.listening.store') }}" class="space-y-4" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="placement_test_package_id" value="{{ $package->id }}">
                @include('admin.placement-test.listening._bank-fields')
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">Cancel</button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">Create Bank</button>
                </div>
            </form>
        </div>
    </x-modal>
@endsection
