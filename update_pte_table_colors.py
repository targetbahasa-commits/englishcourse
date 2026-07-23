import sys
import re

html_table = """
            <!-- Table Section -->
            <div class="mt-12 bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100 mb-10">
                <div class="p-6 text-center border-b border-gray-100" style="background: linear-gradient(to right, #f8fafc, #f1f5f9);">
                    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-800 tracking-tight uppercase">SKOR BREAKDOWN 2026</h2>
                </div>
                <div class="overflow-x-auto p-0">
                    <table class="w-full text-sm text-center border-collapse">
                        <thead>
                            <tr>
                                <th colspan="10" class="py-4 px-4 font-bold text-base md:text-lg" style="background: linear-gradient(to right, #0d9488, #14b8a6); color: white; border-bottom: 2px solid #0f766e;">
                                    PTE Content Question Types & Score Information Table V5 (Official Release)
                                </th>
                            </tr>
                            <tr style="background-color: #0f766e; color: white;" class="font-medium text-xs md:text-sm">
                                <th class="py-3 px-2 border" style="border-color: #115e59;">Sequence</th>
                                <th colspan="2" class="py-3 px-2 border" style="border-color: #115e59;">Question Type</th>
                                <th class="py-3 px-2 border" style="border-color: #115e59;">Numbers</th>
                                <th class="py-3 px-2 border" style="border-color: #115e59;">Time for answering a question</th>
                                <th class="py-3 px-2 border" style="border-color: #115e59;">Overall</th>
                                <th class="py-3 px-2 border" style="border-color: #115e59;">Speaking</th>
                                <th class="py-3 px-2 border" style="border-color: #115e59;">Writing</th>
                                <th class="py-3 px-2 border" style="border-color: #115e59;">Reading</th>
                                <th class="py-3 px-2 border" style="border-color: #115e59;">Listening</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 bg-white align-middle [&>tr>td]:border [&>tr>td]:border-gray-200 [&>tr>td]:py-2 [&>tr>td]:px-2">
                            <!-- ROW 1 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td>1</td>
                                <td class="font-semibold">RA</td>
                                <td rowspan="9" class="font-bold shadow-inner" style="background-color: #fff7ed; color: #c2410c; border: 2px solid #fdba74;">Speaking &amp; Writing<br>(76~84mins)</td>
                                <td>6~7</td>
                                <td class="text-xs text-gray-600">Preparation time: 35s or 40s<br>Answer time: 40s</td>
                                <td class="font-medium">4%</td>
                                <td class="font-medium text-orange-600" style="color: #ea580c;">9%</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <!-- ROW 2 -->
                            <tr class="hover:bg-gray-50 transition-colors" style="background-color: #f8fafc;">
                                <td>2</td>
                                <td class="font-semibold">RS</td>
                                <td>10~12</td>
                                <td class="text-xs text-gray-600">No preparation time<br>Answer time: 15s</td>
                                <td class="font-medium">7%</td>
                                <td class="font-medium text-orange-600" style="color: #ea580c;">16%</td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-purple-600" style="color: #9333ea;">17%</td>
                            </tr>
                            <!-- ROW 3 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td>3</td>
                                <td class="font-semibold">DI</td>
                                <td>5~6</td>
                                <td class="text-xs text-gray-600">Preparation time: 25s<br>Answer time: 40s</td>
                                <td class="font-medium">15%</td>
                                <td class="font-medium text-orange-600" style="color: #ea580c;">31%</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <!-- ROW 4 -->
                            <tr class="hover:bg-gray-50 transition-colors" style="background-color: #f8fafc;">
                                <td>4</td>
                                <td class="font-semibold">RL</td>
                                <td>2~3</td>
                                <td class="text-xs text-gray-600">Preparation time: 10s<br>Answer time: 40s</td>
                                <td class="font-medium">6%</td>
                                <td class="font-medium text-orange-600" style="color: #ea580c;">13%</td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-purple-600" style="color: #9333ea;">13%</td>
                            </tr>
                            <!-- ROW 5 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td>5</td>
                                <td class="font-semibold">ASQ</td>
                                <td>5~6</td>
                                <td class="text-xs text-gray-600">No preparation time<br>Answer time: 10s</td>
                                <td class="font-medium">2%</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-purple-600" style="color: #9333ea;">4%</td>
                            </tr>
                            <!-- ROW 6 -->
                            <tr class="hover:bg-gray-50 transition-colors" style="background-color: #f8fafc;">
                                <td>6</td>
                                <td class="font-semibold">SGD</td>
                                <td>2~3</td>
                                <td class="text-xs text-gray-600">Preparation time: 10s<br>Answer time: 2min</td>
                                <td class="font-medium">9%</td>
                                <td class="font-medium text-orange-600" style="color: #ea580c;">19%</td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-purple-600" style="color: #9333ea;">20%</td>
                            </tr>
                            <!-- ROW 7 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td>7</td>
                                <td class="font-semibold">RTS</td>
                                <td>2~3</td>
                                <td class="text-xs text-gray-600">Preparation time: 10s<br>Answer time: 40s</td>
                                <td class="font-medium">6%</td>
                                <td class="font-medium text-orange-600" style="color: #ea580c;">13%</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <!-- ROW 8 -->
                            <tr class="hover:bg-gray-50 transition-colors" style="background-color: #f8fafc;">
                                <td>8</td>
                                <td class="font-semibold">SWT</td>
                                <td>2</td>
                                <td class="text-xs text-gray-600">10 mins per question (timed individually)</td>
                                <td class="font-medium">7%</td>
                                <td></td>
                                <td class="font-medium text-orange-600" style="color: #ea580c;">28%</td>
                                <td class="font-medium text-blue-600" style="color: #2563eb;">23%</td>
                                <td></td>
                            </tr>
                            <!-- ROW 9 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td>9</td>
                                <td class="font-semibold">WE</td>
                                <td>1</td>
                                <td class="text-xs text-gray-600">20 mins per question (timed individually)</td>
                                <td class="font-medium">7%</td>
                                <td></td>
                                <td class="font-medium text-orange-600" style="color: #ea580c;">31%</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <!-- ROW 10 -->
                            <tr class="hover:bg-gray-50 transition-colors" style="background-color: #f8fafc;">
                                <td>10</td>
                                <td class="font-semibold">FIB_Dropdown</td>
                                <td rowspan="5" class="font-bold shadow-inner" style="background-color: #eff6ff; color: #1d4ed8; border: 2px solid #93c5fd;">Reading<br>(23~30mins)</td>
                                <td>5~6</td>
                                <td class="text-xs text-gray-600">Recommended response time: &le; 2 mins</td>
                                <td class="font-medium">7%</td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-blue-600" style="color: #2563eb;">25%</td>
                                <td></td>
                            </tr>
                            <!-- ROW 11 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td>11</td>
                                <td class="font-semibold">MCM_R</td>
                                <td>2~3</td>
                                <td class="text-xs text-gray-600">Recommended response time: &le; 1-1.5 mins</td>
                                <td class="font-medium">1%</td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-blue-600" style="color: #2563eb;">5%</td>
                                <td></td>
                            </tr>
                            <!-- ROW 12 -->
                            <tr class="hover:bg-gray-50 transition-colors" style="background-color: #f8fafc;">
                                <td>12</td>
                                <td class="font-semibold">RO</td>
                                <td>2~3</td>
                                <td class="text-xs text-gray-600">Recommended response time: &le; 1.5-2 mins</td>
                                <td class="font-medium">3%</td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-blue-600" style="color: #2563eb;">9%</td>
                                <td></td>
                            </tr>
                            <!-- ROW 13 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td>13</td>
                                <td class="font-semibold">FIB_Drag and Drop</td>
                                <td>4~5</td>
                                <td class="text-xs text-gray-600">Recommended response time: &le; 2 mins</td>
                                <td class="font-medium">6%</td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-blue-600" style="color: #2563eb;">20%</td>
                                <td></td>
                            </tr>
                            <!-- ROW 14 -->
                            <tr class="hover:bg-gray-50 transition-colors" style="background-color: #f8fafc;">
                                <td>14</td>
                                <td class="font-semibold">MCS_R</td>
                                <td>2~3</td>
                                <td class="text-xs text-gray-600">Recommended response time: &le; 1-1.5 mins</td>
                                <td class="font-medium">&lt;1%</td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-blue-600" style="color: #2563eb;">3%</td>
                                <td></td>
                            </tr>
                            <!-- ROW 15 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td>15</td>
                                <td class="font-semibold">SST</td>
                                <td rowspan="8" class="font-bold shadow-inner" style="background-color: #faf5ff; color: #7e22ce; border: 2px solid #d8b4fe;">Listening<br>(31~39 mins)<br><br><span class="text-xs font-normal" style="color: #6b21a8;">&bull; SST is timed individually per question</span></td>
                                <td>1</td>
                                <td class="text-xs text-gray-600">Each question: 10 minutes (timed individually)</td>
                                <td class="font-medium">4%</td>
                                <td></td>
                                <td class="font-medium text-orange-600" style="color: #ea580c;">18%</td>
                                <td></td>
                                <td class="font-medium text-purple-600" style="color: #9333ea;">10%</td>
                            </tr>
                            <!-- ROW 16 -->
                            <tr class="hover:bg-gray-50 transition-colors" style="background-color: #f8fafc;">
                                <td>16</td>
                                <td class="font-semibold">MCM_L</td>
                                <td>2~3</td>
                                <td class="text-xs text-gray-600">Recommended response time: &le; 1-1.5 mins</td>
                                <td class="font-medium">1%</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-purple-600" style="color: #9333ea;">3%</td>
                            </tr>
                            <!-- ROW 17 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td>17</td>
                                <td class="font-semibold">FIB_L</td>
                                <td>2~3</td>
                                <td class="text-xs text-gray-600">Recommended response time: &le; 2 mins</td>
                                <td class="font-medium">3%</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-purple-600" style="color: #9333ea;">8%</td>
                            </tr>
                            <!-- ROW 18 -->
                            <tr class="hover:bg-gray-50 transition-colors" style="background-color: #f8fafc;">
                                <td>18</td>
                                <td class="font-semibold">HCS</td>
                                <td>2~3</td>
                                <td class="text-xs text-gray-600">Recommended response time: &le; 1-1.5 mins</td>
                                <td class="font-medium">&lt;1%</td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-blue-600" style="color: #2563eb;">3%</td>
                                <td class="font-medium text-purple-600" style="color: #9333ea;">2%</td>
                            </tr>
                            <!-- ROW 19 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td>19</td>
                                <td class="font-semibold">MCS_L</td>
                                <td>2~3</td>
                                <td class="text-xs text-gray-600">Recommended response time: &le; 1-1.5 mins</td>
                                <td class="font-medium">&lt;1%</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-purple-600" style="color: #9333ea;">2%</td>
                            </tr>
                            <!-- ROW 20 -->
                            <tr class="hover:bg-gray-50 transition-colors" style="background-color: #f8fafc;">
                                <td>20</td>
                                <td class="font-semibold">SMW</td>
                                <td>1-2</td>
                                <td class="text-xs text-gray-600">Recommended response time: &le; 1-1.5 mins</td>
                                <td class="font-medium">1%</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-purple-600" style="color: #9333ea;">1%</td>
                            </tr>
                            <!-- ROW 21 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td>21</td>
                                <td class="font-semibold">HIW</td>
                                <td>2~3</td>
                                <td class="text-xs text-gray-600">Recommended response time: &le; 2 minutes</td>
                                <td class="font-medium">4%</td>
                                <td></td>
                                <td></td>
                                <td class="font-medium text-blue-600" style="color: #2563eb;">13%</td>
                                <td class="font-medium text-purple-600" style="color: #9333ea;">8%</td>
                            </tr>
                            <!-- ROW 22 -->
                            <tr class="hover:bg-gray-50 transition-colors" style="background-color: #f8fafc;">
                                <td>22</td>
                                <td class="font-semibold">WFD</td>
                                <td>3~4</td>
                                <td class="text-xs text-gray-600">2 minutes per question</td>
                                <td class="font-medium">5%</td>
                                <td></td>
                                <td class="font-medium text-orange-600" style="color: #ea580c;">23%</td>
                                <td></td>
                                <td class="font-medium text-purple-600" style="color: #9333ea;">13%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
"""

filepath = 'resources/views/assignments/pte-academic.blade.php'

with open(filepath, 'r') as f:
    file_content = f.read()

# Replace the existing Table Section
new_content = re.sub(r'<!-- Table Section -->.*</div>\n            </div>', html_table.strip(), file_content, flags=re.DOTALL)

with open(filepath, 'w') as f:
    f.write(new_content)

print('Updated PTE table colors successfully.')
