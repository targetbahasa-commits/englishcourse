import re

with open("config/pte_listening_mcsa.php", "r") as f:
    lines = f.readlines()

for i, line in enumerate(lines):
    if "=> '" in line and line.strip().endswith("',"):
        # this is a string assignment like 'question' => '...',
        prefix, content = line.split("=> '", 1)
        content = content.rsplit("',", 1)[0]
        # unescape all first to avoid double escaping
        content = content.replace("\\'", "'")
        # now escape properly
        content = content.replace("'", "\\'")
        lines[i] = f"{prefix}=> '{content}',\n"
    elif line.strip().startswith("'") and line.strip().endswith("',"):
        # this is an array element like 'option',
        content = line.strip()[1:-2]
        content = content.replace("\\'", "'")
        content = content.replace("'", "\\'")
        # preserve leading whitespace
        leading_space = len(line) - len(line.lstrip())
        lines[i] = (" " * leading_space) + f"'{content}',\n"

with open("config/pte_listening_mcsa.php", "w") as f:
    f.writelines(lines)
