@extends('layouts.admin')

@section('content')
    <div class="max-w-7xl mx-auto py-8">
        <!-- Header -->
        <div class="mb-8 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Outreach Messages</h1>
                <p class="text-sm text-gray-500 mt-1">Manage automated class offers and recommendations sent after Free Tests</p>
            </div>
            
            <a href="{{ route('admin.outreach-messages.create') }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Message
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6 rounded-md">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">{{ session('success') }}</p>
                    </div>
                </div>
            </div>
        @endif

        <!-- Main Content -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden text-gray-800">
            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-200">
                            <th class="py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Test Type</th>
                            <th class="py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Target Role</th>
                            <th class="py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Score Range</th>
                            <th class="py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider">Message Content</th>
                            <th class="py-3 px-6 text-xs font-semibold text-gray-600 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($messages as $message)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="font-medium text-gray-900 border border-gray-200 px-2 py-1 bg-gray-50 rounded-md inline-block text-sm">
                                        {{ strtoupper(str_replace('_', ' ', $message->test_type)) }}
                                    </div>
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap">
                                    @if($message->target_role === 'student')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            Student (Recommendation)
                                        </span>
                                    @elseif($message->target_role === 'guest')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                            Guest (Conversion)
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 whitespace-nowrap font-medium text-gray-700">
                                    {{ $message->min_score + 0 }} - {{ $message->max_score + 0 }}
                                </td>
                                <td class="py-4 px-6">
                                    <div class="text-sm text-gray-600 line-clamp-2 max-w-sm">{{ $message->message_content }}</div>
                                </td>
                                <td class="py-4 px-6 text-sm text-right whitespace-nowrap">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('admin.outreach-messages.edit', $message->id) }}" class="text-indigo-600 hover:text-indigo-900 flex items-center gap-1 transition-colors">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.outreach-messages.destroy', $message->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this outreach message?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 flex items-center gap-1 transition-colors">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 px-6 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                    <p class="text-lg font-medium text-gray-900 mb-1">No outreach messages</p>
                                    <p class="text-gray-500 mb-4">You haven't created any automated outreach messages yet.</p>
                                    <a href="{{ route('admin.outreach-messages.create') }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                        Create your first message
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($messages->hasPages())
            <div class="p-4 border-t border-gray-100">
                {{ $messages->links() }}
            </div>
            @endif
        </div>
    </div>
@endsection
