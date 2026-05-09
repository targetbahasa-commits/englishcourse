<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Formulir Pendaftaran Cambridge Test – Target Bahasa</title>
    <meta name="description" content="Daftarkan diri Anda untuk mengikuti Cambridge Test bersama Target Bahasa.">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak]{display:none!important}</style>
    <style>
        body { font-family: 'Figtree', sans-serif; }
        .input-field {
            display: block;
            width: 100%;
            padding: 0.75rem 1rem 0.75rem 2.75rem;
            font-size: 0.95rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 0.75rem;
            background: #f8fafc;
            color: #1e293b;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
        }
        .input-field:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
            background: #fff;
        }
        .input-field::placeholder { color: #94a3b8; }
        .input-icon {
            position: absolute;
            left: 0.85rem;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            pointer-events: none;
        }
        .submit-btn {
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.9rem 1.5rem;
            font-size: 1rem;
            font-weight: 700;
            color: #fff;
            background: linear-gradient(135deg, #2563eb 0%, #4f46e5 100%);
            border: none;
            border-radius: 0.875rem;
            cursor: pointer;
            box-shadow: 0 4px 16px rgba(37,99,235,0.28);
            transition: transform 0.15s, box-shadow 0.15s;
            letter-spacing: 0.01em;
        }
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 24px rgba(37,99,235,0.35);
        }
        .submit-btn:active { transform: translateY(0); }
        select.input-field { padding-left: 2.75rem; appearance: none; -webkit-appearance: none; }
        /* Custom dropdown styles */
        .test-picker-btn {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 0.75rem 2.5rem 0.75rem 2.75rem;
            font-size: 0.95rem;
            border: 1.5px solid #e2e8f0;
            border-radius: 0.75rem;
            background: #f8fafc;
            color: #94a3b8;
            cursor: pointer;
            transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
            outline: none;
            text-align: left;
        }
        .test-picker-btn.selected { color: #1e293b; }
        .test-picker-btn:focus, .test-picker-btn.open {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59,130,246,0.12);
            background: #fff;
        }
        .test-dropdown {
            position: absolute;
            left: 0; right: 0;
            top: calc(100% + 6px);
            background: #fff;
            border: 1.5px solid #e2e8f0;
            border-radius: 0.875rem;
            box-shadow: 0 8px 32px rgba(30,64,175,0.12);
            z-index: 50;
            max-height: 320px;
            overflow-y: auto;
        }
        .test-group-label {
            padding: 0.5rem 1rem 0.25rem;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #94a3b8;
            background: #f8fafc;
            border-bottom: 1px solid #f1f5f9;
            position: sticky;
            top: 0;
        }
        .test-option {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            padding: 0.6rem 1rem;
            cursor: pointer;
            transition: background 0.12s;
        }
        .test-option:hover { background: #eff6ff; }
        .test-option.active { background: #dbeafe; }
        .test-option-name { font-size: 0.9rem; color: #1e293b; font-weight: 500; }
        .test-option-price {
            font-size: 0.8rem;
            font-weight: 700;
            color: #2563eb;
            white-space: nowrap;
            background: #eff6ff;
            border-radius: 0.4rem;
            padding: 0.15rem 0.5rem;
        }
        .test-option-price.free { color: #16a34a; background: #f0fdf4; }
    </style>
</head>
<body class="antialiased bg-gradient-to-br from-blue-50 via-indigo-50 to-purple-50 min-h-screen">

<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6">
    <div class="max-w-lg w-full">

        {{-- Header / Brand --}}
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-blue-600 to-indigo-600 rounded-2xl shadow-lg shadow-blue-500/30 mb-5 transform hover:scale-105 transition-transform">
                <span class="text-2xl font-bold text-white tracking-widest">TB</span>
            </a>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Daftar Cambridge Test</h1>
            <p class="mt-2 text-gray-500 text-sm max-w-sm mx-auto">
                Isi formulir di bawah ini untuk mendaftarkan diri Anda. Tim kami akan segera menghubungi Anda.
            </p>
        </div>

        {{-- Success Alert --}}
        @if(session('success'))
            <div class="mb-6 flex items-start gap-3 bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm font-medium shadow-sm">
                <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        {{-- Form Card --}}
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8 relative overflow-visible">
            {{-- Decorative blobs --}}
            <div class="absolute -top-10 -right-10 w-40 h-40 bg-blue-100 rounded-full mix-blend-multiply filter blur-2xl opacity-60 pointer-events-none"></div>
            <div class="absolute -bottom-10 -left-10 w-40 h-40 bg-indigo-100 rounded-full mix-blend-multiply filter blur-2xl opacity-60 pointer-events-none"></div>

            <form method="POST" action="{{ route('guest.cambridge-test-register.submit') }}" class="space-y-5 relative z-10">
                @csrf

                {{-- Validation Errors --}}
                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-600 rounded-xl p-4 text-sm font-medium">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Nama Lengkap --}}
                <div>
                    <label for="full_name" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Nama Lengkap <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="input-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </span>
                        <input type="text" name="full_name" id="full_name" required
                            class="input-field @error('full_name') border-red-400 @enderror"
                            placeholder="Masukkan nama lengkap Anda"
                            value="{{ old('full_name') }}">
                    </div>
                    @error('full_name')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Nomor WhatsApp --}}
                <div>
                    <label for="whatsapp" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Nomor WhatsApp Aktif <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="input-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                        </span>
                        <input type="tel" name="whatsapp" id="whatsapp" required
                            class="input-field @error('whatsapp') border-red-400 @enderror"
                            placeholder="Contoh: 08123456789"
                            value="{{ old('whatsapp') }}">
                    </div>
                    <p class="mt-1 text-xs text-gray-400">Tim kami akan menghubungi Anda melalui nomor ini.</p>
                    @error('whatsapp')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Email <span class="text-gray-400 font-normal text-xs">(opsional)</span>
                    </label>
                    <div class="relative">
                        <span class="input-icon">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </span>
                        <input type="email" name="email" id="email"
                            class="input-field @error('email') border-red-400 @enderror"
                            placeholder="nama@email.com"
                            value="{{ old('email') }}">
                    </div>
                    @error('email')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Jenis / Paket Test (custom dropdown with price) --}}
                @php
                    // Flatten all programs with group info for Alpine.js
                    $allOptions = [];
                    foreach($grouped as $groupLabel => $programs) {
                        foreach($programs as $p) {
                            $allOptions[] = [
                                'value' => $p->name,
                                'label' => $p->name,
                                'price' => $p->price,
                                'group' => $groupLabel,
                            ];
                        }
                    }
                    // Add "Belum Tahu" option
                    $allOptions[] = [
                        'value' => 'Belum Tahu / Butuh Rekomendasi',
                        'label' => 'Belum Tahu / Butuh Rekomendasi',
                        'price' => null,
                        'group' => 'Lainnya',
                    ];
                    $oldVal = old('cambridge_test', '');
                @endphp
                <div
                    x-data="testPicker({{ json_encode($allOptions) }}, {{ json_encode(array_merge(array_keys($grouped), ['Lainnya'])) }}, '{{ $oldVal }}')"
                    @click.outside="open = false"
                >
                    <label class="block text-sm font-semibold text-gray-700 mb-1.5">
                        Jenis / Paket Test <span class="text-red-500">*</span>
                    </label>

                    {{-- Hidden real input for form submit --}}
                    <input type="hidden" name="cambridge_test" :value="selected ? selected.value : ''">

                    <div class="relative">
                        {{-- Icon --}}
                        <span class="input-icon" style="pointer-events:none;z-index:2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </span>

                        {{-- Trigger button --}}
                        <button type="button"
                            @click="open = !open"
                            :class="['test-picker-btn', selected ? 'selected' : '', open ? 'open' : '']">
                            <span class="flex-1 truncate" x-text="selected ? selected.label : '-- Pilih jenis test --'"></span>
                            <span x-show="selected && selected.price !== null"
                                class="test-option-price ml-2 flex-shrink-0"
                                x-text="selected ? 'Rp ' + Number(selected.price).toLocaleString('id-ID') : ''"
                            ></span>
                        </button>

                        {{-- Chevron --}}
                        <span class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-gray-400"
                            style="transition: transform 0.2s" :style="open ? 'transform:translateY(-50%) rotate(180deg)' : ''">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </span>

                        {{-- Dropdown panel --}}
                        <div x-show="open" x-cloak
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 -translate-y-1"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            class="test-dropdown">

                            <template x-for="group in groups" :key="group">
                                <div>
                                    <div class="test-group-label" x-text="group"></div>
                                    <template x-for="opt in optionsByGroup(group)" :key="opt.value">
                                        <div
                                            class="test-option"
                                            :class="selected && selected.value === opt.value ? 'active' : ''"
                                            @click="select(opt)">
                                            <span class="test-option-name" x-text="opt.label"></span>
                                            <span
                                                class="test-option-price"
                                                :class="opt.price === null ? 'free' : ''"
                                                x-text="opt.price !== null ? 'Rp ' + Number(opt.price).toLocaleString('id-ID') : 'Hubungi Kami'"
                                            ></span>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>

                    @error('cambridge_test')
                        <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <div class="pt-2">
                    <button type="submit" class="submit-btn">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Kirim Pendaftaran
                    </button>
                </div>
            </form>

            <script>
            function testPicker(options, groups, oldValue) {
                return {
                    options,
                    groups,
                    open: false,
                    selected: oldValue ? (options.find(o => o.value === oldValue) || null) : null,
                    optionsByGroup(group) {
                        return this.options.filter(o => o.group === group);
                    },
                    select(opt) {
                        this.selected = opt;
                        this.open = false;
                    }
                };
            }
            </script>

            {{-- Footer note --}}
            <p class="mt-6 text-center text-xs text-gray-400">
                Dengan mengirimkan formulir ini, Anda menyetujui Ketentuan Layanan dan Kebijakan Privasi Target Bahasa.
            </p>
        </div>

        {{-- Back link --}}
        <p class="mt-6 text-center text-sm text-gray-500">
            <a href="/" class="font-medium text-blue-600 hover:text-blue-700 transition-colors">← Kembali ke Beranda</a>
        </p>

    </div>
</div>

</body>
</html>
