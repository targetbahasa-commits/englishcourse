<x-app-layout>
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center max-w-3xl mx-auto mb-12">
        <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Free IELTS Practice Tests</h1>
        <p class="mt-4 text-xl text-gray-500">Get instant AI-powered feedback on your IELTS Writing and Speaking performance. No credit card required.</p>
    </div>

    <div class="mt-12 space-y-16">
        
        <!-- Writing Promos -->
        @if($writingPromos->count() > 0)
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-2">IELTS Writing</h2>
            <div class="grid gap-6 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1">
                @foreach($writingPromos as $promo)
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 transition duration-300 hover:shadow-md flex flex-col h-full">
                    <div class="p-6 flex-grow">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                {{ strtoupper($promo->test_type ?? 'WRITING') }}
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $promo->title }}</h3>
                        <p class="text-sm text-gray-500 line-clamp-3 mb-4">{{ Str::limit(strip_tags($promo->prompt), 150) }}</p>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                        <a href="{{ route('promo.test.show', ['type' => $promo->test_type ?? 'writing_t2', 'id' => $promo->id]) }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            Take Free Test
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Speaking Promos -->
        @if($speakingPromos->count() > 0)
        <div>
            <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-2">IELTS Speaking</h2>
            <div class="grid gap-6 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1">
                @foreach($speakingPromos as $promo)
                <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-100 transition duration-300 hover:shadow-md flex flex-col h-full">
                    <div class="p-6 flex-grow">
                        <div class="flex items-center gap-2 mb-3">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                {{ strtoupper($promo->test_type ?? 'SPEAKING') }}
                            </span>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $promo->title }}</h3>
                    </div>
                    <div class="bg-gray-50 px-6 py-4 border-t border-gray-100">
                        <a href="{{ route('promo.test.show', ['type' => $promo->test_type ?? 'speaking', 'id' => $promo->id]) }}" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-orange-600 hover:bg-orange-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition-colors">
                            Take Free Test
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($writingPromos->count() === 0 && $speakingPromos->count() === 0)
        <div class="text-center py-12 bg-gray-50 rounded-xl border border-gray-200 mt-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No free tests available</h3>
            <p class="mt-1 text-sm text-gray-500">Check back later for new promotional tests.</p>
        </div>
        @endif

    </div>
</div>
</x-app-layout>
