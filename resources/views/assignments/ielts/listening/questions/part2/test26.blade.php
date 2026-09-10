<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 2</h3>

    {{-- Questions 11-12 --}}
    <h4 class="text-lg font-bold mb-2">Questions 11-12</h4>
    <p class="mb-6 text-gray-700">Choose the correct letter, <strong>A, B</strong> or <strong>C</strong>.</p>

    <div class="space-y-8 mb-12">
        {{-- Q11 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">11</strong>&nbsp; Who is buried in the tomb of the Taj Mahal?</p>
            <div class="space-y-2 pl-6">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[11]" value="A" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">A</span><span>the emperor Shahjahan</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[11]" value="B" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">B</span><span>the wife of Shahjahan</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[11]" value="C" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">C</span><span>the emperor and his wife</span>
                </label>
            </div>
        </div>

        {{-- Q12 --}}
        <div>
            <p class="text-lg font-medium mb-3"><strong class="text-blue-600">12</strong>&nbsp; Where did the white marble come from?</p>
            <div class="space-y-2 pl-6">
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[12]" value="A" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">A</span><span>India</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[12]" value="B" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">B</span><span>China</span>
                </label>
                <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                    <input type="radio" name="answers[12]" value="C" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                    <span class="font-bold">C</span><span>Persia</span>
                </label>
             </div>
         </div>
    </div>


    {{-- Questions 13-16 --}}
    <h4 class="text-lg font-bold mb-2">Questions 13-16</h4>
    <p class="mb-2 text-gray-700">Label the plan below.</p>
    <p class="mb-6 text-gray-700 italic">Write <strong>NO MORE THAN THREE WORDS</strong> for each answer.</p>

    {{-- Map Image Placeholder --}}
    <div class="mb-8 text-center">
        <div class="inline-block p-4 border-2 border-dashed border-gray-300 bg-white rounded-lg w-full max-w-2xl relative">
            <p class="text-gray-500 mb-2 font-medium">Map / Plan Insert</p>
            <p class="text-sm text-gray-400 mb-4">Please upload the map image to: <code>public/images/assignments/ielts/listening/part2/test26-map.png</code></p>
            <img src="{{ asset('images/assignments/ielts/listening/part2/test26-map.png') }}" onerror="this.style.display='none'" class="max-w-full h-auto mx-auto" alt="Taj Mahal Plan">
        </div>
    </div>

    <div class="space-y-3 mb-12 flex flex-col pl-4 max-w-sm">
        @foreach([13, 14, 15, 16] as $q)
        <div class="flex items-center gap-4">
            <strong class="text-blue-600">{{ $q }}</strong>
            <input type="text" name="answers[{{ $q }}]" class="w-48 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors" placeholder="..........." autocomplete="off" />
        </div>
        @endforeach
    </div>


    {{-- Question 17 --}}
    <h4 class="text-lg font-bold mb-2">Question 17</h4>
    <p class="mb-6 text-gray-700">Choose the correct letter, <strong>A, B</strong> or <strong>C</strong>.</p>

    <div class="mb-12">
        <p class="text-lg font-medium mb-3"><strong class="text-blue-600">17</strong>&nbsp; What is the purpose of the Rest House?</p>
        <div class="space-y-2 pl-6">
            <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                <input type="radio" name="answers[17]" value="A" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                <span class="font-bold">A</span><span>a place for the poor to stay</span>
            </label>
            <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                <input type="radio" name="answers[17]" value="B" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                <span class="font-bold">B</span><span>a meeting place for pilgrims</span>
            </label>
            <label class="flex items-center gap-3 cursor-pointer hover:bg-white p-2 rounded transition-colors w-fit">
                <input type="radio" name="answers[17]" value="C" class="w-4 h-4 text-blue-600 border-gray-400 focus:ring-blue-500 cursor-pointer">
                <span class="font-bold">C</span><span>an architectural feature</span>
            </label>
        </div>
    </div>


    {{-- Questions 18-20 --}}
    <h4 class="text-lg font-bold mb-2">Questions 18-20</h4>
    <p class="mb-2 text-gray-700">Complete the flow chart below.</p>
    <p class="mb-6 text-gray-700 italic">Write <strong>NO MORE THAN TWO WORDS</strong> for each answer.</p>

    <div class="mb-12">
        <h5 class="font-bold text-center text-gray-800 mb-6 text-xl">How running water is provided</h5>

        <div class="flex flex-col items-center space-y-4 max-w-xl mx-auto text-center text-gray-700">
            {{-- Step 1 --}}
             <div class="flex items-center gap-2 flex-wrap justify-center">
                <span>Water taken from the</span>
                <strong class="text-blue-600">18</strong>
                <input type="text" name="answers[18]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors text-center" placeholder="..........." autocomplete="off" />
                <span>by bullocks.</span>
            </div>

            <div class="text-gray-500 text-2xl">&darr;</div>

            {{-- Step 2 --}}
            <div class="flex items-center gap-2 flex-wrap justify-center">
                <span>Water channelled into the</span>
                <strong class="text-blue-600">19</strong>
                <input type="text" name="answers[19]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors text-center" placeholder="..........." autocomplete="off" />
            </div>

            <div class="text-gray-500 text-2xl">&darr;</div>

            {{-- Step 3 --}}
             <div class="flex items-center gap-2 flex-wrap justify-center">
                <span>Water piped to the</span>
                <strong class="text-blue-600">20</strong>
                <input type="text" name="answers[20]" class="w-36 border-b border-gray-400 focus:border-blue-600 outline-none px-2 py-1 bg-transparent transition-colors text-center" placeholder="..........." autocomplete="off" />
            </div>
        </div>
    </div>
</div>
