@extends('layouts.admin')

@section('content')
<div class="p-6 md:p-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
    <h1 class="text-3xl font-bold font-serif text-gray-900">
        {{ __('Camp Reviews') }}
    </h1>
</div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        
        <!-- Navigation Tabs -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex gap-4">
            <a href="{{ route('admin.camp-management.index') }}" class="px-4 py-2 text-gray-600 hover:bg-gray-50 font-medium rounded-lg transition">Dashboard</a>
            <a href="{{ route('admin.camps.index') }}" class="px-4 py-2 text-gray-600 hover:bg-gray-50 font-medium rounded-lg transition">Master Camps</a>
            <a href="{{ route('admin.camp-reviews.index') }}" class="px-4 py-2 bg-blue-50 text-blue-700 font-semibold rounded-lg">Camp Reviews</a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-4 rounded-lg">
                <p class="text-green-700">{{ session('success') }}</p>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 border-b border-gray-100 flex flex-col md:flex-row gap-4 justify-between items-center bg-gray-50/50">
                <form action="{{ route('admin.camp-reviews.index') }}" method="GET" class="w-full md:w-1/3">
                    <select name="camp_id" onchange="this.form.submit()" class="block w-full border-gray-200 rounded-lg focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white">
                        <option value="">Semua Camp</option>
                        @foreach($camps as $c)
                            <option value="{{ $c->id }}" {{ request('camp_id') == $c->id ? 'selected' : '' }}>{{ $c->nama_camp }}</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Reviewer</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Camp</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Ratings</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kritik & Saran</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($reviews as $review)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $review->student->name ?? 'User Deleted' }}</div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $review->tanggal_review->format('d M Y') }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ $review->camp->nama_camp ?? 'Camp Deleted' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1 text-sm">
                                        <div class="flex items-center gap-2">
                                            <span class="w-24 text-gray-500">Kebersihan:</span>
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                <span class="ml-1 font-medium">{{ $review->tingkat_kebersihan }}</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <span class="w-24 text-gray-500">Fasilitas:</span>
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                                <span class="ml-1 font-medium">{{ $review->kualitas_fasilitas }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-700 italic border-l-2 border-gray-200 pl-3">
                                        {{ $review->kritik_saran ?: 'Tidak ada komentar.' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form action="{{ route('admin.camp-reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus review ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 transition">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    <p class="text-sm">Belum ada review untuk camp ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if($reviews->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $reviews->links() }}
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
