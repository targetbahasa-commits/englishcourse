import re

filepath = '/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/brochure.blade.php'

with open(filepath, 'r') as f:
    lines = f.readlines()

open_count = 0
close_count = 0
for i, line in enumerate(lines):
    open_count += len(re.findall(r'<div[^>]*>', line))
    close_count += len(re.findall(r'</div>', line))
    
print(f"Total open: {open_count}, Total close: {close_count}, Diff: {open_count - close_count}")

