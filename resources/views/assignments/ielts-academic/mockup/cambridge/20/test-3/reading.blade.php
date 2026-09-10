@extends('assignments.ielts.mockup.reading-test-1')

@section('passages')
    {{-- READING PASSAGE 1 --}}
    <div class="mb-6">
        <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 1</h2>
        <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 1–13</strong>, which are based on Reading Passage 1 below.</p>
        <h3 class="text-2xl font-bold text-center text-gray-900 mb-6">Frozen Food</h3>
        <p class="text-center italic mb-6">A US perspective on the development of the frozen food industry</p>
        <div class="passage-content text-[15px] leading-relaxed text-gray-800 space-y-5 font-['Georgia',serif]">
            <p>At some point in history, humans discovered that ice preserved food. There is evidence that winter ice was stored to preserve food in the summer as far back as 10,000 years ago. Two thousand years ago, the inhabitants of South America’s Andean mountains had a unique means of conserving potatoes for later consumption. They froze them overnight, then trampled them to squeeze out the moisture, then dried them in the sun. This preserved their nutritional value—if not their aesthetic appeal.</p>
            <p>Natural ice remained the main form of refrigeration until late in the 19th century. In the early 1800s, ship owners from Boston, USA, had enormous blocks of Arctic ice towed all over the Atlantic for the purpose of food preservation. In 1851, railroads first began putting blocks of ice in insulated rail cars to send butter from Ogdensburg, New York, to Boston.</p>
            <p>Finally, in 1870, Australian inventors found a way to make ‘mechanical ice’. They used a compressor to force a gas—ammonia at first and later Freon—through a condenser. The compressed gas gave up some of its heat as it moved through the condenser. Then the gas was released quickly into a low-pressure evaporator coil where it became liquid and cold. Air was blown over the evaporator coil and then this cooled air passed into an insulated compartment, lowering its temperature to freezing point.</p>
            <p>Initially, this process was invented to keep Australian beer cool even in hot weather. But Australian cattlemen were quick to realize that, if they could put this new invention on a ship, they could export meat across the oceans. In 1880, a shipment of Australian beef and mutton was sent, frozen, to England. While the food frozen this way was still palatable, there was some deterioration. During the freezing process, crystals formed within the cells of the food, and when the ice expanded and the cells burst, this spoilt the flavor and texture of the food.</p>
            <p>The modern frozen food industry began with the indigenous Inuit people of Canada. In 1912, a biology student in Massachusetts, USA, named Clarence Birdseye, ran out of money and went to Labrador in Canada to trap and trade furs. While he was there, he became fascinated with how the Inuit would quickly freeze fish in the Arctic air. The fish looked and tasted fresh even months later.</p>
            <p>Birdseye returned to the USA in 1917 and began developing mechanical freezers capable of quick-freezing food. Birdseye methodically kept inventing better freezers and gradually built a business selling frozen fish from Gloucester, Massachusetts. In 1929, his business was sold and became General Foods, but he stayed with the company as director of research, and his division continued to innovate.</p>
            <p>Birdseye was responsible for several key innovations that made the frozen food industry possible. He developed quick-freezing techniques that reduced the damage that crystals caused, as well as the technique of freezing the product in the package it was to be sold in. He also introduced the use of cellophane, the first transparent material for food packaging, which allowed consumers to see the quality of the product. Birdseye products also came in convenient size packages that could be prepared with a minimum of effort.</p>
            <p>But there were still obstacles. In the 1930s, few grocery stores could afford to buy freezers for a market that wasn’t established yet. So, Birdseye leased inexpensive freezer cases to them. He also leased insulated railroad cars so that he could ship his products nationwide. However, few consumers had freezers large enough or efficient enough to take advantage of the products.</p>
            <p>Sales increased in the early 1940s, when World War II gave a boost to the frozen food industry because tin was being used for munitions. Canned foods were rationed to save tin for the war effort, while frozen foods were abundant and cheap. Finally, by the 1950s, refrigerator technology had developed far enough to make these appliances affordable for the average family. By 1953, 33 million US families owned a refrigerator, and manufacturers were gradually increasing the size of the freezer compartments in them.</p>
            <p>1950s families were also looking for convenience at mealtimes, so the moment was right for the arrival of the ‘TV Dinner’. Swanson Foods was a large, nationally recognized producer of canned and frozen poultry. In 1954, the company adapted some of Birdseye’s freezing techniques, and with the help of a clever name and a huge advertising budget, it launched the first ‘TV Dinner’. This consisted of frozen turkey, potatoes and vegetables served in the same segmented aluminum tray that was used by airlines. The product was an instant success. Within a year, Swanson had sold 13 million TV dinners. American consumers couldn’t resist the combination of a trusted brand name, a single-serving package and the convenience of a meal that could be ready after only 25 minutes in a hot oven. By 1959, Americans were spending $2.7 billion annually on frozen foods, and half a billion of that was spent on ready-prepared meals such as the TV Dinner.</p>
            <p>Today, the US frozen food industry has a turnover of over $67 billion annually, with $26.6 billion of that sold to consumers for home consumption. The remaining $40 billion in frozen food sales come through restaurants, cafeterias, hospitals and schools, and that represents a third of the total food service sales.</p>
        </div>
    </div>
@endsection

@section('questions')
    {{-- Questions 1–7: Note Completion --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
        <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 1–7</strong></p>
        <p class="text-sm text-gray-800 mb-3">Complete the notes below.</p>
        <p class="text-sm italic text-gray-700 mb-4">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>
        <div class="border border-gray-300 p-4 rounded-lg mb-6 text-sm bg-white">
            <h4 class="text-base font-bold text-center mb-4">The history of frozen food</h4>
            <div class="space-y-4">
                <div><span class="font-semibold">2,000 years ago, South America</span><br>
                    • People conserved the nutritional value of <input type="text" name="q1" class="dotted-answer" placeholder="1">, using a method of freezing then drying.
                </div>
                <div><span class="font-semibold">1851, USA</span><br>
                    • <input type="text" name="q2" class="dotted-answer" placeholder="2"> was kept cool by ice during transportation in specially adapted trains.
                </div>
                <div><span class="font-semibold">1880, Australia</span><br>
                    • Two kinds of <input type="text" name="q3" class="dotted-answer" placeholder="3"> were the first frozen food shipped to England.
                </div>
                <div><span class="font-semibold">1917 onwards, USA</span><br>
                    • Clarence Birdseye introduced innovations including:<br>
                    &nbsp;&nbsp;- quick-freezing methods, so that <input type="text" name="q4" class="dotted-answer" placeholder="4"> did not spoil the food.<br>
                    &nbsp;&nbsp;- packaging products with <input type="text" name="q5" class="dotted-answer" placeholder="5">, so the product was visible.
                </div>
                <div><span class="font-semibold">Early 1940s, USA</span><br>
                    • Frozen food became popular because of a shortage of <input type="text" name="q6" class="dotted-answer" placeholder="6">.
                </div>
                <div><span class="font-semibold">1950s, USA</span><br>
                    • A large number of homes now had a <input type="text" name="q7" class="dotted-answer" placeholder="7">.
                </div>
            </div>
        </div>
    </div>

    {{-- Questions 8–13: TRUE/FALSE/NOT GIVEN --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
        <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 8–13</strong></p>
        <p class="text-sm text-gray-800 mb-3">Do the following statements agree with the information given in Reading Passage 1?</p>
        <p class="text-sm italic text-gray-700 mb-4">In boxes 8–13 on your answer sheet, write</p>
        <div class="border border-gray-300 p-4 rounded-lg mb-6 text-sm bg-white">
            <div class="grid gap-x-4 gap-y-1" style="grid-template-columns: auto 1fr">
                <div><span class="font-bold italic">TRUE</span></div><div class="italic">if the statement agrees with the information</div>
                <div><span class="font-bold italic">FALSE</span></div><div class="italic">if the statement contradicts the information</div>
                <div><span class="font-bold italic">NOT GIVEN</span></div><div class="italic">if there is no information on this</div>
            </div>
        </div>
        <div class="overflow-x-auto mt-2">
            <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                <thead>
                    <tr class="bg-white border-b border-gray-200">
                        <th class="p-3 font-bold text-gray-500 w-10 text-center">#</th>
                        <th class="p-3 font-bold text-gray-600">Statement</th>
                        <th class="p-3 font-bold text-gray-600 w-36 text-center">Answer</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-100 last:border-0 hover:bg-white transition-colors">
                        <td class="py-3 px-3 font-bold text-blue-600 text-center">8</td>
                        <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">The ice transportation business made some Boston ship owners very wealthy in the early 1800s.</td>
                        <td class="py-3 px-3 text-center">
                            <div class="relative inline-block w-full">
                                <select name="q8" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
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
                    <tr class="border-b border-gray-100 last:border-0 hover:bg-white transition-colors">
                        <td class="py-3 px-3 font-bold text-blue-600 text-center">9</td>
                        <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">A disadvantage of the freezing process invented in Australia was that it affected the taste of food.</td>
                        <td class="py-3 px-3 text-center">
                            <div class="relative inline-block w-full">
                                <select name="q9" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
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
                    <tr class="border-b border-gray-100 last:border-0 hover:bg-white transition-colors">
                        <td class="py-3 px-3 font-bold text-blue-600 text-center">10</td>
                        <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">Clarence Birdseye travelled to Labrador in order to learn how the Inuit people froze fish.</td>
                        <td class="py-3 px-3 text-center">
                            <div class="relative inline-block w-full">
                                <select name="q10" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
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
                    <tr class="border-b border-gray-100 last:border-0 hover:bg-white transition-colors">
                        <td class="py-3 px-3 font-bold text-blue-600 text-center">11</td>
                        <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">Swanson Foods invested a great deal of money in the promotion of the TV Dinner.</td>
                        <td class="py-3 px-3 text-center">
                            <div class="relative inline-block w-full">
                                <select name="q11" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
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
                    <tr class="border-b border-gray-100 last:border-0 hover:bg-white transition-colors">
                        <td class="py-3 px-3 font-bold text-blue-600 text-center">12</td>
                        <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">Swanson Foods developed a new style of container for the launch of the TV Dinner.</td>
                        <td class="py-3 px-3 text-center">
                            <div class="relative inline-block w-full">
                                <select name="q12" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
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
                    <tr class="border-b border-gray-100 last:border-0 hover:bg-white transition-colors">
                        <td class="py-3 px-3 font-bold text-blue-600 text-center">13</td>
                        <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed">The US frozen food industry is currently the largest in the world.</td>
                        <td class="py-3 px-3 text-center">
                            <div class="relative inline-block w-full">
                                <select name="q13" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
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
                </tbody>
            </table>
        </div>
    </div>
@endsection
