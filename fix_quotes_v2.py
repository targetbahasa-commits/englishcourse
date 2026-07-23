import re

with open("config/pte_listening_mcsa.php", "r") as f:
    text = f.read()

# We need to find all strings inside '...' and escape unescaped single quotes inside them.
# The format is typically:
# 'transcript' => '...',
# 'question' => '...',
# 'options' => [
#   '...',
#   '...',
# ],
# 'correct_answer' => '...',
# 'voice' => '...',

def fix_line(line):
    # Match key => 'value',
    m = re.match(r"^(\s*'[^']+'\s*=>\s*')(.*)(',\s*)$", line)
    if m:
        prefix, content, suffix = m.groups()
        # Fix content
        content = content.replace("\\'", "'").replace("'", "\\'")
        return prefix + content + suffix
    
    # Match 'value', inside options array
    m2 = re.match(r"^(\s*')(.*)(',\s*)$", line)
    if m2:
        prefix, content, suffix = m2.groups()
        content = content.replace("\\'", "'").replace("'", "\\'")
        return prefix + content + suffix
        
    return line

with open("config/pte_listening_mcsa.php", "r") as f:
    lines = f.readlines()

new_lines = [fix_line(l) for l in lines]

with open("config/pte_listening_mcsa.php", "w") as f:
    f.writelines(new_lines)
