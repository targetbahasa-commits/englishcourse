@extends('layouts.admin')

@section('title', 'Email Outbox Logs')

@section('content')
<div class="px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl md:text-3xl font-bold text-gray-900">Email Outbox Logs</h1>
        <p class="mt-1 text-sm text-gray-500">History of all emails sent by the system.</p>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto custom-scrollbar">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-gray-500 bg-gray-50/50 uppercase border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 font-semibold">Date Sent</th>
                        <th class="px-6 py-4 font-semibold">Recipient</th>
                        <th class="px-6 py-4 font-semibold">Related Context</th>
                        <th class="px-6 py-4 font-semibold">Subject</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($logs as $log)
                        <tr class="hover:bg-gray-50/50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-medium">
                                {{ $log->sent_at ? $log->sent_at->format('d M Y, H:i') : '-' }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $log->to_email }}
                                @if($log->user)
                                    <div class="mt-1 text-xs text-blue-600">
                                        <a href="{{ route('students.show', $log->user) }}" class="hover:underline">Student: {{ $log->user->name }}</a>
                                    </div>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                @if($log->related_type === 'registration_lead' && $log->registrationLead)
                                    <a href="{{ route('admin.registration-leads.show', $log->registrationLead) }}" class="inline-flex items-center gap-1 text-xs text-indigo-600 hover:underline bg-indigo-50 px-2 py-1 rounded">
                                        📋 Lead #{{ $log->registrationLead->id }}
                                    </a>
                                @elseif($log->related_type === 'payment' && $log->payment)
                                    <a href="{{ route('admin.payments.index', ['q' => $log->payment->invoice_number]) }}" class="inline-flex items-center gap-1 text-xs text-blue-600 hover:underline bg-blue-50 px-2 py-1 rounded">
                                        💳 {{ $log->payment->invoice_number }}
                                    </a>
                                @else
                                    <span class="text-xs text-gray-400">System</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-gray-900">
                                {{ Str::limit($log->subject, 50) }}
                            </td>
                            <td class="px-6 py-4">
                                @if($log->status === 'sent')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-50 text-green-700 border border-green-100">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                        Sent
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-700 border border-red-100">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        Failed
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <a href="{{ route('admin.email-logs.show', $log) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-blue-600 hover:bg-blue-50 transition" title="View Email Details">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                    <p>No email logs found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                {{ $logs->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
