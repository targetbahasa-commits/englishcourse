@props([
    'notificationHref' => null,
    'chatUnread' => null,
    'notificationUnread' => null,
])

@php
    $chatHref = \Illuminate\Support\Facades\Route::has('inbox.index') ? route('inbox.index', ['tab' => 'messages']) : '#';
    $chatUnread = $chatUnread ?? (Auth::check() && method_exists(Auth::user(), 'hasUnreadChat') && Auth::user()->hasUnreadChat());
    $notificationUnread = $notificationUnread ?? (
        Auth::check()
        && !Auth::user()->isAdmin()
        && method_exists(Auth::user(), 'hasUnreadAnnouncements')
        && Auth::user()->hasUnreadAnnouncements()
    );

    if (!$notificationHref) {
        if (Auth::check() && Auth::user()->isAdmin() && \Illuminate\Support\Facades\Route::has('admin.announcements.index')) {
            $notificationHref = route('admin.announcements.index');
        } elseif (Auth::check() && \Illuminate\Support\Facades\Route::has('announcements.index')) {
            $notificationHref = route('announcements.index');
        } elseif ($chatHref !== '#') {
            $notificationHref = $chatHref;
        } else {
            $notificationHref = \Illuminate\Support\Facades\Route::has('dashboard') ? route('dashboard') : '#';
        }
    }
@endphp

<a href="{{ $chatHref }}" class="relative p-2 bg-white rounded-full shadow-sm hover:bg-gray-50 transition border border-gray-100 flex items-center justify-center" title="Open Inbox" aria-label="Open Inbox">
    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
    @if($chatUnread)
        <span class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-full border-2 border-white"></span>
    @endif
</a>

<a href="{{ $notificationHref }}" class="relative p-2 bg-white rounded-full shadow-sm hover:bg-gray-50 transition border border-gray-100 flex items-center justify-center" title="Open Notifications" aria-label="Open Notifications">
    <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
    @if($notificationUnread)
        <span class="absolute top-0 right-0 w-3 h-3 bg-red-500 rounded-full border-2 border-white"></span>
    @endif
</a>
