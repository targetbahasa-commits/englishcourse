import sys

file_path = "/Applications/MAMP/htdocs/TargetBahasaCourse/app/Application/IeltsWriting/BuildIeltsWritingAiPrompt.php"
with open(file_path, "r") as f:
    content = f.read()

target = "Use '\\\\n' for line breaks."

replacement = "You MUST wrap EVERY single paragraph with <p class=\\\"mb-4\\\"> and </p> tags to ensure proper spacing between paragraphs."

if target in content:
    with open(file_path, "w") as f:
        f.write(content.replace(target, replacement))
    print("Success1")
else:
    print("Target1 not found")

target2 = "    \"better_version\": \"Full Band 9 example essay...\""
replacement2 = "    \"better_version\": \"<p class=\\\"mb-4\\\">Full Band 9 example essay paragraph 1...</p><p class=\\\"mb-4\\\">Paragraph 2...</p>\""
with open(file_path, "r") as f:
    content2 = f.read()
if target2 in content2:
    with open(file_path, "w") as f:
        f.write(content2.replace(target2, replacement2))
    print("Success2")
else:
    print("Target2 not found")
