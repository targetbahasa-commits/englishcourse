import re

file_path = "routes/web.php"
with open(file_path, "r") as f:
    content = f.read()

# Replace evaluation-preview with writing-task{task}-evaluation
content = content.replace('/evaluation-preview', '/writing-task{task}-evaluation')

with open(file_path, "w") as f:
    f.write(content)

print("Route updated.")
