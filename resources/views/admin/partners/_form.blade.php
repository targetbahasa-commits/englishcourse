@php
    $partner = $partner ?? null;
@endphp

<div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
    <div>
        <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama Instansi / Perusahaan <span class="text-red-500">*</span></label>
        <input type="text" name="name" id="name" value="{{ old('name', $partner->name ?? '') }}" required
            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
            placeholder="cth. PT Maju Jaya">
        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="industry" class="block text-sm font-semibold text-gray-700 mb-1">Industri <span class="text-gray-400 font-normal">(opsional)</span></label>
        <input type="text" name="industry" id="industry" value="{{ old('industry', $partner->industry ?? '') }}"
            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
            placeholder="cth. Manufaktur, Sekolah, BUMN">
        @error('industry')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-6">
    <div>
        <label for="pic_name" class="block text-sm font-semibold text-gray-700 mb-1">Nama PIC <span class="text-gray-400 font-normal">(opsional)</span></label>
        <input type="text" name="pic_name" id="pic_name" value="{{ old('pic_name', $partner->pic_name ?? '') }}"
            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
        @error('pic_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="pic_phone" class="block text-sm font-semibold text-gray-700 mb-1">No. HP / WA PIC <span class="text-gray-400 font-normal">(opsional)</span></label>
        <input type="text" name="pic_phone" id="pic_phone" value="{{ old('pic_phone', $partner->pic_phone ?? '') }}"
            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
        @error('pic_phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="pic_email" class="block text-sm font-semibold text-gray-700 mb-1">Email PIC <span class="text-gray-400 font-normal">(opsional)</span></label>
        <input type="email" name="pic_email" id="pic_email" value="{{ old('pic_email', $partner->pic_email ?? '') }}"
            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
        @error('pic_email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mt-6 border-t border-gray-100 pt-6">
    <div>
        <label for="status" class="block text-sm font-semibold text-gray-700 mb-1">Status Kerjasama <span class="text-red-500">*</span></label>
        <select name="status" id="status" required class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
            @php $currentStatus = old('status', $partner->status ?? 'prospecting'); @endphp
            <option value="prospecting" {{ $currentStatus === 'prospecting' ? 'selected' : '' }}>Penjajakan</option>
            <option value="negotiating" {{ $currentStatus === 'negotiating' ? 'selected' : '' }}>Negosiasi</option>
            <option value="active" {{ $currentStatus === 'active' ? 'selected' : '' }}>Aktif</option>
            <option value="inactive" {{ $currentStatus === 'inactive' ? 'selected' : '' }}>Berakhir</option>
        </select>
        @error('status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label for="registration_code" class="block text-sm font-semibold text-gray-700 mb-1">Kode Pendaftaran</label>
        <input type="text" name="registration_code" id="registration_code"
            value="{{ old('registration_code', $partner->registration_code ?? ($suggestedCode ?? '')) }}"
            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3 uppercase"
            placeholder="cth. PTMAJU2026">
        <p class="mt-1 text-xs text-gray-500">Dipakai di link pendaftaran karyawan: <code>/daftar/mitra/&lt;kode&gt;</code>. Kosongkan untuk memakai kode yang disarankan.</p>
        @error('registration_code')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<div class="mt-6 border-t border-gray-100 pt-6">
    <label class="block text-sm font-semibold text-gray-700 mb-2">Detail Program Kerjasama <span class="text-gray-400 font-normal">(opsional)</span></label>
    <p class="text-xs text-gray-500 mb-3">Program apa, berapa kali pertemuan, dan periode pelaksanaan yang disepakati dengan partner ini.</p>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
        <div>
            <label for="program_id" class="block text-xs font-semibold text-gray-600 mb-1">Program</label>
            <select name="program_id" id="program_id" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
                <option value="">— Pilih Program —</option>
                @php $currentProgramId = old('program_id', $partner->program_id ?? ''); @endphp
                @foreach($programs ?? [] as $programOption)
                    <option value="{{ $programOption->id }}" {{ (string) $currentProgramId === (string) $programOption->id ? 'selected' : '' }}>{{ $programOption->name }}</option>
                @endforeach
            </select>
            @error('program_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="total_meetings" class="block text-xs font-semibold text-gray-600 mb-1">Jumlah Pertemuan</label>
            <input type="number" min="1" max="200" name="total_meetings" id="total_meetings" value="{{ old('total_meetings', $partner->total_meetings ?? '') }}"
                class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
                placeholder="cth. 16">
            @error('total_meetings')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label for="program_start_date" class="block text-xs font-semibold text-gray-600 mb-1">Mulai</label>
                <input type="date" name="program_start_date" id="program_start_date" value="{{ old('program_start_date', optional($partner->program_start_date ?? null)->format('Y-m-d')) }}"
                    class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
                @error('program_start_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="program_end_date" class="block text-xs font-semibold text-gray-600 mb-1">Selesai</label>
                <input type="date" name="program_end_date" id="program_end_date" value="{{ old('program_end_date', optional($partner->program_end_date ?? null)->format('Y-m-d')) }}"
                    class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
                @error('program_end_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mt-6">
    <div>
        <label for="discount_type" class="block text-sm font-semibold text-gray-700 mb-1">Tipe Harga Korporat <span class="text-gray-400 font-normal">(opsional)</span></label>
        @php $currentDiscountType = old('discount_type', $partner->discount_type ?? ''); @endphp
        <select name="discount_type" id="discount_type" class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3">
            <option value="">Tidak ada diskon khusus</option>
            <option value="percentage" {{ $currentDiscountType === 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
            <option value="fixed" {{ $currentDiscountType === 'fixed' ? 'selected' : '' }}>Potongan Tetap (Rp)</option>
        </select>
        @error('discount_type')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="discount_value" class="block text-sm font-semibold text-gray-700 mb-1">Nilai Diskon <span class="text-gray-400 font-normal">(opsional)</span></label>
        <input type="number" min="0" name="discount_value" id="discount_value" value="{{ old('discount_value', $partner->discount_value ?? '') }}"
            class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
            placeholder="cth. 20 atau 200000">
        <p class="mt-1 text-xs text-gray-500">Berlaku flat untuk program apapun yang diambil karyawan partner ini.</p>
        @error('discount_value')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div class="flex items-center pt-8">
        <input id="is_active" name="is_active" type="checkbox" value="1" {{ old('is_active', $partner->is_active ?? true) ? 'checked' : '' }}
            class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 cursor-pointer">
        <div class="ml-3">
            <label for="is_active" class="text-sm font-medium text-gray-800 cursor-pointer">Link Pendaftaran Aktif</label>
            <p class="text-xs text-gray-500">Nonaktifkan untuk mematikan link tanpa menghapus data partner.</p>
        </div>
    </div>
</div>

<div class="mt-6 border-t border-gray-100 pt-6">
    <label class="block text-sm font-semibold text-gray-700 mb-2">Output Hasil Kerjasama <span class="text-red-500">*</span></label>
    @php $currentDeliveryMode = old('certificate_delivery_mode', $partner->certificate_delivery_mode ?? 'certificate'); @endphp
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
        <label class="flex items-start gap-3 border rounded-xl p-3 cursor-pointer {{ $currentDeliveryMode === 'certificate' ? 'border-blue-400 bg-blue-50' : 'border-gray-200' }}">
            <input type="radio" name="certificate_delivery_mode" value="certificate" {{ $currentDeliveryMode === 'certificate' ? 'checked' : '' }} class="mt-1 text-blue-600 focus:ring-blue-500">
            <span>
                <span class="block text-sm font-semibold text-gray-800">Certificate</span>
                <span class="block text-xs text-gray-500">Target Bahasa menerbitkan sertifikat resmi untuk tiap karyawan yang menyelesaikan program.</span>
            </span>
        </label>
        <label class="flex items-start gap-3 border rounded-xl p-3 cursor-pointer {{ $currentDeliveryMode === 'score_sheet' ? 'border-blue-400 bg-blue-50' : 'border-gray-200' }}">
            <input type="radio" name="certificate_delivery_mode" value="score_sheet" {{ $currentDeliveryMode === 'score_sheet' ? 'checked' : '' }} class="mt-1 text-blue-600 focus:ring-blue-500">
            <span>
                <span class="block text-sm font-semibold text-gray-800">Lembar Nilai (Sheet)</span>
                <span class="block text-xs text-gray-500">Cukup kirim rekap nilai hasil ujian dalam bentuk sheet (CSV), tanpa sertifikat formal.</span>
            </span>
        </label>
    </div>
    @error('certificate_delivery_mode')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
</div>

<div class="mt-6 border-t border-gray-100 pt-6">
    <label for="notes" class="block text-sm font-semibold text-gray-700 mb-1">Catatan <span class="text-gray-400 font-normal">(opsional)</span></label>
    <textarea name="notes" id="notes" rows="4"
        class="mt-1 block w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 p-3"
        placeholder="Riwayat komunikasi, kesepakatan, dsb.">{{ old('notes', $partner->notes ?? '') }}</textarea>
    @error('notes')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
</div>
