@extends('layouts.admin')

@section('title', 'WHV Applications Management')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">

    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl md:text-3xl text-gray-800 font-bold">WHV Australia Desk</h1>
            <p class="text-sm text-gray-500 mt-1">Kelola konten program Working Holiday Visa yang ditampilkan sebagai dedicated landing page di area publik.</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('whv-applications.index') }}" target="_blank" class="btn bg-white hover:bg-gray-50 text-gray-700 border border-gray-200 rounded-lg px-4 py-2 inline-flex items-center justify-center transition">
                <svg class="w-4 h-4 shrink-0 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7m0 0v7m0-7L10 14"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h5M5 5v14h14v-5"></path></svg>
                Lihat Halaman Publik
            </a>
            <a href="{{ route('admin.whv-applications.create') }}" class="btn bg-amber-600 hover:bg-amber-700 text-white rounded-lg px-4 py-2 inline-flex items-center justify-center transition">
                <svg class="w-4 h-4 fill-current opacity-50 shrink-0 mr-2" viewBox="0 0 16 16">
                    <path d="M15 7H9V1c0-.6-.4-1-1-1S7 .4 7 1v6H1c-.6 0-1 .4-1 1s.4 1 1 1h6v6c0 .6.4 1 1 1s1-.4 1-1V9h6c.6 0 1-.4 1-1s-.4-1-1-1z"/>
                </svg>
                Add WHV Program
            </a>
        </div>
    </div>

    <div class="mb-6 grid gap-4 lg:grid-cols-[1.1fr_0.9fr]">
        <div class="rounded-2xl border border-amber-100 bg-[linear-gradient(135deg,rgba(255,251,235,1),rgba(255,237,213,0.92))] p-5 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-amber-700/70">Public Framing</p>
            <h2 class="mt-2 text-xl font-bold text-gray-900">WHV tidak lagi tampil sebagai listing kartu</h2>
            <p class="mt-3 text-sm leading-7 text-gray-600">Area publik sekarang memposisikan WHV Australia sebagai satu landing page program. Karena itu, kualitas judul, deskripsi, syarat, biaya, FAQ, dan alur pendaftaran akan langsung memengaruhi persepsi pengguna.</p>
        </div>
        <div class="rounded-2xl border border-gray-200 bg-white p-5 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-gray-400">Current Count</p>
            <div class="mt-2 text-3xl font-black text-gray-900">{{ $applications->total() }}</div>
            <p class="mt-2 text-sm leading-7 text-gray-500">Program tersimpan di database. Idealnya hanya program yang benar-benar siap tayang yang diberi status open dan published.</p>
        </div>
    </div>

    @if(session('success'))
        <div x-data="{ show: true }" x-show="show" class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-700 flex justify-between items-center" x-init="setTimeout(() => show = false, 5000)">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span>{{ session('success') }}</span>
            </div>
            <button @click="show = false" class="text-green-500 hover:text-green-600 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
    @endif

    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Program Title</th>
                        <th class="px-6 py-4 font-semibold">Visa Type & Country</th>
                        <th class="px-6 py-4 font-semibold">Requirements</th>
                        <th class="px-6 py-4 font-semibold">Timeline</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 text-right font-semibold">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($applications as $item)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="font-semibold text-gray-800">{{ $item->title }}</div>
                                @if($item->url)
                                    <a href="{{ $item->url }}" target="_blank" class="text-xs text-blue-500 hover:underline truncate block max-w-xs">{{ $item->url }}</a>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-gray-700">{{ $item->visa_type }}</div>
                                <div class="text-xs text-gray-500">{{ $item->country }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="space-y-1 text-xs text-gray-600">
                                    @if($item->english_requirement && $item->english_requirement !== 'none')
                                        <div>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 uppercase">
                                                {{ str_replace('_', ' ', $item->english_requirement) }}
                                                @if($item->min_score) : {{ $item->min_score }} @endif
                                            </span>
                                        </div>
                                    @endif
                                    @if($item->age_requirement)
                                        <div>Age: {{ $item->age_requirement }}</div>
                                    @endif
                                    @if($item->education_requirement)
                                        <div>Education: {{ $item->education_requirement }}</div>
                                    @endif
                                    @if($item->financial_requirement)
                                        <div>Funds: {{ $item->financial_requirement }}</div>
                                    @endif
                                    @if(!$item->english_requirement && !$item->age_requirement && !$item->education_requirement && !$item->financial_requirement)
                                        <span class="text-xs text-gray-500">No structured requirements yet</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-600">
                                <div>Open: {{ $item->opening_date?->format('d M Y') ?? 'TBA' }}</div>
                                <div>Deadline: {{ $item->application_deadline?->format('d M Y') ?? 'TBA' }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-col gap-2 items-start">
                                    @if($item->status === 'open')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Open</span>
                                    @elseif($item->status === 'closed')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700">Closed</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">Draft</span>
                                    @endif

                                    @if($item->is_active)
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Published</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Hidden</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right whitespace-nowrap">
                                <a href="{{ route('admin.whv-applications.edit', $item) }}" class="text-amber-600 hover:text-amber-900 mx-1 transition font-medium">Edit</a>
                                <form action="{{ route('admin.whv-applications.destroy', $item) }}" method="POST" class="inline-block" onsubmit="return confirm('Delete this WHV program?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 transition font-medium">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                <div class="flex flex-col items-center">
                                    <svg class="w-10 h-10 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2.5 2.5 0 00-2.5-2.5H15"></path></svg>
                                    No WHV programs found. Add the first program and build the public WHV landing page from there.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($applications->hasPages())
        <div class="mt-6">
            {{ $applications->links() }}
        </div>
    @endif

</div>
@endsection
