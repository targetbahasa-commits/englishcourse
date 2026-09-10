@props(['program', 'selectedClassPeriod'])

@if(Auth::check() && (Auth::user()->isAdmin() || Auth::user()->isTeacher()) && $selectedClassPeriod)
    @php
        $classMeetingOptions = $selectedClassPeriod->classMeetings()
            ->orderBy('meeting_number')
            ->get();
    @endphp

    @if($classMeetingOptions->isNotEmpty())
        <form action="{{ route('assignments.class-meeting') }}" method="POST" class="flex items-center gap-2 bg-white p-2 rounded-xl shadow-sm">
            @csrf
            <input type="hidden" name="program_id" value="{{ $program->id }}">
            <span class="text-sm font-semibold text-gray-600 pl-2">Jam Kelas:</span>
            <select name="class_meeting_id" class="border-none bg-white rounded-lg text-sm focus:ring-2 focus:ring-blue-500 min-w-[240px]">
                <option value="" disabled {{ !$program->active_class_meeting_id ? 'selected' : '' }}>Pilih jam kelas</option>
                @foreach($classMeetingOptions as $classMeetingOption)
                    <option value="{{ $classMeetingOption->id }}" {{ $program->active_class_meeting_id === $classMeetingOption->id ? 'selected' : '' }}>
                        Meeting {{ $classMeetingOption->meeting_number }}
                        @if($classMeetingOption->meeting_date)
                            - {{ $classMeetingOption->meeting_date->translatedFormat('l, d M Y') }}
                        @endif
                        @if($classMeetingOption->start_time && $classMeetingOption->end_time)
                            - {{ $classMeetingOption->start_time->format('H:i') }}-{{ $classMeetingOption->end_time->format('H:i') }}
                        @endif
                    </option>
                @endforeach
            </select>
            <button type="submit" class="p-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition" title="Set jam kelas aktif" data-loading-label="Applying">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </button>
        </form>
    @endif
@endif
