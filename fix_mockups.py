import re

with open('resources/views/assignments/ielts/mockup/listening-test.blade.php', 'r') as f:
    content = f.read()

content = re.sub(r'x-data="\{\s*step:\s*1\s*\}"(?!\s*x-init)', 'x-data="{ step: 1 }" x-init="$watch(\'step\', value => $dispatch(\'part-changed\', value))"', content)
content = re.sub(r'\{\{-- Admin Upload Modals --\}\}\s*', '', content)
content = re.sub(r'@if\([^{}]*Auth::[^{}]*\)\s*(?:\{\{--.*?--\}\}\s*)?<div id="uploadSrtModal".*?@endif\s*', '', content, flags=re.DOTALL)
content = re.sub(r'(?s)\s*const audio = document\.getElementById\(\'mainAudio\'\);.*?window\.toggleTranscriptDrawer = function\(\).*?\}[\n\r;]*', '', content)

with open('resources/views/assignments/ielts/mockup/listening-test.blade.php', 'w') as f:
    f.write(content)

print("done")
