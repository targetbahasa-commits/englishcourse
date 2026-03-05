import os
import glob
import re

base_dir = '/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/assignments'

def process_file(filepath):
    with open(filepath, 'r', encoding='utf-8') as f:
        content = f.read()

    # Avoid injecting multiple times
    if "@include('components.program-sidebar')" in content:
        return

    # Find <body ...>
    body_pattern = re.compile(r'(<body[^>]*>)')
    match = body_pattern.search(content)

    if match:
        body_tag = match.group(1)
        # Inject right after body tag and impersonation banner if it exists
        insertion = "\n    @include('components.program-sidebar')"
        
        # Determine if we should put it after impersonation banner
        impersonation_pattern = re.compile(r'(@include\([\'"]components\.impersonation-banner[\'"]\))')
        imp_match = impersonation_pattern.search(content[match.end():match.end()+200])
        
        if imp_match:
            # Insert after the impersonation banner
            full_match_text = body_tag + content[match.end():match.end()+imp_match.end()]
            new_content = content[:match.start()] + full_match_text + insertion + content[match.start() + len(full_match_text):]
        else:
            new_content = content.replace(body_tag, body_tag + insertion)

        with open(filepath, 'w', encoding='utf-8') as f:
            f.write(new_content)
        print(f"Injected into {filepath}")

# Find all blade files under grammar-writing and ielts/mockup
files_to_process = glob.glob(os.path.join(base_dir, 'grammar-writing', 'meeting*.blade.php'))
files_to_process += glob.glob(os.path.join(base_dir, 'ielts', 'mockup', '*.blade.php'))
# Try to find cambridge files if any
cambridge_files = glob.glob(os.path.join(base_dir, 'cambridge', '*.blade.php'))
if cambridge_files:
    files_to_process += cambridge_files

for f in files_to_process:
    process_file(f)

print("Done injecting.")
