<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Evaluations') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Overall Stats Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-blue-50 p-6 rounded-xl border border-blue-100 flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-blue-900 mb-1">Average Rating</h3>
                                <p class="text-sm text-blue-700">Based on student feedback</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-4xl font-bold text-amber-500">{{ number_format($averageRating, 1) }}</span>
                                <span class="text-2xl text-amber-400">★</span>
                            </div>
                        </div>
                        
                        <div class="bg-indigo-50 p-6 rounded-xl border border-indigo-100 flex items-center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold text-indigo-900 mb-1">Total Evaluations</h3>
                                <p class="text-sm text-indigo-700">Number of reviews received</p>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-4xl font-bold text-indigo-600">{{ $totalEvaluations }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Evaluations List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-bold mb-6 pb-2 border-b border-gray-100">Recent Student Reviews</h3>
                    
                    @if($evaluations->count() > 0)
                        <div class="space-y-6">
                            @foreach($evaluations as $evaluation)
                                <div class="bg-white border text-gray-800 border-gray-200 rounded-xl p-6 hover:shadow-md transition duration-200">
                                    <div class="flex justify-between items-start flex-wrap gap-4 mb-4">
                                        <div class="flex items-center gap-3">
                                            @if($evaluation->student->profile_photo)
                                                <img src="{{ Storage::url($evaluation->student->profile_photo) }}" alt="Profile" class="h-10 w-10 rounded-full object-cover border border-gray-200">
                                            @else
                                                <div class="h-10 w-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold">
                                                    {{ substr($evaluation->student->name, 0, 1) }}
                                                </div>
                                            @endif
                                            <div>
                                                <h4 class="font-semibold text-gray-900">{{ $evaluation->student->name }}</h4>
                                                <p class="text-xs text-gray-500">{{ $evaluation->created_at->format('M d, Y') }} ({{ $evaluation->created_at->diffForHumans() }})</p>
                                            </div>
                                        </div>
                                        <div class="flex text-amber-400 text-lg" title="{{ $evaluation->rating }} out of 5 stars">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $evaluation->rating)
                                                    ★
                                                @else
                                                    <span class="text-gray-200">★</span>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                    
                                    @if($evaluation->comment)
                                        <div class="bg-gray-50 p-4 rounded-lg text-gray-700 italic border-l-4 border-indigo-300">
                                            "{{ $evaluation->comment }}"
                                        </div>
                                    @else
                                        <p class="text-gray-400 italic text-sm">No additional comments provided.</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $evaluations->links() }}
                        </div>
                    @else
                        <div class="text-center py-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            <p class="text-xl font-medium text-gray-500 mb-1">No evaluations yet</p>
                            <p class="text-gray-400">Student reviews will appear here once they evaluate your classes.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
