@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 relative overflow-hidden py-8 font-sans">
    {{-- Background Decoration --}}
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
        <div class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] rounded-full bg-indigo-200/40 blur-3xl"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[600px] h-[600px] rounded-full bg-purple-200/30 blur-3xl"></div>
        <div class="absolute top-[20%] left-[20%] w-[300px] h-[300px] rounded-full bg-white blur-2xl"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10 max-w-5xl">
        {{-- Navigation --}}
        <div class="mb-8 flex items-center justify-between">
            <a href="{{ route('assignments.ielts-academic.listening.index') }}" 
               class="inline-flex items-center text-gray-500 hover:text-indigo-600 transition-colors group text-sm font-medium tracking-wide">
                <div class="w-8 h-8 rounded-full bg-white flex items-center justify-center mr-3 group-hover:bg-white transition-all">
                    <svg class="w-4 h-4 transform group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </div>
                <span>Back to Skills</span>
            </a>
            <div class="text-gray-500 text-xs font-bold tracking-widest uppercase">IELTS Listening • Warm Up</div>
        </div>

        {{-- Main Interface Card --}}
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden border border-slate-800/10 ring-1 ring-white/10">
            
            {{-- Header Info --}}
             <div class="px-6 md:px-12 pt-10 pb-4">
                <div class="flex items-center gap-3 mb-3">
                    <span class="px-4 py-1.5 rounded-lg text-sm font-bold bg-orange-500 text-white uppercase tracking-wider shadow-lg shadow-orange-500/30">Exercise 1.04</span>
                    <span class="text-slate-400 text-sm font-medium">Part 1</span>
                </div>
                <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-slate-900 mb-3">
                    Numbers
                    <span class="block h-1 w-32 bg-orange-500 rounded-full mt-3"></span>
                </h1>
                <p class="text-slate-600 text-base md:text-lg max-w-2xl leading-relaxed mb-4">
                    In the spaces provided, write down the numbers (and letters) you hear. Each will be read <span class="text-amber-600 font-bold">two times</span>.
                </p>
                <p class="text-slate-500 text-sm italic">
                    <span class="font-semibold">E.g.</span> 86171050, DB 764
                </p>
            </div>

            {{-- Content Area --}}
            <div class="p-6 md:px-10 md:pb-10 bg-white min-h-[400px]">
                <form>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 md:gap-7">
                        @for($i = 1; $i <= 12; $i++)
                        @php
                            $colors = [
                                ['bg' => 'bg-white', 'text' => 'text-orange-600', 'border' => 'border-orange-300', 'ring' => 'ring-orange-500/10', 'focus' => 'focus:border-orange-500'],
                                ['bg' => 'bg-white', 'text' => 'text-indigo-600', 'border' => 'border-indigo-300', 'ring' => 'ring-indigo-500/10', 'focus' => 'focus:border-indigo-500'],
                                ['bg' => 'bg-pink-100', 'text' => 'text-pink-600', 'border' => 'border-pink-300', 'ring' => 'ring-pink-500/10', 'focus' => 'focus:border-pink-500'],
                                ['bg' => 'bg-white', 'text' => 'text-teal-600', 'border' => 'border-teal-300', 'ring' => 'ring-teal-500/10', 'focus' => 'focus:border-teal-500'],
                            ];
                            $color = $colors[($i - 1) % 4];
                        @endphp
                        <div class="group">
                            <div class="mb-2 inline-block {{ $color['bg'] }} px-2.5 py-1 rounded-lg border {{ $color['border'] }} shadow-sm text-sm font-bold {{ $color['text'] }} transition-all group-focus-within:scale-110">
                                {{ $i }}
                            </div>
                            <input type="text" name="q{{ $i }}" 
                                   class="w-full h-16 pl-5 pr-5 bg-white border-2 border-slate-200 rounded-xl text-slate-800 text-lg font-semibold focus:outline-none focus:ring-4 {{ $color['ring'] }} {{ $color['focus'] }} transition-all placeholder-slate-400 shadow-sm hover:border-slate-300 hover:shadow-md" 
                                   placeholder="Type answer..." 
                                   autocomplete="off">
                        </div>
                        @endfor
                    </div>
                </form>
            </div>
            
            {{-- Footer / Actions --}}
            <div class="bg-white border-t border-slate-100 p-6 md:px-12 md:py-8 flex justify-between items-center">
                <button type="button" class="text-slate-400 hover:text-slate-600 text-base font-medium transition-colors">
                    Reset Form
                </button>
                <button type="button" class="px-8 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-lg shadow-lg shadow-orange-500/30 text-base font-bold tracking-wide transition-all transform hover:-translate-y-0.5 hover:shadow-xl">
                    Submit Answers
                </button>
            </div>
            
        </div>
    </div>
</div>

{{-- Audio Player --}}
@include('assignments.ielts.listening.partials.audio-player')

@endsection
