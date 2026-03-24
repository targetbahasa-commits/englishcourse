import os

file_path = "/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/assignments/ielts/mockup/c20-reading-test-2.blade.php"

with open(file_path, 'r') as f:
    content = f.read()

passage2_text = """                {{-- Passage 2 --}}
                <div class="mb-6 mt-16 pt-8 border-t border-gray-200">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 2</h2>
                    <p class="text-sm italic text-gray-700 mb-6">You should spend about 20 minutes on <strong>Questions 14–26</strong>, which are based on Reading Passage 2 below.</p>

                    <h3 class="text-3xl font-bold text-center text-gray-900 mb-2 mt-4">Procrastination</h3>
                    <p class="text-center text-gray-700 italic mb-8 text-lg">A psychologist explains why we put off important tasks and how we can break this habit</p>

                    <div class="passage-content text-[16px] leading-[1.8] text-gray-800 space-y-5 font-['Georgia',serif]"
                         @mouseup="if(highlightMode) window.applyAnnotation('highlight', highlightColor);"
                         @click="if(eraserMode) window.removeHighlight($event);">
                        <p><strong class="mr-2 font-sans text-gray-900">A</strong>Procrastination is the habit of delaying a necessary task, usually by focusing on less urgent, more enjoyable, and easier activities instead. We all do it from time to time. We might be composing a message to a friend who we have to let down, or putting together an important report for college or work; we're doing our best to avoid doing the job at hand, but deep down we know that we should just be getting on with it. Unfortunately, berating ourselves won't stop us procrastinating again. In fact, it's one of the worst things we can do. This matters because, as my research shows, procrastination doesn't just waste time, but is actually linked to other problems, too.</p>

                        <p><strong class="mr-2 font-sans text-gray-900">B</strong>Contrary to popular belief, procrastination is not due to laziness or poor time management. Scientific studies suggest procrastination is, in fact, caused by poor mood management. This makes sense if we consider that people are more likely to put off starting or completing tasks that they are really not keen to do. If just thinking about the task threatens our sense of self-worth or makes us anxious, we will be more likely to put it off. Research involving brain imaging has found that areas of the brain linked to detection of threats and emotion regulation are actually different in people who chronically procrastinate compared to those who don't procrastinate frequently.</p>

                        <p><strong class="mr-2 font-sans text-gray-900">C</strong>Tasks that are emotionally loaded or difficult, such as preparing for exams, are prime candidates for procrastination. People with low self-esteem are more likely to procrastinate. Another group of people who tend to procrastinate are perfectionists, who worry their work will be judged harshly by others. We know that if we don't finish that report or complete those home repairs, then what we did can't be evaluated. When we avoid such tasks, we also avoid the negative emotions associated with them. This is rewarding, and it conditions us to use procrastination to repair our mood. If we engage in more enjoyable tasks instead, we get another mood boost. In the long run, however, procrastination isn't an effective way of managing emotions. The 'mood repair' we experience is temporary. Afterwards, people tend to be left with a sense of guilt that not only increases their negative mood, but also reinforces their tendency to procrastinate.</p>

                        <p><strong class="mr-2 font-sans text-gray-900">D</strong>So why is this such a problem? When most people think of the costs of procrastination, they think of the toll on productivity. For example, studies have shown that procrastination negatively impacts on student performance. But putting off reading textbooks and writing essays may affect other areas of students' lives. In one study of over 3,000 German students over a six-month period, those who reported procrastinating over their university work were also more likely to engage in study-related misconduct, such as cheating and plagiarism. But the behaviour that procrastination was most closely linked with was using fraudulent excuses to get deadline extensions. Other research shows that employees on average spend almost a quarter of their workday procrastinating, and again this is linked with negative outcomes. In fact, in one US survey of over 22,000 employees, participants who said they regularly procrastinated had less annual income and less employment stability. For every one-point increase on a measure of chronic procrastination, annual income decreased by US$15,000.</p>

                        <p><strong class="mr-2 font-sans text-gray-900">E</strong>Procrastination also correlates with serious health and well-being problems. A tendency to procrastinate is linked to poor mental health, including higher levels of depression and anxiety. Across numerous studies, I've found people who regularly procrastinate report a greater number of health issues, such as headaches, flu and colds, and digestive issues. They also experience higher levels of stress and poor sleep quality. They are less likely to practise healthy behaviours, such as eating a healthy diet and regularly exercising, and use destructive coping strategies to manage their stress. In one study of over 700 people, I found people prone to procrastination had a 63% greater risk of poor heart health after accounting for other personality traits and demographics.</p>

                        <p><strong class="mr-2 font-sans text-gray-900">F</strong>Finding better ways of managing our emotions is one route out of the vicious cycle of procrastination. An important first step is to manage our environment and how we view the task. There are a number of evidence-based strategies that can help us fend off distractions that can occupy our minds when we should be focusing on the thing we should be getting on with. For example, reminding ourselves about why the task is important and valuable can increase positive feelings towards it. Forgiving ourselves and feeling compassion when we procrastinate can help break the procrastination cycle. We should admit that we feel bad, but not be overly critical of ourselves. We should remind ourselves that we're not the first person to procrastinate, nor the last. Doing this can take the edge off the negative feelings we have about ourselves when we procrastinate. This can all make it easier to get back on track.</p>
                    </div>
                </div>"""

# Replace passage 2 placeholder
empty_p2 = """                {{-- Passage 2 --}}
                <div class="mb-6 mt-16 pt-8 border-t border-gray-200">
                    <h2 class="text-base font-bold text-gray-900 mb-1 uppercase tracking-wide">READING PASSAGE 2</h2>
                    <p class="text-sm italic text-gray-700 mb-6">Coming Soon</p>
                </div>"""

content = content.replace(empty_p2, passage2_text)

questions2_html = """
                {{-- ── PASSAGE 2 Questions ── --}}
                <div class="mt-12 mb-6">
                    <div class="flex justify-center mb-4">
                        <span class="text-base font-bold bg-black text-white px-5 py-1 uppercase tracking-widest">READING PASSAGE 2</span>
                    </div>
                </div>

                {{-- Q14-16: Matching Information --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 14–16</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Reading Passage 2 has six paragraphs, <strong>A–F</strong>.</p>
                    <p class="text-sm text-gray-800 mb-1">Which paragraph contains the following information?</p>
                    <p class="text-sm font-bold text-gray-800 mb-4 mt-2">NB <span class="font-normal italic">You may use any letter more than once.</span></p>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse bg-white rounded-lg shadow-sm border border-gray-200">
                            <thead>
                                <tr class="bg-blue-100 border-b border-gray-200">
                                    <th class="p-3 font-bold text-gray-700 w-10 text-center">#</th>
                                    <th class="p-3 font-bold text-gray-800 text-center">Column 1</th>
                                    <th class="p-3 font-bold text-gray-800 w-28 text-center bg-blue-50 border-l border-white">Paragraph</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                    [14, 'mention of false assumptions about why people procrastinate'],
                                    [15, 'reference to the realisation that others also procrastinate'],
                                    [16, 'neurological evidence of a link between procrastination and emotion'],
                                ] as [$num, $statement])
                                <tr class="border-b border-gray-100 last:border-0 hover:bg-gray-50 transition-colors">
                                    <td class="py-3 px-3 font-bold text-blue-600 text-center bg-white">{{ $num }}.</td>
                                    <td class="py-3 px-3 text-gray-800 text-sm leading-relaxed bg-white">{{ $statement }}</td>
                                    <td class="py-3 px-3 text-center bg-white border-l border-gray-100">
                                        <div class="relative inline-block w-full">
                                            <select name="q{{ $num }}" class="appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 pr-8 rounded font-semibold text-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                                <option value="" disabled selected>-</option>
                                                @foreach(['A','B','C','D','E','F'] as $p)
                                                    <option value="{{ $p }}">{{ $p }}</option>
                                                @endforeach
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

                {{-- Q17-22: Summary Completion --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 mb-6">
                    <p class="text-sm italic text-gray-600 mb-1"><strong>Questions 17–22</strong></p>
                    <p class="text-sm text-gray-800 mb-1">Complete the summary below.</p>
                    <p class="text-sm italic text-gray-700 mb-5">Choose <strong>ONE WORD ONLY</strong> from the passage for each answer.</p>

                    <div class="border border-blue-200 bg-[#f8fafc] rounded-lg p-6 text-sm">
                        <h4 class="text-lg font-bold text-center mb-5 text-gray-900 border-b border-gray-200 pb-3">What makes us procrastinate?</h4>
                        <div class="text-gray-800 leading-[2.5] space-y-4">
                            <p>
                                Many people think that procrastination is the result of 
                                <span class="font-bold text-blue-700 mx-1 border border-gray-300 bg-white px-2 py-1 rounded shadow-sm">17</span>
                                <input type="text" name="q17" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1 uppercase font-semibold text-center text-blue-800">.
                                Others believe it to be the result of an inability to organise time efficiently. 
                                But scientific studies suggest that procrastination is actually due to poor mood management. 
                                The tasks we are most likely to put off are those that could damage our self-esteem or cause us to feel 
                                <span class="font-bold text-blue-700 mx-1 border border-gray-300 bg-white px-2 py-1 rounded shadow-sm">18</span>
                                <input type="text" name="q18" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1 uppercase font-semibold text-center text-blue-800"> 
                                when we think about them. Research comparing chronic procrastinators with other people even found differences in the brain regions associated with regulating emotions and identifying 
                                <span class="font-bold text-blue-700 mx-1 border border-gray-300 bg-white px-2 py-1 rounded shadow-sm">19</span>
                                <input type="text" name="q19" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1 uppercase font-semibold text-center text-blue-800">.
                            </p>
                            <p class="pt-2 border-t border-gray-200">
                                Emotionally loaded and difficult tasks often cause us to procrastinate. Getting ready to take 
                                <span class="font-bold text-blue-700 mx-1 border border-gray-300 bg-white px-2 py-1 rounded shadow-sm">20</span>
                                <input type="text" name="q20" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1 uppercase font-semibold text-center text-blue-800"> 
                                might be a typical example of one such task. People who are likely to procrastinate tend to be either 
                                <span class="font-bold text-blue-700 mx-1 border border-gray-300 bg-white px-2 py-1 rounded shadow-sm">21</span>
                                <input type="text" name="q21" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1 uppercase font-semibold text-center text-blue-800"> 
                                or those with low self-esteem.
                            </p>
                            <p>
                                Procrastination is only a short-term measure for managing emotions. It's often followed by a feeling of 
                                <span class="font-bold text-blue-700 mx-1 border border-gray-300 bg-white px-2 py-1 rounded shadow-sm">22</span>
                                <input type="text" name="q22" class="border border-gray-300 rounded outline-none p-1.5 w-32 bg-white text-sm focus:border-blue-500 focus:ring-1 focus:ring-blue-500 mx-1 uppercase font-semibold text-center text-blue-800">, 
                                which worsens our mood and leads to more procrastination.
                            </p>
                        </div>
                    </div>
                </div>
"""

# Find where to append Q14-22 block (just before "{{-- Final Submit --}}")
final_submit_token = "                {{-- Final Submit --}}"
content = content.replace(final_submit_token, questions2_html + "\n\n" + final_submit_token)

with open(file_path, 'w') as f:
    f.write(content)

print("Injected Passage 2 and Questions 14-22.")
