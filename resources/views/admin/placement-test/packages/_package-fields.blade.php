@php $p = $package ?? null; @endphp
<div>
    <x-input-label value="Nama Paket" />
    <x-text-input name="title" type="text" class="mt-1 block w-full" value="{{ $p->title ?? '' }}" placeholder="mis. Paket 2" required />
</div>
<div>
    <x-input-label value="Deskripsi (opsional)" />
    <textarea name="description" rows="3" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">{{ $p->description ?? '' }}</textarea>
</div>
<div class="grid grid-cols-2 gap-4">
    <div>
        <x-input-label value="Aktif Mulai (opsional)" />
        <input type="datetime-local" name="active_from" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{ optional($p?->active_from)->format('Y-m-d\TH:i') }}">
    </div>
    <div>
        <x-input-label value="Aktif Sampai (opsional)" />
        <input type="datetime-local" name="active_until" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" value="{{ optional($p?->active_until)->format('Y-m-d\TH:i') }}">
    </div>
</div>
<p class="text-xs text-gray-500">Kosongkan kedua kolom di atas jika ingin paket ini aktif terus-menerus (tanpa batas waktu) setelah di-set active. Kalau diisi, paket otomatis mulai/berhenti melayani siswa sesuai jadwal ini - tidak perlu klik apa pun secara manual saat jadwalnya tiba.</p>
