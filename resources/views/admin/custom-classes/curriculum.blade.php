@extends('layouts.admin')

@section('title', 'Kurikulum & Assignment - ' . $classPeriod->name)

@section('content')
<div class="p-6 md:p-8 max-w-7xl mx-auto space-y-8"
     x-data="customClassCurriculumBuilder({
        catalog: {{ Js::from($curriculumCatalog) }},
        existingMeetings: {{ Js::from($meetingsForJs) }},
        totalMeetings: {{ (int) ($classPeriod->total_meetings ?: 8) }}
     })">

    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-gray-200 pb-6">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <a href="{{ route('class-periods.show', $classPeriod->id) }}" class="text-sm text-indigo-600 hover:text-indigo-800 flex items-center gap-1 font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke {{ $classPeriod->name }}
                </a>
            </div>
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Kurikulum & Assignment</h1>
            <p class="text-gray-500 mt-1">Susun materi untuk setiap pertemuan kelas <strong>{{ $classPeriod->name }}</strong> (bisa ambil dari modul sistem atau topik custom bebas).</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                <span class="w-2 h-2 rounded-full bg-indigo-500 animate-pulse"></span>
                {{ $existingMeetings->count() }} Pertemuan Tersimpan
            </span>
        </div>
    </div>

    @if (session('success'))
        <div class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-xl shadow-sm text-emerald-800 font-medium text-sm">
            {{ session('success') }}
        </div>
    @endif

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

    <form action="{{ route('custom-classes.curriculum.store', $classPeriod->id) }}" method="POST" id="curriculumForm" class="space-y-8">
        @csrf

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-50 to-pink-50 px-6 py-4 border-b border-gray-200 flex flex-col sm:flex-row justify-between sm:items-center gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-purple-600 text-white font-bold flex items-center justify-center text-sm shadow">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-gray-900">Curriculum & Meeting Builder</h2>
                        <p class="text-xs text-gray-500">Susun materi untuk setiap pertemuan (bisa ambil dari modul sistem atau topik custom bebas).</p>
                    </div>
                </div>

                <!-- Template Preset Cepat -->
                <div class="flex items-center gap-2">
                    <label class="text-xs font-semibold text-gray-600">Template Cepat:</label>
                    <select @change="applyQuickPreset($event.target.value); $event.target.value = '';" class="text-xs py-1.5 px-2.5 rounded-lg border border-gray-300 bg-white">
                        <option value="">-- Pilih Presets Modul --</option>
                        <template x-for="mod in catalog" :key="mod.program_name">
                            <option :value="mod.program_name" x-text="mod.program_name"></option>
                        </template>
                    </select>
                </div>
            </div>

            <div class="p-6 space-y-4">
                <div class="flex items-center gap-3">
                    <label class="text-sm font-semibold text-gray-800">Jumlah Pertemuan</label>
                    <div class="flex items-center gap-2">
                        <input type="number" min="1" max="60" x-model.number="totalMeetings" @input="onTotalMeetingsChange()"
                               class="w-24 px-3 py-1.5 rounded-xl border border-gray-300 font-bold text-center text-indigo-700 focus:ring-2 focus:ring-indigo-500">
                        <span class="text-xs text-gray-500">Pertemuan</span>
                    </div>
                </div>

                <p class="text-xs text-gray-500">
                    Berikut adalah baris materi untuk masing-masing pertemuan 1 s/d <span class="font-bold" x-text="totalMeetings"></span>. Anda dapat mencampur materi antar program atau memasukkan judul materi bebas.
                </p>

                <!-- Daftar Baris Pertemuan Dinamis -->
                <div class="space-y-4">
                    <template x-for="(mt, idx) in meetingsList" :key="idx">
                        <div class="p-4 rounded-xl border border-gray-200 bg-gray-50/70 hover:border-indigo-300 transition-all space-y-3">
                            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-2 pb-2 border-b border-gray-200">
                                <div class="flex items-center gap-2">
                                    <span class="w-7 h-7 rounded-lg bg-indigo-600 text-white text-xs font-black flex items-center justify-center" x-text="idx + 1"></span>
                                    <span class="font-bold text-sm text-gray-900" x-text="'Pertemuan ' + (idx + 1)"></span>
                                    <input type="hidden" :name="'meetings[' + idx + '][meeting_number]'" :value="idx + 1">
                                </div>

                                <!-- Toggle Jenis Materi: Existing vs Custom -->
                                <div class="inline-flex p-1 bg-white rounded-lg border border-gray-200 text-xs">
                                    <button type="button" @click="mt.material_type = 'existing'"
                                            :class="mt.material_type === 'existing' ? 'bg-indigo-600 text-white font-bold' : 'text-gray-600'"
                                            class="px-2.5 py-1 rounded-md transition">Materi Sistem</button>
                                    <button type="button" @click="mt.material_type = 'custom'"
                                            :class="mt.material_type === 'custom' ? 'bg-purple-600 text-white font-bold' : 'text-gray-600'"
                                            class="px-2.5 py-1 rounded-md transition">Topik Custom Bebas</button>
                                    <input type="hidden" :name="'meetings[' + idx + '][material_type]'" :value="mt.material_type">
                                </div>
                            </div>

                            <!-- Pilihan Materi Sistem -->
                            <div x-show="mt.material_type === 'existing'" class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Pilih Program / Modul</label>
                                    <select x-model="mt.selectedCatalogIndex" @change="onMeetingCatalogChange(idx)"
                                            class="w-full text-xs px-3 py-2 rounded-lg border border-gray-300 bg-white">
                                        <option value="">-- Pilih Program / Modul --</option>
                                        <template x-for="(cat, cIdx) in catalog" :key="cIdx">
                                            <option :value="cIdx" x-text="cat.program_name + ' (' + cat.category + ')'"></option>
                                        </template>
                                    </select>
                                    <input type="hidden" :name="'meetings[' + idx + '][source_program_id]'" :value="mt.source_program_id">
                                </div>

                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Pilih Pertemuan / Skill Modul</label>
                                    <select x-model="mt.selectedMeetingIndex" @change="onMeetingTopicSelect(idx)"
                                            class="w-full text-xs px-3 py-2 rounded-lg border border-gray-300 bg-white">
                                        <option value="">-- Pilih Topik / Pertemuan --</option>
                                        <template x-for="(mItem, mIdx) in getAvailableMeetingsForCatalog(mt.selectedCatalogIndex)" :key="mIdx">
                                            <option :value="mIdx" x-text="'M' + mItem.meeting_number + ': ' + mItem.title"></option>
                                        </template>
                                    </select>
                                    <input type="hidden" :name="'meetings[' + idx + '][meeting_id]'" :value="mt.meeting_id">
                                </div>
                            </div>

                            <!-- Input Judul Topik & Catatan -->
                            <div class="grid grid-cols-1 md:grid-cols-12 gap-3">
                                <div class="md:col-span-8">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Judul Topik / Materi Pertemuan <span class="text-red-500">*</span></label>
                                    <input type="text" :name="'meetings[' + idx + '][topic]'" x-model="mt.topic" required
                                           class="w-full text-xs px-3 py-2 rounded-lg border border-gray-300 bg-white font-medium text-gray-900"
                                           placeholder="Judul materi pertemuan...">
                                </div>

                                <div class="md:col-span-4">
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Tanggal Pertemuan (Opsional)</label>
                                    <input type="date" :name="'meetings[' + idx + '][meeting_date]'" x-model="mt.meeting_date"
                                           class="w-full text-xs px-3 py-2 rounded-lg border border-gray-300 bg-white">
                                </div>
                            </div>

                            <!-- Baris Catatan / Link Materi (Jika Custom) -->
                            <div x-show="mt.material_type === 'custom'" class="grid grid-cols-1 md:grid-cols-2 gap-3 pt-2 border-t border-gray-200/60">
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Link Materi / Drive (Opsional)</label>
                                    <input type="url" :name="'meetings[' + idx + '][material_url]'" x-model="mt.material_url"
                                           placeholder="https://drive.google.com/..."
                                           class="w-full text-xs px-3 py-1.5 rounded-lg border border-gray-300 bg-white">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-700 mb-1">Catatan Tambahan untuk Siswa</label>
                                    <input type="text" :name="'meetings[' + idx + '][material_notes]'" x-model="mt.material_notes"
                                           placeholder="Instruksi pengerjaan / referensi..."
                                           class="w-full text-xs px-3 py-1.5 rounded-lg border border-gray-300 bg-white">
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Tombol Tambah / Kurangi Pertemuan Manual -->
                <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                    <button type="button" @click="totalMeetings++; onTotalMeetingsChange();"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-purple-50 hover:bg-purple-100 text-purple-700 text-xs font-bold transition border border-purple-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        + Tambah 1 Pertemuan Lagi
                    </button>
                    <button type="button" x-show="totalMeetings > 1" @click="totalMeetings--; onTotalMeetingsChange();"
                            class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-gray-50 hover:bg-gray-100 text-gray-600 text-xs font-semibold transition border border-gray-200">
                        - Kurangi 1 Pertemuan
                    </button>
                </div>
            </div>
        </div>

        <!-- Tombol Aksi Simpan -->
        <div class="flex items-center justify-end gap-4 pt-4">
            <a href="{{ route('class-periods.show', $classPeriod->id) }}" class="px-6 py-3 rounded-xl border border-gray-300 text-gray-700 font-semibold hover:bg-gray-50 transition text-sm">
                Batal
            </a>
            <button type="submit" class="px-8 py-3.5 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-bold transition shadow-lg shadow-indigo-600/30 flex items-center gap-2 text-base">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                Simpan Kurikulum
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function customClassCurriculumBuilder(config) {
    return {
        catalog: config.catalog || [],
        totalMeetings: config.totalMeetings || 8,
        meetingsList: [],

        init() {
            const existing = config.existingMeetings || [];
            if (existing.length > 0) {
                this.meetingsList = existing.map(m => ({ ...m }));
                this.totalMeetings = this.meetingsList.length;
            } else {
                this.syncMeetingsList();
            }
        },

        onTotalMeetingsChange() {
            if (this.totalMeetings < 1) this.totalMeetings = 1;
            this.syncMeetingsList();
        },

        syncMeetingsList() {
            const currentLen = this.meetingsList.length;
            const targetLen = parseInt(this.totalMeetings) || 1;

            if (targetLen > currentLen) {
                for (let i = currentLen; i < targetLen; i++) {
                    this.meetingsList.push({
                        meeting_number: i + 1,
                        material_type: 'existing',
                        selectedCatalogIndex: '',
                        selectedMeetingIndex: '',
                        source_program_id: null,
                        meeting_id: null,
                        topic: 'Pertemuan ' + (i + 1),
                        material_url: '',
                        material_notes: '',
                        meeting_date: '',
                        start_time: '',
                        end_time: ''
                    });
                }
            } else if (targetLen < currentLen) {
                this.meetingsList.splice(targetLen);
            }
        },

        getAvailableMeetingsForCatalog(catalogIndex) {
            if (catalogIndex === '' || catalogIndex === null || !this.catalog[catalogIndex]) {
                return [];
            }
            return this.catalog[catalogIndex].meetings || [];
        },

        onMeetingCatalogChange(idx) {
            const mt = this.meetingsList[idx];
            mt.selectedMeetingIndex = '';
            mt.meeting_id = null;
            if (mt.selectedCatalogIndex !== '' && this.catalog[mt.selectedCatalogIndex]) {
                mt.source_program_id = this.catalog[mt.selectedCatalogIndex].program_id;
            } else {
                mt.source_program_id = null;
            }
        },

        onMeetingTopicSelect(idx) {
            const mt = this.meetingsList[idx];
            if (mt.selectedCatalogIndex !== '' && mt.selectedMeetingIndex !== '') {
                const meetings = this.getAvailableMeetingsForCatalog(mt.selectedCatalogIndex);
                const selected = meetings[mt.selectedMeetingIndex];
                if (selected) {
                    mt.topic = selected.title;
                    mt.meeting_id = selected.meeting_id || null;
                }
            }
        },

        applyQuickPreset(programName) {
            if (!programName) return;
            const cat = this.catalog.find(c => c.program_name === programName);
            if (!cat || !cat.meetings) return;

            const catIndex = this.catalog.indexOf(cat);
            cat.meetings.forEach((m, i) => {
                if (i < this.meetingsList.length) {
                    const mt = this.meetingsList[i];
                    mt.material_type = 'existing';
                    mt.selectedCatalogIndex = catIndex;
                    mt.source_program_id = cat.program_id;
                    mt.selectedMeetingIndex = i;
                    mt.topic = m.title;
                    mt.meeting_id = m.meeting_id || null;
                }
            });
        }
    };
}
</script>
@endpush
@endsection
