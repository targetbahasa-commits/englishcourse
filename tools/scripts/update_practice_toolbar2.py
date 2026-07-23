import re

file_path = "resources/views/assignments/ielts/writing/practice_toolbar.blade.php"
with open(file_path, "r") as f:
    content = f.read()

# Replace block md:hidden with just empty or remove it so SVGs show on desktop too
content = content.replace('<svg class="w-5 h-5 block md:hidden"', '<svg class="w-5 h-5"')

with open(file_path, "w") as f:
    f.write(content)

print("Updates applied.")
