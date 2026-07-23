import re

file_path = "resources/views/assignments/ielts/writing/practice_toolbar.blade.php"
with open(file_path, "r") as f:
    content = f.read()

# Replace classes
content = content.replace('w-10 h-10 p-0 rounded-full justify-center', 'w-10 h-10 p-0 rounded-full md:w-auto md:h-auto md:py-2 md:px-4 md:rounded-xl md:gap-2 justify-center')

# Add text to buttons
buttons = [
    ("Tenses", r'(<button title="Tenses"[\s\S]*?</svg>)'),
    ("Tenses Chart", r'(<button title="Tenses Chart"[\s\S]*?</svg>)'),
    ("Linking Words", r'(<button title="Linking Words"[\s\S]*?</svg>)'),
    ("Dictionary", r'(<button title="Dictionary"[\s\S]*?</svg>)'),
    ("Irregular Verbs", r'(<button title="Irregular Verbs"[\s\S]*?</svg>)'),
    ("Lesson Explanation", r'(<button title="Lesson Explanation"[\s\S]*?</svg>)')
]

for title, pattern in buttons:
    match = re.search(pattern, content)
    if match and '<span class="hidden md:inline text-sm">' not in match.group(0):
        replacement = match.group(1) + f'\n            <span class="hidden md:inline text-sm">{title}</span>'
        content = content.replace(match.group(1), replacement)

with open(file_path, "w") as f:
    f.write(content)

print("Updates applied.")
