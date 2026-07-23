import re

def update_file(file_path, default_part):
    with open(file_path, "r") as f:
        content = f.read()

    old_href_pattern = r"\{\{ route\('assignments\.ielts-academic\.speaking\.practice'\) \}\}\?topic=\{\{ isset\(\$topic\['slug'\]\) \? \$topic\['slug'\] : request\('topic'\) \}\}/result"
    new_href = f"{{{{ route('assignments.ielts.speaking.evaluation_preview', ['part' => $topic['part'] ?? {default_part}, 'id' => $topic['id']]) }}}}"

    new_content = re.sub(old_href_pattern, new_href, content)

    with open(file_path, "w") as f:
        f.write(new_content)

update_file("resources/views/assignments/ielts/speaking/practice.blade.php", 1)
update_file("resources/views/assignments/ielts/speaking/part2_practice.blade.php", 2)

print("Updated review buttons in practice views.")
