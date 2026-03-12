@extends('layouts.dashboard')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8">
        <div class="mb-4 sm:mb-0">
            <h1 class="text-2xl font-bold text-gray-900">Broadcast Messages</h1>
            <p class="text-gray-500 mt-1">Send multi-channel messages to students and teachers.</p>
        </div>
        <div>
            <a href="{{ route('admin.broadcast-messages.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl transition shadow-sm hover:shadow-md">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                New Broadcast
            </a>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        @if($messages->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="text-xs text-gray-500 bg-gray-50/50 uppercase border-b border-gray-100">
                        <tr>
                            <th scope="col" class="px-6 py-4 font-semibold">Title</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Target Audience</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Channels</th>
                            <th scope="col" class="px-6 py-4 font-semibold">Status</th>
                            <th scope="col" class="px-6 py-4 font-semibold text-right">Sent At</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($messages as $message)
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="px-6 py-4 font-medium text-gray-900">{{ $message->title }}</td>
                                <td class="px-6 py-4">
                                    @if($message->target_role === 'student')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-700">Students</span>
                                    @elseif($message->target_role === 'teacher')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-purple-50 text-purple-700">Teachers</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700">All Users</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-1.5">
                                        @if($message->send_via_inbox)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-gray-100 text-gray-800">Inbox</span>
                                        @endif
                                        @if($message->send_via_email)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-orange-50 text-orange-700">Email</span>
                                        @endif
                                        @if($message->send_via_whatsapp)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-xs font-medium bg-emerald-50 text-emerald-700">WhatsApp</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($message->status === 'completed')
                                        <span class="text-green-600 font-medium">Completed</span>
                                    @else
                                        <span class="text-yellow-600 font-medium capitalize">{{ $message->status }}</span>
                                    @endif
                                    <div class="text-xs text-gray-400 mt-1">{{ $message->recipients_count }} recipients</div>
                                </td>
                                <td class="px-6 py-4 text-right text-gray-500 whitespace-nowrap">
                                    {{ $message->created_at->format('M d, Y H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($messages->hasPages())
                <div class="px-6 py-4 border-t border-gray-100">
                    {{ $messages->links() }}
                </div>
            @endif
        @else
            <div class="px-6 py-12 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-50 text-gray-400 mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"></path></svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">No broadcasts yet</h3>
                <p class="text-gray-500 mb-4">You haven't sent any broadcast messages.</p>
                <a href="{{ route('admin.broadcast-messages.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 hover:border-blue-500 hover:text-blue-600 text-gray-700 text-sm font-medium rounded-xl transition shadow-sm">
                    Create your first broadcast
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
