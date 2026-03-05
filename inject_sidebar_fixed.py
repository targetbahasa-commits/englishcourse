import os
import glob
import re

base_dir = '/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/assignments'

def process_file(filepath):
    try:
        with open(filepath, 'r', encoding='utf-8') as f:
            content = f.read()
    except Exception as e:
        print(f"Error reading {filepath}: {e}")
        return

    # Avoid injecting multiple times
    if "@include('components.program-sidebar')" in content:
        print(f"Already injected in {filepath}")
        return

    # Find <body ...>
    body_pattern = re.compile(r'(<body[^>]*>)')
    match = body_pattern.search(content)

    if match:
        body_tag = match.group(1)
        insertion = "\n    @include('components.program-sidebar')"
        
        impersonation_pattern = re.compile(r'(@include\([\'"]components\.impersonation-banner[\'"]\))')
        imp_match = impersonation_pattern.search(content[match.end():match.end()+200])
        
        if imp_match:
            # We want to insert AFTER the impersonation banner
            insert_pos = match.end() + imp_match.end()
            new_content = content[:insert_pos] + insertion + content[insert_pos:]
        else:
            insert_pos = match.end()
            new_content = content[:insert_pos] + insertion + content[insert_pos:]

        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(new_content)
        print(f"Injected into {filepath}")

files_to_process = glob.glob(os.path.join(base_dir, 'grammar-writing', 'meeting*.blade.php'))
files_to_process += glob.glob(os.path.join(base_dir, 'ielts', 'mockup', '*.blade.php'))
files_to_process += glob.glob(os.path.join(base_dir, 'cambridge', '*.blade.php'))

for f in files_to_process:
    process_file(f)

print("Done injecting.")
