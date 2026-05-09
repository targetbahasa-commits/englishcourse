@extends('layouts.admin')

@section('header')
<div class="flex justify-between items-center">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('TOEFL Mockup Results') }}
    </h2>
    <div class="flex space-x-2">
        <button onclick="window.print()" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow hover:bg-indigo-700">
            Export (PDF/Print)
        </button>
    </div>
</div>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm flex flex-col sm:rounded-lg">
            
            <div class="p-6 bg-white border-b border-gray-200 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Exam</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Test Package</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Scores (L / S / R)</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-indigo-600 font-bold uppercase tracking-wider">Total TOEFL</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($results as $result)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $result->created_at->format('d M Y, H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $result->name }}</div>
                                    <div class="text-sm text-gray-500">{{ $result->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $result->exam_label }}</div>
                                    <div class="text-sm text-gray-500">{{ $result->source_label }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    Package {{ $result->package_number }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-mono">
                                    {{ $result->listening_score }} / {{ $result->structure_score }} / {{ $result->reading_score }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-sm leading-5 font-bold rounded-full bg-indigo-100 text-indigo-800">
                                        {{ $result->total_score }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <a href="{{ route('assignments.mock-tests.results.show', $result->id) }}" class="inline-flex items-center rounded-lg border border-indigo-200 bg-indigo-50 px-3 py-1.5 text-sm font-bold text-indigo-700 transition hover:bg-indigo-100">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                    Tidak ada data hasil tes.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="px-6 py-4">
                {{ $results->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
