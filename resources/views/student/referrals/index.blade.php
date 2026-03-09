<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Refer a Friend - {{ config('app.name', 'Target Bahasa') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="font-sans antialiased bg-[#F3F4FF]">
    @include('components.impersonation-banner')
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('components.sidebar-student')

        <!-- Main Content -->
        <main class="flex-1 md:ml-64 p-8">
            <!-- Topbar -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-800">Refer a Friend (Dapatkan Hadiah!) 🎁</h1>
                    <p class="text-gray-500 mt-1">Undang temanmu dan kumpulkan poin untuk ditukar berbagai hadiah menarik.</p>
                </div>
                
                <div class="flex items-center gap-6">
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden md:block">
                            <p class="text-sm font-bold text-gray-800">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-500">Student</p>
                        </div>
                        <div class="w-10 h-10 bg-blue-100 rounded-full overflow-hidden flex items-center justify-center text-blue-600 font-bold">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="max-w-7xl mx-auto space-y-6">

            <!-- Welcome & Link Section -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-xl overflow-hidden text-white relative">
                 <div class="absolute -top-24 -right-24 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="p-8 md:p-10 relative z-10 flex flex-col md:flex-row items-center gap-8">
                    <div class="flex-1 space-y-4">
                        <h3 class="text-3xl font-bold">Undang Teman, Dapatkan Rewards!</h3>
                        <p class="text-blue-100 text-lg">
                            Bantu temanmu meningkatkan skill bahasa Inggris mereka di Target Bahasa dan kumpulkan poin untuk ditukar dengan diskon, T-Shirt eksklusif, atau kelas gratis!
                        </p>
                        
                        <div class="mt-6">
                            <label class="block text-sm font-medium text-blue-200 mb-2">Kode Referral & Link Unik Kamu:</label>
                            <div class="flex bg-white/20 p-2 rounded-xl backdrop-blur-sm border border-white/30 items-center justify-between">
                                <span class="font-mono text-xl font-semibold pl-4">{{ $user->referral_code }}</span>
                                <input type="hidden" id="refLink" value="{{ url('/register-student?ref=' . $user->referral_code) }}">
                                <div class="flex items-center gap-2">
                                    <!-- Scan QR Code Button -->
                                    <button onclick="openScanQrModal()" class="bg-white/20 text-white hover:bg-white/30 px-3 py-2 rounded-lg transition-colors border border-white/30 flex items-center justify-center tooltip-trigger" title="Scan QR Code Teman">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </button>
                                    
                                    <!-- Show My QR Code Button -->
                                    <button onclick="openShowQrModal()" class="bg-white/20 text-white hover:bg-white/30 px-3 py-2 rounded-lg transition-colors border border-white/30 flex items-center justify-center tooltip-trigger" title="Tampilkan QR Code Saya">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm14 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                                    </button>
                                    
                                    <!-- Copy Link Button -->
                                    <button onclick="copyLink()" class="bg-white text-indigo-700 hover:bg-indigo-50 px-4 py-2 rounded-lg font-bold transition-colors flex items-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                                        <span class="hidden sm:inline">Copy Link</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Points Card -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex flex-col items-center justify-center text-center">
                    <div class="w-16 h-16 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    </div>
                    <h4 class="text-gray-500 font-medium">Poin Target Bahasa</h4>
                    <span class="text-4xl font-bold text-gray-900 mt-2">{{ $user->referral_points }}</span>
                </div>

                <!-- Stats / Instructions -->
                <div class="col-span-1 md:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h4 class="text-lg font-bold text-gray-900 mb-4">Cara Kerja</h4>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold">1</div>
                            <div>
                                <p class="font-medium text-gray-900">Bagikan Link / Kode</p>
                                <p class="text-sm text-gray-500">Berikan link unikmu ke teman. Mereka akan otomatis menggunakan kondemu saat mendaftar.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold">2</div>
                            <div>
                                <p class="font-medium text-gray-900">Temanmu Belajar di Target Bahasa</p>
                                <p class="text-sm text-gray-500">Poin akan masuk ke akunmu secara otomatis saat temanmu berhasil mendaftar dan membayar kelas pertama mereka.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-8 h-8 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center font-bold">3</div>
                            <div>
                                <p class="font-medium text-gray-900">Tukar Poin dengan Hadiah</p>
                                <p class="text-sm text-gray-500">Gunakan poinmu di katalog hadiah di bawah ini!</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            </div>

            <!-- Social Media Mission -->
            <div class="mt-8 bg-gradient-to-r from-purple-600 to-pink-600 rounded-2xl shadow-lg p-6 md:p-8 text-white relative overflow-hidden">
                <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
                <div class="relative z-10 flex flex-col md:flex-row gap-8 items-center">
                    <div class="flex-1">
                        <h3 class="text-2xl font-bold mb-2 flex items-center gap-2">
                            <svg class="w-6 h-6 text-pink-200" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path></svg>
                            Misi Spesial: Share & Dapatkan Diskon
                        </h3>
                        <p class="text-purple-100 mb-4">
                            Buat video atau post review belajar di Target Bahasa lalu upload ke <strong>TikTok, Instagram, atau YouTube</strong>. 
                            Kirimkan link postingan kamu di bawah ini. Tim kami akan memberikan <strong>+100 Poin Ekstra</strong> yang bisa langsung ditukar dengan Voucher Diskon!
                        </p>
                        
                        <form action="{{ route('student.referrals.social.submit') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                            @csrf
                            <select name="platform" class="px-4 py-3 rounded-xl border border-white/20 bg-white/10 text-white backdrop-blur-sm focus:outline-none focus:ring-2 focus:ring-white/50 text-sm [&>option]:text-gray-900" required>
                                <option value="" disabled selected>Pilih Platform</option>
                                <option value="tiktok">TikTok</option>
                                <option value="instagram">Instagram</option>
                                <option value="youtube">YouTube</option>
                                <option value="other">Platform Lain</option>
                            </select>
                            
                            <input type="url" name="url" placeholder="https://tiktok.com/@kamu/video/..." class="flex-1 px-4 py-3 rounded-xl border border-white/20 bg-white/10 text-white placeholder-purple-200 backdrop-blur-sm focus:outline-none focus:ring-2 focus:ring-white/50 text-sm" required>
                            
                            <button type="submit" class="bg-white text-purple-700 hover:bg-purple-50 px-6 py-3 rounded-xl font-bold transition-colors shadow-sm whitespace-nowrap">
                                Kirim Link
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Social Media Submission History -->
            @if($socialSubmissions->count() > 0)
            <div class="mt-4 bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                <h4 class="text-sm font-bold text-gray-800 mb-3">Status Pengiriman URL Anda</h4>
                <div class="space-y-2">
                    @foreach($socialSubmissions as $submission)
                        <div class="flex items-center justify-between text-sm p-3 bg-gray-50 rounded-lg border border-gray-100">
                            <div class="flex items-center gap-3">
                                <span class="capitalize font-semibold text-gray-700 w-20">{{ $submission->platform }}</span>
                                <a href="{{ $submission->url }}" target="_blank" class="text-blue-600 hover:underline truncate w-40 sm:w-64">{{ $submission->url }}</a>
                            </div>
                            <div>
                                @if($submission->status === 'pending')
                                    <span class="px-2.5 py-1 rounded-full bg-yellow-100 text-yellow-800 text-xs font-bold">Menunggu Validasi</span>
                                @elseif($submission->status === 'approved')
                                    <span class="px-2.5 py-1 rounded-full bg-green-100 text-green-800 text-xs font-bold">Disetujui (+{{ $submission->points_awarded }} Pts)</span>
                                @else
                                    <span class="px-2.5 py-1 rounded-full bg-red-100 text-red-800 text-xs font-bold tooltip-trigger" title="{{ $submission->admin_note }}">Ditolak</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Rewards Catalog -->
            <div class="mt-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Katalog Hadiah</h3>
                
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 text-green-800 border-l-4 border-green-500 rounded-r-lg">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 text-red-800 border-l-4 border-red-500 rounded-r-lg">
                        {{ session('error') }}
                    </div>
                @endif
                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 text-red-800 border-l-4 border-red-500 rounded-r-lg">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($rewards as $reward)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow flex flex-col h-full">
                            <div class="h-32 bg-gray-50 flex-shrink-0 relative border-b border-gray-100">
                                @if($reward->image)
                                    <img src="{{ asset('storage/' . $reward->image) }}" alt="{{ $reward->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center">
                                        <!-- Placeholder Image/Icon for Reward -->
                                        <svg class="w-16 h-16 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"></path></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="p-6 flex-1 flex flex-col">
                                <h4 class="font-bold text-lg text-gray-900 mb-2">{{ $reward->name }}</h4>
                                <p class="text-gray-500 text-sm mb-4 leading-relaxed flex-1">{{ $reward->description }}</p>
                                
                                <div class="flex items-center justify-between mt-4">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 text-sm font-semibold">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        {{ $reward->points_required }} Pts
                                    </span>
                                    
                                    @if($user->referral_points >= $reward->points_required)
                                        <button onclick="openClaimModal({{ $reward->id }}, '{{ addslashes($reward->name) }}')" class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-semibold hover:bg-indigo-700 transition-colors">
                                            Klaim Hadiah
                                        </button>
                                    @else
                                        <button disabled class="px-4 py-2 bg-gray-100 text-gray-400 rounded-lg text-sm font-semibold cursor-not-allowed">
                                            Poin Kurang
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-span-full py-12 text-center text-gray-500">
                            Belum ada katalog hadiah yang tersedia saat ini.
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Claim History -->
             <div class="mt-8">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Riwayat Klaim</h3>
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    @if($claims->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Hadiah</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($claims as $claim)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $claim->created_at->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                            {{ $claim->reward->name ?? 'Reward Terhapus' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            @if($claim->status === 'pending')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu Diproses</span>
                                            @elseif($claim->status === 'processed' || $claim->status === 'shipped')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Berhasil Diberikan</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">{{ ucfirst($claim->status) }}</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="p-8 text-center text-gray-500">
                            Kamu belum pernah mengklaim hadiah.
                        </div>
                    @endif
                </div>
             </div>

        </div>
    </div>

    <!-- Claim Modal -->
    <div id="claimModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeClaimModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="{{ route('student.referrals.claim') }}" method="POST">
                    @csrf
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Klaim Hadiah</h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 mb-4">Kamu akan menukarkan poinmu untuk hadiah: <strong id="modalRewardName" class="text-gray-900"></strong></p>
                                    
                                    <input type="hidden" name="reward_id" id="modalRewardId" value="">
                                    
                                    <div>
                                        <label for="shipping_address" class="block text-sm font-medium text-gray-700">Detail Pengiriman / Catatan</label>
                                        <p class="text-xs text-gray-500 mb-2">Jika kamu mengklaim barang fisik, cantumkan alamat dan ukuran (jika kaos). Jika diskon, tulis "Terapkan Diskon".</p>
                                        <textarea id="shipping_address" name="shipping_address" rows="3" class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md" placeholder="Contoh: Jl. Merdeka No 1, Bandung. Ukuran Kaos: L"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Kirim Permintaan
                        </button>
                        <button type="button" onclick="closeClaimModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

        <!-- Show QR Modal -->
        <div id="showQrModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeShowQrModal()"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                
                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-sm sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 text-center">
                        <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4" id="modal-title">QR Code Referral Anda</h3>
                        <div class="bg-white p-4 rounded-xl border border-gray-100 inline-block shadow-sm">
                            <!-- QR Code generation via api.qrserver.com -->
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data={{ urlencode(url('/register-student?ref=' . $user->referral_code)) }}" alt="QR Code Referral" class="mx-auto rounded-lg">
                        </div>
                        <p class="text-sm text-gray-500 mt-4">Minta teman Anda untuk memindai kode QR ini saat mendaftar.</p>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                        <button type="button" onclick="closeShowQrModal()" class="w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm transition-colors">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scan QR Modal -->
        <div id="scanQrModal" class="fixed inset-0 z-50 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeScanQrModal()"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                
                <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 text-center">
                        <h3 class="text-lg leading-6 font-bold text-gray-900 mb-4" id="modal-title">Scan Kode Referral Teman</h3>
                        <div id="reader" class="mx-auto w-full max-w-sm rounded-xl overflow-hidden border border-gray-100 mb-2"></div>
                        <p class="text-sm text-gray-500 mt-4">Arahkan kamera ke QR Code pendaftaran milik teman Anda.</p>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-gray-100">
                        <button type="button" onclick="closeScanQrModal()" class="w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:w-auto sm:text-sm transition-colors">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </main>
    </div>

    <!-- HTML5 QR Code Library -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        function copyLink() {
            var copyText = document.getElementById("refLink");
            copyText.type = 'text'; // temporarily unhide to copy
            copyText.select();
            copyText.setSelectionRange(0, 99999); // For mobile devices
            navigator.clipboard.writeText(copyText.value);
            copyText.type = 'hidden';
            alert("Link berhasil disalin! Bagikan ke temanmu sekarang.");
        }

        function openClaimModal(id, name) {
            document.getElementById('modalRewardId').value = id;
            document.getElementById('modalRewardName').innerText = name;
            document.getElementById('claimModal').classList.remove('hidden');
        }

        function closeClaimModal() {
            document.getElementById('claimModal').classList.add('hidden');
        }

        // Show QR Modal
        function openShowQrModal() {
            document.getElementById('showQrModal').classList.remove('hidden');
        }

        function closeShowQrModal() {
            document.getElementById('showQrModal').classList.add('hidden');
        }

        // Scan QR Modal
        let html5QrcodeScanner = null;

        function openScanQrModal() {
            document.getElementById('scanQrModal').classList.remove('hidden');
            
            if (!html5QrcodeScanner) {
                html5QrcodeScanner = new Html5QrcodeScanner(
                    "reader", { fps: 10, qrbox: 250, aspectRatio: 1.0 });
            }
            
            html5QrcodeScanner.render(onScanSuccess, onScanError);
        }

        function closeScanQrModal() {
            document.getElementById('scanQrModal').classList.add('hidden');
            if (html5QrcodeScanner) {
                html5QrcodeScanner.clear().catch(error => {
                    console.error("Failed to clear html5QrcodeScanner. ", error);
                });
            }
        }

        function onScanSuccess(decodedText, decodedResult) {
            // Berhasil scan
            closeScanQrModal();
            console.log(`Scan result: ${decodedText}`);
            
            if (decodedText.includes('register-student')) {
                if (confirm('Link referral terdeteksi!\n\nApakah Anda ingin membuka halaman pendaftaran dari teman Anda?')) {
                    window.open(decodedText, '_blank');
                }
            } else {
                alert('Teks dari QR Code:\n' + decodedText);
            }
        }

        function onScanError(errorMessage) {
            // Bisa diabaikan krn sering terpanggil saat QR blm terdeteksi secara valid
        }
    </script>
</body>
</html>
