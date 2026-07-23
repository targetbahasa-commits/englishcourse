import os
import re

models = [
    'app/Models/MeetingScore.php',
    'app/Models/ToeflListeningScore.php',
    'app/Models/ToeflReadingScore.php',
]

for file_path in models:
    if not os.path.exists(file_path):
        continue
        
    with open(file_path, 'r') as f:
        content = f.read()
        
    # Check if is_reported is already there
    if 'is_reported' not in content:
        # Add to fillable array. Look for protected $fillable = [
        content = re.sub(
            r'(protected \$fillable = \[)',
            r"\1\n        'is_reported',",
            content
        )
        
        with open(file_path, 'w') as f:
            f.write(content)

print("Updated fillable arrays.")
