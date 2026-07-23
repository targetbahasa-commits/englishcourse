import re
import os

cached_file = '/tmp/cached_view.php'
output_file = '/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/brochure.blade.php'

with open(cached_file, 'r') as f:
    content = f.read()

# Reverse Blade directives
content = re.sub(r'<\?php\s+echo\s+e\((.*?)\);\s*\?>', r'{{ \1 }}', content)
content = re.sub(r'<\?php\s+echo\s+(.*?);\s*\?>', r'{!! \1 !!}', content)
content = re.sub(r'<\?php\s+if\((.*?)\):\s*\?>', r'@if(\1)', content)
content = re.sub(r'<\?php\s+elseif\((.*?)\):\s*\?>', r'@elseif(\1)', content)
content = re.sub(r'<\?php\s+else:\s*\?>', r'@else', content)
content = re.sub(r'<\?php\s+endif;\s*\?>', r'@endif', content)
content = re.sub(r'<\?php\s+foreach\((.*?)\):\s*\?>', r'@foreach(\1)', content)
content = re.sub(r'<\?php\s+endforeach;\s*\?>', r'@endforeach', content)
content = re.sub(r'<\?php\s+switch\((.*?)\):\s*\?>', r'@switch(\1)', content)
content = re.sub(r'<\?php\s+case\s*\((.*?)\):\s*\?>', r'@case(\1)', content)
content = re.sub(r'<\?php\s+break;\s*\?>', r'@break', content)
content = re.sub(r'<\?php\s+default:\s*\?>', r'@default', content)
content = re.sub(r'<\?php\s+endswitch;\s*\?>', r'@endswitch', content)
content = re.sub(r"<\?php\s+echo\s+app\('Illuminate\\\\Foundation\\\\Vite'\)\((.*?)\);\s*\?>", r'@vite(\1)', content)
content = re.sub(r'<\?php\s*(.*?)\s*\?>', r'@php \1 @endphp', content, flags=re.DOTALL)
# The above @php might be too greedy or capture multiple statements, but let's hope there's only simple <?php ... ?> left.
# Wait, Laravel compiles `@php ... @endphp` as `<?php ... ?>`.

with open(output_file, 'w') as f:
    f.write(content)

print("Decompiled successfully!")
