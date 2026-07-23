import sys
import re

html_table = """
            <!-- Table Section -->
            <div class="mt-12 bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
                <div class="p-6 text-center border-b border-gray-100">
                    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-800 tracking-tight uppercase">SKOR BREAKDOWN 2026</h2>
                </div>
                <div class="overflow-x-auto p-0">
                    <table class="w-full text-sm text-center border-collapse">
                        <thead>
                            <tr class="bg-[#2dd4bf] text-white">
                                <th colspan="10" class="py-3 px-4 font-bold text-base md:text-lg border-b border-[#14b8a6]">
                                    PTE Content Question Types & Score Information Table V5 (Official Release)
                                </th>
                            </tr>
                            <tr class="bg-[#2dd4bf] text-white font-medium text-xs md:text-sm">
                                <th class="py-2 px-2 border border-[#14b8a6]">Sequence</th>
                                <th colspan="2" class="py-2 px-2 border border-[#14b8a6]">Question Type</th>
                                <th class="py-2 px-2 border border-[#14b8a6]">Numbers</th>
                                <th class="py-2 px-2 border border-[#14b8a6]">Time for answering a question</th>
                                <th class="py-2 px-2 border border-[#14b8a6]">Overall</th>
                                <th class="py-2 px-2 border border-[#14b8a6]">Speaking</th>
                                <th class="py-2 px-2 border border-[#14b8a6]">Writing</th>
                                <th class="py-2 px-2 border border-[#14b8a6]">Reading</th>
                                <th class="py-2 px-2 border border-[#14b8a6]">Listening</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700 bg-white align-middle [&>tr>td]:border [&>tr>td]:border-gray-200 [&>tr>td]:py-2 [&>tr>td]:px-2">
                            <!-- ROW 1 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td>1</td>
                                <td>RA</td>
                                <td rowspan="9" class="font-semibold text-gray-800 bg-gray-50">Speaking &amp; Writing<br>(76~84mins)</td>
                                <td>6~7</td>
                                <td class="text-xs">Preparation time: 35s or 40s<br>Answer time: 40s</td>
                                <td>4%</td>
                                <td>9%</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <!-- ROW 2 -->
                            <tr class="hover:bg-gray-50 transition-colors bg-gray-50/30">
                                <td>2</td>
                                <td>RS</td>
                                <td>10~12</td>
                                <td class="text-xs">No preparation time<br>Answer time: 15s</td>
                                <td>7%</td>
                                <td>16%</td>
                                <td></td>
                                <td></td>
                                <td>17%</td>
                            </tr>
                            <!-- ROW 3 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td>3</td>
                                <td>DI</td>
                                <td>5~6</td>
                                <td class="text-xs">Preparation time: 25s<br>Answer time: 40s</td>
                                <td>15%</td>
                                <td>31%</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <!-- ROW 4 -->
                            <tr class="hover:bg-gray-50 transition-colors bg-gray-50/30">
                                <td>4</td>
                                <td>RL</td>
                                <td>2~3</td>
                                <td class="text-xs">Preparation time: 10s<br>Answer time: 40s</td>
                                <td>6%</td>
                                <td>13%</td>
                                <td></td>
                                <td></td>
                                <td>13%</td>
                            </tr>
                            <!-- ROW 5 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td>5</td>
                                <td>ASQ</td>
                                <td>5~6</td>
                                <td class="text-xs">No preparation time<br>Answer time: 10s</td>
                                <td>2%</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>4%</td>
                            </tr>
                            <!-- ROW 6 -->
                            <tr class="hover:bg-gray-50 transition-colors bg-gray-50/30">
                                <td>6</td>
                                <td>SGD</td>
                                <td>2~3</td>
                                <td class="text-xs">Preparation time: 10s<br>Answer time: 2min</td>
                                <td>9%</td>
                                <td>19%</td>
                                <td></td>
                                <td></td>
                                <td>20%</td>
                            </tr>
                            <!-- ROW 7 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td>7</td>
                                <td>RTS</td>
                                <td>2~3</td>
                                <td class="text-xs">Preparation time: 10s<br>Answer time: 40s</td>
                                <td>6%</td>
                                <td>13%</td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <!-- ROW 8 -->
                            <tr class="hover:bg-gray-50 transition-colors bg-gray-50/30">
                                <td>8</td>
                                <td>SWT</td>
                                <td>2</td>
                                <td class="text-xs">10 mins per question (timed individually)</td>
                                <td>7%</td>
                                <td></td>
                                <td>28%</td>
                                <td>23%</td>
                                <td></td>
                            </tr>
                            <!-- ROW 9 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td>9</td>
                                <td>WE</td>
                                <td>1</td>
                                <td class="text-xs">20 mins per question (timed individually)</td>
                                <td>7%</td>
                                <td></td>
                                <td>31%</td>
                                <td></td>
                                <td></td>
                            </tr>
                            <!-- ROW 10 -->
                            <tr class="hover:bg-gray-50 transition-colors bg-gray-50/30">
                                <td>10</td>
                                <td>FIB_Dropdown</td>
                                <td rowspan="5" class="font-semibold text-gray-800 bg-gray-50">Reading<br>(23~30mins)</td>
                                <td>5~6</td>
                                <td class="text-xs">Recommended response time: &le; 2 mins</td>
                                <td>7%</td>
                                <td></td>
                                <td></td>
                                <td>25%</td>
                                <td></td>
                            </tr>
                            <!-- ROW 11 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td>11</td>
                                <td>MCM_R</td>
                                <td>2~3</td>
                                <td class="text-xs">Recommended response time: &le; 1-1.5 mins</td>
                                <td>1%</td>
                                <td></td>
                                <td></td>
                                <td>5%</td>
                                <td></td>
                            </tr>
                            <!-- ROW 12 -->
                            <tr class="hover:bg-gray-50 transition-colors bg-gray-50/30">
                                <td>12</td>
                                <td>RO</td>
                                <td>2~3</td>
                                <td class="text-xs">Recommended response time: &le; 1.5-2 mins</td>
                                <td>3%</td>
                                <td></td>
                                <td></td>
                                <td>9%</td>
                                <td></td>
                            </tr>
                            <!-- ROW 13 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td>13</td>
                                <td>FIB_Drag and Drop</td>
                                <td>4~5</td>
                                <td class="text-xs">Recommended response time: &le; 2 mins</td>
                                <td>6%</td>
                                <td></td>
                                <td></td>
                                <td>20%</td>
                                <td></td>
                            </tr>
                            <!-- ROW 14 -->
                            <tr class="hover:bg-gray-50 transition-colors bg-gray-50/30">
                                <td>14</td>
                                <td>MCS_R</td>
                                <td>2~3</td>
                                <td class="text-xs">Recommended response time: &le; 1-1.5 mins</td>
                                <td>&lt;1%</td>
                                <td></td>
                                <td></td>
                                <td>3%</td>
                                <td></td>
                            </tr>
                            <!-- ROW 15 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td>15</td>
                                <td>SST</td>
                                <td rowspan="8" class="font-semibold text-gray-800 bg-gray-50">Listening<br>(31~39 mins)<br><br><span class="text-xs font-normal text-gray-500">&bull; SST is timed individually per question</span></td>
                                <td>1</td>
                                <td class="text-xs">Each question: 10 minutes (timed individually)</td>
                                <td>4%</td>
                                <td></td>
                                <td>18%</td>
                                <td></td>
                                <td>10%</td>
                            </tr>
                            <!-- ROW 16 -->
                            <tr class="hover:bg-gray-50 transition-colors bg-gray-50/30">
                                <td>16</td>
                                <td>MCM_L</td>
                                <td>2~3</td>
                                <td class="text-xs">Recommended response time: &le; 1-1.5 mins</td>
                                <td>1%</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>3%</td>
                            </tr>
                            <!-- ROW 17 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td>17</td>
                                <td>FIB_L</td>
                                <td>2~3</td>
                                <td class="text-xs">Recommended response time: &le; 2 mins</td>
                                <td>3%</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>8%</td>
                            </tr>
                            <!-- ROW 18 -->
                            <tr class="hover:bg-gray-50 transition-colors bg-gray-50/30">
                                <td>18</td>
                                <td>HCS</td>
                                <td>2~3</td>
                                <td class="text-xs">Recommended response time: &le; 1-1.5 mins</td>
                                <td>&lt;1%</td>
                                <td></td>
                                <td></td>
                                <td>3%</td>
                                <td>2%</td>
                            </tr>
                            <!-- ROW 19 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td>19</td>
                                <td>MCS_L</td>
                                <td>2~3</td>
                                <td class="text-xs">Recommended response time: &le; 1-1.5 mins</td>
                                <td>&lt;1%</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>2%</td>
                            </tr>
                            <!-- ROW 20 -->
                            <tr class="hover:bg-gray-50 transition-colors bg-gray-50/30">
                                <td>20</td>
                                <td>SMW</td>
                                <td>1-2</td>
                                <td class="text-xs">Recommended response time: &le; 1-1.5 mins</td>
                                <td>1%</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>1%</td>
                            </tr>
                            <!-- ROW 21 -->
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td>21</td>
                                <td>HIW</td>
                                <td>2~3</td>
                                <td class="text-xs">Recommended response time: &le; 2 minutes</td>
                                <td>4%</td>
                                <td></td>
                                <td></td>
                                <td>13%</td>
                                <td>8%</td>
                            </tr>
                            <!-- ROW 22 -->
                            <tr class="hover:bg-gray-50 transition-colors bg-gray-50/30">
                                <td>22</td>
                                <td>WFD</td>
                                <td>3~4</td>
                                <td class="text-xs">2 minutes per question</td>
                                <td>5%</td>
                                <td></td>
                                <td>23%</td>
                                <td></td>
                                <td>13%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
"""

filepath = 'resources/views/assignments/pte-academic.blade.php'

with open(filepath, 'r') as f:
    file_content = f.read()

# Insert the table right after the closing </div> of the sections grid.
# The sections grid ends right before </main>
# We can just substitute before </main>
new_content = re.sub(r'(\s*</main>)', html_table + r'\1', file_content)

with open(filepath, 'w') as f:
    f.write(new_content)

print('Injected PTE table successfully.')
