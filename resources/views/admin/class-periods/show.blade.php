@extends('layouts.admin')

@section('title', $classPeriod->name . ' - Management')

@section('content')
<div class="p-8">
    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('class-periods.index') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $classPeriod->name }} - Management
            </h2>
        </div>
        <div class="flex space-x-2">
                <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'edit-class-period')" class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-500">
                Edit Details
            </button>
                <form action="{{ route('class-periods.destroy', $classPeriod) }}" method="POST" onsubmit="return confirm('Are you sure? This will delete the class period and unassign all students.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-500">
                    Delete
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div x-data="{ tab: 'overview' }">
        <div>
            
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Tabs Navigation -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-t-lg border-b border-gray-200">
                <nav class="flex -mb-px">
                    <button @click="tab = 'overview'" :class="{'border-indigo-500 text-indigo-600': tab === 'overview', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'overview'}" class="w-1/5 py-4 px-1 text-center border-b-2 font-medium text-sm">
                        Overview
                    </button>
                    <button @click="tab = 'students'" :class="{'border-indigo-500 text-indigo-600': tab === 'students', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'students'}" class="w-1/5 py-4 px-1 text-center border-b-2 font-medium text-sm">
                        Students ({{ $classPeriod->users->count() }})
                    </button>
                    <button @click="tab = 'meetings'" :class="{'border-indigo-500 text-indigo-600': tab === 'meetings', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'meetings'}" class="w-1/5 py-4 px-1 text-center border-b-2 font-medium text-sm">
                        Meetings
                    </button>
                    <button @click="tab = 'groups'" :class="{'border-indigo-500 text-indigo-600': tab === 'groups', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'groups'}" class="w-1/5 py-4 px-1 text-center border-b-2 font-medium text-sm">
                        Kelompok/Pasangan ({{ $studentGroups->count() }})
                    </button>
                    <button @click="tab = 'settings'" :class="{'border-indigo-500 text-indigo-600': tab === 'settings', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'settings'}" class="w-1/5 py-4 px-1 text-center border-b-2 font-medium text-sm">
                        Settings
                    </button>
                </nav>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-b-lg p-6">
                
                <!-- Tab: Overview -->
                <div x-show="tab === 'overview'">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="bg-indigo-50 rounded-lg p-6">
                            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Total Students</h3>
                            <p class="mt-2 text-3xl font-bold text-gray-900">
                                {{ $classPeriod->users->count() }}@if($classPeriod->max_capacity)<span class="text-lg text-gray-500"> / {{ $classPeriod->max_capacity }}</span>@endif
                            </p>
                            @if($classPeriod->max_capacity && $classPeriod->users->count() >= $classPeriod->max_capacity)
                                <p class="mt-1 text-xs font-semibold text-red-600">Batch penuh</p>
                            @endif
                        </div>
                        <div class="bg-indigo-50 rounded-lg p-6">
                            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Program</h3>
                            <p class="mt-2 text-xl font-bold text-gray-900">{{ $classPeriod->program ? $classPeriod->program->name : 'N/A' }}</p>
                        </div>
                        <div class="bg-indigo-50 rounded-lg p-6">
                            <h3 class="text-gray-500 text-sm font-medium uppercase tracking-wider">Status</h3>
                            <div class="mt-2 flex gap-2">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-{{ $classPeriod->status === 'active' ? 'green' : 'gray' }}-100 text-{{ $classPeriod->status === 'active' ? 'green' : 'gray' }}-800">
                                    {{ ucfirst($classPeriod->status) }}
                                </span>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $classPeriod->learning_mode === 'online' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                    {{ ucfirst($classPeriod->learning_mode) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    @if($classPeriod->is_custom)
                        <div class="mt-6 p-5 bg-gradient-to-r from-indigo-50 to-purple-50 border border-indigo-200 rounded-xl space-y-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="px-2.5 py-1 bg-indigo-600 text-white text-xs font-bold rounded-lg uppercase tracking-wider">
                                        {{ $classPeriod->batch_type === 'private' ? 'Kelas Privat (1-on-1)' : 'Kelas Semi-Privat (Maks 4 Siswa)' }}
                                    </span>
                                    <span class="text-xs font-semibold text-indigo-900">
                                        {{ $classPeriod->total_meetings ?: $classPeriod->classMeetings->count() }} Pertemuan Fleksibel
                                    </span>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs text-gray-500">Biaya Kesepakatan:</span>
                                    <span class="ml-1 text-base font-black text-indigo-700">Rp {{ number_format($classPeriod->agreed_price, 0, ',', '.') }}</span>
                                    @if($classPeriod->suggested_price)
                                        <span class="text-xs text-gray-400 block">(Saran sistem: Rp {{ number_format($classPeriod->suggested_price, 0, ',', '.') }})</span>
                                    @endif
                                </div>
                            </div>
                            @if($classPeriod->custom_curriculum_notes)
                                <div class="text-xs text-indigo-900 bg-white/80 p-3 rounded-lg border border-indigo-100">
                                    <strong>Catatan Kurikulum Khusus:</strong> {{ $classPeriod->custom_curriculum_notes }}
                                </div>
                            @endif
                            <a href="{{ route('custom-classes.curriculum', $classPeriod->id) }}"
                               class="inline-flex items-center gap-1.5 px-3.5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-lg transition shadow-sm">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Kelola Kurikulum & Assignment ({{ $classPeriod->classMeetings->count() }} Pertemuan)
                            </a>
                        </div>
                    @endif

                    <div class="mt-8">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Duration</h3>
                                <p class="text-gray-600">
                                    <strong>Start Date:</strong> {{ $classPeriod->start_date ? $classPeriod->start_date->format('F d, Y') : 'Not Set' }}<br>
                                    <strong>End Date:</strong> {{ $classPeriod->end_date ? $classPeriod->end_date->format('F d, Y') : 'Not Set' }}
                                </p>
                            </div>
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Teacher</h3>
                                @if($classPeriod->teacher)
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-base shrink-0">
                                            {{ strtoupper(substr($classPeriod->teacher->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-gray-900">{{ $classPeriod->teacher->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $classPeriod->teacher->email }}</div>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-sm text-orange-600 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Belum ada teacher yang diassign. Edit class period untuk menambahkan.
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab: Students -->
                <div x-show="tab === 'students'" style="display: none;">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Enrolled Students</h3>
                        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-student')" class="px-3 py-1 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-500">
                            + Add Student
                        </button>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach ($classPeriod->users as $student)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $student->name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $student->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <form action="{{ route('class-periods.remove-student', [$classPeriod, $student]) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Remove this student from the class period?')">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                @if($classPeriod->users->isEmpty())
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">No students enrolled yet.</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Students who self-booked via "Booking Class" -->
                    <div class="mt-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-1">Booking Sendiri oleh Student</h3>
                        <p class="text-sm text-gray-500 mb-4">Student yang memilih batch ini sendiri lewat menu "Booking Class". Daftar ini terpisah dari tabel di atas.</p>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Booking</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($bookedEnrollments as $enrollment)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $enrollment->user->name ?? '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $enrollment->user->email ?? '-' }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $enrollment->class_period_booked_at->format('d M Y, H:i') }}</td>
                                        </tr>
                                    @endforeach
                                    @if($bookedEnrollments->isEmpty())
                                        <tr>
                                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">Belum ada student yang booking batch ini secara mandiri.</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Tab: Groups/Pairs -->
                <div x-show="tab === 'groups'" style="display: none;">
                    <div class="flex justify-between mb-4">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Kelompok / Pasangan</h3>
                            <p class="text-sm text-gray-500 mt-1">Kelompokkan student dalam batch ini untuk kebutuhan pairwork/aktivitas kelompok. Pasangan cukup dibuat sebagai kelompok berisi 2 anggota.</p>
                        </div>
                        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-group')" class="px-3 py-1 bg-indigo-600 text-white text-sm rounded hover:bg-indigo-500 shrink-0 h-fit">
                            + Buat Kelompok
                        </button>
                    </div>

                    @if($studentGroups->isEmpty())
                        <div class="px-6 py-4 text-center text-gray-500 bg-gray-50 rounded">Belum ada kelompok/pasangan dibuat.</div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach ($studentGroups as $group)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <h4 class="font-semibold text-gray-900">{{ $group->name }}</h4>
                                            @if($group->meeting)
                                                <span class="inline-block mt-1 px-2 py-0.5 rounded-full bg-purple-50 text-purple-700 text-[10px] font-bold uppercase tracking-wide">
                                                    Meeting {{ $group->meeting->meeting_number }}: {{ $group->meeting->title }}
                                                </span>
                                            @else
                                                <span class="inline-block mt-1 px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 text-[10px] font-bold uppercase tracking-wide">
                                                    Semua Meeting (Batch)
                                                </span>
                                            @endif
                                        </div>
                                        <form action="{{ route('class-periods.groups.destroy', [$classPeriod, $group]) }}" method="POST" onsubmit="return confirm('Hapus kelompok ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 text-xs font-medium shrink-0">Hapus Kelompok</button>
                                        </form>
                                    </div>

                                    <div class="flex flex-wrap gap-2 mb-3">
                                        @forelse ($group->members as $member)
                                            <span class="inline-flex items-center gap-1.5 pl-2.5 pr-1.5 py-1 rounded-full bg-indigo-50 text-indigo-700 text-xs font-medium">
                                                {{ $member->name }}
                                                <form action="{{ route('class-periods.groups.remove-member', [$classPeriod, $group, $member]) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" title="Hapus dari kelompok" class="w-4 h-4 rounded-full bg-indigo-200 hover:bg-indigo-300 text-indigo-700 inline-flex items-center justify-center leading-none">&times;</button>
                                                </form>
                                            </span>
                                        @empty
                                            <span class="text-xs text-gray-400">Belum ada anggota.</span>
                                        @endforelse
                                    </div>

                                    @php
                                        $availableForGroup = $rosterStudents->whereNotIn('id', $group->members->pluck('id'));
                                    @endphp
                                    @if($availableForGroup->isNotEmpty())
                                        <form action="{{ route('class-periods.groups.add-member', [$classPeriod, $group]) }}" method="POST" class="flex gap-2">
                                            @csrf
                                            <select name="user_id" class="text-xs border-gray-300 rounded-md shadow-sm flex-1" required>
                                                <option value="">+ Tambah anggota...</option>
                                                @foreach ($availableForGroup as $student)
                                                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                                                @endforeach
                                            </select>
                                            <button type="submit" class="px-3 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium rounded-md">Tambah</button>
                                        </form>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Tab: Meetings (CORE FEATURE) -->
                <div x-show="tab === 'meetings'" style="display: none;">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-medium text-gray-900">Meeting Access Control</h3>
                        <p class="text-sm text-gray-500">Toggle switch to OPEN/LOCK meetings for this class period.</p>
                    </div>
                    
                    @if($meetings->isEmpty())
                            <p class="text-gray-500 text-center py-4">No meetings found for this program.</p>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach ($meetings as $meeting)
                                <div class="border rounded-lg p-4 {{ $meeting->is_open_for_period ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }}">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="font-bold text-gray-800">Meeting {{ $meeting->meeting_number }}</h4>
                                            <p class="text-sm text-gray-600 truncate w-48" title="{{ $meeting->title }}">{{ $meeting->title }}</p>
                                        </div>
                                        <div class="flex items-center">
                                            <span class="mr-2 text-xs font-bold {{ $meeting->is_open_for_period ? 'text-green-600' : 'text-red-600' }}">
                                                {{ $meeting->is_open_for_period ? 'OPEN' : 'LOCKED' }}
                                            </span>

                                            <!-- Toggle Form - only meaningful for real, catalog-backed
                                                 Meeting models. Custom-class curriculum entries are
                                                 plain stdClass rows built in ManageClassPeriods::show()
                                                 (not Eloquent models), always already is_open_for_period
                                                 = true with no pivot to toggle, so route() has nothing
                                                 valid to bind against and passing $meeting straight into
                                                 it throws "Object of class stdClass could not be
                                                 converted to string". -->
                                            @if(empty($meeting->is_custom_meeting))
                                                <form action="{{ route('class-periods.toggle-meeting', [$classPeriod, $meeting]) }}" method="POST">
                                                    @csrf
                                                    <button type="submit"
                                                        class="relative inline-flex flex-shrink-0 h-6 w-11 border-2 border-transparent rounded-full cursor-pointer transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 {{ $meeting->is_open_for_period ? 'bg-green-600' : 'bg-gray-200' }}"
                                                        role="switch"
                                                        aria-checked="{{ $meeting->is_open_for_period ? 'true' : 'false' }}">
                                                        <span
                                                            class="pointer-events-none inline-block h-5 w-5 rounded-full bg-white shadow transform ring-0 transition duration-200 ease-in-out {{ $meeting->is_open_for_period ? 'translate-x-5' : 'translate-x-0' }}">
                                                        </span>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>

                                    @if(isset($meeting->games) && count($meeting->games) > 1)
                                        <div class="mt-3 pt-3 border-t border-gray-200 space-y-2">
                                            <p class="text-xs font-semibold text-gray-500 uppercase">Game per Subtopik</p>
                                            @foreach ($meeting->games as $i => $game)
                                                @php $isGameOpen = !in_array($i, $meeting->hidden_game_indexes, true); @endphp
                                                <div class="flex items-center justify-between text-sm gap-2">
                                                    <span class="truncate">{{ $game['title'] ?? ('Game ' . ($i + 1)) }}</span>
                                                    <form action="{{ route('class-periods.toggle-game', [$classPeriod, $meeting, $i]) }}" method="POST" class="shrink-0">
                                                        @csrf
                                                        <button type="submit"
                                                            class="relative inline-flex flex-shrink-0 h-5 w-9 border-2 border-transparent rounded-full cursor-pointer transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 {{ $isGameOpen ? 'bg-green-600' : 'bg-gray-300' }}"
                                                            role="switch"
                                                            aria-checked="{{ $isGameOpen ? 'true' : 'false' }}">
                                                            <span class="pointer-events-none inline-block h-4 w-4 rounded-full bg-white shadow transform ring-0 transition duration-200 ease-in-out {{ $isGameOpen ? 'translate-x-4' : 'translate-x-0' }}"></span>
                                                        </button>
                                                    </form>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Tab: Settings (Placeholder) -->
                <div x-show="tab === 'settings'" style="display: none;">
                    <p class="text-gray-500">Additional settings like auto-lock dates can be implemented here.</p>
                        
                        <div class="mt-6 border-t pt-6">
                            <h4 class="font-medium text-gray-900">Danger Zone</h4>
                            <div class="mt-2 text-sm text-gray-500">
                                Deleting this class period will remove the association for all students, but student accounts will remain active.
                            </div>
                        </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('modals')
    <!-- Edit Modal -->
    <x-modal name="edit-class-period" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">Edit Class Period</h2>
            <form method="POST" action="{{ route('class-periods.update', $classPeriod) }}" class="mt-6"
                  x-data="{
                      batchType: @js($classPeriod->batch_type),
                      batchNumber: @js($classPeriod->batch_number),
                      startDate: @js($classPeriod->start_date ? $classPeriod->start_date->format('Y-m-d') : ''),
                      endDate: @js($classPeriod->end_date ? $classPeriod->end_date->format('Y-m-d') : ''),
                      periodName: @js($classPeriod->name),
                      minCapacity: @js($classPeriod->min_capacity ?? (['regular' => 4, 'semi_private' => 2, 'private' => 1][$classPeriod->batch_type] ?? 1)),
                      maxCapacity: @js($classPeriod->max_capacity),
                      minCapacityFloorFor(t) { return { regular: 4, semi_private: 2, private: 1 }[t] || 1; },
                      capacityHint(t) {
                          if (t === 'private') return 'Batch Private selalu 1 orang (tidak bisa diubah).';
                          if (t === 'semi_private') return 'Batch Semi-Private minimal 2 orang.';
                          return 'Batch Reguler minimal 4 orang. Kosongkan untuk tanpa batas maksimum.';
                      },
                      onBatchTypeChange() {
                          const floor = this.minCapacityFloorFor(this.batchType);

                          if (this.batchType === 'private') {
                              this.minCapacity = 1;
                              this.maxCapacity = 1;
                          } else if (!this.minCapacity || Number(this.minCapacity) < floor) {
                              this.minCapacity = floor;
                          }

                          if (this.batchType !== 'private' && this.maxCapacity && Number(this.maxCapacity) < Number(this.minCapacity)) {
                              this.maxCapacity = this.minCapacity;
                          } else if (!this.maxCapacity && this.batchType === 'semi_private') {
                              this.maxCapacity = 2;
                          }
                      },
                      syncName() {
                          if (!this.startDate || !this.endDate) return;
                          const start = new Date(this.startDate + 'T00:00:00');
                          const end   = new Date(this.endDate   + 'T00:00:00');
                          if (Number.isNaN(start.getTime()) || Number.isNaN(end.getTime())) return;
                          const locale     = 'id-ID';
                          const startLabel = start.toLocaleDateString(locale, { day: '2-digit', month: 'short', year: 'numeric' });
                          const endLabel   = end.toLocaleDateString(locale,   { day: '2-digit', month: 'short', year: 'numeric' });
                          const batchStr  = this.batchNumber ? `Batch ${this.batchNumber} - ` : 'Batch ';
                          this.periodName = `${batchStr}${startLabel} to ${endLabel}`;
                      }
                  }">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <x-input-label for="edit_batch_type" value="Tipe Batch" />
                    <select name="batch_type" id="edit_batch_type" x-model="batchType" @change="onBatchTypeChange()" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                        <option value="regular" {{ $classPeriod->batch_type == 'regular' ? 'selected' : '' }}>Reguler (minimal 4 orang)</option>
                        <option value="semi_private" {{ $classPeriod->batch_type == 'semi_private' ? 'selected' : '' }}>Semi-Private (minimal 2 orang)</option>
                        <option value="private" {{ $classPeriod->batch_type == 'private' ? 'selected' : '' }}>Private (1 orang)</option>
                    </select>
                </div>
                <div class="mb-4">
                    <x-input-label for="edit_name" value="Period Name" />
                    <x-text-input id="edit_name" name="name" type="text" class="mt-1 block w-full" x-model="periodName" required />
                </div>
                
                <div class="mb-4">
                    <x-input-label for="edit_program_id" value="Program" />
                    <select name="program_id" id="edit_program_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                        @foreach (\App\Models\Program::all() as $program)
                            <option value="{{ $program->id }}" {{ $classPeriod->program_id == $program->id ? 'selected' : '' }}>{{ $program->name }}{{ !$program->is_active ? ' (Inactive)' : '' }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <x-input-label for="edit_start_date" value="Start Date" />
                        <x-text-input id="edit_start_date" name="start_date" type="date" class="mt-1 block w-full" x-model="startDate" @change="syncName()" />
                    </div>
                    <div>
                        <x-input-label for="edit_end_date" value="End Date" />
                        <x-text-input id="edit_end_date" name="end_date" type="date" class="mt-1 block w-full" x-model="endDate" @change="syncName()" />
                    </div>
                </div>
                
                 <div class="mb-4">
                    <x-input-label for="edit_status" value="Status" />
                    <select name="status" id="edit_status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                        <option value="active" {{ $classPeriod->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="upcoming" {{ $classPeriod->status == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                        <option value="closed" {{ $classPeriod->status == 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <x-input-label for="edit_learning_mode" value="Learning Mode" />
                    <select name="learning_mode" id="edit_learning_mode" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                        <option value="online" {{ $classPeriod->learning_mode == 'online' ? 'selected' : '' }}>Online</option>
                        <option value="offline" {{ $classPeriod->learning_mode == 'offline' ? 'selected' : '' }}>Offline</option>
                    </select>
                </div>

                <div class="mb-4">
                    <x-input-label for="edit_min_capacity" value="Min Capacity" />
                    <x-text-input id="edit_min_capacity" name="min_capacity" type="number"
                                  x-model="minCapacity" x-bind:min="minCapacityFloorFor(batchType)" x-bind:readonly="batchType === 'private'"
                                  class="mt-1 block w-full" required />
                    <p class="text-xs text-gray-500 mt-1">Jumlah siswa minimal agar batch ini bisa dibuka.</p>
                </div>

                <div class="mb-4">
                    <x-input-label for="edit_max_capacity" value="Max Capacity" />
                    <x-text-input id="edit_max_capacity" name="max_capacity" type="number"
                                  x-model="maxCapacity" x-bind:min="minCapacity || minCapacityFloorFor(batchType)" x-bind:readonly="batchType === 'private'"
                                  class="mt-1 block w-full" placeholder="Kosongkan jika tidak dibatasi" />
                    <p class="text-xs text-gray-500 mt-1" x-text="capacityHint(batchType)"></p>
                </div>

                <div class="mb-4">
                    <x-input-label for="edit_teacher_id" value="Teacher (Optional)" />
                    <select name="teacher_id" id="edit_teacher_id"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                        <option value="">— Unassigned —</option>
                        @foreach (\App\Models\User::where('role', 'teacher')->orderBy('name')->get() as $t)
                            <option value="{{ $t->id }}" {{ $classPeriod->teacher_id == $t->id ? 'selected' : '' }}>
                                {{ $t->name }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Pengajar yang mengampu batch ini.</p>
                </div>

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="$dispatch('close')">
                        Cancel
                    </x-secondary-button>

                    <x-primary-button class="ml-3">
                        Save Changes
                    </x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>
    
    <!-- Add Student Modal -->
    <x-modal name="add-student" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">Add Student to {{ $classPeriod->name }}</h2>
            <form method="POST" action="{{ route('class-periods.assign-student', $classPeriod) }}" class="mt-6">
                @csrf
                <div class="mb-4">
                    <x-input-label for="user_id" value="Select Student" />
                    <!-- Ideally this would be a search with Alpine/AJAX, but simple select for now -->
                    <select name="user_id" id="user_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                        <option value="">-- Select Student --</option>
                        @foreach ($allStudents as $student)
                            <option value="{{ $student->id }}">
                                {{ $student->name }} ({{ $student->email }}) 
                                - Mode: {{ ucfirst($student->learning_mode) }}
                                {{ $student->class_period_id ? '- Already in ' . $student->classPeriod['name'] : '' }}
                            </option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Students already in another class will be moved to this one.</p>
                </div>
                
                <div class="mt-6 flex justify-end">
                   <x-secondary-button x-on:click="$dispatch('close')">
                        Cancel
                    </x-secondary-button>

                    <x-primary-button class="ml-3">
                        Add Student
                    </x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>

    <x-modal name="create-group" focusable max-width="2xl">
        <div class="p-6" x-data="{
            activeModalTab: 'auto_pair',
            roster: {{ json_encode($rosterStudents->map(fn($s) => ['id' => $s->id, 'name' => $s->name, 'selected' => true])->values()) }},
            namePrefix: 'Pair',
            oddHandling: 'trio',
            previewPairs: [],

            init() {
                this.generatePreview();
            },

            getSelectedCount() {
                return this.roster.filter(s => s.selected).length;
            },

            toggleAll(val) {
                this.roster.forEach(s => s.selected = val);
                this.generatePreview();
            },

            generatePreview() {
                let selected = this.roster.filter(s => s.selected).map(s => ({ id: s.id, name: s.name }));
                for (let i = selected.length - 1; i > 0; i--) {
                    const j = Math.floor(Math.random() * (i + 1));
                    [selected[i], selected[j]] = [selected[j], selected[i]];
                }
                
                let pairs = [];
                let total = selected.length;
                if (total === 0) {
                    this.previewPairs = [];
                    return;
                }

                for (let i = 0; i < total; i += 2) {
                    pairs.push(selected.slice(i, i + 2));
                }

                if (this.oddHandling === 'trio' && pairs.length > 1 && pairs[pairs.length - 1].length === 1) {
                    let lastSingle = pairs.pop();
                    pairs[pairs.length - 1].push(lastSingle[0]);
                }

                this.previewPairs = pairs;
            }
        }">
            <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-4">
                <div>
                    <h2 class="text-lg font-bold text-gray-900">Kelompok & Pasangan Siswa</h2>
                    <p class="text-xs text-gray-500">Batch: {{ $classPeriod->name }}</p>
                </div>
                <button @click="$dispatch('close')" type="button" class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-500 flex items-center justify-center font-bold">&times;</button>
            </div>

            <!-- Tab Switcher -->
            <div class="flex items-center gap-1.5 p-1 bg-gray-100 rounded-xl mb-5 text-xs font-bold">
                <button @click="activeModalTab = 'auto_pair'" type="button"
                    :class="activeModalTab === 'auto_pair' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-600 hover:text-gray-900'"
                    class="px-3.5 py-1.5 rounded-lg transition flex items-center gap-1">
                    <span>🎲</span> <span>Pasangkan Acak (2 Siswa)</span>
                </button>
                <button @click="activeModalTab = 'manual'" type="button"
                    :class="activeModalTab === 'manual' ? 'bg-white text-indigo-600 shadow-sm' : 'text-gray-600 hover:text-gray-900'"
                    class="px-3.5 py-1.5 rounded-lg transition flex items-center gap-1">
                    <span>➕</span> <span>Buat Manual</span>
                </button>
            </div>

            <!-- TAB 1: AUTO-PAIR -->
            <div x-show="activeModalTab === 'auto_pair'" class="space-y-4">
                <form method="POST" action="{{ route('class-periods.groups.auto-pair', $classPeriod) }}">
                    @csrf
                    
                    <div class="space-y-2 mb-4">
                        <div class="flex items-center justify-between">
                            <label class="text-xs font-bold text-gray-700 uppercase">
                                Pilih Siswa yang Hadir (<span x-text="getSelectedCount()"></span>/{{ $rosterStudents->count() }})
                            </label>
                            <div class="flex items-center gap-2">
                                <button @click="toggleAll(true)" type="button" class="text-xs font-semibold text-indigo-600 hover:underline">Pilih Semua</button>
                                <span class="text-gray-300">•</span>
                                <button @click="toggleAll(false)" type="button" class="text-xs font-semibold text-gray-500 hover:underline">Hapus Pilihan</button>
                            </div>
                        </div>

                        <div class="max-h-44 overflow-y-auto border border-gray-200 rounded-xl p-2 bg-gray-50/50 grid grid-cols-1 sm:grid-cols-2 gap-1.5">
                            <template x-for="(s, idx) in roster" :key="s.id">
                                <label class="flex items-center gap-2 p-2 rounded-lg bg-white border border-gray-200 hover:border-indigo-300 cursor-pointer text-xs font-medium text-gray-800 transition">
                                    <input type="checkbox" :name="'user_ids[]'" :value="s.id" x-model="s.selected" @change="generatePreview()" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <span class="truncate" x-text="s.name"></span>
                                </label>
                            </template>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-3 bg-gray-50 rounded-xl border border-gray-200 mb-4 text-xs">
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Format Penamaan</label>
                            <select name="name_prefix" x-model="namePrefix" class="w-full text-xs border-gray-200 rounded-lg shadow-sm">
                                <option value="Pair">Pair 1, Pair 2, ...</option>
                                <option value="Pasangan">Pasangan 1, Pasangan 2, ...</option>
                                <option value="Kelompok">Kelompok 1, Kelompok 2, ...</option>
                            </select>
                        </div>
                        <div>
                            <label class="font-bold text-gray-700 block mb-1">Jika Siswa Ganjil (Sisa 1)</label>
                            <select name="odd_handling" x-model="oddHandling" @change="generatePreview()" class="w-full text-xs border-gray-200 rounded-lg shadow-sm">
                                <option value="trio">Gabung ke pair terakhir (Trio / 3 orang)</option>
                                <option value="single">Buat kelompok sendiri (1 orang)</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="text-xs font-bold text-gray-700 block mb-1">Berlaku Untuk</label>
                        <select name="meeting_id" class="text-xs border-gray-200 rounded-lg shadow-sm block w-full">
                            <option value="">Semua Meeting (Batch)</option>
                            @foreach ($meetings as $meeting)
                                <option value="{{ $meeting->id }}">Meeting {{ $meeting->meeting_number }}: {{ $meeting->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- PREVIEW -->
                    <div class="p-3 rounded-xl bg-indigo-50/50 border border-indigo-200 mb-4">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-indigo-900">Hasil Acakan Pasangan (<span x-text="previewPairs.length"></span>)</span>
                            <button @click="generatePreview()" type="button" class="px-2 py-0.5 rounded bg-white border border-indigo-200 text-indigo-700 text-xs font-bold hover:bg-indigo-600 hover:text-white transition flex items-center gap-1">
                                <span>🎲</span> <span>Acak Ulang</span>
                            </button>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-40 overflow-y-auto">
                            <template x-for="(pair, pIdx) in previewPairs" :key="pIdx">
                                <div class="p-2 rounded-lg bg-white border border-indigo-100 text-xs font-semibold text-gray-800">
                                    <span class="text-indigo-700 font-bold block text-[11px]" x-text="namePrefix + ' ' + (pIdx + 1)"></span>
                                    <span x-text="pair.map(m => m.name).join(' & ')"></span>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="flex justify-end gap-2">
                        <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                        <x-primary-button x-bind:disabled="getSelectedCount() < 2">Buat Pasangan Acak</x-primary-button>
                    </div>
                </form>
            </div>

            <!-- TAB 2: MANUAL -->
            <div x-show="activeModalTab === 'manual'" class="space-y-4">
                <form method="POST" action="{{ route('class-periods.groups.store', $classPeriod) }}">
                    @csrf
                    <div class="mb-4">
                        <x-input-label for="group_name" value="Nama Kelompok (opsional)" />
                        <x-text-input id="group_name" name="name" type="text" class="mt-1 block w-full text-sm" placeholder="Contoh: Pasangan A, Kelompok 1, dst." />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="group_meeting_id" value="Berlaku Untuk" />
                        <select name="meeting_id" id="group_meeting_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full text-sm">
                            <option value="">Semua Meeting (Batch)</option>
                            @foreach ($meetings as $meeting)
                                <option value="{{ $meeting->id }}">Meeting {{ $meeting->meeting_number }}: {{ $meeting->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <x-input-label value="Pilih Anggota" />
                        <div class="mt-1 max-h-48 overflow-y-auto border border-gray-200 rounded-md divide-y divide-gray-100">
                            @forelse ($rosterStudents as $student)
                                <label class="flex items-center gap-2 px-3 py-2 text-sm hover:bg-gray-50 cursor-pointer">
                                    <input type="checkbox" name="user_ids[]" value="{{ $student->id }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                    <span>{{ $student->name }}</span>
                                </label>
                            @empty
                                <p class="px-3 py-2 text-sm text-gray-500">Belum ada student di batch ini.</p>
                            @endforelse
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end gap-2">
                        <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                        <x-primary-button>Buat Kelompok</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </x-modal>
@endsection
