import re

filepath = '/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/brochure.blade.php'

with open(filepath, 'r') as f:
    lines = f.readlines()

def count_divs(start_line, end_line):
    open_count = 0
    close_count = 0
    for i in range(start_line - 1, end_line):
        open_count += len(re.findall(r'<div[^>]*>', lines[i]))
        close_count += len(re.findall(r'</div>', lines[i]))
    return open_count, close_count

# Find IELTS block
ielts_start = 0
ielts_end = 0
toefl_start = 0
toefl_end = 0
pte_start = 0
pte_end = 0

for i, line in enumerate(lines):
    if "@case('ielts-academic-full-package')" in line:
        ielts_start = i + 1
    elif "@case('toefl-itp')" in line:
        toefl_start = i + 1
    elif "@case('pte-academic')" in line:
        pte_start = i + 1
    elif "@break" in line:
        if ielts_start > 0 and ielts_end == 0:
            ielts_end = i + 1
        elif toefl_start > 0 and toefl_end == 0:
            toefl_end = i + 1
        elif pte_start > 0 and pte_end == 0:
            pte_end = i + 1

print(f"IELTS: start={ielts_start}, end={ielts_end}")
ielts_open, ielts_close = count_divs(ielts_start, ielts_end)
print(f"IELTS Open: {ielts_open}, Close: {ielts_close}, Diff: {ielts_open - ielts_close}")

print(f"TOEFL: start={toefl_start}, end={toefl_end}")
toefl_open, toefl_close = count_divs(toefl_start, toefl_end)
print(f"TOEFL Open: {toefl_open}, Close: {toefl_close}, Diff: {toefl_open - toefl_close}")

print(f"PTE: start={pte_start}, end={pte_end}")
pte_open, pte_close = count_divs(pte_start, pte_end)
print(f"PTE Open: {pte_open}, Close: {pte_close}, Diff: {pte_open - pte_close}")

# Let's also check the wrapper
wrapper_start = 0
for i, line in enumerate(lines):
    if '<div class="grid grid-cols-1 lg:grid-cols-2 gap-10 max-w-6xl mx-auto">' in line:
        wrapper_start = i + 1
        break

print(f"Wrapper start: {wrapper_start}")

