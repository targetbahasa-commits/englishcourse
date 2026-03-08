{{-- Template Variables Legend Popup --}}
<div class="relative inline-block" x-data="{ show: false }">
    <button type="button"
        @click="show = !show"
        @keydown.escape.window="show = false"
        class="ml-2 w-5 h-5 rounded-full bg-blue-100 text-blue-600 hover:bg-blue-200 text-xs font-bold inline-flex items-center justify-center transition focus:outline-none focus:ring-2 focus:ring-blue-400"
        title="Template variable legend">
        i
    </button>

    <div x-show="show" x-cloak @click.outside="show = false"
        x-transition:enter="transition ease-out duration-150"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-50 left-0 mt-2 w-80 bg-white border border-blue-100 rounded-2xl shadow-xl p-4 text-sm">

        <div class="flex items-center justify-between mb-3">
            <p class="font-semibold text-gray-800">📋 Template Variables</p>
            <button type="button" @click="show = false" class="text-gray-400 hover:text-gray-600 text-lg leading-none">&times;</button>
        </div>
        <p class="text-xs text-gray-500 mb-3">Gunakan variabel berikut dalam pesan Anda. Variabel akan diganti secara otomatis saat pesan dikirim.</p>

        <div class="space-y-2">
            @foreach([
                ['<<nama>>', 'Nama lengkap pengguna'],
                ['<<email>>', 'Alamat email pengguna'],
                ['<<program>>', 'Nama program yang diikuti'],
                ['<<skor>>', 'Skor hasil tes pengguna'],
                ['<<tes>>', 'Jenis tes yang dikerjakan (TOEFL, IELTS, dll.)'],
                ['<<kelas>>', 'Nama kelas atau kelas periode'],
                ['<<tanggal>>', 'Tanggal hari ini'],
            ] as [$var, $desc])
            <div class="flex items-start gap-2 p-2 bg-gray-50 rounded-lg">
                <code class="text-blue-600 font-mono text-xs bg-blue-50 px-1.5 py-0.5 rounded whitespace-nowrap">{{ $var }}</code>
                <span class="text-xs text-gray-600">{{ $desc }}</span>
            </div>
            @endforeach
        </div>

        <div class="mt-3 pt-3 border-t border-gray-100 text-xs text-gray-400">
            Contoh: <em class="text-gray-600">"Halo &lt;&lt;nama&gt;&gt;, skor &lt;&lt;tes&gt;&gt; Anda adalah &lt;&lt;skor&gt;&gt;."</em>
        </div>
    </div>
</div>
