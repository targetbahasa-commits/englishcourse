<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 3</h3>

    {{-- Questions 21-24: Multiple Choice --}}
    <h4 class="text-lg font-bold mb-2">Questions 21-24</h4>
    <p class="mb-6 text-gray-700">Choose the correct letter, <strong>A</strong>, <strong>B</strong> or <strong>C</strong>.</p>

    <div class="space-y-8 mb-12">

        {{-- Q21 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">21</strong>&nbsp; What background information does Daisy give about rice?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'Wild rice is grown throughout Asia', 'B' => 'Some types of rice need less water than others.', 'C' => 'All rice varieties have a lovely aroma'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[21]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q22 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">22</strong>&nbsp; Erik says that a priority for rice farmers is to be able to</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'grow rice without fertilizers.', 'B' => 'predict the weather patterns.', 'C' => 'manage water resources.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[22]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q23 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">23</strong>&nbsp; Where is the International Rice Research Institute?</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'The Philippines', 'B' => 'China', 'C' => 'Japan'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[23]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

        {{-- Q24 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">24</strong>&nbsp; Scientists in Bangladesh want to find a</p>
            <div class="space-y-2 pl-6">
                @foreach(['A' => 'more effective type of fertilizer.', 'B' => 'strain of rice resistant to flooding.', 'C' => 'way to reduce the effects of global warming.'] as $letter => $option)
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[24]" value="{{ $letter }}" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">{{ $letter }}</span><span>{{ $option }}</span>
                </label>
                @endforeach
            </div>
        </div>

    </div>

    {{-- Questions 25-30: Matching Countries --}}
    <h4 class="text-lg font-bold mb-2">Questions 25-30</h4>
    <p class="mb-2 text-gray-700">Which country do the following statements apply to?</p>
    <p class="mb-4 text-gray-700 italic">Choose the correct letter, <strong>A</strong>, <strong>B</strong> or <strong>C</strong>.</p>

    <div class="mb-6 grid grid-cols-1 gap-y-1 pl-4 text-gray-700 max-w-xs">
        <p><strong>A</strong>&nbsp;&nbsp; Japan</p>
        <p><strong>B</strong>&nbsp;&nbsp; China</p>
        <p><strong>C</strong>&nbsp;&nbsp; Thailand</p>
    </div>

    @php
        $items = [
            25 => 'They grow the most rice in the world.',
            26 => 'They export the most rice in the world.',
            27 => 'They aim to increase the nutritional value of rice.',
            28 => 'Less rice is eaten than in the past.',
            29 => 'An annual rice festival takes place.',
            30 => 'A new type of rice is now popular locally.',
        ];
    @endphp

    <div style="display: grid; grid-template-columns: 320px auto; gap: 0.75rem 1rem; align-items: center; max-width: 500px;">
        @foreach($items as $q => $label)
            <span class="font-medium text-gray-700"><strong class="text-blue-600">{{ $q }}</strong>&nbsp; {{ $label }}</span>
            <select name="answers[{{ $q }}]" class="border border-gray-400 focus:border-blue-600 outline-none px-3 py-2 bg-white cursor-pointer rounded text-gray-700 w-36">
                <option value="" disabled selected>Select...</option>
                @foreach(['A','B','C'] as $letter)
                    <option value="{{ $letter }}">{{ $letter }}</option>
                @endforeach
            </select>
        @endforeach
    </div>
</div>
