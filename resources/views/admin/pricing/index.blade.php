<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pricing Management | {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/brand/icon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .price-input:focus { outline: none; box-shadow: 0 0 0 3px rgba(99,102,241,0.25); }
        .card-hover { transition: all .2s ease; }
        .card-hover:hover { transform: translateY(-2px); box-shadow: 0 8px 30px rgba(0,0,0,.1); }
        .save-btn { transition: all .15s ease; }
        .save-btn:hover { transform: scale(1.02); }
        .tab-active { background: linear-gradient(135deg, #6366f1, #8b5cf6); color: white; }
        .success-toast { animation: slideIn .3s ease; }
        @keyframes slideIn { from { transform: translateX(120%); opacity: 0; } to { transform: translateX(0); opacity: 1; } }
        .edition-card { background: linear-gradient(135deg, #f8f9ff 0%, #ffffff 100%); }
        .online-card { background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%); }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    @include('components.impersonation-banner')

    <div class="flex min-h-screen relative">
        {{-- Sidebar --}}
        @include('components.sidebar-admin')

        {{-- Main Content --}}
        <main class="flex-1 md:ml-64 p-6 lg:p-8">

            {{-- Page Header --}}
            <div class="mb-8">
                <div class="flex items-center gap-4 mb-2">
                    <div class="p-3 bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 rounded-2xl shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Pricing Management</h1>
                        <p class="text-gray-500 text-sm mt-0.5">Kelola harga Mock Test &amp; Online Test secara terpusat</p>
                    </div>
                </div>

                {{-- Success / Error Flash --}}
                @if(session('success'))
                <div id="successToast" class="success-toast flex items-center gap-3 mt-4 px-5 py-3.5 bg-green-50 border border-green-200 rounded-xl text-green-800 text-sm font-medium max-w-xl">
                    <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('success') }}
                </div>
                @endif
                @if(session('error'))
                <div class="flex items-center gap-3 mt-4 px-5 py-3.5 bg-red-50 border border-red-200 rounded-xl text-red-800 text-sm font-medium max-w-xl">
                    <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                    </svg>
                    {{ session('error') }}
                </div>
                @endif
            </div>

            {{-- Tabs --}}
            <div class="flex gap-2 mb-6" x-data="{ tab: 'mocktest' }">
                <button @click="tab = 'mocktest'"
                    :class="tab === 'mocktest' ? 'tab-active shadow-md' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200'"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold text-sm transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    Mock Test
                </button>
                <button @click="tab = 'onlinetest'"
                    :class="tab === 'onlinetest' ? 'tab-active shadow-md' : 'bg-white text-gray-600 hover:bg-gray-50 border border-gray-200'"
                    class="flex items-center gap-2 px-5 py-2.5 rounded-xl font-semibold text-sm transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Online Test
                </button>

                {{-- ========== MOCK TEST TAB ========== --}}
                <div x-show="tab === 'mocktest'" x-cloak class="w-full">
                </div>
                <div x-show="tab === 'onlinetest'" x-cloak class="w-full">
                </div>
            </div>

            {{-- ============================================================
                 MOCK TEST SECTION: Cambridge IELTS
                 ============================================================ --}}
            <div x-data="{ tab: 'mocktest' }">

            {{-- Cambridge IELTS --}}
            <div class="mb-10">
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-1.5 h-8 bg-gradient-to-b from-purple-500 to-indigo-500 rounded-full"></div>
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">IELTS Academic – Cambridge Mock Test</h2>
                            <p class="text-sm text-gray-500">Atur harga Full Edition (semua 4 test) dan Per Test (per 1 test)</p>
                        </div>
                    </div>
                    <div class="hidden lg:flex items-center gap-2 text-xs text-gray-400 bg-gray-50 px-4 py-2 rounded-xl border">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Klik <strong class="mx-0.5">Simpan</strong> di setiap bagian untuk menyimpan perubahan
                    </div>
                </div>

                @foreach($cambridgeEditions as $edition)
                <form action="{{ route('admin.pricing.mock-test.update') }}" method="POST" class="mb-6">
                    @csrf
                    @method('PATCH')
                    <div class="edition-card border border-indigo-100 rounded-2xl p-5 card-hover shadow-sm">
                        {{-- Edition Header --}}
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-indigo-100 to-purple-100 rounded-xl flex items-center justify-center">
                                    <span class="text-indigo-700 font-bold text-sm">C{{ $edition['edition'] }}</span>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800">Cambridge {{ $edition['edition'] }} Mock Test</h3>
                                    <p class="text-xs text-gray-400">{{ $edition['package']->slug }}</p>
                                </div>
                            </div>
                            <button type="submit"
                                class="save-btn flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white rounded-xl text-sm font-semibold shadow-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Simpan C{{ $edition['edition'] }}
                            </button>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">
                            {{-- Full Edition Package --}}
                            <div class="lg:col-span-1 bg-white border-2 border-indigo-200 rounded-xl p-4 shadow-sm">
                                <div class="flex items-center gap-1.5 mb-2">
                                    <span class="w-2 h-2 bg-indigo-500 rounded-full"></span>
                                    <label class="text-xs font-bold text-indigo-700 uppercase tracking-wider">Full Edition</label>
                                </div>
                                <p class="text-xs text-gray-400 mb-3">4 Tests + All Skills</p>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-medium text-sm">Rp</span>
                                    <input type="number" name="prices[{{ $edition['package']->id }}]"
                                        value="{{ $edition['package']->price }}"
                                        min="0" step="1000"
                                        class="price-input w-full pl-8 pr-3 py-2.5 border-2 border-indigo-100 rounded-xl text-sm font-bold text-gray-800 focus:border-indigo-400 transition">
                                </div>
                                <p class="text-xs text-indigo-500 font-medium mt-2">
                                    {{ number_format($edition['package']->price, 0, ',', '.') }}
                                </p>
                            </div>

                            {{-- Individual Tests --}}
                            @foreach($edition['tests'] as $i => $test)
                            @if($test)
                            <div class="bg-white border border-gray-200 rounded-xl p-4 shadow-sm">
                                <div class="flex items-center gap-1.5 mb-2">
                                    <span class="w-2 h-2 bg-gray-400 rounded-full"></span>
                                    <label class="text-xs font-bold text-gray-600 uppercase tracking-wider">Test {{ $i + 1 }}</label>
                                </div>
                                <p class="text-xs text-gray-400 mb-3">Per Test Access</p>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-medium text-sm">Rp</span>
                                    <input type="number" name="prices[{{ $test->id }}]"
                                        value="{{ $test->price }}"
                                        min="0" step="1000"
                                        class="price-input w-full pl-8 pr-3 py-2.5 border-2 border-gray-100 rounded-xl text-sm font-semibold text-gray-800 focus:border-indigo-400 transition">
                                </div>
                                <p class="text-xs text-gray-500 font-medium mt-2">
                                    {{ number_format($test->price, 0, ',', '.') }}
                                </p>
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </form>
                @endforeach
            </div>

            {{-- TOEFL ITP Mock Packages --}}
            @if($toeflMockPrograms->isNotEmpty())
            <div class="mb-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-1.5 h-8 bg-gradient-to-b from-green-500 to-teal-500 rounded-full"></div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">TOEFL ITP – Mock Packages</h2>
                        <p class="text-sm text-gray-500">Harga akses per paket latihan TOEFL ITP</p>
                    </div>
                </div>
                <form action="{{ route('admin.pricing.mock-test.update') }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                        @foreach($toeflMockPrograms as $pkg)
                        <div class="bg-white border border-green-100 rounded-2xl p-5 card-hover shadow-sm">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 bg-gradient-to-br from-green-100 to-teal-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-800 text-sm">{{ $pkg->name }}</h3>
                                    <p class="text-xs text-gray-400">{{ $pkg->slug }}</p>
                                </div>
                            </div>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-medium text-sm">Rp</span>
                                <input type="number" name="prices[{{ $pkg->id }}]"
                                    value="{{ $pkg->price }}"
                                    min="0" step="1000"
                                    class="price-input w-full pl-8 pr-3 py-2.5 border-2 border-gray-100 rounded-xl text-sm font-bold text-gray-800 focus:border-green-400 transition">
                            </div>
                            <p class="text-xs text-gray-500 font-medium mt-2">
                                Rp {{ number_format($pkg->price, 0, ',', '.') }}
                            </p>
                        </div>
                        @endforeach
                    </div>
                    <div class="flex justify-end">
                        <button type="submit"
                            class="save-btn flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-green-500 to-teal-600 hover:from-green-600 hover:to-teal-700 text-white rounded-xl text-sm font-semibold shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan TOEFL ITP Mock
                        </button>
                    </div>
                </form>
            </div>
            @endif

            {{-- ============================================================
                 ONLINE TEST SECTION
                 ============================================================ --}}
            <div class="mb-10">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-1.5 h-8 bg-gradient-to-b from-blue-500 to-cyan-500 rounded-full"></div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-800">Online Test</h2>
                        <p class="text-sm text-gray-500">Atur harga dan status aktif/nonaktif Online Test</p>
                    </div>
                </div>

                <form action="{{ route('admin.pricing.online-test.update') }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                        @php
                            $testColors = [
                                'ielts_academic' => ['from' => 'from-blue-50', 'border' => 'border-blue-200', 'badge' => 'bg-blue-100 text-blue-700', 'dot' => 'bg-blue-500'],
                                'ielts_general'  => ['from' => 'from-green-50', 'border' => 'border-green-200', 'badge' => 'bg-green-100 text-green-700', 'dot' => 'bg-green-500'],
                                'toefl_itp'      => ['from' => 'from-purple-50', 'border' => 'border-purple-200', 'badge' => 'bg-purple-100 text-purple-700', 'dot' => 'bg-purple-500'],
                                'pte_academic'   => ['from' => 'from-orange-50', 'border' => 'border-orange-200', 'badge' => 'bg-orange-100 text-orange-700', 'dot' => 'bg-orange-500'],
                            ];
                        @endphp

                        @foreach($onlineTests as $ot)
                        @php $c = $testColors[$ot['slug']] ?? $testColors['ielts_academic']; @endphp
                        <div class="bg-white border-2 {{ $c['border'] }} rounded-2xl p-5 card-hover shadow-sm">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-3">
                                    <span class="w-2.5 h-2.5 rounded-full {{ $c['dot'] }}"></span>
                                    <h3 class="font-bold text-gray-800">{{ $ot['label'] }}</h3>
                                    <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ $c['badge'] }}">Online Test</span>
                                </div>
                                {{-- Toggle enabled --}}
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="online_enabled[{{ $ot['slug'] }}]" value="1"
                                        {{ $ot['enabled'] ? 'checked' : '' }}
                                        class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-500"></div>
                                    <span class="ml-2 text-xs font-semibold text-gray-500">{{ $ot['enabled'] ? 'Aktif' : 'Nonaktif' }}</span>
                                </label>
                            </div>

                            <div class="mb-3">
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-1.5 block">Harga Akses</label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-medium text-sm">Rp</span>
                                    <input type="number" name="online_prices[{{ $ot['slug'] }}]"
                                        value="{{ $ot['price'] }}"
                                        min="0" step="1000"
                                        placeholder="0 = gratis"
                                        class="price-input w-full pl-8 pr-3 py-2.5 border-2 border-gray-100 rounded-xl text-sm font-bold text-gray-800 focus:border-blue-400 transition">
                                </div>
                                <p class="text-xs text-gray-400 mt-1.5">
                                    @if($ot['price'] === 0)
                                        <span class="text-green-600 font-semibold">✓ Gratis (akses dengan kode batch)</span>
                                    @else
                                        Rp {{ number_format($ot['price'], 0, ',', '.') }}
                                    @endif
                                </p>
                            </div>

                            <input type="hidden" name="online_prices[{{ $ot['slug'] }}]" value="0">
                        </div>
                        @endforeach
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="save-btn flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-500 to-cyan-600 hover:from-blue-600 hover:to-cyan-700 text-white rounded-xl text-sm font-semibold shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Online Test
                        </button>
                    </div>
                </form>
            </div>

            </div>{{-- end x-data --}}

        </main>
    </div>

    <script>
        // Auto-format price display on input change
        document.querySelectorAll('input[type=number]').forEach(input => {
            input.addEventListener('change', function() {
                const preview = this.closest('.relative')?.nextElementSibling;
                if (preview && preview.tagName === 'P') {
                    const val = parseInt(this.value) || 0;
                    preview.textContent = 'Rp ' + val.toLocaleString('id-ID');
                    preview.className = 'text-xs font-medium mt-2 ' + (val === 0 ? 'text-green-600' : 'text-gray-500');
                }
            });
        });

        // Auto dismiss toast after 4s
        const toast = document.getElementById('successToast');
        if (toast) setTimeout(() => { toast.style.opacity = 0; toast.style.transition = 'opacity .5s'; setTimeout(() => toast.remove(), 500); }, 4000);
    </script>
</body>
</html>
