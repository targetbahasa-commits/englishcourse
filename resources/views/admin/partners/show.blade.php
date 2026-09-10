@extends('layouts.admin')

@section('title', $partner->name)

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-8 w-full max-w-6xl mx-auto" x-data="{ copied: false, showAttach: false, searchQuery: '', results: [] }">

    <div class="sm:flex sm:justify-between sm:items-start mb-6">
        <div>
            <a href="{{ route('admin.partners.index') }}" class="text-sm text-gray-500 hover:text-gray-700 flex items-center gap-1 mb-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kerjasama Instansi
            </a>
            <h1 class="text-2xl md:text-3xl text-gray-800 font-bold">{{ $partner->name }}</h1>
            @if($partner->industry)
                <p class="text-sm text-gray-500 mt-1">{{ $partner->industry }}</p>
            @endif
        </div>
        <a href="{{ route('admin.partners.edit', $partner) }}" class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
            Edit Partner
        </a>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-700">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-700">{{ session('error') }}</div>
    @endif

    @if($partner->program || $partner->total_meetings || $partner->program_start_date || $partner->program_end_date)
        <!-- Program details -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-6">
            <h3 class="text-sm font-bold text-gray-800 mb-3">Detail Program Kerjasama</h3>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <div class="text-xs text-gray-500 mb-0.5">Program</div>
                    <div class="text-sm font-medium text-gray-800">{{ $partner->program->name ?? '-' }}</div>
                </div>
                <div>
                    <div class="text-xs text-gray-500 mb-0.5">Jumlah Pertemuan</div>
                    <div class="text-sm font-medium text-gray-800">{{ $partner->total_meetings ? $partner->total_meetings . ' pertemuan' : '-' }}</div>
                </div>
                <div>
                    <div class="text-xs text-gray-500 mb-0.5">Periode</div>
                    <div class="text-sm font-medium text-gray-800">{{ $partner->programPeriodLabelAttribute() ?? '-' }}</div>
                </div>
            </div>
        </div>
    @endif

    <!-- Stat cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
            <div class="text-2xl font-black text-gray-800">{{ $stats['employeeCount'] }}</div>
            <div class="text-sm text-gray-500">Karyawan Terdaftar</div>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
            <div class="text-2xl font-black text-gray-800">{{ $stats['enrollmentCount'] }}</div>
            <div class="text-sm text-gray-500">Total Enrollment</div>
        </div>
        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
            <div class="text-2xl font-black text-gray-800">Rp {{ number_format($stats['totalRevenue'], 0, ',', '.') }}</div>
            <div class="text-sm text-gray-500">Total Revenue Terbayar</div>
        </div>
    </div>

    <!-- Registration link -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-6">
        <h3 class="text-sm font-bold text-gray-800 mb-1">Link Pendaftaran Karyawan</h3>
        <p class="text-xs text-gray-500 mb-3">Bagikan link ini ke HR/PIC {{ $partner->name }} untuk didistribusikan ke karyawan mereka. Setiap yang mendaftar lewat link ini otomatis tertaut ke partner ini{{ $partner->discount_type ? ' dan mendapat harga korporat ('.$partner->formattedDiscountAttribute().')' : '' }}.</p>
        <div class="flex items-center gap-3">
            <input type="text" readonly id="partner-link"
                value="{{ route('partner.register', $partner->registration_code) }}"
                class="flex-1 rounded-xl border-gray-300 shadow-sm bg-gray-50 text-sm p-3 font-mono">
            <button type="button"
                @click="window.copyToClipboard(document.getElementById('partner-link').value).then(() => { copied = true; setTimeout(() => copied = false, 2000); })"
                class="px-4 py-3 rounded-xl text-sm font-medium bg-blue-600 hover:bg-blue-700 text-white transition shrink-0">
                <span x-show="!copied">Salin Link</span>
                <span x-show="copied" x-cloak>Tersalin!</span>
            </button>
        </div>
        @if(!$partner->is_active)
            <p class="mt-2 text-xs text-red-600">Link ini sedang nonaktif - karyawan tidak bisa mendaftar lewat link ini sampai partner diaktifkan kembali.</p>
        @endif
    </div>

    <!-- Certificate / Score Sheet delivery -->
    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mb-6">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h3 class="text-sm font-bold text-gray-800 mb-1">Output Hasil Kerjasama</h3>
                <p class="text-xs text-gray-500">
                    Kesepakatan output untuk {{ $partner->name }}:
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $partner->certificate_delivery_mode === 'score_sheet' ? 'bg-indigo-100 text-indigo-700' : 'bg-emerald-100 text-emerald-700' }}">
                        {{ $partner->certificateDeliveryModeLabelAttribute() }}
                    </span>
                </p>
            </div>
            <a href="{{ route('admin.partners.export-score-sheet', $partner) }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-medium bg-indigo-600 hover:bg-indigo-700 text-white transition shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                Unduh Lembar Nilai (CSV)
            </a>
        </div>
        <p class="mt-3 text-xs text-gray-400">Berisi nilai assignment (Grammar Writing & program berbasis meeting lainnya) untuk semua karyawan yang sudah submit. Untuk sertifikat, gunakan sistem sertifikat per-program yang sudah ada (Final Test, Offline Test, dsb).</p>
    </div>

    <!-- Employees -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
            <h3 class="text-sm font-bold text-gray-800">Karyawan Terdaftar</h3>
            <button type="button" @click="showAttach = !showAttach" class="text-sm text-blue-600 hover:text-blue-800 font-medium">
                <span x-show="!showAttach">+ Tautkan Siswa yang Sudah Terdaftar</span>
                <span x-show="showAttach" x-cloak>Tutup</span>
            </button>
        </div>

        <div x-show="showAttach" x-cloak class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <input type="text" x-model="searchQuery"
                @input.debounce.300ms="if (searchQuery.trim() === '') { results = []; return; } fetch('{{ route('admin.partners.search-users') }}?q=' + encodeURIComponent(searchQuery)).then(r => r.json()).then(data => results = data.users || [])"
                placeholder="Cari siswa berdasarkan nama atau email..."
                class="w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 text-sm p-3 mb-3">
            <div class="space-y-2 max-h-64 overflow-y-auto">
                <template x-for="u in results" :key="u.id">
                    <form action="{{ route('admin.partners.attach-user', $partner) }}" method="POST" class="flex items-center justify-between bg-white rounded-lg border border-gray-200 px-3 py-2">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="user_id" :value="u.id">
                        <div>
                            <div class="text-sm font-medium text-gray-800" x-text="u.name"></div>
                            <div class="text-xs text-gray-500" x-text="u.email"></div>
                        </div>
                        <button type="submit" class="text-xs font-semibold text-blue-600 hover:text-blue-800">Tautkan</button>
                    </form>
                </template>
                <p x-show="searchQuery.trim() !== '' && results.length === 0" x-cloak class="text-xs text-gray-400 text-center py-2">Tidak ada siswa ditemukan (atau sudah tertaut ke partner lain).</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3 font-semibold">Nama</th>
                        <th class="px-6 py-3 font-semibold">Email</th>
                        <th class="px-6 py-3 font-semibold">Bergabung</th>
                        <th class="px-6 py-3 text-right font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($stats['employees'] as $employee)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-3">
                                <a href="{{ route('students.show', $employee) }}" class="font-medium text-gray-800 hover:text-blue-600">{{ $employee->name }}</a>
                            </td>
                            <td class="px-6 py-3">{{ $employee->email }}</td>
                            <td class="px-6 py-3">{{ $employee->created_at?->format('d M Y') }}</td>
                            <td class="px-6 py-3 text-right">
                                <form action="{{ route('admin.partners.detach-user', [$partner, $employee]) }}" method="POST" class="inline-block" onsubmit="return confirm('Lepas siswa ini dari partner?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs font-medium text-red-500 hover:text-red-700">Lepas</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-400">Belum ada karyawan yang terdaftar lewat partner ini.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($partner->notes)
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 mt-6">
            <h3 class="text-sm font-bold text-gray-800 mb-2">Catatan</h3>
            <p class="text-sm text-gray-600 whitespace-pre-line">{{ $partner->notes }}</p>
        </div>
    @endif

</div>
@endsection
