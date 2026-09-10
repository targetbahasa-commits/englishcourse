@php
    use Carbon\Carbon;
    $monthName = Carbon::createFromDate($calendarYear, $calendarMonth, 1)->format('F Y');
    $firstDay  = Carbon::createFromDate($calendarYear, $calendarMonth, 1);
    $daysInMonth = $firstDay->daysInMonth;
    $startDow  = $firstDay->dayOfWeek; // 0=Sun
    $prevMonth = $firstDay->copy()->subMonth();
    $nextMonth = $firstDay->copy()->addMonth();
    $statusColors = ['draft'=>'bg-gray-200 text-gray-700','scheduled'=>'bg-blue-500 text-white','published'=>'bg-green-500 text-white','cancelled'=>'bg-red-400 text-white'];
    $platformIcons = ['Instagram'=>'📸','TikTok'=>'🎵','Facebook'=>'👥','WhatsApp'=>'💬','YouTube'=>'▶️','LinkedIn'=>'💼'];
@endphp

<div class="p-6">
    {{-- Calendar Nav --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-lg font-bold text-gray-800">{{ $monthName }}</h2>
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.social-media.index', $program) }}?cal_year={{ $prevMonth->year }}&cal_month={{ $prevMonth->month }}&tab=calendar"
               class="p-2 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            </a>
            <a href="{{ route('admin.social-media.index', $program) }}?cal_year={{ now()->year }}&cal_month={{ now()->month }}"
               class="px-3 py-1.5 text-xs font-medium text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 rounded-lg transition">
                Today
            </a>
            <a href="{{ route('admin.social-media.index', $program) }}?cal_year={{ $nextMonth->year }}&cal_month={{ $nextMonth->month }}&tab=calendar"
               class="p-2 text-gray-500 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>

    {{-- Day headers --}}
    <div class="grid grid-cols-7 gap-1 mb-1">
        @foreach(['Sun','Mon','Tue','Wed','Thu','Fri','Sat'] as $day)
        <div class="text-center text-xs font-semibold text-gray-400 py-2">{{ $day }}</div>
        @endforeach
    </div>

    {{-- Calendar grid --}}
    <div class="grid grid-cols-7 gap-1">
        {{-- Empty cells before month start --}}
        @for($i = 0; $i < $startDow; $i++)
            <div class="rounded-xl bg-gray-50 min-h-[100px] p-1.5 opacity-40"></div>
        @endfor

        {{-- Day cells --}}
        @for($day = 1; $day <= $daysInMonth; $day++)
            @php
                $isToday = now()->year == $calendarYear && now()->month == $calendarMonth && now()->day == $day;
                $dayPosts = $calendarPosts->get($day, collect());
            @endphp
            <div class="rounded-xl {{ $isToday ? 'bg-indigo-50 ring-2 ring-indigo-400' : 'bg-white border border-gray-100 hover:border-indigo-200' }} min-h-[100px] p-1.5 transition">
                <div class="flex items-center justify-center w-7 h-7 rounded-full mb-1 {{ $isToday ? 'bg-indigo-600 text-white' : 'text-gray-600' }} text-sm font-semibold">
                    {{ $day }}
                </div>
                <div class="space-y-0.5">
                    @foreach($dayPosts->take(3) as $post)
                        @php
                            $color = $statusColors[$post->status] ?? 'bg-gray-200 text-gray-700';
                            $icons = implode('', array_map(fn($p) => $platformIcons[$p] ?? '📄', array_slice($post->platforms ?? [], 0, 2)));
                        @endphp
                        <div class="cal-day-event {{ $color }} text-xs px-1.5 py-1 rounded-lg cursor-pointer truncate"
                             onclick="window.dispatchEvent(new CustomEvent('view-post', {detail: {{ $post->id }}}))"
                             title="{{ $post->title }} — {{ $post->publish_time ? \Carbon\Carbon::parse($post->publish_time)->format('H:i') : '' }}">
                            {{ $icons }} {{ $post->title }}
                        </div>
                    @endforeach
                    @if($dayPosts->count() > 3)
                        <div class="text-xs text-gray-400 font-medium px-1.5">+{{ $dayPosts->count() - 3 }} more</div>
                    @endif
                </div>
            </div>
        @endfor

        {{-- Fill remaining cells --}}
        @php
            $totalCells = $startDow + $daysInMonth;
            $remainder = $totalCells % 7;
            $fillers = $remainder > 0 ? 7 - $remainder : 0;
        @endphp
        @for($i = 0; $i < $fillers; $i++)
            <div class="rounded-xl bg-gray-50 min-h-[100px] p-1.5 opacity-40"></div>
        @endfor
    </div>

    {{-- Legend --}}
    <div class="flex items-center gap-4 mt-4 flex-wrap">
        @foreach($statusColors as $status => $color)
        <div class="flex items-center gap-2">
            <div class="w-3 h-3 rounded-full {{ $color }}"></div>
            <span class="text-xs text-gray-500">{{ ucfirst($status) }}</span>
        </div>
        @endforeach
    </div>
</div>

<script>
window.addEventListener('view-post', (e) => {
    const appEl = document.querySelector('[x-data]');
    if (appEl && window.Alpine) {
        const data = Alpine.$data(appEl);
        if (data && data.viewPost) data.viewPost(e.detail);
    }
});
</script>
