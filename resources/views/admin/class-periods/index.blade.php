@extends('layouts.admin')

@section('title', 'Class Periods')

@section('content')
<div class="p-8">
    <!-- Header -->
    <div class="flex justify-between items-end mb-8">
        <div>
            <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                {{ __('Class Periods') }}
            </h2>
            <p class="text-sm text-gray-500 mt-1">Manage student batches and control meeting access per class</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('custom-classes.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 shadow-sm transition">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                + Buat Kelas Custom (Privat / Semi)
            </a>
            <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-class-period')" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-lg font-semibold text-sm text-white hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Class Period (Reguler)
            </button>
        </div>
    </div>

    <!-- Main Content -->
    <div>
        @if (session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r shadow-sm" role="alert">
                <p class="font-bold">Success</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if (session('wa_template'))
            <div class="bg-emerald-50 border border-emerald-300 p-5 mb-6 rounded-2xl shadow-sm space-y-3" x-data="{ copied: false }">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2 text-emerald-800 font-bold text-sm">
                        <svg class="w-5 h-5 text-emerald-600" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                        <span>Template WhatsApp Siap Kirim ke Student</span>
                    </div>
                    <div class="flex items-center gap-2">
                        @if(session('invoice_url'))
                            <a href="{{ session('invoice_url') }}" target="_blank" class="text-xs bg-white text-indigo-700 border border-indigo-200 px-3 py-1.5 rounded-lg font-bold hover:bg-indigo-50 transition">
                                Unduh Invoice PDF
                            </a>
                        @endif
                        <button type="button" @click="navigator.clipboard.writeText($refs.waText.value); copied = true; setTimeout(() => copied = false, 2000)"
                                class="text-xs bg-emerald-600 text-white px-3 py-1.5 rounded-lg font-bold hover:bg-emerald-700 transition flex items-center gap-1">
                            <span x-text="copied ? '✓ Berhasil Disalin!' : 'Salin Pesan WA'"></span>
                        </button>
                    </div>
                </div>
                <textarea x-ref="waText" readonly rows="7" class="w-full text-xs font-mono bg-white p-3 rounded-xl border border-emerald-200 text-gray-800 focus:ring-0 focus:outline-none">{{ session('wa_template') }}</textarea>
            </div>
        @endif

        <!-- Filters -->
        <!-- Program selection now lives in the Category/Program tabs below,
             which need the full unfiltered $periods list to render every
             program's tab - a server-side "All Programs" dropdown here would
             strip other programs out of that list before it ever reaches the
             tabs, making them silently disappear (e.g. picking "Kelas Custom"
             here used to make the SAT tab vanish entirely, since its periods
             were never fetched in the first place). Status is unaffected
             since nothing below re-derives it per-program. -->
        <form method="GET" action="{{ route('class-periods.index') }}" class="flex gap-4 mb-6">
                <select name="status" onchange="this.form.submit()" class="rounded-lg border-gray-300 text-sm focus:ring-blue-500 focus:border-blue-500 shadow-sm">
                    <option value="">All Statuses</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </form>

            @if(empty($periods))
                <!-- Empty State -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                    <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                        <div class="bg-gray-50 p-4 rounded-full mb-4">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">No class periods created yet</h3>
                        <p class="text-gray-500 mt-1 mb-6 max-w-sm">Create a class period to organize students into batches and manage their meeting access.</p>
                        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'create-class-period')" class="text-blue-600 hover:text-blue-800 font-medium">
                            + Create your first class period
                        </button>
                    </div>
                </div>
            @else
                @php
                    $categoryOrder = ['IELTS Courses & Skills', 'TOEFL & PTE Courses', 'Grammar & Speaking Courses', 'Program Lainnya'];
                    $unassignedLabel = 'Tanpa Program';

                    $byCategory = collect($periods)->groupBy(function ($period) use ($unassignedLabel) {
                        if (!$period->program) {
                            return $unassignedLabel;
                        }
                        return $period->program->category ?: 'Program Lainnya';
                    });

                    // Fixed, predictable category order; anything unexpected falls in after
                    // the known ones, "Tanpa Program" always last.
                    $orderedCategories = collect($categoryOrder)
                        ->filter(fn ($cat) => $byCategory->has($cat))
                        ->concat($byCategory->keys()->diff($categoryOrder)->diff([$unassignedLabel])->sort())
                        ->when($byCategory->has($unassignedLabel), fn ($c) => $c->push($unassignedLabel));

                    // Pre-compute the full category -> program -> periods tree up
                    // front (instead of inside the render loop) so the tab
                    // buttons - which need every category/program name before
                    // any panel is drawn - and the panels themselves can both
                    // read from the same structure.
                    $grouped = $orderedCategories->mapWithKeys(function ($categoryName) use ($byCategory, $unassignedLabel) {
                        $byProgram = $byCategory->get($categoryName)->groupBy(
                            fn ($period) => $period->program ? $period->program->name : $unassignedLabel
                        )->sortKeys();
                        return [$categoryName => $byProgram];
                    });

                    $firstCategory = $orderedCategories->first();
                    $firstProgram = $grouped->get($firstCategory)?->keys()->first();
                @endphp

                <div x-data="{ activeCategory: {{ Js::from($firstCategory) }}, activeProgram: {{ Js::from($firstProgram) }} }">
                    <!-- Category Tabs -->
                    <div class="flex flex-wrap gap-2 border-b border-gray-200 mb-4">
                        @foreach ($orderedCategories as $categoryName)
                            @php $categoryTotal = $byCategory->get($categoryName)->count(); @endphp
                            <button type="button"
                                    @click="activeCategory = {{ Js::from($categoryName) }}; activeProgram = {{ Js::from($grouped->get($categoryName)->keys()->first()) }};"
                                    :class="activeCategory === {{ Js::from($categoryName) }} ? 'border-indigo-600 text-indigo-700' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                    class="px-1 pb-3 -mb-px border-b-2 text-sm font-bold uppercase tracking-wider transition">
                                {{ $categoryName }}
                                <span class="ml-1 text-xs font-normal normal-case text-gray-400">({{ $categoryTotal }})</span>
                            </button>
                        @endforeach
                    </div>

                    @foreach ($orderedCategories as $categoryName)
                        @php $byProgram = $grouped->get($categoryName); @endphp

                        <div x-show="activeCategory === {{ Js::from($categoryName) }}" x-cloak class="mb-8">
                            <!-- Program Sub-tabs -->
                            <div class="flex flex-wrap gap-2 mb-4">
                                @foreach ($byProgram as $programName => $periodsInProgram)
                                    <button type="button"
                                            @click="activeProgram = {{ Js::from($programName) }}"
                                            :class="activeProgram === {{ Js::from($programName) }} ? 'bg-indigo-600 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50'"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition">
                                        {{ $programName }}
                                        <span class="inline-flex items-center justify-center rounded-full px-1.5 py-0.5 text-[10px] font-bold"
                                              :class="activeProgram === {{ Js::from($programName) }} ? 'bg-indigo-500 text-white' : 'bg-gray-200 text-gray-700'">
                                            {{ $periodsInProgram->count() }}
                                        </span>
                                    </button>
                                @endforeach
                            </div>

                            @foreach ($byProgram as $programName => $periodsInProgram)
                                <div x-show="activeProgram === {{ Js::from($programName) }}" x-cloak class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                                    <div class="px-6 py-3 bg-gray-50 border-b border-gray-200 flex items-center gap-2">
                                        <h4 class="font-semibold text-gray-800 text-sm">{{ $programName }}</h4>
                                        <span class="inline-flex items-center justify-center bg-gray-200 text-gray-700 rounded-full px-2 py-0.5 text-xs font-bold">
                                            {{ $periodsInProgram->count() }}
                                        </span>
                                    </div>

                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead>
                                                <tr class="bg-white">
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Class Period Name</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Teacher</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Date Range</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Mode</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Tipe Batch</th>
                                                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Students</th>
                                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach ($periodsInProgram as $period)
                                                    <tr class="hover:bg-gray-50 transition-colors">
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="flex items-center gap-1.5 flex-wrap mb-1">
                                                                @if($period->is_custom)
                                                                    <span class="inline-flex items-center justify-center bg-indigo-100 text-indigo-800 rounded px-2 py-0.5 text-xs font-bold">Custom Class ({{ $period->total_meetings ?? 'Flex' }} M)</span>
                                                                @elseif($period->batch_number)
                                                                    <span class="inline-flex items-center justify-center bg-blue-100 text-blue-800 rounded px-2 py-0.5 text-xs font-bold">Batch {{ $period->batch_number }}</span>
                                                                @endif
                                                            </div>
                                                            <div class="text-sm font-bold text-gray-900">{{ $period->name }}</div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            @if($period->teacher)
                                                                <div class="flex items-center gap-2">
                                                                    <div class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-bold shrink-0">
                                                                        {{ strtoupper(substr($period->teacher->name, 0, 1)) }}
                                                                    </div>
                                                                    <span class="text-sm text-gray-800 font-medium">{{ $period->teacher->name }}</span>
                                                                </div>
                                                            @else
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-400 italic">Unassigned</span>
                                                            @endif
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="text-sm text-gray-900">{{ $period->start_date ? $period->start_date->format('M d, Y') : 'TBD' }}</div>
                                                            <div class="text-xs text-gray-500">to {{ $period->end_date ? $period->end_date->format('M d, Y') : 'TBD' }}</div>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $period->learning_mode === 'online' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800' }}">
                                                                {{ ucfirst($period->learning_mode) }}
                                                            </span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            @php
                                                                $batchTypeLabels = ['regular' => 'Reguler', 'semi_private' => 'Semi-Private', 'private' => 'Private'];
                                                                $batchTypeColors = ['regular' => 'bg-blue-100 text-blue-800', 'semi_private' => 'bg-purple-100 text-purple-800', 'private' => 'bg-amber-100 text-amber-800'];
                                                            @endphp
                                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $batchTypeColors[$period->batch_type] ?? 'bg-gray-100 text-gray-600' }}">
                                                                {{ $batchTypeLabels[$period->batch_type] ?? ucfirst($period->batch_type) }}
                                                            </span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-center">
                                                            <div class="text-sm font-medium text-gray-900">{{ $period->users_count }}</div>
                                                            <div class="text-xs text-gray-500">enrolled</div>
                                                            @if($period->booked_count > 0)
                                                                <div class="text-xs font-bold text-blue-600 mt-0.5">{{ $period->booked_count }} booking sendiri</div>
                                                            @endif
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <form action="{{ route('class-periods.status', $period) }}" method="POST">
                                                                @csrf
                                                                @method('PATCH')
                                                                <select name="status" onchange="this.form.submit()"
                                                                    class="text-xs font-semibold rounded-full border-0 py-1 pl-3 pr-8 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-xs sm:leading-6
                                                                    {{ $period->status === 'active' ? 'bg-green-100 text-green-800' : '' }}
                                                                    {{ $period->status === 'upcoming' ? 'bg-blue-100 text-blue-800' : '' }}
                                                                    {{ $period->status === 'closed' ? 'bg-gray-100 text-gray-600' : '' }}
                                                                    ">
                                                                    <option value="active" {{ $period->status === 'active' ? 'selected' : '' }}>Active</option>
                                                                    <option value="upcoming" {{ $period->status === 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                                                    <option value="closed" {{ $period->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                                                </select>
                                                            </form>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                            <a href="{{ route('class-periods.show', $period) }}" class="inline-flex items-center px-3 py-1.5 border border-indigo-600 rounded-md text-indigo-600 hover:bg-indigo-50 font-medium text-xs transition duration-150 ease-in-out">
                                                                Manage
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            @endif
    </div>
</div>
@endsection

@section('modals')
    <!-- Modal for Create -->
    <x-modal name="create-class-period" focusable>
        <div class="p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4">Create New Class Period</h2>
            
            <form method="POST" action="{{ route('class-periods.store') }}" class="space-y-4" x-data="classPeriodForm()">
                @csrf
                
                <div>
                    <x-input-label for="program_id" value="Program" />
                    <select name="program_id" id="program_id"
                            x-model="programId"
                            @change="fetchBatchNumber($event.target.value)"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                        <option value="">-- Select Program --</option>
                        @foreach (\App\Models\Program::where('is_active', true)->whereNot('slug', 'like', 'cambridge-%')->whereNot('slug', 'like', 'toefl-itp-mock-package-%')->get()->groupBy('category') as $category => $categoryPrograms)
                            <optgroup label="{{ $category }}">
                                @foreach($categoryPrograms as $program)
                                    <option value="{{ $program->id }}">{{ $program->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Pilih program untuk batch ini.</p>
                </div>

                <input type="hidden" name="batch_number" :value="batchNumber">

                <div>
                    <x-input-label for="batch_type" value="Tipe Batch" />
                    <select name="batch_type" id="batch_type" x-model="batchType" @change="onBatchTypeChange()" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                        <option value="regular" selected>Reguler (minimal 4 orang)</option>
                        <option value="semi_private">Semi-Private (minimal 2 orang)</option>
                        <option value="private">Private (1 orang)</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Tipe batch ini akan terlihat oleh student di halaman Booking Class.</p>
                </div>

                <div>
                    <x-input-label for="batch_number_preview" value="Batch Number (Auto)" />
                    <div class="mt-1 relative flex items-center">
                        <input type="text" id="batch_number_preview"
                               :value="batchNumber ? 'Batch #' + batchNumber : '\u2014 (pilih program dulu)'"
                               class="block w-full bg-gray-50 border border-gray-300 rounded-md shadow-sm text-sm text-gray-600 px-3 py-2 focus:outline-none"
                               readonly>
                        <div x-show="fetchingBatch" class="absolute right-3">
                            <svg class="animate-spin h-4 w-4 text-indigo-400" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">Nomor batch dikalkulasi otomatis berdasarkan riwayat program.</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="start_date" value="Start Date" />
                        <x-text-input id="start_date" name="start_date" type="date" class="mt-1 block w-full" x-model="startDate" @change="syncName" required />
                    </div>
                    <div>
                        <x-input-label for="end_date" value="End Date" />
                        <x-text-input id="end_date" name="end_date" type="date" class="mt-1 block w-full" x-model="endDate" @change="syncName" required />
                    </div>
                </div>

                <div>
                    <x-input-label for="name" value="Period Name (Auto)" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full bg-gray-50" x-model="periodName" readonly required />
                    <p class="text-xs text-gray-500 mt-1">Nama batch dibuat otomatis berdasarkan program dan tanggal.</p>
                </div>

                <div>
                    <x-input-label for="teacher_id_create" value="Teacher (Optional)" />
                    <select name="teacher_id" id="teacher_id_create"
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
                        <option value="">— Unassigned (dapat diassign menyusul) —</option>
                        @foreach (\App\Models\User::where('role', 'teacher')->orderBy('name')->get() as $t)
                            <option value="{{ $t->id }}">{{ $t->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-gray-500 mt-1">Pengajar dapat di-assign setelah batch dibuat.</p>
                </div>
                
                 <div>
                    <x-input-label for="status" value="Status" />
                    <select name="status" id="status" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                        <option value="active" selected>Active</option>
                        <option value="upcoming">Upcoming</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
                
                <div>
                    <x-input-label for="learning_mode" value="Learning Mode" />
                    <select name="learning_mode" id="learning_mode" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" required>
                        <option value="online" selected>Online</option>
                        <option value="offline">Offline</option>
                    </select>
                </div>
                
                <div>
                    <x-input-label for="min_capacity" value="Min Capacity" />
                    <x-text-input id="min_capacity" name="min_capacity" type="number"
                                  x-model="minCapacity" x-bind:min="minCapacityFloorFor(batchType)" x-bind:readonly="batchType === 'private'"
                                  class="mt-1 block w-full" required />
                    <p class="text-xs text-gray-500 mt-1">Jumlah siswa minimal agar batch ini bisa dibuka.</p>
                </div>

                <div>
                    <x-input-label for="max_capacity" value="Max Capacity" />
                    <x-text-input id="max_capacity" name="max_capacity" type="number"
                                  x-model="maxCapacity" x-bind:min="minCapacity || minCapacityFloorFor(batchType)" x-bind:readonly="batchType === 'private'"
                                  class="mt-1 block w-full" placeholder="Kosongkan jika tidak dibatasi" />
                    <p class="text-xs text-gray-500 mt-1" x-text="capacityHint(batchType)"></p>
                </div>

                <div class="flex items-center mt-2">
                    <input id="auto_lock" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" disabled checked>
                    <label for="auto_lock" class="ml-2 block text-sm text-gray-500 opacity-75">
                        Auto-lock meetings after end date (Available in Pro)
                    </label>
                </div>

                <div class="mt-6 flex justify-end gap-3">
                    <button type="button" x-on:click="$dispatch('close')" class="px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                        Cancel
                    </button>

                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        Create Period
                    </button>
                </div>
            </form>
        </div>
    </x-modal>

    <script>
        function classPeriodForm() {
            return {
                programId: '',
                batchNumber: '',
                fetchingBatch: false,
                startDate: '',
                endDate: '',
                periodName: '',
                batchType: 'regular',
                minCapacity: 4,
                maxCapacity: '',

                minCapacityFloorFor(batchType) {
                    return { regular: 4, semi_private: 2, private: 1 }[batchType] || 1;
                },

                capacityHint(batchType) {
                    if (batchType === 'private') return 'Batch Private selalu 1 orang (tidak bisa diubah).';
                    if (batchType === 'semi_private') return 'Batch Semi-Private minimal 2 orang.';
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
                    } else if (!this.maxCapacity && this.batchType === 'regular') {
                        this.maxCapacity = '';
                    }
                },

                async fetchBatchNumber(programId) {
                    if (!programId) {
                        this.batchNumber = '';
                        this.syncName();
                        return;
                    }
                    this.fetchingBatch = true;
                    try {
                        const res = await fetch(`/admin/class-periods/next-batch-number?program_id=${programId}`, {
                            headers: { 'X-Requested-With': 'XMLHttpRequest' }
                        });
                        const data = await res.json();
                        this.batchNumber = data.next_batch_number;
                    } catch (e) {
                        this.batchNumber = '';
                    } finally {
                        this.fetchingBatch = false;
                    }
                    this.syncName();
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
            };
        }
    </script>
@endsection
