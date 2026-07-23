import re

# 1. Fix routes/web.php
file_path = "routes/web.php"
with open(file_path, "r") as f:
    content = f.read()

content = content.replace('{task}-evaluation', '{task_id}-evaluation')

with open(file_path, "w") as f:
    f.write(content)

# 2. Fix IeltsWritingController.php
file_path = "app/Http/Controllers/IeltsWritingController.php"
with open(file_path, "r") as f:
    content = f.read()

content = content.replace('public function evaluationPreview($task, $id)', 'public function evaluationPreview($task, $id, $task_id = null)')

with open(file_path, "w") as f:
    f.write(content)

# 3. Fix practice_view.blade.php
file_path = "resources/views/assignments/ielts/writing/practice_view.blade.php"
with open(file_path, "r") as f:
    content = f.read()

content = content.replace("'id' => $meeting->id])", "'id' => $meeting->id, 'task_id' => $task])")

with open(file_path, "w") as f:
    f.write(content)

print("Fixed route and controller.")
