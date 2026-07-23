import os

base_dir = '/Applications/MAMP/htdocs/TargetBahasaCourse/resources/views/assignments/pte-academic'
modified_files = []

for root, dirs, files in os.walk(base_dir):
    for file in files:
        if file.endswith('.blade.php'):
            filepath = os.path.join(root, file)
            with open(filepath, 'r', encoding='utf-8') as f:
                lines = f.readlines()
            
            new_lines = [line for line in lines if 'assignments.ielts.writing.practice_toolbar' not in line]
            
            if len(new_lines) != len(lines):
                with open(filepath, 'w', encoding='utf-8') as f:
                    f.writelines(new_lines)
                rel_path = os.path.relpath(filepath, '/Applications/MAMP/htdocs/TargetBahasaCourse')
                modified_files.append(rel_path)
                print(f"Removed practice_toolbar from: {rel_path}")

print("\nTotal files modified:", len(modified_files))

with open('/Applications/MAMP/htdocs/TargetBahasaCourse/changed_files.txt', 'w', encoding='utf-8') as f:
    f.write('\n'.join(modified_files))

print("Updated changed_files.txt with modified files.")
