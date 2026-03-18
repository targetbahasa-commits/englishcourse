@extends('layouts.dashboard')

@section('content')
@php
    $initialTab = request('tab');
    if (!in_array($initialTab, ['notifications', 'messages', 'sent'], true)) {
        $initialTab = 'messages';
    }

    $unreadNotificationCount = $notifications->whereNull('read_at')->count();
    $unreadMessageCount = $inboxMessages->whereNull('read_at')->count();
@endphp
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto" x-data="{ tab: @js($initialTab) }">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Inbox & Messages</h1>
            <p class="text-gray-500 mt-1">Manage your notifications and direct messages.</p>
        </div>
        <div>
            <!-- Button to open compose modal -->
            <button @click="$dispatch('open-compose')" class="px-4 py-2 bg-blue-600 text-white rounded-xl shadow-sm hover:bg-blue-700 font-medium transition flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                {{ $user->role === 'admin' ? 'Send Message' : 'Contact Admin' }}
            </button>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl">
            <p class="text-green-700">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Tabs -->
    <div class="flex flex-wrap gap-6 border-b border-gray-200 mb-6">
        <button @click="tab = 'notifications'" :class="{'border-blue-500 text-blue-600': tab === 'notifications', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'notifications'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center gap-2">
            Notifications
            @if($unreadNotificationCount > 0)
                <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $unreadNotificationCount }}</span>
            @endif
        </button>
        <button @click="tab = 'messages'" :class="{'border-blue-500 text-blue-600': tab === 'messages', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'messages'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm flex items-center gap-2">
            Messages
            @if($unreadMessageCount > 0)
                <span class="bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $unreadMessageCount }}</span>
            @endif
        </button>
        <button @click="tab = 'sent'" :class="{'border-blue-500 text-blue-600': tab === 'sent', 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300': tab !== 'sent'}" class="whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
            Sent Messages
        </button>
    </div>

    <div x-show="tab === 'notifications'" class="space-y-4">
        @forelse($notifications as $item)
            <div class="bg-white p-5 rounded-xl shadow-sm border {{ is_null($item->read_at) ? 'border-blue-200 bg-blue-50/30' : 'border-gray-100' }}">
                <div class="flex justify-between items-start gap-4">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">{{ $item->data['title'] ?? 'Broadcast Announcement' }}</h3>
                            <p class="text-sm text-gray-600 mt-1 whitespace-pre-wrap">{{ $item->data['content'] ?? '' }}</p>
                            <div class="mt-2 text-xs text-gray-400 font-medium">From: Administrator • {{ $item->created_at->diffForHumans() }}</div>
                        </div>
                    </div>
                    @if(is_null($item->read_at))
                        <form action="{{ route('inbox.read', $item->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="notification">
                            <button type="submit" class="text-xs text-blue-600 hover:underline font-semibold bg-white px-3 py-1.5 rounded-lg border border-blue-200">Mark as Read</button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 text-center">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                <h3 class="text-lg font-medium text-gray-900">No notifications</h3>
                <p class="text-gray-500 text-sm mt-1">You don't have any broadcast notifications.</p>
            </div>
        @endforelse
    </div>

    <div x-show="tab === 'messages'" class="space-y-4">
        @forelse($inboxMessages as $item)
            <div class="bg-white p-5 rounded-xl shadow-sm border {{ is_null($item->read_at) ? 'border-blue-200 bg-blue-50/30' : 'border-gray-100' }}">
                <div class="flex justify-between items-start gap-4">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0 font-bold">
                            {{ substr($item->sender->name ?? 'A', 0, 1) }}
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">{{ $item->subject }}</h3>
                            <p class="text-sm text-gray-600 mt-1 whitespace-pre-wrap">{{ $item->content }}</p>
                            <div class="mt-2 text-xs text-gray-400 font-medium flex gap-2 items-center">
                                <span>From: <strong class="text-gray-600">{{ $item->sender->name ?? 'Unknown User' }}</strong> ({{ ucfirst($item->sender->role ?? 'user') }})</span>
                                <span>• {{ $item->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col items-end gap-2">
                        @if(is_null($item->read_at))
                            <form action="{{ route('inbox.read', $item->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="type" value="direct">
                                <button type="submit" class="text-xs text-blue-600 hover:underline font-semibold bg-white px-3 py-1.5 rounded-lg border border-blue-200">Mark as Read</button>
                            </form>
                        @endif
                        @if($user->role === 'admin')
                            <button @click="$dispatch('open-compose', { receiver: '{{ $item->sender_id }}', replyTo: '{{ addslashes($item->subject) }}' })" class="text-xs text-gray-600 hover:text-gray-900 font-semibold flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                                Reply
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 text-center">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                <h3 class="text-lg font-medium text-gray-900">Your messages are empty</h3>
                <p class="text-gray-500 text-sm mt-1">You don't have any direct messages yet.</p>
            </div>
        @endforelse
    </div>

    <!-- Sent List -->
    <div x-show="tab === 'sent'" class="space-y-4" style="display: none;">
        @forelse($sentMessages as $msg)
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                <div class="flex justify-between items-start">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 rounded-full bg-gray-100 text-gray-500 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900">{{ $msg->subject }}</h3>
                            <p class="text-sm text-gray-600 mt-1 whitespace-pre-wrap">{{ $msg->content }}</p>
                            <div class="mt-2 text-xs text-gray-400 font-medium">
                                To: <strong class="text-gray-600">{{ $msg->receiver_id ? $msg->receiver->name : 'Administrator' }}</strong> • {{ $msg->created_at->diffForHumans() }}
                                @if($msg->read_at)
                                    <span class="ml-2 text-green-500">✓ Read</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 text-center">
                <h3 class="text-lg font-medium text-gray-900">No sent messages</h3>
                <p class="text-gray-500 text-sm mt-1">You haven't sent any messages yet.</p>
            </div>
        @endforelse
    </div>

</div>

<!-- Compose Modal -->
<div x-data="{ open: false, receiver: '', subject: '' }" 
     @open-compose.window="open = true; receiver = $event.detail?.receiver || ''; subject = $event.detail?.replyTo ? 'Re: ' + $event.detail.replyTo : ''"
     x-show="open" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" @click="open = false"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            <form action="{{ route('inbox.store') }}" method="POST">
                @csrf
                <!-- Admin specific: They can send to specific users. We use a hidden input for the receiver if replying -->
                @if($user->role === 'admin')
                    <input type="hidden" name="receiver_id" x-model="receiver">
                @endif

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
                                {{ $user->role === 'admin' ? 'Send a Message' : 'Contact Administrator' }}
                            </h3>
                            <div class="mt-4 space-y-4">
                                @if($user->role === 'admin')
                                    <p class="text-xs text-blue-600 bg-blue-50 p-2 rounded-lg" x-show="receiver">Replying to a specific user.</p>
                                @endif
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                                    <input type="text" name="subject" x-model="subject" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                                    <textarea name="content" rows="5" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                    <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition">
                        Send Message
                    </button>
                    <button type="button" @click="open = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
