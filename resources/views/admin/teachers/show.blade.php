@extends('layouts.admin')

@section('header')
<div class="flex items-center justify-between">
    <div>
        <div class="flex items-center gap-3 text-sm text-gray-500 mb-2">
            <a href="{{ route('teachers.index') }}" class="hover:text-emerald-600 transition-colors">Teachers</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            <span class="text-gray-900 font-medium">{{ $teacher->name }}</span>
        </div>
        <h2 class="font-bold text-2xl text-gray-800 flex items-center gap-3">
            Teacher Profile
        </h2>
    </div>
    
    <div class="flex items-center gap-3">
        <a href="{{ route('teachers.index') }}" class="px-4 py-2 bg-white border border-gray-200 text-gray-700 font-medium rounded-xl hover:bg-gray-50 shadow-sm transition">
            Back to List
        </a>
        <a href="{{ route('users.edit', $teacher) }}" class="px-4 py-2 bg-emerald-600 text-white font-medium rounded-xl hover:bg-emerald-700 shadow-sm transition flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            Edit Teacher
        </a>
    </div>
</div>
@endsection

@section('content')
<div class="p-8 max-w-7xl mx-auto space-y-8">
    
    <!-- Top Identity Card -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative">
        <div class="h-32 bg-gradient-to-r from-emerald-500 to-teal-600"></div>
        <div class="px-8 pb-8">
            <div class="flex flex-col md:flex-row gap-6 -mt-16 mb-4">
                <!-- Avatar -->
                <div class="relative w-28 h-28 rounded-2xl bg-white p-1.5 shadow-md flex-shrink-0 mx-auto md:mx-0">
                    <div class="w-full h-full rounded-xl bg-gradient-to-br from-emerald-50 to-teal-50 flex items-center justify-center border border-emerald-100 overflow-hidden">
                        @if(isset($teacher) && $teacher->profile_photo)
                            <img src="{{ asset($teacher->profile_photo) }}" alt="{{ $teacher->name }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-4xl font-bold text-emerald-600">{{ strtoupper(substr($teacher->name, 0, 1)) }}</span>
                        @endif
                    </div>
                </div>
                
                <!-- Basic Info -->
                <div class="flex-1 flex flex-col justify-between pt-1">
                    <div class="flex flex-col md:flex-row items-center justify-center md:justify-start gap-3">
                        <h1 class="text-3xl font-bold text-white drop-shadow-sm">{{ $teacher->name }}</h1>
                        @if($teacher->status === 'active')
                            <span class="px-3 py-1 text-xs font-bold bg-emerald-100 text-emerald-800 rounded-lg flex items-center gap-1.5 mt-2 md:mt-0 shadow-sm border border-emerald-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                            </span>
                        @else
                            <span class="px-3 py-1 text-xs font-bold bg-gray-100 text-gray-700 rounded-lg flex items-center gap-1.5 mt-2 md:mt-0 shadow-sm border border-gray-200">
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-500"></span> Inactive
                            </span>
                        @endif
                    </div>
                    <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-sm text-gray-500 mt-6 md:mt-0 pb-1">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            {{ $teacher->email }}
                        </span>
                        @if($teacher->phone_number)
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            +62 {{ $teacher->phone_number }}
                        </span>
                        @endif
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Joined {{ $teacher->created_at->format('M d, Y') }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Stats Grid within Header -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-6 border-t border-gray-100">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Teaching Mode</p>
                    <p class="font-semibold text-gray-900 capitalize">{{ $teacher->learning_mode ?? 'Not Set' }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Active Classes</p>
                    <p class="font-semibold text-gray-900">{{ is_countable($upcomingClasses) ? count($upcomingClasses) : 0 }} Classes</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Private Students</p>
                    <p class="font-semibold text-gray-900">{{ $teacher->students->count() }} Students</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Average Rating</p>
                    <p class="font-semibold text-amber-500 flex items-center gap-1">
                        <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        {{ number_format($averageRating, 1) }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Camp Location</p>
                    <p class="font-semibold text-gray-900">
                        @if($teacher->camp)
                            {{ $teacher->camp->nama_camp }}
                            @if($teacher->campRoom)
                                <span class="text-xs text-gray-500 block">Room: {{ $teacher->campRoom->nama_kamar }}</span>
                            @endif
                        @else
                            <span class="text-gray-400">Tidak tinggal di camp</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Left Column: Workload -->
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Assigned Classes -->
            <div id="classes" class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    Active Classes
                </h3>

                @if(is_countable($upcomingClasses) && count($upcomingClasses) > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($upcomingClasses as $classInfo)
                    <div class="border border-gray-100 rounded-2xl p-4 hover:border-emerald-200 hover:shadow-sm transition-all bg-gray-50/50">
                        <div class="flex items-center justify-between mb-2">
                            <h4 class="font-bold text-gray-900 truncate">{{ $classInfo->name }}</h4>
                            <span class="px-2 py-0.5 text-xs font-medium rounded-md bg-emerald-100 text-emerald-800 border border-emerald-200">{{ ucfirst($classInfo->status) }}</span>
                        </div>
                        <div class="flex items-center gap-4 text-sm text-gray-500">
                            <span class="flex items-center gap-1" title="Students Enrolled">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                {{ $classInfo->students_count }} Students
                            </span>
                            @if($classInfo->schedule_description)
                            <span class="flex items-center gap-1 truncate" title="Schedule">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $classInfo->schedule_description }}
                            </span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8 bg-gray-50 rounded-2xl border border-gray-100 border-dashed">
                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    <p class="text-gray-500 font-medium text-sm">No active classes assigned.</p>
                </div>
                @endif
            </div>
            
            <!-- Private Students -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <h3 class="text-lg font-bold text-gray-900 mb-6 flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                    Private Students
                </h3>

                @if($teacher->students->count() > 0)
                <div class="overflow-x-auto border border-gray-100 rounded-2xl">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Student Name</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Program</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Mode</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($teacher->students as $student)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center text-xs font-bold border border-blue-100">
                                            {{ strtoupper(substr($student->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <a href="{{ route('students.show', $student) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600 transition-colors">{{ $student->name }}</a>
                                            <div class="text-xs text-gray-500">{{ $student->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-700">{{ $student->program ? $student->program->name : 'No Program' }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    <span class="px-2 py-1 text-xs font-medium rounded-md bg-gray-100 text-gray-800 capitalize">{{ $student->learning_mode ?? 'Both' }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-8 bg-gray-50 rounded-2xl border border-gray-100 border-dashed">
                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    <p class="text-gray-500 font-medium text-sm">No private students assigned.</p>
                </div>
                @endif
            </div>

        </div>
        
        <!-- Right Column: Evaluations & Details -->
        <div class="space-y-8">
            
            <!-- Recent Evaluations -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    Recent Evaluations
                </h3>

                <div class="space-y-4">
                    @forelse($evaluations as $evaluation)
                    <div class="p-4 bg-amber-50 rounded-2xl border border-amber-100">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-amber-800">{{ $evaluation->student->name ?? 'Student' }}</span>
                            <div class="flex flex-row-reverse text-amber-400 gap-0.5">
                                @for($i = 0; $i < $evaluation->rating; $i++)
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                @endfor
                            </div>
                        </div>
                        <p class="text-sm text-gray-700 italic">"{{ $evaluation->comment }}"</p>
                        <p class="text-xs text-gray-400 mt-2">{{ $evaluation->created_at->diffForHumans() }}</p>
                    </div>
                    @empty
                    <p class="text-sm text-gray-500 italic">No evaluations received yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Notes or Bio -->
            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-8">
                <h3 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Specialization / Bio
                </h3>
                
                @if($teacher->bio)
                <div class="p-4 bg-indigo-50 rounded-xl border border-indigo-100 text-sm text-indigo-900 whitespace-pre-line">
                    {{ $teacher->bio }}
                </div>
                @else
                <p class="text-sm text-gray-400 italic">No bio or specialization added.</p>
                @endif
            </div>

        </div>
    </div>
</div>
@endsection
