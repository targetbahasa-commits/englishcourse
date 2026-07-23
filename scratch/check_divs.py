import re

with open('resources/views/brochure.blade.php', 'r') as f:
    lines = f.readlines()

div_count = 0
for i, line in enumerate(lines, 1):
    div_count += line.count('<div') - line.count('</div')
    if div_count < 0:
        print(f"Negative div count at line {i}: {div_count}")

print(f"Final div count: {div_count}")
