import re

filepath = '/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/brochure.blade.php'

with open(filepath, 'r') as f:
    content = f.read()

# The style string to replace
old_style = 'margin-top: 0; margin-left: -8px; margin-right: -8px;'
new_content = content.replace(old_style, '')

# Also remove it if it has extra spaces
new_content = re.sub(r'margin-top:\s*0;\s*margin-left:\s*-8px;\s*margin-right:\s*-8px;?', '', new_content)

with open(filepath, 'w') as f:
    f.write(new_content)

print("Restored mt-48 by removing inline margin overrides.")
