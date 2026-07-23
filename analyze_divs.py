import re

filepath = '/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/brochure.blade.php'

with open(filepath, 'r') as f:
    lines = f.readlines()

def get_balance(start, end):
    o = 0
    c = 0
    for i in range(start, end):
        o += len(re.findall(r'<div[^>]*>', lines[i]))
        c += len(re.findall(r'</div>', lines[i]))
    return o - c

print("Lines 1-360:", get_balance(0, 360))
print("Lines 360-785 (IELTS + TOEFL):", get_balance(360, 785))
print("Lines 785-end:", get_balance(785, len(lines)))

# Let's break it down further.
boundaries = [0, 360, 580, 785, 990, 1195, 1405, 1590, len(lines)]
for i in range(len(boundaries)-1):
    start = boundaries[i]
    end = boundaries[i+1]
    print(f"Lines {start}-{end}: {get_balance(start, end)}")

