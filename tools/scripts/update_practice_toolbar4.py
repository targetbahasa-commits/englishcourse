import re

file_path = "resources/views/assignments/ielts/writing/practice_toolbar.blade.php"
with open(file_path, "r") as f:
    content = f.read()

# Replace padding and text size on desktop
# from: md:py-2 md:px-4 md:rounded-xl
# to: md:py-1.5 md:px-3 md:rounded-lg
content = content.replace('md:py-2 md:px-4 md:rounded-xl', 'md:py-1.5 md:px-3 md:rounded-lg')
content = content.replace('<span class="hidden md:inline text-sm">', '<span class="hidden md:inline text-xs">')

with open(file_path, "w") as f:
    f.write(content)

print("Updates applied.")
