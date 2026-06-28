@extends('layouts.dashboard')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-9xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.broadcast-messages.index') }}" class="p-2 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 text-gray-500 transition">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">New Broadcast Message</h1>
                <p class="text-gray-500 mt-1">Compose a message and select the delivery channels.</p>
            </div>
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-4xl">
        <form action="{{ route('admin.broadcast-messages.store') }}" method="POST" class="p-6 sm:p-8 space-y-6">
            @csrf

            <!-- Audience Setup -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Target Audience
                </h3>
                <div class="grid sm:grid-cols-4 gap-4">
                    <label class="relative flex cursor-pointer rounded-xl border border-gray-200 bg-gray-50/50 p-4 shadow-sm hover:bg-gray-50/80 hover:border-blue-300 focus:outline-none transition has-[:checked]:bg-blue-50 has-[:checked]:border-blue-600 has-[:checked]:ring-1 has-[:checked]:ring-blue-600">
                        <input type="radio" name="target_role" value="all" class="sr-only" checked>
                        <span class="flex flex-1 items-center justify-center">
                            <span class="flex flex-col text-center">
                                <span class="block text-sm font-semibold text-gray-900 mb-1">All Users</span>
                                <span class="block text-xs text-gray-500 font-medium">Students & Teachers</span>
                            </span>
                        </span>
                        <svg class="w-5 h-5 flex-shrink-0 text-blue-600 absolute top-3 right-3 hidden peer-checked:block" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    </label>
                    <label class="relative flex cursor-pointer rounded-xl border border-gray-200 bg-gray-50/50 p-4 shadow-sm hover:bg-gray-50/80 hover:border-blue-300 focus:outline-none transition has-[:checked]:bg-blue-50 has-[:checked]:border-blue-600 has-[:checked]:ring-1 has-[:checked]:ring-blue-600">
                        <input type="radio" name="target_role" value="student" class="sr-only">
                        <span class="flex flex-1 items-center justify-center">
                            <span class="flex flex-col text-center">
                                <span class="block text-sm font-semibold text-gray-900 mb-1">Students Only</span>
                                <span class="block text-xs text-gray-500 font-medium">All active learners</span>
                            </span>
                        </span>
                    </label>
                    <label class="relative flex cursor-pointer rounded-xl border border-gray-200 bg-gray-50/50 p-4 shadow-sm hover:bg-gray-50/80 hover:border-blue-300 focus:outline-none transition has-[:checked]:bg-blue-50 has-[:checked]:border-blue-600 has-[:checked]:ring-1 has-[:checked]:ring-blue-600">
                        <input type="radio" name="target_role" value="teacher" class="sr-only">
                        <span class="flex flex-1 items-center justify-center">
                            <span class="flex flex-col text-center">
                                <span class="block text-sm font-semibold text-gray-900 mb-1">Teachers Only</span>
                                <span class="block text-xs text-gray-500 font-medium">Instructors & Staff</span>
                            </span>
                        </span>
                    </label>
                    <label id="leadTargetOption" class="relative flex cursor-pointer rounded-xl border border-gray-200 bg-gray-50/50 p-4 shadow-sm hover:bg-gray-50/80 hover:border-orange-300 focus:outline-none transition has-[:checked]:bg-orange-50 has-[:checked]:border-orange-500 has-[:checked]:ring-1 has-[:checked]:ring-orange-500">
                        <input type="radio" name="target_role" value="lead" id="targetLead" class="sr-only">
                        <span class="flex flex-1 items-center justify-center">
                            <span class="flex flex-col text-center">
                                <span class="block text-sm font-semibold text-gray-900 mb-1">Registration Leads</span>
                                <span class="block text-xs text-orange-600 font-medium">Unconverted inquiries</span>
                            </span>
                        </span>
                    </label>
                </div>

                <!-- Lead target warning -->
                <div id="leadWarning" class="hidden mt-3 p-3 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-800 flex items-start gap-2">
                    <svg class="w-4 h-4 text-amber-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    <div>
                        <strong>Note:</strong> For Registration Leads, <strong>In-App Inbox</strong> is not available (leads don't have accounts). 
                        <strong>Email</strong> will only be sent to leads who have an email address. 
                        <strong>WhatsApp</strong> will be sent to all leads with a WhatsApp number.
                    </div>
                </div>
                @error('target_role')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <hr class="border-gray-100">

            <!-- Message Content Setup -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 flex-shrink-0 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    Message Content
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Broadcast Title</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-colors placeholder-gray-400" placeholder="e.g. New Schedule Update for March">
                        @error('title')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Message Body</label>
                        <p class="text-xs text-gray-500 mb-2 font-medium">For WhatsApp, formatting like *bold* and _italic_ is supported.</p>
                        <textarea id="content" name="content" rows="6" required class="w-full px-4 py-3 bg-gray-50 border border-gray-200 text-gray-900 rounded-xl focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-colors placeholder-gray-400" placeholder="Type your broadcast message here..."></textarea>
                        @error('content')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <hr class="border-gray-100">

            <!-- Delivery Channels -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 flex-shrink-0 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    Delivery Channels
                </h3>
                <div class="space-y-3 bg-gray-50/50 border border-gray-100 rounded-xl p-5">
                    <!-- In-App Inbox -->
                    <label class="flex items-start gap-3 cursor-pointer p-2 hover:bg-white rounded-lg transition">
                        <div class="flex items-center h-5 mt-0.5">
                            <input type="checkbox" name="send_via_inbox" value="1" {{ old('send_via_inbox', true) ? 'checked' : '' }} class="w-4.5 h-4.5 flex-shrink-0 text-blue-600 bg-white border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
                        </div>
                        <div class="flex-1">
                            <span class="block text-sm font-semibold text-gray-900">In-App Inbox (Default)</span>
                            <span class="block text-xs text-gray-500 mt-0.5 font-medium">Sends to the user's dashboard notifications bell.</span>
                        </div>
                    </label>

                    <!-- Email -->
                    <label class="flex items-start gap-3 cursor-pointer p-2 hover:bg-white rounded-lg transition">
                        <div class="flex items-center h-5 mt-0.5">
                            <input type="checkbox" name="send_via_email" value="1" {{ old('send_via_email') ? 'checked' : '' }} class="w-4.5 h-4.5 flex-shrink-0 text-orange-600 bg-white border-gray-300 rounded focus:ring-orange-500 focus:ring-2">
                        </div>
                        <div class="flex-1">
                            <span class="block text-sm font-semibold text-gray-900">Email Blast <span class="bg-orange-100 text-orange-700 text-[10px] px-1.5 py-0.5 rounded ml-1 font-bold">SMTP</span></span>
                            <span class="block text-xs text-gray-500 mt-0.5 font-medium">Sends an email directly to their registered email address.</span>
                        </div>
                    </label>

                    <!-- WhatsApp -->
                    <label class="flex items-start gap-3 cursor-pointer p-2 hover:bg-white rounded-lg transition">
                        <div class="flex items-center h-5 mt-0.5">
                            <input type="checkbox" name="send_via_whatsapp" value="1" {{ old('send_via_whatsapp') ? 'checked' : '' }} class="w-4.5 h-4.5 flex-shrink-0 text-emerald-600 bg-white border-gray-300 rounded focus:ring-emerald-500 focus:ring-2">
                        </div>
                        <div class="flex-1">
                            <span class="block text-sm font-semibold text-gray-900">WhatsApp Broadcast <span class="bg-emerald-100 text-emerald-700 text-[10px] px-1.5 py-0.5 rounded ml-1 font-bold">API</span></span>
                            <span class="block text-xs text-gray-500 mt-0.5 font-medium">Sends a WhatsApp message if they have a valid phone number.</span>
                        </div>
                    </label>
                </div>
                @if($errors->has('channels'))
                    <p class="mt-2 text-sm text-red-600 font-medium">Please select at least one delivery channel.</p>
                @endif
            </div>

            <!-- Submit -->
            <div class="pt-6 flex justify-end gap-3 mt-8 border-t border-gray-100">
                <a href="{{ route('admin.broadcast-messages.index') }}" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-200 rounded-xl shadow-sm hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-xl shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                    Send Broadcast Now
                </button>
            </div>
            
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Show/hide lead warning based on target_role selection
    const radios = document.querySelectorAll('input[name="target_role"]');
    const leadWarning = document.getElementById('leadWarning');
    const inboxCheckbox = document.querySelector('input[name="send_via_inbox"]');

    function handleTargetChange() {
        const selected = document.querySelector('input[name="target_role"]:checked');
        if (selected && selected.value === 'lead') {
            leadWarning.classList.remove('hidden');
            if (inboxCheckbox) {
                inboxCheckbox.checked = false;
                inboxCheckbox.disabled = true;
                inboxCheckbox.closest('label').classList.add('opacity-50', 'cursor-not-allowed');
            }
        } else {
            leadWarning.classList.add('hidden');
            if (inboxCheckbox) {
                inboxCheckbox.disabled = false;
                inboxCheckbox.closest('label').classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }
    }

    radios.forEach(r => r.addEventListener('change', handleTargetChange));
    handleTargetChange(); // run on load
</script>
@endpush
