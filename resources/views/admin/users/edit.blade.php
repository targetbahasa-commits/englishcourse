@extends('layouts.admin')

@section('content')
<div class="p-8 pb-24 max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Edit User</h1>
            <nav class="flex mt-2" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('users.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-blue-600 transition-colors">
                            Users
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            <span class="ml-1 text-sm font-medium text-gray-800 md:ml-2">Edit User</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden text-gray-800">
        <form action="{{ route('users.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.users._form', ['submitText' => 'Update User Profile'])
        </form>
    </div>

    @if($user->role === 'intern')
    <div class="mt-8 bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden text-gray-800">
        <div class="p-8 border-b border-gray-100 bg-blue-50/50">
            <h2 class="text-xl font-bold text-gray-900">Intern Permissions</h2>
            <p class="text-sm text-gray-500 mt-1">Select the administrative areas this intern is allowed to access.</p>
        </div>
        <form action="{{ route('users.intern-permissions.update', $user) }}" method="POST" class="p-8">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6">
                @php
                    $availablePermissions = [
                        'manage_payments' => 'Manage Payments',
                        'manage_announcements' => 'Manage Announcements',
                        'manage_users' => 'Manage Users (Students, Teachers, etc.)',
                        'view_reports' => 'View Reports & Attendance',
                        'manage_programs' => 'Manage Programs & Camps',
                    ];
                @endphp
                
                @foreach($availablePermissions as $key => $label)
                <label class="flex items-center p-4 border rounded-xl hover:bg-gray-50 cursor-pointer transition-colors">
                    <input type="checkbox" name="permissions[]" value="{{ $key }}" class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500" {{ $user->hasInternPermission($key) ? 'checked' : '' }}>
                    <span class="ml-3 text-sm font-medium text-gray-700">{{ $label }}</span>
                </label>
                @endforeach
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-md hover:bg-blue-700 hover:shadow-lg transition">
                    Save Permissions
                </button>
            </div>
        </form>
    </div>
    @endif
</div>
@endsection
