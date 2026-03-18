@extends('layouts.dashboard')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-6xl mx-auto">
    <div class="mb-8 flex items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Announcements</h1>
            <p class="text-gray-500 mt-1">Updates from the Target Bahasa team for your current role.</p>
        </div>
        <a href="{{ route('inbox.index', ['tab' => 'notifications']) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 rounded-xl text-sm font-medium text-gray-700 hover:bg-gray-50 transition shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            Open Inbox Notifications
        </a>
    </div>

    @if(count($justReadIds) > 0)
        <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-800 rounded-2xl px-5 py-4">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <div>
                    <p class="font-semibold">Announcements marked as read.</p>
                    <p class="text-sm text-blue-700 mt-1">Unread badge will clear after this visit.</p>
                </div>
            </div>
        </div>
    @endif

    <div class="space-y-4">
        @forelse($announcements as $announcement)
            <article class="bg-white border border-gray-100 rounded-2xl shadow-sm p-6">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-3 mb-3">
                            <h2 class="text-lg font-bold text-gray-900">{{ $announcement->title }}</h2>
                            @if(in_array($announcement->id, $justReadIds, true))
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-600">New</span>
                            @elseif($announcement->updated_at->gt($announcement->created_at))
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700">Updated</span>
                            @endif
                        </div>
                        <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $announcement->content }}</p>
                    </div>
                    <div class="text-right shrink-0">
                        <div class="text-xs font-semibold uppercase tracking-wide text-gray-400">Published</div>
                        <div class="text-sm font-medium text-gray-600 mt-1">{{ $announcement->updated_at->diffForHumans() }}</div>
                    </div>
                </div>
            </article>
        @empty
            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm p-10 text-center">
                <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 10c0 7-7 11-7 11S5 17 5 10a7 7 0 1114 0z"></path></svg>
                <h2 class="text-lg font-semibold text-gray-900">No announcements yet</h2>
                <p class="text-sm text-gray-500 mt-1">There are no active announcements for your role right now.</p>
            </div>
        @endforelse
    </div>

    @if($announcements->hasPages())
        <div class="mt-8">
            {{ $announcements->links() }}
        </div>
    @endif
</div>
@endsection
