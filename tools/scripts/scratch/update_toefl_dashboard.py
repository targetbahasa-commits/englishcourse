import re

with open('resources/views/assignments/toefl-itp.blade.php', 'r') as f:
    content = f.read()

# Update the button text from Start Learning / Start Test to Kerjakan Ulang ↺
def text_repl(m):
    text = m.group(1)
    svg = m.group(2)
    path = m.group(3)
    return f"{{{{ !empty($isClassEnded) && Auth::user()->isStudent() ? 'Kerjakan Ulang ↺' : '{text}' }}}}\n                            @if(empty($isClassEnded) || !Auth::user()->isStudent())\n                            {svg}{path}</path></svg>\n                            @endif"

pattern_text = r'(Start Learning|Start Test|Take Test)\s*(<svg[^>]+>)\s*(<path[^>]+>)</path></svg>'
content = re.sub(pattern_text, text_repl, content)

# Change the background colors on hover to amber if class ended
def color_repl(m):
    color = m.group(1)
    weight1 = m.group(2)
    weight2 = m.group(3)
    return f'{{{{ !empty($isClassEnded) && Auth::user()->isStudent() ? \'bg-amber-500 hover:bg-amber-600\' : \'bg-{color}-{weight1} hover:bg-{color}-{weight2}\' }}}}'

pattern_color = r'bg-([a-z]+)-(\d+) hover:bg-\1-(\d+)'
content = re.sub(pattern_color, color_repl, content)

with open('resources/views/assignments/toefl-itp.blade.php', 'w') as f:
    f.write(content)

print("TOEFL UI updated.")
