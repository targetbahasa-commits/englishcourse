import re

file_path = "resources/views/assignments/ielts/writing/practice_view.blade.php"
with open(file_path, "r") as f:
    content = f.read()

# Replace the promo preview link
# from: href="{{ route('promo.test.result', ['type' => $task == 1 ? 'writing_t1' : 'writing_t2', 'id' => $meeting->id, 'submission_id' => 'mock']) }}"
# to: href="{{ route('assignments.ielts.writing.evaluation_preview', ['task' => $task, 'id' => $meeting->id]) }}"

content = re.sub(r"href=\"\{\{ route\('promo\.test\.result', \['type' => \$task == 1 \? 'writing_t1' : 'writing_t2', 'id' => \$meeting->id, 'submission_id' => 'mock'\]\) \}\}(?:\?b=online)?\"", "href=\"{{ route('assignments.ielts.writing.evaluation_preview', ['task' => $task, 'id' => $meeting->id]) }}\"", content)

with open(file_path, "w") as f:
    f.write(content)

print("Preview link updated.")
