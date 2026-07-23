file_path = "resources/views/assignments/ielts/writing/practice_toolbar.blade.php"
with open(file_path, "r") as f:
    lines = f.readlines()

for idx in [75, 113, 473, 527, 743, 1965]:
    start = max(0, idx - 1)
    end = min(len(lines), idx + 5)
    print(f"--- Line {idx} ---")
    print("".join(lines[start:end]))
