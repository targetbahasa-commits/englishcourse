@extends('layouts.admin')

@section('title', 'Add WHV Program')

@section('content')
<div class="max-w-3xl mx-auto py-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Tambah Program WHV</h1>
            <p class="text-sm text-gray-500 mt-1">Buat konten program Working Holiday Visa yang akan menjadi sumber utama landing page publik.</p>
        </div>
        <a href="{{ route('admin.whv-applications.index') }}" class="text-gray-500 hover:text-gray-700 flex items-center gap-1 font-medium text-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Daftar
        </a>
    </div>

    <div class="mb-6 rounded-2xl border border-amber-100 bg-[linear-gradient(135deg,rgba(255,251,235,1),rgba(255,237,213,0.92))] p-5 shadow-sm">
        <p class="text-xs font-bold uppercase tracking-[0.2em] text-amber-700/70">Editorial Note</p>
        <p class="mt-2 text-sm leading-7 text-gray-700">Isi form ini dipakai langsung untuk menyusun halaman WHV Australia di publik. Prioritaskan copy yang jelas, ringkas, dan siap dibaca calon pelamar, bukan sekadar catatan internal.</p>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <form action="{{ route('admin.whv-applications.store') }}" method="POST" class="p-6 sm:p-8">
            @csrf
            <div class="space-y-6">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    {{-- Title --}}
                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-700 mb-1">Judul Program <span class="text-red-500">*</span></label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3"
                            placeholder="e.g., Working Holiday Visa Subclass 462">
                        @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    {{-- Visa Type --}}
                    <div>
                        <label for="visa_type" class="block text-sm font-semibold text-gray-700 mb-1">Jenis Visa <span class="text-red-500">*</span></label>
                        <input type="text" name="visa_type" id="visa_type" value="{{ old('visa_type') }}" required
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3"
                            placeholder="e.g., Working Holiday Visa, Young Professional Visa">
                        @error('visa_type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    {{-- Country --}}
                    <div>
                        <label for="country" class="block text-sm font-semibold text-gray-700 mb-1">Negara <span class="text-red-500">*</span></label>
                        <input type="text" name="country" id="country" value="{{ old('country', 'Australia') }}" required
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3"
                            placeholder="e.g., Australia">
                        @error('country')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    {{-- Sponsored By --}}
                    <div>
                        <label for="sponsored_by" class="block text-sm font-semibold text-gray-700 mb-1">Instansi Resmi <span class="text-gray-400 font-normal">(opsional)</span></label>
                        <input type="text" name="sponsored_by" id="sponsored_by" value="{{ old('sponsored_by') }}"
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3"
                            placeholder="e.g., Australian Department of Home Affairs">
                        @error('sponsored_by')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="status" class="block text-sm font-semibold text-gray-700 mb-1">Status Program <span class="text-red-500">*</span></label>
                        <select name="status" id="status" required
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3">
                            <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="open" {{ old('status') == 'open' ? 'selected' : '' }}>Open</option>
                            <option value="closed" {{ old('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                        @error('status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="opening_date" class="block text-sm font-semibold text-gray-700 mb-1">Tanggal Dibuka <span class="text-gray-400 font-normal">(opsional)</span></label>
                        <input type="date" name="opening_date" id="opening_date" value="{{ old('opening_date') }}"
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3">
                        @error('opening_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    {{-- Age Requirement --}}
                    <div>
                        <label for="age_requirement" class="block text-sm font-semibold text-gray-700 mb-1">Syarat Usia <span class="text-gray-400 font-normal">(opsional)</span></label>
                        <input type="text" name="age_requirement" id="age_requirement" value="{{ old('age_requirement') }}"
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3"
                            placeholder="e.g., 18-35">
                        @error('age_requirement')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="education_requirement" class="block text-sm font-semibold text-gray-700 mb-1">Syarat Pendidikan <span class="text-gray-400 font-normal">(opsional)</span></label>
                        <input type="text" name="education_requirement" id="education_requirement" value="{{ old('education_requirement') }}"
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3"
                            placeholder="e.g., Diploma (D3) or active student">
                        @error('education_requirement')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="financial_requirement" class="block text-sm font-semibold text-gray-700 mb-1">Syarat Dana <span class="text-gray-400 font-normal">(opsional)</span></label>
                        <input type="text" name="financial_requirement" id="financial_requirement" value="{{ old('financial_requirement') }}"
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3"
                            placeholder="e.g., AUD 5,000 savings proof">
                        @error('financial_requirement')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                </div>

                <div>
                    <label for="support_letter_info" class="block text-sm font-semibold text-gray-700 mb-1">Info Surat Dukungan SDUWHV <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <textarea name="support_letter_info" id="support_letter_info" rows="4"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3"
                        placeholder="Jelaskan cara pelamar Indonesia memperoleh surat dukungan SDUWHV dan kapan dokumen ini dibutuhkan...">{{ old('support_letter_info') }}</textarea>
                    @error('support_letter_info')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    {{-- Visa Duration --}}
                    <div>
                        <label for="visa_duration" class="block text-sm font-semibold text-gray-700 mb-1">Durasi Visa <span class="text-gray-400 font-normal">(opsional)</span></label>
                        <input type="text" name="visa_duration" id="visa_duration" value="{{ old('visa_duration') }}"
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3"
                            placeholder="e.g., 12 months">
                        @error('visa_duration')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    {{-- Processing Time --}}
                    <div>
                        <label for="processing_time" class="block text-sm font-semibold text-gray-700 mb-1">Estimasi Proses <span class="text-gray-400 font-normal">(opsional)</span></label>
                        <input type="text" name="processing_time" id="processing_time" value="{{ old('processing_time') }}"
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3"
                            placeholder="e.g., 2-4 weeks">
                        @error('processing_time')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    {{-- Application Fee --}}
                    <div>
                        <label for="application_fee" class="block text-sm font-semibold text-gray-700 mb-1">Biaya Aplikasi <span class="text-gray-400 font-normal">(opsional)</span></label>
                        <input type="text" name="application_fee" id="application_fee" value="{{ old('application_fee') }}"
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3"
                            placeholder="e.g., AUD 600">
                        @error('application_fee')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    {{-- Application Deadline --}}
                    <div>
                        <label for="application_deadline" class="block text-sm font-semibold text-gray-700 mb-1">Batas Akhir Pendaftaran <span class="text-gray-400 font-normal">(opsional)</span></label>
                        <input type="date" name="application_deadline" id="application_deadline" value="{{ old('application_deadline') }}"
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3">
                        @error('application_deadline')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    {{-- English Requirement --}}
                    <div>
                        <label for="english_requirement" class="block text-sm font-semibold text-gray-700 mb-1">Syarat Bahasa Inggris <span class="text-gray-400 font-normal">(opsional)</span></label>
                        <select name="english_requirement" id="english_requirement"
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3">
                            <option value="">Tidak ada</option>
                            <option value="ielts" {{ old('english_requirement') == 'ielts' ? 'selected' : '' }}>IELTS</option>
                            <option value="toefl_itp" {{ old('english_requirement') == 'toefl_itp' ? 'selected' : '' }}>TOEFL ITP</option>
                            <option value="toefl_ibt" {{ old('english_requirement') == 'toefl_ibt' ? 'selected' : '' }}>TOEFL iBT</option>
                            <option value="pte" {{ old('english_requirement') == 'pte' ? 'selected' : '' }}>PTE</option>
                            <option value="multiple" {{ old('english_requirement') == 'multiple' ? 'selected' : '' }}>Beberapa Opsi Tes</option>
                            <option value="other" {{ old('english_requirement') == 'other' ? 'selected' : '' }}>Lainnya</option>
                        </select>
                        @error('english_requirement')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    {{-- Min Score --}}
                    <div>
                        <label for="min_score" class="block text-sm font-semibold text-gray-700 mb-1">Skor Minimum <span class="text-gray-400 font-normal">(opsional)</span></label>
                        <input type="text" name="min_score" id="min_score" value="{{ old('min_score') }}"
                            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3"
                            placeholder="contoh: IELTS 4.5 / TOEFL iBT 32 / PTE 30">
                        @error('min_score')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-1">Deskripsi Program <span class="text-red-500">*</span></label>
                    <textarea name="description" id="description" rows="6" required
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3"
                        placeholder="Ringkas program WHV ini dalam 2-4 kalimat yang mudah dipahami calon pelamar...">{{ old('description') }}</textarea>
                    @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Eligibility Criteria --}}
                <div>
                    <label for="eligibility_criteria" class="block text-sm font-semibold text-gray-700 mb-1">Ringkasan Kelayakan Pelamar <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <textarea name="eligibility_criteria" id="eligibility_criteria" rows="4"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3"
                        placeholder="Jelaskan profil pelamar yang ideal dan poin kelayakan utama secara singkat...">{{ old('eligibility_criteria') }}</textarea>
                    @error('eligibility_criteria')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Requirements --}}
                <div>
                    <label for="requirements" class="block text-sm font-semibold text-gray-700 mb-1">Detail Persyaratan <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <textarea name="requirements" id="requirements" rows="4"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3"
                        placeholder="Gunakan format Judul: penjelasan. Pisahkan tiap poin dengan baris kosong agar tampil rapi di halaman publik...">{{ old('requirements') }}</textarea>
                    <p class="mt-2 text-xs leading-6 text-gray-500">Contoh: Bukti Dana: Minimal AUD 5.000 di rekening aktif.</p>
                    @error('requirements')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Benefits --}}
                <div>
                    <label for="benefits" class="block text-sm font-semibold text-gray-700 mb-1">Keuntungan Program <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <textarea name="benefits" id="benefits" rows="4"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3"
                        placeholder="Gunakan format Judul: penjelasan. Contoh: Pengalaman Internasional: Peserta bisa bekerja sambil membangun exposure global...">{{ old('benefits') }}</textarea>
                    @error('benefits')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="job_opportunities" class="block text-sm font-semibold text-gray-700 mb-1">Peluang Kerja <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <textarea name="job_opportunities" id="job_opportunities" rows="4"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3"
                        placeholder="Sebutkan sektor populer, contoh posisi, serta gambaran income atau lingkungan kerja secara singkat...">{{ old('job_opportunities') }}</textarea>
                    @error('job_opportunities')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="cost_breakdown" class="block text-sm font-semibold text-gray-700 mb-1">Rincian Biaya <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <textarea name="cost_breakdown" id="cost_breakdown" rows="4"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3"
                        placeholder="Gunakan format Komponen: estimasi biaya. Contoh: Visa Fee: sekitar AUD 650...">{{ old('cost_breakdown') }}</textarea>
                    @error('cost_breakdown')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="testimonials" class="block text-sm font-semibold text-gray-700 mb-1">Testimoni atau Catatan Konten <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <textarea name="testimonials" id="testimonials" rows="4"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3"
                        placeholder="Isi dengan testimoni singkat, insight alumni, atau catatan editorial yang relevan untuk calon pelamar...">{{ old('testimonials') }}</textarea>
                    @error('testimonials')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="faqs" class="block text-sm font-semibold text-gray-700 mb-1">FAQ <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <textarea name="faqs" id="faqs" rows="4"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3"
                        placeholder="Pisahkan tiap FAQ dengan baris kosong. Baris pertama untuk pertanyaan, baris berikutnya untuk jawaban...">{{ old('faqs') }}</textarea>
                    <p class="mt-2 text-xs leading-6 text-gray-500">Contoh: Apakah harus punya pengalaman kerja? Lalu tulis jawaban di baris berikutnya.</p>
                    @error('faqs')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- How to Apply --}}
                <div>
                    <label for="how_to_apply" class="block text-sm font-semibold text-gray-700 mb-1">Langkah Pendaftaran <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <textarea name="how_to_apply" id="how_to_apply" rows="4"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3"
                        placeholder="Tulis langkah bernomor 1., 2., 3., dan seterusnya agar otomatis terpecah menjadi step di halaman publik...">{{ old('how_to_apply') }}</textarea>
                    @error('how_to_apply')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- URL --}}
                <div>
                    <label for="url" class="block text-sm font-semibold text-gray-700 mb-1">Website Resmi <span class="text-gray-400 font-normal">(opsional)</span></label>
                    <input type="url" name="url" id="url" value="{{ old('url') }}"
                        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-amber-500 focus:ring-amber-500 p-3"
                        placeholder="https://...">
                    @error('url')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>

                {{-- Active Status --}}
                <div class="flex items-center pt-2">
                    <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                        class="w-5 h-5 text-amber-600 bg-gray-100 border-gray-300 rounded focus:ring-amber-500 cursor-pointer">
                    <div class="ml-3">
                        <label for="is_active" class="text-sm font-medium text-gray-800 cursor-pointer">Tampilkan di publik</label>
                    </div>
                </div>

            </div>

            <div class="mt-8 flex gap-4 pt-6 border-t border-gray-200">
                <button type="submit" class="flex-1 px-4 py-3 bg-amber-600 hover:bg-amber-700 text-white font-bold rounded-xl transition">
                    Simpan Program
                </button>
                <a href="{{ route('admin.whv-applications.index') }}" class="flex-1 px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold rounded-xl transition text-center">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
