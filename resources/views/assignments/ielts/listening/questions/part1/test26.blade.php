<div class="mb-8">
    <h3 class="text-xl font-bold mb-4">SECTION 1</h3>

    {{-- Questions 1-6 --}}
    <h4 class="text-lg font-bold mb-2">Questions 1-6</h4>
    <p class="mb-1 text-gray-700">Complete the form below.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN THREE WORDS AND/OR A NUMBER</strong> for each answer.</p>

    <h4 class="text-xl font-bold mb-6 text-center uppercase tracking-wide">Patient Record</h4>

    <div class="space-y-5 text-lg text-gray-800 mb-10">
        {{-- Given (Time of appointment) --}}
        <p class="text-gray-700">Time of appointment: <span class="font-medium">10:00 am</span></p>

        {{-- Q1: Given names --}}
        <p class="flex items-center flex-wrap gap-1">
            Given names: Simon
            <strong class="mx-1">1</strong>
            <span class="inline-block w-44">
                <input type="text" name="answers[1]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </p>

        {{-- Given (Family name) --}}
        <p class="text-gray-700">Family name: <span class="font-medium">Lee</span></p>

        {{-- Q2: Date of birth --}}
        <p class="flex items-center flex-wrap gap-1">
            Date of birth:
            <strong class="mx-1">2</strong>
            <span class="inline-block w-36">
                <input type="text" name="answers[2]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
            <span class="text-gray-700">1989</span>
        </p>

        {{-- Q3: Address --}}
        <p class="flex items-center flex-wrap gap-1">
            Address:
            <strong class="mx-1">3</strong>
            <span class="inline-block w-36">
                <input type="text" name="answers[3]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
            <span class="text-gray-700">Adams Terrace, Wellington</span>
        </p>

        {{-- Given (Phone number) --}}
        <p class="text-gray-700">Phone number: <span class="font-medium">0211558809</span></p>

        {{-- Q4: Insurance company --}}
        <p class="flex items-center flex-wrap gap-1">
            Name of insurance company:
            <strong class="mx-1">4</strong>
            <span class="inline-block w-44">
                <input type="text" name="answers[4]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </p>

        {{-- Q5: Date of last eye test --}}
        <p class="flex items-center flex-wrap gap-1">
            Date of last eye test:
            <strong class="mx-1">5</strong>
            <span class="inline-block w-44">
                <input type="text" name="answers[5]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </p>

        {{-- Q6: Patient's observations --}}
        <p class="flex items-center flex-wrap gap-1">
            Patient's observations: Problems seeing
            <strong class="mx-1">6</strong>
            <span class="inline-block w-44">
                <input type="text" name="answers[6]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </p>
    </div>

    {{-- Questions 7-10 --}}
    <h4 class="text-lg font-bold mb-2">Questions 7-10</h4>
    <p class="mb-1 text-gray-700">Answer the questions below.</p>
    <p class="mb-6 text-gray-700">Write <strong>NO MORE THAN THREE WORDS</strong> for each answer.</p>

    <div class="space-y-6 text-lg text-gray-800">
        <div>
            <p class="mb-2"><strong>7</strong>&nbsp; When must Simon wear his glasses?</p>
            <span class="inline-block w-52 ml-6">
                <input type="text" name="answers[7]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </div>
        <div>
            <p class="mb-2"><strong>8</strong>&nbsp; What type of glasses are the least expensive?</p>
            <span class="inline-block w-52 ml-6">
                <input type="text" name="answers[8]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </div>
        <div>
            <p class="mb-2"><strong>9</strong>&nbsp; What is good about the glasses Simon chooses?</p>
            <span class="inline-block w-52 ml-6">
                <input type="text" name="answers[9]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </div>
        <div>
            <p class="mb-2"><strong>10</strong>&nbsp; How does Simon decide to pay?</p>
            <span class="inline-block w-52 ml-6">
                <input type="text" name="answers[10]" class="w-full border border-gray-400 focus:border-blue-600 outline-none px-2 py-1 text-center font-medium bg-white transition-colors" placeholder="Answer" autocomplete="off" />
            </span>
        </div>
    </div>
</div>
