<div class="group relative bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
    <div class="p-6">
        <div class="flex justify-between items-start mb-4">
            <span class="px-3 py-1 bg-{{ $task == 1 ? 'teal' : 'orange' }}-100 text-{{ $task == 1 ? 'teal' : 'orange' }}-600 rounded-full text-xs font-semibold">{{ $type }} {{ $meeting->meeting_number }}</span>
            @if(Auth::user()->isAdmin())
            <div class="flex gap-2">
                <button onclick='editMeeting(@json($meeting))' class="text-gray-400 hover:text-blue-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                </button>
                <form action="{{ route('assignments.ielts.writing.destroy', $meeting->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-gray-400 hover:text-red-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </button>
                </form>
            </div>
            @endif
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-{{ $task == 1 ? 'teal' : 'orange' }}-600 transition-colors">{{ $meeting->title }}</h3>
        <p class="text-gray-500 text-sm mb-4 line-clamp-2 h-10">{{ $meeting->prompt }}</p>
        
        <a href="{{ route('assignments.ielts-academic.writing.meeting', ['task' => $task, 'id' => $meeting->id]) }}" class="flex items-center text-{{ $task == 1 ? 'teal' : 'orange' }}-600 text-sm font-semibold mt-auto">
            <span>Start {{ $type }}</span>
            <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
        </a>
    </div>
</div>
