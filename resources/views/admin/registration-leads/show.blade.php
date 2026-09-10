@extends('layouts.admin')

@section('title', 'Detail Lead – ' . $lead->full_name)

@section('content')
<div class="p-8 pb-24 max-w-4xl mx-auto" x-data="leadEditor()">

    {{-- Back + Breadcrumb --}}
    <div class="flex items-center gap-2 text-sm text-gray-500 mb-6">
        <a href="{{ route('admin.registration-leads.index') }}" class="hover:text-blue-600 transition">Registration Leads</a>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        <span class="text-gray-800 font-semibold">{{ $lead->full_name }}</span>
    </div>

    <div class="flex justify-end mb-6">
        <a href="{{ route('class-periods.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-gray-200 text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-50 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Kelola Batch Kelas
        </a>
    </div>

    {{-- Inquiry Source Banner (shows for leads from public pages) --}}
    @php
        $inquirySources = ['scholarship', 'job_vacancy', 'whv_application', 'quick_inquiry'];
        $isPublicInquiry = in_array($lead->source, $inquirySources);
        $sourceIcon = match($lead->source) {
            'scholarship'    => '🎓',
            'job_vacancy'    => '💼',
            'whv_application'=> '🌏',
            default          => '💬',
        };
        $sourceLabel = match($lead->source) {
            'scholarship'    => 'Scholarship Inquiry',
            'job_vacancy'    => 'Job Vacancy Inquiry',
            'whv_application'=> 'WHV Inquiry',
            default          => ucfirst(str_replace('_', ' ', $lead->source)),
        };
    @endphp
    @if($isPublicInquiry)
        <div class="mb-5 flex items-start gap-3 p-4 bg-blue-50 border border-blue-200 rounded-xl">
            <span class="text-2xl leading-none">{{ $sourceIcon }}</span>
            <div>
                <p class="text-sm font-bold text-blue-800">{{ $sourceLabel }}</p>
                @if($lead->source_detail)
                    <p class="text-xs text-blue-600 mt-0.5">{{ $lead->source_detail }}</p>
                @endif
                <p class="text-xs text-blue-500 mt-1">Lead ini berasal dari halaman publik melalui <strong>Quick Inquiry Modal</strong>.</p>
            </div>
        </div>
    @endif

    {{-- Flash --}}
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-700 text-sm rounded-xl px-4 py-3">{{ session('success') }}</div>
    @endif
    
    @if(session('wa_template'))
        <div class="mb-6 bg-blue-50 border border-blue-200 rounded-xl p-5 shadow-sm">
            <h3 class="text-base font-bold text-blue-900 mb-2 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Konversi Berhasil!
            </h3>
            <p class="text-sm text-blue-800 mb-4">Email dan Invoice sudah terkirim. Silakan copy template pesan di bawah ini untuk dikirimkan secara manual via WhatsApp.</p>
            
            <div class="bg-white border border-blue-100 rounded-lg p-4 text-sm text-gray-800 whitespace-pre-wrap font-mono mb-4">{{ session('wa_template') }}</div>
            
            <div class="flex flex-wrap gap-3">
                <button onclick="navigator.clipboard.writeText(`{{ session('wa_template') }}`); alert('Teks berhasil disalin!');" class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg text-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                    Copy Text
                </button>
                @if(session('invoice_url'))
                    <a href="{{ session('invoice_url') }}" target="_blank" class="flex items-center gap-2 bg-white border border-blue-200 text-blue-700 hover:bg-blue-100 font-semibold px-4 py-2 rounded-lg text-sm transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Buka & Download Invoice PDF
                    </a>
                @endif
                <a href="https://wa.me/62{{ ltrim(preg_replace('/[^0-9]/', '', $lead->whatsapp), '0') }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded-lg text-sm transition">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.134.558 4.143 1.535 5.886L.057 23.857a.5.5 0 00.614.617l6.077-1.475A11.942 11.942 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.907 0-3.693-.519-5.218-1.422l-.374-.222-3.876.942.96-3.785-.245-.389A9.96 9.96 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                    Kirim via WA Web
                </a>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-700 text-sm rounded-xl px-4 py-3">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-xl px-4 py-3">
            <p class="text-sm font-semibold text-red-700 mb-2">Ada data yang perlu diperbaiki:</p>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li class="text-xs text-red-600">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

        {{-- Left: Detail --}}
        <div class="md:col-span-2 space-y-5">

            {{-- Identity Card --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Data Diri
                    </h3>
                    <button @click="isEditing = !isEditing" class="text-xs font-semibold text-blue-600 hover:text-blue-800 flex items-center gap-1 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-lg transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        <span x-text="isEditing ? 'Tutup Edit' : 'Edit Lead'"></span>
                    </button>
                </div>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    @foreach([
                        'Nama Lengkap'   => $lead->full_name,
                        'WhatsApp'       => $lead->whatsapp,
                        'Email'          => $lead->email ?: '—',
                        'Kota'           => $lead->city,
                        'Usia'           => $lead->age ? $lead->age . ' tahun' : '—',
                        'Profesi'        => match($lead->profession) {
                            'student_sma' => 'Pelajar SMA',
                            'mahasiswa'   => 'Mahasiswa',
                            'karyawan'    => 'Karyawan',
                            default       => $lead->profession_other ?: 'Lainnya'
                        },
                        'Sumber Info'    => ucfirst($lead->source) . ($lead->source_detail ? ' (' . $lead->source_detail . ')' : ''),
                        'Daftar Pada'    => $lead->created_at ? $lead->created_at->format('d M Y, H:i') : '-',
                    ] as $label => $value)
                    <div>
                        <p class="text-xs font-medium text-gray-400 mb-0.5">{{ $label }}</p>
                        <p class="font-medium text-gray-800">{{ $value }}</p>
                    </div>
                    @endforeach
                </div>
                {{-- WhatsApp Button --}}
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <a href="https://wa.me/62{{ ltrim(preg_replace('/[^0-9]/', '', $lead->whatsapp), '0') }}"
                       target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-2 px-4 py-2 bg-green-500 hover:bg-green-600 text-white text-sm font-semibold rounded-xl transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.134.558 4.143 1.535 5.886L.057 23.857a.5.5 0 00.614.617l6.077-1.475A11.942 11.942 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.907 0-3.693-.519-5.218-1.422l-.374-.222-3.876.942.96-3.785-.245-.389A9.96 9.96 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                        Chat WhatsApp
                    </a>
                </div>
            </div>

            <div x-cloak x-show="isEditing" x-transition class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-bold text-gray-800">Edit Lead</h3>
                    <button type="button" @click="isEditing = false" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form action="{{ route('admin.registration-leads.update', $lead) }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    @csrf
                    @method('PUT')

                    <div class="md:col-span-2">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Nama Lengkap</label>
                        <input type="text" name="full_name" value="{{ old('full_name', $lead->full_name) }}" class="w-full border border-gray-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">WhatsApp</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp', $lead->whatsapp) }}" class="w-full border border-gray-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $lead->email) }}" class="w-full border border-gray-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Kota</label>
                        <input type="text" name="city" value="{{ old('city', $lead->city) }}" class="w-full border border-gray-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Profesi</label>
                        <select name="profession" class="w-full border border-gray-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            @foreach(['student_sma' => 'Pelajar SMA', 'mahasiswa' => 'Mahasiswa', 'karyawan' => 'Karyawan', 'other' => 'Lainnya'] as $value => $label)
                                <option value="{{ $value }}" {{ old('profession', $lead->profession) === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Profesi Lainnya</label>
                        <input type="text" name="profession_other" value="{{ old('profession_other', $lead->profession_other) }}" class="w-full border border-gray-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none">
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Program</label>
                        <select name="program_id" x-model="form.program_id" @change="onProgramOrModeChanged()" class="w-full border border-gray-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            <option value="">Belum ditentukan</option>
                            @php
                                $categoryPriority = [
                                    'IELTS Courses & Skills' => 1,
                                    'TOEFL & PTE Courses' => 2,
                                    'Grammar & Speaking Courses' => 3,
                                    'TOEFL Mock Packages' => 4,
                                    'Cambridge Practice Tests' => 5,
                                    'Program Lainnya' => 99,
                                ];
                                $groupedPrograms = $programs->groupBy('category')->sortBy(fn($items, $key) => $categoryPriority[$key] ?? 99);
                            @endphp
                            @foreach($groupedPrograms as $categoryName => $groupPrograms)
                                <optgroup label="── {{ $categoryName }} ──">
                                    @foreach($groupPrograms as $program)
                                        <option value="{{ $program->id }}" {{ (string) old('program_id', $lead->program_id) === (string) $program->id ? 'selected' : '' }}>{{ $program->name }}</option>
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Batch Kelas</label>
                        <select name="class_period_id" x-model="form.class_period_id" class="w-full border border-gray-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            <option value="">Belum dipilih</option>
                            @foreach($classPeriods as $period)
                                <option value="{{ $period->id }}" :disabled="!isBatchVisible('{{ $period->program_id ?? '' }}', '{{ $period->learning_mode }}')" {{ (string) old('class_period_id', $lead->class_period_id) === (string) $period->id ? 'selected' : '' }}>
                                    {{ $period->program?->name ?? 'Program' }} - {{ $period->name }} ({{ ucfirst($period->learning_mode) }}{{ $period->start_date ? ' | ' . $period->start_date->format('d M Y') : '' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Mode Belajar</label>
                        <select name="mode" x-model="form.mode" @change="onProgramOrModeChanged()" class="w-full border border-gray-200 rounded-xl px-3 py-2 focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            @foreach(['online' => 'Online', 'offline' => 'Offline', 'flexible' => 'Fleksibel'] as $value => $label)
                                <option value="{{ $value }}" {{ old('mode', $lead->mode) === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-2 flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-slate-800 hover:bg-slate-900 text-white font-semibold rounded-xl transition">
                            Simpan Perubahan Lead
                        </button>
                    </div>
                </form>
            </div>

            {{-- Program & Mode --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-base font-bold text-gray-800 mb-4">Program & Mode Belajar</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-xs font-medium text-gray-400 mb-0.5">Program</p>
                        <p class="font-medium text-gray-800">
                            {{ $lead->program?->name ?? ($lead->program_interest ?: 'Belum ditentukan') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-400 mb-0.5">Batch Kelas</p>
                        <p class="font-medium text-gray-800">
                            @if($lead->classPeriod)
                                {{ $lead->classPeriod->name }}
                                @if($lead->classPeriod->start_date)
                                    ({{ $lead->classPeriod->start_date->format('d M Y') }})
                                @endif
                            @else
                                —
                            @endif
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-400 mb-0.5">Mode Belajar</p>
                        @php
                            $modeColor = match($lead->mode) {
                                'online'   => 'bg-purple-100 text-purple-700',
                                'offline'  => 'bg-orange-100 text-orange-700',
                                'flexible' => 'bg-teal-100 text-teal-700',
                                default    => 'bg-gray-100 text-gray-600',
                            };
                        @endphp
                        <span class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $modeColor }}">
                            {{ ucfirst($lead->mode) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-400 mb-0.5">Jadwal</p>
                        <p class="font-medium text-gray-800">{{ ucfirst($lead->schedule_preference) }} / {{ ucfirst($lead->preferred_time) }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-400 mb-0.5">Budget</p>
                        <p class="font-medium text-gray-800">{{ $lead->budget_range ?: '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-400 mb-0.5">Target Skor</p>
                        <p class="font-medium text-gray-800">{{ $lead->target_score ?: '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium text-gray-400 mb-0.5">Waktu Dihubungi</p>
                        <p class="font-medium text-gray-800">{{ $lead->best_contact_time ?: '—' }}</p>
                    </div>
                    @if($lead->learning_goal)
                    <div class="col-span-2">
                        <p class="text-xs font-medium text-gray-400 mb-0.5">Tujuan Belajar</p>
                        <p class="text-gray-800">{{ $lead->learning_goal }}</p>
                    </div>
                    @endif
                    @if($lead->has_previous_course)
                    <div class="col-span-2">
                        <p class="text-xs font-medium text-gray-400 mb-0.5">Kursus Sebelumnya</p>
                        <p class="text-gray-800">{{ $lead->previous_course_name ?: 'Pernah, tidak disebutkan' }}</p>
                    </div>
                    @endif
                    @if($lead->notes)
                    <div class="col-span-2">
                        <p class="text-xs font-medium text-gray-400 mb-0.5">Catatan dari Peserta</p>
                        <p class="text-gray-800">{{ $lead->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-base font-bold text-gray-800 mb-4">Marketing Attribution</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    @foreach([
                        'UTM Source' => $lead->utm_source,
                        'UTM Medium' => $lead->utm_medium,
                        'UTM Campaign' => $lead->utm_campaign,
                        'UTM Content' => $lead->utm_content,
                        'UTM Term' => $lead->utm_term,
                        'Source Page' => $lead->acquisition_source_page,
                        'Landing Path' => $lead->acquisition_landing_path,
                        'Referrer' => $lead->acquisition_referrer,
                        'Variant' => $lead->acquisition_variant,
                        'Last CTA' => $lead->acquisition_last_cta,
                    ] as $label => $value)
                        <div>
                            <p class="text-xs font-medium text-gray-400 mb-0.5">{{ $label }}</p>
                            <p class="font-medium text-gray-800 break-all">{{ $value ?: '—' }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                <h3 class="text-base font-bold text-gray-800 mb-4">Timeline Lead</h3>
                <div class="space-y-4">
                    <div class="flex gap-3">
                        <div class="w-2.5 h-2.5 rounded-full bg-blue-500 mt-1.5"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Lead dibuat</p>
                            <p class="text-xs text-gray-500">{{ $lead->created_at ? $lead->created_at->format('d M Y, H:i') : '-' }}</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="w-2.5 h-2.5 rounded-full {{ $lead->contacted_at ? 'bg-yellow-500' : 'bg-gray-200' }} mt-1.5"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Lead dihubungi</p>
                            <p class="text-xs text-gray-500">{{ $lead->contacted_at ? $lead->contacted_at->format('d M Y, H:i') : 'Belum dihubungi' }}</p>
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <div class="w-2.5 h-2.5 rounded-full {{ $lead->converted_at ? 'bg-emerald-500' : 'bg-gray-200' }} mt-1.5"></div>
                        <div>
                            <p class="text-sm font-medium text-gray-800">Lead dikonversi</p>
                            <p class="text-xs text-gray-500">{{ $lead->converted_at ? $lead->converted_at->format('d M Y, H:i') : 'Belum dikonversi' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ─── Data Terkait (Payment & Enrollment) ─── --}}
            @if($lead->converted_user_id)
            <div class="bg-white rounded-2xl border border-indigo-100 shadow-sm p-6">
                <h3 class="text-base font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                    </svg>
                    Data Terkait
                </h3>
                <div class="mb-4">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">💳 Invoice Pembayaran</p>
                    @if($relatedPayment)
                        <div class="bg-gray-50 rounded-xl border border-gray-100 p-3 text-sm space-y-1">
                            <p class="font-semibold text-gray-800">{{ $relatedPayment->invoice_number }}</p>
                            <p class="text-gray-500">Program: {{ $relatedPayment->program->name ?? "—" }}</p>
                            <p class="text-gray-500">Jumlah: Rp{{ number_format(max(0,(int)$relatedPayment->amount - (int)$relatedPayment->discount_amount), 0, ",", ".") }}</p>
                            <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold {{ $relatedPayment->status === "paid" ? "bg-green-100 text-green-700" : ($relatedPayment->status === "pending" ? "bg-yellow-100 text-yellow-700" : "bg-red-100 text-red-700") }}">
                                {{ strtoupper($relatedPayment->status) }}
                            </span>
                            @if($relatedPayment->paid_at)
                                <p class="text-xs text-gray-400">Dibayar: {{ $relatedPayment->paid_at->format("d M Y") }}</p>
                            @endif
                        </div>
                        <a href="{{ route("admin.payments.index", ["q" => $relatedPayment->invoice_number]) }}" class="mt-2 inline-flex items-center gap-1 text-xs text-indigo-600 hover:underline">
                            Lihat di halaman Payments →
                        </a>
                    @else
                        <p class="text-sm text-gray-400 italic">Belum ada invoice.</p>
                    @endif
                </div>
                <div>
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">🎓 Status Enrollment</p>
                    @if($relatedEnrollment)
                        <div class="bg-gray-50 rounded-xl border border-gray-100 p-3 text-sm space-y-1">
                            <span class="inline-block px-2 py-0.5 rounded-full text-xs font-bold {{ $relatedEnrollment->status === "active" ? "bg-green-100 text-green-700" : "bg-gray-100 text-gray-600" }}">
                                {{ strtoupper($relatedEnrollment->status) }}
                            </span>
                            <p class="text-gray-500">Kelas: {{ $relatedEnrollment->classPeriod?->name ?? "—" }}</p>
                            @if($relatedEnrollment->enrolled_at)
                                <p class="text-xs text-gray-400">Terdaftar: {{ $relatedEnrollment->enrolled_at->format("d M Y") }}</p>
                            @endif
                        </div>
                    @else
                        <p class="text-sm text-gray-400 italic">Belum terdaftar di kelas.</p>
                    @endif
                </div>
                


                @if($lead->emailLogs && $lead->emailLogs->count() > 0)
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <p class="text-xs font-semibold text-gray-500 uppercase tracking-wide mb-2">✉️ Email Outbox ({{ $lead->emailLogs->count() }})</p>
                    <div class="space-y-2">
                        @foreach($lead->emailLogs->take(3) as $log)
                            <div class="bg-gray-50 rounded-lg border border-gray-100 p-2 text-xs">
                                <p class="font-semibold text-gray-800 truncate">{{ $log->subject }}</p>
                                <div class="flex items-center justify-between mt-1">
                                    <span class="text-gray-500">{{ $log->sent_at ? $log->sent_at->format('d M Y, H:i') : 'Pending' }}</span>
                                    <span class="{{ $log->status === 'sent' ? 'text-green-600' : 'text-red-600' }} font-medium capitalize">{{ $log->status }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @if($lead->emailLogs->count() > 3)
                        <a href="{{ route('admin.email-logs.index', ['search' => $lead->email]) }}" class="mt-2 inline-flex items-center gap-1 text-xs text-purple-600 hover:underline">
                            Lihat Semua Email →
                        </a>
                    @endif
                </div>
                @endif
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <a href="{{ route("students.show", $lead->convertedUser) }}" class="inline-flex items-center gap-2 text-sm text-blue-600 hover:text-blue-800 hover:underline font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Lihat Profil Student Lengkap
                    </a>
                </div>
            </div>
            @endif


        </div>

        {{-- Right: Status & Admin --}}
        <div class="space-y-5">

            {{-- Update Status --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
                <h3 class="text-base font-bold text-gray-800 mb-4">Update Status</h3>

                @if($lead->convertedUser)
                    <div class="mb-4 p-3 rounded-xl bg-emerald-50 border border-emerald-100">
                        <p class="text-xs font-semibold text-emerald-700 mb-1">Lead sudah dikonversi</p>
                        <div class="flex items-center justify-between gap-3">
                            <div>
                                <p class="text-sm font-medium text-emerald-900">{{ $lead->convertedUser->name }}</p>
                                <p class="text-xs text-emerald-700">Student ID #{{ $lead->convertedUser->id }}</p>
                            </div>
                            <a href="{{ route('students.show', $lead->convertedUser) }}" class="text-xs font-semibold text-emerald-700 hover:text-emerald-900 transition">
                                Lihat Student
                            </a>
                        </div>
                    </div>
                @endif

                <form action="{{ route('admin.registration-leads.update-status', $lead) }}" method="POST" class="space-y-3">
                    @csrf
                    @method('PATCH')
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Status Lead</label>
                        <select name="status" class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none bg-white">
                            @foreach(['new' => 'Baru', 'contacted' => 'Sudah Dihubungi', 'converted' => 'Converted (Daftar)', 'cancelled' => 'Cancelled'] as $val => $lbl)
                                <option value="{{ $val }}" {{ $lead->status === $val ? 'selected' : '' }}>{{ $lbl }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Catatan Admin</label>
                        <textarea name="admin_notes" rows="4" placeholder="Catatan follow-up, hasil percakapan, dll..."
                                  class="w-full border border-gray-200 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 outline-none resize-none">{{ $lead->admin_notes }}</textarea>
                    </div>
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-xl text-sm transition">
                        Simpan Status
                    </button>
                </form>

                @if($lead->contacted_at)
                    <p class="text-xs text-gray-400 mt-3 text-center">
                        Dihubungi: {{ $lead->contacted_at->format('d M Y, H:i') }}
                    </p>
                @endif

                @if($lead->status !== 'converted')
                    <form action="{{ route('admin.registration-leads.convert', $lead) }}" method="POST" class="mt-4 pt-4 border-t border-gray-100">
                        @csrf
                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 rounded-xl text-sm transition"
                                onclick="return confirm('Konfirmasi bukti transfer dan konversi lead ini menjadi akun student sekarang?')">
                            Konfirmasi Transfer & Convert
                        </button>
                    </form>
                @elseif($lead->convertedUser)
                    <div class="mt-4 pt-4 border-t border-gray-100 space-y-3">
                        @php
                            $passwordText = $lead->password ? "Password: (Sesuai yang Anda buat saat pendaftaran)\n\nSilakan login ke " . url('/login') . "\n" : "Password sementara Anda telah dikirimkan via email beserta invoice.\n\nSilakan login ke " . url('/login') . " dan segera ubah password Anda.\n";
                            
                            $payment = \App\Models\Payment::where('user_id', $lead->converted_user_id)->where('status', 'paid')->latest()->first();
                            $invoiceUrl = $payment ? asset('storage/invoices/invoice-' . $payment->invoice_number . '.pdf') : null;
                            
                            $invoiceText = "";
                            if ($payment) {
                                $formattedAmount = "Rp " . number_format($payment->amount, 0, ',', '.');
                                $invoiceText = "No. Invoice: {$payment->invoice_number}\nTotal Pembayaran: {$formattedAmount}\n\n";
                            }
                            
                            $waMsg = "Halo {$lead->full_name},\n\n" .
                                "Pendaftaran Anda di Target Bahasa telah berhasil dikonfirmasi!\n\n" .
                                "Berikut adalah detail akses akun Anda:\n" .
                                "Email: {$lead->convertedUser->email}\n" .
                                $passwordText . "\n" .
                                $invoiceText .
                                "Invoice dan detail lebih lengkap juga telah kami kirimkan ke email Anda.\n\n" .
                                "Terima kasih!";
                        @endphp
                        
                        <p class="text-xs font-semibold text-gray-700">Template Pesan WhatsApp:</p>
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 text-xs text-gray-800 whitespace-pre-wrap font-mono break-words break-all">{{ $waMsg }}</div>
                        
                        <div class="flex flex-col gap-2">
                            <button type="button" onclick="navigator.clipboard.writeText(`{{ $waMsg }}`); alert('Teks berhasil disalin!');" class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-xl text-sm transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                Copy Text
                            </button>
                            
                            @if($invoiceUrl)
                            <a href="{{ $invoiceUrl }}" target="_blank" class="w-full flex items-center justify-center gap-2 bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-semibold py-2 rounded-xl text-sm transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Buka & Download Invoice PDF
                            </a>
                            @endif
                            
                            <a href="https://wa.me/62{{ ltrim(preg_replace('/[^0-9]/', '', $lead->whatsapp), '0') }}?text={{ urlencode($waMsg) }}"
                               target="_blank" rel="noopener noreferrer"
                               class="w-full text-center flex items-center justify-center gap-2 bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-2 rounded-xl text-sm transition">
                               <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z"/><path d="M12 0C5.373 0 0 5.373 0 12c0 2.134.558 4.143 1.535 5.886L.057 23.857a.5.5 0 00.614.617l6.077-1.475A11.942 11.942 0 0012 24c6.627 0 12-5.373 12-12S18.627 0 12 0zm0 22c-1.907 0-3.693-.519-5.218-1.422l-.374-.222-3.876.942.96-3.785-.245-.389A9.96 9.96 0 012 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10z"/></svg>
                                Kirim via WA Web
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Danger Zone --}}
            <div class="bg-white rounded-2xl border border-red-100 shadow-sm p-5">
                <h3 class="text-sm font-bold text-red-600 mb-3">Hapus Lead</h3>
                <p class="text-xs text-gray-500 mb-3">Data lead akan dihapus permanen dan tidak bisa dikembalikan.</p>
                <button @click="confirmDelete = true" type="button"
                        class="w-full border border-red-200 text-red-600 hover:bg-red-50 font-semibold py-2 rounded-xl text-sm transition">
                    Hapus Lead Ini
                </button>
            </div>
        </div>

    </div>

    {{-- Delete Confirm Modal --}}
    <div x-show="confirmDelete" x-cloak
         class="fixed inset-0 bg-black/50 flex items-center justify-center z-50 px-4">
        <div class="bg-white rounded-2xl shadow-xl p-6 max-w-sm w-full">
            <h3 class="font-bold text-gray-900 mb-2">Hapus Lead?</h3>
            <p class="text-sm text-gray-500 mb-5">Data <strong>{{ $lead->full_name }}</strong> akan dihapus permanen.</p>
            <div class="flex gap-3">
                <button @click="confirmDelete = false"
                        class="flex-1 border border-gray-200 text-gray-600 font-semibold py-2.5 rounded-xl text-sm hover:bg-gray-50 transition">
                    Batal
                </button>
                <form action="{{ route('admin.registration-leads.destroy', $lead) }}" method="POST" class="flex-1">
                    @csrf @method('DELETE')
                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-2.5 rounded-xl text-sm transition">
                        Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>

<script>
function leadEditor() {
    return {
        isEditing: {{ $errors->any() ? 'true' : 'false' }},
        confirmDelete: false,
        form: {
            program_id: '{{ old('program_id', $lead->program_id) }}',
            class_period_id: '{{ old('class_period_id', $lead->class_period_id) }}',
            mode: '{{ old('mode', $lead->mode) }}',
        },
        isBatchVisible(programId, learningMode) {
            const matchProgram = !this.form.program_id || String(this.form.program_id) === String(programId);
            const matchMode = this.form.mode === 'flexible' || this.form.mode === learningMode;
            return matchProgram && matchMode;
        },
        onProgramOrModeChanged() {
            if (!this.form.class_period_id) {
                return;
            }

            @php
                $mappedBatches = $classPeriods->map(fn ($period) => [
                    'id' => (string) $period->id,
                    'program_id' => (string) ($period->program_id ?? ''),
                    'learning_mode' => $period->learning_mode,
                ])->values();
            @endphp
            const batchMap = @json($mappedBatches);

            const selected = batchMap.find((item) => item.id === String(this.form.class_period_id));
            if (!selected) {
                this.form.class_period_id = '';
                return;
            }

            if (!this.isBatchVisible(selected.program_id, selected.learning_mode)) {
                this.form.class_period_id = '';
            }
        },
    }
}
</script>
@endsection
