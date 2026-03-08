<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SchoolHub') }} - Grammar for Writing</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F3F4FF]">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        @if(Auth::user()->isAdmin())
            @include('components.sidebar-admin')
        @elseif(Auth::user()->isTeacher())
            @include('components.sidebar-teacher')
        @else
            @include('components.sidebar-student')
        @endif

        <!-- Main Content -->
        <main class="flex-1 md:ml-64 p-8">
            <!-- Topbar -->
            <div class="flex justify-between items-center mb-8">
                <div class="relative w-96">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" class="w-full py-3 pl-10 pr-4 bg-white rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 shadow-sm" placeholder="Search">
                </div>
                
                <div class="flex items-center gap-6">
                    <button class="relative p-2 bg-white rounded-full shadow-sm hover:bg-gray-50">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                    </button>
                    <button class="relative p-2 bg-white rounded-full shadow-sm hover:bg-gray-50">
                        <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <span class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-full border-2 border-white"></span>
                    </button>
                    
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">{{ ucfirst(Auth::user()->role) }}</p>
                        </div>
                        <div class="w-10 h-10 bg-purple-200 rounded-full overflow-hidden">
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}&background=random" alt="User" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Header & Period -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Grammar for Writing</h2>
                    <p class="text-gray-500 text-sm">Manage meetings and class period.</p>
                </div>
                <div class="flex items-center gap-3">
                    <form action="{{ route('assignments.grammar-writing.period') }}" method="POST" class="flex items-center gap-2 bg-white p-2 rounded-xl shadow-sm">
                        @csrf
                        <span class="text-sm font-semibold text-gray-600 pl-2">Class Period:</span>
                        <input type="text" name="period" value="{{ $program->period }}" class="border-none bg-gray-50 rounded-lg text-sm focus:ring-2 focus:ring-blue-500" placeholder="e.g. September 2024">
                        <button type="submit" class="p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                    </form>
                    
                    <a href="{{ route('assignments.index') }}" class="px-4 py-2 bg-white text-gray-600 rounded-xl shadow-sm hover:bg-gray-50 font-medium transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        Back
                    </a>
                </div>
            </div>

            <!-- Meetings Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                @foreach($program->meetings as $meeting)
                <div class="bg-white p-6 rounded-3xl shadow-sm hover:shadow-md transition group relative">
                    <div class="flex justify-between items-start mb-4">
                        <span class="px-3 py-1 {{ $meeting->is_locked ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600' }} rounded-full text-xs font-bold">
                            {{ $meeting->is_locked ? 'LOCKED' : 'OPEN' }}
                        </span>
                        @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
                        <form action="{{ route('assignments.meeting.toggle-lock', $meeting) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-gray-400 hover:text-gray-600 transition" title="Toggle Lock">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($meeting->is_locked)
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                                    @endif
                                </svg>
                            </button>
                        </form>
                        @endif
                    </div>
                    
                    @if(isset($scores[$meeting->meeting_number]))
                        @php
                            $score = $scores[$meeting->meeting_number];
                            $scoreRounded = round($score / 10, 1);
                            
                            // Determine icon based on score range
                            if ($scoreRounded == 10) {
                                $icon = '💎';
                                $badge = 'Diamond';
                            } elseif ($scoreRounded >= 9.5) {
                                $icon = '👑';
                                $badge = 'Crown';
                            } elseif ($scoreRounded >= 9.0) {
                                $icon = '🥇';
                                $badge = 'Platinum';
                            } elseif ($scoreRounded >= 8.0) {
                                $icon = '🏆';
                                $badge = 'Gold';
                            } elseif ($scoreRounded >= 7.0) {
                                $icon = '🥈';
                                $badge = 'Silver';
                            } elseif ($scoreRounded >= 6.0) {
                                $icon = '⭐';
                                $badge = 'Score 6';
                            } elseif ($scoreRounded >= 5.0) {
                                $icon = '🌟';
                                $badge = 'Score 5';
                            } elseif ($scoreRounded >= 4.0) {
                                $icon = '💫';
                                $badge = 'Score 4';
                            } elseif ($scoreRounded >= 3.0) {
                                $icon = '🌠';
                                $badge = 'Score 3';
                            } elseif ($scoreRounded >= 2.0) {
                                $icon = '✨';
                                $badge = 'Score 2';
                            } elseif ($scoreRounded >= 1.0) {
                                $icon = '🎖️';
                                $badge = 'Score 1';
                            } else {
                                $icon = '⭕';
                                $badge = 'Empty';
                            }
                        @endphp
                        
                        <!-- Score Icon and Value -->
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-24 h-24 bg-gradient-to-br from-blue-50 to-purple-50 rounded-2xl flex items-center justify-center border-2 border-blue-100 shadow-sm">
                            <span class="text-5xl">{{ $icon }}</span>
                        </div>
                            <span class="text-3xl font-bold text-gray-800">{{ number_format($score, 1) }}</span>
                        </div>
                    @else
                        <!-- Default Document Icon when no score -->
                        <div class="w-12 h-12 {{ $meeting->is_locked ? 'bg-gray-100 text-gray-400' : 'bg-blue-100 text-blue-600' }} rounded-2xl flex items-center justify-center mb-4 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                    @endif
                    
                    <h3 class="text-xl font-bold text-gray-800 mb-1">{{ $meeting->title }}</h3>
                    <p class="text-gray-500 text-sm mb-4">
                        {{ $meetingTopics[$meeting->meeting_number] ?? 'Grammar Exercises' }}
                    </p>
                    
                    @if(!$meeting->is_locked)
                        @if($meeting->meeting_number == 1)
                            <a href="{{ route('assignments.grammar-writing.meeting1') }}" class="block w-full py-2 bg-blue-600 text-white text-center rounded-xl font-bold hover:bg-blue-700 transition">Start</a>
                        @elseif($meeting->meeting_number == 2)
                            <a href="{{ route('assignments.grammar-writing.meeting2') }}" class="block w-full py-2 bg-blue-600 text-white text-center rounded-xl font-bold hover:bg-blue-700 transition">Start</a>
                        @elseif($meeting->meeting_number == 3)
                            <a href="{{ route('assignments.grammar-writing.meeting3') }}" class="block w-full py-2 bg-blue-600 text-white text-center rounded-xl font-bold hover:bg-blue-700 transition">Start</a>
                        @elseif($meeting->meeting_number == 4)
                            <a href="{{ route('assignments.grammar-writing.meeting4') }}" class="block w-full py-2 bg-blue-600 text-white text-center rounded-xl font-bold hover:bg-blue-700 transition">Start</a>
                        @elseif($meeting->meeting_number == 5)
                            <a href="{{ route('assignments.grammar-writing.meeting5') }}" class="block w-full py-2 bg-blue-600 text-white text-center rounded-xl font-bold hover:bg-blue-700 transition">Start</a>
                        @elseif($meeting->meeting_number == 6)
                            <a href="{{ route('assignments.grammar-writing.meeting6') }}" class="block w-full py-2 bg-blue-600 text-white text-center rounded-xl font-bold hover:bg-blue-700 transition">Start</a>
                        @elseif($meeting->meeting_number == 7)
                            <a href="{{ route('assignments.grammar-writing.meeting7') }}" class="block w-full py-2 bg-blue-600 text-white text-center rounded-xl font-bold hover:bg-blue-700 transition">Start</a>
                        @elseif($meeting->meeting_number == 8)
                            <a href="{{ route('assignments.grammar-writing.meeting8') }}" class="block w-full py-2 bg-blue-600 text-white text-center rounded-xl font-bold hover:bg-blue-700 transition">Start</a>
                        @else
                            <a href="#" class="block w-full py-2 bg-gray-400 text-white text-center rounded-xl font-bold hover:bg-gray-500 transition cursor-not-allowed">Start</a>
                        @endif
                    @else
                        <button disabled class="block w-full py-2 bg-gray-100 text-gray-400 text-center rounded-xl font-bold cursor-not-allowed">Locked</button>
                    @endif
                </div>
                @endforeach
            </div>
        </main>
    </div>
</body>
</html>
