import os
import re

file_path = "/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/assignments/ielts/mockup/c20-reading-test-2.blade.php"

with open(file_path, 'r') as f:
    content = f.read()

q_start_str = '<div class="px-8 py-8 pb-24 max-w-2xl mx-auto border-l border-gray-200 min-h-full">'
q_end_str = "<!-- END OF FULL SCREEN -->"

idx_q_start = content.find(q_start_str)
idx_q_end = content.find(q_end_str, idx_q_start)

questions_html = """<div class="px-8 py-8 pb-24 max-w-2xl mx-auto border-l border-gray-200 min-h-full">

                {{-- Questions 1–6: Note Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 1–6</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the notes below.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Choose <strong>ONE WORD AND/OR A NUMBER</strong> from the passage for each answer.</p>

                    <div class="border border-blue-200 bg-[#eef4fc] rounded-lg p-6 text-sm">
                        <h4 class="text-lg font-bold text-center mb-6 text-gray-900 border-b border-gray-300 pb-3">Manatees</h4>

                        <p class="font-bold text-gray-900 mb-3 text-base">Appearance</p>
                        <ul class="list-disc ml-5 space-y-4 mb-6">
                            <li class="text-gray-800 leading-loose">
                                look similar to dugongs, but with a differently shaped <span class="font-bold text-blue-700">1</span>
                                <input type="text" name="q1" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1">
                            </li>
                        </ul>

                        <p class="font-bold text-gray-900 mb-3 text-base">Movement</p>
                        <ul class="list-disc ml-5 space-y-4 mb-6">
                            <li class="text-gray-800 leading-relaxed">have fewer neck bones than most mammals</li>
                            <li class="text-gray-800 leading-loose">
                                need to use their <span class="font-bold text-blue-700">2</span>
                                <input type="text" name="q2" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1"> to help to turn their bodies around in order to look sideways
                            </li>
                            <li class="text-gray-800 leading-loose">
                                sense vibrations in the water by means of <span class="font-bold text-blue-700">3</span>
                                <input type="text" name="q3" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1"> on their skin
                            </li>
                        </ul>

                        <p class="font-bold text-gray-900 mb-3 text-base">Feeding</p>
                        <ul class="list-disc ml-5 space-y-4 mb-6">
                            <li class="text-gray-800 leading-loose">
                                eat mainly aquatic vegetation, such as <span class="font-bold text-blue-700">4</span>
                                <input type="text" name="q4" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1">
                            </li>
                            <li class="text-gray-800 leading-loose">
                                grasp and pull up plants with their <span class="font-bold text-blue-700">5</span>
                                <input type="text" name="q5" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1">
                            </li>
                        </ul>

                        <p class="font-bold text-gray-900 mb-3 text-base">Breathing</p>
                        <ul class="list-disc ml-5 space-y-4">
                            <li class="text-gray-800 leading-relaxed">come to the surface for air every 2-4 minutes when awake and every 15-20 while sleeping</li>
                            <li class="text-gray-800 leading-loose">
                                may regulate the <span class="font-bold text-blue-700">6</span>
                                <input type="text" name="q6" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1"> of their bodies by using muscles of diaphragm to store air internally
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- Questions 7–13: True/False/Not Given --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 7–13</strong></p>
                    <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the information given in Reading Passage 1?</p>
                    <p class="text-sm italic text-gray-700 mb-4">In boxes 7–13 on your answer sheet, write</p>

                    <div class="border border-gray-300 p-4 rounded-lg mb-6 text-sm bg-gray-50">
                        <div class="grid gap-x-4 gap-y-1" style="grid-template-columns: auto 1fr">
                            <div><span class="font-bold italic">TRUE</span></div><div class="italic">if the statement agrees with the information</div>
                            <div><span class="font-bold italic">FALSE</span></div><div class="italic">if the statement contradicts the information</div>
                            <div><span class="font-bold italic">NOT GIVEN</span></div><div class="italic">if there is no information on this</div>
                        </div>
                    </div>

                    <div class="overflow-x-auto mt-2">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-600">Statement</th>
                                    <th class="p-3 font-bold text-gray-600 w-36 text-center">Answer</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [7, "West Indian manatees can be found in a variety of different aquatic habitats."],
                                    [8, "The Florida manatee lives in warmer waters than the Antillean manatee."],
                                    [9, "The African manatee's range is limited to coastal waters between the West African countries of Mauritania and Angola."],
                                    [10, "The extent of the loss of Amazonian manatees in the mid-twentieth century was only revealed many years later."],
                                    [11, "It is predicted that West Indian manatee populations will fall in the coming decades."],
                                    [12, "The risk to manatees from entanglement and plastic consumption increased significantly in the period 2009–2020."],
                                    [13, "There is some legislation in place which aims to reduce the likelihood of boat strikes on manatees in Florida."],
                                ] as [$num, $statement])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center">{{ $num }}</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">{{ $statement }}</td>
                                    <td class="py-3 px-3 text-center">
                                        <div class="relative inline-block w-full">
                                            <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                                <option value="" disabled selected>-</option>
                                                <option value="TRUE">TRUE</option>
                                                <option value="FALSE">FALSE</option>
                                                <option value="NOT GIVEN">NOT GIVEN</option>
                                            </select>
                                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-600">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
"""

# Try searching manually for the closing div
if idx_q_start != -1:
    # Need to replace until the end of the question block
    end_of_block = content.find("        </div>\n    </div>", idx_q_start)
    if end_of_block != -1:
        content = content[:idx_q_start] + questions_html + content[end_of_block:]
        with open(file_path, 'w') as f:
            f.write(content)
        print("Questions correctly updated.")
    else:
        print("End block not found.")
else:
    print("Start block not found.")
