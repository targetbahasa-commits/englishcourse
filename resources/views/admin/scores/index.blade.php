@extends('layouts.admin')

@section('header')
<div class="flex justify-between items-center">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Daftar Skor</h2>
    <div></div>
</div>
@endsection

@section('content')
<div class="py-8">
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b bg-gray-50 flex items-center justify-between">
                <h3 class="font-bold text-lg">Skor Siswa</h3>
                <form method="GET" class="flex items-center gap-2">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email" class="px-3 py-2 border rounded-lg text-sm">
                    <select name="program_id" class="px-3 py-2 border rounded-lg text-sm">
                        <option value="">Semua Program</option>
                        @foreach($programs as $program)
                            <option value="{{ $program->id }}" @if(request('program_id') == $program->id) selected @endif>{{ $program->name }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="meeting_number" value="{{ request('meeting_number') }}" placeholder="Meeting #" class="px-3 py-2 border rounded-lg text-sm w-28">
                    <button class="px-3 py-2 bg-indigo-600 text-white rounded-lg text-sm">Filter</button>
                </form>
            </div>
            <div class="p-6">
                <div class="mb-4 text-sm text-gray-600">
                    <strong>Total:</strong> {{ $stats['total'] }} — <strong>Completed:</strong> {{ $stats['completed'] }} — <strong>Unique Students:</strong> {{ $stats['unique_students'] }} — <strong>Average:</strong> {{ number_format($stats['average'], 2) }}
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="text-xs text-gray-500">
                                <th class="px-4 py-2">Student</th>
                                <th class="px-4 py-2">Program</th>
                                <th class="px-4 py-2">Meeting</th>
                                <th class="px-4 py-2">Score</th>
                                <th class="px-4 py-2">Submitted At</th>
                                <th class="px-4 py-2 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($results as $row)
                                <tr class="border-t">
                                    <td class="px-4 py-3">
                                        <a href="{{ route('admin.assignment-results.submission', [$row->program, $row->id]) }}" class="text-sm font-medium text-gray-900 hover:underline">{{ $row->user->name ?? ($row->user->email ?? '-') }}</a>
                                        <div class="text-xs text-gray-500">{{ $row->user->email ?? '-' }}</div>
                                    </td>
                                    <td class="px-4 py-3">{{ $row->program->name ?? '-' }}</td>
                                    <td class="px-4 py-3">{{ $row->meeting_number }}</td>
                                    <td class="px-4 py-3 font-mono">{{ $row->score ?? '—' }}</td>
                                    <td class="px-4 py-3">{{ $row->submitted_at ? $row->submitted_at->format('d M Y H:i') : ($row->created_at ? $row->created_at->format('d M Y H:i') : '-') }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <a href="{{ route('admin.assignment-results.submission', [$row->program, $row->id]) }}" class="inline-flex items-center gap-2 px-3 py-1.5 bg-indigo-50 text-indigo-700 rounded-lg border border-indigo-200 text-sm">View</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-6 text-center text-sm text-gray-500">Tidak ada data.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $results->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
