<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>System Settings - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">

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
        @include('components.sidebar-admin')

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
            <div x-data="{ tab: new URLSearchParams(location.search).get('tab') || 'general' }">
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

                        <button @click="tab = 'registration'" :class="{ 'bg-blue-50 text-blue-700 hover:text-blue-700 hover:bg-blue-100': tab === 'registration', 'text-gray-900 hover:text-gray-900 hover:bg-gray-100': tab !== 'registration' }" class="flex items-center px-3 py-2 text-sm font-medium rounded-md mt-1">
                            <svg class="flex-shrink-0 -ml-1 mr-3 h-5 w-5 text-gray-400" :class="{ 'text-blue-500': tab === 'registration' }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                            <span class="truncate">Registration & Auth</span>
                        </button>

                        <button @click="tab = 'payment'" :class="{ 'bg-blue-50 text-blue-700 hover:text-blue-700 hover:bg-blue-100': tab === 'payment', 'text-gray-900 hover:text-gray-900 hover:bg-gray-100': tab !== 'payment' }" class="flex items-center px-3 py-2 text-sm font-medium rounded-md mt-1">
                            <svg class="flex-shrink-0 -ml-1 mr-3 h-5 w-5 text-gray-400" :class="{ 'text-blue-500': tab === 'payment' }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a5 5 0 00-10 0v2M5 9h14l1 10a2 2 0 01-2 2H6a2 2 0 01-2-2L5 9z" />
                            </svg>
                            <span class="truncate">Payment Details</span>
                        </button>

                        <button @click="tab = 'frontpage'" :class="{ 'bg-blue-50 text-blue-700 hover:text-blue-700 hover:bg-blue-100': tab === 'frontpage', 'text-gray-900 hover:text-gray-900 hover:bg-gray-100': tab !== 'frontpage' }" class="flex items-center px-3 py-2 text-sm font-medium rounded-md mt-1">
                            <svg class="flex-shrink-0 -ml-1 mr-3 h-5 w-5 text-gray-400" :class="{ 'text-blue-500': tab === 'frontpage' }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z" />
                            </svg>
                            <span class="truncate">Landing Page Promos</span>
                        </button>

                        <button @click="tab = 'notifications'" :class="{ 'bg-blue-50 text-blue-700 hover:text-blue-700 hover:bg-blue-100': tab === 'notifications', 'text-gray-900 hover:text-gray-900 hover:bg-gray-100': tab !== 'notifications' }" class="flex items-center px-3 py-2 text-sm font-medium rounded-md mt-1">
                            <svg class="flex-shrink-0 -ml-1 mr-3 h-5 w-5 text-gray-400" :class="{ 'text-blue-500': tab === 'notifications' }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            <span class="truncate">Admin Notifications</span>
                        </button>

                        <button @click="tab = 'authpages'" :class="{ 'bg-blue-50 text-blue-700 hover:text-blue-700 hover:bg-blue-100': tab === 'authpages', 'text-gray-900 hover:text-gray-900 hover:bg-gray-100': tab !== 'authpages' }" class="flex items-center px-3 py-2 text-sm font-medium rounded-md mt-1">
                            <svg class="flex-shrink-0 -ml-1 mr-3 h-5 w-5 text-gray-400" :class="{ 'text-blue-500': tab === 'authpages' }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            <span class="truncate">Auth Pages Content</span>
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
                                            <option value="test-taker" {{ ($settings['default_new_user_role'] ?? '') == 'test-taker' ? 'selected' : '' }}>Test Taker</option>
                                            <option value="student" {{ ($settings['default_new_user_role'] ?? '') == 'student' ? 'selected' : '' }}>Student</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Payment Settings Tab -->
                        <div x-show="tab === 'payment'" x-cloak>
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Payment & Bank Information</h3>
                            <p class="text-sm text-gray-500 mb-6">These details will be displayed to students on their invoices for manual bank transfers.</p>
                            
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                
                                <div class="sm:col-span-3">
                                    <label for="bank_name" class="block text-sm font-medium text-gray-700"> Bank Name </label>
                                    <div class="mt-1">
                                        <input type="text" name="bank_name" id="bank_name" value="{{ $settings['bank_name'] ?? 'BCA' }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="e.g. BCA">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="bank_account_number" class="block text-sm font-medium text-gray-700"> Account Number </label>
                                    <div class="mt-1">
                                        <input type="text" name="bank_account_number" id="bank_account_number" value="{{ $settings['bank_account_number'] ?? '1234567890' }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="e.g. 1234567890">
                                    </div>
                                </div>

                                <div class="sm:col-span-6">
                                    <label for="bank_account_holder" class="block text-sm font-medium text-gray-700"> Account Holder Name </label>
                                    <div class="mt-1">
                                        <input type="text" name="bank_account_holder" id="bank_account_holder" value="{{ $settings['bank_account_holder'] ?? 'Target Bahasa Course' }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="e.g. Target Bahasa Course">
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Frontpage Promos Tab -->
                        <div x-show="tab === 'frontpage'" x-cloak>
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Landing Page Promos</h3>
                            <p class="text-sm text-gray-500 mb-6">Manage the running text and promotions displayed publicly on the landing page header.</p>
                            
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <div class="sm:col-span-6">
                                    <label for="header_running_text" class="block text-sm font-medium text-gray-700"> Header Running Text (Marquee) </label>
                                    <div class="mt-1">
                                        <textarea name="header_running_text" id="header_running_text" rows="4" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ $settings['header_running_text'] ?? '🚀 <strong>PROMO SPESIAL!</strong> Dapatkan Diskon 20% untuk Pendaftaran Kelas IELTS & TOEFL Bulan Ini! | 📝 <strong>IKUTI MOCKUP TEST!</strong> Uji Kemampuan Bahasa Inggrismu dengan Standar Internasional Sekarang Juga! | 🎓 Tingkatkan Karirmu dengan Sertifikat Target Bahasa!' }}</textarea>
                                    </div>
                                    <p class="mt-2 text-sm text-gray-500">Teks ini akan berjalan otomatis di bagian atas website. Gunakan pemisah vertikal ( <code>|</code> ) untuk memisahkan promosi. Mendukung tag <code>&lt;strong&gt;</code> untuk huruf tebal.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Notifications Tab -->
                        <div x-show="tab === 'notifications'" x-cloak>
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Admin Notifications</h3>
                            <p class="text-sm text-gray-500 mb-6">Konfigurasi penerima notifikasi pendaftaran dan pembayaran.</p>
                            
                            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-6">
                                <div class="sm:col-span-6">
                                    <label for="notification_emails" class="block text-sm font-medium text-gray-700"> Email Admin (pisahkan dengan koma) </label>
                                    <div class="mt-1">
                                        <input type="text" name="notification_emails" id="notification_emails" value="{{ $settings['notification_emails'] ?? 'targetbahasa@gmail.com' }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="admin1@example.com, admin2@example.com">
                                    </div>
                                    <p class="mt-2 text-xs text-gray-500">Email yang akan menerima notifikasi pendaftaran dan pembayaran baru.</p>
                                </div>

                                <div class="sm:col-span-6">
                                    <label for="notification_whatsapps" class="block text-sm font-medium text-gray-700"> WhatsApp Admin (pisahkan dengan koma) </label>
                                    <div class="mt-1">
                                        <input type="text" name="notification_whatsapps" id="notification_whatsapps" value="{{ $settings['notification_whatsapps'] ?? '6282228273410' }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" placeholder="628123456789, 628987654321">
                                    </div>
                                    <p class="mt-2 text-xs text-gray-500">Nomor WA yang akan menerima notifikasi pendaftaran dan pembayaran baru. (Format: 628...)</p>
                                </div>
                            </div>
                        </div>

                        <!-- Auth Pages Content Tab -->
                        <div x-show="tab === 'authpages'" x-cloak>
                            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Auth Pages Content</h3>
                            <p class="text-sm text-gray-500 mb-6">Kelola konten dan tulisan yang muncul pada halaman Pendaftaran (Signup), Login, dll.</p>
                            
                            <div class="space-y-8">
                                <!-- Pendaftaran Student -->
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="text-md font-semibold text-gray-800 border-b pb-2 flex-1">Pendaftaran Student</h4>
                                        <div class="flex items-center gap-2 bg-blue-50 border border-blue-200 px-3 py-2 rounded-lg">
                                            <code class="text-xs text-blue-700">{{ url('/student/register') }}</code>
                                            <button type="button" onclick="navigator.clipboard.writeText('{{ url('/student/register') }}').then(() => alert('Link copied!'))" class="text-blue-600 hover:text-blue-800 text-xs font-semibold">
                                                📋 Copy
                                            </button>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-6">
                                        <div class="sm:col-span-6">
                                            <label class="block text-sm font-medium text-gray-700"> Judul Halaman </label>
                                            <div class="mt-1">
                                                <input type="text" name="auth_register_student_title" value="{{ $settings['auth_register_student_title'] ?? 'Buat Akun Student' }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                        </div>
                                        <div class="sm:col-span-6">
                                            <label class="block text-sm font-medium text-gray-700"> Deskripsi Singkat </label>
                                            <div class="mt-1">
                                                <textarea name="auth_register_student_subtitle" rows="2" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ $settings['auth_register_student_subtitle'] ?? 'Daftarkan dirimu untuk mengakses kelas dan memulai perjalanan belajar bahasa Inggris.' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <h5 class="text-sm font-semibold text-gray-700 mt-6 mb-3 flex items-center justify-between">
                                        <span>Tahap 2: Pilih Kelas</span>
                                        <div class="flex items-center gap-2 bg-orange-50 border border-orange-200 px-3 py-2 rounded-lg">
                                            <code class="text-xs text-orange-700">{{ url('/student/register?step=2') }}</code>
                                            <button type="button" onclick="navigator.clipboard.writeText('{{ url('/student/register?step=2') }}').then(() => alert('Link copied!'))" class="text-orange-600 hover:text-orange-800 text-xs font-semibold">
                                                📋 Copy
                                            </button>
                                        </div>
                                    </h5>
                                    <div class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-6 border border-gray-100 bg-gray-50 p-4 rounded-xl">
                                        <div class="sm:col-span-3">
                                            <label class="block text-sm font-medium text-gray-700"> Judul Tahap 2 </label>
                                            <div class="mt-1">
                                                <input type="text" name="auth_register_step2_title" value="{{ $settings['auth_register_step2_title'] ?? 'Pilih Kelas' }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                        </div>
                                        <div class="sm:col-span-3">
                                            <label class="block text-sm font-medium text-gray-700"> Judul Tahap 2 (Tanpa Payment) </label>
                                            <div class="mt-1">
                                                <input type="text" name="auth_register_step2_title_skip_payment" value="{{ $settings['auth_register_step2_title_skip_payment'] ?? 'Pilih Kelas & Selesaikan' }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                        </div>
                                        <div class="sm:col-span-3">
                                            <label class="block text-sm font-medium text-gray-700"> Subjudul Tahap 2 </label>
                                            <div class="mt-1">
                                                <textarea name="auth_register_step2_subtitle" rows="2" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ $settings['auth_register_step2_subtitle'] ?? 'Pilih program utama yang ingin kamu ikuti.' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="sm:col-span-3">
                                            <label class="block text-sm font-medium text-gray-700"> Subjudul Tahap 2 (Tanpa Payment) </label>
                                            <div class="mt-1">
                                                <textarea name="auth_register_step2_subtitle_skip_payment" rows="2" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ $settings['auth_register_step2_subtitle_skip_payment'] ?? 'Pilih program utama yang ingin kamu ikuti, lalu langsung buat akun.' }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <h5 class="text-sm font-semibold text-gray-700 mt-6 mb-3 flex items-center justify-between">
                                        <span>Tahap 3: Pembayaran</span>
                                        <div class="flex items-center gap-2 bg-green-50 border border-green-200 px-3 py-2 rounded-lg">
                                            <code class="text-xs text-green-700">{{ url('/student/register?step=3') }}</code>
                                            <button type="button" onclick="navigator.clipboard.writeText('{{ url('/student/register?step=3') }}').then(() => alert('Link copied!'))" class="text-green-600 hover:text-green-800 text-xs font-semibold">
                                                📋 Copy
                                            </button>
                                        </div>
                                    </h5>
                                    <div class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-6 border border-gray-100 bg-gray-50 p-4 rounded-xl">
                                        <div class="sm:col-span-6">
                                            <label class="block text-sm font-medium text-gray-700"> Judul Tahap 3 </label>
                                            <div class="mt-1">
                                                <input type="text" name="auth_register_step3_title" value="{{ $settings['auth_register_step3_title'] ?? 'Tahap Pembayaran' }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                        </div>
                                        <div class="sm:col-span-6">
                                            <label class="block text-sm font-medium text-gray-700"> Subjudul Tahap 3 </label>
                                            <div class="mt-1">
                                                <textarea name="auth_register_step3_subtitle" rows="2" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ $settings['auth_register_step3_subtitle'] ?? 'Pilih metode pembayaran yang akan kamu gunakan.' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pendaftaran Kelas Umum (/daftar) -->
                                <div>
                                    <div class="flex items-center justify-between mb-3 mt-8">
                                        <h4 class="text-md font-semibold text-gray-800 border-b pb-2 flex-1">Pendaftaran Kelas Umum</h4>
                                        <div class="flex items-center gap-2 bg-blue-50 border border-blue-200 px-3 py-2 rounded-lg">
                                            <code class="text-xs text-blue-700">{{ url('/daftar') }}</code>
                                            <button type="button" onclick="navigator.clipboard.writeText('{{ url('/daftar') }}').then(() => alert('Link copied!'))" class="text-blue-600 hover:text-blue-800 text-xs font-semibold">
                                                📋 Copy
                                            </button>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-6">
                                        <div class="sm:col-span-6">
                                            <label class="block text-sm font-medium text-gray-700"> Judul Halaman </label>
                                            <div class="mt-1">
                                                <input type="text" name="auth_register_daftar_title" value="{{ $settings['auth_register_daftar_title'] ?? 'Formulir Pendaftaran Kelas' }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                        </div>
                                        <div class="sm:col-span-6">
                                            <label class="block text-sm font-medium text-gray-700"> Deskripsi Singkat </label>
                                            <div class="mt-1">
                                                <textarea name="auth_register_daftar_subtitle" rows="2" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ $settings['auth_register_daftar_subtitle'] ?? 'Isi data di bawah ini dan tim kami akan segera menghubungi kamu.' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Login Student -->
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="text-md font-semibold text-gray-800 border-b pb-2 flex-1">Login Student</h4>
                                        <div class="flex items-center gap-2 bg-purple-50 border border-purple-200 px-3 py-2 rounded-lg">
                                            <code class="text-xs text-purple-700">{{ url('/login') }}</code>
                                            <button type="button" onclick="navigator.clipboard.writeText('{{ url('/login') }}').then(() => alert('Link copied!'))" class="text-purple-600 hover:text-purple-800 text-xs font-semibold">
                                                📋 Copy
                                            </button>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-6">
                                        <div class="sm:col-span-6">
                                            <label class="block text-sm font-medium text-gray-700"> Welcome Title </label>
                                            <div class="mt-1">
                                                <input type="text" name="auth_login_student_title" value="{{ $settings['auth_login_student_title'] ?? 'Welcome Back!' }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                        </div>
                                        <div class="sm:col-span-6">
                                            <label class="block text-sm font-medium text-gray-700"> Welcome Subtitle </label>
                                            <div class="mt-1">
                                                <textarea name="auth_login_student_subtitle" rows="2" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ $settings['auth_login_student_subtitle'] ?? 'Please sign in to your student account.' }}</textarea>
                                            </div>
                                        </div>
                                        <div class="sm:col-span-6">
                                            <label class="block text-sm font-medium text-gray-700"> Main Brand Title </label>
                                            <div class="mt-1">
                                                <input type="text" name="auth_login_student_brand_title" value="{{ $settings['auth_login_student_brand_title'] ?? 'Target Bahasa' }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                        </div>
                                        <div class="sm:col-span-6">
                                            <label class="block text-sm font-medium text-gray-700"> Main Brand Description </label>
                                            <div class="mt-1">
                                                <textarea name="auth_login_student_brand_desc" rows="2" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ $settings['auth_login_student_brand_desc'] ?? 'Your journey to mastering the language starts here. Log in to access your dashboard, track progress, and continue learning.' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Guest / Free Test Pendaftaran -->
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="text-md font-semibold text-gray-800 border-b pb-2 flex-1">Pendaftaran / Login Guest (Free Test)</h4>
                                        <div class="flex items-center gap-1">
                                            <div class="flex items-center gap-2 bg-pink-50 border border-pink-200 px-3 py-2 rounded-lg">
                                                <code class="text-xs text-pink-700">{{ url('/guest/register') }}</code>
                                                <button type="button" onclick="navigator.clipboard.writeText('{{ url('/guest/register') }}').then(() => alert('Link copied!'))" class="text-pink-600 hover:text-pink-800 text-xs font-semibold">
                                                    📋 Copy
                                                </button>
                                            </div>
                                            <div class="flex items-center gap-2 bg-indigo-50 border border-indigo-200 px-3 py-2 rounded-lg">
                                                <code class="text-xs text-indigo-700">{{ url('/guest/login') }}</code>
                                                <button type="button" onclick="navigator.clipboard.writeText('{{ url('/guest/login') }}').then(() => alert('Link copied!'))" class="text-indigo-600 hover:text-indigo-800 text-xs font-semibold">
                                                    📋 Copy
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-6">
                                        <div class="sm:col-span-6">
                                            <label class="block text-sm font-medium text-gray-700"> Main Title / Headline </label>
                                            <div class="mt-1">
                                                <textarea name="auth_register_guest_title" rows="2" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ $settings['auth_register_guest_title'] ?? "FREE TOEFL<br><span class=\"text-transparent bg-clip-text bg-gradient-to-r from-blue-200 to-indigo-100\">PREDICTION TEST</span>" }}</textarea>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1">Gunakan tag &lt;br&gt; dan &lt;span&gt; untuk mengatur desain warna jika perlu.</p>
                                        </div>
                                        <div class="sm:col-span-6">
                                            <label class="block text-sm font-medium text-gray-700"> Subtitle </label>
                                            <div class="mt-1">
                                                <textarea name="auth_register_guest_subtitle" rows="2" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ $settings['auth_register_guest_subtitle'] ?? 'Test your English level in 30 minutes.' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Login Teacher -->
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <h4 class="text-md font-semibold text-gray-800 border-b pb-2 flex-1">Login Teacher</h4>
                                        <div class="flex items-center gap-2 bg-amber-50 border border-amber-200 px-3 py-2 rounded-lg">
                                            <code class="text-xs text-amber-700">{{ url('/teacher/login') }}</code>
                                            <button type="button" onclick="navigator.clipboard.writeText('{{ url('/teacher/login') }}').then(() => alert('Link copied!'))" class="text-amber-600 hover:text-amber-800 text-xs font-semibold">
                                                📋 Copy
                                            </button>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 gap-y-4 gap-x-4 sm:grid-cols-6">
                                        <div class="sm:col-span-6">
                                            <label class="block text-sm font-medium text-gray-700"> Portal Title </label>
                                            <div class="mt-1">
                                                <input type="text" name="auth_login_teacher_title" value="{{ $settings['auth_login_teacher_title'] ?? 'Tutors Portal' }}" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                        </div>
                                        <div class="sm:col-span-6">
                                            <label class="block text-sm font-medium text-gray-700"> Portal Subtitle </label>
                                            <div class="mt-1">
                                                <textarea name="auth_login_teacher_subtitle" rows="2" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">{{ $settings['auth_login_teacher_subtitle'] ?? 'Secure access for tutors. Please log in to your account.' }}</textarea>
                                            </div>
                                        </div>
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
