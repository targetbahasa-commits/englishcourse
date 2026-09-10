{{-- Admin/Teacher-only per-question AI grading toggle, shown on a practice card. --}}
<div x-data="{
        aiEnabled: @js((bool) $meeting->ai_grading_enabled),
        loading: false,
        async toggleAi() {
            if (this.loading) return;
            this.loading = true;
            try {
                const res = await fetch('{{ route('admin.ielts-writing-meetings.toggle-ai', $meeting->id) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ enabled: !this.aiEnabled })
                });
                const data = await res.json();
                if (res.ok && data.status === 'success') {
                    this.aiEnabled = data.ai_grading_enabled;
                } else {
                    alert('Gagal mengubah mode penilaian AI.');
                }
            } catch (e) {
                alert('Terjadi kesalahan jaringan.');
            } finally {
                this.loading = false;
            }
        }
     }"
     @click.stop.prevent
     title="Mode penilaian untuk soal ini"
     class="absolute top-3 right-3 z-10 flex items-center gap-1.5 bg-white border border-slate-200 rounded-full pl-2 pr-1 py-1 shadow-sm">
    <span class="text-[10px] font-bold" :class="aiEnabled ? 'text-emerald-600' : 'text-amber-600'" x-text="aiEnabled ? '🤖 AI' : '✏️ Manual'"></span>
    <button type="button" @click.stop.prevent="toggleAi()" :disabled="loading"
            class="relative inline-flex h-4 w-7 shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none"
            :class="aiEnabled ? 'bg-emerald-500' : 'bg-slate-400'">
        <span class="pointer-events-none inline-block h-3 w-3 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"
              :class="aiEnabled ? 'translate-x-3' : 'translate-x-0'"></span>
    </button>
</div>
