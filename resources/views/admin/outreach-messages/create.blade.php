@extends('layouts.admin')

@section('content')
    <div class="max-w-4xl mx-auto py-8">
        <div class="mb-6 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Create Outreach Message</h1>
                <p class="text-sm text-gray-500 mt-1">Configure an automated message based on a user's Free Test score</p>
            </div>
            <a href="{{ route('admin.outreach-messages.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-1 font-medium text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to List
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <form action="{{ route('admin.outreach-messages.store') }}" method="POST" class="p-6 sm:p-8">
                @csrf

                <div class="space-y-6">
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Test Type -->
                        <div>
                            <label for="test_type" class="block text-sm font-semibold text-gray-700 mb-1">Test Type <span class="text-red-500">*</span></label>
                            <select id="test_type" name="test_type" required class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out p-3 bg-white">
                                <option value="toefl_itp" {{ old('test_type') == 'toefl_itp' ? 'selected' : '' }}>TOEFL ITP</option>
                                <option value="ielts_academic" {{ old('test_type') == 'ielts_academic' ? 'selected' : '' }}>IELTS Academic</option>
                                <option value="ielts_general" {{ old('test_type') == 'ielts_general' ? 'selected' : '' }}>IELTS General</option>
                                <option value="pte_academic" {{ old('test_type') == 'pte_academic' ? 'selected' : '' }}>PTE Academic</option>
                            </select>
                            @error('test_type')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Target Role -->
                        <div>
                            <label for="target_role" class="block text-sm font-semibold text-gray-700 mb-1">Target Role <span class="text-red-500">*</span></label>
                            <select id="target_role" name="target_role" required class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out p-3 bg-white">
                                <option value="guest" {{ old('target_role') == 'guest' ? 'selected' : '' }}>Guest (For Class Enrollment)</option>
                                <option value="student" {{ old('target_role') == 'student' ? 'selected' : '' }}>Student (For Upselling/Recommendation)</option>
                            </select>
                            @error('target_role')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Min Score -->
                        <div>
                            <label for="min_score" class="block text-sm font-semibold text-gray-700 mb-1">Minimum Score <span class="text-red-500">*</span></label>
                            <input type="number" step="0.5" min="0" name="min_score" id="min_score" value="{{ old('min_score') }}" required
                                class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out p-3" 
                                placeholder="e.g., 0">
                            @error('min_score')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Max Score -->
                        <div>
                            <label for="max_score" class="block text-sm font-semibold text-gray-700 mb-1">Maximum Score <span class="text-red-500">*</span></label>
                            <input type="number" step="0.5" min="0" name="max_score" id="max_score" value="{{ old('max_score') }}" required
                                class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out p-3" 
                                placeholder="e.g., 400">
                            @error('max_score')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="bg-blue-50 rounded-lg p-4 my-2 border border-blue-100 text-sm text-blue-800">
                        <strong>Tip:</strong> If a test score is between the Minimum and Maximum (inclusive), this message will be displayed!
                    </div>

                    <!-- Content -->
                    <div>
                        <label for="message_content" class="block text-sm font-semibold text-gray-700 mb-1">Outreach Message Content <span class="text-red-500">*</span></label>
                        <p class="text-xs text-gray-500 mb-2">Write the promotional or recommendation message that the user will see. You can advise them on what class they need based on this score bracket.</p>
                        <textarea id="message_content" name="message_content" rows="6" required
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 transition duration-150 ease-in-out p-3" 
                            placeholder="e.g., Based on your score, we highly recommend our Intensive Foundation Class to master the basics before attempting the more advanced material..."></textarea>
                        @error('message_content')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

                <div class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-end gap-3">
                    <a href="{{ route('admin.outreach-messages.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Save Message
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
