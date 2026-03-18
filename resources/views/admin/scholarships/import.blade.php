@extends('layouts.admin')

@section('title', 'Bulk Import Scholarships')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-3xl mx-auto">

    <!-- Page header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl md:text-3xl text-gray-800 font-bold">Bulk Import Scholarships</h1>
            <p class="text-sm text-gray-500 mt-1">Upload a CSV file to create multiple scholarships at once.</p>
        </div>
        <a href="{{ route('admin.scholarships.index') }}" class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
            ← Back to List
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg flex items-center gap-2">
            <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-lg">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden p-6 space-y-6">

        <!-- Upload Form -->
        <form action="{{ route('admin.scholarships.import.process') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div class="grid gap-4 md:grid-cols-2">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Import Mode</label>
                    <select name="import_mode" class="w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-indigo-400 focus:ring-indigo-400">
                        <option value="scholarship" {{ old('import_mode') === 'scholarship' ? 'selected' : '' }}>Scholarship</option>
                        <option value="event" {{ old('import_mode') === 'event' ? 'selected' : '' }}>Event / Kompetisi (Review)</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <label class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-700">
                        <input type="checkbox" name="publish_now" value="1" {{ old('publish_now') ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                        Publish sebagai Active
                    </label>
                </div>
            </div>
            <p class="-mt-1 text-xs text-amber-700">Default disimpan sebagai review (inactive). Jika publish diaktifkan, data tetap akan melewati quality gate.</p>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">CSV File <span class="text-red-500">*</span></label>
                <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg bg-gray-50 hover:bg-white transition"
                     x-data="{ fileName: null }" x-on:dragover.prevent x-on:drop.prevent="fileName = $event.dataTransfer.files[0]?.name; $refs.csvInput.files = $event.dataTransfer.files">
                    <div class="space-y-2 text-center">
                        <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        <div class="flex justify-center text-sm text-gray-600">
                            <label for="csv_file" class="relative cursor-pointer font-medium text-indigo-600 hover:text-indigo-500">
                                <span x-text="fileName || 'Choose a CSV file'"></span>
                                <input id="csv_file" name="csv_file" x-ref="csvInput" type="file" class="sr-only" accept=".csv,.txt"
                                       @change="fileName = $event.target.files[0]?.name">
                            </label>
                            <p class="pl-1 hidden sm:block">or drag and drop</p>
                        </div>
                        <p class="text-xs text-gray-500">CSV or TXT, max 2 MB</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition shadow-sm">
                    Upload &amp; Import
                </button>
            </div>
        </form>

        <!-- Format Guide -->
        <div class="border-t border-gray-100 pt-5">
            <h3 class="text-sm font-semibold text-gray-700 mb-3">Required CSV Format</h3>
            <p class="text-xs text-gray-500 mb-3">Header fleksibel sudah didukung. Untuk hasil terbaik, gunakan urutan kolom berikut:</p>
            <div class="overflow-x-auto">
                <table class="min-w-full text-xs border border-gray-200 rounded-lg overflow-hidden">
                    <thead class="bg-gray-50">
                        <tr>
                            @foreach(['#','Column','Required','Example'] as $h)
                            <th class="px-3 py-2 text-left font-semibold text-gray-600 border-b border-gray-200">{{ $h }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @php
                        $cols = [
                            [1,'title','Yes','Chevening Scholarship'],
                            [2,'provider','Yes','UK Government'],
                            [3,'location','Yes','United Kingdom'],
                            [4,'level_of_study','Yes','S2'],
                            [5,'deadline','Yes','2026-12-01'],
                            [6,'apply_link','Yes','https://chevening.org'],
                            [7,'min_ielts','No','6.5'],
                            [8,'min_toefl','No','580'],
                            [9,'country','No','UK'],
                            [10,'description','No','A prestigious…'],
                            [11,'requirements','No','WNI, GPA ≥ 3.0…'],
                            [12,'benefits','No','Tuition, living…'],
                        ];
                        @endphp
                        @foreach($cols as [$n,$col,$req,$ex])
                        <tr class="{{ $n % 2 === 0 ? 'bg-gray-50' : '' }}">
                            <td class="px-3 py-1.5 text-gray-400">{{ $n }}</td>
                            <td class="px-3 py-1.5 font-mono text-indigo-600">{{ $col }}</td>
                            <td class="px-3 py-1.5">
                                @if($req === 'Yes')
                                    <span class="text-red-500 font-medium">Yes</span>
                                @else
                                    <span class="text-gray-400">No</span>
                                @endif
                            </td>
                            <td class="px-3 py-1.5 text-gray-500">{{ $ex }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Download sample -->
            <div class="mt-4">
                <a href="data:text/csv;charset=utf-8,title,provider,location,level_of_study,deadline,apply_link,min_ielts,min_toefl,country,description,requirements,benefits%0AChevening Scholarship,UK Government,United Kingdom,S2,2026-12-01,https://chevening.org,6.5,,UK,A prestigious scholarship.,WNI citizens who have finished S1.,Full tuition and living allowance."
                   download="scholarships_sample.csv"
                   class="inline-flex items-center gap-2 text-sm text-indigo-600 hover:text-indigo-800 font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Download Sample CSV
                </a>
            </div>
        </div>
    </div>

</div>
@endsection
