<?php
$filePath = __DIR__ . '/resources/views/assignments/ielts/mockup/reading-test-2.blade.php';
$content = file_get_contents($filePath);

$q8_old = <<<EOT
                {{-- Questions 8–13: Table Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 8–13</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the table below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 8–13 on your answer sheet.</p>

                    <div class="border border-gray-400 rounded-lg p-5 bg-gray-50 text-sm">
                        <h4 class="text-base font-bold text-center mb-4">Reasons why polar bears should be protected</h4>

                        <p class="mb-3 text-gray-800">People think of bears as unintelligent and <span class="font-bold">8</span>
                            <input type="text" name="q8" class="border-b border-gray-500 outline-none px-1 w-28 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">.</p>

                        <p class="mb-2 text-gray-800">However, this may not be correct. For example:</p>
                        <ul class="list-disc ml-5 space-y-3 mb-4">
                            <li class="text-gray-800">
                                In Tennoji Zoo, a bear has been seen using a branch as a <span class="font-bold">9</span>
                                <input type="text" name="q9" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">.
                                This allowed him to knock down some <span class="font-bold">10</span>
                                <input type="text" name="q10" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">.
                            </li>
                            <li class="text-gray-800">
                                A wild polar bear worked out a method of reaching a platform where a <span class="font-bold">11</span>
                                <input type="text" name="q11" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer"> was located.
                            </li>
                            <li class="text-gray-800">
                                Polar bears have displayed behaviour such as conscious manipulation of objects and activity similar to a <span class="font-bold">12</span>
                                <input type="text" name="q12" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer">.
                            </li>
                        </ul>

                        <p class="mb-2 text-gray-800">Bears may also display emotions. For example:</p>
                        <ul class="list-disc ml-5 space-y-3">
                            <li class="text-gray-800">
                                They may make movements suggesting <span class="font-bold">13</span>
                                <input type="text" name="q13" class="border-b border-gray-500 outline-none px-1 w-24 bg-transparent text-sm placeholder-gray-400" placeholder="Answer"> if disappointed when hunting.
                            </li>
                            <li class="text-gray-800">They may form relationships with other species.</li>
                        </ul>
                    </div>

                    {{-- Submit --}}
                    <div class="mt-6 flex justify-end">
                        <button class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-xl transition shadow-sm">
                            Submit Answers
                        </button>
                    </div>
                </div>
EOT;

$q9_new = <<<EOT
                {{-- Questions 9–13: Notes Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 9–13</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the notes below.</p>
                    <p class="text-sm italic text-gray-700 mb-1">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Write your answers in boxes 9–13 on your answer sheet.</p>

                    <div class="border-2 border-gray-400 rounded-lg p-6 bg-gray-50 text-sm font-sans relative shadow-sm">
                        <h4 class="text-xl font-bold text-center mb-6">The Uffington White Horse</h4>
                        
                        <p class="font-bold text-gray-900 mb-3 text-base">The location of the Uffington White Horse:</p>
                        <ul class="list-disc ml-6 space-y-3 mb-6 text-gray-800 text-[15px]">
                            <li class="pl-2">a distance of 2.5 km from Uffington village</li>
                            <li class="pl-2">
                                near an ancient road known as the <span class="font-bold">9</span>
                                <input type="text" name="q9" class="border-b border-gray-500 outline-none px-2 w-48 bg-transparent text-[15px] placeholder-gray-400 focus:border-blue-500 transition-colors" placeholder="Answer">
                            </li>
                            <li class="pl-2">close to an ancient cemetery that has a number of burial mounds</li>
                        </ul>

                        <p class="font-bold text-gray-900 mb-3 text-base">Dating the Uffington White Horse:</p>
                        <ul class="list-disc ml-6 space-y-3 mb-6 text-gray-800 text-[15px]">
                            <li class="pl-2">
                                first reference to White Horse Hill appears in <span class="font-bold">10</span>
                                <input type="text" name="q10" class="border-b border-gray-500 outline-none px-2 w-48 bg-transparent text-[15px] placeholder-gray-400 focus:border-blue-500 transition-colors" placeholder="Answer"> from the 1070s
                            </li>
                            <li class="pl-2">horses shown on coins from the period 100 BCE – 1 BCE are similar in appearance</li>
                            <li class="pl-2">
                                according to analysis of the surrounding <span class="font-bold">11</span>
                                <input type="text" name="q11" class="border-b border-gray-500 outline-none px-2 w-48 bg-transparent text-[15px] placeholder-gray-400 focus:border-blue-500 transition-colors" placeholder="Answer"> , the Horse is Late Bronze Age / Early Iron Age
                            </li>
                        </ul>

                        <p class="font-bold text-gray-900 mb-3 text-base">Possible reasons for creation of the Uffington White Horse:</p>
                        <ul class="list-disc ml-6 space-y-4 text-gray-800 text-[15px]">
                            <li class="pl-2">an emblem to indicate land ownership</li>
                            <li class="pl-2">formed part of an ancient ritual</li>
                            <li class="pl-2 leading-relaxed">
                                was a representation of goddess Epona – associated with protection of horses and <span class="font-bold">12</span>
                                <input type="text" name="q12" class="border-b border-gray-500 outline-none px-2 w-48 bg-transparent text-[15px] placeholder-gray-400 focus:border-blue-500 transition-colors" placeholder="Answer">
                            </li>
                            <li class="pl-2 leading-relaxed">
                                was a representation of a Welsh goddess called <span class="font-bold">13</span>
                                <input type="text" name="q13" class="border-b border-gray-500 outline-none px-2 w-48 bg-transparent text-[15px] placeholder-gray-400 focus:border-blue-500 transition-colors" placeholder="Answer">
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="flex justify-center mt-8 mb-8">
                    <button class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-8 rounded-xl shadow-lg transform hover:scale-105 transition-all w-full max-w-sm">
                        Submit Reading Answers
                    </button>
                </div>
EOT;

$content = str_replace($q8_old, $q9_new, $content);

file_put_contents($filePath, $content);
echo "Q9-13 Notes completion replaced.";
?>
