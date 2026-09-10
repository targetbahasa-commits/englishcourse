@php
    $initialScore = old('teacher_score', $meetingScore->teacher_score);
    $initialFeedback = old('teacher_feedback', $meetingScore->teacher_feedback ?? '');
@endphp
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 h-fit"
     x-data="{
        teacherScore: {{ $initialScore !== null ? $initialScore : 'null' }},
        teacherFeedback: {{ \Illuminate\Support\Js::from($initialFeedback) }},
        syncTimer: null,
        syncNow() {
            fetch('{{ route('api.submission-review.sync', $meetingScore->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ teacher_score: this.teacherScore, teacher_feedback: this.teacherFeedback })
            }).catch(() => {});
        },
        queueSync() {
            clearTimeout(this.syncTimer);
            this.syncTimer = setTimeout(() => this.syncNow(), 800);
        }
     }"
     @if(!$meetingScore->reviewed_at) x-init="syncNow()" @endif
>
    <div class="flex items-center justify-between gap-2 mb-4">
        <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wide">Koreksi &amp; Nilai Guru</h2>
        @unless($meetingScore->reviewed_at)
            <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-red-600" title="Siswa bisa melihat perubahan ini secara live sebelum disimpan">
                <span class="w-1.5 h-1.5 rounded-full bg-red-500 animate-pulse"></span>
                Live &mdash; sedang ditonton siswa
            </span>
        @endunless
    </div>

    @if($meetingScore->reviewed_at)
        <p class="text-xs text-gray-500 mb-4">
            Terakhir direview oleh <span class="font-semibold text-gray-700">{{ $meetingScore->reviewer->name ?? '—' }}</span>
            pada {{ $meetingScore->reviewed_at->format('d M Y H:i') }}.
        </p>
    @endif

    <form method="POST" action="{{ $reviewRoute }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-xs font-bold text-gray-600 mb-1">Nilai Guru (0–100)</label>
            <input type="number" name="teacher_score" min="0" max="100" step="0.5"
                   x-model.number="teacherScore" @input="queueSync()"
                   class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-600 mb-1">Catatan Guru</label>
            <textarea name="teacher_feedback" rows="8"
                      x-model="teacherFeedback" @input="queueSync()"
                      class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500"
                      placeholder="Tulis koreksi / masukan untuk siswa..."></textarea>
        </div>

        <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-xl transition-colors">
            Simpan Koreksi
        </button>
    </form>
</div>
