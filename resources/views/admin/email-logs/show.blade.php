@extends('layouts.admin')

@section('title', 'View Email Log')

@section('content')
<div class="px-8 py-8 w-full max-w-5xl mx-auto">
    <!-- Header -->
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ route('admin.email-logs.index') }}" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white border border-gray-200 text-gray-500 hover:text-blue-600 hover:border-blue-200 hover:bg-blue-50 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h1 class="text-2xl font-bold text-gray-900">Email Details</h1>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 md:p-8 border-b border-gray-100 space-y-4">
            <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-8 text-sm">
                <div class="flex items-center gap-2">
                    <span class="text-gray-500 font-medium w-16">To:</span>
                    <span class="text-gray-900 font-semibold">{{ $emailLog->to_email }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-gray-500 font-medium w-16">Date:</span>
                    <span class="text-gray-900">{{ $emailLog->sent_at ? $emailLog->sent_at->format('d M Y, H:i:s') : '-' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-gray-500 font-medium w-16">Status:</span>
                    @if($emailLog->status === 'sent')
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-100">Sent</span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-100">Failed</span>
                    @endif
                </div>
            </div>
            <div class="flex items-start gap-2 text-sm pt-4 border-t border-gray-50">
                <span class="text-gray-500 font-medium w-16 mt-0.5">Subject:</span>
                <span class="text-gray-900 font-bold text-base">{{ $emailLog->subject }}</span>
            </div>
        </div>
        
        <div class="p-0 bg-gray-50/50">
            <!-- Iframe to safely render the email HTML -->
            <iframe srcdoc="{{ $emailLog->body }}" class="w-full min-h-[600px] border-0" sandbox="allow-same-origin"></iframe>
        </div>
    </div>
</div>
@endsection
