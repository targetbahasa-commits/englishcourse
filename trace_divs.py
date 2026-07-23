import re

filepath = '/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/brochure.blade.php'

with open(filepath, 'r') as f:
    lines = f.readlines()

depth = 0
for i, line in enumerate(lines):
    open_count = len(re.findall(r'<div[^>]*>', line))
    close_count = len(re.findall(r'</div>', line))
    depth += open_count - close_count
    
    # Just print lines where depth changes drastically or goes negative? 
    # Let's print out the depth at the end of each section.

print("Final depth:", depth)

# Let's track the depth starting from 0. If it ends at -1, then an extra </div> is somewhere.
# Since it's a blade template with @if, it's possible that the @if branches have different number of divs!
# Wait! Let's check @if and @else branches for mismatched divs.
