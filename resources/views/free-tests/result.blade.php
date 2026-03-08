@extends('layouts.app')

@section('content')
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        
        <!-- Congratulatory Header -->
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-green-100 text-green-500 rounded-full mb-4 shadow-sm">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h1 class="text-3xl font-extrabold text-gray-900">Simulation Complete!</h1>
            <p class="mt-2 text-lg text-gray-600">Here is your estimated {{ strtoupper(str_replace('_', ' ', $result->test_type)) }} score and analysis.</p>
        </div>

        <div class="space-y-8">
            <!-- Score Card -->
            <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden relative">
                <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-blue-500 to-purple-600"></div>
                <div class="p-8 md:p-12 text-center">
                    <p class="text-sm font-semibold text-gray-500 uppercase tracking-widest mb-2">Estimated Score</p>
                    <div class="text-6xl md:text-8xl font-black text-transparent bg-clip-text bg-gradient-to-br from-gray-900 to-gray-600 mb-6">
                        {{ $result->score + 0 }}
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left mt-8 pt-8 border-t border-gray-100">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                                Key Strengths
                            </h3>
                            <ul class="space-y-2">
                                @forelse($result->evaluation_data['strengths'] ?? [] as $strength)
                                    <li class="flex items-start">
                                        <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        <span class="text-gray-600 text-sm">{{ $strength }}</span>
                                    </li>
                                @empty
                                    <li class="text-gray-400 text-sm italic">Analysis pending...</li>
                                @endforelse
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-gray-900 mb-3 flex items-center gap-2">
                                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                Areas to Improve
                            </h3>
                            <ul class="space-y-2">
                                @forelse($result->evaluation_data['weaknesses'] ?? [] as $weakness)
                                    <li class="flex items-start">
                                        <div class="w-1.5 h-1.5 rounded-full bg-amber-400 mr-2.5 mt-2"></div>
                                        <span class="text-gray-600 text-sm">{{ $weakness }}</span>
                                    </li>
                                @empty
                                    <li class="text-gray-400 text-sm italic">Analysis pending...</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Outreach / Action Item Card -->
            @if($outreachMessage)
                <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-3xl shadow-xl overflow-hidden text-white relative">
                    <div class="absolute top-0 right-0 -mt-10 -mr-10 w-40 h-40 bg-white opacity-10 rounded-full blur-2xl"></div>
                    <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-32 h-32 bg-blue-400 opacity-20 rounded-full blur-xl"></div>
                    
                    <div class="p-8 md:p-10 relative z-10 flex flex-col md:flex-row items-center gap-8">
                        <div class="flex-1">
                            <span class="inline-block px-3 py-1 bg-white/20 rounded-full text-xs font-bold tracking-wider uppercase mb-4 shadow-sm backdrop-blur-sm">
                                Recommendation
                            </span>
                            <h2 class="text-2xl md:text-3xl font-bold mb-4 leading-tight">Next Steps for Your Goal</h2>
                            <p class="text-blue-50 text-base md:text-lg leading-relaxed opacity-90">
                                {{ $outreachMessage->message_content }}
                            </p>
                        </div>
                        <div class="w-full md:w-auto flex-shrink-0">
                            <a href="#" class="block w-full text-center px-8 py-4 bg-white text-blue-700 font-bold rounded-xl shadow-lg hover:shadow-2xl hover:bg-gray-50 hover:scale-105 transition-all duration-300">
                                View Class Details
                            </a>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-white rounded-2xl shadow border border-gray-100 p-8 text-center ring-1 ring-black ring-opacity-5">
                    <p class="text-gray-600 mb-4">You did a great job! Keep practicing to improve your score.</p>
                    <a href="{{ route('dashboard') }}" class="inline-block px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition">Return to Dashboard</a>
                </div>
            @endif
            
            <div class="text-center mt-6">
                <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-800 font-medium transition-colors">← Back to Dashboard</a>
            </div>

        </div>
    </div>
</div>
@endsection
