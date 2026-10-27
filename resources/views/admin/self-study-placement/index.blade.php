@extends('layouts.admin')

@section('title', 'Self-Study Grammar Placement')

@section('content')
<div class="p-6 sm:p-8">
    <div class="mb-8">
        <h1 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">Self-Study Grammar Placement</h1>
        <p class="text-sm text-gray-500 mt-1">
            Hasil tes penempatan untuk kursus mandiri Grammar for Writing, dan kontrol untuk mengatur mode (A1-B2 atau B1-C2) secara manual per siswa.
        </p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if(!$packageId)
        <div class="bg-amber-50 border border-amber-200 text-amber-700 px-4 py-3 rounded-xl mb-6 text-sm">
            Belum ada paket tes penempatan self-study yang terdaftar (Setting <code>self_study_grammar_placement_package_id</code> kosong).
        </div>
    @endif

    <!-- Set mode for any student -->
    <div class="bg-white shadow-sm border border-gray-200 rounded-xl p-6 mb-8">
        <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wide mb-4">Atur Mode Manual untuk Siswa</h2>
        <form method="POST" action="{{ route('admin.self-study-placement.override') }}" class="flex flex-col sm:flex-row gap-3 sm:items-end">
            @csrf
            <div class="flex-1">
                <label class="block text-xs font-semibold text-gray-600 mb-1">Siswa</label>
                <select name="user_id" required class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Pilih siswa...</option>
                    @foreach($students as $s)
                        <option value="{{ $s->id }}">
                            {{ $s->name }} ({{ $s->email }})@if($s->self_study_grammar_mode_override) &mdash; saat ini: Mode {{ $s->self_study_grammar_mode_override }} @endif
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-600 mb-1">Mode</label>
                <select name="mode" class="block w-full border border-gray-300 rounded-xl px-4 py-2.5 text-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Otomatis (ikuti hasil tes)</option>
                    <option value="A">Mode A &mdash; A1-A2 bertahap ke B1-B2</option>
                    <option value="B">Mode B &mdash; B1-C2 lanjutan</option>
                </select>
            </div>
            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold rounded-xl transition-colors shadow-sm">
                Simpan
            </button>
        </form>
        <p class="text-xs text-gray-400 mt-3">Jika mode diatur manual, siswa langsung masuk ke kursus dengan mode tersebut tanpa perlu mengerjakan tes penempatan.</p>
    </div>

    <!-- Results list -->
    <div class="bg-white shadow-sm overflow-hidden border border-gray-200 rounded-xl">
        <div class="px-5 py-4 border-b border-gray-100">
            <h2 class="text-sm font-bold text-gray-800 uppercase tracking-wide">Riwayat Tes Penempatan</h2>
        </div>
        @if($results->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 px-4 text-center">
                <h3 class="text-base font-bold text-gray-900">Belum ada hasil tes.</h3>
                <p class="text-xs text-gray-500 mt-1">Hasil akan muncul di sini setelah siswa mengerjakan tes penempatan self-study.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-5 py-3 text-left text-xs uppercase tracking-wider text-gray-400 font-semibold">Siswa</th>
                            <th class="px-5 py-3 text-left text-xs uppercase tracking-wider text-gray-400 font-semibold">Skor</th>
                            <th class="px-5 py-3 text-left text-xs uppercase tracking-wider text-gray-400 font-semibold">CEFR</th>
                            <th class="px-5 py-3 text-left text-xs uppercase tracking-wider text-gray-400 font-semibold">Mode Hasil Tes</th>
                            <th class="px-5 py-3 text-left text-xs uppercase tracking-wider text-gray-400 font-semibold">Status Override</th>
                            <th class="px-5 py-3 text-left text-xs uppercase tracking-wider text-gray-400 font-semibold">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($results as $r)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-5 py-4">
                                    <div class="font-medium text-gray-800">{{ $r->student->name ?? $r->student_name }}</div>
                                    <div class="text-xs text-gray-400">{{ $r->student->email ?? '' }}</div>
                                </td>
                                <td class="px-5 py-4 text-sm text-gray-600">{{ $r->correct_count }}/{{ $r->total_count }} ({{ $r->percentage }}%)</td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800">{{ $r->cefr_level }}</span>
                                </td>
                                <td class="px-5 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $r->resolved_mode === 'B' ? 'bg-purple-100 text-purple-800' : 'bg-emerald-100 text-emerald-800' }}">
                                        Mode {{ $r->resolved_mode }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-sm">
                                    @if($r->student && $r->student->self_study_grammar_mode_override)
                                        <span class="text-amber-600 font-semibold">Manual: Mode {{ $r->student->self_study_grammar_mode_override }}</span>
                                    @else
                                        <span class="text-gray-400">Otomatis</span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-xs text-gray-400">{{ $r->created_at->format('d M Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
