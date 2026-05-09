<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profile - {{ config('app.name', 'Target Bahasa') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">

        @php
            $profileRole = strtolower($user->active_role ?? 'student');
        @endphp

        {{-- Sidebar --}}
        @if($profileRole === 'admin')
            @include('components.sidebar-admin')
        @elseif($profileRole === 'teacher')
            @include('components.sidebar-teacher')
        @elseif(in_array($profileRole, ['guest', 'guest_quick']))
            @include('components.sidebar-guest')
        @else
            @include('components.sidebar-student')
        @endif

        {{-- Main Content --}}
        <main class="flex-1 md:ml-64 p-8">
            {{-- Header --}}
            <div class="mb-8">
                <div class="flex items-center gap-3">
                    <div class="p-3 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-2xl shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent">My Profile</h1>
                        <p class="text-gray-500 mt-1">Manage your personal information and account settings</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Left: Avatar Card --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
                        <div class="w-24 h-24 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-3xl font-bold mx-auto mb-4 shadow-lg">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">{{ $user->name }}</h2>
                        <p class="text-gray-500 text-sm mt-1">{{ $user->email }}</p>

                        <div class="mt-4">
                            @php
                                $displayRole = in_array($user->active_role, ['guest', 'guest_quick']) ? 'guest' : $user->active_role;
                                $roleColors = [
                                    'admin'   => 'bg-purple-100 text-purple-700',
                                    'teacher' => 'bg-blue-100 text-blue-700',
                                    'student' => 'bg-green-100 text-green-700',
                                    'guest'   => 'bg-gray-100 text-gray-700',
                                ];
                                $roleColor = $roleColors[$displayRole] ?? 'bg-gray-100 text-gray-700';
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $roleColor }}">
                                {{ ucfirst($displayRole) }}
                            </span>
                        </div>

                        {{-- Referral Code Card --}}
                        <div class="mt-6 bg-gradient-to-r from-indigo-50 to-blue-50 p-4 rounded-xl border border-indigo-100 relative overflow-hidden group text-left">
                           <div class="absolute -right-6 -top-6 w-24 h-24 bg-white/40 rounded-full blur-xl group-hover:bg-white/60 transition-colors pointer-events-none"></div>
                           <h4 class="text-[11px] font-bold text-indigo-800 uppercase tracking-wider mb-2 relative z-10 flex items-center gap-1.5">
                               <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path></svg>
                               Kode Referral Anda
                           </h4>
                           <div class="flex items-center justify-between bg-white rounded-lg p-2.5 border border-indigo-200/50 shadow-sm relative z-10">
                               <span class="font-mono text-base font-bold text-gray-900 tracking-widest" id="profileRefCode">{{ $user->referral_code ?? 'BELUM-ADA' }}</span>
                               <button onclick="copyProfileRef()" class="p-1.5 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 rounded-md transition-colors" title="Salin Kode">
                                   <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                               </button>
                           </div>
                           <p class="text-[10px] text-indigo-600/70 mt-2 text-center relative z-10 font-medium">Bagikan & Dapatkan Hadiah!</p>
                        </div>

                        @if($user->phone_number)
                        <div class="mt-4 pt-4 border-t border-gray-100 text-sm text-gray-500">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            {{ $user->phone_number }}
                        </div>
                        @endif

                        <div class="mt-4 pt-4 border-t border-gray-100 text-sm text-gray-400">
                            Member since {{ $user->created_at->format('F Y') }}
                        </div>
                    </div>
                </div>

                {{-- Right: Forms --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- Program Access History --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-blue-100 p-6">
                        <h3 class="text-lg font-semibold text-blue-800 mb-1">Program Access History</h3>
                        <p class="text-gray-500 text-sm mb-4">List of programs you have unlocked with an access key.</p>
                        <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead>
                                <tr class="text-left text-xs text-gray-500 uppercase border-b">
                                    <th class="py-2 pr-4">Program</th>
                                    <th class="py-2 pr-4">Granted At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->programAccesses()->with('program')->orderByDesc('granted_at')->get() as $access)
                                    <tr class="border-b last:border-0">
                                        <td class="py-2 pr-4 font-medium text-gray-800">{{ $access->program->name ?? '-' }}</td>
                                        <td class="py-2 pr-4 text-gray-600">{{ $access->granted_at ? \Carbon\Carbon::parse($access->granted_at)->format('d M Y H:i') : '-' }}</td>
                                    </tr>
                                @endforeach
                                @if($user->programAccesses()->count() === 0)
                                    <tr><td colspan="2" class="py-2 text-gray-400">No program access history yet.</td></tr>
                                @endif
                            </tbody>
                        </table>
                        </div>
                    </div>

                    {{-- Success alerts --}}
                    @if(session('status') === 'profile-updated')
                    <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Profile updated successfully!
                    </div>
                    @endif
                    @if(session('status') === 'password-updated')
                    <div class="flex items-center gap-3 bg-green-50 border border-green-200 text-green-700 px-5 py-4 rounded-2xl">
                        <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Password updated successfully!
                    </div>
                    @endif

                    {{-- Profile Information --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Profile Information</h3>
                        <p class="text-gray-500 text-sm mb-6">Update your name, email, and phone number.</p>

                        <form method="POST" action="{{ route('profile.update') }}" class="space-y-5">
                            @csrf
                            @method('PATCH')

                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name</label>
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition"
                                    required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition"
                                    required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="phone_number" class="block text-sm font-medium text-gray-700 mb-1">Phone Number <span class="text-gray-400">(optional)</span></label>
                                <input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition"
                                    placeholder="e.g. 08123456789">
                                @error('phone_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl transition shadow-sm">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Change Password --}}
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-1">Change Password</h3>
                        <p class="text-gray-500 text-sm mb-6">Ensure your account uses a strong password.</p>

                        <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
                            @csrf
                            @method('PUT')

                            <div>
                                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                                <input type="password" id="current_password" name="current_password"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition">
                                @error('current_password', 'updatePassword')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                                <input type="password" id="password" name="password"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition">
                                @error('password', 'updatePassword')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm transition">
                            </div>

                            <div class="pt-2">
                                <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-xl transition shadow-sm">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>



                </div>
            </div>
        </main>
    </div>

    <script>
        function copyProfileRef() {
            var code = document.getElementById('profileRefCode').innerText;
            if (code !== 'BELUM-ADA') {
                navigator.clipboard.writeText(code);
                alert("Kode Referral disalin: " + code);
            } else {
                alert("Kode referral belum tersedia untuk akun ini.");
            }
        }
    </script>
</body>
</html>
