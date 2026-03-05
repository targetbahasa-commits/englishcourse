<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>System Settings - {{ config('app.name', 'Target Bahasa') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-gray-100">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md fixed h-full z-10 hidden md:block">
            <div class="p-6 flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center text-white font-bold">TB</div>
                <span class="text-xl font-bold text-gray-800">Target Bahasa</span>
            </div>
            
            @include('components.admin-sidebar')

            <div class="absolute bottom-8 px-6 w-full">
                 <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 px-4 py-3 text-gray-500 hover:bg-gray-50 rounded-xl font-medium transition w-full text-left">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Log Out
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 md:ml-64 p-8">
            <!-- Topbar -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-gray-600 bg-white border border-gray-200 rounded-lg p-2 transition shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        </a>
                        <h1 class="text-2xl font-bold text-gray-800">System Settings</h1>
                    </div>
                </div>
                
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">Administrator</p>
                        </div>
                        <div class="w-10 h-10 bg-blue-100 rounded-full overflow-hidden flex items-center justify-center text-blue-600 font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Settings Content -->
            <div x-data="{ tab: 'general' }">
                <div class="bg-white overflow-hidden shadow-sm border border-gray-100 sm:rounded-2xl flex flex-col md:flex-row min-h-[600px]">
                
                <!-- Sidebar Tabs -->
                <div class="w-full md:w-64 bg-gray-50 border-r border-gray-200">
                    <nav class="flex flex-col space-y-1 p-4" aria-label="Tabs">
                        <button @click="tab = 'general'" :class="{ 'bg-blue-50 text-blue-700 hover:text-blue-700 hover:bg-blue-100': tab === 'general', 'text-gray-900 hover:text-gray-900 hover:bg-gray-100': tab !== 'general' }" class="flex items-center px-3 py-2 text-sm font-medium rounded-md">
                            <svg class="flex-shrink-0 -ml-1 mr-3 h-5 w-5 text-gray-400" :class="{ 'text-blue-500': tab === 'general' }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                            <span class="truncate">General</span>
                        </button>

                        <button @click="tab = 'academic'" :class="{ 'bg-blue-50 text-blue-700 hover:text-blue-700 hover:bg-blue-100': tab === 'academic', 'text-gray-900 hover:text-gray-900 hover:bg-gray-100': tab !== 'academic' }" class="flex items-center px-3 py-2 text-sm font-medium rounded-md">
                            <svg class="flex-shrink-0 -ml-1 mr-3 h-5 w-5 text-gray-400" :class="{ 'text-blue-500': tab === 'academic' }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                            </svg>
                            <span class="truncate">Academic / Classes</span>
                        </button>

                        <button @click="tab = 'registration'" :class="{ 'bg-blue-50 text-blue-700 hover:text-blue-700 hover:bg-blue-100': tab === 'registration', 'text-gray-900 hover:text-gray-900 hover:bg-gray-100': tab !== 'registration' }" class="flex items-center px-3 py-2 text-sm font-medium rounded-md">
                            <svg class="flex-shrink-0 -ml-1 mr-3 h-5 w-5 text-gray-400" :class="{ 'text-blue-500': tab === 'registration' }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            <span class="truncate">Registration & Auth</span>
                        </button>
                    </nav>
                </div>

                <!-- Settings Forms Area -->
                <div class="flex-1 p-6 sm:p-8">
                    @if (session('success'))
                        <div class="mb-4 bg-green-50 border-l-4 border-green-400 p-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-green-700">
                                        {{ session('success') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf

                        <!-- General Settings Tab -->
                        <div x-show="tab === 'general'" x-cloak>
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">General Settings</h3>
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                
                                <div class="sm:col-span-6">
                                    <label for="site_name" class="block text-sm font-medium text-gray-700"> Site Name </label>
                                    <div class="mt-1">
                                        <input type="text" name="site_name" id="site_name" value="{{ $settings['site_name'] ?? 'Target Bahasa Course' }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">The primary brand name displayed on the portal.</p>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="support_email" class="block text-sm font-medium text-gray-700"> Support Email </label>
                                    <div class="mt-1">
                                        <input type="email" name="support_email" id="support_email" value="{{ $settings['support_email'] ?? 'support@targetbahasa.com' }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="support_phone" class="block text-sm font-medium text-gray-700"> Support Phone / WhatsApp </label>
                                    <div class="mt-1">
                                        <input type="text" name="support_phone" id="support_phone" value="{{ $settings['support_phone'] ?? '+62 812 3456 7890' }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                                
                            </div>
                        </div>

                        <!-- Academic Settings Tab -->
                        <div x-show="tab === 'academic'" x-cloak>
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Academic & Class Configurations</h3>
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                
                                <div class="sm:col-span-3">
                                    <label for="default_learning_mode" class="block text-sm font-medium text-gray-700"> Default Learning Mode </label>
                                    <div class="mt-1">
                                        <select id="default_learning_mode" name="default_learning_mode" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            <option value="online" {{ ($settings['default_learning_mode'] ?? '') == 'online' ? 'selected' : '' }}>Online</option>
                                            <option value="offline" {{ ($settings['default_learning_mode'] ?? '') == 'offline' ? 'selected' : '' }}>Offline</option>
                                            <option value="both" {{ ($settings['default_learning_mode'] ?? '') == 'both' ? 'selected' : '' }}>Both / Hybrid</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="guest_test_limit" class="block text-sm font-medium text-gray-700"> Guest Free Test Limit </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="number" name="guest_test_limit" id="guest_test_limit" value="{{ $settings['guest_test_limit'] ?? '3' }}" class="flex-1 focus:ring-blue-500 focus:border-blue-500 block w-full min-w-0 rounded-none rounded-l-md sm:text-sm border-gray-300">
                                        <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm"> tests </span>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="class_auto_lock_days" class="block text-sm font-medium text-gray-700"> Class Auto-Lock Period </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="number" name="class_auto_lock_days" id="class_auto_lock_days" value="{{ $settings['class_auto_lock_days'] ?? '14' }}" class="flex-1 focus:ring-blue-500 focus:border-blue-500 block w-full min-w-0 rounded-none rounded-l-md sm:text-sm border-gray-300">
                                        <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm"> days </span>
                                    </div>
                                    <p class="mt-2 text-xs text-gray-500">Days after class period ends to automatically lock all meetings.</p>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="minimum_attendance_rate" class="block text-sm font-medium text-gray-700"> Minimum Attendance Rate </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="number" name="minimum_attendance_rate" id="minimum_attendance_rate" value="{{ $settings['minimum_attendance_rate'] ?? '80' }}" class="flex-1 focus:ring-blue-500 focus:border-blue-500 block w-full min-w-0 rounded-none rounded-l-md sm:text-sm border-gray-300">
                                        <span class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm"> % </span>
                                    </div>
                                    <p class="mt-2 text-xs text-gray-500">Required attendance to pass the final assessment/get certificate.</p>
                                </div>

                            </div>
                        </div>

                        <!-- Registration Settings Tab -->
                        <div x-show="tab === 'registration'" x-cloak>
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Registration & Authentication</h3>
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                
                                <div class="sm:col-span-6 flex items-start">
                                    <div class="flex items-center h-5">
                                        <!-- Note: html checkboxes submit value 'on' if checked, else nothing. 
                                             We use a hidden input "0" so unchecked states are properly captured in bulk updates. -->
                                        <input type="hidden" name="allow_self_registration" value="0">
                                        <input id="allow_self_registration" name="allow_self_registration" type="checkbox" value="1" {{ ($settings['allow_self_registration'] ?? '1') == '1' ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="allow_self_registration" class="font-medium text-gray-700">Allow Self-Registration</label>
                                        <p class="text-gray-500">If unchecked, new users must be manually created by an Administrator.</p>
                                    </div>
                                </div>

                                <div class="sm:col-span-6 flex items-start">
                                    <div class="flex items-center h-5">
                                        <input type="hidden" name="require_email_verification" value="0">
                                        <input id="require_email_verification" name="require_email_verification" type="checkbox" value="1" {{ ($settings['require_email_verification'] ?? '0') == '1' ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                    </div>
                                    <div class="ml-3 text-sm">
                                        <label for="require_email_verification" class="font-medium text-gray-700">Require Email Verification</label>
                                        <p class="text-gray-500">Enforce email verification before allowing users to log in.</p>
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="default_new_user_role" class="block text-sm font-medium text-gray-700"> Default Registration Role </label>
                                    <div class="mt-1">
                                        <select id="default_new_user_role" name="default_new_user_role" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            <option value="guest" {{ ($settings['default_new_user_role'] ?? 'guest') == 'guest' ? 'selected' : '' }}>Guest</option>
                                            <option value="student" {{ ($settings['default_new_user_role'] ?? '') == 'student' ? 'selected' : '' }}>Student</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Sticky Footer Action -->
                        <div class="pt-8">
                            <div class="flex justify-end">
                                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Save System Settings
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
