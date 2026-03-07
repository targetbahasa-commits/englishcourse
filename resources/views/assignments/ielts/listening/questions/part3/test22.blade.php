<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 3</h3>

    {{-- Questions 21-25: Multiple Choice --}}
    <h4 class="text-lg font-bold mb-2">Questions 21-25</h4>
    <p class="mb-6 text-gray-700">Choose the correct letter, <strong>A</strong>, <strong>B</strong> or <strong>C</strong>.</p>

    <div class="space-y-8 mb-12">

        {{-- Q21 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">21</strong>&nbsp; What was the most difficult problem when the company was founded?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'No clear objectives', 'B' => 'No formal structures', 'C' => 'No perfect premises'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[21]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q22 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">22</strong>&nbsp; What is the staff unsatisfied with?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'The type of work', 'B' => 'The work assignment', 'C' => 'The feeling of appreciation'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[22]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q23 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">23</strong>&nbsp; What was the problem of the manager?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'He had a lot of tasks to do.', 'B' => 'He employed too many people and let them go then.', 'C' => 'He always made decisions by himself.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[23]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q24 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">24</strong>&nbsp; What does the staff think of the new manager of the company?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'They are delighted to see that the meeting time is shorter.', 'B' => 'They feel annoyed toward him.', 'C' => 'They are amazed that he has done it well.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[24]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q25 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">25</strong>&nbsp; What achievement has the organisation made already?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'Children were involved in painting the entrance area.', 'B' => 'There was no particular achievement.', 'C' => 'It built a local primary school.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[25]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

    </div>

    {{-- Questions 26-30: Summary Completion --}}
    <h4 class="text-lg font-bold mb-2">Questions 26-30</h4>
    <p class="mb-2 text-gray-700">Complete the summary below.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN THREE WORDS</strong> for each answer.</p>

    <div class="border border-gray-300 rounded-lg p-5 max-w-2xl bg-gray-50">
        <p class="font-bold text-gray-800 mb-4 text-center">Major Problems of a Company</p>
        <div class="text-gray-700" style="line-height: 3rem;">
            Since the company opened, there have been many problems with employment, but there is no
            <strong class="text-blue-600">26</strong>
            <input type="text" name="answers[26]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
            He needs to find a venue for financial training. It is very hard to run an organisation and the
            <strong class="text-blue-600">27</strong>
            <input type="text" name="answers[27]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
            is of great importance to staying organised. To enhance the organisation skills, there is a section on
            <strong class="text-blue-600">28</strong>
            <input type="text" name="answers[28]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
            in the library where some valuable books can be found. In addition, the library contains some useful resources, such as a collection of documentaries on personal organisation, the literature on
            <strong class="text-blue-600">29</strong>
            <input type="text" name="answers[29]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
            , and the articles on the
            <strong class="text-blue-600">30</strong>
            <input type="text" name="answers[30]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="............" autocomplete="off" />
        </div>
    </div>
</div>
