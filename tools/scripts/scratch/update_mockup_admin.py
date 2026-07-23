import re
with open('app/Http/Controllers/Admin/ToeflMockupResultController.php', 'r') as f:
    content = f.read()

content = re.sub(r'\\App\\Models\\ToeflMockupResult::with', r"\\App\\Models\\ToeflMockupResult::where('is_reported', true)->with", content)
content = re.sub(r'\\App\\Models\\ToeflMockupResult::whereHas', r"\\App\\Models\\ToeflMockupResult::where('is_reported', true)->whereHas", content)
content = re.sub(r'ToeflMockupResult::with', r"ToeflMockupResult::where('is_reported', true)->with", content)

with open('app/Http/Controllers/Admin/ToeflMockupResultController.php', 'w') as f:
    f.write(content)

print("Updated ToeflMockupResultController")
