@extends('layouts.admin')

@section('content')
@php
    $selectedPractice = (int) request()->get('practice', 0);
    $surnameColumns = [
        ['Anderson', 'Campbell', 'Edwards', 'Granger', 'Johnson', 'Marshall', 'Reed', 'Taylor'],
        ['Andrews', 'Collins', 'Evans', 'Green', 'Jones', 'Oliver', 'Robinson', 'Turner'],
        ['Brown', 'Davis', 'Fisher', 'Harris', 'King', 'Palmer', 'Stevens', 'Watson'],
        ['Black', 'Dawson', 'Ford', 'Hill', 'Lewis', 'Patterson', 'Smith', 'Williams'],
    ];
@endphp
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

            @if($selectedPractice === 0)
                <div class="px-6 md:px-12 py-10">
                    <div class="mb-8 text-center">
                        <span class="px-4 py-1.5 rounded-lg text-sm font-bold bg-orange-500 text-white uppercase tracking-wider shadow-lg shadow-orange-500/30">Names Warm-Up</span>
                        <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-slate-900 mt-4 mb-3">
                            Choose Practice
                        </h1>
                        <p class="text-slate-600 text-base md:text-lg max-w-2xl mx-auto leading-relaxed">
                            Pilih latihan yang ingin kamu kerjakan untuk topik names.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <a href="{{ route('assignments.ielts-academic.listening.warmup', 'names') }}?practice=1" class="group relative overflow-hidden rounded-2xl border border-orange-200 bg-gradient-to-br from-orange-50 to-amber-50 p-6 hover:shadow-xl transition-all duration-300">
                            <div class="absolute right-0 top-0 -mt-8 -mr-8 w-24 h-24 rounded-full bg-orange-200/40 blur-2xl"></div>
                            <div class="relative z-10">
                                <div class="inline-flex items-center px-3 py-1 rounded-full bg-orange-500 text-white text-xs font-bold tracking-wider uppercase mb-3">Practice 1</div>
                                <h3 class="text-xl font-bold text-slate-900 mb-2">Names Dictation</h3>
                                <p class="text-slate-600 text-sm">Write down the names you hear. Each name is spelled two times.</p>
                            </div>
                        </a>

                        <a href="{{ route('assignments.ielts-academic.listening.warmup', 'names') }}?practice=2" class="group relative overflow-hidden rounded-2xl border border-emerald-200 bg-gradient-to-br from-emerald-50 to-lime-50 p-6 hover:shadow-xl transition-all duration-300">
                            <div class="absolute right-0 top-0 -mt-8 -mr-8 w-24 h-24 rounded-full bg-emerald-200/40 blur-2xl"></div>
                            <div class="relative z-10">
                                <div class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-500 text-white text-xs font-bold tracking-wider uppercase mb-3">Practice 2</div>
                                <h3 class="text-xl font-bold text-slate-900 mb-2">Common Surnames</h3>
                                <p class="text-slate-600 text-sm">Tick the surnames you hear. You will not hear all the names in the box.</p>
                            </div>
                        </a>

                    </div>
                </div>
            @elseif($selectedPractice === 1)
                {{-- Header Info --}}
                <div class="px-6 md:px-12 pt-10 pb-4">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="px-4 py-1.5 rounded-lg text-sm font-bold bg-orange-500 text-white uppercase tracking-wider shadow-lg shadow-orange-500/30">Exercise 1.05</span>
                        <span class="text-slate-400 text-sm font-medium">Practice 1</span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-slate-900 mb-3">
                        Names
                        <span class="block h-1 w-32 bg-orange-500 rounded-full mt-3"></span>
                    </h1>
                    <p class="text-slate-600 text-base md:text-lg max-w-2xl leading-relaxed mb-4">
                        In the spaces provided, write down the names you hear. Each will be spelled out <span class="text-amber-600 font-bold">two times</span>.
                    </p>
                    <p class="text-slate-500 text-sm italic">
                        <span class="font-semibold">E.g.</span> Brian Singer, Kowalski
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
                    <a href="{{ route('assignments.ielts-academic.listening.warmup', 'names') }}" class="text-slate-400 hover:text-slate-600 text-base font-medium transition-colors">
                        Back to Practice Cards
                    </a>
                    <button type="button" class="px-8 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-lg shadow-lg shadow-orange-500/30 text-base font-bold tracking-wide transition-all transform hover:-translate-y-0.5 hover:shadow-xl">
                        Submit Answers
                    </button>
                </div>
            @elseif($selectedPractice === 2)
                {{-- Header Info --}}
                <div class="px-6 md:px-12 pt-10 pb-4">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="px-4 py-1.5 rounded-lg text-sm font-bold bg-emerald-500 text-white uppercase tracking-wider shadow-lg shadow-emerald-500/30">Exercise 1.05B</span>
                        <span class="text-slate-400 text-sm font-medium">Practice 2</span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold tracking-tight text-slate-900 mb-3">
                        Common English Surnames
                        <span class="block h-1 w-40 bg-emerald-500 rounded-full mt-3"></span>
                    </h1>
                    <p class="text-slate-600 text-base md:text-lg max-w-3xl leading-relaxed mb-4 italic">
                        Pay attention to how these common English surnames sound.
                    </p>
                    <p class="text-slate-600 text-base md:text-lg max-w-3xl leading-relaxed">
                        Tick the surnames you hear. You will not hear all the names in the box.
                    </p>
                </div>

                {{-- Content Area --}}
                <div class="p-6 md:px-10 md:pb-10 bg-white min-h-[400px]">
                    <form>
                        <div class="rounded-2xl border border-lime-200 overflow-hidden shadow-sm">
                            <div class="grid grid-cols-1 md:grid-cols-4">
                                @foreach($surnameColumns as $colIndex => $names)
                                    <div class="{{ $colIndex < 3 ? 'md:border-r' : '' }} border-lime-200">
                                        @foreach($names as $rowIndex => $surname)
                                            <label class="h-14 px-4 flex items-center justify-between cursor-pointer {{ $rowIndex < 7 ? 'border-b' : '' }} border-lime-200 bg-lime-100/70 hover:bg-lime-100 transition-colors">
                                                <span class="text-slate-700 font-semibold">{{ $surname }}</span>
                                                <input type="checkbox" name="surname_{{ strtolower($surname) }}" class="w-5 h-5 rounded border-slate-300 text-emerald-600 focus:ring-emerald-500">
                                            </label>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Footer / Actions --}}
                <div class="bg-white border-t border-slate-100 p-6 md:px-12 md:py-8 flex justify-between items-center">
                    <a href="{{ route('assignments.ielts-academic.listening.warmup', 'names') }}" class="text-slate-400 hover:text-slate-600 text-base font-medium transition-colors">
                        Back to Practice Cards
                    </a>
                    <button type="button" class="px-8 py-3 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg shadow-lg shadow-emerald-500/30 text-base font-bold tracking-wide transition-all transform hover:-translate-y-0.5 hover:shadow-xl">
                        Submit Answers
                    </button>
                </div>
            @else
                <div class="px-6 md:px-12 py-10 text-center">
                    <h2 class="text-2xl font-bold text-slate-900 mb-3">Practice Not Found</h2>
                    <p class="text-slate-600 mb-5">Silakan pilih practice yang tersedia.</p>
                    <a href="{{ route('assignments.ielts-academic.listening.warmup', 'names') }}" class="inline-flex items-center px-5 py-2.5 bg-orange-500 hover:bg-orange-600 text-white font-semibold rounded-lg transition-colors">Back to Practice Cards</a>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- Audio Player --}}
@include('assignments.ielts.listening.partials.audio-player')

@endsection
