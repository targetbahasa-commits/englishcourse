<!-- Diagram Labelling -->
<div class="mt-6 mb-8 overflow-x-auto">
    @if(!empty($question['instruction']) && empty($question['text']))
        <p class="mb-4 italic text-gray-700">{!! $question['instruction'] !!}</p>
    @endif

    <div class="relative rounded-xl overflow-hidden border border-gray-200 shadow-sm bg-white mx-auto" style="min-width: 900px !important;">
        <img src="{{ asset($question['image'] ?? '') }}" alt="Diagram for Question {{ $question['question_number'] ?? $question['id'] }}" class="w-full h-auto object-contain">

        @foreach($question['sub_questions'] ?? [] as $subQuestion)
            <div class="absolute transform -translate-y-1/2" style="top: {{ $subQuestion['y'] ?? 0 }}%; left: {{ $subQuestion['x'] ?? 0 }}%;">
                <div class="flex items-center border border-gray-400 rounded-md px-2 py-1 transition-all focus-within:border-blue-500 bg-white hover:border-blue-400 shadow-sm">
                    <span class="font-bold text-blue-700 mr-2 text-sm select-none">{{ $subQuestion['label'] }}</span>
                    <input type="text"
                           data-qid="{{ $subQuestion['id'] }}" x-model="selected['{{ $subQuestion['id'] }}']"
                           class="bg-transparent border-none p-0 w-24 focus:ring-0 text-sm text-gray-900 placeholder-gray-600 font-bold"
                           placeholder="Answer...">
                </div>
            </div>
        @endforeach
    </div>
</div>
