@props(['track', 'meeting', 'enabled'])
<div x-data="{
        aiEnabled: {{ $enabled ? 'true' : 'false' }},
        loading: false,
        async toggleAi() {
            if (this.loading) return;
            this.loading = true;
            try {
                const res = await fetch('{{ route('admin.grammar-writing-review.toggle-ai') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ track: '{{ $track }}', meeting: {{ (int) $meeting }}, enabled: !this.aiEnabled })
                });
                const data = await res.json();
                if (res.ok && data.status === 'success') {
                    this.aiEnabled = data.ai_enabled;
                } else {
                    alert(data.message || 'Gagal mengubah pengaturan penilaian AI.');
                }
            } catch (e) {
                console.error(e);
                alert('Terjadi kesalahan jaringan.');
            } finally {
                this.loading = false;
            }
        }
    }"
    class="inline-flex items-center gap-1.5 bg-gray-50 px-2 py-1 rounded-full border border-gray-200"
    title="Khusus admin/pengajar: aktifkan/nonaktifkan penilaian AI otomatis untuk meeting ini"
>
    <span class="text-[10px] font-bold uppercase" :class="aiEnabled ? 'text-emerald-600' : 'text-gray-500'" x-text="aiEnabled ? 'AI ON' : 'AI OFF'"></span>
    <button type="button" @click.stop.prevent="toggleAi()" :disabled="loading"
            class="relative inline-flex h-4 w-8 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200"
            :class="aiEnabled ? 'bg-emerald-500' : 'bg-gray-300'">
        <span class="sr-only">Toggle AI grading</span>
        <span class="pointer-events-none inline-block h-3 w-3 transform rounded-full bg-white shadow ring-0 transition duration-200"
              :class="aiEnabled ? 'translate-x-4' : 'translate-x-0'"></span>
    </button>
</div>
