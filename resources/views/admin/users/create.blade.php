@extends('layouts.admin')

@section('content')
<div class="p-8 pb-24 max-w-4xl mx-auto">
    <!-- Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Add New User</h1>
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
                            <span class="ml-1 text-sm font-medium text-gray-800 md:ml-2">Add New</span>
                        </div>
                    </li>
                </ol>
            </nav>
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden text-gray-800">
        <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.users._form', ['submitText' => 'Create User'])
        </form>
    </div>
</div>
@endsection
