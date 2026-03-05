@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8 h-screen flex flex-col">
    <!-- Header -->
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center gap-3">
            <a href="{{ route('assignments.ielts-academic.writing.index', ['task' => $task]) }}" class="p-2 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                 <span class="text-sm font-semibold text-teal-600 tracking-wider uppercase">IELTS Writing Task {{ $task }}</span>
                <h1 class="text-2xl font-bold text-gray-800">{{ $meeting->title }}</h1>
            </div>
        </div>
    </div>

    <!-- Content Wrapper -->
    <div class="flex-1 overflow-y-auto pb-8">
        <div class="max-w-4xl mx-auto w-full space-y-8">
            
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
                <div class="inline-block p-4 bg-teal-50 rounded-full mb-4">
                    <svg class="w-16 h-16 text-teal-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path></svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Welcome to Graphical Sentences</h2>
                <p class="text-xl text-gray-600">
                    This lesson will guide you through interpreting and describing graphs, charts, and diagrams for IELTS Writing Task 1.
                </p>
                <div class="mt-8 p-6 bg-yellow-50 text-yellow-800 rounded-lg border border-yellow-200">
                    <strong>Work in Progress:</strong> The full content for this lesson is currently under development.
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
