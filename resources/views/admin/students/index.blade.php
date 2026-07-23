@extends('layouts.admin')

@section('header')
<div class="flex items-center justify-between">
    <div>
        <h2 class="font-bold text-2xl text-gray-800 flex items-center gap-3">
            <span class="p-2 bg-blue-100 text-blue-600 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222"></path></svg>
            </span>
            Student Management
        </h2>
        <p class="text-sm text-gray-500 mt-1">Monitor academic progress, manage contacts, and track referral codes.</p>
    </div>
</div>
@endsection

@section('content')
<div class="p-8 pb-24 max-w-7xl mx-auto" x-data="{
    showAssignModal: false,
    showQuickEditModal: false,
    selectedStudentId: null,
    selectedStudentName: '',
    selectedStudentPhone: '',
    selectedStudentReferral: '',
    openQuickEdit(id, name, phone, referral) {
        this.selectedStudentId = id;
        this.selectedStudentName = name;
        this.selectedStudentPhone = phone || '';
        this.selectedStudentReferral = referral || '';
        this.showQuickEditModal = true;
    }
}">

    <!-- Top Stats Cards -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <!-- Total Students -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 relative overflow-hidden group hover:shadow-md transition-shadow flex items-center gap-4">
            <div class="p-3 bg-indigo-50 text-indigo-600 rounded-xl shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 mb-0.5">Total Students</p>
                <h3 class="text-xl font-bold text-gray-900">{{ $metrics['total_students'] }}</h3>
            </div>
        </div>

        <!-- Active -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-4 group hover:shadow-md transition-shadow flex items-center gap-4">
            <div class="p-3 bg-emerald-50 text-emerald-600 rounded-xl shrink-0">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-semibold text-gray-500 mb-0.5">Active Accounts</p>
                <h3 class="text-xl font-bold text-gray-900">{{ $metrics['active_students'] }}</h3>
            </div>
        </div>

        <!-- Missing WA -->
        <a href="{{ route('students.index', array_merge(request()->query(), ['missing' => 'whatsapp'])) }}"
           class="bg-white rounded-xl border {{ $metrics['missing_wa'] > 0 ? 'border-amber-200' : 'border-gray-100' }} shadow-sm p-4 group hover:shadow-md transition-shadow flex items-center justify-between gap-2">
            <div class="flex items-center gap-4">
                <div class="p-3 {{ $metrics['missing_wa'] > 0 ? 'bg-amber-50 text-amber-600' : 'bg-gray-50 text-gray-400' }} rounded-xl shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 mb-0.5">No WhatsApp</p>
                    <h3 class="text-xl font-bold {{ $metrics['missing_wa'] > 0 ? 'text-amber-600' : 'text-gray-900' }}">{{ $metrics['missing_wa'] }}</h3>
                </div>
            </div>
            @if($metrics['missing_wa'] > 0)
                <span class="text-[9px] font-bold uppercase tracking-wide text-amber-500 bg-amber-50 px-2 py-1 rounded hidden md:block">Filter</span>
            @endif
        </a>

        <!-- Missing Referral -->
        <a href="{{ route('students.index', array_merge(request()->query(), ['missing' => 'referral'])) }}"
           class="bg-white rounded-xl border {{ $metrics['missing_referral'] > 0 ? 'border-red-200' : 'border-gray-100' }} shadow-sm p-4 group hover:shadow-md transition-shadow flex items-center justify-between gap-2">
            <div class="flex items-center gap-4">
                <div class="p-3 {{ $metrics['missing_referral'] > 0 ? 'bg-red-50 text-red-500' : 'bg-gray-50 text-gray-400' }} rounded-xl shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 mb-0.5">No Referral</p>
                    <h3 class="text-xl font-bold {{ $metrics['missing_referral'] > 0 ? 'text-red-600' : 'text-gray-900' }}">{{ $metrics['missing_referral'] }}</h3>
                </div>
            </div>
            @if($metrics['missing_referral'] > 0)
                <span class="text-[9px] font-bold uppercase tracking-wide text-red-500 bg-red-50 px-2 py-1 rounded hidden md:block">Filter</span>
            @endif
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl relative flex items-center gap-3">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="mb-6 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl relative flex items-center gap-3">
        <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <span>{{ session('error') }}</span>
    </div>
    @endif

    <!-- Main Content Box -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        <!-- Filters & Search Bar -->
        <!-- Filters & Search Bar -->
        <div class="p-6 border-b border-gray-100 bg-gray-50/50" x-data="{ showAdvanced: {{ request()->hasAny(['program_id', 'class_period_id', 'month_year']) ? 'true' : 'false' }} }">
            <form action="{{ route('students.index') }}" method="GET">
                <div class="flex flex-col md:flex-row gap-3 flex-wrap items-end">
                    <!-- Search -->
                    <div class="flex-1 min-w-[200px] w-full">
                        <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wide">Pencarian</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </div>
                            <input type="text" name="search" value="{{ request('search') }}" class="block w-full pl-10 pr-3 py-2.5 border border-gray-200 rounded-xl text-sm bg-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-shadow" placeholder="Nama, email, atau no wa...">
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="w-full md:w-40">
                        <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wide">Status</label>
                        <select name="status" class="block w-full pl-3 pr-8 py-2.5 text-sm border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-xl bg-white cursor-pointer">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <!-- Missing data filter -->
                    <div class="w-full md:w-52">
                        <label class="block text-xs font-semibold text-gray-500 mb-1.5 uppercase tracking-wide">Data Filter</label>
                        <select name="missing" class="block w-full pl-3 pr-8 py-2.5 text-sm border-gray-200 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-xl bg-white cursor-pointer">
                            <option value="">Semua Data Lengkap</option>
                            <option value="whatsapp" {{ request('missing') === 'whatsapp' ? 'selected' : '' }}>⚠️ Missing WhatsApp</option>
                            <option value="referral" {{ request('missing') === 'referral' ? 'selected' : '' }}>🏷️ Missing Referral Code</option>
                            <option value="both" {{ request('missing') === 'both' ? 'selected' : '' }}>❌ Missing Both</option>
                        </select>
                    </div>

                    <div class="flex items-center gap-2 w-full md:w-auto">
                        <button type="submit" class="flex-1 md:flex-none px-6 py-2.5 bg-slate-800 text-white font-bold rounded-xl hover:bg-slate-900 transition-colors text-sm shadow-md shadow-slate-200 whitespace-nowrap">
                            Apply Filter
                        </button>
                        <button type="button" @click="showAdvanced = !showAdvanced" class="p-2.5 border border-gray-200 text-gray-500 rounded-xl hover:bg-white bg-white transition" title="Advanced Filters">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                        </button>
                        @if(request()->hasAny(['search', 'status', 'missing', 'program_id', 'class_period_id', 'month_year']))
                            <a href="{{ route('students.index') }}" class="p-2.5 bg-red-50 border border-red-100 text-red-500 rounded-xl hover:bg-red-100 hover:text-red-600 transition text-center" title="Reset">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </a>
                        @endif
                        
                        <div class="w-px h-8 bg-gray-200 mx-2 hidden md:block"></div>
                        
                        <button type="submit" form="bulkGenerateForm" onclick="return confirm('Auto-generate referral codes for all students without one?')"
                            class="px-4 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-medium rounded-xl text-xs flex items-center gap-2 transition whitespace-nowrap hidden md:flex">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            Auto-Generate Referral Codes
                        </button>
                    </div>
                </div>
                
                <!-- Advanced Filters -->
                <div x-show="showAdvanced" x-collapse class="mt-5 pt-5 border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Program</label>
                            <select name="program_id" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-blue-500 outline-none bg-white">
                                <option value="">Semua Program</option>
                                @php
                                    $mockPrograms = [];
                                    $regularPrograms = [];
                                    foreach($programs as $prog) {
                                        $name = strtolower($prog->name);
                                        if (str_contains($name, 'cambridge') || str_contains($name, 'mock')) {
                                            $mockPrograms[] = $prog;
                                        } else {
                                            $regularPrograms[] = $prog;
                                        }
                                    }
                                @endphp
                                
                                @if(count($regularPrograms) > 0)
                                    <optgroup label="Kursus Reguler & Paket">
                                        @foreach($regularPrograms as $prog)
                                            <option value="{{ $prog->id }}" {{ request('program_id') == $prog->id ? 'selected' : '' }}>{{ $prog->name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endif

                                @if(count($mockPrograms) > 0)
                                    <optgroup label="Mock Tests & Latihan">
                                        @foreach($mockPrograms as $prog)
                                            <option value="{{ $prog->id }}" {{ request('program_id') == $prog->id ? 'selected' : '' }}>{{ $prog->name }}</option>
                                        @endforeach
                                    </optgroup>
                                @endif
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Batch Kelas</label>
                            <select name="class_period_id" class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-blue-500 outline-none bg-white">
                                <option value="">Semua Batch</option>
                                @foreach(\App\Models\ClassPeriod::orderBy('start_date', 'desc')->get() as $period)
                                    <option value="{{ $period->id }}" {{ request('class_period_id') == $period->id ? 'selected' : '' }}>
                                        {{ $period->name }} ({{ $period->start_date ? $period->start_date->format('M Y') : 'N/A' }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 mb-1.5 uppercase tracking-wider">Bulan Daftar</label>
                            <input type="month" name="month_year" value="{{ request('month_year') }}" 
                                   class="w-full border border-gray-200 rounded-lg px-3 py-2 text-sm focus:border-blue-500 outline-none bg-white">
                        </div>
                    </div>
                </div>

            </form>
            
            <form id="bulkGenerateForm" action="{{ route('admin.students.bulk_generate_referral') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>

        @if(request()->filled('missing'))
        <div class="px-6 py-3 bg-amber-50 border-b border-amber-100 text-amber-700 text-sm flex items-center gap-2">
            <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Showing students with <strong class="mx-1">
                @if(request('missing') === 'whatsapp') missing WhatsApp number
                @elseif(request('missing') === 'referral') no referral code
                @else both WhatsApp and referral code missing @endif
            </strong>. Click <svg class="w-3.5 h-3.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> to edit each student inline.
        </div>
        @endif

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-100">
                <thead class="bg-gray-50/80">
                    <tr>
                        <th class="px-4 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">Student</th>
                        <th class="px-4 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">WhatsApp</th>
                        <th class="px-4 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">Referral Code</th>
                        <th class="px-4 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">Program</th>
                        <th class="px-4 py-3 text-left text-[11px] font-bold text-gray-500 uppercase tracking-wider">Teacher</th>
                        <th class="px-4 py-3 text-center text-[11px] font-bold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-4 py-3 text-right text-[11px] font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-50">
                    @forelse($students as $student)
                        @php
                            $missingWa  = empty($student->phone_number);
                            $missingRef = empty($student->referral_code);
                        @endphp
                        <tr class="hover:bg-gray-50/50 transition-colors {{ ($missingWa || $missingRef) ? 'border-l-2 border-l-amber-300' : '' }}">
                            <!-- Name -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="h-9 w-9 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-sm border border-blue-200 shrink-0">
                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <a href="{{ route('students.show', $student) }}" class="text-sm font-semibold text-gray-900 hover:text-blue-600 transition-colors">{{ $student->name }}</a>
                                        <div class="text-xs text-gray-400 mt-0.5">{{ $student->email }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- WhatsApp -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if($missingWa)
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-xs font-medium bg-amber-50 text-amber-600 border border-amber-200">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Not set
                                    </span>
                                @else
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $student->phone_number) }}" target="_blank"
                                       class="inline-flex items-center gap-1.5 text-xs font-medium text-green-700 bg-green-50 px-2.5 py-1 rounded-md border border-green-200 hover:bg-green-100 transition">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12.004 0C5.374 0 0 5.373 0 12c0 2.126.557 4.116 1.532 5.845L.073 23.927l6.244-1.436A11.946 11.946 0 0012.004 24C18.628 24 24 18.626 24 12S18.628 0 12.004 0zm0 21.818a9.794 9.794 0 01-5.003-1.372l-.358-.213-3.709.853.882-3.606-.233-.37A9.784 9.784 0 012.186 12c0-5.429 4.389-9.818 9.818-9.818S21.822 6.571 21.822 12s-4.391 9.818-9.818 9.818z"/></svg>
                                        {{ $student->phone_number }}
                                    </a>
                                @endif
                            </td>

                            <!-- Referral Code -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if($missingRef)
                                    <span class="inline-flex items-center gap-1 px-2 py-1 rounded-md text-xs font-medium bg-red-50 text-red-500 border border-red-200">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        Not generated
                                    </span>
                                @else
                                    <span class="font-mono text-xs bg-indigo-50 text-indigo-700 border border-indigo-200 px-2.5 py-1 rounded-md font-semibold tracking-wider">
                                        {{ $student->referral_code }}
                                    </span>
                                @endif
                            </td>

                            <!-- Program -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                <div class="flex flex-col gap-1">
                                    @php
                                        $allPrograms = [];
                                        if ($student->program) {
                                            $allPrograms[$student->program->id] = $student->program->name;
                                        }
                                        if ($student->enrollments) {
                                            foreach ($student->enrollments as $enrollment) {
                                                if ($enrollment->program && in_array($enrollment->status, ['active', 'completed'])) {
                                                    $allPrograms[$enrollment->program->id] = $enrollment->program->name;
                                                }
                                            }
                                        }
                                    @endphp

                                    @if(count($allPrograms) > 0)
                                        @foreach($allPrograms as $progId => $progName)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-indigo-50 text-indigo-700 border border-indigo-100 w-max">
                                                {{ $progName }}
                                            </span>
                                        @endforeach
                                    @else
                                        <span class="text-sm text-gray-400 italic">—</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Teacher -->
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if($student->teacher)
                                    <div class="flex items-center gap-2">
                                        <div class="h-6 w-6 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 text-[10px] font-bold">
                                            {{ strtoupper(substr($student->teacher->name, 0, 1)) }}
                                        </div>
                                        <span class="text-sm text-gray-700 font-medium">{{ $student->teacher->name }}</span>
                                    </div>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-md text-xs font-medium bg-red-50 text-red-600 border border-red-100">
                                        Unassigned
                                    </span>
                                @endif
                            </td>

                            <!-- Status -->
                            <td class="px-4 py-3 whitespace-nowrap text-center">
                                <button class="flex mx-auto items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium {{ $student->status == 'active' ? 'bg-green-50 text-green-700 border border-green-200 hover:bg-green-100' : 'bg-gray-50 text-gray-600 border border-gray-200 hover:bg-gray-100' }} transition-colors" data-user-id="{{ $student->id }}" onclick="toggleStatus(this)">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $student->status == 'active' ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                    <span class="status-text">{{ ucfirst($student->status) }}</span>
                                </button>
                            </td>

                            <!-- Actions -->
                            <td class="px-4 py-3 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-1 text-gray-400" x-data="{ openDropdown: false }">
                                    <!-- Quick Edit Contact -->
                                    <button type="button"
                                        @click="openQuickEdit({{ $student->id }}, '{{ addslashes($student->name) }}', '{{ addslashes($student->phone_number ?? '') }}', '{{ addslashes($student->referral_code ?? '') }}')"
                                        class="p-1.5 hover:text-green-600 hover:bg-green-50 rounded-lg transition-colors border border-transparent hover:border-green-100 {{ ($missingWa || $missingRef) ? 'text-amber-400 bg-amber-50 border-amber-200' : '' }}"
                                        title="Edit WhatsApp / Referral Code">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>

                                    <!-- Assign Teacher -->
                                    <button type="button" @click="selectedStudentId = {{ $student->id }}; selectedStudentName = '{{ addslashes($student->name) }}'; showAssignModal = true" class="p-1.5 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-colors border border-transparent hover:border-blue-100" title="Assign Teacher">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                                    </button>

                                    <!-- More Actions Dropdown -->
                                    <div class="relative">
                                        <button @click="openDropdown = !openDropdown" @click.away="openDropdown = false" class="p-1.5 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors" title="More Actions">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                                        </button>
                                        <div x-show="openDropdown" style="display: none;" class="absolute right-0 w-48 bg-white rounded-xl shadow-lg ring-1 ring-black ring-opacity-5 z-[100] divide-y divide-gray-100 {{ $loop->remaining < 2 ? 'bottom-full mb-2' : 'top-full mt-2' }}">
                                            <div class="py-1">
                                                <a href="{{ route('students.show', $student) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-indigo-600">
                                                    <svg class="mr-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                                    View Profile
                                                </a>
                                                <a href="{{ route('users.edit', $student) }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-blue-600">
                                                    <svg class="mr-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                    Edit Full Profile
                                                </a>
                                            </div>
                                            <div class="py-1">
                                                <form method="POST" action="{{ route('users.toggle-status', $student) }}">
                                                    @csrf
                                                    <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 text-left">
                                                        <svg class="mr-3 w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                                                        @if($student->status === 'active') Freeze Account @else Unfreeze Account @endif
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                <p class="text-gray-600 font-medium">No students found</p>
                                <p class="text-sm text-gray-400 mt-1">Try changing your search or filter.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
            {{ $students->links() }}
        </div>
    </div>

    {{-- =============================
         Quick Edit Modal (WA + Referral)
         ============================= --}}
    <div x-show="showQuickEditModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-900 bg-opacity-50" @click="showQuickEditModal = false"></div>
            <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 z-10"
                 x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                <div class="flex items-center gap-3 mb-5">
                    <div class="p-2 bg-green-100 text-green-600 rounded-xl">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-gray-900">Edit Contact Info</h3>
                        <p class="text-xs text-gray-500" x-text="selectedStudentName"></p>
                    </div>
                    <button @click="showQuickEditModal = false" class="ml-auto p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <form :action="`{{ url('/admin/students') }}/${selectedStudentId}/quick-update`" method="POST" class="space-y-4">
                    @csrf
                    <!-- WhatsApp -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            WhatsApp Number
                            <span class="text-xs text-gray-400 font-normal ml-1">(e.g. 08123456789 or 628123456789)</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/></svg>
                            </div>
                            <input type="text" name="phone_number" x-model="selectedStudentPhone" placeholder="628123456789"
                                class="pl-9 block w-full border border-gray-300 rounded-xl text-sm py-2.5 focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Will be auto-converted to 62xxx format.</p>
                    </div>

                    <!-- Referral Code -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Referral Code
                            <span class="text-xs text-gray-400 font-normal ml-1">(leave blank to auto-generate)</span>
                        </label>
                        <input type="text" name="referral_code" x-model="selectedStudentReferral" placeholder="e.g. BUDI12345"
                            class="block w-full border border-gray-300 rounded-xl text-sm py-2.5 px-3 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 uppercase font-mono tracking-widest">
                    </div>

                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" @click="showQuickEditModal = false"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-5 py-2 text-sm font-medium text-white bg-green-600 rounded-xl hover:bg-green-700 transition shadow-sm">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- =============================
         Assign Teacher Modal
         ============================= --}}
    <div x-show="showAssignModal" x-cloak class="fixed inset-0 z-50 overflow-y-auto" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75" @click="showAssignModal = false"></div>
            <div class="relative bg-white rounded-2xl shadow-xl w-full max-w-md p-6 z-10">
                <form :action="`{{ url('/admin/students') }}/${selectedStudentId}/assign-teacher`" method="POST">
                    @csrf
                    <div class="flex items-start gap-4 mb-5">
                        <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-full bg-blue-100">
                            <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-gray-900">Assign Teacher</h3>
                            <p class="text-sm text-gray-500 mt-0.5">Select a teacher for <span class="font-bold text-gray-900" x-text="selectedStudentName"></span>.</p>
                        </div>
                    </div>
                    <select name="teacher_id" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 cursor-pointer mb-4">
                        <option value="">-- Remove Teacher Assignment --</option>
                        @foreach($teachers as $teacher)
                            <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                        @endforeach
                    </select>
                    <div class="flex justify-end gap-2">
                        <button type="button" @click="showAssignModal = false" class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50">Cancel</button>
                        <button type="submit" class="px-5 py-2 text-sm font-medium text-white bg-blue-600 rounded-xl hover:bg-blue-700 transition shadow-sm">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
    function toggleStatus(btn) {
        const userId = btn.dataset.userId;
        const currentSpan = btn.querySelector('.w-1\\.5');
        const textSpan = btn.querySelector('.status-text');
        
        fetch(`/admin/users/${userId}/toggle-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.status === 'active') {
                btn.className = 'flex mx-auto items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium bg-green-50 text-green-700 border border-green-200 hover:bg-green-100 transition-colors';
                currentSpan.className = 'w-1.5 h-1.5 rounded-full bg-green-500';
                textSpan.innerText = 'Active';
            } else {
                btn.className = 'flex mx-auto items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-medium bg-gray-50 text-gray-600 border border-gray-200 hover:bg-gray-100 transition-colors';
                currentSpan.className = 'w-1.5 h-1.5 rounded-full bg-gray-400';
                textSpan.innerText = 'Inactive';
            }
        });
    }
</script>
@endsection
