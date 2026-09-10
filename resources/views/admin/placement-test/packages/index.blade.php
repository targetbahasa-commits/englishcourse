@extends('layouts.admin')

@section('title', 'Tes Kompetensi - Paket')

@section('content')
<div class="p-8">
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">{{ __('Tes Kompetensi') }}</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola paket tes kompetensi. Setiap paket berisi soal Reading, Listening, Writing, dan Speaking sendiri. Hanya 1 paket yang aktif dan dipakai siswa pada satu waktu.</p>
        </div>
        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-package')" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-blue-700 shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Paket Baru
        </button>
    </div>

    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r shadow-sm">{{ session('success') }}</div>
    @endif

    <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
        @if($packages->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                <h3 class="text-lg font-medium text-gray-900">Belum ada paket tes kompetensi</h3>
                <p class="text-gray-500 mt-1 mb-6 max-w-sm">Buat paket pertama untuk mulai menambahkan soal Reading, Listening, Writing, dan Speaking.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Paket</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Reading</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Listening</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Writing</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Speaking</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($packages as $package)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $package->title }}</div>
                                    @if($package->description)
                                        <div class="text-xs text-gray-500 mt-0.5 max-w-xs truncate">{{ $package->description }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">{{ $package->reading_passages_count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">{{ $package->listening_banks_count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">{{ $package->writing_prompts_count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-700">{{ $package->speaking_prompts_count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $state = $package->scheduleState();
                                        $stateBadge = [
                                            'active' => ['label' => 'Active', 'class' => 'bg-green-100 text-green-800'],
                                            'scheduled' => ['label' => 'Scheduled', 'class' => 'bg-blue-100 text-blue-800'],
                                            'expired' => ['label' => 'Expired', 'class' => 'bg-amber-100 text-amber-800'],
                                            'draft' => ['label' => 'Draft', 'class' => 'bg-gray-100 text-gray-600'],
                                        ][$state];
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $stateBadge['class'] }}">{{ $stateBadge['label'] }}</span>
                                    @if($package->active_from || $package->active_until)
                                        <div class="text-xs text-gray-400 mt-1">
                                            {{ $package->active_from?->format('d M Y H:i') ?? '—' }} &rarr; {{ $package->active_until?->format('d M Y H:i') ?? '—' }}
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    @if($package->isActive())
                                        <form action="{{ route('admin.placement-test.packages.deactivate', $package) }}" method="POST" class="inline" onsubmit="return confirm('Nonaktifkan &quot;{{ $package->title }}&quot;? Tidak akan ada paket aktif sampai Anda mengaktifkan paket lain.');">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-amber-500 rounded-md text-amber-700 hover:bg-amber-50 font-medium text-xs">Deactivate</button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.placement-test.packages.activate', $package) }}" method="POST" class="inline" onsubmit="return confirm('Jadikan &quot;{{ $package->title }}&quot; sebagai paket aktif? Paket aktif sebelumnya akan menjadi draft.');">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-green-600 rounded-md text-green-700 hover:bg-green-50 font-medium text-xs">Set Active</button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.placement-test.reading.index', ['package_id' => $package->id]) }}" class="inline-flex items-center px-3 py-1.5 border border-indigo-600 rounded-md text-indigo-600 hover:bg-indigo-50 font-medium text-xs">Kelola Soal</a>
                                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'edit-package-{{ $package->id }}')" class="inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md text-gray-600 hover:bg-gray-50 font-medium text-xs">Edit</button>
                                    <form action="{{ route('admin.placement-test.packages.destroy', $package) }}" method="POST" class="inline" onsubmit="return confirm('Hapus paket ini beserta semua soal di dalamnya?');">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 border border-red-300 rounded-md text-red-600 hover:bg-red-50 font-medium text-xs">Delete</button>
                                    </form>
                                </td>
                            </tr>

                            <x-modal name="edit-package-{{ $package->id }}" focusable>
                                <div class="p-6">
                                    <h2 class="text-lg font-bold text-gray-900 mb-4">Edit Paket</h2>
                                    <form method="POST" action="{{ route('admin.placement-test.packages.update', $package) }}" class="space-y-4">
                                        @csrf @method('PUT')
                                        @include('admin.placement-test.packages._package-fields', ['package' => $package])
                                        <div class="mt-6 flex justify-end gap-3">
                                            <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">Cancel</button>
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </x-modal>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection

@section('modals')
    <x-modal name="create-package" focusable>
        <div class="p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Paket Tes Kompetensi Baru</h2>
            <form method="POST" action="{{ route('admin.placement-test.packages.store') }}" class="space-y-4">
                @csrf
                @include('admin.placement-test.packages._package-fields')
                <p class="text-xs text-gray-500">Paket baru dibuat sebagai draft. Setelah diisi soal, gunakan tombol "Set Active" agar dipakai siswa.</p>
                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">Cancel</button>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">Create Paket</button>
                </div>
            </form>
        </div>
    </x-modal>
@endsection
