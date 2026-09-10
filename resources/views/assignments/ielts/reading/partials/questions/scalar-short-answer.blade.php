@unless($hasInlineBlank ?? false)
<!-- Short Answer Input -->
<div class="pl-0 md:pl-8 mt-2 flex items-center gap-1.5">
    <span class="text-blue-600 font-bold text-sm md:text-base select-none pointer-events-none">{{ $currentBadgeNum }}</span>
    <input type="text"
           x-model="selected"
           data-qid="{{ $question['id'] }}"
           class="user-answer border-0 border-b-2 border-gray-400 focus:border-blue-600 rounded-none outline-none bg-transparent px-2 py-1 w-full max-w-sm text-gray-900 font-medium transition-all focus:ring-0 placeholder-gray-400 text-sm md:text-base"
           placeholder="......"
    >
</div>
@endunless
