<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 2</h3>

    {{-- Questions 11-15 --}}
    <h4 class="text-lg font-bold mb-2">Questions 11 &ndash; 15</h4>
    <p class="mb-6 text-gray-700">Complete the repair schedule.</p>

    <p class="mb-6 text-gray-700 italic">Write the correct letter, <strong>A-F</strong>, for each answer.</p>

    <div class="mb-6">
        <p class="font-bold text-gray-800 mb-4">Problems to Fix</p>
        <div class="space-y-3 pl-4 mb-8">
            <div class="flex gap-4"><strong class="font-bold">A</strong><span>Birds in ceiling</span></div>
            <div class="flex gap-4"><strong class="font-bold">B</strong><span>Broken windows</span></div>
            <div class="flex gap-4"><strong class="font-bold">C</strong><span>Electrical fault</span></div>
            <div class="flex gap-4"><strong class="font-bold">D</strong><span>Fallen tree</span></div>
            <div class="flex gap-4"><strong class="font-bold">E</strong><span>Leaking roof</span></div>
            <div class="flex gap-4"><strong class="font-bold">F</strong><span>Staining on walls</span></div>
        </div>
    </div>

    <p class="font-bold text-gray-800 mb-4">Schedule of Repairs</p>

    {{-- Timeline Image Placeholder --}}
    <div class="mb-8 text-center">
        <div class="p-3 border border-gray-200 bg-white rounded-xl shadow-sm max-w-3xl mx-auto"><img src="{{ asset('images/assignments/ielts/listening/part2/test5-timeline.png') }}" class="w-full h-auto rounded-lg" alt="Schedule of Repairs Timeline"></div>
    </div>

    <div class="space-y-4 max-w-sm mb-12">
        @for($q = 11; $q <= 15; $q++)
        <div class="flex items-center gap-3">
            <strong class="text-blue-600">{{ $q }}</strong>
            <span class="inline-block w-24">
                <select name="answers[{{ $q }}]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors cursor-pointer appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%234B5563%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:10px_10px] bg-no-repeat bg-[position:right_10px_center]">
                    <option value="" disabled selected>___</option>
                    @foreach(['A','B','C','D','E','F'] as $letter)
                        <option value="{{ $letter }}">{{ $letter }}</option>
                    @endforeach
                </select>
            </span>
        </div>
        @endfor
    </div>

    {{-- Questions 16-20 --}}
    <h4 class="text-lg font-bold mb-2">Questions 16-20</h4>
    <p class="mb-1 text-gray-700">Complete the sentences.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN TWO WORDS</strong> for each answer.</p>

    <p class="font-bold text-gray-800 mb-6">Additional Details Concerning Repairs</p>

    <div class="space-y-6">
        <div class="flex items-center gap-1 flex-wrap">
            <span class="text-gray-700">The stained walls will be painted</span>
            <strong class="text-blue-600">16</strong>
            <span class="inline-block w-40 mx-1">
                <input type="text" name="answers[16]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </div>

        <div class="flex items-center gap-1 flex-wrap">
            <span class="text-gray-700">Extra paint will be left in the</span>
            <strong class="text-blue-600">17</strong>
            <span class="inline-block w-40 mx-1">
                <input type="text" name="answers[17]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </div>

        <div class="flex items-center gap-1 flex-wrap">
            <span class="text-gray-700">The baby birds will be given to a</span>
            <strong class="text-blue-600">18</strong>
            <span class="inline-block w-40 mx-1">
                <input type="text" name="answers[18]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </div>

        <div class="flex items-center gap-1 flex-wrap">
            <span class="text-gray-700">The fallen tree will be used as</span>
            <strong class="text-blue-600">19</strong>
            <span class="inline-block w-40 mx-1">
                <input type="text" name="answers[19]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </div>

        <div class="flex items-center gap-1 flex-wrap">
            <span class="text-gray-700">The smaller parts of the tree will be put in a</span>
            <strong class="text-blue-600">20</strong>
            <span class="inline-block w-40 mx-1">
                <input type="text" name="answers[20]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </div>
    </div>
</div>
