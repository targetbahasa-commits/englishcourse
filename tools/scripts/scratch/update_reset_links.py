import os
import re
import glob

views_dir = 'resources/views/assignments/grammar-writing'
files = glob.glob(f"{views_dir}/meeting*.blade.php")

for file_path in files:
    with open(file_path, 'r') as f:
        content = f.read()
    
    # We want to find the "Coba Lagi" link and replace it with a form.
    # It usually looks like:
    # <a href="{{ route('assignments.grammar-writing.meetingX') }}" class="block w-full py-4 bg-gray-500 text-white rounded-xl font-bold text-lg hover:bg-gray-600 transition-colors shadow-lg text-center">
    #     Coba Lagi
    # </a>
    # Or similar. Let's use a regex.
    
    pattern = r'<a\s+href="\{\{\s*route\(\'assignments\.grammar-writing\.meeting(\d+)\'\)\s*\}\}"\s+class="(.*?)">\s*Coba Lagi\s*<\/a>'
    
    def replacer(match):
        meeting_num = match.group(1)
        classes = match.group(2)
        # Note: sometimes classes has 'block' which is fine for button too, or maybe w-full
        return f'''<form method="POST" action="{{{{ route('assignments.grammar-writing.meeting{meeting_num}.reset') }}}}">
                    @csrf
                    <button type="submit" class="{classes}">
                        Coba Lagi
                    </button>
                </form>'''
    
    new_content = re.sub(pattern, replacer, content)
    
    if new_content != content:
        with open(file_path, 'w') as f:
            f.write(new_content)
        print(f"Updated {file_path}")

print("Done")
