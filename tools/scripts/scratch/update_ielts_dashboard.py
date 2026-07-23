import re

with open('resources/views/ielts/writing/index.blade.php', 'r') as f:
    content = f.read()

# 1. Add onclick handler
pattern_a = r'(<a href="\{\{ route\(\'assignments\.ielts-academic[^"]+\'\) \}\}")( class="group relative bg-white)'
repl_a = r'\1 onclick="{{ !empty($isClassEnded) && Auth::user()->isStudent() ? \"Object.keys(localStorage).forEach(k => { if(k.startsWith(\'ielts\')) localStorage.removeItem(k); });\" : \"\" }}"\2'
content = re.sub(pattern_a, repl_a, content)

# 2. Update colors
def color_repl(m):
    color = m.group(1)
    weight1 = m.group(2)
    weight2 = m.group(3)
    return f'{{{{ !empty($isClassEnded) && Auth::user()->isStudent() ? \'bg-amber-500 hover:bg-amber-600\' : \'bg-{color}-{weight1} hover:bg-{color}-{weight2}\' }}}}'

pattern_color = r'bg-([a-z]+)-(\d+) hover:bg-\1-(\d+)'
content = re.sub(pattern_color, color_repl, content)

# 3. Update text (Start Learning, Start Practice, Start Test) and add @if @endif around svg
def text_repl(m):
    text = m.group(1)
    svg = m.group(2)
    path = m.group(3)
    return f"{{{{ !empty($isClassEnded) && Auth::user()->isStudent() ? 'Kerjakan Ulang ↺' : '{text}' }}}}\n                            @if(empty($isClassEnded) || !Auth::user()->isStudent())\n                            {svg}{path}</path></svg>\n                            @endif"

pattern_text = r'(Start Learning|Start Practice|Start Test)\s*(<svg[^>]+>)\s*(<path[^>]+>)</path></svg>'
content = re.sub(pattern_text, text_repl, content)

with open('resources/views/ielts/writing/index.blade.php', 'w') as f:
    f.write(content)

print("Fixed update done.")
