import os
import re

file_path = "/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/assignments/ielts/mockup/c20-reading-test-2.blade.php"
source_path = "/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/assignments/ielts/mockup/c20-reading-test-1.blade.php"

# create a copy
with open(source_path, 'r') as f:
    content = f.read()

# Replace the title/header numbering
content = content.replace("IELTS Reading – Mock Test {{ $testId ?? 1 }}", "IELTS Reading – Mock Test {{ $testId ?? 2 }}")
content = content.replace("['edition' => $edition ?? 20, 'id' => $testId ?? 1]", "['edition' => $edition ?? 20, 'id' => $testId ?? 2]")
content = content.replace("IELTS Reading – Mock Test {{ $testId ?? 2 }}", "IELTS Reading – Mock Test {{ $testId ?? 2 }}") # Just in case the source was 2 instead of 1

# Manatees Passage Text
passage1_html = """
                    <div class="passage-content text-[16px] leading-[1.8] text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">
                         
                        <p>Manatees, also known as sea cows, are aquatic mammals that belong to a group of animals called Sirenia. This group also contains dugongs. Dugongs and manatees look quite alike – they are similar in size, colour and shape, and both have flexible flippers for forelimbs. However, the manatee has a broad, rounded tail, whereas the dugong's is fluked, like that of a whale. There are three species of manatees: the West Indian manatee (Trichechus manatus), the African manatee (Trichechus senegalensis) and the Amazonian manatee (Trichechus inunguis).</p>
                        
                        <p>Unlike most mammals, manatees have only six bones in their neck – most others, including humans and giraffes, have seven. This short neck allows a manatee to move its head up and down, but not side to side. To see something on its left or its right, a manatee must turn its entire body, steering with its flippers. Manatees have pectoral flippers but no back limbs, only a tail for propulsion. They do have pelvic bones, however – a leftover from their evolution from a four-legged to a fully aquatic animal. Manatees share some visual similarities to elephants. Like elephants, manatees have thick, wrinkled skin. They also have some hairs covering their bodies which help them sense vibrations in the water around them.</p>

                        <p>Seagrasses and other marine plants make up most of a manatee’s diet. Manatees spend about eight hours each day grazing and uprooting plants. They eat up to 15% of their weight in food each day. African manatees are omnivorous – studies have shown that molluscs and fish make up a small part of their diets. West Indian and Amazonian manatees are both herbivores.</p>

                        <p>Manatees’ teeth are all molars – flat, rounded teeth for grinding food. Due to manatees’ abrasive aquatic plant diet, these teeth get worn down and they eventually fall out, so they continually grow new teeth that get pushed forward to replace the ones they lose. Instead of having incisors to grasp their food, manatees have lips which function like a pair of hands to help tear food away from the seafloor.</p>
                        
                        <p>Manatees are fully aquatic, but as mammals, they need to come up to the surface to breathe. When awake, they typically surface every two to four minutes, but they can hold their breath for much longer. Adult manatees sleep underwater for 10–12 hours a day, but they come up for air every 15–20 minutes. Active manatees need to breathe more frequently. It’s thought that manatees use their muscular diaphragm and breathing to adjust their buoyancy. They may use diaphragm contractions to compress and store gas in folds in their large intestine to help them float.</p>
                        
                        <p>The West Indian manatee reaches about 3.5 metres long and weighs on average around 500 kilogrammes. It moves between fresh water and salt water, taking advantage of coastal mangroves and coral reefs, rivers, lakes and inland lagoons. There are two subspecies of West Indian manatee: the Antillean manatee is found in waters from the Bahamas to Brazil, whereas the Florida manatee is found in US waters, although some individuals have been recorded in the Bahamas. In winter, the Florida manatee is typically restricted to Florida. When the ambient water temperature drops below 20°C, it takes refuge in naturally and artificially warmed water, such as at the warm-water outfalls from powerplants.</p>
                        
                        <p>The African manatee is also about 3.5 metres long and found in the sea along the west coast of Africa, from Mauritania down to Angola. The species also makes use of rivers, with the mammals seen in landlocked countries such as Mali and Niger.</p>
                        
                        <p>The Amazonian manatee is the smallest species, though it is still a big animal. It grows to about 2.5 metres long and 350 kilogrammes. Amazonian manatees favour calm, shallow waters that are above 23°C. This species is found in fresh water in the Amazon Basin in Brazil, as well as in Colombia, Ecuador and Peru.</p>
                        
                        <p>All three manatee species are endangered or at a heightened risk of extinction. The African manatee and Amazonian manatee are both listed as Vulnerable by the International Union for Conservation of Nature (IUCN). It is estimated that 140,000 Amazonian manatees were killed between 1935 and 1954 for their meat, fat and skin, with the latter used to make leather. In more recent years, African manatee decline has been tied to incidental capture in fishing nets and hunting. Manatee hunting is now illegal in every country the African species is found in.</p>
                        
                        <p>The two subspecies of West Indian manatee are listed as Endangered by the IUCN. Both are also expected to undergo a decline of 20% over the next 40 years. A review of almost 1,800 cases of entanglement in fishing nets and of plastic consumption among marine mammals in US waters from 2009 to 2020 found that at least 700 cases involved manatees. The chief cause of death in Florida manatees is boat strikes. However, laws in certain parts of Florida now limit boat speeds during winter, allowing slow-moving manatees more time to respond.</p>

                    </div>
"""

questions_html = """
            <div class="px-8 py-8 pb-24 max-w-2xl mx-auto border-l border-gray-200 min-h-full">

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

# Extract the left and right panels from the original HTML
pattern_left = r'(<h3 class="text-3xl font-bold text-center text-gray-900 mb-8 mt-4">The kākāpō</h3>\s*<div class="passage-content.*?>)(.*?)(</div>\s*</div>\s*\{\{-- Passage 2 --\}\})'
m_left = re.search(pattern_left, content, re.DOTALL)

if m_left:
    content = content[:m_left.start(2)] + "\n" + passage1_html.split('<div class="passage-content')[1].split('>', 1)[1].rsplit('</div>', 1)[0] + "\n" + content[m_left.end(2):]
    # Replace passage title
    content = content.replace("The kākāpō", "Manatees", 1)

# Make Passage 2 and 3 tabs "Coming Soon" or empty
content = re.sub(r'\{\{-- Passage 2 --\}\}.*?\{\{-- Passage 3 --\}\}', '{{-- Passage 2 --}}\n                <div class="mb-6 mt-16 pt-8 border-t border-gray-200">\n                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 2</h2>\n                    <p class="text-sm italic text-gray-700 mb-6">Coming Soon</p>\n                </div>\n\n                {{-- Passage 3 --}}', content, flags=re.DOTALL)

content = re.sub(r'\{\{-- Passage 3 --\}\}.*?\{\{-- Floating Annotation Toolbar --\}\}', '{{-- Passage 3 --}}\n                <div class="mb-6 mt-16 pt-8 border-t border-gray-200">\n                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 3</h2>\n                    <p class="text-sm italic text-gray-700 mb-6">Coming Soon</p>\n                </div>\n\n                {{-- Floating Annotation Toolbar --}}', content, flags=re.DOTALL)


# Now replace the questions on the right
pattern_right = r'(<div class="px-8 py-8 pb-24 max-w-2xl mx-auto border-l border-gray-200 min-h-full">)(.*?)(</div>\s*</div>\s*<!-- END OF FULL SCREEN -->)'
m_right = re.search(pattern_right, content, re.DOTALL)

if m_right:
    inner_questions = questions_html.split('<div class="px-8 py-8 pb-24 max-w-2xl mx-auto border-l border-gray-200 min-h-full">')[1].rsplit('</div>', 1)[0]
    content = content[:m_right.start(2)] + inner_questions + content[m_right.end(2):]

with open(file_path, 'w') as f:
    f.write(content)

print("Generated C20 Test 2 Reading view successfully.")
