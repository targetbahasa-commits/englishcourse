import re

file_path = "resources/views/assignments/ielts/writing/evaluation_preview.blade.php"
with open(file_path, "r") as f:
    content = f.read()

content = content.replace('<x-app-layout>', "@extends('layouts.admin')\n@section('content')")
content = content.replace('</x-app-layout>', "@endsection")

# Remove CTA banner (the blue box with text "Ingin mengerjakan soal writing lainnya?")
cta_pattern = r'<!-- CTA Banner -->[\s\S]*?(?=</div>\s*</div>\s*</div>\s*<!-- Closes Right Column -->)'
if not re.search(cta_pattern, content):
    # Try another pattern just in case "<!-- CTA Banner -->" doesn't exist
    cta_pattern = r'<div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden mt-6">[\s\S]*?</a>\s*</div>'

content = re.sub(cta_pattern, '', content)

with open(file_path, "w") as f:
    f.write(content)

print("Cleaned up evaluation preview view.")
