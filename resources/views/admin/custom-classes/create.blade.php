@extends('layouts.admin')

@section('title', 'Buat Kelas Online Custom')

@section('content')
<div class="p-6 md:p-8 max-w-7xl mx-auto space-y-8" 
     x-data="customClassBuilder({
        ratePrivate: {{ $ratePrivate }},
        rateSemiPrivate: {{ $rateSemiPrivate }},
        existingStudents: {{ Js::from($students) }}
     })">
    
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-gray-200 pb-6">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <a href="{{ route('class-periods.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 flex items-center gap-1 font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Class Periods
                </a>
            </div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Buat Kelas Online Custom</h1>
            <p class="text-gray-500 mt-1">Atur kelas khusus privat 1 orang atau semi privat (s/d 4 orang) dengan kurikulum & jumlah pertemuan fleksibel.</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                Custom Builder
            </span>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-xl shadow-sm">
            <div class="flex items-center gap-2 text-red-800 font-semibold mb-1">
                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Periksa kembali formulir Anda:
            </div>
            <ul class="list-disc list-inside text-sm text-red-700 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('custom-classes.store') }}" method="POST" id="customClassForm" class="space-y-8">
        @csrf

        <!-- LANGKAH 1: Informasi Kelas & Siswa -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-indigo-600 text-white font-bold flex items-center justify-center text-sm shadow">1</div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Tipe Kelas & Peserta Siswa</h2>
                        <p class="text-xs text-gray-500">Pilih format kelas (Privat atau Semi-Privat) dan tentukan siswa serta pengajar.</p>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <!-- Tipe Kelas (Pills) -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-2">Tipe Kelas <span class="text-red-500">*</span></label>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="relative flex flex-col p-4 border-2 rounded-xl cursor-pointer transition-all"
                               :class="batchType === 'private' ? 'border-indigo-600 bg-indigo-50/40 shadow-sm' : 'border-gray-200 hover:border-gray-300'">
                            <input type="radio" name="batch_type" value="private" x-model="batchType" @change="onBatchTypeChange()" class="sr-only">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center" :class="batchType === 'private' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600'">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    </div>
                                    <div>
                                        <span class="font-bold text-gray-900">Privat (1-on-1)</span>
                                        <p class="text-xs text-gray-500">1 Siswa eksklusif dengan 1 Pengajar</p>
                                    </div>
                                </div>
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full" :class="batchType === 'private' ? 'bg-indigo-200 text-indigo-900' : 'bg-gray-100 text-gray-500'">1 Siswa</span>
                            </div>
                        </label>

                        <label class="relative flex flex-col p-4 border-2 rounded-xl cursor-pointer transition-all"
                               :class="batchType === 'semi_private' ? 'border-indigo-600 bg-indigo-50/40 shadow-sm' : 'border-gray-200 hover:border-gray-300'">
                            <input type="radio" name="batch_type" value="semi_private" x-model="batchType" @change="onBatchTypeChange()" class="sr-only">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-9 h-9 rounded-full flex items-center justify-center" :class="batchType === 'semi_private' ? 'bg-indigo-600 text-white' : 'bg-gray-100 text-gray-600'">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    </div>
                                    <div>
                                        <span class="font-bold text-gray-900">Semi-Privat (Kelompok Kecil)</span>
                                        <p class="text-xs text-gray-500">2 hingga 4 Siswa bersama 1 Pengajar</p>
                                    </div>
                                </div>
                                <span class="text-xs font-semibold px-2 py-0.5 rounded-full" :class="batchType === 'semi_private' ? 'bg-indigo-200 text-indigo-900' : 'bg-gray-100 text-gray-500'">Max 4 Siswa</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Nama Kelas -->
                <div>
                    <label class="block text-sm font-semibold text-gray-800 mb-1">Nama / Judul Kelas <span class="text-red-500">*</span></label>
                    <input type="text" name="name" x-model="className" required
                           class="w-full px-4 py-2.5 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm"
                           placeholder="Contoh: Privat IELTS Intensive - Sarah / Semi-Privat TOEFL - Group A">
                </div>

                <!-- Mode Pemilihan Siswa -->
                <div class="border-t border-gray-100 pt-5">
                    <div class="flex items-center justify-between mb-3 flex-wrap gap-2">
                        <label class="block text-sm font-semibold text-gray-800">Peserta Siswa <span class="text-red-500">*</span></label>
                        <div class="flex items-center gap-2 flex-wrap">
                            <button type="button" 
                                    onclick="navigator.clipboard.writeText('{{ route('student.register-custom') }}'); alert('Link pendaftaran kelas custom berhasil disalin:\n{{ route('student.register-custom') }}');"
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-semibold text-indigo-700 bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 rounded-lg transition cursor-pointer"
                                    title="Salin tautan formulir pendaftaran untuk dikirimkan ke calon siswa">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                <span>Salin Link Form Pendaftaran</span>
                            </button>
                            <div class="inline-flex p-1 bg-gray-100 rounded-lg text-xs font-medium">
                                <button type="button" @click="studentMode = 'existing'"
                                        :class="studentMode === 'existing' ? 'bg-white shadow-sm text-indigo-700 font-bold' : 'text-gray-600'"
                                        class="px-3 py-1 rounded-md transition">Pilih Siswa Terdaftar</button>
                                <button type="button" @click="studentMode = 'new'"
                                        :class="studentMode === 'new' ? 'bg-white shadow-sm text-indigo-700 font-bold' : 'text-gray-600'"
                                        class="px-3 py-1 rounded-md transition">+ Daftarkan Siswa Baru</button>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="student_selection_mode" :value="studentMode">

                    <!-- Siswa Terdaftar -->
                    <div x-show="studentMode === 'existing'" class="space-y-3">
                        <div class="relative">
                            <input type="text" x-model="studentSearch" placeholder="Cari nama atau email siswa..."
                                   class="w-full pl-10 pr-4 py-2 rounded-xl border border-gray-300 focus:ring-2 focus:ring-indigo-500 text-sm">
                            <svg class="w-4 h-4 text-gray-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>

                        <!-- Siswa yang Sudah Terpilih -->
                        <div x-show="selectedStudentIds.length > 0" class="flex flex-wrap gap-2">
                            <template x-for="id in selectedStudentIds" :key="id">
                                <span class="inline-flex items-center gap-1.5 pl-3 pr-1.5 py-1 rounded-full bg-indigo-100 text-indigo-800 text-xs font-semibold">
                                    <span x-text="(existingStudents.find(s => s.id === id) || {}).name || 'Siswa'"></span>
                                    <button type="button" @click="removeSelectedStudent(id)"
                                            class="w-4 h-4 flex items-center justify-center rounded-full text-indigo-500 hover:bg-indigo-200 hover:text-indigo-900 transition"
                                            title="Hapus dari pilihan">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    </button>
                                </span>
                            </template>
                        </div>

                        <!-- Daftar Siswa untuk Dipilih -->
                        <div class="max-h-52 overflow-y-auto border border-gray-200 rounded-xl p-2 space-y-1 bg-gray-50/50">
                            <template x-for="st in filteredStudents" :key="st.id">
                                <label class="flex items-center justify-between p-2 rounded-lg hover:bg-white cursor-pointer border border-transparent hover:border-gray-200 text-sm transition">
                                    <div class="flex items-center gap-2.5">
                                        <template x-if="batchType === 'private'">
                                            <input type="radio" name="existing_student_ids[]" :value="st.id" 
                                                   :checked="selectedStudentIds.includes(st.id)"
                                                   @change="selectedStudentIds = [st.id]; updateSuggestedPrice();"
                                                   class="text-indigo-600 focus:ring-indigo-500 rounded">
                                        </template>
                                        <template x-if="batchType === 'semi_private'">
                                            <input type="checkbox" name="existing_student_ids[]" :value="st.id"
                                                   :checked="selectedStudentIds.includes(st.id)"
                                                   @change="toggleStudent(st.id)"
                                                   :disabled="!selectedStudentIds.includes(st.id) && selectedStudentIds.length >= 4"
                                                   class="text-indigo-600 focus:ring-indigo-500 rounded">
                                        </template>
                                        <div>
                                            <span class="font-medium text-gray-900" x-text="st.name"></span>
                                            <span class="text-xs text-gray-500 ml-1" x-text="'(' + st.email + ')'"></span>
                                        </div>
                                    </div>
                                    <span class="text-xs text-gray-400" x-text="st.phone_number || '-'"></span>
                                </label>
                            </template>
                        </div>
                        <p class="text-xs text-gray-500 flex items-center justify-between">
                            <span x-text="'Terpilih: ' + selectedStudentIds.length + ' siswa'"></span>
                            <span x-show="batchType === 'semi_private'" class="text-indigo-600">Maksimal 4 siswa</span>
                        </p>
                    </div>

                    <!-- Pendaftaran Siswa Baru Cepat -->
                    <div x-show="studentMode === 'new'" class="space-y-4 bg-gray-50 p-4 rounded-xl border border-gray-200">
                        <template x-for="(ns, idx) in newStudentsList" :key="idx">
                            <div class="p-3 bg-white rounded-lg border border-gray-200 space-y-3 relative">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-indigo-700" x-text="'Siswa Baru #' + (idx + 1)"></span>
                                    <button type="button" x-show="newStudentsList.length > 1" @click="removeNewStudent(idx)" class="text-red-500 hover:text-red-700 text-xs font-semibold">Hapus</button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Nama Lengkap</label>
                                        <input type="text" :name="'new_students[' + idx + '][name]'" x-model="ns.name" required placeholder="Nama Siswa"
                                               class="w-full px-3 py-1.5 rounded-lg border border-gray-300 text-xs">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">Email</label>
                                        <input type="email" :name="'new_students[' + idx + '][email]'" x-model="ns.email" required placeholder="email@contoh.com"
                                               class="w-full px-3 py-1.5 rounded-lg border border-gray-300 text-xs">
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-gray-700 mb-1">No. WhatsApp</label>
                                        <input type="text" :name="'new_students[' + idx + '][phone_number]'" x-model="ns.phone" placeholder="0812xxxx"
                                               class="w-full px-3 py-1.5 rounded-lg border border-gray-300 text-xs">
                                    </div>
                                </div>
                            </div>
                        </template>

                        <div x-show="batchType === 'semi_private' && newStudentsList.length < 4">
                            <button type="button" @click="addNewStudentRow()" class="text-xs text-indigo-600 font-bold hover:underline flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                + Tambah Siswa Baru Lagi (Maks. 4)
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Pengajar & Jadwal -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 border-t border-gray-100 pt-5">
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-1">Pengajar (Teacher)</label>
                        <select name="teacher_id" class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-indigo-500">
                            <option value="">-- Belum Ditugaskan --</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }} ({{ $teacher->email }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-1">Tanggal Mulai <span class="text-red-500">*</span></label>
                        <input type="date" name="start_date" required value="{{ date('Y-m-d') }}"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-1">Perkiraan Selesai</label>
                        <input type="date" name="end_date"
                               class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>

                <!-- Zoom Link Utama -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-1">Link Zoom / Google Meet (Opsional)</label>
                        <input type="url" name="zoom_link" placeholder="https://zoom.us/j/..."
                               class="w-full px-3.5 py-2 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-1">Passcode / Password Zoom</label>
                        <input type="text" name="zoom_password" placeholder="Passcode (jika ada)"
                               class="w-full px-3.5 py-2 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
            </div>
        </div>

        <!-- LANGKAH 2: Jumlah Pertemuan & Kalkulator Saran Harga -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-emerald-50 to-teal-50 px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-600 text-white font-bold flex items-center justify-center text-sm shadow">2</div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Jumlah Pertemuan & Kalkulator Biaya</h2>
                        <p class="text-xs text-gray-500">Sistem otomatis menghitung saran harga berdasarkan tarif acuan per pertemuan.</p>
                    </div>
                </div>
            </div>

            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Jumlah Pertemuan -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-1">Jumlah Pertemuan (Meetings) <span class="text-red-500">*</span></label>
                        <div class="flex items-center gap-2">
                            <input type="number" name="total_meetings" min="1" max="60" x-model.number="totalMeetings" 
                                   @input="onTotalMeetingsChange()" required
                                   class="w-full px-4 py-2.5 rounded-xl border border-gray-300 font-bold text-lg text-indigo-700 text-center focus:ring-2 focus:ring-indigo-500">
                            <span class="text-sm font-medium text-gray-600">Pertemuan</span>
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Standar paket: 4, 8, 10, 12, atau 16 pertemuan.</p>
                    </div>

                    <!-- Tarif Acuan Per Pertemuan -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-1">Tarif Acuan per Pertemuan</label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-2.5 text-gray-400 text-sm">Rp</span>
                            <input type="number" x-model.number="currentRatePerMeeting" @input="updateSuggestedPrice()"
                                   class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-indigo-500">
                        </div>
                        <p class="text-xs text-gray-500 mt-1" x-text="batchType === 'private' ? 'Standar Privat: Rp ' + formatNumber(ratePrivate) + '/meeting' : 'Standar Semi-Privat: Rp ' + formatNumber(rateSemiPrivate) + '/meeting/siswa'"></p>
                    </div>

                    <!-- Box Saran Harga Otomatis -->
                    <div class="p-4 rounded-xl border-2 border-emerald-300 bg-emerald-50/60 flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <span class="text-xs font-bold uppercase tracking-wider text-emerald-800">Saran Harga Otomatis</span>
                            <span class="text-[10px] font-semibold bg-emerald-200 text-emerald-900 px-2 py-0.5 rounded-full">Kalkulasi Sistem</span>
                        </div>
                        <div class="my-2">
                            <span class="text-2xl font-black text-emerald-700" x-text="'Rp ' + formatNumber(suggestedPrice)"></span>
                            <p class="text-[11px] text-emerald-600 mt-0.5" x-text="calcExplanation"></p>
                        </div>
                        <button type="button" @click="useSuggestedPrice()" 
                                class="text-xs bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-1.5 px-3 rounded-lg transition shadow-sm self-start">
                            Gunakan Saran Harga Ini
                        </button>
                    </div>
                </div>

                <!-- Input Harga Final Disepakati -->
                <div class="border-t border-gray-100 pt-5 grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                    <div>
                        <label class="block text-sm font-semibold text-gray-800 mb-1">
                            Harga Final Disepakati (Total Tagihan) <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-3.5 top-2.5 text-gray-500 font-bold">Rp</span>
                            <input type="number" name="agreed_price" x-model.number="agreedPrice" required min="0"
                                   class="w-full pl-11 pr-4 py-2.5 rounded-xl border-2 border-indigo-400 focus:border-indigo-600 focus:ring-2 focus:ring-indigo-500 font-black text-lg text-gray-900">
                        </div>
                        <input type="hidden" name="suggested_price" :value="suggestedPrice">
                        <p class="text-xs text-gray-500 mt-1">Bisa disesuaikan bebas sesuai kesepakatan diskon / negosiasi dengan student.</p>
                    </div>

                    <!-- Opsi Invoice Otomatis -->
                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-200">
                        <label class="flex items-start gap-3 cursor-pointer">
                            <input type="checkbox" name="create_invoice" value="1" checked class="w-5 h-5 mt-0.5 text-indigo-600 rounded focus:ring-indigo-500">
                            <div>
                                <span class="text-sm font-bold text-gray-800">Otomatis Terbitkan Invoice & Template WhatsApp</span>
                                <p class="text-xs text-gray-500 mt-0.5">Sistem akan mencatat invoice pembayaran di tabel Payment dan menyiapkan pesan WhatsApp siap kirim.</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Catatan: Curriculum & Meeting Builder dipindah ke halaman Kelola
             Kurikulum & Assignment kelas ini, dapat diakses setelah kelas
             dibuat (lihat Admin\CustomClassController::curriculum()). Form
             ini hanya membuat kelas + siswa + harga; jumlah pertemuan di
             atas tetap menentukan kalkulasi harga, tapi materinya disusun
             belakangan, bukan di sini. -->

        <!-- Catatan Umum Kurikulum (Opsional) -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 space-y-2">
            <label class="block text-sm font-semibold text-gray-800">Catatan Khusus Kelas / Permintaan Student (Opsional)</label>
            <textarea name="custom_curriculum_notes" rows="3"
                      placeholder="Contoh: Student meminta fokus 60% pada Speaking part 2 & 3 untuk persiapan wawancara LPDP."
                      class="w-full px-4 py-2.5 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-indigo-500"></textarea>
        </div>

        <!-- Tombol Aksi Simpan -->
        <div class="flex items-center justify-end gap-4 pt-4">
            <a href="{{ route('class-periods.index') }}" class="px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition text-sm">
                Batal
            </a>
            <button type="submit" class="px-8 py-3.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold transition shadow-lg shadow-indigo-600/30 flex items-center gap-2 text-base">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Buat Kelas Online Custom Sekarang
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function customClassBuilder(config) {
    return {
        batchType: 'private',
        className: '',
        studentMode: 'existing',
        studentSearch: '',
        existingStudents: config.existingStudents || [],
        selectedStudentIds: [],
        newStudentsList: [
            { name: '', email: '', phone: '' }
        ],
        ratePrivate: config.ratePrivate || 150000,
        rateSemiPrivate: config.rateSemiPrivate || 75000,
        currentRatePerMeeting: config.ratePrivate || 150000,
        totalMeetings: 8,
        suggestedPrice: 0,
        agreedPrice: 0,
        calcExplanation: '',

        init() {
            this.currentRatePerMeeting = this.ratePrivate;
            this.updateSuggestedPrice();
            this.useSuggestedPrice();
        },

        get filteredStudents() {
            if (!this.studentSearch) return this.existingStudents;
            const q = this.studentSearch.toLowerCase();
            return this.existingStudents.filter(s => 
                (s.name && s.name.toLowerCase().includes(q)) || 
                (s.email && s.email.toLowerCase().includes(q))
            );
        },

        onBatchTypeChange() {
            if (this.batchType === 'private') {
                this.currentRatePerMeeting = this.ratePrivate;
                if (this.selectedStudentIds.length > 1) {
                    this.selectedStudentIds = [this.selectedStudentIds[0]];
                }
                this.newStudentsList = [this.newStudentsList[0] || { name: '', email: '', phone: '' }];
            } else {
                this.currentRatePerMeeting = this.rateSemiPrivate;
            }
            this.updateSuggestedPrice();
            this.useSuggestedPrice();
        },

        toggleStudent(id) {
            const idx = this.selectedStudentIds.indexOf(id);
            if (idx > -1) {
                this.selectedStudentIds.splice(idx, 1);
            } else {
                if (this.selectedStudentIds.length < 4) {
                    this.selectedStudentIds.push(id);
                }
            }
            this.updateSuggestedPrice();
        },

        removeSelectedStudent(id) {
            const idx = this.selectedStudentIds.indexOf(id);
            if (idx > -1) {
                this.selectedStudentIds.splice(idx, 1);
                this.updateSuggestedPrice();
            }
        },

        addNewStudentRow() {
            if (this.newStudentsList.length < 4) {
                this.newStudentsList.push({ name: '', email: '', phone: '' });
                this.updateSuggestedPrice();
            }
        },

        removeNewStudent(index) {
            if (this.newStudentsList.length > 1) {
                this.newStudentsList.splice(index, 1);
                this.updateSuggestedPrice();
            }
        },

        onTotalMeetingsChange() {
            if (this.totalMeetings < 1) this.totalMeetings = 1;
            this.updateSuggestedPrice();
        },

        updateSuggestedPrice() {
            const studentCount = this.batchType === 'private' 
                ? 1 
                : Math.max(1, this.studentMode === 'existing' ? this.selectedStudentIds.length : this.newStudentsList.length);

            const meetings = parseInt(this.totalMeetings) || 1;
            const rate = parseInt(this.currentRatePerMeeting) || 0;

            if (this.batchType === 'private') {
                this.suggestedPrice = meetings * rate;
                this.calcExplanation = meetings + ' pertemuan × Rp ' + this.formatNumber(rate);
            } else {
                this.suggestedPrice = meetings * rate * studentCount;
                this.calcExplanation = meetings + ' pertemuan × Rp ' + this.formatNumber(rate) + ' × ' + studentCount + ' siswa';
            }
        },

        useSuggestedPrice() {
            this.agreedPrice = this.suggestedPrice;
        },

        formatNumber(val) {
            return new Intl.NumberFormat('id-ID').format(val || 0);
        }
    };
}
</script>
@endpush
@endsection
