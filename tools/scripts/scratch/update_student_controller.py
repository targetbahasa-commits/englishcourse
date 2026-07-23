import re
with open('app/Http/Controllers/Admin/StudentController.php', 'r') as f:
    content = f.read()

content = re.sub(r'ToeflListeningScore::query\(\)', r"ToeflListeningScore::query()->where('is_reported', true)", content)
content = re.sub(r'ToeflMockupResult::query\(\)', r"ToeflMockupResult::query()->where('is_reported', true)", content)

with open('app/Http/Controllers/Admin/StudentController.php', 'w') as f:
    f.write(content)

print("Updated StudentController")
