<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Target Bahasa') }} - Schedule</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-[#F3F4FF]">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('components.sidebar-student')

        <!-- Main Content -->
        <main class="flex-1 md:ml-64 p-8">
            <!-- Topbar -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Class Schedule 📅</h1>
                    <p class="text-gray-500">Jadwal seluruh pertemuan kelas Anda saat ini.</p>
                </div>
                
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">Student</p>
                        </div>
                        <div class="w-10 h-10 bg-blue-100 rounded-full overflow-hidden flex items-center justify-center text-blue-600 font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </div>

            @if(!$hasActivePeriod)
            <!-- Empty State: No Active Class Period -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center max-w-2xl mx-auto mt-12">
                <div class="w-24 h-24 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h2 class="text-2xl font-bold text-gray-800 mb-3">Tidak Ada Jadwal Kelas Aktif</h2>
                <p class="text-gray-500 mb-8">Saat ini Anda belum tergabung dalam batch/periode kelas manapun, sehingga jadwal pertemuan tidak tersedia.</p>
                <a href="{{ route('assignments.index') }}" class="inline-block px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition shadow-sm hover:shadow">
                    Eksplorasi Program
                </a>
            </div>
            @else
            <!-- Schedule Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left Column: Upcoming Classes (Sticky on Desktop) -->
                <div class="lg:col-span-1 border border-gray-100 p-6 rounded-2xl bg-white shadow-sm flex flex-col h-fit sticky top-8">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-xl font-bold text-gray-800 flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-blue-500 animate-pulse"></span>
                            Upcoming
                        </h3>
                        <span class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">{{ $upcomingMeetings->count() }} Kelas</span>
                    </div>

                    <div class="space-y-4">
                        @forelse($upcomingMeetings as $meeting)
                            @php
                                $isToday = \Carbon\Carbon::parse($meeting->meeting_date)->isToday();
                            @endphp
                            <div class="relative p-5 rounded-2xl border {{ $isToday ? 'border-blue-500 bg-blue-50/50 shadow-sm' : 'border-gray-100 hover:border-blue-200 transition bg-white' }}">
                                @if($isToday)
                                    <div class="absolute -top-3 right-4 bg-blue-500 text-white text-[10px] font-black uppercase tracking-wider px-2 py-1 rounded-md shadow-sm">
                                        Hari Ini
                                    </div>
                                @endif
                                
                                <div class="flex gap-4 items-start">
                                    <div class="w-14 h-14 rounded-xl flex flex-col items-center justify-center {{ $isToday ? 'bg-blue-500 text-white' : 'bg-gray-50 text-gray-600' }} flex-shrink-0">
                                        <span class="text-[10px] font-bold uppercase">{{ \Carbon\Carbon::parse($meeting->meeting_date)->format('M') }}</span>
                                        <span class="text-xl font-black leading-none">{{ \Carbon\Carbon::parse($meeting->meeting_date)->format('d') }}</span>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex justify-between items-start mb-1">
                                            <span class="text-xs font-bold text-indigo-600 tracking-wider uppercase">Meeting {{ $meeting->meeting_number }}</span>
                                        </div>
                                        <h4 class="text-base font-bold text-gray-800 mb-2 leading-tight">
                                            {{ $meeting->topic ?? ($meeting->meeting ? $meeting->meeting->title : 'Topik belum ditentukan') }}
                                        </h4>
                                        <div class="flex flex-wrap items-center gap-3 text-xs text-gray-500 mb-4">
                                            <span class="flex items-center gap-1 font-medium bg-gray-100 px-2 py-1 rounded-md">
                                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                {{ $meeting->start_time ? \Carbon\Carbon::parse($meeting->start_time)->format('H:i') : '--:--' }} - {{ $meeting->end_time ? \Carbon\Carbon::parse($meeting->end_time)->format('H:i') : '--:--' }} WIB
                                            </span>
                                        </div>
                                        
                                        @if($meeting->meeting_link)
                                            <a href="{{ $meeting->meeting_link }}" target="_blank" class="w-full flex items-center justify-center gap-2 py-2.5 px-4 {{ $isToday ? 'bg-blue-600 hover:bg-blue-700 text-white shadow-md' : 'bg-white border-2 border-gray-200 hover:border-blue-500 hover:text-blue-600 text-gray-700' }} font-bold text-sm rounded-xl transition">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                                Join Meeting
                                            </a>
                                        @else
                                            <button disabled class="w-full flex items-center justify-center gap-2 py-2.5 px-4 bg-gray-100 text-gray-400 font-bold text-sm rounded-xl cursor-not-allowed border border-transparent">
                                                Link belum tersedia
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-10 px-4 border-2 border-dashed border-gray-200 rounded-2xl">
                                <span class="text-4xl">🌵</span>
                                <h4 class="text-sm font-bold text-gray-700 mt-4 mb-1">Semua Selesai!</h4>
                                <p class="text-xs text-gray-500">Tidak ada jadwal kelas yang akan datang.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Right Column: Past Classes -->
                <div class="lg:col-span-2">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-xl font-bold text-gray-800">Riwayat Kelas (Past/Done)</h3>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-collapse">
                                <thead>
                                    <tr class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider">
                                        <th class="p-4 font-semibold rounded-tl-lg">Pertemuan</th>
                                        <th class="p-4 font-semibold">Topik Pembahasan</th>
                                        <th class="p-4 font-semibold">Tanggal & Waktu</th>
                                        <th class="p-4 font-semibold rounded-tr-lg text-right">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="text-sm divide-y divide-gray-50">
                                    @forelse($pastMeetings as $meeting)
                                        <tr class="hover:bg-gray-50 transition">
                                            <td class="p-4 font-bold text-gray-800">Meeting {{ $meeting->meeting_number }}</td>
                                            <td class="p-4 font-medium text-gray-700">
                                                <div class="line-clamp-2">
                                                    {{ $meeting->topic ?? ($meeting->meeting ? $meeting->meeting->title : 'Topik belum ditentukan') }}
                                                </div>
                                            </td>
                                            <td class="p-4">
                                                <div class="text-gray-800 font-medium">{{ \Carbon\Carbon::parse($meeting->meeting_date)->format('d M Y') }}</div>
                                                <div class="text-xs text-gray-500 mt-0.5">
                                                    {{ $meeting->start_time ? \Carbon\Carbon::parse($meeting->start_time)->format('H:i') : '--:--' }} - {{ $meeting->end_time ? \Carbon\Carbon::parse($meeting->end_time)->format('H:i') : '--:--' }} WIB
                                                </div>
                                            </td>
                                            <td class="p-4 text-right">
                                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-bold bg-green-50 text-green-700 border border-green-100">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                    Selesai
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="p-8 text-center text-gray-400 border-b border-gray-50">
                                                Riwayat pertemuan belum tersedia.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            @endif

        </main>
    </div>
</body>
</html>
